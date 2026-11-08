<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $pageTitle = ! empty($namaDiumrahkan)
        ? 'Video Dokumentasi Tidak Tersedia - ' . $namaDiumrahkan
        : 'Video Dokumentasi Tidak Tersedia';
    ?>

    <title><?= esc($pageTitle); ?> | Badal Umrah</title>
    <meta name="title" content="<?= esc($pageTitle); ?>">
    <meta name="description" content="Informasi video dokumentasi pelaksanaan Badal Umrah yang tidak tersedia atau telah dihapus.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-dark: #0f3d23;
            --green-light: #1b5633;
            --gold: #b8924b;
            --gold-light: #d8bc7e;
            --bg-cream: #f4f1ea;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-cream);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .text-gold {
            color: var(--gold);
        }

        .text-green {
            color: var(--green-dark);
        }

        .bg-green {
            background-color: var(--green-dark);
        }

        .btn-gold {
            background-color: var(--gold);
            color: white;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: #9c7b3e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(184, 146, 75, 0.3);
        }

        .btn-wa-action {
            background-color: #25D366;
            color: #ffffff;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-wa-action:hover {
            background-color: #1eb956;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.35);
        }

        .card-custom {
            border: none;
            border-top: 5px solid var(--gold);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .icon-box-warning {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background-color: rgba(184, 146, 75, 0.12);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 2.5rem;
        }

        .meta-box {
            background-color: #faf8f5;
            border: 1px solid #ede7dd;
            border-radius: 12px;
            padding: 18px;
        }

        .meta-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            font-weight: 500;
        }

        .meta-value {
            font-weight: 600;
            color: var(--green-dark);
            word-break: break-word;
        }

        footer {
            margin-top: auto;
            background-color: #0d2818;
            color: #bbb;
        }
    </style>
</head>

<body>
    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg bg-green navbar-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url(); ?>">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Badal Umrah" height="38" class="d-inline-block align-text-top">
                <div class="d-flex flex-column">
                    <span class="font-serif fw-bold fs-5 text-white lh-1">Badal Umrah</span>
                    <span class="small text-gold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Amanah & Terpercaya</span>
                </div>
            </a>
            <div class="d-flex gap-2">
                <a href="<?= base_url(); ?>" class="btn btn-sm btn-outline-light rounded-pill px-3">
                    <i class="fa-solid fa-house me-1"></i> Beranda
                </a>
                <a href="<?= base_url(); ?>#cek-sertifikat" class="btn btn-sm btn-gold rounded-pill px-3">
                    <i class="fa-solid fa-certificate me-1"></i> Cek Sertifikat
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card-custom p-4 p-md-5 text-center">

                    <!-- Ikon Peringatan -->
                    <div class="icon-box-warning">
                        <i class="fa-solid fa-video-slash"></i>
                    </div>

                    <!-- Badge Status -->
                    <div>
                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 mb-2">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> Video Tidak Tersedia
                        </span>
                    </div>

                    <!-- Judul Utama -->
                    <h1 class="font-serif fw-bold text-green fs-2 mt-2 mb-2">
                        Video Dokumentasi Tidak Ditemukan
                    </h1>

                    <!-- Penjelasan Ramah -->
                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                        <?php if (! empty($namaDiumrahkan)): ?>
                            Mohon maaf, tautan video dokumentasi pelaksanaan Badal Umrah atas nama <strong><?= esc($namaDiumrahkan); ?></strong> sudah tidak dapat diakses karena berkas video telah dihapus dari server arsip atau masa aktif tautan telah berakhir.
                        <?php else: ?>
                            Mohon maaf, tautan video dokumentasi yang Anda tuju sudah tidak tersedia atau telah dihapus dari sistem penyimpanan kami.
                        <?php endif; ?>
                    </p>

                    <!-- Rincian Informasi jika tersedia -->
                    <?php if (! empty($namaDiumrahkan) || ! empty($namaPelaksana) || ! empty($namaPemesan)): ?>
                    <div class="meta-box text-start mb-4">
                        <h6 class="fw-bold text-green mb-3">
                            <i class="fa-solid fa-circle-info text-gold me-2"></i> Rincian Pelaksanaan
                        </h6>
                        <div class="row g-3">
                            <?php if (! empty($namaDiumrahkan)): ?>
                            <div class="col-sm-6">
                                <div class="meta-label">Nama yang Diumrahkan</div>
                                <div class="meta-value"><?= esc($namaDiumrahkan); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (! empty($namaPelaksana)): ?>
                            <div class="col-sm-6">
                                <div class="meta-label">Pelaksana Badal Umrah</div>
                                <div class="meta-value"><?= esc($namaPelaksana); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (! empty($namaPemesan)): ?>
                            <div class="col-sm-6">
                                <div class="meta-label">Pemesan / Keluarga</div>
                                <div class="meta-value"><?= esc($namaPemesan); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if (! empty($pendaftaran['paket_pilihan'])): ?>
                            <div class="col-sm-6">
                                <div class="meta-label">Paket Badal Umrah</div>
                                <div class="meta-value"><?= esc($pendaftaran['paket_pilihan']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Kotak Petunjuk Kontak -->
                    <div class="alert alert-light border border-success border-opacity-25 rounded-3 text-start p-3 mb-4 shadow-sm" style="background-color: #f7faf7;">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-success fs-3 mt-1 flex-shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-1">Butuh Bantuan atau Salinan Video?</div>
                                <div class="small text-muted mb-0" style="line-height: 1.5;">
                                    Bagi keluarga jamaah atau pihak pemesan yang memerlukan kembali arsip video atau informasi terkait pelaksanaan badal umrah ini, silakan hubungi langsung <strong>Admin / Pelaksana Badal Umrah</strong>. Kami dengan senang hati akan membantu Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi Utama: WhatsApp -->
                    <div class="d-grid gap-2 mb-3">
                        <a href="<?= esc($waAdminUrl); ?>" target="_blank" rel="noopener" class="btn btn-wa-action rounded-pill px-4 py-3 fs-6">
                            <i class="fa-brands fa-whatsapp fs-5 me-2"></i> Hubungi Admin / Pelaksana via WhatsApp
                        </a>
                    </div>

                    <!-- Tombol Pendukung: Kembali / Cek Sertifikat -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 pt-2">
                        <a href="<?= base_url(); ?>#cek-sertifikat" class="btn btn-outline-success rounded-pill px-4 py-2">
                            <i class="fa-solid fa-certificate me-2"></i> Cek Sertifikat Badal Umrah
                        </a>
                        <a href="<?= base_url(); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            <i class="fa-solid fa-house me-2"></i> Kembali ke Halaman Utama
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-muted small mt-auto">
        <div class="container">
            <p class="mb-1">Layanan Badal Umrah Amanah & Terpercaya</p>
            <p class="mb-0 text-white-50">&copy; <?= date('Y'); ?> Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
