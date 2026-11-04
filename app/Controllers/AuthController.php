<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke admin
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin'));
        }
        return view('admin_login', ['isLocalhost' => $this->isLocalhost()]);
    }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $cf_response = $this->request->getPost('cf-turnstile-response');

        // Wajibkan token Turnstile di luar localhost development.
        if (! $this->isLocalhost() && empty($cf_response)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Verifikasi keamanan gagal! Harap tunggu/centang kotak Cloudflare.'
            ]);
        }

        // 2. BYPASS CURL KE CLOUDFLARE (Karena diblokir oleh server hosting)
        // Langsung lompat ke pengecekan Database
        $pengaturanModel = new \App\Models\PengaturanModel();

        $db_user = $pengaturanModel->getSetting('admin_username') ?? 'admin';
        $db_pass = $pengaturanModel->getSetting('admin_password');

        // Fallback jika database belum pernah di-setting
        if (empty($db_pass)) {
            $db_pass = password_hash('rahasia123', PASSWORD_DEFAULT);
        }

        // 3. Verifikasi Password
        if ($username === $db_user && password_verify($password, $db_pass)) {
            session()->set(['is_admin' => true]);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Login berhasil, mengalihkan...'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username atau Password salah!'
            ]);
        }
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
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
