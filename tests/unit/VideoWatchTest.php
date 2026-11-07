<?php

namespace Tests\Unit;

use App\Controllers\PendaftaranController;
use App\Models\PendaftaranModel;
use App\Models\VideoDokumentasiModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\App;

/**
 * @internal
 */
final class VideoWatchTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    private string $testVideoPath;
    private string $token;
    private int $pendaftaranId;
    private int $videoId;

    protected function setUp(): void
    {
        parent::setUp();

        $videoDir = WRITEPATH . 'uploads/videos';
        if (! is_dir($videoDir)) {
            mkdir($videoDir, 0755, true);
        }

        $this->token = bin2hex(random_bytes(32));
        $fileName = 'test_sample_video_' . $this->token . '.mp4';
        $this->testVideoPath = $videoDir . '/' . $fileName;
        file_put_contents($this->testVideoPath, 'fake-mp4-video-content-stream-bytes-for-testing-1234567890');

        $pendaftaranModel = new PendaftaranModel();
        $this->pendaftaranId = (int) $pendaftaranModel->insert([
            'uuid'             => uniqid('test-uuid-', true),
            'nama_pemesan'     => 'Keluarga Bpk. H. Ahmad',
            'no_wa_pemesan'    => '081234567890',
            'nama_diumrahkan'  => 'Alm. Bpk. H. Ahmad Dahlan',
            'paket_pilihan'    => 'Paket Badal Umrah Spesial',
            'status'           => 'selesai',
        ]);

        $videoModel = new VideoDokumentasiModel();
        $this->videoId = (int) $videoModel->insert([
            'pendaftaran_id' => $this->pendaftaranId,
            'file_name'      => $fileName,
            'original_name'  => 'Pelaksanaan Tawaf.mp4',
            'mime_type'      => 'video/mp4',
            'file_size'      => filesize($this->testVideoPath),
            'share_token'    => $this->token,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    protected function tearDown(): void
    {
        if (is_file($this->testVideoPath)) {
            @unlink($this->testVideoPath);
        }

        if (! empty($this->videoId)) {
            (new VideoDokumentasiModel())->delete($this->videoId, true);
        }
        if (! empty($this->pendaftaranId)) {
            (new PendaftaranModel())->delete($this->pendaftaranId, true);
        }

        parent::tearDown();
    }

    public function testTontonVideoRendersHtmlPlayer(): void
    {
        $controller = new PendaftaranController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request->setHeader('Accept', 'text/html,application/xhtml+xml');
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $result = $controller->tontonVideo($this->token);
        $this->assertIsString($result);
        $this->assertStringContainsString('Alm. Bpk. H. Ahmad Dahlan', $result);
        $this->assertStringContainsString('Pelaksanaan Tawaf.mp4', $result);
        $this->assertStringContainsString('<video', $result);
        $this->assertStringContainsString($this->token . '/stream', $result);
        $this->assertStringContainsString($this->token . '/download', $result);
    }

    public function testStreamVideoReturnsInlineContent(): void
    {
        $controller = new PendaftaranController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $streamResponse = $controller->streamVideo($this->token);
        $this->assertSame(200, $streamResponse->getStatusCode());
        $this->assertSame('inline', $streamResponse->getHeaderLine('Content-Disposition'));
        $this->assertStringContainsString('video/mp4', $streamResponse->getHeaderLine('Content-Type'));
        $this->assertSame('bytes', $streamResponse->getHeaderLine('Accept-Ranges'));
    }

    public function testStreamVideoMapsQuickTimeToMp4(): void
    {
        (new VideoDokumentasiModel())->update($this->videoId, ['mime_type' => 'video/quicktime']);

        $controller = new PendaftaranController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $streamResponse = $controller->streamVideo($this->token);
        $this->assertSame(200, $streamResponse->getStatusCode());
        $this->assertSame('inline', $streamResponse->getHeaderLine('Content-Disposition'));
        $this->assertSame('video/mp4', $streamResponse->getHeaderLine('Content-Type'));
    }

    public function testDownloadSharedVideoReturnsAttachment(): void
    {
        $controller = new PendaftaranController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $downloadResponse = $controller->downloadSharedVideo($this->token);
        $this->assertSame(200, $downloadResponse->getStatusCode());
        $this->assertStringContainsString('attachment', $downloadResponse->getHeaderLine('Content-Disposition'));
        $this->assertStringContainsString('Pelaksanaan Tawaf.mp4', $downloadResponse->getHeaderLine('Content-Disposition'));
    }
}
