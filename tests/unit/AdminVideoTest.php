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
}
