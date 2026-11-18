<?php

namespace Tests\Unit;

use App\Controllers\AdminController;
use App\Controllers\SertifikatController;
use App\Models\TempatMiqatModel;
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
final class TempatMiqatCrudTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    private function createAdminController(array $post = []): AdminController
    {
        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request->setGlobal('post', $post);
        $request->setGlobal('request', $post);
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        return $controller;
    }

    public function testSertifikatIndexRendersDynamicDatalist(): void
    {
        $miqatModel = new TempatMiqatModel();
        // Pastikan ada setidaknya satu record
        $testName = 'Miqat Test ' . bin2hex(random_bytes(3));
        $id = (int) $miqatModel->insert([
            'nama_miqat' => $testName,
            'keterangan' => 'Testing Datalist',
        ]);

        $controller = new SertifikatController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $html = $controller->index();
        $this->assertIsString($html);
        $this->assertStringContainsString('id="listMiqatForm"', $html);
        $this->assertStringContainsString(esc($testName, 'attr'), $html);

        $miqatModel->delete($id);
    }

    public function testAdminPengaturanIncludesTempatMiqat(): void
    {
        $controller = $this->createAdminController();
        $html = $controller->pengaturan();
        $this->assertIsString($html);
        $this->assertStringContainsString('Master Tempat Miqat', $html);
        $this->assertStringContainsString('modalTambahMiqat', $html);
        $this->assertStringContainsString('modalEditMiqat', $html);
    }

    public function testTambahMiqatValidationAndSuccess(): void
    {
        // 1. Validasi nama kosong
        $c1 = $this->createAdminController(['nama_miqat' => '']);
        $res1 = $c1->tambahMiqat();
        $this->assertSame(422, $res1->getStatusCode());
        $body1 = json_decode($res1->getBody(), true);
        $this->assertSame('error', $body1['status']);

        // 2. Berhasil tambah
        $uniqueName = 'Miqat Baru ' . bin2hex(random_bytes(4));
        $c2 = $this->createAdminController([
            'nama_miqat' => $uniqueName,
            'keterangan' => 'Keterangan uji coba',
        ]);
        $res2 = $c2->tambahMiqat();
        $this->assertSame(200, $res2->getStatusCode());
        $body2 = json_decode($res2->getBody(), true);
        $this->assertSame('success', $body2['status']);
        $newId = (int) $body2['data']['id'];

        // Verifikasi di DB
        $miqatModel = new TempatMiqatModel();
        $saved = $miqatModel->find($newId);
        $this->assertNotNull($saved);
        $this->assertSame($uniqueName, $saved['nama_miqat']);

        // 3. Duplikat ditolak
        $c3 = $this->createAdminController([
            'nama_miqat' => $uniqueName,
        ]);
        $res3 = $c3->tambahMiqat();
        $this->assertSame(422, $res3->getStatusCode());

        // Cleanup
        $miqatModel->delete($newId);
    }

    public function testEditMiqatValidationAndSuccess(): void
    {
        $miqatModel = new TempatMiqatModel();
        $initName = 'Miqat Edit Test ' . bin2hex(random_bytes(4));
        $id = (int) $miqatModel->insert([
            'nama_miqat' => $initName,
            'keterangan' => 'Sebelum edit',
        ]);

        // Edit dengan nama baru
        $updatedName = 'Miqat Telah Diedit ' . bin2hex(random_bytes(4));
        $controller = $this->createAdminController([
            'nama_miqat' => $updatedName,
            'keterangan' => 'Setelah edit',
        ]);
        $res = $controller->editMiqat($id);
        $this->assertSame(200, $res->getStatusCode());
        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);

        $updated = $miqatModel->find($id);
        $this->assertSame($updatedName, $updated['nama_miqat']);
        $this->assertSame('Setelah edit', $updated['keterangan']);

        // Edit not found
        $resNotFound = $controller->editMiqat(999999);
        $this->assertSame(404, $resNotFound->getStatusCode());

        // Cleanup
        $miqatModel->delete($id);
    }

    public function testHapusMiqat(): void
    {
        $miqatModel = new TempatMiqatModel();
        $id = (int) $miqatModel->insert([
            'nama_miqat' => 'Miqat Hapus ' . bin2hex(random_bytes(4)),
            'keterangan' => 'Akan dihapus',
        ]);

        $controller = $this->createAdminController();
        $res = $controller->hapusMiqat($id);
        $this->assertSame(200, $res->getStatusCode());
        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);

        // Verifikasi terhapus
        $this->assertNull($miqatModel->find($id));

        // Hapus ID yang sudah tidak ada -> 404
        $resNotFound = $controller->hapusMiqat($id);
        $this->assertSame(404, $resNotFound->getStatusCode());
    }
}
