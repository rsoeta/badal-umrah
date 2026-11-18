<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <?php
    $pageTitle = ! empty($namaDiumrahkan)
        ? 'Video Dokumentasi Tidak Tersedia - ' . $namaDiumrahkan
        : 'Video Dokumentasi Tidak Tersedia';
    $ogDesc = ! empty($namaDiumrahkan)
        ? 'Informasi video dokumentasi pelaksanaan Badal Umrah atas nama ' . $namaDiumrahkan . '. Tautan video saat ini tidak tersedia atau telah dihapus.'
        : 'Informasi video dokumentasi pelaksanaan Badal Umrah yang tidak tersedia atau telah dihapus. Hubungi Admin / Pelaksana untuk bantuan.';
    ?>

    <title><?= esc($pageTitle); ?> | Badal Umrah</title>
    <meta name="title" content="<?= esc($pageTitle); ?>">
    <meta name="description" content="<?= esc($ogDesc); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= esc($shareUrl ?? current_url()); ?>">
    <meta property="og:title" content="<?= esc($pageTitle); ?> | Badal Umrah">
    <meta property="og:description" content="<?= esc($ogDesc); ?>">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="600">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="<?= esc($shareUrl ?? current_url()); ?>">
    <meta name="twitter:title" content="<?= esc($pageTitle); ?> | Badal Umrah">
    <meta name="twitter:description" content="<?= esc($ogDesc); ?>">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .icon-box-warning {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: var(--sig-soft);
            color: var(--sig-text);
            box-shadow: inset 0 0 0 1px var(--sig-border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 2.3rem;
        }

        .meta-label {
            font-size: var(--fs-2xs);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            font-weight: 700;
        }

        .meta-value {
            font-weight: 600;
            color: var(--ink);
            word-break: break-word;
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame sg-frame--compact">
        <!-- Sticky Top Bar -->
        <header class="sg-topbar">
            <a class="sg-brand" href="<?= base_url(); ?>">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Badal Umrah" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Badal Umrah</span>
                    <span class="sg-brand__sub">Amanah &amp; Terpercaya</span>
                </div>
            </a>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>
                <a href="<?= base_url(); ?>" class="sg-icon-btn" aria-label="Beranda">
                    <i class="fa-solid fa-house"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Beranda</span>
                </a>
                <a href="<?= base_url(); ?>#cek-sertifikat" class="sg-icon-btn sg-icon-btn--sig" aria-label="Cek Sertifikat">
                    <i class="fa-solid fa-certificate"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Cek Sertifikat</span>
                </a>
            </div>
        </header>

        <!-- Konten Utama -->
        <main id="main-content" class="sg-pane sg-main">
            <section class="sg-card sg-card--highlight text-center">
                <!-- Ikon Peringatan -->
                <div class="icon-box-warning">
                    <i class="fa-solid fa-video-slash"></i>
                </div>

                <!-- Badge Status -->
                <div class="mb-2">
                    <span class="sg-pill sg-pill--bad">
                        <i class="fa-solid fa-circle-exclamation"></i> Video Tidak Tersedia
                    </span>
                </div>

                <!-- Judul Utama -->
                <h1 class="sg-h1 mt-2 mb-2">
                    Video Dokumentasi Tidak Ditemukan
                </h1>

                <!-- Penjelasan Ramah -->
                <p class="sg-text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                    <?php if (! empty($namaDiumrahkan)): ?>
                        Mohon maaf, tautan video dokumentasi pelaksanaan Badal Umrah atas nama <strong class="sg-text-ink"><?= esc($namaDiumrahkan); ?></strong> sudah tidak dapat diakses karena berkas video telah dihapus dari server arsip atau masa aktif tautan telah berakhir.
                    <?php else: ?>
                        Mohon maaf, tautan video dokumentasi yang Anda tuju sudah tidak tersedia atau telah dihapus dari sistem penyimpanan kami.
                    <?php endif; ?>
                </p>

                <!-- Rincian Informasi jika tersedia -->
                <?php if (! empty($namaDiumrahkan) || ! empty($namaPelaksana) || ! empty($namaPemesan)): ?>
                <div class="sg-subpanel text-start mb-4">
                    <h2 class="sg-card__title mb-3">
                        <i class="fa-solid fa-circle-info"></i> Rincian Pelaksanaan
                    </h2>
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
                <div class="sg-subpanel text-start mb-4 d-flex align-items-start gap-3">
                    <div class="text-success fs-3 mt-1 flex-shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="fw-bold sg-text-ink mb-1">Butuh Bantuan atau Salinan Video?</div>
                        <div class="small sg-text-muted mb-0" style="line-height: 1.5;">
                            Bagi keluarga jamaah atau pihak pemesan yang memerlukan kembali arsip video atau informasi terkait pelaksanaan badal umrah ini, silakan hubungi langsung <strong class="sg-text-ink">Admin / Pelaksana Badal Umrah</strong>. Kami dengan senang hati akan membantu Anda.
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Utama: WhatsApp -->
                <div class="d-grid gap-2 mb-3">
                    <a href="<?= esc($waAdminUrl); ?>" target="_blank" rel="noopener" class="sg-btn sg-btn--wa py-3">
                        <i class="fa-brands fa-whatsapp fs-5"></i> Hubungi Admin / Pelaksana via WhatsApp
                    </a>
                </div>

                <!-- Tombol Pendukung: Kembali / Cek Sertifikat -->
                <div class="d-flex flex-wrap justify-content-center gap-2 pt-2">
                    <a href="<?= base_url(); ?>#cek-sertifikat" class="sg-btn sg-btn--sig">
                        <i class="fa-solid fa-certificate"></i> Cek Sertifikat Badal Umrah
                    </a>
                    <a href="<?= base_url(); ?>" class="sg-btn sg-btn--glass">
                        <i class="fa-solid fa-house"></i> Kembali ke Halaman Utama
                    </a>
                </div>
            </section>
        </main>

        <footer class="sg-footer">
            <span>Layanan Badal Umrah Amanah &amp; Terpercaya</span>
            <span>&copy; <?= date('Y'); ?> Seluruh hak cipta dilindungi.</span>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
