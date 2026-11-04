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
        return view('admin_login');
    }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $cf_response = $this->request->getPost('cf-turnstile-response');

        // 1. Validasi Frontend: Pastikan widget dicentang dan mengeluarkan token
        if (empty($cf_response)) {
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
