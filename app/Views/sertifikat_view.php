<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        .card-custom {
            border: none;
            border-top: 5px solid var(--gold);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .certificate-frame {
            position: relative;
            background: #1a1a1a;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .certificate-img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
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
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cek Lainnya
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card-custom p-3 p-md-4">

                    <!-- Header Sertifikat -->
                    <div class="text-center mb-4">
                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 mb-2">
                            <i class="fa-solid fa-certificate text-success me-1"></i> Sertifikat Resmi Badal Umrah
                        </span>
                        <h1 class="font-serif fw-bold text-green fs-2 mt-2 mb-1">
                            <?= esc($namaDiumrahkan); ?>
                        </h1>
                        <p class="text-muted small mb-0 font-monospace">
                            No. Registrasi: <strong><?= esc($uuid); ?></strong>
                        </p>
                    </div>

                    <!-- Pratinjau Gambar Sertifikat -->
                    <div class="certificate-frame mb-3">
                        <a href="<?= esc($urlJpg); ?>" target="_blank" rel="noopener" title="Klik untuk melihat resolusi penuh">
                            <img src="<?= esc($urlJpg); ?>" alt="Sertifikat Badal Umrah <?= esc($namaDiumrahkan); ?>" class="certificate-img">
                        </a>
                    </div>

                    <!-- Tombol Aksi Cepat -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                        <a href="<?= esc($urlPdf); ?>" download class="btn btn-danger rounded-pill px-4 py-2 fw-medium shadow-sm">
                            <i class="fa-solid fa-file-pdf me-2"></i> Unduh PDF Resmi
                        </a>
                        <a href="<?= esc($urlJpg); ?>" download class="btn btn-outline-dark rounded-pill px-4 py-2 fw-medium">
                            <i class="fa-solid fa-image me-2"></i> Unduh Gambar JPG
                        </a>
                        <button type="button" id="btnSalinTautan" class="btn btn-gold rounded-pill px-4 py-2">
                            <i class="fa-solid fa-share-nodes me-2"></i> Salin Tautan
                        </button>
                        <a href="https://wa.me/?text=<?= rawurlencode("Sertifikat Badal Umrah - " . $namaDiumrahkan . "\n\n" . $shareUrl); ?>" target="_blank" rel="noopener" class="btn btn-success rounded-pill px-4 py-2 fw-medium">
                            <i class="fa-brands fa-whatsapp me-2"></i> Bagikan ke WA
                        </a>
                    </div>

                    <!-- Informasi Rincian Sertifikat -->
                    <div class="meta-box mb-3">
                        <h6 class="fw-bold text-green mb-3">
                            <i class="fa-solid fa-circle-info text-gold me-2"></i> Rincian Pelaksanaan Badal Umrah
                        </h6>
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
                    <div class="meta-box">
                        <h6 class="fw-bold text-green mb-3">
                            <i class="fa-solid fa-video text-gold me-2"></i> Dokumentasi Video Pelaksanaan
                        </h6>
                        <div class="list-group list-group-flush">
                            <?php foreach ($videos as $v): ?>
                            <div class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-film text-success"></i>
                                    <span class="fw-semibold small"><?= esc($v['original_name']); ?></span>
                                </div>
                                <a href="<?= base_url('video/' . esc($v['share_token'])); ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fa-solid fa-play me-1"></i> Tonton Video
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

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
