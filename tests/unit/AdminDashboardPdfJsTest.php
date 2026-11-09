<?php

namespace Tests\Unit;

use App\Models\PendaftaranModel;
use App\Models\PengaturanModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class AdminDashboardPdfJsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    public function testViewSourceContainsPdfJsAndNoIframe(): void
    {
        $viewPath = APPPATH . 'Views/admin_dashboard.php';
        $this->assertFileExists($viewPath);

        $content = file_get_contents($viewPath);

        // Pastikan library Mozilla PDF.js di-include
        $this->assertStringContainsString('cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js', $content);
        $this->assertStringContainsString('cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js', $content);

        // Pastikan kontainer canvas Mozilla PDF.js ada
        $this->assertStringContainsString('id="pdfViewerWrapper"', $content);
        $this->assertStringContainsString('id="pdfPagesContainer"', $content);
        $this->assertStringContainsString('id="pdfLoadingSpinner"', $content);
        $this->assertStringContainsString('id="pdfErrorNotice"', $content);

        // Pastikan kontrol zoom ada
        $this->assertStringContainsString('id="btnPdfZoomIn"', $content);
        $this->assertStringContainsString('id="btnPdfZoomOut"', $content);
        $this->assertStringContainsString('id="btnPdfZoomFit"', $content);
        $this->assertStringContainsString('id="pdfZoomLabel"', $content);

        // Pastikan iframe lama sudah diganti
        $this->assertStringNotContainsString('id="iframePreviewPdf"', $content);
    }

    public function testDashboardViewRendersCleanly(): void
    {
        $data = [
            'pendaftar'       => [
                [
                    'id'               => 1,
                    'uuid'             => 'RCP-2026-TEST01',
                    'nama_pemesan'     => 'Pemesan Uji',
                    'no_wa_pemesan'    => '08123456789',
                    'nama_diumrahkan'  => 'Alm. Uji Jamaah',
                    'paket_pilihan'    => 'Paket Badal Umrah Spesial',
                    'status'           => 'selesai',
                    'foto_jamaah'      => '',
                    'nama_pelaksana'   => 'Ust. Ahmad',
                    'tanggal_selesai'  => '2026-11-09',
                    'created_at'       => '2026-11-09 10:00:00',
                    'video_count'      => 3,
                ],
            ],
            'koreksi_hijriah' => 0,
            'jumlah_sampah'   => 2,
            'list_mutawwif'   => ['Ust. Ahmad Fadil|ttd-ahmad.png'],
        ];

        $html = view('admin_dashboard', $data);

        $this->assertStringContainsString('pdf.min.js', $html);
        $this->assertStringContainsString('id="pdfViewerWrapper"', $html);
        $this->assertStringContainsString('id="pdfPagesContainer"', $html);
        $this->assertStringContainsString('Alm. Uji Jamaah', $html);
        $this->assertStringContainsString('RCP-2026-TEST01', $html);
    }
}
