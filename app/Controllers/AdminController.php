<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftaranModel;
use App\Models\PengaturanModel;
use App\Models\VideoDokumentasiModel;
use App\Libraries\SertifikatGenerator;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class AdminController extends Controller
{
    public function index()
    {
        $pendaftaranModel = new PendaftaranModel();
        $pengaturanModel  = new PengaturanModel();

        $data['pendaftar'] = $pendaftaranModel->orderBy('created_at', 'DESC')->findAll();
        $data['jumlah_sampah'] = (new PendaftaranModel())->onlyDeleted()->countAllResults();

        // Ambil data Mutawwif, pecah berdasarkan baris baru (enter) menjadi array
        $list_mutawwif_raw = $pengaturanModel->getSetting('list_mutawwif') ?? "Ust. Ahmad Fadil|ttd-ahmad.png\nUst. Azis Rustandi|ttd-azis.png";
        $data['list_mutawwif'] = array_filter(explode("\n", str_replace("\r", "", $list_mutawwif_raw)));
        $data['koreksi_hijriah'] = (int) ($pengaturanModel->getSetting('koreksi_hijriah') ?? 0);

        return view('admin_dashboard', $data);
    }

    public function sampah()
    {
        $data['pendaftar'] = (new PendaftaranModel())
            ->onlyDeleted()
            ->orderBy('deleted_at', 'DESC')
            ->findAll();

        return view('admin_trash', $data);
    }

    public function hapusPendaftaran(int $id)
    {
        $pendaftaranModel = new PendaftaranModel();
        if (!$pendaftaranModel->find($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data pendaftaran tidak ditemukan.']);
        }

        if (!$pendaftaranModel->delete($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data gagal dipindahkan ke sampah.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pendaftaran dipindahkan ke sampah.']);
    }

    public function restorePendaftaran(int $id)
    {
        $pendaftaranModel = new PendaftaranModel();
        if (!$pendaftaranModel->onlyDeleted()->find($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data di sampah tidak ditemukan.']);
        }

        if (!$pendaftaranModel->update($id, ['deleted_at' => null])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data gagal dipulihkan.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pendaftaran berhasil dipulihkan.']);
    }

    public function hapusPermanen(int $id)
    {
        $pendaftaranModel = new PendaftaranModel();
        $pendaftaran = $pendaftaranModel->onlyDeleted()->find($id);
        if (!$pendaftaran) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data di sampah tidak ditemukan.']);
        }

        if (!$pendaftaranModel->delete($id, true)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data gagal dihapus permanen.']);
        }

        $videoModel = new VideoDokumentasiModel();
        $videos = $videoModel->where('pendaftaran_id', $id)->findAll();
        $uuid = basename($pendaftaran['uuid']);
        $files = [
            FCPATH . 'storage/certificates/' . $uuid . '.jpg',
            FCPATH . 'storage/certificates/' . $uuid . '.pdf',
        ];
        if (! empty($pendaftaran['foto_jamaah'])) {
            $files[] = WRITEPATH . 'uploads/pendaftaran-images/' . basename($pendaftaran['foto_jamaah']);
        }
        $failedFiles = [];
        foreach ($files as $file) {
            if (is_file($file) && !unlink($file)) {
                $failedFiles[] = basename($file);
                log_message('error', 'Failed to remove certificate file after permanent deletion: {file}', ['file' => $file]);
            }
        }
        foreach ($videos as $video) {
            $videoPath = WRITEPATH . 'uploads/videos/' . basename($video['file_name']);
            if (is_file($videoPath) && ! unlink($videoPath)) {
                $failedFiles[] = $video['original_name'];
                log_message('error', 'Failed to remove archived umrah video after permanent deletion: {file}', ['file' => $videoPath]);
                continue;
            }

            if (! $videoModel->delete($video['id'])) {
                $failedFiles[] = $video['original_name'] . ' (metadata)';
                log_message('error', 'Failed to remove archived umrah video metadata: {videoId}', ['videoId' => $video['id']]);
            }
        }

        $result = ['status' => 'success', 'message' => 'Pendaftaran dihapus permanen.'];
        if ($failedFiles !== []) {
            $result['warning'] = 'Data terhapus, tetapi berkas berikut gagal dihapus: ' . implode(', ', $failedFiles);
        }

        return $this->response->setJSON($result);
    }

    public function daftarVideo(int $id)
    {
        if (! (new PendaftaranModel())->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data pendaftaran tidak ditemukan.',
            ]);
        }

        $videos = (new VideoDokumentasiModel())
            ->where('pendaftaran_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $items = array_map(static function (array $video) use ($id): array {
            return [
                'id'            => (int) $video['id'],
                'original_name' => $video['original_name'],
                'file_size'     => (int) $video['file_size'],
                'created_at'    => $video['created_at'],
                'download_url'  => base_url('admin/pendaftaran/' . $id . '/videos/' . $video['id'] . '/download'),
            ];
        }, $videos);

        return $this->response->setJSON(['status' => 'success', 'videos' => $items]);
    }

    public function unggahVideo(int $id)
    {
        if (! (new PendaftaranModel())->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data pendaftaran tidak ditemukan.',
            ]);
        }

        $files = $this->request->getFileMultiple('videos') ?? [];
        $files = array_values(array_filter($files, static fn ($file): bool => $file->getError() !== UPLOAD_ERR_NO_FILE));
        if ($files === []) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => 'Pilih setidaknya satu video untuk diarsipkan.',
            ]);
        }

        $allowedTypes = [
            'video/mp4'       => 'mp4',
            'video/webm'      => 'webm',
            'video/quicktime' => 'mov',
        ];
        $maxFileSize = 500 * 1024 * 1024;
        $validatedFiles = [];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            log_message('error', 'Unable to initialize video MIME type validation.');

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Validasi video tidak dapat dijalankan saat ini.',
            ]);
        }

        foreach ($files as $file) {
            if (! $file->isValid()) {
                finfo_close($finfo);

                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => $file->getErrorString(),
                ]);
            }

            if ($file->getSize() > $maxFileSize) {
                finfo_close($finfo);

                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Ukuran setiap video maksimal 500 MB.',
                ]);
            }

            $mimeType = finfo_file($finfo, $file->getTempName());
            if (! isset($allowedTypes[$mimeType])) {
                finfo_close($finfo);

                return $this->response->setStatusCode(422)->setJSON([
                    'status'  => 'error',
                    'message' => 'Format video harus MP4, WEBM, atau MOV.',
                ]);
            }

            $originalName = basename(str_replace('\\', '/', $file->getClientName()));
            $originalName = preg_replace('/[\x00-\x1F\x7F]/', '', $originalName) ?: 'video.' . $allowedTypes[$mimeType];
            $validatedFiles[] = [
                'file'          => $file,
                'mime_type'     => $mimeType,
                'extension'     => $allowedTypes[$mimeType],
                'original_name' => mb_substr($originalName, 0, 255),
                'file_size'     => $file->getSize(),
            ];
        }
        finfo_close($finfo);

        $uploadDirectory = WRITEPATH . 'uploads/videos';
        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0750, true) && ! is_dir($uploadDirectory)) {
            log_message('error', 'Failed to create video archive directory: {directory}', ['directory' => $uploadDirectory]);

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Folder arsip video gagal disiapkan.',
            ]);
        }

        $videoModel = new VideoDokumentasiModel();
        $savedFiles = [];
        $savedIds = [];
        foreach ($validatedFiles as $validatedFile) {
            $storedName = bin2hex(random_bytes(16)) . '.' . $validatedFile['extension'];
            $storedPath = $uploadDirectory . DIRECTORY_SEPARATOR . $storedName;
            $savedFiles[] = $storedPath;

            try {
                $validatedFile['file']->move($uploadDirectory, $storedName);
            } catch (HTTPException $exception) {
                log_message('error', 'Failed to move uploaded umrah video: {error}', ['error' => $exception->getMessage()]);
                $this->rollbackVideoUploads($videoModel, $savedFiles, $savedIds);

                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 'error',
                    'message' => 'Video gagal disimpan. Silakan coba kembali.',
                ]);
            }

            $videoId = $videoModel->insert([
                'pendaftaran_id' => $id,
                'file_name'      => $storedName,
                'original_name'  => $validatedFile['original_name'],
                'mime_type'      => $validatedFile['mime_type'],
                'file_size'      => $validatedFile['file_size'],
                'created_at'     => date('Y-m-d H:i:s'),
            ]);

            if ($videoId === false) {
                log_message('error', 'Failed to save uploaded umrah video metadata for registration {registrationId}.', ['registrationId' => $id]);
                $this->rollbackVideoUploads($videoModel, $savedFiles, $savedIds);

                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 'error',
                    'message' => 'Informasi arsip video gagal disimpan.',
                ]);
            }

            $savedIds[] = $videoId;
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => count($savedFiles) . ' video berhasil diarsipkan.',
        ]);
    }

    public function unduhVideo(int $id, int $videoId)
    {
        if (! (new PendaftaranModel())->find($id)) {
            return $this->response->setStatusCode(404)->setBody('Data pendaftaran tidak ditemukan.');
        }

        $video = (new VideoDokumentasiModel())
            ->where('pendaftaran_id', $id)
            ->find($videoId);
        if (! $video) {
            return $this->response->setStatusCode(404)->setBody('Video tidak ditemukan.');
        }

        $videoPath = WRITEPATH . 'uploads/videos/' . basename($video['file_name']);
        if (! is_file($videoPath)) {
            return $this->response->setStatusCode(404)->setBody('Berkas video tidak ditemukan.');
        }

        return $this->response
            ->download($videoPath, null)
            ->setFileName(basename($video['original_name']));
    }

    public function hapusVideo(int $id, int $videoId)
    {
        if (! (new PendaftaranModel())->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data pendaftaran tidak ditemukan.',
            ]);
        }

        $videoModel = new VideoDokumentasiModel();
        $video = $videoModel->where('pendaftaran_id', $id)->find($videoId);
        if (! $video) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Video tidak ditemukan.',
            ]);
        }

        $videoPath = WRITEPATH . 'uploads/videos/' . basename($video['file_name']);
        if (is_file($videoPath) && ! unlink($videoPath)) {
            log_message('error', 'Failed to remove archived umrah video: {file}', ['file' => $videoPath]);

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Video gagal dihapus dari penyimpanan.',
            ]);
        }

        if (! $videoModel->delete($videoId)) {
            log_message('error', 'Failed to remove archived umrah video metadata: {videoId}', ['videoId' => $videoId]);

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Data arsip video gagal dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Video berhasil dihapus.',
        ]);
    }

    /**
     * Removes files and metadata created by an incomplete multi-video upload.
     *
     * @param list<string> $files
     * @param list<int|string> $ids
     */
    private function rollbackVideoUploads(VideoDokumentasiModel $videoModel, array $files, array $ids): void
    {
        foreach ($ids as $id) {
            if (! $videoModel->delete($id)) {
                log_message('error', 'Failed to roll back video metadata: {videoId}', ['videoId' => $id]);
            }
        }

        foreach ($files as $file) {
            if (is_file($file) && ! unlink($file)) {
                log_message('error', 'Failed to roll back uploaded video file: {file}', ['file' => $file]);
            }
        }
    }

    public function prosesSertifikat()
    {
        $pendaftaranModel = new PendaftaranModel();

        $id_pendaftaran   = $this->request->getPost('id_pendaftaran');

        $jamaah = $pendaftaranModel->find($id_pendaftaran);
        if (!$jamaah) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan!']);
        }

        $pelaksana_data = explode('|', $this->request->getPost('pelaksana_data'));
        $nama_pelaksana = $pelaksana_data[0];
        $file_ttd       = $pelaksana_data[1] ?? '';

        $tgl_miqat_input = $this->request->getPost('tanggal_miqat');
        $tgl_cetak_input = $this->request->getPost('tanggal_cetak');
        $koreksi_hijriah = (int) $this->request->getPost('koreksi_hijriah');

        $tanggal_miqat = $this->formatMasehi($tgl_miqat_input) . ' M / ' . $this->gregorianToHijri($tgl_miqat_input, $koreksi_hijriah) . ' H';
        $tanggal_cetak_masehi = $this->formatMasehi($tgl_cetak_input);
        $tanggal_cetak_hijriah = $this->gregorianToHijri($tgl_cetak_input, $koreksi_hijriah);

        // MENGGUNAKAN UUID ASLI DARI DATABASE (Bukan random lagi)
        $uuid = $jamaah['uuid'];
        $outputJpg = FCPATH . 'storage/certificates/' . $uuid . '.jpg';
        $outputPdf = FCPATH . 'storage/certificates/' . $uuid . '.pdf';
        $fotoJamaahPath = ! empty($jamaah['foto_jamaah'])
            ? WRITEPATH . 'uploads/pendaftaran-images/' . basename($jamaah['foto_jamaah'])
            : null;

        (new SertifikatGenerator())->generate(
            $nama_pelaksana,
            $jamaah['nama_diumrahkan'],
            $tanggal_miqat,
            $tanggal_cetak_masehi,
            $tanggal_cetak_hijriah,
            $file_ttd,
            $outputJpg,
            $outputPdf,
            $fotoJamaahPath
        );

        // 5. UPDATE DATABASE (Tandai Selesai)
        $pendaftaranModel->update($id_pendaftaran, [
            'nama_pelaksana'     => $nama_pelaksana,
            'file_ttd_pelaksana' => $file_ttd,
            'tanggal_miqat'      => $tgl_miqat_input,
            'tanggal_cetak'      => $tgl_cetak_input,
            'status'             => 'selesai'
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Sertifikat berhasil di-generate & data diperbarui!',
            'url_jpg'  => base_url('storage/certificates/' . $uuid . '.jpg'),
            'url_pdf'  => base_url('storage/certificates/' . $uuid . '.pdf')
        ]);
    }

    // --- Helper Konversi Tanggal ---
    private function formatMasehi($date)
    {
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $time = strtotime($date);
        return date('j', $time) . ' ' . $bulan[date('n', $time)] . ' ' . date('Y', $time);
    }

    private function gregorianToHijri($date, $offset = 0)
    {
        $time = strtotime($date) + ($offset * 86400);
        $d = date('j', $time);
        $m = date('n', $time);
        $y = date('Y', $time);

        if (($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14))) {
            $jd = (int)((1461 * ($y + 4800 + (int)(($m - 14) / 12))) / 4) + (int)((367 * ($m - 2 - 12 * ((int)(($m - 14) / 12)))) / 12) - (int)((3 * ((int)(($y + 4900 + (int)(($m - 14) / 12)) / 100))) / 4) + $d - 32075;
        } else {
            $jd = 367 * $y - (int)((7 * ($y + 5001 + (int)(($m - 9) / 7))) / 4) + (int)((275 * $m) / 9) + $d + 1729777;
        }

        $l = $jd - 1948440 + 10632;
        $n = (int)(($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $j = ((int)((10985 - $l) / 5316)) * ((int)((50 * $l) / 17719)) + ((int)($l / 5670)) * ((int)((43 * $l) / 15238));
        $l = $l - ((int)((30 - $j) / 15)) * ((int)((17719 * $j) / 50)) - ((int)($j / 16)) * ((int)((15238 * $j) / 43)) + 29;

        $m_hijri = (int)((24 * $l) / 709);
        $d_hijri = $l - (int)((709 * $m_hijri) / 24);
        $y_hijri = 30 * $n + $j - 30;
        $bulan_hijri = ['Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir', 'Jumadil Awal', 'Jumadil Akhir', 'Rajab', "Sya'ban", 'Ramadhan', 'Syawal', 'Dzulqa\'dah', 'Dzulhijjah'];

        return $d_hijri . ' ' . $bulan_hijri[$m_hijri - 1] . ' ' . $y_hijri;
    }

    public function pengaturan()
    {
        $pengaturanModel = new PengaturanModel();

        $data['list_mutawwif'] = $pengaturanModel->getSetting('list_mutawwif') ?? "Ust. Ahmad Fadil|ttd-ahmad.png\nUst. Azis Rustandi|ttd-azis.png";
        $data['koreksi_hijriah'] = (int) ($pengaturanModel->getSetting('koreksi_hijriah') ?? 0);

        // Ambil data username untuk ditampilkan di form (password jangan pernah dikirim ke view)
        $data['admin_username'] = $pengaturanModel->getSetting('admin_username') ?? 'admin-badal';

        return view('admin_pengaturan', $data);
    }

    public function simpanPengaturan()
    {
        $pengaturanModel = new PengaturanModel();

        if (! $this->validate([
            'koreksi_hijriah' => 'permit_empty|integer',
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => implode(' ', $this->validator->getErrors()),
            ]);
        }

        $settings = [
            'list_mutawwif'  => $this->request->getPost('list_mutawwif'),
            'admin_username' => $this->request->getPost('admin_username'),
            'koreksi_hijriah' => (string) ((int) ($this->request->getPost('koreksi_hijriah') ?? 0)),
        ];

        // Khusus untuk password, JIKA diisi baru kita update & enkripsi
        $new_password = $this->request->getPost('admin_password');
        if (!empty($new_password)) {
            $settings['admin_password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        foreach ($settings as $key => $val) {
            $exist = $pengaturanModel->where('setting_key', $key)->first();
            if ($exist) {
                $pengaturanModel->update($exist['id'], ['setting_value' => $val]);
            } else {
                $pengaturanModel->insert(['setting_key' => $key, 'setting_value' => $val]);
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pengaturan & Kredensial berhasil diperbarui!']);
    }
}
