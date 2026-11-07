<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Badal Umrah</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Favicon yang Benar -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

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

        /* ... Sisa CSS Lainnya ... */

        h4,
        .h1,
        .h5,
        .h6 {
            font-weight: 700;
        }

        .navbar-admin {
            background-color: #0f3d23;
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
            font-family: 'Quicksand', sans-serif !important;
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
            font-size: 0.9rem;
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
                border: 1px solid #e5e9e6;
                border-radius: 0.9rem;
                background: #fff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            #pendaftarTable tbody td {
                display: grid;
                grid-template-columns: minmax(6rem, 34%) minmax(0, 1fr);
                align-items: start;
                gap: 0.5rem;
                width: 100% !important;
                padding: 0.65rem 0;
                border: 0;
                border-bottom: 1px solid #edf0ee;
                text-align: left !important;
                white-space: normal !important;
                overflow-wrap: anywhere;
            }

            #pendaftarTable tbody td:last-child {
                border-bottom: 0;
            }

            #pendaftarTable tbody td::before {
                content: attr(data-label);
                color: #66736b;
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
            border: 1px solid #e5e9e6;
            border-radius: 1rem;
            background: #fff;
        }

        .date-field-card .input-group-text {
            color: #0f3d23;
            background: #f1f6f2;
            border-color: #dee5df;
        }

        .date-field-card .form-control {
            border-color: #dee5df;
        }

        .date-field-card .form-control:focus {
            border-color: #6a9c7d;
            box-shadow: 0 0 0 0.2rem rgba(15, 61, 35, 0.12);
        }

        .flatpickr-calendar {
            z-index: 1060;
        }

        @media (max-width: 575.98px) {
            .navbar-admin .navbar-actions {
                gap: 0.25rem !important;
                margin-left: auto;
                flex-wrap: nowrap;
            }

            .navbar-admin .navbar-actions .btn {
                padding-right: 0.5rem !important;
                padding-left: 0.5rem !important;
                flex-shrink: 0;
            }

            .navbar-admin .navbar-brand {
                flex-shrink: 0;
                margin-right: 0.25rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-admin shadow-sm mb-4 py-3">
        <div class="container-fluid px-md-4">
            <a class="navbar-brand mb-0 h1 fs-5 text-white text-decoration-none" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-kaaba me-2 text-warning"></i> Admin Panel
            </a>

            <div class="d-flex gap-2 align-items-center navbar-actions">
                <a href="<?= base_url('/'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm" target="_blank" aria-label="Buka Web">
                    <i class="fa-solid fa-globe me-1"></i> <span class="d-none d-sm-inline">Web</span>
                </a>

                <a href="<?= base_url('admin/pengaturan'); ?>" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm text-success fw-bold" aria-label="Pengaturan">
                    <i class="fa-solid fa-sliders me-1"></i> <span class="d-none d-sm-inline">Pengaturan</span>
                </a>

                <a href="<?= base_url('admin/sampah'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm" aria-label="Sampah">
                    <i class="fa-solid fa-trash me-1"></i><span class="d-none d-sm-inline">Sampah</span>
                    <?php if ($jumlah_sampah > 0): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= $jumlah_sampah; ?></span>
                    <?php endif; ?>
                </a>

                <a href="#" id="btn-logout" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm" aria-label="Logout">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> <span class="d-none d-sm-inline">Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-md-4">
        <!-- Header Tabel Responsif (Tidak akan tergencet lagi di HP) -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2 pb-2 border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-success"></i>Daftar Pendaftar</h5>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPendaftar">
                    <i class="fa-solid fa-user-plus me-1"></i> Tambah Data
                </button>
                <span class="badge bg-secondary rounded-pill px-3 py-2 fs-6"><?= count($pendaftar); ?> Total</span>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
            <div class="card-body p-0">
                <table id="pendaftarTable" class="table table-hover mb-0 align-middle table-custom w-100">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>No</th>
                            <th>Registrasi & Pemesan</th>
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
                                        <strong class="text-dark d-block mb-1"><?= esc($row['uuid']); ?></strong>

                                        <?php
                                        // FORMAT NOMOR WA AGAR LINK WA.ME BERFUNGSI (Ubah awalan '0' jadi '62')
                                        $no_wa_clean = preg_replace('/[^0-9]/', '', $row['no_wa_pemesan']);
                                        if (substr($no_wa_clean, 0, 1) === '0') {
                                            $no_wa_clean = '62' . substr($no_wa_clean, 1);
                                        }
                                        ?>

                                        <!-- Link WA Clickable -->
                                        <a href="https://wa.me/<?= $no_wa_clean; ?>" target="_blank" class="text-success text-decoration-none fw-medium bg-success bg-opacity-10 px-2 py-1 rounded">
                                            <i class="fa-brands fa-whatsapp"></i> <?= esc($row['nama_pemesan']); ?>
                                        </a>
                                    </div>
                                </td>
                                <td data-label="Di-umrahkan" class="fw-bold text-success fs-6">
                                    <?= esc($row['nama_diumrahkan']); ?>
                                    <?php if (! empty($row['foto_jamaah'])): ?>
                                        <span class="badge bg-info text-dark">Foto disertakan</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Paket"><span class="badge bg-light text-dark border p-2"><?= esc($row['paket_pilihan']); ?></span></td>
                                <td data-label="Status">
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-dark rounded-pill p-2"><i class="fa-regular fa-clock me-1"></i> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success rounded-pill p-2"><i class="fa-solid fa-check-double me-1"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <button class="btn btn-primary rounded-pill px-3 btn-proses shadow-sm"
                                                data-id="<?= $row['id']; ?>"
                                                data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                                data-koreksi-hijriah="<?= esc((string) $koreksi_hijriah, 'attr'); ?>">
                                                <i class="fa-solid fa-gear me-1"></i>Proses
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('storage/certificates/' . $row['uuid'] . '.pdf'); ?>" target="_blank" class="btn btn-outline-danger rounded-pill px-3 shadow-sm"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-outline-primary rounded-pill btn-edit-pendaftaran"
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
                                        <button type="button" class="btn btn-outline-success rounded-pill btn-video-arsip"
                                            data-id="<?= $row['id']; ?>"
                                            data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            aria-label="Arsip video dokumentasi untuk <?= esc($row['nama_diumrahkan'], 'attr'); ?>"
                                            title="Arsip Video Dokumentasi">
                                            <i class="fa-solid fa-video"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary rounded-pill btn-hapus-pendaftaran"
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
            </div>
        </div>
    </div>

    <!-- Modal Edit Pendaftaran -->
    <div class="modal fade" id="modalEditPendaftaran" tabindex="-1" aria-labelledby="modalEditPendaftaranLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold" id="modalEditPendaftaranLabel"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Data Pendaftar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="formEditPendaftaran" enctype="multipart/form-data">
                    <div class="modal-body p-4 bg-light">
                        <input type="hidden" name="id_pendaftaran" id="editIdPendaftaran">
                        <div class="mb-3">
                            <label for="editNamaPemesan" class="form-label text-muted fw-bold small">Nama Lengkap Pemesan</label>
                            <input type="text" name="nama_pemesan" id="editNamaPemesan" class="form-control rounded-3" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNoWaPemesan" class="form-label text-muted fw-bold small">Nomor WhatsApp</label>
                            <input type="tel" name="no_wa_pemesan" id="editNoWaPemesan" class="form-control rounded-3" maxlength="20" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaDiumrahkan" class="form-label text-muted fw-bold small">Nama yang Di-umrahkan</label>
                            <input type="text" name="nama_diumrahkan" id="editNamaDiumrahkan" class="form-control rounded-3" maxlength="150" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFotoJamaah" class="form-label text-muted fw-bold small">Foto untuk Sertifikat (Opsional)</label>
                            <div id="editFotoCurrentWrapper" class="d-none mb-2 p-2 bg-white border rounded-3 d-flex align-items-center gap-3">
                                <img id="editFotoPreview" src="" alt="Foto Jamaah" class="rounded border" style="width: 50px; height: 65px; object-fit: cover;">
                                <div class="small">
                                    <div class="fw-semibold text-dark"><i class="fa-solid fa-image text-primary me-1"></i> Foto Saat Ini Tersedia</div>
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
                            <label for="editPaketPilihan" class="form-label text-muted fw-bold small">Pilihan Paket</label>
                            <select name="paket_pilihan" id="editPaketPilihan" class="form-select rounded-3" required>
                                <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanEditPendaftaran" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Arsip Video Dokumentasi -->
    <div class="modal fade" id="modalArsipVideo" tabindex="-1" aria-labelledby="modalArsipVideoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white border-0 rounded-top-4">
                    <div>
                        <h5 class="modal-title fw-bold" id="modalArsipVideoLabel"><i class="fa-solid fa-video me-2"></i>Arsip Video Dokumentasi</h5>
                        <div class="small text-white-50" id="videoArsipNama"></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <form id="formUnggahVideo" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="inputVideoDokumentasi" class="form-label fw-bold">Tambah video</label>
                            <input type="file" id="inputVideoDokumentasi" name="videos[]" class="form-control" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" multiple required>
                            <div class="form-text">Pilih satu atau beberapa video. Format MP4, WEBM, atau MOV; maksimal 500 MB per video.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="btnUnggahVideo" class="btn btn-success rounded-pill px-4">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Unggah ke Arsip
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">Video yang Diarsipkan</h6>
                    <div id="daftarVideoArsip" class="d-flex flex-column gap-2" aria-live="polite">
                        <div class="text-muted small">Memuat daftar video...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pendaftar Manual -->
    <div class="modal fade" id="modalTambahPendaftar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i> Input Pendaftaran Manual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTambahPendaftar" enctype="multipart/form-data">
                    <div class="modal-body p-4 bg-light">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small">Nama Lengkap Pemesan</label>
                            <input type="text" name="nama_pemesan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small">Nomor WhatsApp</label>
                            <input type="number" name="no_wa_pemesan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small">Nama Yang Di-umrahkan</label>
                            <input type="text" name="nama_diumrahkan" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small">Foto untuk Sertifikat (Opsional)</label>
                            <input type="file" name="foto_jamaah" class="form-control rounded-3" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4.</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-muted fw-bold small">Pilihan Paket</label>
                            <select name="paket_pilihan" class="form-select rounded-3" required>
                                <option value="">-- Pilih Paket --</option>
                                <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa-solid fa-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Eksekusi -->
    <div class="modal fade" id="modalProses" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-signature me-2"></i> Generate Sertifikat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProsesSertifikat">
                    <div class="modal-body p-4 bg-light">
                        <input type="hidden" name="id_pendaftaran" id="id_pendaftaran">

                        <div class="alert alert-success py-3 px-3 mb-4 rounded-3" style="border-left: 5px solid #0f3d23;">
                            Eksekusi untuk: <br><strong id="lbl_nama_diumrahkan" class="fs-5"></strong>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Mutawwif Pelaksana</label>
                            <select name="pelaksana_data" class="form-select rounded-3" required>
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
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="date-field-card">
                                    <label for="tanggalMiqat" class="form-label fw-bold text-dark">
                                        <i class="fa-solid fa-kaaba me-2 text-success"></i>Tanggal Miqat
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
                                    <label for="tanggalCetak" class="form-label fw-bold text-dark">
                                        <i class="fa-solid fa-file-circle-check me-2 text-success"></i>Tanggal Cetak Sertifikat
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
                            <label class="form-label text-muted fw-bold">Koreksi Hijriah (Opsional)</label>
                            <input type="number" name="koreksi_hijriah" id="inputKoreksiHijriah" class="form-control rounded-3" step="1" value="<?= esc((string) $koreksi_hijriah); ?>">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm"><i class="fa-solid fa-print me-1"></i> Simpan & Generate</button>
                    </div>
                </form>
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

        document.querySelectorAll('.btn-proses').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('id_pendaftaran').value = this.getAttribute('data-id');
                document.getElementById('lbl_nama_diumrahkan').innerText = this.getAttribute('data-nama');
                document.getElementById('inputKoreksiHijriah').value = this.getAttribute('data-koreksi-hijriah') || '0';

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
                window.prompt('Salin teks dan tautan video ini:', text || fallbackUrl);
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

        const loadVideoArchive = async () => {
            daftarVideoArsip.textContent = 'Memuat daftar video...';
            const data = await requestVideoJson(`${videoBaseUrl}/${activePendaftaranVideoId}/videos`);
            daftarVideoArsip.replaceChildren();

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