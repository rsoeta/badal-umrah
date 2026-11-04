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
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Favicon yang Benar -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo.png'); ?>" />

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
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-admin shadow-sm mb-4 py-3">
        <div class="container-fluid px-md-4">
            <a class="navbar-brand mb-0 h1 fs-5 text-white text-decoration-none" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-kaaba me-2 text-warning"></i> Admin Panel
            </a>

            <div class="d-flex gap-2 align-items-center">
                <a href="<?= base_url('/'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm" target="_blank">
                    <i class="fa-solid fa-globe me-1"></i> <span class="d-none d-sm-inline">Web</span>
                </a>

                <a href="<?= base_url('admin/pengaturan'); ?>" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm text-success fw-bold">
                    <i class="fa-solid fa-sliders me-1"></i> <span class="d-none d-sm-inline">Pengaturan</span>
                </a>

                <a href="<?= base_url('admin/sampah'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-trash me-1"></i> Sampah
                    <?php if ($jumlah_sampah > 0): ?>
                        <span class="badge bg-warning text-dark ms-1"><?= $jumlah_sampah; ?></span>
                    <?php endif; ?>
                </a>

                <a href="#" id="btn-logout" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">
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
                                <td><?= $i++; ?></td>
                                <td>
                                    <div>
                                        <strong class="text-dark d-block mb-1"><?= $row['uuid']; ?></strong>

                                        <?php
                                        // FORMAT NOMOR WA AGAR LINK WA.ME BERFUNGSI (Ubah awalan '0' jadi '62')
                                        $no_wa_clean = preg_replace('/[^0-9]/', '', $row['no_wa_pemesan']);
                                        if (substr($no_wa_clean, 0, 1) === '0') {
                                            $no_wa_clean = '62' . substr($no_wa_clean, 1);
                                        }
                                        ?>

                                        <!-- Link WA Clickable -->
                                        <a href="https://wa.me/<?= $no_wa_clean; ?>" target="_blank" class="text-success text-decoration-none fw-medium bg-success bg-opacity-10 px-2 py-1 rounded">
                                            <i class="fa-brands fa-whatsapp"></i> <?= $row['nama_pemesan']; ?>
                                        </a>
                                    </div>
                                </td>
                                <td class="fw-bold text-success fs-6"><?= $row['nama_diumrahkan']; ?></td>
                                <td><span class="badge bg-light text-dark border p-2"><?= $row['paket_pilihan']; ?></span></td>
                                <td>
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-dark rounded-pill p-2"><i class="fa-regular fa-clock me-1"></i> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success rounded-pill p-2"><i class="fa-solid fa-check-double me-1"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <button class="btn btn-primary rounded-pill px-3 btn-proses shadow-sm"
                                                data-id="<?= $row['id']; ?>"
                                                data-nama="<?= esc($row['nama_diumrahkan'], 'attr'); ?>">
                                                <i class="fa-solid fa-gear me-1"></i> Proses
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('storage/certificates/' . $row['uuid'] . '.pdf'); ?>" target="_blank" class="btn btn-outline-danger rounded-pill px-3 shadow-sm"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                        <?php endif; ?>
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

    <!-- Modal Tambah Pendaftar Manual -->
    <div class="modal fade" id="modalTambahPendaftar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i> Input Pendaftaran Manual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTambahPendaftar">
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
                        <div class="mb-2">
                            <label class="form-label text-muted fw-bold small">Pilihan Paket</label>
                            <select name="paket_pilihan" class="form-select rounded-3" required>
                                <option value="">-- Pilih Paket --</option>
                                <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa-solid fa-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Eksekusi -->
    <div class="modal fade" id="modalProses" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
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
                                <option value="">-- Pilih Ustaz --</option>
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
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold">Tgl Miqat</label>
                                <input type="date" name="tanggal_miqat" class="form-control rounded-3" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold">Tgl Cetak</label>
                                <input type="date" name="tanggal_cetak" class="form-control rounded-3" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label text-muted fw-bold">Koreksi Hijriah (Opsional)</label>
                            <input type="number" name="koreksi_hijriah" class="form-control rounded-3" value="0">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-4 pt-0">
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

    <script>
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
        document.querySelectorAll('.btn-proses').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('id_pendaftaran').value = this.getAttribute('data-id');
                document.getElementById('lbl_nama_diumrahkan').innerText = this.getAttribute('data-nama');

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

                    fetch(`<?= base_url('admin/pendaftaran'); ?>/${id}/hapus`, { method: 'POST' })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status !== 'success') throw new Error(data.message);
                            return Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                        })
                        .then(() => location.reload())
                        .catch(error => Swal.fire({ icon: 'error', title: 'Gagal', text: error.message || 'Terjadi kesalahan sistem.' }));
                });
            });
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