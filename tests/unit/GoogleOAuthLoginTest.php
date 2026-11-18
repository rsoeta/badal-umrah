<?php

namespace Tests\Unit;

use App\Controllers\AuthController;
use App\Libraries\GoogleOAuth;
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
final class GoogleOAuthLoginTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    private function createAuthController(array $get = [], array $post = []): AuthController
    {
        $controller = new AuthController();
        $request = new IncomingRequest(new App(), service('uri'), null, new UserAgent());
        $request->setGlobal('get', $get);
        $request->setGlobal('post', $post);
        $request->setGlobal('request', array_merge($get, $post));
        $response = new Response(new App());
        $controller->initController($request, $response, Services::logger());

        return $controller;
    }

    public function testGoogleOAuthLibraryConfigurationAndUrls(): void
    {
        $oauth = new GoogleOAuth('test-client-id.apps.googleusercontent.com', 'test-client-secret', 'http://localhost:8080/login/google/callback');

        $this->assertTrue($oauth->isConfigured());
        $this->assertSame('test-client-id.apps.googleusercontent.com', $oauth->getClientId());
        $this->assertSame('test-client-secret', $oauth->getClientSecret());
        $this->assertSame('http://localhost:8080/login/google/callback', $oauth->getRedirectUri());

        $state = 'test_csrf_state_123';
        $authUrl = $oauth->getAuthUrl($state);

        $this->assertStringContainsString('https://accounts.google.com/o/oauth2/v2/auth', $authUrl);
        $this->assertStringContainsString('client_id=test-client-id.apps.googleusercontent.com', $authUrl);
        $this->assertStringContainsString('state=test_csrf_state_123', $authUrl);
        $this->assertStringContainsString('scope=' . urlencode('openid email profile'), $authUrl);
    }

    public function testGoogleOAuthEmailAuthorization(): void
    {
        $oauth = new GoogleOAuth('client', 'secret');
        $oauth->setAllowedEmails(['admin@badal.test', 'azis@badal.test']);

        $this->assertTrue($oauth->isEmailAuthorized('admin@badal.test'));
        $this->assertTrue($oauth->isEmailAuthorized('ADMIN@BADAL.TEST')); // Case-insensitive
        $this->assertTrue($oauth->isEmailAuthorized('azis@badal.test'));
        $this->assertFalse($oauth->isEmailAuthorized('intruder@gmail.com'));
        $this->assertFalse($oauth->isEmailAuthorized(''));

        // Whitelist kosong -> mengizinkan pendaftaran admin pertama kali
        $emptyWhitelistOauth = new GoogleOAuth('client', 'secret');
        $emptyWhitelistOauth->setAllowedEmails([]);
        $this->assertTrue($emptyWhitelistOauth->isEmailAuthorized('first-admin@gmail.com'));
    }

    public function testLoginIndexViewRendersGoogleButton(): void
    {
        session()->destroy();

        $controller = $this->createAuthController();
        $oauth = new GoogleOAuth('client-test-id', 'secret-test');
        $controller->setGoogleOAuth($oauth);

        $html = $controller->index();
        $this->assertIsString($html);
        $this->assertStringContainsString('Masuk dengan Google', $html);
        $this->assertStringContainsString(base_url('login/google'), $html);
    }

    public function testGoogleLoginRedirectsWithCsrfState(): void
    {
        session()->destroy();

        $controller = $this->createAuthController();
        $oauth = new GoogleOAuth('client-test-id', 'secret-test', 'http://localhost:8080/login/google/callback');
        $controller->setGoogleOAuth($oauth);

        $response = $controller->googleLogin();
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('Location'));

        $redirectUrl = $response->getHeaderLine('Location');
        $this->assertStringContainsString('https://accounts.google.com/o/oauth2/v2/auth', $redirectUrl);

        $savedState = session()->get('google_oauth_state');
        $this->assertNotEmpty($savedState);
        $this->assertStringContainsString('state=' . $savedState, $redirectUrl);
    }

    public function testGoogleCallbackRejectsInvalidState(): void
    {
        session()->destroy();
        session()->set('google_oauth_state', 'expected_state_abc');

        // State yang dikirim berbeda
        $controller = $this->createAuthController([
            'code'  => 'google_auth_code_xyz',
            'state' => 'wrong_state_123',
        ]);
        $oauth = new GoogleOAuth('client-test-id', 'secret-test');
        $controller->setGoogleOAuth($oauth);

        $response = $controller->googleCallback();
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('Location'));
        $this->assertStringContainsString(base_url('login'), $response->getHeaderLine('Location'));
        $this->assertFalse(session()->get('is_admin') ?? false);
        $this->assertNotEmpty(session()->getFlashdata('login_error'));
    }

    public function testGoogleCallbackSuccessfulLogin(): void
    {
        session()->destroy();
        $state = 'valid_state_secure_999';
        session()->set('google_oauth_state', $state);

        // Subclass mock GoogleOAuth untuk menguji pertukaran token & profil tanpa koneksi internet ke Google
        $mockOAuth = new class ('mock-id', 'mock-secret') extends GoogleOAuth {
            public function exchangeCode(string $code): ?array
            {
                if ($code === 'valid_code_abc') {
                    return ['access_token' => 'mock_access_token_token_123'];
                }

                return null;
            }

            public function getUserInfo(string $accessToken): ?array
            {
                if ($accessToken === 'mock_access_token_token_123') {
                    return [
                        'email'          => 'admin.terverifikasi@example.com',
                        'name'           => 'Ustadz Admin',
                        'picture'        => 'https://lh3.googleusercontent.com/photo.jpg',
                        'email_verified' => true,
                    ];
                }

                return null;
            }
        };
        $mockOAuth->setAllowedEmails(['admin.terverifikasi@example.com']);

        $controller = $this->createAuthController([
            'code'  => 'valid_code_abc',
            'state' => $state,
        ]);
        $controller->setGoogleOAuth($mockOAuth);

        $response = $controller->googleCallback();
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('Location'));
        $this->assertStringContainsString(base_url('admin'), $response->getHeaderLine('Location'));

        // Pastikan session admin berhasil diset
        $this->assertTrue(session()->get('is_admin'));
        $this->assertSame('admin.terverifikasi@example.com', session()->get('admin_email'));
        $this->assertSame('Ustadz Admin', session()->get('admin_name'));
        $this->assertSame('https://lh3.googleusercontent.com/photo.jpg', session()->get('admin_picture'));
        $this->assertSame('google', session()->get('auth_provider'));

        // Logout
        $logoutResponse = $controller->logout();
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $logoutResponse);
        $this->assertTrue($logoutResponse->hasHeader('Location'));
        $this->assertFalse(session()->get('is_admin') ?? false);
    }

    public function testGoogleCallbackRejectsUnauthorizedEmail(): void
    {
        session()->destroy();
        $state = 'valid_state_secure_999';
        session()->set('google_oauth_state', $state);

        $mockOAuth = new class ('mock-id', 'mock-secret') extends GoogleOAuth {
            public function exchangeCode(string $code): ?array
            {
                return ['access_token' => 'mock_token'];
            }

            public function getUserInfo(string $accessToken): ?array
            {
                return [
                    'email' => 'hacker@bukanadmin.com',
                    'name'  => 'Bukan Admin',
                ];
            }
        };
        $mockOAuth->setAllowedEmails(['admin.asli@example.com']);

        $controller = $this->createAuthController([
            'code'  => 'any_code',
            'state' => $state,
        ]);
        $controller->setGoogleOAuth($mockOAuth);

        $response = $controller->googleCallback();
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $response);
        $this->assertTrue($response->hasHeader('Location'));
        $this->assertStringContainsString(base_url('login'), $response->getHeaderLine('Location'));
        $this->assertFalse(session()->get('is_admin') ?? false);
        $this->assertStringContainsString('tidak terdaftar sebagai Administrator', session()->getFlashdata('login_error') ?? '');
    }

    public function testAdminDashboardHasTambahFotoPreviewElements(): void
    {
        $html = view('admin_dashboard', [
            'pendaftar'         => [],
            'jumlah_sampah'     => 0,
            'list_mutawwif'     => [],
            'koreksi_hijriah'   => 0,
            'list_tempat_miqat' => [],
        ]);

        $this->assertIsString($html);
        $this->assertStringContainsString('id="modalTambahPendaftar"', $html);
        $this->assertStringContainsString('id="tambahFotoJamaah"', $html);
        $this->assertStringContainsString('id="tambahFotoPreviewWrapper"', $html);
        $this->assertStringContainsString('id="tambahFotoPreview"', $html);
        $this->assertStringContainsString('id="btnHapusPreviewTambahFoto"', $html);
    }
}
