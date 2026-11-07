<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Azis Rustandi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php if (! $isLocalhost): ?>
        <!-- Cloudflare Turnstile -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #0f3d23;
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-top: 6px solid #b8924b;
        }

        /* Custom SweetAlert Mobile-friendly */
        .swal-mobile-custom {
            font-size: 0.8rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
            border-radius: 12px !important;
        }

        .swal-title-custom {
            font-size: 1rem !important;
            font-family: 'Quicksand', sans-serif !important;
            font-weight: 700 !important;
        }
    </style>
</head>

<body>

    <div class="container px-3 d-flex justify-content-center">
        <div class="login-card">
            <div class="text-center mb-4">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Azis Rustandi" style="height: 60px; object-fit: contain;" class="mb-3">
                <h4 class="fw-bold text-dark mb-0">Admin Panel</h4>
                <p class="text-muted small">Silakan login untuk kelola sertifikat</p>
            </div>

            <form id="formLogin">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                    </div>
                </div>

                <?php if (! $isLocalhost): ?>
                    <!-- Widget Cloudflare Turnstile -->
                    <div class="cf-turnstile mb-3 d-flex justify-content-center" data-sitekey="0x4AAAAAAE2wCBIBbm825VPi"></div>
                <?php else: ?>
                    <p class="text-muted small text-center">Verifikasi Cloudflare dilewati di localhost.</p>
                <?php endif; ?>

                <button type="submit" class="btn w-100 fw-bold shadow-sm" style="background-color: #b8924b; color: white;">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Sistem
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="<?= base_url('/'); ?>" class="text-muted text-decoration-none small"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Web Utama</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Otentikasi...',
                text: 'Memeriksa kredensial dan keamanan.',
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
                        // Reset Turnstile jika gagal agar bisa dicoba lagi
                        if (typeof turnstile !== 'undefined') turnstile.reset();
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                    console.error(error);
                    if (typeof turnstile !== 'undefined') turnstile.reset();
                });
        });
    </script>
</body>

</html>