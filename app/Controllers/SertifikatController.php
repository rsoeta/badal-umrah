<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\SertifikatGenerator;
use App\Models\PendaftaranModel;
use App\Models\VideoDokumentasiModel;

class SertifikatController extends Controller
{
    public function index()
    {
        return view('sertifikat_form');
    }

    public function generate()
    {
        // 1. Ambil data dari form (Frontend)
        // Memecah "Nama Pelaksana|file_ttd.png" menjadi 2 variabel terpisah
        $pelaksana_data = explode('|', $this->request->getPost('pelaksana_data'));
        $nama_pelaksana = $pelaksana_data[0];
        $file_ttd       = $pelaksana_data[1] ?? '';

        $nama_diumrahkan = $this->request->getPost('nama_diumrahkan');
        $fotoJamaah = $this->request->getFile('foto_jamaah');
        $fotoJamaahPath = null;

        if ($fotoJamaah !== null && $fotoJamaah->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $this->validate([
                'foto_jamaah' => 'uploaded[foto_jamaah]|is_image[foto_jamaah]|mime_in[foto_jamaah,image/jpeg,image/png,image/webp]|max_size[foto_jamaah,5120]',
            ])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => implode(' ', $this->validator->getErrors()),
                ]);
            }

            $fotoJamaahPath = $fotoJamaah->getTempName();
        }

        // Data Tanggal & Koreksi Hijriah
        $tgl_miqat_input = $this->request->getPost('tanggal_miqat');
        $tgl_cetak_input = $this->request->getPost('tanggal_cetak');
        $koreksi_hijriah = (int) $this->request->getPost('koreksi_hijriah');

        // Proses format tanggal Masehi & Hijriah
        $tanggal_miqat = $this->formatMasehi($tgl_miqat_input) . ' M / ' . $this->gregorianToHijri($tgl_miqat_input, $koreksi_hijriah) . ' H';
        $tanggal_cetak_masehi = $this->formatMasehi($tgl_cetak_input);
        $tanggal_cetak_hijriah = $this->gregorianToHijri($tgl_cetak_input, $koreksi_hijriah);

        // Nomor Registrasi (Format: RCP-Tahun-6KarakterAcak)
        $nomorRegistrasi = trim((string) $this->request->getPost('nomor_registrasi'));
        if ($nomorRegistrasi === '') {
            $nomorRegistrasi = 'RCP-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        }

        // UUID untuk nama file rahasia
        $uuid = bin2hex(random_bytes(8));

        $outputJpg    = FCPATH . 'storage/certificates/' . $uuid . '.jpg';
        $outputPdf    = FCPATH . 'storage/certificates/' . $uuid . '.pdf';

        (new SertifikatGenerator())->generate(
            $nama_pelaksana,
            $nama_diumrahkan,
            $tanggal_miqat,
            $tanggal_cetak_masehi,
            $tanggal_cetak_hijriah,
            $file_ttd,
            $outputJpg,
            $outputPdf,
            $fotoJamaahPath,
            $nomorRegistrasi
        );

        // 5. Kembalikan Response ke Frontend
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Sertifikat berhasil dibuat!',
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
        $time = strtotime($date) + ($offset * 86400); // Menambahkan/mengurangi selisih hari

        $d = date('j', $time);
        $m = date('n', $time);
        $y = date('Y', $time);

        if (($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14))) {
            $jd = (int)((1461 * ($y + 4800 + (int)(($m - 14) / 12))) / 4) +
                (int)((367 * ($m - 2 - 12 * ((int)(($m - 14) / 12)))) / 12) -
                (int)((3 * ((int)(($y + 4900 + (int)(($m - 14) / 12)) / 100))) / 4) + $d - 32075;
        } else {
            $jd = 367 * $y - (int)((7 * ($y + 5001 + (int)(($m - 9) / 7))) / 4) +
                (int)((275 * $m) / 9) + $d + 1729777;
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

    public function lihat(string $uuid)
    {
        $uuid = basename(trim($uuid));
        if ($uuid === '' || ! preg_match('/\A[a-zA-Z0-9_\-]+\z/', $uuid)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
        }

        $pendaftaran = (new PendaftaranModel())->where('uuid', $uuid)->first();

        $pdfPath = FCPATH . 'storage/certificates/' . $uuid . '.pdf';
        $jpgPath = FCPATH . 'storage/certificates/' . $uuid . '.jpg';

        $hasPdf = is_file($pdfPath);
        $hasJpg = is_file($jpgPath);

        if (! $hasPdf && ! $hasJpg && ! $pendaftaran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
        }

        $namaDiumrahkan = $pendaftaran['nama_diumrahkan'] ?? 'Jamaah';
        $namaPelaksana = $pendaftaran['nama_pelaksana'] ?? null;
        $tanggalMiqat = $pendaftaran['tanggal_miqat'] ?? null;
        $tanggalCetak = $pendaftaran['tanggal_cetak'] ?? null;
        $paketPilihan = $pendaftaran['paket_pilihan'] ?? null;

        $urlPdf = base_url('storage/certificates/' . rawurlencode($uuid) . '.pdf');
        $urlJpg = $hasJpg
            ? base_url('storage/certificates/' . rawurlencode($uuid) . '.jpg')
            : base_url('img/logo-utama.png');
        $shareUrl = base_url('sertifikat/' . rawurlencode($uuid));

        $videos = [];
        if (! empty($pendaftaran['id'])) {
            $videoModel = new VideoDokumentasiModel();
            $rawVideos = $videoModel
                ->where('pendaftaran_id', $pendaftaran['id'])
                ->findAll();

            foreach ($rawVideos as $vid) {
                // Pastikan video memiliki share_token valid agar link tontonan langsung dapat diakses
                if (empty($vid['share_token'])) {
                    $token = bin2hex(random_bytes(32));
                    $videoModel->update($vid['id'], ['share_token' => $token]);
                    $vid['share_token'] = $token;
                }
                $videos[] = $vid;
            }
        }

        return view('sertifikat_view', [
            'uuid'            => $uuid,
            'pendaftaran'     => $pendaftaran,
            'namaDiumrahkan'  => $namaDiumrahkan,
            'namaPelaksana'   => $namaPelaksana,
            'tanggalMiqat'    => $tanggalMiqat,
            'tanggalCetak'    => $tanggalCetak,
            'paketPilihan'    => $paketPilihan,
            'urlPdf'          => $urlPdf,
            'urlJpg'          => $urlJpg,
            'shareUrl'        => $shareUrl,
            'videos'          => $videos,
        ]);
    }
}
