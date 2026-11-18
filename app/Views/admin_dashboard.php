<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Admin Dashboard - Badal Umrah</title>
    <meta name="title" content="Admin Dashboard - Badal Umrah">
    <meta name="description" content="Panel Administrasi Layanan Badal Umrah. Kelola data pendaftar, pencetakan sertifikat, dan arsip video dokumentasi.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('admin'); ?>">
    <meta property="og:title" content="Admin Dashboard - Badal Umrah">
    <meta property="og:description" content="Panel Administrasi Layanan Badal Umrah. Kelola data pendaftar, sertifikat, dan video dokumentasi.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Admin Dashboard - Badal Umrah">
    <meta name="twitter:description" content="Panel Administrasi Layanan Badal Umrah. Kelola data pendaftar, sertifikat, dan video dokumentasi.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tom Select (Bootstrap 5) for Multi-function Select Option -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @media (max-width: 767.98px) {
            html {
                font-size: 14px;
            }
        }

        h4,
        .h1,
        .h5,
        .h6 {
            font-weight: 700;
        }

        .bu-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .bu-kpi-val {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.1;
        }

        /* Custom SweetAlert Mobile-friendly */
        .swal-mobile-custom {
            font-size: 0.9rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
            border-radius: 12px !important;
        }

        .swal-title-custom {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
        }

        .swal-btn-custom {
            padding: 8px 16px !important;
            font-size: 0.9rem !important;
            border-radius: 6px !important;
        }

        .table-custom th {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        @media (max-width: 991.98px) {
            .bu-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            #pendaftarTable,
            #pendaftarTable tbody {
                display: block;
                width: 100%;
            }

            #pendaftarTable {
                table-layout: auto;
            }

            #pendaftarTable thead {
                display: none;
            }

            #pendaftarTable tbody tr {
                display: block;
                margin: 0.75rem;
                padding: 0.5rem 0.85rem;
                border: 0;
                border-radius: var(--r-md);
                background: var(--card);
                box-shadow: inset 0 0 0 1px var(--glass-rim), inset 1px 1px 0 var(--glass-top), var(--shadow-sm);
            }

            #pendaftarTable tbody td {
                display: grid;
                grid-template-columns: minmax(6rem, 34%) minmax(0, 1fr);
                align-items: start;
                gap: 0.5rem;
                width: 100% !important;
                padding: 0.65rem 0;
                border: 0;
                border-bottom: 1px solid var(--glass-rim);
                text-align: left !important;
                white-space: normal !important;
                overflow-wrap: anywhere;
            }

            #pendaftarTable tbody td:last-child {
                border-bottom: 0;
            }

            #pendaftarTable tbody td::before {
                content: attr(data-label);
                color: var(--muted);
                font-size: 0.78rem;
                font-weight: 700;
            }

            #pendaftarTable .badge {
                white-space: normal;
                overflow-wrap: anywhere;
            }

            #pendaftarTable .btn-proses,
            #pendaftarTable .btn-outline-danger,
            #pendaftarTable .btn-hapus-pendaftaran {
                padding: 0.375rem 0.5rem !important;
            }

            #pendaftarTable .d-flex {
                justify-content: flex-start !important;
            }
        }

        .date-field-card {
            height: 100%;
            padding: 1rem;
            border-radius: var(--r-md);
            background: var(--card-2);
            box-shadow: inset 0 0 0 1px var(--glass-rim);
        }

        .flatpickr-calendar {
            z-index: 1060;
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <?php
    $totalPendaftar = count($pendaftar);
    $totalPending = 0;
    $totalSelesai = 0;
    foreach ($pendaftar as $rowCount) {
        if (($rowCount['status'] ?? '') === 'selesai') {
            $totalSelesai++;
        } else {
            $totalPending++;
        }
    }
    ?>

    <div class="sg-frame">
        <!-- Sticky Top Bar -->
        <header class="sg-topbar">
            <a class="sg-brand" href="<?= base_url('admin'); ?>">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Admin Panel" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Admin Panel</span>
                    <span class="sg-brand__sub">Dashboard Pendaftaran &amp; Sertifikat</span>
                </div>
            </a>

            <?= view('partials/admin_nav', [
                'activeMenu'     => 'pendaftar',
                'totalPendaftar' => $totalPendaftar,
                'jumlah_sampah'  => $jumlah_sampah ?? 0,
            ]); ?>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>

                <?php if (session()->get('admin_picture')): ?>
                    <img src="<?= esc(session()->get('admin_picture'), 'attr'); ?>" alt="Profil Google" class="rounded-circle shadow-sm" style="width: 34px; height: 34px; object-fit: cover; border: 2px solid var(--sig);" title="<?= esc(session()->get('admin_name') ?? session()->get('admin_email')); ?>">
                <?php elseif (session()->get('admin_email')): ?>
                    <span class="sg-pill d-none d-xl-inline-flex text-truncate" style="max-width: 170px;" title="<?= esc(session()->get('admin_email')); ?>">
                        <i class="fa-brands fa-google text-danger"></i><?= esc(session()->get('admin_name') ?? session()->get('admin_email')); ?>
                    </span>
                <?php endif; ?>

                <a href="#" id="btn-logout" class="sg-icon-btn sg-icon-btn--danger" aria-label="Logout" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Logout</span>
                </a>
            </div>
        </header>

        <main id="main-content" class="sg-pane sg-main">
            <!-- Page Header -->
            <header class="sg-phead pb-3 mb-4 border-bottom">
                <div>
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-kaaba"></i>
                        <span>Manajemen Layanan Badal Umrah</span>
                    </div>
                    <h1 class="sg-h1">Daftar Pendaftar</h1>
                    <p class="sg-phead__sub">Kelola pendaftaran jamaah, proses penerbitan sertifikat resmi, dan arsip video dokumentasi.</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <button type="button" class="sg-btn sg-btn--sig" data-bs-toggle="modal" data-bs-target="#modalTambahPendaftar">
                        <i class="fa-solid fa-user-plus"></i> Tambah Data
                    </button>
                    <span class="sg-pill"><?= $totalPendaftar; ?> Total</span>
                </div>
            </header>

            <!-- Bento KPI Summary Row -->
            <div class="bu-kpi-grid">
                <section class="sg-card py-3">
                    <div class="small sg-text-muted mb-1"><i class="fa-solid fa-users sg-text-sig me-1"></i> Total Pendaftar</div>
                    <div class="bu-kpi-val"><?= $totalPendaftar; ?></div>
                </section>
                <section class="sg-card py-3">
                    <div class="small sg-text-muted mb-1"><i class="fa-regular fa-clock text-warning me-1"></i> Menunggu Proses</div>
                    <div class="bu-kpi-val text-warning"><?= $totalPending; ?></div>
                </section>
                <section class="sg-card py-3">
                    <div class="small sg-text-muted mb-1"><i class="fa-solid fa-check-double text-success me-1"></i> Sertifikat Selesai</div>
                    <div class="bu-kpi-val text-success"><?= $totalSelesai; ?></div>
                </section>
                <section class="sg-card py-3">
                    <div class="small sg-text-muted mb-1"><i class="fa-solid fa-trash-can sg-text-sig me-1"></i> Di Sampah</div>
                    <div class="bu-kpi-val"><?= (int) ($jumlah_sampah ?? 0); ?></div>
                </section>
            </div>

            <!-- Table Card -->
            <section class="sg-card sg-card--flush">
                <table id="pendaftarTable" class="table table-hover mb-0 align-middle table-custom w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Registrasi &amp; Pemesan</th>
                            <th>Di-umrahkan</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($pendaftar as $row): ?>
                            <tr>
                                <td data-label="No"><?= $i++; ?></td>
                                <td data-label="Registrasi & Pemesan">
                                    <div>
                                        <strong class="sg-text-ink d-block mb-1 font-monospace"><?= esc($row['uuid']); ?></strong>

                                        <?php
                                        $no_wa_clean = preg_replace('/[^0-9]/', '', $row['no_wa_pemesan']);
                                        if (substr($no_wa_clean, 0, 1) === '0') {
                                            $no_wa_clean = '62' . substr($no_wa_clean, 1);
                                        }
                                        ?>

                                        <a href="https://wa.me/<?= $no_wa_clean; ?>" target="_blank" class="sg-pill sg-pill--good text-decoration-none">
                                            <i class="fa-brands fa-whatsapp"></i> <?= esc($row['nama_pemesan']); ?>
                                        </a>
                                    </div>
                                </td>
                                <td data-label="Di-umrahkan">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (! empty($row['foto_jamaah'])): ?>
                                            <a href="<?= base_url('admin/pendaftaran/' . $row['id'] . '/foto'); ?>" target="_blank" title="Lihat Foto <?= esc($row['nama_diumrahkan'], 'attr'); ?>" class="flex-shrink-0 text-decoration-none">
                                                <img src="<?= base_url('admin/pendaftaran/' . $row['id'] . '/foto'); ?>"
                                                    alt="Foto <?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                                    class="rounded border shadow-sm"
                                                    style="width: 36px; height: 46px; object-fit: cover;"
                                                    loading="lazy"
                                                    onerror="this.parentElement.style.display='none'">
                                            </a>
                                        <?php endif; ?>
                                        <span class="fw-bold sg-text-ink fs-6 text-break">
                                            <?= esc($row['nama_diumrahkan']); ?>
                                        </span>
                                    </div>
                                </td>
                                <td data-label="Paket"><span class="sg-pill"><?= esc($row['paket_pilihan']); ?></span></td>
                                <td data-label="Status">
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <span class="sg-pill sg-pill--warn"><i class="fa-regular fa-clock"></i> Pending</span>
                                    <?php else: ?>
                                        <span class="sg-pill sg-pill--good"><i class="fa-solid fa-check-double"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <button class="btn btn-sm btn-primary rounded-pill px-3 btn-proses shadow-sm"
                                                data-id="<?= $row['id']; ?>"
                                                data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                                data-koreksi-hijriah="<?= esc((string) $koreksi_hijriah, 'attr'); ?>"
                                                data-tempat-miqat="<?= esc($row['tempat_miqat'] ?? '', 'attr'); ?>">
                                                <i class="fa-solid fa-gear me-1"></i>Proses
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm btn-preview-pdf"
                                                data-url="<?= base_url('storage/certificates/' . rawurlencode($row['uuid']) . '.pdf'); ?>"
                                                data-share-url="<?= base_url('sertifikat/' . rawurlencode($row['uuid'])); ?>"
                                                data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                                data-uuid="<?= esc($row['uuid'], 'attr'); ?>"
                                                aria-label="Preview sertifikat PDF untuk <?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                                title="Preview Sertifikat PDF">
                                                <i class="fa-solid fa-file-pdf me-1"></i>PDF
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-edit-pendaftaran"
                                            data-id="<?= $row['id']; ?>"
                                            data-nama-pemesan="<?= esc($row['nama_pemesan'], 'attr'); ?>"
                                            data-no-wa="<?= esc($row['no_wa_pemesan'], 'attr'); ?>"
                                            data-nama-diumrahkan="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            data-paket="<?= esc($row['paket_pilihan'], 'attr'); ?>"
                                            data-foto="<?= esc($row['foto_jamaah'] ?? '', 'attr'); ?>"
                                            data-foto-url="<?= ! empty($row['foto_jamaah']) ? base_url('admin/pendaftaran/' . $row['id'] . '/foto') : ''; ?>"
                                            aria-label="Edit data pendaftar <?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <?php $totalVideo = (int) ($row['total_video'] ?? 0); ?>
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill btn-video-arsip position-relative"
                                            data-id="<?= $row['id']; ?>"
                                            data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            aria-label="Arsip video dokumentasi untuk <?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            title="Arsip Video Dokumentasi (<?= $totalVideo; ?> video)">
                                            <i class="fa-solid fa-video"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light badge-video-count<?= $totalVideo > 0 ? '' : ' d-none'; ?>" style="font-size: 0.65rem; padding: 0.25em 0.45em; min-width: 1.25rem;">
                                                <?= $totalVideo; ?>
                                                <span class="visually-hidden">video diarsipkan</span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill btn-hapus-pendaftaran"
                                            data-id="<?= $row['id']; ?>"
                                            data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            aria-label="Pindahkan pendaftaran ke sampah">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal Edit Pendaftaran -->
    <div class="modal fade" id="modalEditPendaftaran" tabindex="-1" aria-labelledby="modalEditPendaftaranLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditPendaftaranLabel"><i class="fa-solid fa-pen-to-square me-2 sg-text-sig"></i>Edit Data Pendaftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formEditPendaftaran" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_pendaftaran" id="editIdPendaftaran">
                        <div class="mb-3">
                            <label for="editNamaPemesan" class="form-label fw-bold small">Nama Lengkap Pemesan</label>
                            <input type="text" name="nama_pemesan" id="editNamaPemesan" class="form-control rounded-3" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNoWaPemesan" class="form-label fw-bold small">Nomor WhatsApp</label>
                            <input type="tel" name="no_wa_pemesan" id="editNoWaPemesan" class="form-control rounded-3" maxlength="20" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaDiumrahkan" class="form-label fw-bold small">Nama yang Di-umrahkan</label>
                            <input type="text" name="nama_diumrahkan" id="editNamaDiumrahkan" class="form-control rounded-3" maxlength="150" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFotoJamaah" class="form-label fw-bold small">Foto untuk Sertifikat (Opsional)</label>
                            <div id="editFotoCurrentWrapper" class="d-none mb-2 p-2 sg-subpanel d-flex align-items-center gap-3">
                                <img id="editFotoPreview" src="" alt="Foto Jamaah" class="rounded border" style="width: 50px; height: 65px; object-fit: cover;">
                                <div class="small">
                                    <div class="fw-semibold sg-text-ink"><i class="fa-solid fa-image sg-text-sig me-1"></i> Foto Saat Ini Tersedia</div>
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="hapus_foto_jamaah" value="1" id="editHapusFoto">
                                        <label class="form-check-label text-danger small fw-medium" for="editHapusFoto">
                                            Hapus foto ini (sertifikat tanpa foto)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="foto_jamaah" id="editFotoJamaah" class="form-control rounded-3" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4. Kosongkan jika tidak ingin mengubah foto.</div>
                        </div>
                        <div>
                            <label for="editPaketPilihan" class="form-label fw-bold small">Pilihan Paket</label>
                            <select name="paket_pilihan" id="editPaketPilihan" class="form-select rounded-3" required>
                                <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="sg-btn sg-btn--glass btn-sm py-2 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanEditPendaftaran" class="sg-btn sg-btn--sig btn-sm py-2 px-4">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Arsip Video Dokumentasi -->
    <div class="modal fade" id="modalArsipVideo" tabindex="-1" aria-labelledby="modalArsipVideoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalArsipVideoLabel"><i class="fa-solid fa-video me-2 sg-text-sig"></i>Arsip Video Dokumentasi</h5>
                        <div class="small sg-text-muted" id="videoArsipNama"></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formUnggahVideo" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="inputVideoDokumentasi" class="form-label fw-bold">Tambah video</label>
                            <input type="file" id="inputVideoDokumentasi" name="videos[]" class="form-control" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" multiple required>
                            <div class="form-text">Pilih satu atau beberapa video. Format MP4, WEBM, atau MOV; maksimal 500 MB per video.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="btnUnggahVideo" class="sg-btn sg-btn--sig btn-sm py-2 px-4">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Unggah ke Arsip
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <h6 class="fw-bold mb-3 sg-text-ink">Video yang Diarsipkan</h6>
                    <div id="daftarVideoArsip" class="d-flex flex-column gap-2" aria-live="polite">
                        <div class="sg-text-muted small">Memuat daftar video...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pendaftar Manual -->
    <div class="modal fade" id="modalTambahPendaftar" tabindex="-1" aria-labelledby="modalTambahPendaftarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahPendaftarLabel"><i class="fa-solid fa-user-plus me-2 sg-text-sig"></i> Input Pendaftaran Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formTambahPendaftar" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="tambahNamaPemesan" class="form-label fw-bold small">Nama Lengkap Pemesan</label>
                            <input id="tambahNamaPemesan" type="text" name="nama_pemesan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambahNoWaPemesan" class="form-label fw-bold small">Nomor WhatsApp</label>
                            <input id="tambahNoWaPemesan" type="number" name="no_wa_pemesan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambahNamaDiumrahkan" class="form-label fw-bold small">Nama Yang Di-umrahkan</label>
                            <input id="tambahNamaDiumrahkan" type="text" name="nama_diumrahkan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambahFotoJamaah" class="form-label fw-bold small">Foto untuk Sertifikat (Opsional)</label>

                            <!-- Preview Foto Terpilih -->
                            <div id="tambahFotoPreviewWrapper" class="d-none mb-2 p-2 sg-subpanel d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3 overflow-hidden">
                                    <img id="tambahFotoPreview" src="" alt="Preview Foto Jamaah" class="rounded border shadow-sm flex-shrink-0" style="width: 50px; height: 65px; object-fit: cover;">
                                    <div class="small overflow-hidden">
                                        <div class="fw-bold sg-text-ink text-truncate" id="tambahFotoNama" style="max-width: 200px;">Nama File</div>
                                        <div class="sg-text-muted" style="font-size: 0.75rem;" id="tambahFotoUkuran">0 KB</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-1 flex-shrink-0" id="btnHapusPreviewTambahFoto" title="Hapus foto terpilih">
                                    <i class="fa-solid fa-xmark me-1"></i> Batal
                                </button>
                            </div>

                            <input type="file" name="foto_jamaah" id="tambahFotoJamaah" class="form-control rounded-3" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4.</div>
                        </div>
                        <div class="mb-2">
                            <label for="tambahPaketPilihan" class="form-label fw-bold small">Pilihan Paket</label>
                            <select id="tambahPaketPilihan" name="paket_pilihan" class="form-select rounded-3" required>
                                <option value="">-- Pilih Paket --</option>
                                <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="sg-btn sg-btn--glass btn-sm py-2 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="sg-btn sg-btn--sig btn-sm py-2 px-4"><i class="fa-solid fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Eksekusi -->
    <div class="modal fade" id="modalProses" tabindex="-1" aria-labelledby="modalProsesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalProsesLabel"><i class="fa-solid fa-file-signature me-2 sg-text-sig"></i> Generate Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formProsesSertifikat">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_pendaftaran" id="id_pendaftaran">

                        <div class="sg-subpanel mb-4" style="border-left: 4px solid var(--sig);">
                            Eksekusi untuk: <br><strong id="lbl_nama_diumrahkan" class="fs-5 sg-text-ink"></strong>
                        </div>

                        <div class="mb-3">
                            <label for="selectPelaksanaProses" class="form-label fw-bold">Mutawwif Pelaksana</label>
                            <select id="selectPelaksanaProses" name="pelaksana_data" class="form-select rounded-3" required>
                                <?php foreach ($list_mutawwif as $mutawwif): ?>
                                    <?php
                                    $parts = explode('|', $mutawwif);
                                    $nama_ust = trim($parts[0] ?? '');
                                    $val_ust = trim($mutawwif);
                                    ?>
                                    <?php if (!empty($nama_ust)): ?>
                                        <option value="<?= esc($val_ust); ?>"><?= esc($nama_ust); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="selectTempatMiqat" class="form-label fw-bold">
                                <i class="fa-solid fa-location-dot sg-text-sig me-1"></i> Tempat Miqat
                            </label>
                            <select name="tempat_miqat" id="selectTempatMiqat" class="form-select rounded-3" required>
                                <option value="">Pilih atau ketik tempat miqat...</option>
                                <?php
                                $tempatMiqatOptions = ! empty($list_tempat_miqat) ? $list_tempat_miqat : [
                                    "Tan'im, Makkah Al-Mukarramah",
                                    "Bir Ali (Zulhulaifah)",
                                    "Ji'ranah",
                                    "Hudaibiyah",
                                    "Yalamlam",
                                    "Qarnul Manazil"
                                ];
                                ?>
                                <?php foreach ($tempatMiqatOptions as $miqatOpt): ?>
                                    <option value="<?= esc($miqatOpt); ?>"><?= esc($miqatOpt); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Pilih opsi yang ada atau ketik langsung jika tempat miqat belum ada di daftar.</div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="date-field-card">
                                    <label for="tanggalMiqat" class="form-label fw-bold">
                                        <i class="fa-solid fa-kaaba me-2 sg-text-sig"></i>Tanggal Miqat
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                        <input type="text" name="tanggal_miqat" id="tanggalMiqat" class="form-control" placeholder="Pilih tanggal miqat" required>
                                    </div>
                                    <div class="form-text">Pilih tanggal pelaksanaan ibadah di miqat.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="date-field-card">
                                    <label for="tanggalCetak" class="form-label fw-bold">
                                        <i class="fa-solid fa-file-circle-check me-2 sg-text-sig"></i>Tanggal Cetak Sertifikat
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-calendar-check"></i></span>
                                        <input type="text" name="tanggal_cetak" id="tanggalCetak" class="form-control" placeholder="Pilih tanggal cetak" required>
                                    </div>
                                    <div class="form-text">Tanggal sertifikat diterbitkan. Otomatis diisi hari ini.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="inputKoreksiHijriah" class="form-label fw-bold">Koreksi Hijriah (Opsional)</label>
                            <input type="number" name="koreksi_hijriah" id="inputKoreksiHijriah" class="form-control rounded-3" step="1" value="<?= esc((string) $koreksi_hijriah); ?>">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="sg-btn sg-btn--glass btn-sm py-2 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="sg-btn sg-btn--sig btn-sm py-2 px-4"><i class="fa-solid fa-print"></i> Simpan &amp; Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF Sertifikat -->
    <div class="modal fade" id="modalPreviewPdf" tabindex="-1" aria-labelledby="modalPreviewPdfLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-pdf fs-4 text-danger"></i>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="modalPreviewPdfLabel">Preview Sertifikat PDF</h5>
                            <div class="small sg-text-muted" id="previewPdfNamaJamaah"></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-3">
                    <!-- Action Toolbar di atas preview -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 p-2 sg-subpanel">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="sg-pill sg-pill--bad">
                                <i class="fa-solid fa-certificate"></i> Sertifikat Resmi
                            </span>
                            <span class="small sg-text-muted d-none d-md-inline font-monospace" id="previewPdfUuid"></span>

                            <!-- Zoom Controls for PDF.js -->
                            <div class="btn-group btn-group-sm shadow-sm ms-md-2" role="group" aria-label="Kontrol Zoom PDF">
                                <button type="button" id="btnPdfZoomOut" class="btn btn-outline-secondary" title="Perkecil" aria-label="Perkecil PDF">
                                    <i class="fa-solid fa-magnifying-glass-minus"></i>
                                </button>
                                <button type="button" id="btnPdfZoomFit" class="btn btn-outline-secondary px-2" title="Sesuaikan Lebar Layar">
                                    <i class="fa-solid fa-arrows-left-right me-1"></i>Fit
                                </button>
                                <button type="button" id="btnPdfZoomIn" class="btn btn-outline-secondary" title="Perbesar" aria-label="Perbesar PDF">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                                <span id="pdfZoomLabel" class="btn btn-outline-secondary disabled font-monospace px-2" style="opacity: 1;">100%</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" id="btnSalinLinkPdf" class="btn btn-outline-success rounded-pill px-3 shadow-sm btn-sm">
                                <i class="fa-solid fa-share-nodes me-1"></i> Salin Link Sertifikat
                            </button>
                            <a id="btnDownloadPdf" href="#" download class="btn btn-danger rounded-pill px-3 shadow-sm btn-sm">
                                <i class="fa-solid fa-download me-1"></i> Download PDF
                            </a>
                            <a id="btnWaPdf" href="#" target="_blank" rel="noopener" class="btn btn-success rounded-pill px-3 shadow-sm btn-sm" title="Bagikan via WhatsApp">
                                <i class="fa-brands fa-whatsapp me-1"></i> Kirim WA
                            </a>
                            <a id="btnBukaTabPdf" href="#" target="_blank" rel="noopener" class="btn btn-outline-secondary rounded-pill px-3 btn-sm" title="Buka di tab baru">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Tab Baru
                            </a>
                        </div>
                    </div>

                    <!-- Container Mozilla PDF.js Canvas Preview -->
                    <div id="pdfViewerWrapper" class="rounded-3 overflow-auto position-relative shadow-sm d-flex flex-column align-items-center p-2 p-md-3" style="height: 70vh; min-height: 420px; max-height: 85vh; -webkit-overflow-scrolling: touch; background: rgba(15, 17, 20, 0.55); border: 1px solid var(--glass-rim);">
                        <!-- Loading State -->
                        <div id="pdfLoadingSpinner" class="text-center my-auto py-5">
                            <div class="spinner-border text-danger mb-2" role="status">
                                <span class="visually-hidden">Memuat PDF...</span>
                            </div>
                            <div class="small sg-text-muted fw-semibold">Memuat pratinjau sertifikat via Mozilla PDF.js...</div>
                        </div>

                        <!-- Error Fallback Notice -->
                        <div id="pdfErrorNotice" class="alert alert-danger d-none text-center my-auto p-4 m-3 rounded-3 shadow-sm" style="max-width: 500px;">
                            <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-danger"></i>
                            <div class="fw-bold mb-1">Pratinjau PDF Tidak Dapat Ditampilkan</div>
                            <div class="small mb-3" id="pdfErrorMessage">Browser mengalami kendala saat merender berkas PDF langsung.</div>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a id="btnFallbackDownloadPdf" href="#" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" download>
                                    <i class="fa-solid fa-download me-1"></i> Unduh PDF
                                </a>
                                <a id="btnFallbackTabPdf" href="#" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka di Tab Baru
                                </a>
                            </div>
                        </div>

                        <!-- Canvas Container -->
                        <div id="pdfPagesContainer" class="d-flex flex-column align-items-center w-100"></div>
                    </div>

                    <div class="small sg-text-muted mt-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span><i class="fa-solid fa-shield-halved text-success me-1"></i> Pratinjau kompatibel untuk layar ponsel &amp; desktop via Mozilla PDF.js.</span>
                        <span class="small">Badal Umrah Amanah &amp; Terpercaya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (required by the DataTables CDN build) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <!-- Flatpickr with Indonesian locale -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>
    <!-- Mozilla PDF.js (Cross-Device Mobile & Desktop PDF Viewer) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <!-- Tom Select (Bootstrap 5) for Multi-function Select Option -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        // Blur active element before SweetAlert2 shows to avoid WAI-ARIA aria-hidden console warning on modal descendants
        const originalSwalFire = Swal.fire.bind(Swal);
        Swal.fire = function(...args) {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
            return originalSwalFire(...args);
        };

        new DataTable('#pendaftarTable', {
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data untuk ditampilkan',
                infoFiltered: '(difilter dari _MAX_ total data)',
                zeroRecords: 'Data yang cocok tidak ditemukan',
                emptyTable: 'Belum ada data pendaftaran masuk.',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });

        // Konfirmasi Logout dengan SweetAlert2
        document.getElementById('btn-logout').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Keluar Sistem?',
                text: "Anda harus memasukkan kembali username & password untuk masuk.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa-solid fa-right-from-bracket me-1"></i> Ya, Logout',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom',
                    confirmButton: 'swal-btn-custom shadow-sm',
                    cancelButton: 'swal-btn-custom shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('logout'); ?>';
                }
            });
        });

        // Membuka Modal saat tombol Proses diklik
        const tanggalMiqatInput = document.getElementById('tanggalMiqat');
        const tanggalCetakInput = document.getElementById('tanggalCetak');
        const datePickerOptions = {
            locale: flatpickr.l10ns.id,
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'l, j F Y',
            altInputClass: 'form-control',
            allowInput: true,
            disableMobile: true,
            position: 'below'
        };
        const tanggalMiqatPicker = flatpickr(tanggalMiqatInput, datePickerOptions);
        const tanggalCetakPicker = flatpickr(tanggalCetakInput, datePickerOptions);

        // Inisialisasi Tom Select untuk tempat miqat (select-option multi fungsi: pilih atau ketik langsung)
        let tomSelectMiqat = null;
        const elSelectMiqat = document.getElementById('selectTempatMiqat');
        if (elSelectMiqat && window.TomSelect) {
            tomSelectMiqat = new TomSelect('#selectTempatMiqat', {
                create: true,
                createOnBlur: true,
                persist: false,
                placeholder: 'Pilih atau ketik tempat miqat...',
                maxItems: 1
            });
        }

        document.querySelectorAll('.btn-proses').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('id_pendaftaran').value = this.getAttribute('data-id');
                document.getElementById('lbl_nama_diumrahkan').innerText = this.getAttribute('data-nama');
                document.getElementById('inputKoreksiHijriah').value = this.getAttribute('data-koreksi-hijriah') || '0';

                const miqatVal = this.getAttribute('data-tempat-miqat') || "Tan'im, Makkah Al-Mukarramah";
                if (tomSelectMiqat) {
                    tomSelectMiqat.addOption({value: miqatVal, text: miqatVal});
                    tomSelectMiqat.setValue(miqatVal, true);
                } else if (elSelectMiqat) {
                    elSelectMiqat.value = miqatVal;
                }

                if (!tanggalCetakInput.value) {
                    const today = new Date();
                    const localDate = new Date(today.getTime() - today.getTimezoneOffset() * 60000)
                        .toISOString()
                        .slice(0, 10);
                    tanggalCetakPicker.setDate(localDate, false);
                }

                new bootstrap.Modal(document.getElementById('modalProses')).show();
            });
        });

        document.querySelectorAll('.btn-hapus-pendaftaran').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Pindahkan ke Sampah?',
                    text: `Pendaftaran atas nama ${nama} dapat dipulihkan dari menu Sampah.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, pindahkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#6c757d'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`<?= base_url('admin/pendaftaran'); ?>/${id}/hapus`, {
                            method: 'POST'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status !== 'success') throw new Error(data.message);
                            return Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message
                            });
                        })
                        .then(() => location.reload())
                        .catch(error => Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message || 'Terjadi kesalahan sistem.'
                        }));
                });
            });
        });

        const modalEditPendaftaran = document.getElementById('modalEditPendaftaran');
        const formEditPendaftaran = document.getElementById('formEditPendaftaran');
        const btnSimpanEditPendaftaran = document.getElementById('btnSimpanEditPendaftaran');
        const editFotoCurrentWrapper = document.getElementById('editFotoCurrentWrapper');
        const editFotoPreview = document.getElementById('editFotoPreview');
        const editHapusFoto = document.getElementById('editHapusFoto');
        const editFotoJamaah = document.getElementById('editFotoJamaah');
        const pendaftaranBaseUrl = '<?= base_url('admin/pendaftaran'); ?>';

        if (editFotoJamaah && editHapusFoto) {
            editFotoJamaah.addEventListener('change', function() {
                if (this.files.length > 0) {
                    editHapusFoto.checked = false;
                }
            });
            editHapusFoto.addEventListener('change', function() {
                if (this.checked) {
                    editFotoJamaah.value = '';
                }
            });
        }

        document.querySelectorAll('.btn-edit-pendaftaran').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editIdPendaftaran').value = this.dataset.id;
                document.getElementById('editNamaPemesan').value = this.dataset.namaPemesan;
                document.getElementById('editNoWaPemesan').value = this.dataset.noWa;
                document.getElementById('editNamaDiumrahkan').value = this.dataset.namaDiumrahkan;
                document.getElementById('editPaketPilihan').value = this.dataset.paket;

                if (editFotoJamaah) {
                    editFotoJamaah.value = '';
                }
                if (editHapusFoto) {
                    editHapusFoto.checked = false;
                }

                if (this.dataset.foto && this.dataset.fotoUrl) {
                    if (editFotoPreview) editFotoPreview.src = this.dataset.fotoUrl;
                    if (editFotoCurrentWrapper) editFotoCurrentWrapper.classList.remove('d-none');
                } else {
                    if (editFotoPreview) editFotoPreview.src = '';
                    if (editFotoCurrentWrapper) editFotoCurrentWrapper.classList.add('d-none');
                }

                bootstrap.Modal.getOrCreateInstance(modalEditPendaftaran).show();
            });
        });

        formEditPendaftaran.addEventListener('submit', async function(event) {
            event.preventDefault();
            const registrationId = document.getElementById('editIdPendaftaran').value;
            btnSimpanEditPendaftaran.disabled = true;
            btnSimpanEditPendaftaran.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span> Menyimpan...';

            try {
                const response = await fetch(`${pendaftaranBaseUrl}/${registrationId}/edit`, {
                    method: 'POST',
                    body: new FormData(this)
                });
                const data = await response.json();
                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Data pendaftar gagal diperbarui.');
                }

                bootstrap.Modal.getOrCreateInstance(modalEditPendaftaran).hide();
                if (data.url_pdf) {
                    window.open(data.url_pdf, '_blank');
                }
                await Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                location.reload();
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: error.message || 'Data pendaftar gagal diperbarui.' });
            } finally {
                btnSimpanEditPendaftaran.disabled = false;
                btnSimpanEditPendaftaran.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan';
            }
        });

        const modalArsipVideo = document.getElementById('modalArsipVideo');
        const videoArsipNama = document.getElementById('videoArsipNama');
        const daftarVideoArsip = document.getElementById('daftarVideoArsip');
        const formUnggahVideo = document.getElementById('formUnggahVideo');
        const btnUnggahVideo = document.getElementById('btnUnggahVideo');
        const videoBaseUrl = pendaftaranBaseUrl;
        let activePendaftaranVideoId = null;

        const formatUkuranVideo = bytes => {
            if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(0)} KB`;
            return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
        };

        const copyShareText = async (text, fallbackUrl = '') => {
            let copied = false;
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(text);
                    copied = true;
                } catch (error) {
                    console.warn('Clipboard access unavailable; falling back to textarea.', error);
                }
            }

            if (!copied) {
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.setAttribute('readonly', '');
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();
                    copied = document.execCommand('copy');
                    document.body.removeChild(textarea);
                } catch (err) {
                    console.warn('execCommand copy failed.', err);
                }
            }

            if (!copied) {
                window.prompt('Salin teks dan tautan ini:', text || fallbackUrl);
            }
            return copied;
        };

        const requestVideoJson = async (url, options = {}) => {
            const response = await fetch(url, options);
            let data;
            try {
                data = await response.json();
            } catch (err) {
                if (response.status === 413) {
                    throw new Error('Ukuran berkas video terlalu besar untuk server (413 Request Entity Too Large). Periksa konfigurasi web server (misal: client_max_body_size pada Nginx).');
                }
                throw new Error(`Permintaan ke server gagal (Status ${response.status}: ${response.statusText || 'Error'}).`);
            }
            if (!response.ok || data.status !== 'success') {
                throw new Error(data.message || 'Permintaan arsip video gagal.');
            }
            return data;
        };

        const updateButtonVideoBadge = (pendaftaranId, count) => {
            const btn = document.querySelector(`.btn-video-arsip[data-id="${pendaftaranId}"]`);
            if (!btn) return;

            let badge = btn.querySelector('.badge-video-count');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light badge-video-count';
                badge.style.fontSize = '0.65rem';
                badge.style.padding = '0.25em 0.45em';
                badge.style.minWidth = '1.25rem';
                btn.appendChild(badge);
            }

            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('d-none');
                btn.title = `Arsip Video Dokumentasi (${count} video)`;
            } else {
                badge.textContent = '0';
                badge.classList.add('d-none');
                btn.title = 'Arsip Video Dokumentasi (0 video)';
            }
        };

        const loadVideoArchive = async () => {
            daftarVideoArsip.textContent = 'Memuat daftar video...';
            const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos`);
            daftarVideoArsip.replaceChildren();

            if (data && Array.isArray(data.videos)) {
                updateButtonVideoBadge(activePendaftaranVideoId, data.videos.length);
            }

            if (data.videos.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'text-muted small py-2';
                empty.textContent = 'Belum ada video yang diarsipkan untuk pendaftar ini.';
                daftarVideoArsip.append(empty);
                return;
            }

            data.videos.forEach(video => {
                const item = document.createElement('div');
                item.className = 'd-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 p-3 bg-white border rounded-3';

                const details = document.createElement('div');
                details.className = 'min-w-0';
                const filename = document.createElement('div');
                filename.className = 'fw-semibold text-break';
                filename.textContent = video.original_name;
                const metadata = document.createElement('div');
                metadata.className = 'text-muted small';
                const uploadedAt = video.created_at
                    ? new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(video.created_at.replace(' ', 'T')))
                    : '';
                metadata.textContent = `${formatUkuranVideo(video.file_size)}${uploadedAt ? ` · Diunggah ${uploadedAt}` : ''}`;
                details.append(filename, metadata);

                const actions = document.createElement('div');
                actions.className = 'd-flex gap-2 flex-shrink-0';
                const downloadLink = document.createElement('a');
                downloadLink.className = 'btn btn-sm btn-outline-success rounded-pill';
                downloadLink.href = video.download_url;
                downloadLink.target = '_blank';
                downloadLink.rel = 'noopener';
                downloadLink.setAttribute('aria-label', `Unduh video ${video.original_name}`);
                downloadLink.innerHTML = '<i class="fa-solid fa-download"></i>';
                const shareButton = document.createElement('button');
                shareButton.type = 'button';
                shareButton.className = `btn btn-sm rounded-pill ${video.share_url ? 'btn-success' : 'btn-outline-primary'} btn-bagikan-video`;
                shareButton.dataset.id = video.id;
                shareButton.dataset.shareUrl = video.share_url || '';
                shareButton.dataset.videoName = video.original_name || '';
                shareButton.setAttribute('aria-label', video.share_url ? `Salin tautan video ${video.original_name}` : `Buat tautan video ${video.original_name}`);
                shareButton.title = video.share_url ? 'Salin tautan berbagi' : 'Buat tautan berbagi';
                shareButton.innerHTML = video.share_url
                    ? '<i class="fa-solid fa-link"></i>'
                    : '<i class="fa-solid fa-share-nodes"></i>';
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'btn btn-sm btn-outline-danger rounded-pill btn-hapus-video';
                deleteButton.dataset.id = video.id;
                deleteButton.setAttribute('aria-label', `Hapus video ${video.original_name}`);
                deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                actions.append(downloadLink, shareButton);
                if (video.share_url) {
                    const revokeButton = document.createElement('button');
                    revokeButton.type = 'button';
                    revokeButton.className = 'btn btn-sm btn-outline-warning rounded-pill btn-cabut-bagikan-video';
                    revokeButton.dataset.id = video.id;
                    revokeButton.setAttribute('aria-label', `Cabut tautan video ${video.original_name}`);
                    revokeButton.title = 'Cabut tautan berbagi';
                    revokeButton.innerHTML = '<i class="fa-solid fa-link-slash"></i>';
                    actions.append(revokeButton);
                }
                actions.append(deleteButton);
                item.append(details, actions);
                daftarVideoArsip.append(item);
            });
        };

        document.querySelectorAll('.btn-video-arsip').forEach(button => {
            button.addEventListener('click', function() {
                activePendaftaranVideoId = this.dataset.id;
                videoArsipNama.textContent = this.dataset.nama;
                formUnggahVideo.reset();
                bootstrap.Modal.getOrCreateInstance(modalArsipVideo).show();
                loadVideoArchive().catch(error => {
                    daftarVideoArsip.textContent = error.message;
                });
            });
        });

        formUnggahVideo.addEventListener('submit', async function(event) {
            event.preventDefault();

            const input = document.getElementById('inputVideoDokumentasi');
            const files = input ? input.files : [];
            const maxClientBytes = 500 * 1024 * 1024;
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxClientBytes) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar',
                        text: `Berkas "${files[i].name}" (${(files[i].size / (1024 * 1024)).toFixed(1)} MB) melebihi batas maksimal 500 MB.`
                    });
                    return;
                }
            }

            btnUnggahVideo.disabled = true;
            btnUnggahVideo.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span> Mengunggah...';

            try {
                const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos`, {
                    method: 'POST',
                    body: new FormData(this)
                });
                this.reset();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                loadVideoArchive().catch(error => {
                    daftarVideoArsip.textContent = error.message;
                });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Unggah Gagal', text: error.message || 'Video gagal diarsipkan.' });
            } finally {
                btnUnggahVideo.disabled = false;
                btnUnggahVideo.innerHTML = '<i class="fa-solid fa-cloud-arrow-up me-1"></i> Unggah ke Arsip';
            }
        });

        daftarVideoArsip.addEventListener('click', async event => {
            const shareButton = event.target.closest('.btn-bagikan-video');
            if (shareButton) {
                try {
                    let shareUrl = shareButton.dataset.shareUrl;
                    if (!shareUrl) {
                        const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos/${shareButton.dataset.id}/share`, {
                            method: 'POST'
                        });
                        shareUrl = data.share_url;
                        await loadVideoArchive();
                    }

                    const namaJamaah = (videoArsipNama.textContent || '').trim();
                    const shareTitle = namaJamaah
                        ? `Video Dokumentasi Badal Umrah - ${namaJamaah}`
                        : 'Video Dokumentasi Badal Umrah';
                    const shareText = `${shareTitle}\n\n${shareUrl}`;

                    await copyShareText(shareText, shareUrl);
                    Swal.fire({
                        icon: 'success',
                        title: 'Tautan & Judul Disalin!',
                        html: `Teks judul dan tautan video telah disalin ke clipboard:<div class="mt-3 p-2 bg-light border rounded text-start small font-monospace user-select-all text-break"><strong>${shareTitle}</strong><br><br><a href="${shareUrl}" target="_blank" class="text-success text-decoration-none">${shareUrl}</a></div>`,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#198754'
                    });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: error.message || 'Tautan video gagal disiapkan atau disalin.' });
                }
                return;
            }

            const revokeButton = event.target.closest('.btn-cabut-bagikan-video');
            if (revokeButton) {
                const confirmation = await Swal.fire({
                    title: 'Cabut tautan berbagi?',
                    text: 'Tautan yang sudah dibagikan tidak akan dapat diputar lagi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, cabut tautan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545'
                });
                if (!confirmation.isConfirmed) return;

                try {
                    const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos/${revokeButton.dataset.id}/unshare`, {
                        method: 'POST'
                    });
                    await loadVideoArchive();
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: error.message || 'Tautan gagal dicabut.' });
                }
                return;
            }

            const button = event.target.closest('.btn-hapus-video');
            if (!button) return;

            const confirmation = await Swal.fire({
                title: 'Hapus video?',
                text: 'Video ini akan dihapus permanen dari arsip.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545'
            });
            if (!confirmation.isConfirmed) return;

            try {
                const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos/${button.dataset.id}/hapus`, {
                    method: 'POST'
                });
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                loadVideoArchive().catch(error => {
                    daftarVideoArsip.textContent = error.message;
                });
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: error.message || 'Video gagal dihapus.' });
            }
        });

        // ================= Mozilla PDF.js Preview Modal =================
        const modalPreviewPdf = document.getElementById('modalPreviewPdf');
        const pdfViewerWrapper = document.getElementById('pdfViewerWrapper');
        const pdfPagesContainer = document.getElementById('pdfPagesContainer');
        const pdfLoadingSpinner = document.getElementById('pdfLoadingSpinner');
        const pdfErrorNotice = document.getElementById('pdfErrorNotice');
        const pdfErrorMessage = document.getElementById('pdfErrorMessage');
        const btnPdfZoomOut = document.getElementById('btnPdfZoomOut');
        const btnPdfZoomFit = document.getElementById('btnPdfZoomFit');
        const btnPdfZoomIn = document.getElementById('btnPdfZoomIn');
        const pdfZoomLabel = document.getElementById('pdfZoomLabel');

        const previewPdfNamaJamaah = document.getElementById('previewPdfNamaJamaah');
        const previewPdfUuid = document.getElementById('previewPdfUuid');
        const btnSalinLinkPdf = document.getElementById('btnSalinLinkPdf');
        const btnDownloadPdf = document.getElementById('btnDownloadPdf');
        const btnBukaTabPdf = document.getElementById('btnBukaTabPdf');
        const btnWaPdf = document.getElementById('btnWaPdf');
        const btnFallbackDownloadPdf = document.getElementById('btnFallbackDownloadPdf');
        const btnFallbackTabPdf = document.getElementById('btnFallbackTabPdf');

        let currentPdfUrl = '';
        let currentPdfShareUrl = '';
        let currentPdfNama = '';
        let currentPdfUuid = '';

        let currentPdfDoc = null;
        let currentPdfLoadingTask = null;
        let currentRenderTasks = [];
        let currentZoomScale = 1.0;
        let isZoomFit = true;

        if (window.pdfjsLib) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }

        const updateZoomLabel = () => {
            if (!pdfZoomLabel) return;
            const pct = Math.round((isZoomFit ? 1.0 : currentZoomScale) * 100);
            pdfZoomLabel.textContent = `${pct}%`;
        };

        const cancelAllRenderTasks = () => {
            currentRenderTasks.forEach(task => {
                try { task.cancel(); } catch (e) {}
            });
            currentRenderTasks = [];
        };

        const renderPdfDocument = async () => {
            if (!currentPdfDoc || !pdfPagesContainer || !pdfViewerWrapper) return;

            cancelAllRenderTasks();
            pdfPagesContainer.innerHTML = '';
            if (pdfLoadingSpinner) pdfLoadingSpinner.classList.remove('d-none');
            if (pdfErrorNotice) pdfErrorNotice.classList.add('d-none');

            try {
                const numPages = currentPdfDoc.numPages;
                const wrapperWidth = pdfViewerWrapper.clientWidth > 0
                    ? pdfViewerWrapper.clientWidth
                    : (window.innerWidth < 768 ? window.innerWidth - 32 : 720);
                const availableWidth = Math.max(260, wrapperWidth - 28);

                const firstPage = await currentPdfDoc.getPage(1);
                const unscaledViewport = firstPage.getViewport({ scale: 1.0 });
                const baseFitScale = availableWidth / unscaledViewport.width;
                const effectiveScale = isZoomFit ? baseFitScale : (baseFitScale * currentZoomScale);
                updateZoomLabel();

                const pixelRatio = Math.min(window.devicePixelRatio || 1, 2.5);

                for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                    const page = (pageNum === 1) ? firstPage : await currentPdfDoc.getPage(pageNum);
                    const viewport = page.getViewport({ scale: effectiveScale });

                    const pageWrapper = document.createElement('div');
                    pageWrapper.className = 'pdf-page-wrapper my-2 position-relative text-center w-100 d-flex justify-content-center';

                    const canvas = document.createElement('canvas');
                    canvas.className = 'pdf-canvas shadow rounded bg-white';
                    const context = canvas.getContext('2d');

                    canvas.width = Math.floor(viewport.width * pixelRatio);
                    canvas.height = Math.floor(viewport.height * pixelRatio);
                    canvas.style.width = Math.floor(viewport.width) + 'px';
                    canvas.style.height = Math.floor(viewport.height) + 'px';

                    const transform = pixelRatio !== 1 ? [pixelRatio, 0, 0, pixelRatio, 0, 0] : null;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                        transform: transform
                    };

                    pageWrapper.appendChild(canvas);

                    if (numPages > 1) {
                        const badge = document.createElement('div');
                        badge.className = 'badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 end-0 m-2 px-2 py-1 small rounded';
                        badge.textContent = `${pageNum} / ${numPages}`;
                        pageWrapper.appendChild(badge);
                    }

                    pdfPagesContainer.appendChild(pageWrapper);

                    const renderTask = page.render(renderContext);
                    currentRenderTasks.push(renderTask);
                    await renderTask.promise;
                }

                if (pdfLoadingSpinner) pdfLoadingSpinner.classList.add('d-none');
            } catch (err) {
                if (err && err.name === 'RenderingCancelledException') {
                    return;
                }
                console.error('PDF.js render error:', err);
                if (pdfLoadingSpinner) pdfLoadingSpinner.classList.add('d-none');
                if (pdfErrorNotice) {
                    pdfErrorNotice.classList.remove('d-none');
                    if (pdfErrorMessage) {
                        pdfErrorMessage.textContent = err.message || 'Gagal memproses pratinjau halaman PDF.';
                    }
                }
            }
        };

        const loadAndRenderPdf = async (url) => {
            if (!url) return;

            cancelAllRenderTasks();
            if (currentPdfLoadingTask) {
                try { currentPdfLoadingTask.destroy(); } catch (e) {}
                currentPdfLoadingTask = null;
            }
            if (currentPdfDoc) {
                try { currentPdfDoc.destroy(); } catch (e) {}
                currentPdfDoc = null;
            }

            if (pdfPagesContainer) pdfPagesContainer.innerHTML = '';
            if (pdfLoadingSpinner) pdfLoadingSpinner.classList.remove('d-none');
            if (pdfErrorNotice) pdfErrorNotice.classList.add('d-none');

            isZoomFit = true;
            currentZoomScale = 1.0;
            updateZoomLabel();

            if (!window.pdfjsLib) {
                if (pdfLoadingSpinner) pdfLoadingSpinner.classList.add('d-none');
                if (pdfErrorNotice) {
                    pdfErrorNotice.classList.remove('d-none');
                    if (pdfErrorMessage) {
                        pdfErrorMessage.textContent = 'Library Mozilla PDF.js belum selesai dimuat. Silakan periksa koneksi internet Anda atau gunakan tombol unduh.';
                    }
                }
                return;
            }

            try {
                currentPdfLoadingTask = pdfjsLib.getDocument({
                    url: url,
                    withCredentials: false
                });
                currentPdfDoc = await currentPdfLoadingTask.promise;
                await renderPdfDocument();
            } catch (err) {
                if (err && err.name === 'RenderingCancelledException') return;
                console.error('PDF.js getDocument error:', err);
                if (pdfLoadingSpinner) pdfLoadingSpinner.classList.add('d-none');
                if (pdfErrorNotice) {
                    pdfErrorNotice.classList.remove('d-none');
                    if (pdfErrorMessage) {
                        pdfErrorMessage.textContent = err.message || 'Berkas PDF tidak dapat diakses atau dimuat oleh browser.';
                    }
                }
            }
        };

        // Zoom button event handlers
        if (btnPdfZoomIn) {
            btnPdfZoomIn.addEventListener('click', function() {
                if (!currentPdfDoc) return;
                isZoomFit = false;
                currentZoomScale = Math.min(3.0, Math.round((currentZoomScale + 0.25) * 100) / 100);
                renderPdfDocument();
            });
        }
        if (btnPdfZoomOut) {
            btnPdfZoomOut.addEventListener('click', function() {
                if (!currentPdfDoc) return;
                isZoomFit = false;
                currentZoomScale = Math.max(0.5, Math.round((currentZoomScale - 0.25) * 100) / 100);
                renderPdfDocument();
            });
        }
        if (btnPdfZoomFit) {
            btnPdfZoomFit.addEventListener('click', function() {
                if (!currentPdfDoc) return;
                isZoomFit = true;
                currentZoomScale = 1.0;
                renderPdfDocument();
            });
        }

        // Window resize debounce
        let pdfResizeTimeout = null;
        window.addEventListener('resize', function() {
            if (!modalPreviewPdf || !modalPreviewPdf.classList.contains('show') || !currentPdfDoc) return;
            if (isZoomFit) {
                clearTimeout(pdfResizeTimeout);
                pdfResizeTimeout = setTimeout(() => {
                    renderPdfDocument();
                }, 200);
            }
        });

        const escapeHtml = str => String(str).replace(/[&<>"']/g, match => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[match]));

        document.addEventListener('click', function(event) {
            const button = event.target.closest('.btn-preview-pdf');
            if (!button) return;

            currentPdfUrl = button.dataset.url || '';
            currentPdfShareUrl = button.dataset.shareUrl || currentPdfUrl;
            currentPdfNama = (button.dataset.nama || '').trim();
            currentPdfUuid = (button.dataset.uuid || '').trim();

            if (previewPdfNamaJamaah) {
                previewPdfNamaJamaah.textContent = currentPdfNama ? `Jamaah: ${currentPdfNama}` : '';
            }
            if (previewPdfUuid) {
                previewPdfUuid.textContent = currentPdfUuid ? `ID: ${currentPdfUuid}` : '';
            }

            const safeNama = (currentPdfNama || 'Jamaah').replace(/[^a-zA-Z0-9_\-]/g, '_');
            const downloadFilename = `Sertifikat-Badal-Umrah-${safeNama}.pdf`;

            if (btnDownloadPdf) {
                btnDownloadPdf.href = currentPdfUrl;
                btnDownloadPdf.setAttribute('download', downloadFilename);
            }
            if (btnFallbackDownloadPdf) {
                btnFallbackDownloadPdf.href = currentPdfUrl;
                btnFallbackDownloadPdf.setAttribute('download', downloadFilename);
            }

            if (btnBukaTabPdf) {
                btnBukaTabPdf.href = currentPdfUrl;
            }
            if (btnFallbackTabPdf) {
                btnFallbackTabPdf.href = currentPdfUrl;
            }

            if (btnWaPdf) {
                const shareTitle = `Sertifikat Badal Umrah - ${currentPdfNama || 'Jamaah'}`;
                const shareTargetUrl = currentPdfShareUrl || currentPdfUrl;
                const waText = `${shareTitle}\n\n${shareTargetUrl}`;
                btnWaPdf.href = `https://wa.me/?text=${encodeURIComponent(waText)}`;
            }

            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalPreviewPdf);
            modalInstance.show();

            // Load and render PDF with Mozilla PDF.js
            loadAndRenderPdf(currentPdfUrl);
        });

        if (modalPreviewPdf) {
            modalPreviewPdf.addEventListener('shown.bs.modal', function() {
                if (currentPdfDoc && isZoomFit) {
                    renderPdfDocument();
                }
            });

            modalPreviewPdf.addEventListener('hidden.bs.modal', function() {
                cancelAllRenderTasks();
                if (currentPdfLoadingTask) {
                    try { currentPdfLoadingTask.destroy(); } catch (e) {}
                    currentPdfLoadingTask = null;
                }
                if (currentPdfDoc) {
                    try { currentPdfDoc.destroy(); } catch (e) {}
                    currentPdfDoc = null;
                }
                if (pdfPagesContainer) pdfPagesContainer.innerHTML = '';
                if (pdfLoadingSpinner) pdfLoadingSpinner.classList.remove('d-none');
                if (pdfErrorNotice) pdfErrorNotice.classList.add('d-none');
            });
        }

        if (btnSalinLinkPdf) {
            btnSalinLinkPdf.addEventListener('click', async function() {
                if (!currentPdfUrl) return;

                const shareTitle = `Sertifikat Badal Umrah - ${currentPdfNama || 'Jamaah'}`;
                const shareTargetUrl = currentPdfShareUrl || currentPdfUrl;
                const shareText = `${shareTitle}\n\n${shareTargetUrl}`;

                try {
                    await copyShareText(shareText, shareTargetUrl);

                    const originalHtml = btnSalinLinkPdf.innerHTML;
                    btnSalinLinkPdf.className = 'btn btn-success rounded-pill px-3 shadow-sm btn-sm';
                    btnSalinLinkPdf.innerHTML = '<i class="fa-solid fa-check me-1"></i> Disalin!';
                    setTimeout(() => {
                        btnSalinLinkPdf.className = 'btn btn-outline-success rounded-pill px-3 shadow-sm btn-sm';
                        btnSalinLinkPdf.innerHTML = originalHtml;
                    }, 2500);

                    Swal.fire({
                        icon: 'success',
                        title: 'Tautan & Format Disalin!',
                        html: `Format teks dan tautan sertifikat berhasil disalin ke clipboard:<div class="mt-3 p-3 bg-light border rounded text-start small font-monospace user-select-all text-break"><strong>${escapeHtml(shareTitle)}</strong><br><br><a href="${shareTargetUrl}" target="_blank" class="text-success text-decoration-none">${shareTargetUrl}</a></div>`,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#198754'
                    });
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Tautan sertifikat gagal disalin.'
                    });
                }
            });
        }

        // Submit Form ke Backend
        document.getElementById('formProsesSertifikat').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            bootstrap.Modal.getInstance(document.getElementById('modalProses')).hide();

            Swal.fire({
                title: 'Sedang Memproses...',
                text: 'Mencetak sertifikat...',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('admin/proses-sertifikat') ?>', {
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
                            showDenyButton: true,
                            confirmButtonText: '<i class="fa fa-file-pdf"></i> Lihat PDF',
                            denyButtonText: 'Tutup',
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom',
                                confirmButton: 'swal-btn-custom btn-danger',
                                denyButton: 'swal-btn-custom btn-light text-dark'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open(data.url_pdf, '_blank');
                            }
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                            customClass: {
                                popup: 'swal-mobile-custom'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.',
                        customClass: {
                            popup: 'swal-mobile-custom'
                        }
                    });
                    console.error(error);
                });
        });

        // Preview Foto pada Modal Input Pendaftaran Manual
        const tambahFotoJamaah = document.getElementById('tambahFotoJamaah');
        const tambahFotoPreviewWrapper = document.getElementById('tambahFotoPreviewWrapper');
        const tambahFotoPreview = document.getElementById('tambahFotoPreview');
        const tambahFotoNama = document.getElementById('tambahFotoNama');
        const tambahFotoUkuran = document.getElementById('tambahFotoUkuran');
        const btnHapusPreviewTambahFoto = document.getElementById('btnHapusPreviewTambahFoto');
        const modalTambahPendaftarEl = document.getElementById('modalTambahPendaftar');

        function formatBytesFoto(bytes, decimals = 1) {
            if (!bytes || bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function resetTambahFotoPreview() {
            if (tambahFotoJamaah) tambahFotoJamaah.value = '';
            if (tambahFotoPreview) tambahFotoPreview.src = '';
            if (tambahFotoNama) tambahFotoNama.textContent = '';
            if (tambahFotoUkuran) tambahFotoUkuran.textContent = '';
            if (tambahFotoPreviewWrapper) tambahFotoPreviewWrapper.classList.add('d-none');
        }

        if (tambahFotoJamaah) {
            tambahFotoJamaah.addEventListener('change', function() {
                const file = this.files && this.files[0];
                if (!file) {
                    resetTambahFotoPreview();
                    return;
                }

                // Validasi format file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Format Gambar Tidak Sesuai',
                        text: 'Pilih file gambar dengan format JPG, PNG, atau WEBP.',
                        customClass: { popup: 'swal-mobile-custom' }
                    });
                    resetTambahFotoPreview();
                    return;
                }

                // Validasi ukuran file (maksimal 5 MB)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran Terlalu Besar',
                        text: 'Ukuran file gambar maksimal adalah 5 MB.',
                        customClass: { popup: 'swal-mobile-custom' }
                    });
                    resetTambahFotoPreview();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (tambahFotoPreview) tambahFotoPreview.src = e.target.result;
                    if (tambahFotoNama) tambahFotoNama.textContent = file.name;
                    if (tambahFotoUkuran) tambahFotoUkuran.textContent = formatBytesFoto(file.size);
                    if (tambahFotoPreviewWrapper) tambahFotoPreviewWrapper.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            });
        }

        if (btnHapusPreviewTambahFoto) {
            btnHapusPreviewTambahFoto.addEventListener('click', function() {
                resetTambahFotoPreview();
            });
        }

        if (modalTambahPendaftarEl) {
            modalTambahPendaftarEl.addEventListener('hidden.bs.modal', function() {
                document.getElementById('formTambahPendaftar').reset();
                resetTambahFotoPreview();
            });
        }

        // Submit Form Tambah Pendaftar Manual
        document.getElementById('formTambahPendaftar').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            bootstrap.Modal.getInstance(document.getElementById('modalTambahPendaftar')).hide();

            Swal.fire({
                title: 'Menyimpan Data...',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Mendaur ulang endpoint submit form frontend
            fetch('<?= base_url('pendaftaran/submit') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        resetTambahFotoPreview();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: `Data ditambahkan dengan No. Registrasi:<br><strong class="fs-4 text-success">${data.uuid}</strong>`,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                            customClass: {
                                popup: 'swal-mobile-custom'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.',
                        customClass: {
                            popup: 'swal-mobile-custom'
                        }
                    });
                });
        });
    </script>
</body>

</html>