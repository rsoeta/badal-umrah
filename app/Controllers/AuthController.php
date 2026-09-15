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

        // 1. Verifikasi Cloudflare Turnstile
        // Cek apakah aplikasi sedang dalam mode 'development' di file .env
        if (env('CI_ENVIRONMENT') === 'development') {
            $cf_success = true; // Jalur VIP (Bypass) khusus localhost
        } else {
            $secret_key = env('0x4AAAAAAE2wCC_XpRi1wsoAfIe5BVQU4Ac'); // Ganti dengan Secret Key asli dari Cloudflare Turnstile
            $verify = curl_init();
            curl_setopt($verify, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query([
                'secret'   => $secret_key,
                'response' => $cf_response
            ]));
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false); // Jaga-jaga error SSL

            $response = curl_exec($verify);
            $result = json_decode($response);

            $cf_success = $result->success ?? false;
        }

        if (!$cf_success) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Verifikasi Cloudflare gagal! Pastikan Anda bukan robot.']);
        }

        // 2. Verifikasi Database (Menggunakan PengaturanModel)
        $pengaturanModel = new \App\Models\PengaturanModel();

        $db_user = $pengaturanModel->getSetting('admin_username');
        $db_pass = $pengaturanModel->getSetting('admin_password');

        // Jika data login belum pernah di-setting di database, buat otomatis (Default)
        if (!$db_user || !$db_pass) {
            $db_user = 'admin-badal';
            $db_pass = password_hash('tBwueF@f_8szpVz;', PASSWORD_DEFAULT);
            $pengaturanModel->insert(['setting_key' => 'admin_username', 'setting_value' => $db_user]);
            $pengaturanModel->insert(['setting_key' => 'admin_password', 'setting_value' => $db_pass]);
        }

        // 3. Pengecekan Kredensial dengan Password Hash
        if ($username === $db_user && password_verify($password, $db_pass)) {
            session()->set(['is_admin' => true]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Login berhasil...']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username atau Password salah!']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
