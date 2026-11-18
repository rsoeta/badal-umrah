<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <?php
    $pageTitle = 'Sertifikat Badal Umrah - ' . $namaDiumrahkan;
    $metaDescription = 'Sertifikat resmi pelaksanaan Badal Umrah atas nama ' . $namaDiumrahkan
        . (! empty($namaPelaksana) ? ' oleh ' . $namaPelaksana : '')
        . '. Amanah, transparan, dan terpercaya.';
    ?>

    <title><?= esc($pageTitle); ?> | Badal Umrah</title>
    <meta name="title" content="<?= esc($pageTitle); ?>">
    <meta name="description" content="<?= esc($metaDescription); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= esc($shareUrl); ?>">
    <meta property="og:title" content="<?= esc($pageTitle); ?>">
    <meta property="og:description" content="<?= esc($metaDescription); ?>">
    <meta property="og:image" content="<?= esc($urlJpg); ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="850">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($shareUrl); ?>">
    <meta name="twitter:title" content="<?= esc($pageTitle); ?>">
    <meta name="twitter:description" content="<?= esc($metaDescription); ?>">
    <meta name="twitter:image" content="<?= esc($urlJpg); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .certificate-frame {
            position: relative;
            background: rgba(12, 14, 16, 0.72);
            border-radius: var(--r-lg);
            padding: 10px;
            box-shadow: inset 0 0 0 1px var(--glass-rim), var(--shadow-md);
        }

        .certificate-img {
            width: 100%;
            height: auto;
            border-radius: var(--r-md);
            display: block;
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

    <div class="sg-frame sg-frame--narrow">
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
                <a href="<?= base_url(); ?>#cek-sertifikat" class="sg-icon-btn sg-icon-btn--sig" aria-label="Cek Lainnya">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Cek Lainnya</span>
                </a>
            </div>
        </header>

        <!-- Main Glass Container -->
        <main id="main-content" class="sg-pane sg-main">
            <section class="sg-card sg-card--highlight">
                <!-- Header Sertifikat -->
                <div class="text-center mb-4">
                    <span class="sg-pill sg-pill--good mb-2">
                        <i class="fa-solid fa-certificate"></i> Sertifikat Resmi Badal Umrah
                    </span>
                    <h1 class="sg-h1 mt-2 mb-1">
                        <?= esc($namaDiumrahkan); ?>
                    </h1>
                    <p class="sg-text-muted small mb-0 font-monospace">
                        No. Registrasi: <strong class="sg-text-ink"><?= esc($uuid); ?></strong>
                    </p>
                </div>

                <!-- Pratinjau Gambar Sertifikat -->
                <div class="certificate-frame mb-4">
                    <a href="<?= esc($urlJpg); ?>" target="_blank" rel="noopener" title="Klik untuk melihat resolusi penuh">
                        <img src="<?= esc($urlJpg); ?>" alt="Sertifikat Badal Umrah <?= esc($namaDiumrahkan); ?>" class="certificate-img">
                    </a>
                </div>

                <!-- Tombol Aksi Cepat -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <a href="<?= esc($urlPdf); ?>" download class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="fa-solid fa-file-pdf me-2"></i> Unduh PDF Resmi
                    </a>
                    <a href="<?= esc($urlJpg); ?>" download class="sg-btn sg-btn--glass">
                        <i class="fa-solid fa-image"></i> Unduh Gambar JPG
                    </a>
                    <button type="button" id="btnSalinTautan" class="sg-btn sg-btn--sig">
                        <i class="fa-solid fa-share-nodes"></i> Salin Tautan
                    </button>
                    <a href="https://wa.me/?text=<?= rawurlencode("Sertifikat Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>" target="_blank" rel="noopener" class="sg-btn sg-btn--wa">
                        <i class="fa-brands fa-whatsapp"></i> Bagikan ke WA
                    </a>
                </div>

                <!-- Informasi Rincian Sertifikat -->
                <div class="sg-subpanel mb-3">
                    <h2 class="sg-card__title mb-3">
                        <i class="fa-solid fa-circle-info"></i> Rincian Pelaksanaan Badal Umrah
                    </h2>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Nama yang Diumrahkan</div>
                            <div class="meta-value"><?= esc($namaDiumrahkan); ?></div>
                        </div>
                        <?php if (! empty($namaPelaksana)): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Pelaksana / Mutawwif</div>
                            <div class="meta-value"><?= esc($namaPelaksana); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (! empty($pendaftaran['nama_pemesan'])): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Keluarga / Pemesan</div>
                            <div class="meta-value"><?= esc($pendaftaran['nama_pemesan']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (! empty($paketPilihan)): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Paket Pilihan</div>
                            <div class="meta-value"><?= esc($paketPilihan); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (! empty($tempatMiqat)): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Tempat Miqat</div>
                            <div class="meta-value"><?= esc($tempatMiqat); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (! empty($tanggalMiqat)): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Tanggal Miqat</div>
                            <div class="meta-value"><?= esc($tanggalMiqat); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (! empty($tanggalCetak)): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Tanggal Penerbitan</div>
                            <div class="meta-value"><?= esc($tanggalCetak); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Arsip Video Terkait jika ada -->
                <?php if (! empty($videos)): ?>
                <div class="sg-subpanel">
                    <h2 class="sg-card__title mb-3">
                        <i class="fa-solid fa-video"></i> Dokumentasi Video Pelaksanaan
                    </h2>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($videos as $v): ?>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-film sg-text-sig"></i>
                                <span class="fw-semibold small sg-text-ink"><?= esc($v['original_name']); ?></span>
                            </div>
                            <a href="<?= base_url('video/' . esc($v['share_token'])); ?>" target="_blank" class="sg-btn sg-btn--glass btn-sm py-1 px-3">
                                <i class="fa-solid fa-play"></i> Tonton Video
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </main>

        <footer class="sg-footer">
            <span>Layanan Badal Umrah Amanah &amp; Terpercaya</span>
            <span>&copy; <?= date('Y'); ?> Seluruh hak cipta dilindungi.</span>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('btnSalinTautan').addEventListener('click', async function() {
            const shareTitle = "<?= addslashes(esc($pageTitle)); ?>";
            const shareUrl = "<?= addslashes(esc($shareUrl)); ?>";
            const textToCopy = `${shareTitle}\n\n${shareUrl}`;

            let copied = false;
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(textToCopy);
                    copied = true;
                } catch (e) {}
            }

            if (!copied) {
                const textarea = document.createElement('textarea');
                textarea.value = textToCopy;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    copied = document.execCommand('copy');
                } catch (e) {}
                document.body.removeChild(textarea);
            }

            if (copied) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tautan Disalin!',
                    text: 'Tautan sertifikat telah disalin ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                window.prompt('Salin tautan berikut:', textToCopy);
            }
        });
    </script>
</body>

</html>
