<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class SmokedGlassDesignSystemTest extends CIUnitTestCase
{
    public function testSmokedGlassAssetsAndOptimizationTrickExist(): void
    {
        $cssPath = FCPATH . 'css/smoked-glass.css';
        $jsPath = FCPATH . 'js/smoked-glass.js';
        $bgSharp = FCPATH . 'img/bg-haram.jpg';
        $bgBlur = FCPATH . 'img/bg-haram-blur.jpg';

        $this->assertFileExists($cssPath);
        $this->assertFileExists($jsPath);
        $this->assertFileExists($bgSharp);
        $this->assertFileExists($bgBlur);

        $css = file_get_contents($cssPath);
        $this->assertStringContainsString('--frost:', $css);
        $this->assertStringContainsString('--sheet:', $css);
        $this->assertStringContainsString('--card:', $css);
        $this->assertStringContainsString('.sg-bg-layer::before', $css);
        $this->assertStringContainsString('.sg-bg-layer::after', $css);
        $this->assertStringContainsString('bg-haram-blur.jpg', $css);
        $this->assertStringContainsString('mask-image', $css);
        $this->assertStringContainsString('prefers-reduced-motion', $css);
        $this->assertStringContainsString('prefers-reduced-transparency', $css);
        $this->assertStringContainsString('.sg-topbar::before', $css);
        $this->assertStringContainsString('.sg-nav .tabbar__pill', $css);

        $js = file_get_contents($jsPath);
        $this->assertStringContainsString('syncTabbarPills', $js);
        $this->assertStringContainsString('instanceof Element', $js);
    }

    public function testViewsRenderWithSmokedGlassShell(): void
    {
        $viewSamples = [
            ['home', []],
            ['pendaftaran_form', []],
            ['sertifikat_form', ['list_miqat' => [], 'default_miqat' => "Tan'im, Makkah Al-Mukarramah"]],
            ['admin_login', ['isLocalhost' => true, 'googleConfigured' => false, 'loginError' => '', 'loginSuccess' => '']],
            ['admin_trash', ['pendaftar' => []]],
            ['admin_dashboard', ['pendaftar' => [], 'jumlah_sampah' => 0, 'list_mutawwif' => [], 'koreksi_hijriah' => 0, 'list_tempat_miqat' => []]],
        ];

        foreach ($viewSamples as [$viewName, $data]) {
            $html = view($viewName, $data);
            $this->assertStringContainsString('css/smoked-glass.css', $html, "Missing CSS in $viewName");
            $this->assertStringContainsString('js/smoked-glass.js', $html, "Missing JS in $viewName");
            $this->assertStringContainsString('bg-haram-blur.jpg', $html, "Missing background preload in $viewName");
            $this->assertStringContainsString('class="sg-bg-layer"', $html, "Missing .sg-bg-layer in $viewName");
            $this->assertStringContainsString('id="sgGlassPopover"', $html, "Missing Adjust Glass popover in $viewName");
        }
    }

    public function testNavigationIncludesMobileTabbarPill(): void
    {
        $homeHtml = view('home');
        $this->assertStringContainsString('class="sg-nav"', $homeHtml);
        $this->assertStringContainsString('class="tabbar__pill"', $homeHtml);

        $trashHtml = view('admin_trash', ['pendaftar' => []]);
        $this->assertStringContainsString('aria-label="Menu Admin"', $trashHtml);
        $this->assertStringContainsString('class="tabbar__pill"', $trashHtml);

        $dashHtml = view('admin_dashboard', [
            'pendaftar'         => [],
            'jumlah_sampah'     => 2,
            'list_mutawwif'     => [],
            'koreksi_hijriah'   => 0,
            'list_tempat_miqat' => [],
        ]);
        $this->assertStringContainsString('aria-label="Menu Admin"', $dashHtml);
        $this->assertStringContainsString('class="tabbar__pill"', $dashHtml);
        $this->assertStringContainsString('class="sg-nav__count"', $dashHtml);
    }

    public function testPwaManifestIconsServiceWorkerAndHeadTags(): void
    {
        $manifestPath = FCPATH . 'manifest.json';
        $swPath = FCPATH . 'sw.js';
        $offlinePath = FCPATH . 'offline.html';

        $this->assertFileExists($manifestPath);
        $this->assertFileExists($swPath);
        $this->assertFileExists($offlinePath);

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $this->assertIsArray($manifest);
        $this->assertSame('standalone', $manifest['display']);
        $this->assertSame('Badal Umrah — Azis Rustandi', $manifest['name']);
        $this->assertSame('Badal Umrah', $manifest['short_name']);

        $iconFiles = [
            'icons/icon-192x192.png'          => [192, 192],
            'icons/icon-512x512.png'          => [512, 512],
            'icons/icon-maskable-512x512.png' => [512, 512],
            'icons/apple-touch-icon-180x180.png' => [180, 180],
        ];
        foreach ($iconFiles as $relPath => [$expectedW, $expectedH]) {
            $fullPath = FCPATH . $relPath;
            $this->assertFileExists($fullPath);
            $size = getimagesize($fullPath);
            $this->assertSame($expectedW, $size[0]);
            $this->assertSame($expectedH, $size[1]);
        }

        $sw = file_get_contents($swPath);
        $this->assertStringContainsString('offline.html', $sw);
        $this->assertStringContainsString('/admin', $sw);
        $this->assertStringContainsString('/login', $sw);
        $this->assertStringContainsString('/storage/', $sw);
        $this->assertStringContainsString('stream', $sw);
        $this->assertStringContainsString("request.method !== 'GET'", $sw);

        $homeHtml = view('home');
        $this->assertStringContainsString('rel="manifest"', $homeHtml);
        $this->assertStringContainsString('manifest.json', $homeHtml);
        $this->assertStringContainsString('name="apple-mobile-web-app-capable"', $homeHtml);
        $this->assertStringContainsString('rel="apple-touch-icon"', $homeHtml);
        $this->assertStringContainsString('apple-touch-icon-180x180.png', $homeHtml);
        $this->assertStringContainsString('icon-192x192.png', $homeHtml);
        $this->assertStringContainsString('icon-512x512.png', $homeHtml);
        $this->assertStringContainsString('name="sg-sw-url"', $homeHtml);

        $js = file_get_contents(FCPATH . 'js/smoked-glass.js');
        $this->assertStringContainsString('navigator.serviceWorker', $js);
    }
}
