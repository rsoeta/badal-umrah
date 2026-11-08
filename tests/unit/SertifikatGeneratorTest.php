<?php

namespace Tests\Unit;

use App\Libraries\SertifikatGenerator;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class SertifikatGeneratorTest extends CIUnitTestCase
{
    private string $tempJpg;
    private string $tempPdf;

    protected function setUp(): void
    {
        parent::setUp();
        $token = bin2hex(random_bytes(8));
        $this->tempJpg = WRITEPATH . 'cache/test_cert_' . $token . '.jpg';
        $this->tempPdf = WRITEPATH . 'cache/test_cert_' . $token . '.pdf';
    }

    protected function tearDown(): void
    {
        if (is_file($this->tempJpg)) {
            @unlink($this->tempJpg);
        }
        if (is_file($this->tempPdf)) {
            @unlink($this->tempPdf);
        }
        parent::tearDown();
    }

    public function testGenerateSertifikatWithNomorRegistrasi(): void
    {
        $generator = new SertifikatGenerator();
        $generator->generate(
            'Ust. Azis Rustandi',
            'Alm. Fulan bin Fulan',
            '1 Ramadan 1448 H',
            '1 Maret 2026',
            '1 Ramadan 1448',
            '',
            $this->tempJpg,
            $this->tempPdf,
            null,
            'RCP-2026-ABC123'
        );

        $this->assertFileExists($this->tempJpg);
        $this->assertFileExists($this->tempPdf);
        $this->assertGreaterThan(10000, filesize($this->tempJpg));
        $this->assertGreaterThan(10000, filesize($this->tempPdf));
    }
}
