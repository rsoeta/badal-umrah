<?php

namespace Tests\Unit;

use App\Controllers\AdminController;
use App\Models\PendaftaranModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;

/**
 * @internal
 */
final class AdminEditFotoTest extends CIUnitTestCase
{
    use \CodeIgniter\Test\DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    public function testLihatFotoReturns404WhenNoPhoto(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-foto-404-uuid',
            'nama_pemesan'    => 'Pemesan Tanpa Foto',
            'no_wa_pemesan'   => '0811111111',
            'nama_diumrahkan' => 'Jamaah Tanpa Foto',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
            'status'          => 'pending',
            'foto_jamaah'     => null,
        ]);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->lihatFoto((int) $id);
        $this->assertSame(404, $res->getStatusCode());
    }

    public function testLihatFotoReturnsImageWhenPhotoExists(): void
    {
        $uploadDir = WRITEPATH . 'uploads/pendaftaran-images';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $dummyFileName = 'test_sample_photo_' . uniqid() . '.jpg';
        $dummyPath = $uploadDir . '/' . $dummyFileName;
        file_put_contents($dummyPath, 'fake-jpeg-binary-data');

        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-foto-200-uuid',
            'nama_pemesan'    => 'Pemesan Ada Foto',
            'no_wa_pemesan'   => '0812222222',
            'nama_diumrahkan' => 'Jamaah Ada Foto',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
            'status'          => 'pending',
            'foto_jamaah'     => $dummyFileName,
        ]);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->lihatFoto((int) $id);
        $this->assertSame(200, $res->getStatusCode());
        $this->assertSame('fake-jpeg-binary-data', $res->getBody());

        if (is_file($dummyPath)) {
            unlink($dummyPath);
        }
    }

    public function testHapusFotoJamaahViaEditPendaftaran(): void
    {
        $uploadDir = WRITEPATH . 'uploads/pendaftaran-images';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $dummyFileName = 'test_remove_photo_' . uniqid() . '.jpg';
        $dummyPath = $uploadDir . '/' . $dummyFileName;
        file_put_contents($dummyPath, 'image-to-be-deleted');

        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-foto-delete-uuid',
            'nama_pemesan'    => 'Pemesan Hapus Foto',
            'no_wa_pemesan'   => '0813333333',
            'nama_diumrahkan' => 'Jamaah Hapus Foto',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
            'status'          => 'pending',
            'foto_jamaah'     => $dummyFileName,
        ]);

        $controller = new AdminController();

        $postData = [
            'nama_pemesan'       => 'Pemesan Hapus Foto Baru',
            'no_wa_pemesan'      => '0813333333',
            'nama_diumrahkan'    => 'Jamaah Hapus Foto Baru',
            'paket_pilihan'      => 'Paket Standar (Rp 1.5 Jt)',
            'hapus_foto_jamaah'  => '1',
        ];

        $_POST = $postData;
        $_REQUEST = $postData;
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request = $request->withMethod('POST');
        $request->setGlobal('post', $postData);
        $request->setGlobal('request', $postData);
        Services::injectMock('request', $request);

        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->editPendaftaran((int) $id);
        $this->assertSame(200, $res->getStatusCode(), 'Response: ' . $res->getBody());

        $updatedRecord = $pendaftaranModel->find($id);
        $this->assertNull($updatedRecord['foto_jamaah']);
        $this->assertFileDoesNotExist($dummyPath);
    }

    public function testKeepExistingFotoWhenNoNewPhotoAndNoHapus(): void
    {
        $uploadDir = WRITEPATH . 'uploads/pendaftaran-images';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $dummyFileName = 'test_keep_photo_' . uniqid() . '.jpg';
        $dummyPath = $uploadDir . '/' . $dummyFileName;
        file_put_contents($dummyPath, 'keep-this-image');

        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-foto-keep-uuid',
            'nama_pemesan'    => 'Pemesan Simpan Foto',
            'no_wa_pemesan'   => '0814444444',
            'nama_diumrahkan' => 'Jamaah Simpan Foto',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
            'status'          => 'pending',
            'foto_jamaah'     => $dummyFileName,
        ]);

        $controller = new AdminController();

        $postData = [
            'nama_pemesan'    => 'Pemesan Nama Berubah',
            'no_wa_pemesan'   => '0814444444',
            'nama_diumrahkan' => 'Jamaah Nama Berubah',
            'paket_pilihan'   => 'Paket Paripurna (Rp 2 Jt)',
        ];

        $_POST = $postData;
        $_REQUEST = $postData;
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request = $request->withMethod('POST');
        $request->setGlobal('post', $postData);
        $request->setGlobal('request', $postData);
        Services::injectMock('request', $request);

        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->editPendaftaran((int) $id);
        $this->assertSame(200, $res->getStatusCode(), 'Response: ' . $res->getBody());

        $updatedRecord = $pendaftaranModel->find($id);
        $this->assertSame($dummyFileName, $updatedRecord['foto_jamaah']);
        $this->assertSame('Pemesan Nama Berubah', $updatedRecord['nama_pemesan']);
        $this->assertSame('Paket Paripurna (Rp 2 Jt)', $updatedRecord['paket_pilihan']);
        $this->assertFileExists($dummyPath);

        if (is_file($dummyPath)) {
            unlink($dummyPath);
        }
    }

    public function testEditPendaftaranReturnsUrlPdfWhenStatusIsSelesai(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'                 => 'RCP-2026-TESTPDF',
            'nama_pemesan'         => 'Pemesan Selesai',
            'no_wa_pemesan'        => '0815555555',
            'nama_diumrahkan'      => 'Jamaah Selesai',
            'paket_pilihan'        => 'Paket Standar (Rp 1.5 Jt)',
            'status'               => 'selesai',
            'tanggal_miqat'        => '2026-11-01',
            'tanggal_cetak'        => '2026-11-02',
            'nama_pelaksana'       => 'Ustadz Pelaksana',
            'file_ttd_pelaksana'   => '',
            'foto_jamaah'          => null,
        ]);

        $controller = new AdminController();

        $postData = [
            'nama_pemesan'    => 'Pemesan Selesai Diupdate',
            'no_wa_pemesan'   => '0815555555',
            'nama_diumrahkan' => 'Jamaah Selesai Diupdate',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
        ];

        $_POST = $postData;
        $_REQUEST = $postData;
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request = $request->withMethod('POST');
        $request->setGlobal('post', $postData);
        $request->setGlobal('request', $postData);
        Services::injectMock('request', $request);

        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->editPendaftaran((int) $id);
        $this->assertSame(200, $res->getStatusCode(), 'Response: ' . $res->getBody());

        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);
        $this->assertArrayHasKey('url_pdf', $body);
        $this->assertStringContainsString('storage/certificates/RCP-2026-TESTPDF.pdf', $body['url_pdf']);
    }

    public function testPublicFaviconIsPresentAndValidIco(): void
    {
        $faviconPath = FCPATH . 'favicon.ico';
        $this->assertFileExists($faviconPath);
        $this->assertGreaterThan(5000, filesize($faviconPath));

        $header = unpack('vreserved/vtype/vcount', file_get_contents($faviconPath, false, null, 0, 6));
        $this->assertSame(0, $header['reserved']);
        $this->assertSame(1, $header['type']); // 1 = ICO
        $this->assertGreaterThan(0, $header['count']);
    }

    public function testDashboardRendersMiniFotoWhenAvailable(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $id = $pendaftaranModel->insert([
            'uuid'            => 'test-foto-mini-uuid',
            'nama_pemesan'    => 'Pemesan Mini',
            'no_wa_pemesan'   => '0812345678',
            'nama_diumrahkan' => 'Jamaah Mini Foto',
            'paket_pilihan'   => 'Paket Standar (Rp 1.5 Jt)',
            'status'          => 'pending',
            'foto_jamaah'     => 'sample_photo.jpg',
        ]);

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $html = $controller->index();
        $this->assertIsString($html);
        $this->assertStringContainsString('admin/pendaftaran/' . $id . '/foto', $html);
        $this->assertStringContainsString('Jamaah Mini Foto', $html);
        $this->assertStringNotContainsString('Foto disertakan', $html);
    }
}
