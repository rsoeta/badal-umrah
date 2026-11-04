<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Master - Badal Umrah</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/brand-logo.png'); ?>" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Pengaturan Font Responsif Global (Mempengaruhi seluruh satuan REM Bootstrap) */
        html {
            font-size: 16px;
        }

        /* Ukuran Normal di Laptop */

        @media (max-width: 767.98px) {
            html {
                font-size: 13.5px;
            }

            /* Mengecil serentak di HP */
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Quicksand', sans-serif;
            color: #333;
        }

        .navbar-admin {
            background-color: #0f3d23;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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

        .swal-btn-custom {
            padding: 6px 14px !important;
            font-size: 0.8rem !important;
            border-radius: 6px !important;
        }

        @media (max-width: 767.98px) {
            body {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-admin shadow-sm mb-4">
        <div class="container-fluid px-md-4">
            <a class="navbar-brand mb-0 h1 fs-5 text-white text-decoration-none" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-kaaba me-2 text-warning"></i> Admin Panel
            </a>
            <div class="d-flex gap-2 align-items-center">
                <a href="<?= base_url('admin'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> <span class="d-none d-sm-inline">Kembali</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-md-4 pb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold">Pengaturan Data Master</h5>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card card-custom mb-4 border-top border-warning border-4">
                    <div class="card-body p-4">
                        <form id="formPengaturan">

                            <!-- Setting: List Mutawwif -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark"><i class="fa-solid fa-users me-2 text-success"></i> Daftar Mutawwif & File TTD</label>
                                <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                    Format pengisian: <b>Nama Ustadz|namafile.png</b> <br>
                                    Pisahkan mutawwif baru dengan <b>Baris Baru (Enter)</b>. Pastikan file TTD sudah di-upload ke folder <code>public/signatures/</code>.
                                </p>
                                <textarea name="list_mutawwif" class="form-control rounded-3" rows="5" required><?= esc($list_mutawwif); ?></textarea>
                            </div>

                            <!-- Setting: Kredensial Akun -->
                            <div class="mb-4 pt-3 border-top border-light border-2">
                                <label class="form-label fw-bold text-dark"><i class="fa-solid fa-lock me-2 text-danger"></i> Kredensial Login Admin</label>
                                <p class="text-muted mb-3" style="font-size: 0.75rem;">Ubah username dan password untuk masuk ke halaman admin. Kosongkan kolom password jika tidak ingin mengubahnya.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Username Baru</label>
                                        <input type="text" name="admin_username" class="form-control rounded-3" value="<?= esc($admin_username); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Password Baru</label>
                                        <input type="password" name="admin_password" class="form-control rounded-3" placeholder="Isi untuk mengganti password">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm w-100 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('formPengaturan').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('admin/pengaturan/simpan') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        });
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Terjadi kendala sistem.', 'error');
                    console.error(error);
                });
        });
    </script>
</body>

</html>