<?php

namespace App\Controllers;

use App\Libraries\GoogleOAuth;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected ?GoogleOAuth $googleOAuth = null;

    public function setGoogleOAuth(?GoogleOAuth $oauth): self
    {
        $this->googleOAuth = $oauth;

        return $this;
    }

    protected function getGoogleOAuth(): GoogleOAuth
    {
        if ($this->googleOAuth !== null) {
            return $this->googleOAuth;
        }

        return new GoogleOAuth();
    }

    public function index()
    {
        // Jika sudah login, langsung lempar ke admin
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin'));
        }

        $googleOAuth = $this->getGoogleOAuth();

        return view('admin_login', [
            'isLocalhost'      => $this->isLocalhost(),
            'googleConfigured' => $googleOAuth->isConfigured(),
            'loginError'       => session()->getFlashdata('login_error'),
            'loginSuccess'     => session()->getFlashdata('login_success'),
            'loginInfo'        => session()->getFlashdata('login_info'),
        ]);
    }

    public function googleLogin()
    {
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin'));
        }

        $googleOAuth = $this->getGoogleOAuth();

        if (! $googleOAuth->isConfigured()) {
            session()->setFlashdata('login_error', 'Google OAuth belum dikonfigurasi. Harap isi Google Client ID dan Secret di .env atau Pengaturan Admin.');

            return redirect()->to(base_url('login'));
        }

        $state = bin2hex(random_bytes(16));
        session()->set('google_oauth_state', $state);

        return redirect()->to($googleOAuth->getAuthUrl($state));
    }

    public function googleCallback()
    {
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin'));
        }

        // Cek jika ada error dari Google (misal user menekan "Cancel" atau menolak izin)
        $oauthError = $this->request->getGet('error');
        if (! empty($oauthError)) {
            log_message('notice', 'Google OAuth callback returned error: {error}', ['error' => $oauthError]);
            session()->setFlashdata('login_error', 'Proses masuk dengan Google dibatalkan.');

            return redirect()->to(base_url('login'));
        }

        $code = trim((string) $this->request->getGet('code'));
        $state = trim((string) $this->request->getGet('state'));
        $savedState = (string) session()->get('google_oauth_state');
        session()->remove('google_oauth_state');

        // Verifikasi state untuk proteksi CSRF
        if ($state === '' || $savedState === '' || ! hash_equals($savedState, $state)) {
            session()->setFlashdata('login_error', 'Validasi sesi keamanan Google tidak cocok atau kedaluwarsa. Silakan coba lagi.');

            return redirect()->to(base_url('login'));
        }

        if ($code === '') {
            session()->setFlashdata('login_error', 'Kode otorisasi dari Google tidak ditemukan.');

            return redirect()->to(base_url('login'));
        }

        $googleOAuth = $this->getGoogleOAuth();
        $tokenData = $googleOAuth->exchangeCode($code);

        if (! $tokenData || empty($tokenData['access_token'])) {
            session()->setFlashdata('login_error', 'Gagal menukarkan token dengan Google. Silakan coba beberapa saat lagi.');

            return redirect()->to(base_url('login'));
        }

        $userInfo = $googleOAuth->getUserInfo((string) $tokenData['access_token']);
        if (! $userInfo || empty($userInfo['email'])) {
            session()->setFlashdata('login_error', 'Gagal memperoleh data akun Google Anda.');

            return redirect()->to(base_url('login'));
        }

        $email = strtolower(trim((string) $userInfo['email']));
        $name = trim((string) ($userInfo['name'] ?? ''));
        $picture = trim((string) ($userInfo['picture'] ?? ''));

        // Cek otorisasi email admin
        if (! $googleOAuth->isEmailAuthorized($email)) {
            session()->setFlashdata('login_error', "Akses Ditolak: Akun Google ({$email}) tidak terdaftar sebagai Administrator Badal Umrah.");

            return redirect()->to(base_url('login'));
        }

        // Jika whitelist masih kosong sebelumnya, daftarkan email ini sebagai admin utama
        if (empty($googleOAuth->getAllowedEmails())) {
            $googleOAuth->registerInitialAdminEmail($email);
        }

        // Set sesi Admin
        session()->set([
            'is_admin'      => true,
            'admin_email'   => $email,
            'admin_name'    => $name !== '' ? $name : $email,
            'admin_picture' => $picture !== '' ? $picture : null,
            'auth_provider' => 'google',
        ]);

        session()->setFlashdata('login_success', 'Selamat datang, ' . ($name !== '' ? $name : $email) . '!');

        return redirect()->to(base_url('admin'));
    }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $cf_response = $this->request->getPost('cf-turnstile-response');

        // Wajibkan token Turnstile di luar localhost development.
        if (! $this->isLocalhost() && empty($cf_response)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Verifikasi keamanan gagal! Harap tunggu/centang kotak Cloudflare.',
            ]);
        }

        // Langsung lompat ke pengecekan Database
        $pengaturanModel = new \App\Models\PengaturanModel();

        $db_user = $pengaturanModel->getSetting('admin_username') ?? 'admin';
        $db_pass = $pengaturanModel->getSetting('admin_password');

        // Fallback jika database belum pernah di-setting
        if (empty($db_pass)) {
            $db_pass = password_hash('rahasia123', PASSWORD_DEFAULT);
        }

        // Verifikasi Password
        if ($username === $db_user && password_verify($password, $db_pass)) {
            session()->set([
                'is_admin'      => true,
                'admin_name'    => $username,
                'auth_provider' => 'password',
            ]);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Login berhasil, mengalihkan...',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Username atau Password salah!',
        ]);
    }

    private function isLocalhost(): bool
    {
        if (ENVIRONMENT !== 'development') {
            return false;
        }

        $host = trim(strtolower((string) parse_url(
            'http://' . $this->request->getServer('HTTP_HOST'),
            PHP_URL_HOST
        )), '[]');

        return in_array($host, ['localhost', '127.0.0.1', '::1'], true)
            && in_array($this->request->getIPAddress(), ['127.0.0.1', '::1'], true);
    }

    public function logout()
    {
        session()->remove(['is_admin', 'admin_email', 'admin_name', 'admin_picture', 'auth_provider']);
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}
