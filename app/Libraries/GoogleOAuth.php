<?php

namespace App\Libraries;

use App\Models\PengaturanModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\CURLRequest;

class GoogleOAuth
{
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected string $redirectUri = '';
    /** @var list<string> */
    protected array $allowedEmails = [];
    protected ?CURLRequest $httpClient = null;

    public function __construct(
        ?string $clientId = null,
        ?string $clientSecret = null,
        ?string $redirectUri = null,
        ?CURLRequest $httpClient = null
    ) {
        $pengaturanModel = new PengaturanModel();

        // 1. Client ID: prioritaskan parameter, lalu env, lalu database pengaturan
        $this->clientId = trim((string) (
            $clientId
            ?? env('google.clientId')
            ?? env('GOOGLE_CLIENT_ID')
            ?? ($pengaturanModel->getSetting('google_client_id') ?? '')
        ));

        // 2. Client Secret: prioritaskan parameter, lalu env, lalu database pengaturan
        $this->clientSecret = trim((string) (
            $clientSecret
            ?? env('google.clientSecret')
            ?? env('GOOGLE_CLIENT_SECRET')
            ?? ($pengaturanModel->getSetting('google_client_secret') ?? '')
        ));

        // 3. Redirect URI: prioritaskan parameter, lalu database, lalu env, lalu deteksi host aktif
        $dbRedirect  = $pengaturanModel->getSetting('google_redirect_uri');
        $envRedirect = env('google.redirectUri') ?? env('GOOGLE_REDIRECT_URI');

        if (! empty($redirectUri)) {
            $this->redirectUri = trim($redirectUri);
        } elseif (! empty($dbRedirect)) {
            $this->redirectUri = trim($dbRedirect);
        } elseif (! empty($envRedirect)) {
            $this->redirectUri = trim((string) $envRedirect);
        } else {
            $this->redirectUri = self::detectCurrentRedirectUri();
        }

        // 4. Allowed Emails: ambil dari env dan database
        $rawEnv = (string) (env('google.allowedEmails') ?? env('GOOGLE_ALLOWED_EMAILS') ?? '');
        $rawDb  = (string) ($pengaturanModel->getSetting('google_admin_emails')
            ?? $pengaturanModel->getSetting('admin_email')
            ?? '');

        $combined = array_merge(
            preg_split('/[\r\n,]+/', $rawEnv) ?: [],
            preg_split('/[\r\n,]+/', $rawDb) ?: []
        );

        $clean = [];
        foreach ($combined as $email) {
            $e = strtolower(trim($email));
            if ($e !== '' && filter_var($e, FILTER_VALIDATE_EMAIL)) {
                $clean[] = $e;
            }
        }

        $this->allowedEmails = array_values(array_unique($clean));
        $this->httpClient = $httpClient;
    }

    public function isConfigured(): bool
    {
        return $this->clientId !== '' && $this->clientSecret !== '';
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        $this->clientId = trim($clientId);

        return $this;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function setClientSecret(string $clientSecret): self
    {
        $this->clientSecret = trim($clientSecret);

        return $this;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(string $uri): self
    {
        $this->redirectUri = trim($uri);

        return $this;
    }

    /**
     * Mendeteksi Redirect URI secara dinamis berdasarkan host, protokol, dan port yang sedang aktif
     */
    public static function detectCurrentRedirectUri(): string
    {
        $request = Services::request();
        $host = $request->getServer('HTTP_HOST');

        if (! empty($host)) {
            $isHttps = $request->isSecure()
                || strtolower((string) $request->getServer('HTTPS')) === 'on'
                || strtolower((string) $request->getServer('HTTP_X_FORWARDED_PROTO')) === 'https';
            $scheme = $isHttps ? 'https' : 'http';

            return "{$scheme}://{$host}/login/google/callback";
        }

        return rtrim(base_url(), '/') . '/login/google/callback';
    }

    /**
     * @return list<string>
     */
    public function getAllowedEmails(): array
    {
        return $this->allowedEmails;
    }

    /**
     * @param list<string> $emails
     */
    public function setAllowedEmails(array $emails): self
    {
        $clean = [];
        foreach ($emails as $email) {
            $e = strtolower(trim($email));
            if ($e !== '') {
                $clean[] = $e;
            }
        }
        $this->allowedEmails = array_values(array_unique($clean));

        return $this;
    }

    public function setHttpClient(?CURLRequest $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    protected function getHttpClient(): CURLRequest
    {
        if ($this->httpClient !== null) {
            return $this->httpClient;
        }

        return Services::curlrequest([
            'timeout'         => 15,
            'http_errors'     => false,
            'allow_redirects' => false,
        ]);
    }

    /**
     * Membuat Google OAuth 2.0 Authorization URL
     */
    public function getAuthUrl(string $state): string
    {
        $params = [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
            'access_type'   => 'online',
            'prompt'        => 'select_account',
        ];

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }

    /**
     * Menukar Authorization Code dari callback dengan Access Token & ID Token
     *
     * @return array<string, mixed>|null
     */
    public function exchangeCode(string $code): ?array
    {
        if (! $this->isConfigured() || trim($code) === '') {
            return null;
        }

        try {
            $client = $this->getHttpClient();
            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'code'          => $code,
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri'  => $this->redirectUri,
                    'grant_type'    => 'authorization_code',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                log_message('error', 'Google OAuth token exchange failed [{code}]: {body}', [
                    'code' => $response->getStatusCode(),
                    'body' => $response->getBody(),
                ]);

                return null;
            }

            $data = json_decode($response->getBody(), true);

            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            log_message('error', 'Google OAuth exchangeCode exception: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Mengambil informasi profil Google pengguna dari Access Token
     *
     * @return array<string, mixed>|null
     */
    public function getUserInfo(string $accessToken): ?array
    {
        if (trim($accessToken) === '') {
            return null;
        }

        try {
            $client = $this->getHttpClient();
            $response = $client->get('https://www.googleapis.com/oauth2/v3/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept'        => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                log_message('error', 'Google OAuth getUserInfo failed [{code}]: {body}', [
                    'code' => $response->getStatusCode(),
                    'body' => $response->getBody(),
                ]);

                return null;
            }

            $data = json_decode($response->getBody(), true);

            return is_array($data) ? $data : null;
        } catch (\Throwable $e) {
            log_message('error', 'Google OAuth getUserInfo exception: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Memeriksa apakah email Google yang login diizinkan sebagai Administrator
     */
    public function isEmailAuthorized(string $email): bool
    {
        $normalized = strtolower(trim($email));
        if ($normalized === '') {
            return false;
        }

        // Jika whitelist belum pernah diset sama sekali di database dan env,
        // izinkan login pertama kali untuk mendaftarkan akun admin awal
        if (empty($this->allowedEmails)) {
            return true;
        }

        return in_array($normalized, $this->allowedEmails, true);
    }

    /**
     * Menyimpan email admin pertama ke tabel pengaturan jika whitelist belum ada
     */
    public function registerInitialAdminEmail(string $email): void
    {
        $normalized = strtolower(trim($email));
        if ($normalized === '' || ! filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $pengaturanModel = new PengaturanModel();
        $existing = $pengaturanModel->where('setting_key', 'google_admin_emails')->first();
        if (! $existing) {
            $pengaturanModel->insert([
                'setting_key'   => 'google_admin_emails',
                'setting_value' => $normalized,
            ]);
        } elseif (trim((string) $existing['setting_value']) === '') {
            $pengaturanModel->update($existing['id'], [
                'setting_value' => $normalized,
            ]);
        }

        $this->allowedEmails[] = $normalized;
        $this->allowedEmails = array_values(array_unique($this->allowedEmails));
    }
}
