<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Master - Badal Umrah</title>
    <meta name="title" content="Pengaturan Master - Badal Umrah">
    <meta name="description" content="Pengaturan master sistem Badal Umrah, daftar mutawwif, dan konfigurasi kalender Hijriah.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('admin/pengaturan'); ?>">
    <meta property="og:title" content="Pengaturan Master - Badal Umrah">
    <meta property="og:description" content="Pengaturan master sistem Badal Umrah, daftar mutawwif, dan konfigurasi kalender Hijriah.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Pengaturan Master - Badal Umrah">
    <meta name="twitter:description" content="Pengaturan master sistem Badal Umrah, daftar mutawwif, dan konfigurasi kalender Hijriah.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-admin {
            background-color: #0f3d23;
        }

        .settings-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
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

    <div class="container-fluid px-md-4 pb-5 settings-content">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <h5 class="mb-0 fw-bold">Pengaturan Data Master</h5>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-lg-6">
                <div class="card card-custom mb-4 border-top border-warning border-4 h-100">
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

                            <div class="mb-4 pt-3 border-top border-light border-2">
                                <label class="form-label fw-bold text-dark"><i class="fa-solid fa-calendar-days me-2 text-primary"></i> Koreksi Hijriah</label>
                                <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                    Nilai ini akan otomatis dikirim ke formulir proses sertifikat. Isi <b>1</b> atau <b>-1</b> jika tanggal Hijriah perlu dikoreksi, atau <b>0</b> jika tidak ada koreksi.
                                </p>
                                <input type="number" name="koreksi_hijriah" class="form-control rounded-3" step="1" value="<?= esc((string) $koreksi_hijriah); ?>">
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

            <!-- Card Master Tempat Miqat -->
            <div class="col-lg-6">
                <div class="card card-custom mb-4 border-top border-success border-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <label class="form-label fw-bold text-dark mb-1"><i class="fa-solid fa-location-dot me-2 text-success"></i> Master Tempat Miqat</label>
                                <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                    Daftar opsi tempat miqat untuk form sertifikat & dashboard.
                                </p>
                            </div>
                            <button type="button" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahMiqat">
                                <i class="fa-solid fa-plus me-1"></i> Tambah
                            </button>
                        </div>

                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th>Nama Miqat</th>
                                        <th>Keterangan</th>
                                        <th class="text-end" style="width: 85px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($list_tempat_miqat)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data tempat miqat.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($list_tempat_miqat as $miqat): ?>
                                            <tr>
                                                <td class="text-muted small"><?= $no++; ?></td>
                                                <td class="fw-bold text-dark"><?= esc($miqat['nama_miqat']); ?></td>
                                                <td class="text-muted small"><?= esc($miqat['keterangan'] ?? '-'); ?></td>
                                                <td class="text-end text-nowrap">
                                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill btn-edit-miqat me-1"
                                                        data-id="<?= $miqat['id']; ?>"
                                                        data-nama="<?= esc($miqat['nama_miqat'], 'attr'); ?>"
                                                        data-keterangan="<?= esc($miqat['keterangan'] ?? '', 'attr'); ?>"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill btn-hapus-miqat"
                                                        data-id="<?= $miqat['id']; ?>"
                                                        data-nama="<?= esc($miqat['nama_miqat'], 'attr'); ?>"
                                                        title="Hapus">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tempat Miqat -->
    <div class="modal fade" id="modalTambahMiqat" tabindex="-1" aria-labelledby="modalTambahMiqatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white border-0 rounded-top-4">
                    <h6 class="modal-title fw-bold" id="modalTambahMiqatLabel">
                        <i class="fa-solid fa-location-dot me-2"></i>Tambah Tempat Miqat
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formTambahMiqat">
                    <div class="modal-body p-4 bg-light">
                        <div class="mb-3">
                            <label for="inputNamaMiqat" class="form-label text-muted fw-bold small">Nama Tempat Miqat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_miqat" id="inputNamaMiqat" class="form-control rounded-3" placeholder="Contoh: Tan'im, Makkah Al-Mukarramah" maxlength="150" required>
                        </div>
                        <div>
                            <label for="inputKeteranganMiqat" class="form-label text-muted fw-bold small">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="inputKeteranganMiqat" class="form-control rounded-3" placeholder="Contoh: Miqat penduduk Makkah / Umrah sunnah" maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanTambahMiqat" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tempat Miqat -->
    <div class="modal fade" id="modalEditMiqat" tabindex="-1" aria-labelledby="modalEditMiqatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h6 class="modal-title fw-bold" id="modalEditMiqatLabel">
                        <i class="fa-solid fa-pen-to-square me-2"></i>Edit Tempat Miqat
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formEditMiqat">
                    <input type="hidden" name="id" id="editIdMiqat">
                    <div class="modal-body p-4 bg-light">
                        <div class="mb-3">
                            <label for="editNamaMiqat" class="form-label text-muted fw-bold small">Nama Tempat Miqat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_miqat" id="editNamaMiqat" class="form-control rounded-3" maxlength="150" required>
                        </div>
                        <div>
                            <label for="editKeteranganMiqat" class="form-label text-muted fw-bold small">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="editKeteranganMiqat" class="form-control rounded-3" maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanEditMiqat" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Form Pengaturan Utama
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
                        Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Terjadi kendala sistem.', 'error');
                    console.error(error);
                });
        });

        // Form Tambah Tempat Miqat
        const modalTambahMiqatEl = document.getElementById('modalTambahMiqat');
        const modalTambahMiqat = new bootstrap.Modal(modalTambahMiqatEl);
        document.getElementById('formTambahMiqat').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let btn = document.getElementById('btnSimpanTambahMiqat');
            btn.disabled = true;

            Swal.fire({
                title: 'Menambahkan...',
                allowOutsideClick: false,
                customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' },
                didOpen: () => { Swal.showLoading(); }
            });

            fetch('<?= base_url('admin/pengaturan/miqat/tambah') ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.status === 'success') {
                    modalTambahMiqat.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Gagal menambahkan data.', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                Swal.fire('Error', 'Terjadi kendala jaringan.', 'error');
                console.error(err);
            });
        });

        // Form Edit Tempat Miqat
        const modalEditMiqatEl = document.getElementById('modalEditMiqat');
        const modalEditMiqat = new bootstrap.Modal(modalEditMiqatEl);
        document.querySelectorAll('.btn-edit-miqat').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const keterangan = this.getAttribute('data-keterangan');

                document.getElementById('editIdMiqat').value = id;
                document.getElementById('editNamaMiqat').value = nama;
                document.getElementById('editKeteranganMiqat').value = keterangan;

                modalEditMiqat.show();
            });
        });

        document.getElementById('formEditMiqat').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editIdMiqat').value;
            let formData = new FormData(this);
            let btn = document.getElementById('btnSimpanEditMiqat');
            btn.disabled = true;

            Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' },
                didOpen: () => { Swal.showLoading(); }
            });

            fetch(`<?= base_url('admin/pengaturan/miqat') ?>/${id}/edit`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.status === 'success') {
                    modalEditMiqat.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Gagal memperbarui data.', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                Swal.fire('Error', 'Terjadi kendala jaringan.', 'error');
                console.error(err);
            });
        });

        // Hapus Tempat Miqat
        document.querySelectorAll('.btn-hapus-miqat').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Tempat Miqat?',
                    html: `Apakah Anda yakin ingin menghapus <b>${nama}</b> dari daftar tempat miqat?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-mobile-custom',
                        title: 'swal-title-custom',
                        confirmButton: 'swal-btn-custom',
                        cancelButton: 'swal-btn-custom'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' },
                            didOpen: () => { Swal.showLoading(); }
                        });

                        fetch(`<?= base_url('admin/pengaturan/miqat') ?>/${id}/hapus`, {
                            method: 'POST'
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' }
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Gagal', data.message || 'Gagal menghapus data.', 'error');
                            }
                        })
                        .catch(err => {
                            Swal.fire('Error', 'Terjadi kendala jaringan.', 'error');
                            console.error(err);
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>