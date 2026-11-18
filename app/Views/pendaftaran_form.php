<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Form Pendaftaran Badal Umrah - Azis Rustandi</title>
    <meta name="title" content="Azis Rustandi - Layanan Badal Umrah Amanah">
    <meta name="description" content="Jasa Badal Umrah terpercaya untuk orang tercinta yang sudah meninggal atau udzur syar'i. Amanah, bersertifikat resmi, dan didokumentasikan lengkap.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('pendaftaran'); ?>">
    <meta property="og:title" content="Form Pendaftaran Badal Umrah - Azis Rustandi">
    <meta property="og:description" content="Menghadirkan Cinta dan Doa di Tanah Suci untuk Mereka yang Tercinta. Layanan Badal Umrah profesional dengan sertifikat eksklusif.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Form Pendaftaran Badal Umrah - Azis Rustandi">
    <meta name="twitter:description" content="Menghadirkan Cinta dan Doa di Tanah Suci untuk Mereka yang Tercinta. Layanan Badal Umrah profesional dengan sertifikat eksklusif.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
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
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame sg-frame--compact">
        <!-- Sticky Top Bar -->
        <header class="sg-topbar">
            <a href="<?= base_url('/'); ?>" class="sg-brand" aria-label="Kembali ke Beranda Azis Rustandi">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Azis Rustandi" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Azis Rustandi</span>
                    <span class="sg-brand__sub">Pendaftaran Badal Umrah</span>
                </div>
            </a>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>
                <a href="<?= base_url('/'); ?>" class="sg-icon-btn" aria-label="Kembali ke Beranda">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="sg-btn-label">Kembali</span>
                </a>
            </div>
        </header>

        <!-- Main Glass Container -->
        <main id="main-content" class="sg-pane sg-main">
            <header class="sg-phead mb-4 pb-3 border-bottom">
                <div>
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-file-signature"></i>
                        <span>Formulir Resmi</span>
                    </div>
                    <h1 class="sg-h1">Formulir Pendaftaran</h1>
                    <p class="sg-phead__sub">Silakan lengkapi data di bawah ini untuk pendaftaran Badal Umrah.</p>
                </div>
            </header>

            <section class="sg-card sg-card--highlight">
                <form id="formPendaftaran" enctype="multipart/form-data">
                    <h2 class="sg-card__title mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>Data Pemesan (Keluarga)</span>
                    </h2>

                    <div class="mb-3">
                        <label for="inputNamaPemesan" class="form-label small">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                        <input id="inputNamaPemesan" type="text" name="nama_pemesan" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="mb-4">
                        <label for="inputNoWaPemesan" class="form-label small">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input id="inputNoWaPemesan" type="number" name="no_wa_pemesan" class="form-control" placeholder="Contoh: 08123456789" required>
                        <div class="form-text" style="font-size: 0.74rem;">Nomor ini akan digunakan untuk mengirimkan update dan dokumentasi.</div>
                    </div>

                    <h2 class="sg-card__title mb-3 pb-2 border-bottom mt-4">
                        <i class="fa-solid fa-kaaba"></i>
                        <span>Data Almarhum / Jamaah</span>
                    </h2>

                    <div class="mb-3">
                        <label for="inputNamaDiumrahkan" class="form-label small">Nama Lengkap yang Di-umrahkan <span class="text-danger">*</span></label>
                        <input id="inputNamaDiumrahkan" type="text" name="nama_diumrahkan" class="form-control" placeholder="Contoh: H. Fulan bin Fulan" required>
                        <div class="form-text" style="font-size: 0.74rem;">Tuliskan nama lengkap beserta nama ayah (Bin/Binti).</div>
                    </div>

                    <div class="mb-3">
                        <label for="inputFotoJamaah" class="form-label small">Foto untuk Sertifikat <span class="sg-text-muted fw-normal">(Opsional)</span></label>
                        <input id="inputFotoJamaah" type="file" name="foto_jamaah" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text" style="font-size: 0.74rem;">Format JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4 pada sertifikat.</div>
                    </div>

                    <div class="mb-4">
                        <label for="selectPaketPilihan" class="form-label small">Pilihan Paket <span class="text-danger">*</span></label>
                        <select id="selectPaketPilihan" name="paket_pilihan" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                            <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                        </select>
                    </div>

                    <button type="submit" class="sg-btn sg-btn--sig w-100 py-2">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </form>
            </section>

            <div class="text-center mt-4 sg-text-muted small">
                <p class="mb-0"><i class="fa-solid fa-lock me-1 sg-text-sig"></i> Data Anda dijamin kerahasiaan dan keamanannya.</p>
            </div>
        </main>
    </div>

    <!-- Script Proses Form -->
    <script>
        document.getElementById('formPendaftaran').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            Swal.fire({
                title: 'Menyimpan Data...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('pendaftaran/submit') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Alhamdulillah, Terdaftar!',
                            html: `Pendaftaran Anda telah kami terima.<br><br><b>Nomor Registrasi:</b><br><span class="sg-text-sig" style="font-size:1.2rem; font-weight:bold;">${data.uuid}</span><br><br><small>Mohon simpan nomor registrasi di atas untuk keperluan pengecekan sertifikat.</small>`,
                            confirmButtonText: 'Selesai',
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        }).then(() => {
                            document.getElementById('formPendaftaran').reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pendaftaran Gagal',
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
                        title: 'Error Server',
                        text: 'Terjadi kendala pada sistem kami. Silakan coba lagi nanti.',
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
