<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $tempat_miqat    = $this->request->getPost('tempat_miqat');

        // Data Tanggal & Koreksi Hijriah
        $tgl_miqat_input = $this->request->getPost('tanggal_miqat');
        $tgl_cetak_input = $this->request->getPost('tanggal_cetak');
        $koreksi_hijriah = (int) $this->request->getPost('koreksi_hijriah');

        // Proses format tanggal Masehi & Hijriah
        $tanggal_miqat = $this->formatMasehi($tgl_miqat_input) . ' M / ' . $this->gregorianToHijri($tgl_miqat_input, $koreksi_hijriah) . ' H';
        $tanggal_cetak = $this->formatMasehi($tgl_cetak_input) . ' M / ' . $this->gregorianToHijri($tgl_cetak_input, $koreksi_hijriah) . ' H';

        // Data Statis
        $nama_direktur   = "H. Fulan bin Fulan, Lc., M.A.";

        // 2. Tentukan lokasi path aset
        $templatePath = FCPATH . 'templates/template_sertifikat.png';
        $fontPath     = FCPATH . 'fonts/Amiri-Bold.ttf';

        // UUID untuk nama file rahasia
        $uuid = bin2hex(random_bytes(8));

        $outputJpg    = FCPATH . 'storage/certificates/' . $uuid . '.jpg';
        $outputPdf    = FCPATH . 'storage/certificates/' . $uuid . '.pdf';

        // 3. Proses Injeksi Teks ke Gambar
        $manager = new ImageManager(new Driver());
        $img = $manager->read($templatePath);

        // Fungsi bantu (Mendukung parameter warna)
        $tulisTeks = function ($image, $text, $x, $y, $align, $size = 32, $color = '#000000') use ($fontPath) {
            $image->text($text, $x, $y, function ($font) use ($fontPath, $size, $color, $align) {
                $font->file($fontPath);
                $font->size($size);
                $font->color($color);
                $font->align($align);
                $font->valign('middle');
            });
        };

        // Menyuntikkan teks berdasarkan koordinat presisi Kang Rian
        $tulisTeks($img, $nama_pelaksana, 513, 685, 'center', 42); // Nama Pelaksana (Tengah)
        $tulisTeks($img, $nama_diumrahkan, 510, 804, 'center', 42); // Nama Di-umrahkan

        // Tempat & Tanggal Miqat (Ukuran 20, Warna Putih)
        $tulisTeks($img, $tempat_miqat, 383, 865, 'left', 20, '#FFFFFF');
        $tulisTeks($img, $tanggal_miqat, 383, 901, 'left', 20, '#FFFFFF');

        // Tanggal Cetak
        $tulisTeks($img, $tanggal_cetak, 600, 1069, 'left', 15, '#FFFFFF');

        // Bagian Tanda Tangan (Sejajar di Y: 1429, Ukuran 24)
        $tulisTeks($img, $nama_direktur, 211, 1429, 'center', 24); // Kiri: Direktur
        $tulisTeks($img, $nama_pelaksana, 806, 1429, 'center', 24); // Kanan: Pelaksana

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

        // Simpan sebagai file JPG
        $img->save($outputJpg, 90);

        // 4. Proses Konversi JPG ke PDF
        $pdf = new \FPDF('P', 'pt', [1024, 1536]);
        $pdf->AddPage();
        $pdf->Image($outputJpg, 0, 0, 1024, 1536);
        $pdf->Output('F', $outputPdf);

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
}
