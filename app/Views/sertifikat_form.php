<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Generator Sertifikat Badal Umrah</title>
    <meta name="title" content="Generator Sertifikat Badal Umrah">
    <meta name="description" content="Formulir pembuatan dan cetak sertifikat resmi pelaksanaan Badal Umrah. Amanah, transparan, dan terpercaya.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('sertifikat'); ?>">
    <meta property="og:title" content="Generator Sertifikat Badal Umrah">
    <meta property="og:description" content="Pembuatan dan cetak sertifikat resmi pelaksanaan Badal Umrah. Amanah, transparan, dan terpercaya.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Generator Sertifikat Badal Umrah">
    <meta name="twitter:description" content="Pembuatan dan cetak sertifikat resmi pelaksanaan Badal Umrah.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .swal-mobile-custom {
            font-size: 0.85rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
        }

        .swal-title-custom {
            font-size: 1.1rem !important;
        }

        .swal-btn-custom {
            padding: 8px 16px !important;
            font-size: 0.85rem !important;
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame sg-frame--compact">
        <!-- Sticky Top Bar -->
        <header class="sg-topbar">
            <a href="<?= base_url('/'); ?>" class="sg-brand" aria-label="Beranda Badal Umrah">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Badal Umrah" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Badal Umrah</span>
                    <span class="sg-brand__sub">Generator Sertifikat</span>
                </div>
            </a>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>
                <a href="<?= base_url('/'); ?>" class="sg-icon-btn" aria-label="Beranda">
                    <i class="fa-solid fa-house"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Beranda</span>
                </a>
            </div>
        </header>

        <main id="main-content" class="sg-pane sg-main">
            <header class="sg-phead mb-4 pb-3 border-bottom">
                <div>
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-certificate"></i>
                        <span>Penerbitan Dokumen Resmi</span>
                    </div>
                    <h1 class="sg-h1">Sertifikat Badal Umrah</h1>
                    <p class="sg-phead__sub">Buat dan unduh sertifikat PDF/JPG secara langsung.</p>
                </div>
            </header>

            <section class="sg-card sg-card--highlight">
                <form id="formSertifikat" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="selectPelaksanaData" class="form-label small">Nama Pelaksana</label>
                        <select id="selectPelaksanaData" name="pelaksana_data" class="form-select" required>
                            <option value="">-- Pilih Pelaksana --</option>
                            <option value="Ust. Azis Rustandi|ttd-azis.png">Ust. Azis Rustandi</option>
                            <option value="Ust. Ahmad Fadil|ttd-ahmad.png">Ust. Ahmad Fadil</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="inputNamaDiumrahkanSertifikat" class="form-label small">Nama Di-umrahkan</label>
                        <input id="inputNamaDiumrahkanSertifikat" type="text" name="nama_diumrahkan" class="form-control" required placeholder="Contoh: Hj. Siti Aminah binti Fulan">
                    </div>

                    <div class="mb-3">
                        <label for="inputNomorRegistrasi" class="form-label small">Nomor Registrasi (Opsional)</label>
                        <input id="inputNomorRegistrasi" type="text" name="nomor_registrasi" class="form-control" placeholder="Otomatis jika dikosongkan (RCP-<?= date('Y') ?>-XXXXXX)">
                    </div>

                    <div class="mb-3">
                        <label for="inputFotoSertifikat" class="form-label small">Foto untuk Sertifikat (Opsional)</label>
                        <input id="inputFotoSertifikat" type="file" name="foto_jamaah" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4.</div>
                    </div>

                    <div class="mb-3">
                        <label for="inputTempatMiqatForm" class="form-label small">Tempat Miqat</label>
                        <?php
                        $defaultValue = ! empty($default_miqat) ? $default_miqat : "Tan'im, Makkah Al-Mukarramah";
                        $options = ! empty($list_miqat) ? $list_miqat : [
                            ['nama_miqat' => "Tan'im, Makkah Al-Mukarramah"],
                            ['nama_miqat' => 'Bir Ali (Zulhulaifah)'],
                            ['nama_miqat' => "Ji'ranah"],
                            ['nama_miqat' => 'Hudaibiyah'],
                            ['nama_miqat' => 'Yalamlam'],
                            ['nama_miqat' => 'Qarnul Manazil'],
                        ];
                        ?>
                        <input id="inputTempatMiqatForm" type="text" name="tempat_miqat" class="form-control" list="listMiqatForm" placeholder="Pilih atau ketik tempat miqat..." value="<?= esc($defaultValue, 'attr'); ?>" required>
                        <datalist id="listMiqatForm">
                            <?php foreach ($options as $opt): ?>
                                <option value="<?= esc(is_array($opt) ? ($opt['nama_miqat'] ?? '') : (string) $opt, 'attr'); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="inputTanggalMiqatForm" class="form-label small">Tanggal Miqat (Masehi)</label>
                            <input id="inputTanggalMiqatForm" type="date" name="tanggal_miqat" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="inputTanggalCetakForm" class="form-label small">Tanggal Cetak (Masehi)</label>
                            <input id="inputTanggalCetakForm" type="date" name="tanggal_cetak" class="form-control" required>
                        </div>
                    </div>

                    <div class="sg-subpanel mb-4">
                        <label for="inputKoreksiHijriahForm" class="form-label small mb-1">Koreksi Selisih Hari Hijriah (Jika Ada)</label>
                        <p class="sg-text-muted mb-2" style="font-size: 0.75rem;">
                            Isi <b>1</b> atau <b>-1</b> jika penanggalan Hijriah hari ini meleset. Biarkan 0 jika sudah pas.
                        </p>
                        <input id="inputKoreksiHijriahForm" type="number" name="koreksi_hijriah" class="form-control" value="0" required>
                    </div>

                    <button type="submit" class="sg-btn sg-btn--sig w-100 py-2">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Sertifikat
                    </button>
                </form>
            </section>
        </main>
    </div>

    <script>
        document.getElementById('formSertifikat').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang membuat sertifikat, mohon tunggu.',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('sertifikat/generate') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Sertifikat gagal dibuat.',
                            customClass: {
                                popup: 'swal-mobile-custom'
                            }
                        });
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: 'Sertifikat berhasil di-generate.',
                        showDenyButton: true,
                        confirmButtonText: '<i class="fa fa-file-pdf"></i> Buka PDF',
                        denyButtonText: '<i class="fa fa-image"></i> Buka JPG',
                        customClass: {
                            popup: 'swal-mobile-custom',
                            title: 'swal-title-custom',
                            confirmButton: 'swal-btn-custom',
                            denyButton: 'swal-btn-custom'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(data.url_pdf, '_blank');
                        } else if (result.isDenied) {
                            window.open(data.url_jpg, '_blank');
                        }
                    });
                    document.getElementById('formSertifikat').reset();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.',
                        customClass: {
                            popup: 'swal-mobile-custom'
                        }
                    });
                    console.error('Error:', error);
                });
        });
    </script>

</body>

</html>
