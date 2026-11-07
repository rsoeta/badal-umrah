<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="video.other">
    <meta property="og:url" content="<?= esc($shareUrl); ?>">
    <meta property="og:title" content="<?= esc($pageTitle); ?>">
    <meta property="og:description" content="Tonton langsung video dokumentasi pelaksanaan Badal Umrah atas nama <?= esc($namaDiumrahkan); ?>.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:video" content="<?= esc($streamUrl); ?>">
    <meta property="og:video:type" content="<?= esc($video['mime_type']); ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .card-video {
            border: none;
            border-top: 5px solid var(--gold);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .video-wrapper {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        video {
            width: 100%;
            height: auto;
            max-height: 540px;
            display: block;
            outline: none;
            background: #000;
        }

        .meta-box {
            background-color: #faf8f5;
            border: 1px solid #ede7dd;
            border-radius: 12px;
            padding: 16px;
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

        .swal-mobile-custom {
            font-size: 0.85rem !important;
            width: 85% !important;
            border-radius: 12px !important;
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
            <div class="col-lg-10 col-xl-9">
                <div class="card-video p-3 p-md-4">
                    <!-- Header Info -->
                    <div class="text-center mb-4">
                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 mb-2">
                            <i class="fa-solid fa-circle-check text-success me-1"></i> Dokumentasi Resmi Pelaksanaan
                        </span>
                        <h1 class="font-serif fw-bold text-green fs-2 mt-2 mb-1">
                            <?= esc($namaDiumrahkan); ?>
                        </h1>
                        <p class="text-muted small mb-0">
                            <i class="fa-solid fa-file-video text-gold me-1"></i> <?= esc($namaVideo); ?>
                        </p>
                    </div>

                    <!-- Pemutar Video Realtime -->
                    <div class="video-wrapper mb-4">
                        <video id="playerVideo" controls autoplay playsinline preload="auto">
                            <source src="<?= esc($streamUrl); ?>" type="<?= esc($video['mime_type']); ?>">
                            Browser Anda tidak mendukung pemutar video HTML5. Silakan unduh berkas video menggunakan tombol di bawah.
                        </video>
                    </div>

                    <!-- Tombol Aksi Cepat -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        <button type="button" id="btnSalinTautan" class="btn btn-gold rounded-pill px-4 py-2">
                            <i class="fa-solid fa-share-nodes me-2"></i> Salin Tautan & Judul
                        </button>
                        <a href="<?= esc($downloadUrl); ?>" class="btn btn-outline-success rounded-pill px-4 py-2 fw-medium">
                            <i class="fa-solid fa-download me-2"></i> Unduh Video (<?= esc($fileSizeFormatted); ?>)
                        </a>
                        <a href="https://wa.me/?text=<?= rawurlencode("Video Dokumentasi Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>" target="_blank" rel="noopener" class="btn btn-success rounded-pill px-4 py-2 fw-medium">
                            <i class="fa-brands fa-whatsapp me-2"></i> Bagikan ke WhatsApp
                        </a>
                    </div>

                    <!-- Informasi Detail Pendaftaran & Video -->
                    <div class="meta-box">
                        <h6 class="fw-bold text-green mb-3">
                            <i class="fa-solid fa-circle-info text-gold me-2"></i> Informasi Pelaksanaan
                        </h6>
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
                        <p class="small text-muted mb-0">
                            Semoga amal ibadah badal umrah ini diterima dan mabrur di sisi Allah SWT. Aamiin ya Rabbal 'Alamin.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center">
        <div class="container">
            <p class="small text-white-50 mb-1">
                &copy; <?= date('Y'); ?> Layanan Badal Umrah Amanah - Azis Rustandi. Seluruh hak cipta dilindungi.
            </p>
            <p class="small text-muted mb-0" style="font-size: 0.75rem;">
                Video dokumentasi ini dibagikan secara resmi untuk keluarga jamaah.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                btnSalin.addEventListener('click', async function () {
                    await copyToClipboard(shareText);
                    Swal.fire({
                        icon: 'success',
                        title: 'Tautan & Judul Disalin!',
                        html: `Teks judul dan tautan video berhasil disalin ke clipboard:<div class="mt-3 p-2 bg-light border rounded text-start small font-monospace user-select-all text-break">${shareText.replace(/\n\n/g, '<br><br>')}</div>`,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#198754',
                        customClass: { popup: 'swal-mobile-custom' }
                    });
                });
            }
        });
    </script>
</body>

</html>
