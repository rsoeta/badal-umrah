<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <!-- Primary Meta Tags -->
    <title>Azis Rustandi - Layanan Badal Umrah Amanah</title>
    <meta name="title" content="Azis Rustandi - Layanan Badal Umrah Amanah">
    <meta name="description" content="Jasa Badal Umrah terpercaya untuk orang tercinta yang sudah meninggal atau udzur syar'i. Amanah, bersertifikat resmi, dan didokumentasikan lengkap.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url(); ?>">
    <meta property="og:title" content="🕋 Badal Umrah - Azis Rustandi">
    <meta property="og:description" content="Menghadirkan Cinta dan Doa di Tanah Suci untuk Mereka yang Tercinta. Layanan Badal Umrah profesional dengan sertifikat eksklusif.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="🕋 Badal Umrah - Azis Rustandi">
    <meta name="twitter:description" content="Menghadirkan Cinta dan Doa di Tanah Suci untuk Mereka yang Tercinta. Layanan Badal Umrah profesional dengan sertifikat eksklusif.">
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
        .bu-hero-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .bu-quote-card {
            background: var(--card-2);
            border-radius: var(--r-md);
            padding: 16px 20px;
            box-shadow: inset 0 0 0 1px var(--glass-rim);
            text-align: right;
        }

        .bu-num-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .bu-num-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--sig);
            color: var(--sig-ink);
            font-weight: 700;
            font-size: var(--fs-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bu-mutawwif-tile {
            background: var(--card-2);
            border-radius: var(--r-md);
            padding: 12px 10px;
            text-align: center;
            box-shadow: inset 0 0 0 1px var(--glass-rim);
            height: 100%;
        }

        .bu-mutawwif-img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid var(--sig-border);
        }

        .bu-alur-img-wrap {
            position: relative;
            border-radius: var(--r-md);
            overflow: hidden;
            aspect-ratio: 1 / 1;
            box-shadow: inset 0 0 0 1px var(--glass-rim);
            margin-bottom: 10px;
        }

        .bu-alur-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .bu-alur-num {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--sig);
            color: var(--sig-ink);
            font-weight: 700;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }

        .bu-paket-tile {
            background: var(--card-2);
            border-radius: var(--r-md);
            padding: 16px 10px;
            text-align: center;
            box-shadow: inset 0 0 0 1px var(--glass-rim);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .bu-paket-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--sig-soft);
            color: var(--sig-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .bu-testi-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--sig-border);
            flex-shrink: 0;
        }

        .cek-hasil-card {
            margin-top: 14px;
            padding: 14px;
            border-radius: var(--r-md);
            background: var(--card-2);
            box-shadow: inset 0 0 0 1px var(--sig-border);
        }

        .cek-hasil-video {
            width: 100%;
            max-height: 260px;
            border-radius: var(--r-sm);
            background: #000;
        }

        .bu-features-bottom {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            font-size: var(--fs-xs);
            color: var(--muted);
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--glass-rim);
        }

        .bu-dalil-box {
            background: var(--card-2);
            border-left: 3px solid var(--sig);
            border-radius: var(--r-sm);
            padding: 14px;
        }

        @media (max-width: 991.98px) {
            .bu-quote-card {
                text-align: left;
                width: 100%;
            }
        }
    </style>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame">
        <!-- Sticky Top Bar (Selective Backdrop-Filter) -->
        <header class="sg-topbar">
            <a href="<?= base_url('/'); ?>" class="sg-brand" aria-label="Beranda Badal Umrah Azis Rustandi">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Azis Rustandi" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Azis Rustandi</span>
                    <span class="sg-brand__sub">Layanan Badal Umrah Amanah</span>
                </div>
            </a>

            <nav class="sg-nav sg-nav--desktop-only" aria-label="Navigasi Halaman">
                <a href="#main-content" class="sg-nav__item is-active" aria-current="page">
                    <i class="fa-solid fa-kaaba"></i>
                    <span>Beranda</span>
                </a>
                <a href="#cek-sertifikat" class="sg-nav__item">
                    <i class="fa-solid fa-certificate"></i>
                    <span>Cek Sertifikat</span>
                </a>
                <a href="#alur" class="sg-nav__item">
                    <i class="fa-solid fa-video"></i>
                    <span>Dokumentasi</span>
                </a>
                <a href="#paket" class="sg-nav__item">
                    <i class="fa-solid fa-gift"></i>
                    <span>Fasilitas</span>
                </a>
                <a href="#daftar" class="sg-nav__item">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Pendaftaran</span>
                </a>
            </nav>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>

                <a href="<?= base_url('pendaftaran'); ?>" class="sg-icon-btn sg-icon-btn--sig" aria-label="Daftar Badal Umrah">
                    <i class="fa-regular fa-pen-to-square"></i>
                    <span class="sg-btn-label">Daftar</span>
                </a>

                <a href="<?= base_url('login'); ?>" class="sg-icon-btn" aria-label="Masuk Admin Panel" title="Admin Panel">
                    <i class="fa-solid fa-lock"></i>
                    <span class="sg-btn-label d-none d-sm-inline">Admin</span>
                </a>
            </div>
        </header>

        <!-- Main Smoked Glass Sheet (Pre-Blurred Background Architecture, Zero Scroll Lag) -->
        <main id="main-content" class="sg-pane sg-main">
            <!-- Hero / Page Header -->
            <header class="sg-phead pb-3 mb-4 border-bottom">
                <div style="max-width: 660px;">
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-kaaba"></i>
                        <span>Amanah dalam Ibadah, Indah dalam Layanan</span>
                    </div>
                    <h1 class="sg-h1">Layanan Badal Umrah</h1>
                    <p class="sg-phead__sub mb-3">
                        Menghadirkan cinta dan doa di Tanah Suci untuk mereka yang tercinta — bersertifikat resmi dan didokumentasikan lengkap.
                    </p>
                    <div class="bu-hero-badges">
                        <span class="sg-pill sg-pill--sig"><i class="fa-solid fa-shield-halved"></i> Amanah</span>
                        <span class="sg-pill"><i class="fa-solid fa-user-tie sg-text-sig"></i> Profesional</span>
                        <span class="sg-pill"><i class="fa-solid fa-expand sg-text-sig"></i> Transparan</span>
                        <span class="sg-pill"><i class="fa-solid fa-medal sg-text-sig"></i> Terpercaya</span>
                    </div>
                </div>

                <div class="bu-quote-card">
                    <p class="sg-serif-quote mb-3 sg-text-ink" style="font-size: 1.08rem;">
                        "Doa terbaik, untuk mereka di tempat terbaik."
                    </p>
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="<?= base_url('pendaftaran'); ?>" class="sg-btn sg-btn--sig">
                            <i class="fa-regular fa-pen-to-square"></i> Isi Formulir
                        </a>
                        <a href="https://wa.me/6282111133929" target="_blank" rel="noopener" class="sg-btn sg-btn--wa">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </header>

            <!-- ROW 1: Asymmetric Bento Grid (5fr : 4fr : 3fr) -->
            <div class="sg-bento-row sg-bento-row--home-top">
                <!-- Cek Sertifikat & Video -->
                <section id="cek-sertifikat" class="sg-card sg-card--highlight">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-certificate"></i>
                            Cek &amp; Unduh Sertifikat / Video
                        </h2>
                        <span class="sg-pill sg-pill--sig">Instan</span>
                    </div>

                    <p class="small sg-text-muted mb-3">
                        Masukkan Nomor Registrasi / UUID untuk melihat sertifikat resmi dan video dokumentasi yang tersedia.
                    </p>

                    <div class="input-group mb-2">
                        <label for="inputSertifikat" class="visually-hidden">Nomor Registrasi atau UUID</label>
                        <input type="text" id="inputSertifikat" name="uuid" class="form-control" placeholder="Contoh: RCP-2026-XXXX atau UUID">
                        <button class="sg-btn sg-btn--glass btn-search rounded-start-0" type="button" aria-label="Cari Sertifikat">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>

                    <button class="sg-btn sg-btn--sig w-100 mt-1" id="btnCekSertifikat" type="button">
                        <i class="fa-solid fa-magnifying-glass"></i> Cek Sertifikat &amp; Video
                    </button>

                    <div id="hasilCekSertifikat" class="d-none" aria-live="polite"></div>

                    <div class="bu-features-bottom mt-4">
                        <span><i class="fa-regular fa-clock sg-text-sig me-1"></i>Instan</span>
                        <span><i class="fa-solid fa-shield sg-text-sig me-1"></i>Aman</span>
                        <span><i class="fa-regular fa-file-pdf sg-text-sig me-1"></i>Paperless</span>
                        <span><i class="fa-regular fa-star sg-text-sig me-1"></i>Mudah</span>
                    </div>
                </section>

                <!-- Apa itu Badal Umrah -->
                <section class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-book-open"></i>
                            Apa itu Badal Umrah?
                        </h2>
                    </div>

                    <p class="small sg-text-muted mb-3">
                        Badal Umrah adalah pelaksanaan ibadah umrah yang dilakukan oleh seseorang untuk orang lain yang tidak mampu melakukannya sendiri karena uzur syar'i, berdasarkan dalil-dalil yang shahih.
                    </p>

                    <div class="bu-dalil-box mt-auto">
                        <p class="small fst-italic sg-text-muted mb-0">
                            "Dari Ibnu Abbas radhiyallahu 'anhuma, bahwa seorang wanita dari Juhainah datang kepada Nabi ﷺ seraya berkata: 'Wahai Rasulullah, ibuku telah bernazar umrah, namun ia tidak mampu melakukannya. Apakah boleh aku mengumrahkannya?' Beliau menjawab: 'Ya, umrahkanlah dia.'"
                            <br><br><strong class="sg-text-ink fst-normal">(HR. Bukhari no. 1853)</strong>
                        </p>
                    </div>
                </section>

                <!-- Siapa yang Boleh -->
                <section class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-users"></i>
                            Siapa Boleh Di-badal-kan?
                        </h2>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <div class="bu-num-item">
                            <div class="bu-num-badge">1</div>
                            <div>
                                <div class="fw-bold sg-text-ink small mb-1">
                                    <i class="fa-solid fa-book-skull sg-text-sig me-1"></i> Meninggal Dunia
                                </div>
                                <p class="small sg-text-muted mb-0">Orang yang telah wafat dan semasa hidupnya belum sempat umrah.</p>
                            </div>
                        </div>

                        <div class="bu-num-item">
                            <div class="bu-num-badge">2</div>
                            <div>
                                <div class="fw-bold sg-text-ink small mb-1">
                                    <i class="fa-solid fa-bed sg-text-sig me-1"></i> Sakit Parah / Uzur
                                </div>
                                <p class="small sg-text-muted mb-0">Orang yang sakit parah yang tidak ada harapan sembuh.</p>
                            </div>
                        </div>

                        <div class="bu-num-item">
                            <div class="bu-num-badge">3</div>
                            <div>
                                <div class="fw-bold sg-text-ink small mb-1">
                                    <i class="fa-solid fa-person-cane sg-text-sig me-1"></i> Usia Sangat Renta
                                </div>
                                <p class="small sg-text-muted mb-0">Orang yang sudah sangat tua dan tidak lagi mampu melakukan perjalanan ke Tanah Suci.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- ROW 2: Mutawwif & Alur Dokumentasi (5fr : 7fr) -->
            <div class="sg-bento-row sg-bento-row--2col">
                <section class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-id-card-clip"></i>
                            Profil Mutawwif / Pelaksana
                        </h2>
                    </div>
                    <p class="small sg-text-muted mb-3">Pelaksana amanah ibadah Anda di Tanah Suci.</p>

                    <div class="row g-2 mt-auto">
                        <div class="col-4">
                            <div class="bu-mutawwif-tile">
                                <img src="https://ui-avatars.com/api/?name=Azis+Rustandi&background=2f3339&color=dfb86c&size=150" alt="Ust. Azis Rustandi" class="bu-mutawwif-img">
                                <div class="fw-bold sg-text-ink" style="font-size: 0.8rem;">Ust. Azis Rustandi</div>
                                <div class="sg-text-muted" style="font-size: 0.7rem;">Mahasiswa Univ. Islam Madinah</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bu-mutawwif-tile">
                                <img src="https://ui-avatars.com/api/?name=Abdul+Malik&background=2f3339&color=dfb86c&size=150" alt="Ust. Abdul Malik" class="bu-mutawwif-img">
                                <div class="fw-bold sg-text-ink" style="font-size: 0.8rem;">Ust. Abdul Malik</div>
                                <div class="sg-text-muted" style="font-size: 0.7rem;">Mukimin di Makkah</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bu-mutawwif-tile">
                                <img src="https://ui-avatars.com/api/?name=Salman+A&background=2f3339&color=dfb86c&size=150" alt="Ust. Salman A." class="bu-mutawwif-img">
                                <div class="fw-bold sg-text-ink" style="font-size: 0.8rem;">Ust. Salman A.</div>
                                <div class="sg-text-muted" style="font-size: 0.7rem;">Tim Mutawwif Raehan Cipta</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="alur" class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-video"></i>
                            Alur Dokumentasi Pelaksanaan
                        </h2>
                        <span class="sg-pill">4 Tahap Video</span>
                    </div>
                    <p class="small sg-text-muted mb-3">Bukti nyata sebagai bentuk transparansi dan ketenangan hati keluarga.</p>

                    <div class="row g-2">
                        <div class="col-6 col-sm-3 text-center">
                            <div class="bu-alur-img-wrap">
                                <img src="<?= base_url('img/miqat.jpeg'); ?>" alt="Dokumentasi Miqat" class="bu-alur-img" loading="lazy">
                                <span class="bu-alur-num">1</span>
                            </div>
                            <div class="fw-bold sg-text-ink small">Miqat</div>
                            <p class="sg-text-muted lh-sm mb-0" style="font-size: 0.72rem;">Video pelaksana mengambil miqat &amp; menyebut nama.</p>
                        </div>
                        <div class="col-6 col-sm-3 text-center">
                            <div class="bu-alur-img-wrap">
                                <img src="<?= base_url('img/tawaf.jpeg'); ?>" alt="Dokumentasi Tawaf" class="bu-alur-img" loading="lazy">
                                <span class="bu-alur-num">2</span>
                            </div>
                            <div class="fw-bold sg-text-ink small">Tawaf</div>
                            <p class="sg-text-muted lh-sm mb-0" style="font-size: 0.72rem;">Video pelaksanaan tawaf di Masjidil Haram.</p>
                        </div>
                        <div class="col-6 col-sm-3 text-center">
                            <div class="bu-alur-img-wrap">
                                <img src="<?= base_url('img/sai.jpeg'); ?>" alt="Dokumentasi Sa'i" class="bu-alur-img" loading="lazy">
                                <span class="bu-alur-num">3</span>
                            </div>
                            <div class="fw-bold sg-text-ink small">Sa'i</div>
                            <p class="sg-text-muted lh-sm mb-0" style="font-size: 0.72rem;">Video pelaksanaan sa'i antara Shafa dan Marwah.</p>
                        </div>
                        <div class="col-6 col-sm-3 text-center">
                            <div class="bu-alur-img-wrap">
                                <img src="<?= base_url('img/tahallul.jpeg'); ?>" alt="Dokumentasi Tahallul dan Doa" class="bu-alur-img" loading="lazy">
                                <span class="bu-alur-num">4</span>
                            </div>
                            <div class="fw-bold sg-text-ink small">Tahallul &amp; Doa</div>
                            <p class="sg-text-muted lh-sm mb-0" style="font-size: 0.72rem;">Video tahallul dan doa di depan Ka'bah.</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- ROW 3: Paket & Panti Asuhan -->
            <div class="sg-bento-row sg-bento-row--equal">
                <section id="paket" class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-gift"></i>
                            Paket &amp; Fasilitas
                        </h2>
                    </div>
                    <p class="small sg-text-muted mb-3">Lebih dari sekadar ibadah, kami hadirkan kenangan dan doa.</p>

                    <div class="row g-2 mt-auto">
                        <div class="col-6 col-sm-3">
                            <div class="bu-paket-tile">
                                <div class="bu-paket-icon"><i class="fa-solid fa-file-signature"></i></div>
                                <div class="fw-semibold small lh-sm sg-text-ink">Sertifikat Digital &amp; Cetak</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bu-paket-tile">
                                <div class="bu-paket-icon"><i class="fa-solid fa-bottle-water"></i></div>
                                <div class="fw-semibold small lh-sm sg-text-ink">Air Zamzam<br>(1 / 5 Liter)</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bu-paket-tile">
                                <div class="bu-paket-icon"><i class="fa-solid fa-hands-praying"></i></div>
                                <div class="fw-semibold small lh-sm sg-text-ink">Souvenir Islami<br>(Sajadah, Tasbih)</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="bu-paket-tile">
                                <div class="bu-paket-icon"><i class="fa-solid fa-id-badge"></i></div>
                                <div class="fw-semibold small lh-sm sg-text-ink">Pin / ID Card<br>Badal</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="sg-card">
                    <div class="sg-card__head">
                        <h2 class="sg-card__title">
                            <i class="fa-solid fa-house-chimney-window"></i>
                            Bingkisan untuk Panti Asuhan
                        </h2>
                        <span class="sg-pill sg-pill--good"><i class="fa-solid fa-heart"></i> Sedekah Jariyah</span>
                    </div>

                    <p class="small sg-text-muted mb-3">
                        Sebagai bentuk sedekah jariyah, kami menyalurkan bingkisan ke panti asuhan atas nama almarhum/jamaah pada Paket Paripurna.
                    </p>

                    <div class="sg-subpanel mt-auto d-flex align-items-center gap-3">
                        <div class="bu-paket-icon flex-shrink-0">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <p class="sg-serif-quote mb-0 sg-text-ink" style="font-size: 1.05rem;">
                            "Bahagia mereka, menjadi bagian dari pahala beliau."
                        </p>
                    </div>
                </section>
            </div>

            <!-- ROW 4: Testimoni -->
            <section class="sg-card mb-3">
                <div class="sg-card__head">
                    <h2 class="sg-card__title">
                        <i class="fa-solid fa-shield-heart"></i>
                        Testimoni Keluarga Jamaah
                    </h2>
                    <span class="sg-pill">Kepuasan &amp; Amanah</span>
                </div>

                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="sg-subpanel h-100 d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Ripa+Sopianti&background=2f3339&color=dfb86c" alt="Ibu Ripa Sopianti" class="bu-testi-avatar" loading="lazy">
                            <div>
                                <p class="small sg-text-muted fst-italic mb-2">"Alhamdulillah, prosesnya sangat mudah dan terpercaya. Sertifikat dan videonya lengkap. Terima kasih Azis Rustandi."</p>
                                <div class="sg-text-sig mb-1" style="font-size: 0.78rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <div class="fw-bold sg-text-ink small">Ibu Ripa Sopianti</div>
                                <div class="sg-text-muted" style="font-size: 0.72rem;">(Anak dari Almarhumah Ibu Ereh)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sg-subpanel h-100 d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=2f3339&color=dfb86c" alt="Bapak Andi Pratama" class="bu-testi-avatar" loading="lazy">
                            <div>
                                <p class="small sg-text-muted fst-italic mb-2">"Kami merasa tenang karena semua dilakukan dengan amanah dan profesional. Doa kami tersampaikan di depan Ka'bah. Jazakumullah khairan."</p>
                                <div class="sg-text-sig mb-1" style="font-size: 0.78rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <div class="fw-bold sg-text-ink small">Bapak Andi Pratama</div>
                                <div class="sg-text-muted" style="font-size: 0.72rem;">(Anak dari Almarhumah Ibu Hj. Sumarni)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sg-subpanel h-100 d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Ibu+Nani&background=2f3339&color=dfb86c" alt="Ibu Nani" class="bu-testi-avatar" loading="lazy">
                            <div>
                                <p class="small sg-text-muted fst-italic mb-2">"Pelayanannya sangat baik, komunikatif, dan dokumentasinya lengkap. Semoga semakin banyak yang terbantu."</p>
                                <div class="sg-text-sig mb-1" style="font-size: 0.78rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                <div class="fw-bold sg-text-ink small">Ibu Nani</div>
                                <div class="sg-text-muted" style="font-size: 0.72rem;">(Orang Tua Jamaah)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ROW 5: Pendaftaran & Konsultasi -->
            <section id="daftar" class="sg-card sg-card--highlight">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <div class="sg-card__head mb-2">
                            <h2 class="sg-card__title">
                                <i class="fa-solid fa-file-signature"></i>
                                Pendaftaran &amp; Konsultasi
                            </h2>
                        </div>
                        <p class="small sg-text-muted mb-3">
                            Tim kami siap membantu proses pendaftaran Anda dengan ramah dan profesional.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://wa.me/6282111133929" target="_blank" rel="noopener" class="sg-btn sg-btn--wa">
                                <i class="fa-brands fa-whatsapp"></i> Chat via WhatsApp
                            </a>
                            <a href="<?= base_url('pendaftaran'); ?>" class="sg-btn sg-btn--sig">
                                <i class="fa-regular fa-pen-to-square"></i> Isi Formulir Pendaftaran
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row g-2 text-center">
                            <div class="col-6 col-sm-3">
                                <div class="sg-subpanel h-100 py-3">
                                    <i class="fa-regular fa-clock fa-lg sg-text-sig mb-2 d-block"></i>
                                    <span class="fw-semibold small sg-text-ink">Respon Cepat</span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="sg-subpanel h-100 py-3">
                                    <i class="fa-regular fa-address-book fa-lg sg-text-sig mb-2 d-block"></i>
                                    <span class="fw-semibold small sg-text-ink">Info Lengkap</span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="sg-subpanel h-100 py-3">
                                    <i class="fa-regular fa-comments fa-lg sg-text-sig mb-2 d-block"></i>
                                    <span class="fw-semibold small sg-text-ink">Gratis Konsultasi</span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="sg-subpanel h-100 py-3">
                                    <i class="fa-solid fa-user-shield fa-lg sg-text-sig mb-2 d-block"></i>
                                    <span class="fw-semibold small sg-text-ink">Pendampingan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="sg-footer">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-kaaba fa-lg sg-text-sig"></i>
                <div>
                    <div class="fw-bold sg-text-ink">Azis Rustandi</div>
                    <div class="sg-text-muted" style="font-size: 0.72rem;">Amanah dalam Ibadah, Indah dalam Layanan</div>
                </div>
            </div>

            <div class="sg-serif-quote sg-text-sig d-none d-md-block">
                "Setiap langkah di Tanah Suci, adalah doa untuk mereka yang kita cinta."
            </div>

            <div>Makkah | Madinah | Untuk Umat</div>
        </footer>
    </div>

    <!-- Script Interaksi Cek Sertifikat Asli -->
    <script>
        const hasilCekSertifikat = document.getElementById('hasilCekSertifikat');
        const inputSertifikat = document.getElementById('inputSertifikat');
        const btnCekSertifikat = document.getElementById('btnCekSertifikat');
        const btnSearchInline = document.querySelector('#cek-sertifikat .btn-search');

        const tampilkanHasilCek = data => {
            hasilCekSertifikat.replaceChildren();
            hasilCekSertifikat.classList.remove('d-none');

            const resultCard = document.createElement('div');
            resultCard.className = 'cek-hasil-card';
            const heading = document.createElement('div');
            heading.className = 'fw-bold sg-text-sig mb-2';
            heading.textContent = data.certificate_ready
                ? `Sertifikat atas nama ${data.nama} siap diunduh.`
                : data.message;
            resultCard.append(heading);

            if (data.certificate_ready) {
                const certificateActions = document.createElement('div');
                certificateActions.className = 'd-flex flex-wrap gap-2 mb-3';
                const pdfLink = document.createElement('a');
                pdfLink.href = data.url_pdf;
                pdfLink.target = '_blank';
                pdfLink.rel = 'noopener';
                pdfLink.className = 'btn btn-sm btn-danger rounded-pill px-3';
                pdfLink.innerHTML = '<i class="fa-solid fa-file-pdf me-1"></i> Unduh PDF';
                const jpgLink = document.createElement('a');
                jpgLink.href = data.url_jpg;
                jpgLink.target = '_blank';
                jpgLink.rel = 'noopener';
                jpgLink.className = 'sg-btn sg-btn--glass btn-sm py-1 px-3';
                jpgLink.innerHTML = '<i class="fa-solid fa-image me-1"></i> Lihat JPG';
                certificateActions.append(pdfLink, jpgLink);
                resultCard.append(certificateActions);
            }

            if (data.videos && data.videos.length > 0) {
                const videoHeading = document.createElement('div');
                videoHeading.className = 'fw-bold sg-text-sig mb-2';
                videoHeading.textContent = 'Video dokumentasi';
                resultCard.append(videoHeading);

                data.videos.forEach(video => {
                    const videoCard = document.createElement('div');
                    videoCard.className = 'mb-3';
                    const name = document.createElement('div');
                    name.className = 'small mb-2 text-break sg-text-ink';
                    name.textContent = video.name;
                    const player = document.createElement('video');
                    player.className = 'cek-hasil-video';
                    player.controls = true;
                    player.preload = 'metadata';
                    player.playsInline = true;
                    player.src = video.stream_url;
                    const actionContainer = document.createElement('div');
                    actionContainer.className = 'd-flex flex-wrap gap-2 mt-2';

                    const watchLink = document.createElement('a');
                    watchLink.className = 'sg-btn sg-btn--sig btn-sm py-1 px-3';
                    watchLink.href = video.watch_url || video.stream_url;
                    watchLink.target = '_blank';
                    watchLink.rel = 'noopener';
                    watchLink.innerHTML = '<i class="fa-solid fa-up-right-from-square me-1"></i> Tonton Halaman Penuh';

                    const download = document.createElement('a');
                    download.className = 'sg-btn sg-btn--glass btn-sm py-1 px-3';
                    download.href = video.download_url;
                    download.innerHTML = '<i class="fa-solid fa-download me-1"></i> Unduh Video';

                    actionContainer.append(watchLink, download);
                    videoCard.append(name, player, actionContainer);
                    resultCard.append(videoCard);
                });
            }

            hasilCekSertifikat.append(resultCard);
        };

        const jalankanCekSertifikat = () => {
            let inputVal = inputSertifikat.value;

            if (inputVal.trim() === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Kosong',
                    text: 'Masukkan Nomor Registrasi terlebih dahulu.',
                    customClass: {
                        popup: 'swal-mobile-custom',
                        title: 'swal-title-custom'
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Mencari Data...',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let formData = new FormData();
            formData.append('uuid', inputVal.trim());
            hasilCekSertifikat.replaceChildren();
            hasilCekSertifikat.classList.add('d-none');

            fetch('<?= base_url('cek-sertifikat') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Pencarian gagal.');
                    return data;
                })
                .then(data => {
                    if (data.status === 'success') {
                        Swal.close();
                        tampilkanHasilCek(data);
                    } else if (data.status === 'pending') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sedang Diproses',
                            text: data.message,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak Ditemukan',
                            text: data.message,
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Server',
                        text: error.message || 'Terjadi kendala saat menghubungi server.',
                        customClass: {
                            popup: 'swal-mobile-custom',
                            title: 'swal-title-custom'
                        }
                    });
                    console.error(error);
                });
        };

        btnCekSertifikat.addEventListener('click', jalankanCekSertifikat);
        if (btnSearchInline) {
            btnSearchInline.addEventListener('click', jalankanCekSertifikat);
        }
        if (inputSertifikat) {
            inputSertifikat.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    jalankanCekSertifikat();
                }
            });
        }
    </script>
</body>

</html>
