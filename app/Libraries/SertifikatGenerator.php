<?php

namespace App\Libraries;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SertifikatGenerator
{
    public function generate(
        string $namaPelaksana,
        string $namaDiumrahkan,
        string $tanggalMiqat,
        string $tanggalCetakMasehi,
        string $tanggalCetakHijriah,
        string $fileTtd,
        string $outputJpg,
        string $outputPdf
    ): void {
        $templatePath = FCPATH . 'templates/template_sertifikat.png';
        $fontPath = FCPATH . 'fonts/Amiri-Bold.ttf';
        $manager = new ImageManager(new Driver());
        $image = $manager->read($templatePath);

        $writeText = static function ($text, $x, $y, $align, $size, $color = '#000000') use ($image, $fontPath): void {
            $image->text($text, $x, $y, static function ($font) use ($fontPath, $size, $color, $align): void {
                $font->file($fontPath);
                $font->size($size);
                $font->color($color);
                $font->align($align);
                $font->valign('middle');
            });
        };

        $writeText($namaPelaksana, 706, 899, 'center', 42);
        $writeText($namaDiumrahkan, 706, 1078, 'center', 42);
        $writeText($tanggalMiqat, 489, 1262, 'left', 36);
        // The template already prints "M /" and "H" between these date fields.
        $writeText($tanggalCetakMasehi, 821, 1588, 'left', 30);
        $writeText($tanggalCetakHijriah, 1120, 1588, 'left', 30);

        $witnessSignaturePath = FCPATH . 'signatures/ttd-rian.png';
        if (is_file($witnessSignaturePath)) {
            $witnessSignature = $manager->read($witnessSignaturePath);
            $witnessSignature->trim()->scale(width: 370);
            $image->place($witnessSignature, 'top-left', 185, 1615);
        }

        if ($fileTtd !== '') {
            $signaturePath = FCPATH . 'signatures/' . $fileTtd;
            if (is_file($signaturePath)) {
                $signature = $manager->read($signaturePath);
                $signature->trim()->resize(230, 170);
                $image->place($signature, 'top-left', 1000 + rand(-8, 8), 1615 + rand(-8, 8));
            }
        }

        $stampPath = FCPATH . 'templates/stempel.png';
        if (is_file($stampPath)) {
            $stamp = $manager->read($stampPath);
            $stamp->scale(width: 190);
            $stamp->rotate(rand(-4, 4), 'transparent');
            $image->place($stamp, 'top-left', 910 + rand(-5, 5), 1610 + rand(-5, 5));
        }

        $image->save($outputJpg, 90);

        $pageWidth = 210;
        $pageHeight = 297;
        $scale = min($pageWidth / $image->width(), $pageHeight / $image->height());
        $imageWidth = $image->width() * $scale;
        $imageHeight = $image->height() * $scale;

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();
        $pdf->Image(
            $outputJpg,
            ($pageWidth - $imageWidth) / 2,
            ($pageHeight - $imageHeight) / 2,
            $imageWidth,
            $imageHeight
        );
        $pdf->Output('F', $outputPdf);
    }
}
