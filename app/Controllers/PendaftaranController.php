<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftaranModel;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('pendaftaran_form');
    }

    public function submit()
    {
        $pendaftaranModel = new PendaftaranModel();

        // Membuat Nomor Registrasi (Format: RCP-Tahun-6KarakterAcak)
        $uuid = 'RCP-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $fotoJamaah = $this->request->getFile('foto_jamaah');
        $fotoJamaahName = null;

        if ($fotoJamaah !== null && $fotoJamaah->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $this->validate([
                'foto_jamaah' => 'uploaded[foto_jamaah]|is_image[foto_jamaah]|mime_in[foto_jamaah,image/jpeg,image/png,image/webp]|max_size[foto_jamaah,5120]',
            ])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => implode(' ', $this->validator->getErrors()),
                ]);
            }

            $extension = match ($fotoJamaah->getMimeType()) {
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
                default      => null,
            };

            if ($extension === null) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Format foto harus JPG, PNG, atau WEBP.',
                ]);
            }

            $uploadDirectory = WRITEPATH . 'uploads/pendaftaran-images';
            if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0750, true) && ! is_dir($uploadDirectory)) {
                log_message('error', 'Failed to create registration image directory: {directory}', ['directory' => $uploadDirectory]);

                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Foto gagal disimpan. Silakan coba kembali.',
                ]);
            }

            $fotoJamaahName = $uuid . '.' . $extension;
            $fotoJamaah->move($uploadDirectory, $fotoJamaahName);
        }

        $data = [
            'uuid'            => $uuid,
            'nama_pemesan'    => $this->request->getPost('nama_pemesan'),
            'no_wa_pemesan'   => $this->request->getPost('no_wa_pemesan'),
            'nama_diumrahkan' => $this->request->getPost('nama_diumrahkan'),
            'foto_jamaah'     => $fotoJamaahName,
            'paket_pilihan'   => $this->request->getPost('paket_pilihan'),
            'status'          => 'pending' // Status awal saat pendaftaran masuk
        ];

        // Simpan ke database
        if ($pendaftaranModel->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Pendaftaran berhasil dikirim!',
                'uuid'    => $uuid
            ]);
        } else {
            if ($fotoJamaahName !== null) {
                $fotoJamaahPath = WRITEPATH . 'uploads/pendaftaran-images/' . $fotoJamaahName;
                if (is_file($fotoJamaahPath) && ! unlink($fotoJamaahPath)) {
                    log_message('error', 'Failed to remove registration image after database insert failure: {file}', ['file' => $fotoJamaahPath]);
                }
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
    }

    public function cekSertifikat()
    {
        $pendaftaranModel = new PendaftaranModel();
        $uuid = $this->request->getPost('uuid');

        // Cari data berdasarkan UUID (Nomor Registrasi)
        $data = $pendaftaranModel->where('uuid', $uuid)->first();

        if ($data) {
            // Jika data ditemukan, cek statusnya
            if ($data['status'] === 'selesai') {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'nama'    => $data['nama_diumrahkan'],
                    'url_pdf' => base_url('storage/certificates/' . $uuid . '.pdf'),
                    'url_jpg' => base_url('storage/certificates/' . $uuid . '.jpg')
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => 'pending',
                    'message' => 'Sertifikat atas nama ' . $data['nama_diumrahkan'] . ' sedang dalam proses pelaksanaan/pengerjaan.'
                ]);
            }
        } else {
            // Jika UUID tidak ada di database
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan. Pastikan Nomor Registrasi sudah diketik dengan benar.'
            ]);
        }
    }
}
