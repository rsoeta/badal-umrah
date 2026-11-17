<?php

namespace Tests\Unit;

use App\Controllers\AdminController;
use App\Models\PendaftaranModel;
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
final class AdminProsesMiqatTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    public function testProsesSertifikatSavesTempatMiqatToDbAndGeneratesCert(): void
    {
        $pendaftaranModel = new PendaftaranModel();
        $testUuid = 'RCP-TEST-MIQAT-' . bin2hex(random_bytes(3));
        $id = (int) $pendaftaranModel->insert([
            'uuid'            => $testUuid,
            'nama_pemesan'    => 'Pemesan Miqat Test',
            'no_wa_pemesan'   => '081299998888',
            'nama_diumrahkan' => 'Alm. Haji Pengujian Miqat',
            'paket_pilihan'   => 'Paket Standar',
            'status'          => 'pending',
        ]);

        $postData = [
            'id_pendaftaran'  => (string) $id,
            'pelaksana_data'  => 'Ust. Azis Rustandi|ttd-azis.png',
            'tempat_miqat'    => 'Ji\'ranah, Makkah Al-Mukarramah',
            'tanggal_miqat'   => '2026-11-17',
            'tanggal_cetak'   => '2026-11-17',
            'koreksi_hijriah' => '0',
        ];

        $controller = new AdminController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request->setGlobal('post', $postData);
        $request->setGlobal('request', $postData);
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        $res = $controller->prosesSertifikat();
        $this->assertSame(200, $res->getStatusCode());

        $body = json_decode($res->getBody(), true);
        $this->assertSame('success', $body['status']);

        // Verifikasi database telah menyimpan tempat_miqat
        $updated = $pendaftaranModel->find($id);
        $this->assertSame('selesai', $updated['status']);
        $this->assertSame('Ji\'ranah, Makkah Al-Mukarramah', $updated['tempat_miqat']);

        // Verifikasi file sertifikat ter-generate
        $jpgPath = FCPATH . 'storage/certificates/' . $testUuid . '.jpg';
        $pdfPath = FCPATH . 'storage/certificates/' . $testUuid . '.pdf';
        $this->assertFileExists($jpgPath);
        $this->assertFileExists($pdfPath);

        // Verifikasi dashboard mengambil tempat_miqat dari database ter-group by
        $html = $controller->index();
        $this->assertIsString($html);
        $this->assertStringContainsString(esc('Ji\'ranah, Makkah Al-Mukarramah'), $html);

        // Clean up
        if (is_file($jpgPath)) @unlink($jpgPath);
        if (is_file($pdfPath)) @unlink($pdfPath);
        $pendaftaranModel->delete($id, true);
    }
}
