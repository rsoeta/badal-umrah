<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftaranModel;
use App\Models\PengaturanModel;
use App\Libraries\SertifikatGenerator;

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

        $uuid = basename($pendaftaran['uuid']);
        $files = [
            FCPATH . 'storage/certificates/' . $uuid . '.jpg',
            FCPATH . 'storage/certificates/' . $uuid . '.pdf',
        ];
        $failedFiles = [];
        foreach ($files as $file) {
            if (is_file($file) && !unlink($file)) {
                $failedFiles[] = basename($file);
                log_message('error', 'Failed to remove certificate file after permanent deletion: {file}', ['file' => $file]);
            }
        }

        $result = ['status' => 'success', 'message' => 'Pendaftaran dihapus permanen.'];
        if ($failedFiles !== []) {
            $result['warning'] = 'Data terhapus, tetapi berkas berikut gagal dihapus: ' . implode(', ', $failedFiles);
        }

        return $this->response->setJSON($result);
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

        (new SertifikatGenerator())->generate(
            $nama_pelaksana,
            $jamaah['nama_diumrahkan'],
            $tanggal_miqat,
            $tanggal_cetak_masehi,
            $tanggal_cetak_hijriah,
            $file_ttd,
            $outputJpg,
            $outputPdf
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

        // Ambil data username untuk ditampilkan di form (password jangan pernah dikirim ke view)
        $data['admin_username'] = $pengaturanModel->getSetting('admin_username') ?? 'admin-badal';

        return view('admin_pengaturan', $data);
    }

    public function simpanPengaturan()
    {
        $pengaturanModel = new PengaturanModel();

        $settings = [
            'list_mutawwif'  => $this->request->getPost('list_mutawwif'),
            'admin_username' => $this->request->getPost('admin_username')
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
