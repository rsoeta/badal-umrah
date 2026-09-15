<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftaranModel;
use App\Models\PengaturanModel;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function index()
    {
        $pendaftaranModel = new PendaftaranModel();
        $pengaturanModel  = new PengaturanModel();

        $data['pendaftar'] = $pendaftaranModel->orderBy('created_at', 'DESC')->findAll();

        // Ambil data Mutawwif, pecah berdasarkan baris baru (enter) menjadi array
        $list_mutawwif_raw = $pengaturanModel->getSetting('list_mutawwif') ?? "Ust. Ahmad Fadil|ttd-ahmad.png\nUst. Azis Rustandi|ttd-azis.png";
        $data['list_mutawwif'] = array_filter(explode("\n", str_replace("\r", "", $list_mutawwif_raw)));

        return view('admin_dashboard', $data);
    }

    public function prosesSertifikat()
    {
        $pendaftaranModel = new PendaftaranModel();
        $pengaturanModel  = new PengaturanModel(); // Panggil model pengaturan

        $id_pendaftaran   = $this->request->getPost('id_pendaftaran');

        $jamaah = $pendaftaranModel->find($id_pendaftaran);
        if (!$jamaah) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan!']);
        }

        $pelaksana_data = explode('|', $this->request->getPost('pelaksana_data'));
        $nama_pelaksana = $pelaksana_data[0];
        $file_ttd       = $pelaksana_data[1] ?? '';

        $tempat_miqat    = $this->request->getPost('tempat_miqat');
        $tgl_miqat_input = $this->request->getPost('tanggal_miqat');
        $tgl_cetak_input = $this->request->getPost('tanggal_cetak');
        $koreksi_hijriah = (int) $this->request->getPost('koreksi_hijriah');

        $tanggal_miqat = $this->formatMasehi($tgl_miqat_input) . ' M / ' . $this->gregorianToHijri($tgl_miqat_input, $koreksi_hijriah) . ' H';
        $tanggal_cetak = $this->formatMasehi($tgl_cetak_input) . ' M / ' . $this->gregorianToHijri($tgl_cetak_input, $koreksi_hijriah) . ' H';

        // MENGAMBIL NAMA DIREKTUR DINAMIS DARI DATABASE
        $nama_direktur = $pengaturanModel->getSetting('nama_direktur') ?? "H. Fulan bin Fulan, Lc., M.A.";

        // ... (Kode ke bawahnya untuk PDF dan ImageManager tetap sama persis seperti sebelumnya) ...

        // 2. Persiapan Aset Gambar
        $templatePath = FCPATH . 'templates/template_sertifikat.png';
        $fontPath     = FCPATH . 'fonts/Amiri-Bold.ttf';

        // MENGGUNAKAN UUID ASLI DARI DATABASE (Bukan random lagi)
        $uuid = $jamaah['uuid'];
        $outputJpg = FCPATH . 'storage/certificates/' . $uuid . '.jpg';
        $outputPdf = FCPATH . 'storage/certificates/' . $uuid . '.pdf';

        // 3. Proses Injeksi Teks ke Gambar (Menggunakan kode generator kita sebelumnya)
        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        $tulisTeks = function ($image, $text, $x, $y, $align, $size = 32, $color = '#000000') use ($fontPath) {
            $image->text($text, $x, $y, function ($font) use ($fontPath, $size, $color, $align) {
                $font->file($fontPath);
                $font->size($size);
                $font->color($color);
                $font->align($align);
                $font->valign('middle');
            });
        };

        // Suntik Data ke Gambar
        $tulisTeks($img, $nama_pelaksana, 513, 685, 'center', 42);
        $tulisTeks($img, $jamaah['nama_diumrahkan'], 510, 804, 'center', 42);
        $tulisTeks($img, $tempat_miqat, 383, 865, 'left', 20, '#FFFFFF');
        $tulisTeks($img, $tanggal_miqat, 383, 901, 'left', 20, '#FFFFFF');
        $tulisTeks($img, $tanggal_cetak, 600, 1069, 'left', 15, '#FFFFFF');
        $tulisTeks($img, $nama_direktur, 211, 1429, 'center', 24);
        $tulisTeks($img, $nama_pelaksana, 806, 1429, 'center', 24);

        // // Humanizer Stempel & TTD
        // $stempelPath = FCPATH . 'templates/stempel.png';
        // if (file_exists($stempelPath)) {
        //     $stempel = $manager->read($stempelPath);
        //     $stempel->scale(width: 220);
        //     $stempel->rotate(rand(-4, 4), 'transparent');
        //     $img->place($stempel, 'top-left', 101 + rand(-10, 10), 1249 + rand(-10, 10));
        // }

        // if ($file_ttd !== '') {
        //     $ttdPath = FCPATH . 'signatures/' . $file_ttd;
        //     if (file_exists($ttdPath)) {
        //         $ttd = $manager->read($ttdPath);
        //         $ttd->scale(width: 180);
        //         $ttd->rotate(rand(-3, 3), 'transparent');
        //         $img->place($ttd, 'top-left', 716 + rand(-15, 15), 1269 + rand(-15, 15));
        //     }
        // }
        // ==========================================
        // FITUR HUMANIZER (STEMPEL & TANDA TANGAN)
        // ==========================================

        // A. Menyuntikkan Cap Stempel (Di atas nama Direktur)
        $stempelPath = FCPATH . 'templates/stempel.png';
        if (file_exists($stempelPath)) {
            $stempel = $manager->read($stempelPath);

            // 1. Resize stempel raksasa menjadi ukuran proporsional (misal: lebar 220px)
            $stempel->scale(width: 220);

            // 2. Randomizer kemiringan
            $stempel->rotate(rand(-4, 4), 'transparent');

            // 3. Kalkulasi Koordinat:
            // Titik tengah nama direktur adalah X: 211. 
            // Agar stempel (lebar 220px) ada di tengah, X = 211 - (220/2) = 101.
            // Y diletakkan sedikit di atas nama direktur (1429 - 180 = 1249).
            $img->place($stempel, 'top-left', 650 + rand(-10, 10), 1255 + rand(-10, 10));
        }

        // B. Menyuntikkan Tanda Tangan Pelaksana (Di atas nama Pelaksana)
        if ($file_ttd !== '') {
            $ttdPath = FCPATH . 'signatures/' . $file_ttd;
            if (file_exists($ttdPath)) {
                $ttd = $manager->read($ttdPath);

                // 1. Resize sedikit tanda tangan agar tidak terlalu besar (misal: lebar 180px)
                $ttd->scale(width: 180);

                // 2. Randomizer kemiringan
                $ttd->rotate(rand(-3, 3), 'transparent');

                // 3. Kalkulasi Koordinat:
                // Titik tengah nama pelaksana adalah X: 806.
                // Agar TTD (lebar 180px) ada di tengah, X = 806 - (180/2) = 716.
                // Y diletakkan sedikit di atas nama pelaksana (1429 - 160 = 1269).
                $img->place($ttd, 'top-left', 735 + rand(-15, 15), 1300 + rand(-15, 15));
            }
        }

        $img->save($outputJpg, 90);

        // 4. Konversi ke PDF
        $pdf = new \FPDF('P', 'pt', [1024, 1536]);
        $pdf->AddPage();
        $pdf->Image($outputJpg, 0, 0, 1024, 1536);
        $pdf->Output('F', $outputPdf);

        // 5. UPDATE DATABASE (Tandai Selesai)
        $pendaftaranModel->update($id_pendaftaran, [
            'nama_pelaksana'     => $nama_pelaksana,
            'file_ttd_pelaksana' => $file_ttd,
            'tempat_miqat'       => $tempat_miqat,
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

        $data['nama_direktur'] = $pengaturanModel->getSetting('nama_direktur') ?? 'H. Fulan bin Fulan, Lc., M.A.';
        $data['list_mutawwif'] = $pengaturanModel->getSetting('list_mutawwif') ?? "Ust. Ahmad Fadil|ttd-ahmad.png\nUst. Azis Rustandi|ttd-azis.png";

        // Ambil data username untuk ditampilkan di form (password jangan pernah dikirim ke view)
        $data['admin_username'] = $pengaturanModel->getSetting('admin_username') ?? 'admin-badal';

        return view('admin_pengaturan', $data);
    }

    public function simpanPengaturan()
    {
        $pengaturanModel = new PengaturanModel();

        $settings = [
            'nama_direktur'  => $this->request->getPost('nama_direktur'),
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
