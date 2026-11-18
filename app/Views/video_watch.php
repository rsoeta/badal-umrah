<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <?php
    $namaDiumrahkan = ! empty($pendaftaran['nama_diumrahkan']) ? $pendaftaran['nama_diumrahkan'] : 'Jamaah';
    $namaVideo = ! empty($video['original_name']) ? $video['original_name'] : 'Video Dokumentasi';
    $pageTitle = 'Video Dokumentasi Badal Umrah - ' . $namaDiumrahkan;
    $fileSizeFormatted = ($video['file_size'] < 1024 * 1024)
        ? round($video['file_size'] / 1024) . ' KB'
        : number_format($video['file_size'] / (1024 * 1024), 1) . ' MB';
    $tanggalUnggah = ! empty($video['created_at'])
        ? date('d F Y, H:i', strtotime($video['created_at'])) . ' WIB'
        : '-';
    ?>

    <title><?= esc($pageTitle); ?> | Azis Rustandi</title>
    <meta name="title" content="<?= esc($pageTitle); ?>">
    <meta name="description" content="Tonton langsung video dokumentasi pelaksanaan Badal Umrah atas nama <?= esc($namaDiumrahkan); ?>. Amanah, transparan, dan terpercaya.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="video.other">
    <meta property="og:url" content="<?= esc($shareUrl); ?>">
    <meta property="og:title" content="<?= esc($pageTitle); ?>">
    <meta property="og:description" content="Tonton langsung video dokumentasi pelaksanaan Badal Umrah atas nama <?= esc($namaDiumrahkan); ?>.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">
    <meta property="og:video" content="<?= esc($streamUrl); ?>">
    <meta property="og:video:type" content="<?= esc($video['mime_type']); ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($shareUrl); ?>">
    <meta name="twitter:title" content="<?= esc($pageTitle); ?>">
    <meta name="twitter:description" content="Tonton langsung video dokumentasi pelaksanaan Badal Umrah atas nama <?= esc($namaDiumrahkan); ?>.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .video-wrapper {
            position: relative;
            background: #000;
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: inset 0 0 0 1px var(--glass-rim), var(--shadow-md);
        }

        video {
            width: 100%;
            height: auto;
            max-height: 540px;
            display: block;
            outline: none;
            background: #000;
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

        .swal-mobile-custom {
            font-size: 0.85rem !important;
            width: 85% !important;
            border-radius: 12px !important;
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
                <a href="<?= base_url(); ?>#cek-sertifikat" class="sg-icon-btn sg-icon-btn--sig" aria-label="Cek Sertifikat">
                    <i class="fa-solid fa-certificate"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Cek Sertifikat</span>
                </a>
            </div>
        </header>

        <!-- Konten Utama -->
        <main id="main-content" class="sg-pane sg-main">
            <section class="sg-card sg-card--highlight">
                <!-- Header Info -->
                <div class="text-center mb-4">
                    <span class="sg-pill sg-pill--good mb-2">
                        <i class="fa-solid fa-circle-check"></i> Dokumentasi Resmi Pelaksanaan
                    </span>
                    <h1 class="sg-h1 mt-2 mb-1">
                        <?= esc($namaDiumrahkan); ?>
                    </h1>
                </div>

                <!-- Pemutar Video Realtime -->
                <div class="video-wrapper mb-3 position-relative">
                    <video id="playerVideo" controls autoplay playsinline preload="auto">
                        <source src="<?= esc($streamUrl); ?>" type="video/mp4">
                        <?php if ($video['mime_type'] !== 'video/mp4'): ?>
                            <source src="<?= esc($streamUrl); ?>" type="<?= esc($video['mime_type']); ?>">
                        <?php endif; ?>
                        <source src="<?= esc($streamUrl); ?>">
                        Browser Anda tidak mendukung pemutar video HTML5. Silakan unduh berkas video menggunakan tombol di bawah.
                    </video>
                </div>

                <!-- Pemberitahuan jika codec/format video tidak kompatibel di browser tertentu -->
                <div id="videoCodecNotice" class="alert alert-warning d-none text-start p-3 mb-4 rounded-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-exclamation fs-5 mt-1 flex-shrink-0"></i>
                        <div>
                            <div class="fw-semibold">Video Tidak Dapat Diputar Langsung di Browser Ini?</div>
                            <div class="small mb-2">
                                Berkas ini berformat <strong><?= esc($namaVideo); ?></strong> (rekaman iPhone Apple MOV / HEVC). Beberapa browser desktop (seperti Chrome di Windows tanpa codec HEVC) tidak dapat mendekode video format ini di halaman web.
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?= esc($downloadUrl); ?>" class="btn btn-sm btn-success rounded-pill px-3">
                                    <i class="fa-solid fa-download me-1"></i> Unduh Video (<?= esc($fileSizeFormatted); ?>)
                                </a>
                                <a href="https://wa.me/?text=<?= rawurlencode("Video Dokumentasi Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fa-brands fa-whatsapp me-1"></i> Buka di Ponsel / iPhone
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Cepat -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <button type="button" id="btnSalinTautan" class="sg-btn sg-btn--sig">
                        <i class="fa-solid fa-share-nodes"></i> Salin Tautan &amp; Judul
                    </button>
                    <a href="<?= esc($downloadUrl); ?>" class="sg-btn sg-btn--glass">
                        <i class="fa-solid fa-download"></i> Unduh Video (<?= esc($fileSizeFormatted); ?>)
                    </a>
                    <a href="https://wa.me/?text=<?= rawurlencode("Video Dokumentasi Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>" target="_blank" rel="noopener" class="sg-btn sg-btn--wa">
                        <i class="fa-brands fa-whatsapp"></i> Bagikan ke WhatsApp
                    </a>
                </div>

                <!-- Informasi Detail Pendaftaran & Video -->
                <div class="sg-subpanel">
                    <h2 class="sg-card__title mb-3">
                        <i class="fa-solid fa-circle-info"></i> Informasi Pelaksanaan
                    </h2>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Nama yang Diumrahkan</div>
                            <div class="meta-value"><?= esc($namaDiumrahkan); ?></div>
                        </div>
                        <?php if (! empty($pendaftaran['nama_pemesan'])): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="meta-label">Pemesan / Keluarga</div>
                                <div class="meta-value"><?= esc($pendaftaran['nama_pemesan']); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (! empty($pendaftaran['paket_pilihan'])): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="meta-label">Paket Badal Umrah</div>
                                <div class="meta-value"><?= esc($pendaftaran['paket_pilihan']); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (! empty($pendaftaran['tempat_miqat'])): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="meta-label">Tempat Miqat</div>
                                <div class="meta-value"><?= esc($pendaftaran['tempat_miqat']); ?></div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Waktu Pengunggahan</div>
                            <div class="meta-value"><?= esc($tanggalUnggah); ?></div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="meta-label">Ukuran Berkas Video</div>
                            <div class="meta-value"><?= esc($fileSizeFormatted); ?></div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="small sg-text-muted mb-0">
                        Semoga amal ibadah badal umrah ini diterima dan mabrur di sisi Allah SWT. Aamiin ya Rabbal 'Alamin.
                    </p>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="sg-footer">
            <span>&copy; <?= date('Y'); ?> Layanan Badal Umrah Amanah - Azis Rustandi.</span>
            <span>Video dokumentasi ini dibagikan secara resmi untuk keluarga jamaah.</span>
        </footer>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareText = <?= json_encode("Video Dokumentasi Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>;
            const btnSalin = document.getElementById('btnSalinTautan');

            const copyToClipboard = async (text) => {
                let ok = false;
                if (navigator.clipboard && window.isSecureContext) {
                    try {
                        await navigator.clipboard.writeText(text);
                        ok = true;
                    } catch (e) {
                        console.warn('Clipboard API gagal, mencoba fallback.', e);
                    }
                }

                if (!ok) {
                    try {
                        const ta = document.createElement('textarea');
                        ta.value = text;
                        ta.style.position = 'fixed';
                        ta.style.opacity = '0';
                        document.body.appendChild(ta);
                        ta.focus();
                        ta.select();
                        ok = document.execCommand('copy');
                        document.body.removeChild(ta);
                    } catch (err) {
                        console.warn('execCommand copy gagal.', err);
                    }
                }

                if (!ok) {
                    window.prompt('Salin teks dan tautan video ini:', text);
                }
                return ok;
            };

            if (btnSalin) {
                btnSalin.addEventListener('click', async function() {
                    await copyToClipboard(shareText);
                    Swal.fire({
                        icon: 'success',
                        title: 'Tautan & Judul Disalin!',
                        html: `Teks judul dan tautan video berhasil disalin ke clipboard:<div class="mt-3 p-2 border rounded text-start small font-monospace user-select-all text-break">${shareText.replace(/\n\n/g, '<br><br>')}</div>`,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#198754',
                        customClass: {
                            popup: 'swal-mobile-custom'
                        }
                    });
                });
            }

            const playerVideo = document.getElementById('playerVideo');
            const videoCodecNotice = document.getElementById('videoCodecNotice');
            if (playerVideo && videoCodecNotice) {
                const showCodecNotice = () => {
                    videoCodecNotice.classList.remove('d-none');
                };

                playerVideo.addEventListener('error', showCodecNotice, true);
                playerVideo.querySelectorAll('source').forEach(source => {
                    source.addEventListener('error', showCodecNotice);
                });

                setTimeout(() => {
                    if (playerVideo.networkState === HTMLMediaElement.NETWORK_NO_SOURCE || (playerVideo.error && playerVideo.error.code !== 0)) {
                        showCodecNotice();
                    }
                }, 3000);
            }
        });
    </script>
</body>

</html>
