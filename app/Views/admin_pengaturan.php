<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
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

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @media (max-width: 767.98px) {
            html {
                font-size: 14px;
            }
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

        .swal-btn-custom {
            padding: 6px 14px !important;
            font-size: 0.8rem !important;
            border-radius: 6px !important;
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame">
        <!-- Sticky Top Bar -->
        <header class="sg-topbar">
            <a class="sg-brand" href="<?= base_url('admin'); ?>">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Admin Panel" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Admin Panel</span>
                    <span class="sg-brand__sub">Pengaturan Master Sistem</span>
                </div>
            </a>

            <?= view('partials/admin_nav', [
                'activeMenu'    => 'pengaturan',
                'jumlah_sampah' => $jumlah_sampah ?? 0,
            ]); ?>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>
                <a href="<?= base_url('admin'); ?>" class="sg-icon-btn" aria-label="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Kembali</span>
                </a>
            </div>
        </header>

        <main id="main-content" class="sg-pane sg-main">
            <header class="sg-phead pb-3 mb-4 border-bottom">
                <div>
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Konfigurasi Operasional</span>
                    </div>
                    <h1 class="sg-h1">Pengaturan Data Master</h1>
                    <p class="sg-phead__sub">Kelola daftar mutawwif, koreksi kalender Hijriah, autentikasi admin, dan master tempat miqat.</p>
                </div>
            </header>

            <div class="row justify-content-center g-4">
                <div class="col-lg-6">
                    <section class="sg-card sg-card--highlight h-100">
                        <form id="formPengaturan">

                            <!-- Setting: List Mutawwif -->
                            <div class="mb-4">
                                <label for="inputListMutawwif" class="form-label fw-bold sg-text-ink"><i class="fa-solid fa-users me-2 text-success"></i> Daftar Mutawwif &amp; File TTD</label>
                                <p class="sg-text-muted mb-2" style="font-size: 0.75rem;">
                                    Format pengisian: <b>Nama Ustadz|namafile.png</b> <br>
                                    Pisahkan mutawwif baru dengan <b>Baris Baru (Enter)</b>. Pastikan file TTD sudah di-upload ke folder <code>public/signatures/</code>.
                                </p>
                                <textarea id="inputListMutawwif" name="list_mutawwif" class="form-control rounded-3" rows="5" required><?= esc($list_mutawwif); ?></textarea>
                            </div>

                            <div class="mb-4 pt-3 border-top">
                                <label for="inputKoreksiHijriahSetting" class="form-label fw-bold sg-text-ink"><i class="fa-solid fa-calendar-days me-2 text-primary"></i> Koreksi Hijriah</label>
                                <p class="sg-text-muted mb-2" style="font-size: 0.75rem;">
                                    Nilai ini akan otomatis dikirim ke formulir proses sertifikat. Isi <b>1</b> atau <b>-1</b> jika tanggal Hijriah perlu dikoreksi, atau <b>0</b> jika tidak ada koreksi.
                                </p>
                                <input id="inputKoreksiHijriahSetting" type="number" name="koreksi_hijriah" class="form-control rounded-3" step="1" value="<?= esc((string) $koreksi_hijriah); ?>">
                            </div>

                            <!-- Setting: Kredensial Akun -->
                            <div class="mb-4 pt-3 border-top">
                                <div class="form-label fw-bold sg-text-ink"><i class="fa-solid fa-lock me-2 text-danger"></i> Kredensial Login Admin (Sistem)</div>
                                <p class="sg-text-muted mb-3" style="font-size: 0.75rem;">Ubah username dan password untuk masuk ke halaman admin. Kosongkan kolom password jika tidak ingin mengubahnya.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="inputAdminUsername" class="form-label small fw-bold sg-text-muted">Username Baru</label>
                                        <input id="inputAdminUsername" type="text" name="admin_username" class="form-control rounded-3" value="<?= esc($admin_username); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAdminPassword" class="form-label small fw-bold sg-text-muted">Password Baru</label>
                                        <input id="inputAdminPassword" type="password" name="admin_password" class="form-control rounded-3" placeholder="Isi untuk mengganti password">
                                    </div>
                                </div>
                            </div>

                            <!-- Setting: Integrasi Google OAuth -->
                            <div class="mb-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="form-label fw-bold sg-text-ink mb-0">
                                        <i class="fa-brands fa-google me-2 text-danger"></i> Integrasi Google OAuth
                                    </span>
                                    <?php if ($google_is_configured): ?>
                                        <span class="sg-pill sg-pill--good">
                                            <i class="fa-solid fa-circle-check"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="sg-pill sg-pill--warn">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Belum Lengkap
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="sg-text-muted mb-3" style="font-size: 0.75rem;">
                                    Konfigurasi login Administrator menggunakan akun Google OAuth 2.0.
                                </p>

                                <div class="mb-3">
                                    <label for="inputGoogleClientId" class="form-label small fw-bold sg-text-muted">Google Client ID</label>
                                    <input id="inputGoogleClientId" type="text" name="google_client_id" class="form-control rounded-3" value="<?= esc($google_client_id); ?>" placeholder="Contoh: 123456789-abc.apps.googleusercontent.com">
                                </div>

                                <div class="mb-3">
                                    <label for="inputGoogleClientSecret" class="form-label small fw-bold sg-text-muted">
                                        Google Client Secret
                                        <?php if ($google_client_secret_is_set): ?>
                                            <span class="sg-pill sg-pill--good ms-1 py-0 px-2"><i class="fa-solid fa-lock"></i> Tersimpan</span>
                                        <?php endif; ?>
                                    </label>
                                    <input id="inputGoogleClientSecret" type="password" name="google_client_secret" class="form-control rounded-3" placeholder="<?= $google_client_secret_is_set ? 'Biarkan kosong jika tidak diubah' : 'Masukkan Google Client Secret'; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="inputGoogleAdminEmails" class="form-label small fw-bold sg-text-muted">Email Admin yang Diizinkan (Whitelist)</label>
                                    <input id="inputGoogleAdminEmails" type="text" name="google_admin_emails" class="form-control rounded-3" value="<?= esc($google_admin_emails); ?>" placeholder="admin@gmail.com, azis@gmail.com">
                                    <div class="form-text" style="font-size: 0.72rem;">Pisahkan dengan koma jika lebih dari satu email. Jika dikosongkan, email Google pertama yang login akan otomatis dijadikan admin.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputGoogleRedirectUri" class="form-label small fw-bold sg-text-muted">Redirect URI Kustom (Opsional)</label>
                                    <input id="inputGoogleRedirectUri" type="text" name="google_redirect_uri" class="form-control rounded-3" value="<?= esc($google_redirect_uri_custom ?? ''); ?>" placeholder="Biarkan kosong untuk deteksi otomatis (<?= esc($google_redirect_uri); ?>)">
                                    <div class="form-text" style="font-size: 0.72rem;">Kosongkan untuk mendeteksi domain/port aktif secara otomatis.</div>
                                </div>

                                <!-- Box Panduan Authorized Redirect URIs untuk Google Cloud Console -->
                                <div class="sg-subpanel small">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="fw-bold sg-text-ink" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> Authorized Redirect URIs (Google Console)
                                        </div>
                                        <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener" class="sg-btn sg-btn--glass btn-sm py-0 px-2" style="font-size: 0.7rem;">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Console
                                        </a>
                                    </div>
                                    <p class="sg-text-muted mb-2" style="font-size: 0.73rem;">
                                        Agar tidak muncul <b>Error 400: redirect_uri_mismatch</b>, pastikan URL berikut sudah didaftarkan pada <b>Authorized redirect URIs</b> di Google Cloud Console:
                                    </p>

                                    <!-- URI Aktif Saat Ini -->
                                    <label for="redirectUriInput" class="small sg-text-muted fw-bold mb-1" style="font-size: 0.7rem;">URI Aktif Saat Ini:</label>
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text" class="form-control font-monospace" id="redirectUriInput" value="<?= esc($google_redirect_uri); ?>" readonly style="font-size: 0.75rem;">
                                        <button class="btn btn-primary" type="button" id="btnCopyRedirectUri" title="Salin URI Aktif">
                                            <i class="fa-regular fa-copy me-1"></i> Salin
                                        </button>
                                    </div>

                                    <!-- URI Tambahan untuk Localhost -->
                                    <?php
                                    $uri127 = 'http://127.0.0.1:8080/login/google/callback';
                                    $uriLocalhost = 'http://localhost:8080/login/google/callback';
                                    ?>
                                    <div class="mt-2 pt-2 border-top">
                                        <div class="sg-text-muted small fw-semibold mb-1" style="font-size: 0.7rem;">Daftarkan juga variasi berikut di Google Console:</div>
                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex justify-content-between align-items-center p-1 px-2 border rounded" style="background: var(--input-bg);">
                                                <code style="font-size: 0.72rem;"><?= $uriLocalhost; ?></code>
                                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none copy-helper sg-text-sig" data-copy="<?= $uriLocalhost; ?>" style="font-size: 0.72rem;">
                                                    <i class="fa-regular fa-copy"></i> Salin
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center p-1 px-2 border rounded" style="background: var(--input-bg);">
                                                <code style="font-size: 0.72rem;"><?= $uri127; ?></code>
                                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none copy-helper sg-text-sig" data-copy="<?= $uri127; ?>" style="font-size: 0.72rem;">
                                                    <i class="fa-regular fa-copy"></i> Salin
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2 text-danger" style="font-size: 0.7rem;">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> <b>Catatan:</b> Jangan tambahkan tanda miring (<code>/</code>) di akhir URL. Setelah menambahkannya di Google Console, klik <b>SAVE</b> dan tunggu 1-2 menit agar Google menyinkronkan.
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="sg-btn sg-btn--sig w-100 py-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </section>
                </div>

                <!-- Card Master Tempat Miqat -->
                <div class="col-lg-6">
                    <section class="sg-card h-100">
                        <div class="sg-card__head align-items-start">
                            <div>
                                <h2 class="sg-card__title mb-1">
                                    <i class="fa-solid fa-location-dot"></i> Master Tempat Miqat
                                </h2>
                                <p class="sg-text-muted mb-0" style="font-size: 0.75rem;">
                                    Daftar opsi tempat miqat untuk form sertifikat &amp; dashboard.
                                </p>
                            </div>
                            <button type="button" class="sg-btn sg-btn--sig btn-sm py-1 px-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahMiqat">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </button>
                        </div>

                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                <thead>
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
                                            <td colspan="4" class="text-center sg-text-muted py-4">Belum ada data tempat miqat.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($list_tempat_miqat as $miqat): ?>
                                            <tr>
                                                <td class="sg-text-muted small"><?= $no++; ?></td>
                                                <td class="fw-bold sg-text-ink"><?= esc($miqat['nama_miqat']); ?></td>
                                                <td class="sg-text-muted small"><?= esc($miqat['keterangan'] ?? '-'); ?></td>
                                                <td class="text-end text-nowrap">
                                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill btn-edit-miqat me-1"
                                                        data-id="<?= $miqat['id']; ?>"
                                                        data-nama="<?= esc($miqat['nama_miqat'], 'attr'); ?>"
                                                        data-keterangan="<?= esc($miqat['keterangan'] ?? '', 'attr'); ?>"
                                                        title="Edit"
                                                        aria-label="Edit <?= esc($miqat['nama_miqat'], 'attr'); ?>">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill btn-hapus-miqat"
                                                        data-id="<?= $miqat['id']; ?>"
                                                        data-nama="<?= esc($miqat['nama_miqat'], 'attr'); ?>"
                                                        title="Hapus"
                                                        aria-label="Hapus <?= esc($miqat['nama_miqat'], 'attr'); ?>">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Tempat Miqat -->
    <div class="modal fade" id="modalTambahMiqat" tabindex="-1" aria-labelledby="modalTambahMiqatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="modalTambahMiqatLabel">
                        <i class="fa-solid fa-location-dot me-2 sg-text-sig"></i>Tambah Tempat Miqat
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formTambahMiqat">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="inputNamaMiqat" class="form-label fw-bold small">Nama Tempat Miqat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_miqat" id="inputNamaMiqat" class="form-control rounded-3" placeholder="Contoh: Tan'im, Makkah Al-Mukarramah" maxlength="150" required>
                        </div>
                        <div>
                            <label for="inputKeteranganMiqat" class="form-label fw-bold small">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="inputKeteranganMiqat" class="form-control rounded-3" placeholder="Contoh: Miqat penduduk Makkah / Umrah sunnah" maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="sg-btn sg-btn--glass btn-sm py-2 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanTambahMiqat" class="sg-btn sg-btn--sig btn-sm py-2 px-4">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tempat Miqat -->
    <div class="modal fade" id="modalEditMiqat" tabindex="-1" aria-labelledby="modalEditMiqatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="modalEditMiqatLabel">
                        <i class="fa-solid fa-pen-to-square me-2 sg-text-sig"></i>Edit Tempat Miqat
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formEditMiqat">
                    <input type="hidden" name="id" id="editIdMiqat">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="editNamaMiqat" class="form-label fw-bold small">Nama Tempat Miqat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_miqat" id="editNamaMiqat" class="form-control rounded-3" maxlength="150" required>
                        </div>
                        <div>
                            <label for="editKeteranganMiqat" class="form-label fw-bold small">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="editKeteranganMiqat" class="form-control rounded-3" maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="sg-btn sg-btn--glass btn-sm py-2 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanEditMiqat" class="sg-btn sg-btn--sig btn-sm py-2 px-4">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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

        // Salin Redirect URI Google OAuth
        const btnCopyRedirectUri = document.getElementById('btnCopyRedirectUri');
        if (btnCopyRedirectUri) {
            btnCopyRedirectUri.addEventListener('click', function() {
                const input = document.getElementById('redirectUriInput');
                if (!input) return;
                input.select();
                navigator.clipboard.writeText(input.value).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Authorized Redirect URI berhasil disalin.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' }
                    });
                }).catch(() => {
                    input.select();
                    document.execCommand('copy');
                });
            });
        }

        document.querySelectorAll('.copy-helper').forEach(btn => {
            btn.addEventListener('click', function() {
                const text = this.getAttribute('data-copy');
                if (!text) return;
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: text + ' telah disalin ke clipboard.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-mobile-custom', title: 'swal-title-custom' }
                    });
                });
            });
        });
    </script>
</body>

</html>