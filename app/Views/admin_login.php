<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login Admin - Badal Umrah</title>
    <meta name="title" content="Login Admin - Badal Umrah">
    <meta name="description" content="Masuk ke Panel Administrasi Layanan Badal Umrah dengan Google OAuth.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('login'); ?>">
    <meta property="og:title" content="Login Admin - Badal Umrah">
    <meta property="og:description" content="Masuk ke Panel Administrasi Layanan Badal Umrah dengan Google OAuth.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Login Admin - Badal Umrah">
    <meta name="twitter:description" content="Masuk ke Panel Administrasi Layanan Badal Umrah dengan Google OAuth.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if (! $isLocalhost): ?>
        <!-- Cloudflare Turnstile -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .login-shell {
            width: 100%;
            max-width: 460px;
            margin: auto;
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background-color: var(--card-3);
            color: var(--ink);
            border: 0;
            box-shadow: inset 0 0 0 1px var(--glass-rim), inset 1px 1px 0 var(--glass-top), var(--shadow-sm);
            border-radius: 50px;
            padding: 12px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-google:hover {
            background-color: var(--accent);
            color: var(--accent-ink);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            transform: translateY(-1px);
        }

        .google-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0 1rem;
        }

        .divider-container::before,
        .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--glass-rim);
        }

        .divider-text {
            padding: 0 12px;
            color: var(--muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .swal-mobile-custom {
            font-size: 0.8rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
            border-radius: 12px !important;
        }

        .swal-title-custom {
            font-size: 1rem !important;
            font-weight: 700 !important;
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame" style="justify-content: center;">
        <div class="login-shell">
            <!-- Top mini controls -->
            <div class="sg-topbar mb-3">
                <a href="<?= base_url('/'); ?>" class="sg-brand" aria-label="Beranda Azis Rustandi">
                    <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Badal Umrah" class="sg-brand__logo">
                    <div class="sg-brand__meta">
                        <span class="sg-brand__name">Badal Umrah</span>
                        <span class="sg-brand__sub">Admin Authentication</span>
                    </div>
                </a>
                <div class="sg-actions">
                    <?= $this->include('partials/smoked_glass_customizer'); ?>
                </div>
            </div>

            <main id="main-content" class="sg-pane sg-main">
                <div class="sg-card sg-card--highlight">
                    <!-- Brand Header -->
                    <div class="text-center mb-4">
                        <h1 class="sg-h1" style="font-size: 1.85rem;">Admin Panel</h1>
                        <p class="sg-text-muted small mb-0">Masuk untuk mengelola pendaftaran dan sertifikat</p>
                    </div>

                    <!-- Flash Message Alert -->
                    <?php if (! empty($loginError)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 small mb-3 shadow-sm d-flex align-items-start gap-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                            <div><?= esc($loginError); ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($loginSuccess)): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 small mb-3 shadow-sm d-flex align-items-start gap-2" role="alert">
                            <i class="fa-solid fa-circle-check mt-1"></i>
                            <div><?= esc($loginSuccess); ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Google OAuth Section (Metode Utama) -->
                    <div class="mb-3">
                        <?php if ($googleConfigured): ?>
                            <a href="<?= base_url('login/google'); ?>" class="btn-google w-100">
                                <svg class="google-icon" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                </svg>
                                <span>Masuk dengan Google</span>
                            </a>
                            <div class="text-center mt-2">
                                <span class="sg-text-muted" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-shield-halved text-success me-1"></i>Otentikasi aman via Google OAuth
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="sg-subpanel text-center">
                                <div class="text-warning mb-2"><i class="fa-solid fa-triangle-exclamation fa-2x"></i></div>
                                <h2 class="fw-bold sg-text-ink mb-1" style="font-size: 0.9rem;">Google OAuth Belum Dikonfigurasi</h2>
                                <p class="sg-text-muted small mb-2" style="font-size: 0.75rem;">
                                    Lengkapi <code>google.clientId</code> dan <code>google.clientSecret</code> di <code>.env</code> atau Pengaturan Admin untuk mengaktifkan login Google.
                                </p>
                                <a href="#formManualCollapse" data-bs-toggle="collapse" class="sg-btn sg-btn--glass btn-sm py-1 px-3" style="font-size: 0.75rem;">
                                    Gunakan Kredensial Sistem
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Divider Opsi Alternatif -->
                    <div class="divider-container">
                        <span class="divider-text">atau</span>
                    </div>

                    <div class="text-center mb-3">
                        <a class="text-decoration-none sg-text-muted small fw-medium" data-bs-toggle="collapse" href="#formManualCollapse" role="button" aria-expanded="<?= ! $googleConfigured ? 'true' : 'false'; ?>" aria-controls="formManualCollapse">
                            <i class="fa-solid fa-key me-1"></i> Masuk dengan Kredensial Sistem <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                        </a>
                    </div>

                    <!-- Form Manual (Collapsible Fallback) -->
                    <div class="collapse <?= ! $googleConfigured ? 'show' : ''; ?>" id="formManualCollapse">
                        <form id="formLogin" class="sg-subpanel mb-3">
                            <div class="mb-3">
                                <label for="loginUsername" class="form-label small fw-bold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input id="loginUsername" type="text" name="username" class="form-control" required placeholder="Username admin">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="loginPassword" class="form-label small fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input id="loginPassword" type="password" name="password" class="form-control" required placeholder="Password admin">
                                </div>
                            </div>

                            <?php if (! $isLocalhost): ?>
                                <!-- Widget Cloudflare Turnstile -->
                                <div class="cf-turnstile mb-3 d-flex justify-content-center" data-sitekey="0x4AAAAAAE2wCBIBbm825VPi"></div>
                            <?php endif; ?>

                            <button type="submit" id="btnSubmitManual" class="sg-btn sg-btn--sig w-100">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk
                            </button>
                        </form>
                    </div>

                    <!-- Footer Link -->
                    <div class="text-center mt-3 pt-2 border-top">
                        <a href="<?= base_url('/'); ?>" class="sg-text-muted text-decoration-none small">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Web Utama
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let btn = document.getElementById('btnSubmitManual');
            btn.disabled = true;

            Swal.fire({
                title: 'Otentikasi...',
                text: 'Memeriksa kredensial akun.',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('login/proses') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Akses Diberikan!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        }).then(() => {
                            window.location.href = '<?= base_url('admin') ?>';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Akses Ditolak',
                            text: data.message,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        });
                        if (typeof turnstile !== 'undefined') turnstile.reset();
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                    console.error(error);
                    if (typeof turnstile !== 'undefined') turnstile.reset();
                });
        });
    </script>
</body>

</html>
