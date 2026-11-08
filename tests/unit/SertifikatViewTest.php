<?php

namespace Tests\Unit;

use App\Controllers\SertifikatController;
use App\Models\PendaftaranModel;
use CodeIgniter\Config\Services;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\App;

/**
 * @internal
 */
final class SertifikatViewTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    private string $testUuid;
    private string $testJpgPath;
    private string $testPdfPath;
    private int $pendaftaranId;

    protected function setUp(): void
    {
        parent::setUp();

        $certDir = FCPATH . 'storage/certificates';
        if (! is_dir($certDir)) {
            mkdir($certDir, 0755, true);
        }

        $this->testUuid = 'RCP-TEST-' . bin2hex(random_bytes(4));
        $this->testJpgPath = $certDir . '/' . $this->testUuid . '.jpg';
        $this->testPdfPath = $certDir . '/' . $this->testUuid . '.pdf';

        file_put_contents($this->testJpgPath, 'fake-jpg-content');
        file_put_contents($this->testPdfPath, 'fake-pdf-content');

        $pendaftaranModel = new PendaftaranModel();
        $this->pendaftaranId = (int) $pendaftaranModel->insert([
            'uuid'            => $this->testUuid,
            'nama_pemesan'    => 'Keluarga Bpk. Oman',
            'no_wa_pemesan'   => '081234567890',
            'nama_diumrahkan' => 'Oman Bin Ahri',
            'paket_pilihan'   => 'Paket Badal Umrah Spesial',
            'nama_pelaksana'  => 'Ust. Azis Rustandi',
            'status'          => 'selesai',
        ]);
    }

    protected function tearDown(): void
    {
        if (is_file($this->testJpgPath)) {
            @unlink($this->testJpgPath);
        }
        if (is_file($this->testPdfPath)) {
            @unlink($this->testPdfPath);
        }
        if (! empty($this->pendaftaranId)) {
            (new PendaftaranModel())->delete($this->pendaftaranId, true);
        }

        parent::tearDown();
    }

    public function testLihatRendersHtmlWithOpenGraphTags(): void
    {
        $controller = new SertifikatController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $html = $controller->lihat($this->testUuid);

        $this->assertIsString($html);
        $this->assertStringContainsString('Oman Bin Ahri', $html);
        $this->assertStringContainsString('Ust. Azis Rustandi', $html);
        $this->assertStringContainsString('property="og:title"', $html);
        $this->assertStringContainsString('property="og:description"', $html);
        $this->assertStringContainsString('property="og:image"', $html);
        $this->assertStringContainsString($this->testUuid . '.jpg', $html);
        $this->assertStringContainsString($this->testUuid . '.pdf', $html);
        $this->assertStringContainsString('name="twitter:card"', $html);
    }

    public function testLihatThrows404ForNonexistentUuid(): void
    {
        $this->expectException(PageNotFoundException::class);

        $controller = new SertifikatController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $controller->lihat('NON-EXISTENT-UUID-99999');
    }
}
