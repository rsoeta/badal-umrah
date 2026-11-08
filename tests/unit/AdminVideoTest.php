<?php

namespace Tests\Unit;

use App\Controllers\AdminController;
use App\Models\PendaftaranModel;
use App\Models\VideoDokumentasiModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;

/**
 * @internal
 */
final class AdminVideoTest extends CIUnitTestCase
{
    use \CodeIgniter\Test\DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    public function testDaftarVideoHandlesRecordWithoutError(): void
    {
        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $logger = Services::logger();

        $controller->initController($request, $response, $logger);

        $res = $controller->daftarVideo(17);
        $this->assertContains($res->getStatusCode(), [200, 404]);

        $body = json_decode($res->getBody(), true);
        $this->assertIsArray($body);
        $this->assertArrayHasKey('status', $body);
    }

    public function testDaftarVideoReturnsVideosWithShareStatus(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'             => 'test-uuid-video-1234',
            'nama_pemesan'     => 'Pemesan Test',
            'no_wa_pemesan'    => '08123456789',
            'nama_diumrahkan'  => 'Almarhum Test',
            'paket_pilihan'    => 'Paket Badal Umrah',
            'status'           => 'selesai',
        ]);

        $videoModel = new VideoDokumentasiModel();
        $videoModel->insert([
            'pendaftaran_id' => $id,
            'file_name'      => 'test_video_1.mp4',
            'original_name'  => 'video-1.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => 1024,
            'share_token'    => null,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $videoModel->insert([
            'pendaftaran_id' => $id,
            'file_name'      => 'test_video_2.mp4',
            'original_name'  => 'video-2.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => 2048,
            'share_token'    => str_repeat('a', 64),
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->daftarVideo((int) $id);
        $this->assertSame(200, $res->getStatusCode());

        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);
        $this->assertCount(2, $body['videos']);

        $tokenedVideo = null;
        $unsharedVideo = null;
        foreach ($body['videos'] as $v) {
            if ($v['original_name'] === 'video-2.mp4') {
                $tokenedVideo = $v;
            } elseif ($v['original_name'] === 'video-1.mp4') {
                $unsharedVideo = $v;
            }
        }

        $this->assertNotNull($tokenedVideo);
        $this->assertNotNull($unsharedVideo);
        $this->assertNotNull($tokenedVideo['share_url']);
        $this->assertNull($unsharedVideo['share_url']);
    }

    public function testHapusPermanenDeletesVideoFilesAndMetadata(): void
    {
        $videoDir = WRITEPATH . 'uploads/videos';
        if (! is_dir($videoDir)) {
            mkdir($videoDir, 0755, true);
        }

        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'uuid-trash-test-1',
            'nama_pemesan'    => 'Pemesan Sampah',
            'no_wa_pemesan'   => '0812999999',
            'nama_diumrahkan' => 'Alm Sampah',
            'paket_pilihan'   => 'Paket Badal Umrah',
            'status'          => 'selesai',
        ]);

        // Soft delete the pendaftaran to put it in trash
        $pendaftaranModel->delete($id);

        $dummyVideoName = 'test_trash_video_' . uniqid() . '.mp4';
        $dummyVideoPath = $videoDir . DIRECTORY_SEPARATOR . $dummyVideoName;
        file_put_contents($dummyVideoPath, 'fake-mp4-data');

        $videoModel = new VideoDokumentasiModel();
        $videoId = $videoModel->insert([
            'pendaftaran_id' => $id,
            'file_name'      => $dummyVideoName,
            'original_name'  => 'asli_video.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => 13,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $this->assertFileExists($dummyVideoPath);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->hapusPermanen((int) $id);
        $this->assertSame(200, $res->getStatusCode());

        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);

        // Verify video file is deleted from disk
        $this->assertFileDoesNotExist($dummyVideoPath);

        // Verify video metadata is deleted from database
        $this->assertNull($videoModel->find($videoId));

        // Verify pendaftaran is completely removed
        $this->assertNull($pendaftaranModel->withDeleted()->find($id));
    }

    public function testDashboardRendersVideoNotificationBadge(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-video-badge-uuid',
            'nama_pemesan'    => 'Pemesan Badge',
            'no_wa_pemesan'   => '0812345678',
            'nama_diumrahkan' => 'Jamaah Badge Video',
            'paket_pilihan'   => 'Paket Standar',
            'status'          => 'pending',
        ]);

        $videoModel = new VideoDokumentasiModel();
        $videoModel->insert([
            'pendaftaran_id' => $id,
            'file_name'      => 'vid1.mp4',
            'original_name'  => 'video1.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => 1024,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        $videoModel->insert([
            'pendaftaran_id' => $id,
            'file_name'      => 'vid2.mp4',
            'original_name'  => 'video2.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => 2048,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $html = $controller->index();
        $this->assertIsString($html);
        $this->assertStringContainsString('badge-video-count', $html);
        $this->assertStringContainsString('data-id="' . $id . '"', $html);
        $this->assertStringContainsString('Arsip Video Dokumentasi (2 video)', $html);
    }
}
