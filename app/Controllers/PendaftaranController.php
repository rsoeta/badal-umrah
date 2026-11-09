<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftaranModel;
use App\Models\PengaturanModel;
use App\Models\VideoDokumentasiModel;
use App\Libraries\VideoStreamResponse;

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
        $uuid = trim((string) $this->request->getPost('uuid'));

        // Cari data berdasarkan UUID (Nomor Registrasi)
        $data = $pendaftaranModel->where('uuid', $uuid)->first();

        if ($data) {
            $videoModel = new VideoDokumentasiModel();
            $rawVideos = $videoModel
                ->where('pendaftaran_id', $data['id'])
                ->findAll();

            $videos = [];
            foreach ($rawVideos as $vid) {
                if (empty($vid['share_token'])) {
                    $token = bin2hex(random_bytes(32));
                    $videoModel->update($vid['id'], ['share_token' => $token]);
                    $vid['share_token'] = $token;
                }
                $videos[] = $vid;
            }

            $sharedVideos = array_map(static function (array $video): array {
                $token = $video['share_token'] ?? '';

                return [
                    'name'         => $video['original_name'],
                    'stream_url'   => base_url('video/' . $token . '/stream'),
                    'watch_url'    => base_url('video/' . $token),
                    'download_url' => base_url('video/' . $token . '/download'),
                ];
            }, $videos);

            // Jika data ditemukan, cek statusnya
            if ($data['status'] === 'selesai') {
                return $this->response->setJSON([
                    'status'          => 'success',
                    'certificate_ready' => true,
                    'nama'            => $data['nama_diumrahkan'],
                    'url_pdf'         => base_url('storage/certificates/' . rawurlencode($uuid) . '.pdf'),
                    'url_jpg'         => base_url('storage/certificates/' . rawurlencode($uuid) . '.jpg'),
                    'videos'          => $sharedVideos,
                ]);
            } else {
                if ($sharedVideos !== []) {
                    return $this->response->setJSON([
                        'status'            => 'success',
                        'certificate_ready' => false,
                        'nama'              => $data['nama_diumrahkan'],
                        'message'           => 'Sertifikat masih diproses, tetapi video dokumentasi sudah tersedia.',
                        'videos'            => $sharedVideos,
                    ]);
                }

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

    public function tontonVideo(string $token)
    {
        $isValidToken = (bool) preg_match('/\A[a-f0-9]{64}\z/', $token);

        $video = null;
        if ($isValidToken) {
            $video = (new VideoDokumentasiModel())
                ->where('share_token', $token)
                ->first();
        }

        $pendaftaran = null;
        if ($video !== null) {
            $pendaftaran = (new PendaftaranModel())->find($video['pendaftaran_id']);
        }

        $videoPath = $video !== null ? WRITEPATH . 'uploads/videos/' . basename($video['file_name']) : null;
        $videoFileExists = ($videoPath !== null && is_file($videoPath));

        if ($video !== null && ! $videoFileExists) {
            log_message('error', 'Shared video file is missing: {file}', ['file' => $videoPath]);
        }

        if (! $isValidToken || $video === null || $pendaftaran === null || ! $videoFileExists) {
            $pendaftaranFallback = null;
            if ($video !== null) {
                $pendaftaranFallback = (new PendaftaranModel())->withDeleted()->find($video['pendaftaran_id']);
            }

            return $this->tampilkanHalamanVideoTidakTersedia($token, $video, $pendaftaranFallback);
        }

        // Jika klien meminta video stream langsung (misal: Range header atau query parameter stream/raw)
        $accept = (string) $this->request->getHeaderLine('Accept');
        $hasRange = $this->request->hasHeader('Range');
        $wantsStream = $this->request->getGet('stream') !== null || $this->request->getGet('raw') !== null;
        $isPureMediaClient = (! str_contains($accept, 'text/html') && str_contains($accept, 'video/'));

        if ($hasRange || $wantsStream || $isPureMediaClient) {
            return $this->sharedVideoResponse($token, false);
        }

        return view('video_watch', [
            'video'       => $video,
            'pendaftaran' => $pendaftaran,
            'streamUrl'   => base_url('video/' . $token . '/stream'),
            'downloadUrl' => base_url('video/' . $token . '/download'),
            'shareUrl'    => base_url('video/' . $token),
        ]);
    }

    public function streamVideo(string $token)
    {
        return $this->sharedVideoResponse($token, false);
    }

    public function downloadSharedVideo(string $token)
    {
        return $this->sharedVideoResponse($token, true);
    }

    private function sharedVideoResponse(string $token, bool $download)
    {
        $accept = (string) $this->request->getHeaderLine('Accept');
        $isBrowser = $download || str_contains($accept, 'text/html');

        if (! preg_match('/\A[a-f0-9]{64}\z/', $token)) {
            if ($isBrowser) {
                return redirect()->to(base_url('video/' . $token));
            }

            return $this->response->setStatusCode(404)->setBody('Video tidak ditemukan.');
        }

        $video = (new VideoDokumentasiModel())
            ->where('share_token', $token)
            ->first();
        if (! $video) {
            if ($isBrowser) {
                return redirect()->to(base_url('video/' . $token));
            }

            return $this->response->setStatusCode(404)->setBody('Tautan video tidak tersedia atau telah dicabut.');
        }

        $pendaftaran = (new PendaftaranModel())->find($video['pendaftaran_id']);
        if (! $pendaftaran) {
            if ($isBrowser) {
                return redirect()->to(base_url('video/' . $token));
            }

            return $this->response->setStatusCode(404)->setBody('Data pendaftaran tidak aktif.');
        }

        $videoPath = WRITEPATH . 'uploads/videos/' . basename($video['file_name']);
        if (! is_file($videoPath)) {
            log_message('error', 'Shared video file is missing: {file}', ['file' => $videoPath]);

            if ($isBrowser) {
                return redirect()->to(base_url('video/' . $token));
            }

            return $this->response->setStatusCode(404)->setBody('Berkas video tidak ditemukan.');
        }

        $fileSize = filesize($videoPath);
        if ($fileSize === false || $fileSize <= 0) {
            log_message('error', 'Shared video has an invalid file size: {file}', ['file' => $videoPath]);

            return $this->response->setStatusCode(404)->setBody('Berkas video tidak dapat diputar.');
        }

        $mimeTypes = ['video/mp4', 'video/webm', 'video/quicktime'];
        if (! in_array($video['mime_type'], $mimeTypes, true)) {
            log_message('error', 'Unexpected MIME type for shared video {videoId}: {mimeType}', [
                'videoId'  => $video['id'],
                'mimeType' => $video['mime_type'],
            ]);

            return $this->response->setStatusCode(415)->setBody('Format video tidak didukung.');
        }

        $start = 0;
        $end = $fileSize - 1;
        $statusCode = 200;
        $rangeHeader = $this->request->getHeaderLine('Range');

        if ($rangeHeader !== '') {
            if (! preg_match('/\Abytes=(\d*)-(\d*)\z/', $rangeHeader, $matches)) {
                return $this->unsatisfiableVideoRange($fileSize);
            }

            if ($matches[1] === '') {
                $suffixLength = (int) $matches[2];
                if ($suffixLength <= 0) {
                    return $this->unsatisfiableVideoRange($fileSize);
                }
                $start = max(0, $fileSize - $suffixLength);
            } else {
                $start = (int) $matches[1];
                if ($matches[2] !== '') {
                    $end = min((int) $matches[2], $end);
                }
            }

            if ($start >= $fileSize || $end < $start) {
                return $this->unsatisfiableVideoRange($fileSize);
            }

            $statusCode = 206;
        }

        $length = $end - $start + 1;
        $response = new VideoStreamResponse(
            config('App'),
            $videoPath,
            $start,
            $length,
            strtoupper($this->request->getMethod()) === 'HEAD'
        );
        $response->setStatusCode($statusCode);
        $streamMime = $video['mime_type'];
        if (! $download && $streamMime === 'video/quicktime') {
            $streamMime = 'video/mp4';
        }
        $response->setContentType($streamMime, '');
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', (string) $length);

        if ($download) {
            $downloadFilename = ! empty($video['original_name'])
                ? basename($video['original_name'])
                : ('video.' . pathinfo($videoPath, PATHINFO_EXTENSION));
            $response->setHeader('Content-Disposition', 'attachment; filename="' . addcslashes($downloadFilename, '"\\') . '"; filename*=UTF-8\'\'' . rawurlencode($downloadFilename));
        } else {
            $response->setHeader('Content-Disposition', 'inline');
        }

        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->setHeader('Cache-Control', 'private, no-store, no-cache, must-revalidate');

        if ($statusCode === 206) {
            $response->setHeader('Content-Range', 'bytes ' . $start . '-' . $end . '/' . $fileSize);
        }

        return $response;
    }

    private function unsatisfiableVideoRange(int $fileSize)
    {
        return $this->response
            ->setStatusCode(416)
            ->setHeader('Content-Range', 'bytes */' . $fileSize)
            ->setHeader('Accept-Ranges', 'bytes')
            ->setBody('Rentang byte video tidak valid.');
    }

    private function tampilkanHalamanVideoTidakTersedia(string $token, ?array $video = null, ?array $pendaftaran = null)
    {
        $accept = (string) $this->request->getHeaderLine('Accept');
        $isPureMediaClient = (! str_contains($accept, 'text/html') && str_contains($accept, 'video/'));
        if ($isPureMediaClient) {
            return $this->response->setStatusCode(404)->setBody('Video tidak tersedia atau telah dihapus.');
        }

        $pengaturanModel = new PengaturanModel();
        $rawWaAdmin = $pengaturanModel->getSetting('no_wa_admin') ?? '082111133929';
        $cleanWaAdmin = preg_replace('/[^0-9]/', '', $rawWaAdmin);
        if (str_starts_with($cleanWaAdmin, '0')) {
            $cleanWaAdmin = '62' . substr($cleanWaAdmin, 1);
        }
        if ($cleanWaAdmin === '') {
            $cleanWaAdmin = '6282111133929';
        }

        $shareUrl = base_url('video/' . $token);

        $namaDiumrahkan = ! empty($pendaftaran['nama_diumrahkan']) ? $pendaftaran['nama_diumrahkan'] : null;
        $namaPelaksana = ! empty($pendaftaran['nama_pelaksana']) ? $pendaftaran['nama_pelaksana'] : null;
        $namaPemesan = ! empty($pendaftaran['nama_pemesan']) ? $pendaftaran['nama_pemesan'] : null;

        if ($namaDiumrahkan !== null) {
            $waText = "Assalamu'alaikum Admin / Pelaksana Badal Umrah,\n\n"
                . "Saya ingin menanyakan tautan video dokumentasi Badal Umrah atas nama:\n"
                . "• Nama Jamaah: " . $namaDiumrahkan . "\n"
                . ($namaPelaksana ? "• Pelaksana: " . $namaPelaksana . "\n" : "")
                . "• Tautan: " . $shareUrl . "\n\n"
                . "Tautan tersebut saat ini tidak dapat diakses / video telah dihapus. Mohon bantuan informasinya. Terima kasih.";
        } else {
            $waText = "Assalamu'alaikum Admin / Pelaksana Badal Umrah,\n\n"
                . "Saya ingin menanyakan tautan video dokumentasi Badal Umrah berikut yang saat ini tidak dapat diakses (video telah dihapus/tidak ditemukan):\n"
                . $shareUrl . "\n\n"
                . "Mohon bantuan informasinya. Terima kasih.";
        }

        $waAdminUrl = 'https://wa.me/' . $cleanWaAdmin . '?text=' . rawurlencode($waText);

        return $this->response
            ->setStatusCode(404)
            ->setBody(view('video_unavailable', [
                'token'          => $token,
                'shareUrl'       => $shareUrl,
                'pendaftaran'    => $pendaftaran,
                'namaDiumrahkan' => $namaDiumrahkan,
                'namaPelaksana'  => $namaPelaksana,
                'namaPemesan'    => $namaPemesan,
                'cleanWaAdmin'   => $cleanWaAdmin,
                'waAdminUrl'     => $waAdminUrl,
            ]));
    }
}
