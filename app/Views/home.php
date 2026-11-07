<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>Azis Rustandi - Layanan Badal Umrah Amanah</title>
    <meta name="title" content="Azis Rustandi - Layanan Badal Umrah Amanah">
    <meta name="description" content="Jasa Badal Umrah terpercaya untuk orang tercinta yang sudah meninggal atau udzur syar'i. Amanah, bersertifikat resmi, dan didokumentasikan lengkap.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url(); ?>">
    <meta property="og:title" content="🕋 Badal Umrah - Azis Rustandi">
    <meta property="og:description" content="Menghadirkan Cinta dan Doa di Tanah Suci untuk Mereka yang Tercinta. Layanan Badal Umrah profesional dengan sertifikat eksklusif.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">

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

        .bg-gold {
            background-color: var(--gold);
        }

        /* General Card Styling */
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: #fff;
            height: 100%;
            overflow: hidden;
        }

        .section-header {
            font-weight: 700;
            color: var(--green-dark);
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .section-header i {
            color: var(--gold);
            font-size: 1.5rem;
            margin-right: 10px;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: url('https://images.unsplash.com/photo-1591814246083-09ebfaeebc03?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            padding: 60px 0;
            border-bottom: 5px solid var(--gold);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(244, 241, 234, 0.95) 0%, rgba(244, 241, 234, 0.8) 50%, rgba(244, 241, 234, 0.1) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title-small {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--green-dark);
            margin-bottom: -10px;
        }

        .hero-title-large {
            font-size: 4rem;
            font-weight: 700;
            color: var(--gold);
            line-height: 1.1;
            margin-bottom: 15px;
        }

        .badge-hero {
            background: #fff;
            color: var(--green-dark);
            border: 1px solid var(--gold);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .badge-hero i {
            color: var(--gold);
            margin-right: 5px;
        }

        /* Cek Sertifikat Box */
        .cek-sertifikat-box {
            background-color: var(--green-dark);
            color: white;
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            position: relative;
        }

        .cek-sertifikat-box .form-control {
            border-radius: 8px 0 0 8px;
            border: none;
        }

        .cek-sertifikat-box .btn-search {
            background-color: var(--green-light);
            color: white;
            border-radius: 0 8px 8px 0;
            border: none;
        }

        .cek-sertifikat-box .btn-gold {
            background-color: var(--gold);
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
        }

        .cek-hasil-card {
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.08);
        }

        .cek-hasil-video {
            width: 100%;
            max-height: 280px;
            border-radius: 0.6rem;
            background: #000;
        }

        .features-bottom {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
        }

        /* Numbered List (Siapa Boleh Dibadalkan) */
        .numbered-item {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .num-circle {
            width: 35px;
            height: 35px;
            background: var(--gold);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        /* Mutawwif & Alur */
        .mutawwif-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .alur-step {
            text-align: center;
            font-size: 0.85rem;
        }

        .alur-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--gold);
            position: relative;
        }

        .alur-num {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--green-dark);
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            border: 2px solid #fff;
        }

        /* Paket & Panti Asuhan */
        .paket-img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border: 1px solid #eee;
        }

        .panti-bg {
            background: linear-gradient(to right, rgba(255, 255, 255, 0.95) 40%, rgba(255, 255, 255, 0) 100%), url('https://images.unsplash.com/photo-1594708767771-a7502209ff51?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') right/cover;
            border-radius: 12px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 30px;
        }

        /* Testimoni */
        .testi-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid var(--gold);
        }

        /* CTA Section */
        .btn-wa {
            background-color: #25d366;
            color: white;
            font-weight: bold;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
        }

        .btn-outline-dark {
            border: 2px solid var(--green-dark);
            color: var(--green-dark);
            font-weight: bold;
            padding: 12px 25px;
            border-radius: 8px;
        }

        /* Footer */
        .footer {
            background-color: var(--green-dark);
            color: white;
            padding: 20px 0;
            font-size: 0.85rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .hero-title-large {
                font-size: 2.5rem;
            }

            .hero::before {
                background: rgba(244, 241, 234, 0.9);
            }

            .panti-bg {
                background: rgba(255, 255, 255, 0.9);
                padding: 20px;
            }

            .badge-hero {
                font-size: 0.75rem;
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero position-relative">

        <!-- TOMBOL LOGIN ADMIN MELAYANG DI POJOK KANAN ATAS -->
        <div class="position-absolute top-0 end-0 p-3 p-md-4" style="z-index: 10;">
            <a href="<?= base_url('login'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm" style="border-color: var(--gold); color: var(--gold);">
                <i class="fa-solid fa-lock me-1"></i> <span class="d-none d-sm-inline">Admin Panel</span>
            </a>
        </div>

        <div class="container hero-content">
            <!-- ... baris konten hero ... -->
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <!-- Menggunakan Logo Perusahaan Asli -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Azis Rustandi" style="max-height: 100px; object-fit: contain;" class="me-3">
                        <div>
                            <h2 class="mb-0 fw-bold text-green font-serif" style="line-height: 1;">Azis Rustandi</h2>
                            <small class="text-muted" style="font-size: 0.9rem;">Amanah dalam Ibadah, Indah dalam Layanan</small>
                        </div>
                    </div>

                    <h3 class="hero-title-small font-serif">Layanan</h3>
                    <h1 class="hero-title-large font-serif">Badal Umrah</h1>
                    <h4 class="text-green font-serif mb-4">Menghadirkan Cinta dan Doa<br>di Tanah Suci untuk Mereka yang Tercinta</h4>

                    <div class="d-flex flex-wrap">
                        <span class="badge-hero"><i class="fa-solid fa-shield-halved"></i> Amanah</span>
                        <span class="badge-hero"><i class="fa-solid fa-user-tie"></i> Profesional</span>
                        <span class="badge-hero"><i class="fa-solid fa-expand"></i> Transparan</span>
                        <span class="badge-hero"><i class="fa-solid fa-medal"></i> Terpercaya</span>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-end">
                    <h3 class="font-serif text-dark fst-italic">"Doa terbaik,<br>untuk mereka<br>di tempat terbaik"</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="container py-4">

        <!-- ROW 1 -->
        <div class="row g-4 mb-4">
            <!-- Cek Sertifikat -->
            <div class="col-lg-4">
                <div class="cek-sertifikat-box shadow">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-certificate fa-2x text-gold me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold text-gold">Cek & Unduh Sertifikat / Video</h5>
                            <small>Masukkan Nomor Registrasi / UUID untuk melihat sertifikat dan video dokumentasi yang tersedia.</small>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" id="inputSertifikat" class="form-control" placeholder="Contoh: RCP-2026-XXXX atau UUID">
                        <button class="btn btn-search" type="button"><i class="fa-solid fa-search"></i></button>
                    </div>
                    <button class="btn btn-gold w-100 mt-3" id="btnCekSertifikat">Cek Sertifikat & Video</button>
                    <div id="hasilCekSertifikat" class="d-none" aria-live="polite"></div>

                    <div class="features-bottom">
                        <span><i class="fa-regular fa-clock text-gold"></i> Instan</span>
                        <span><i class="fa-solid fa-shield text-gold"></i> Aman</span>
                        <span><i class="fa-regular fa-file-pdf text-gold"></i> Paperless</span>
                        <span><i class="fa-regular fa-star text-gold"></i> Mudah</span>
                    </div>
                </div>
            </div>

            <!-- Apa itu Badal Umrah -->
            <div class="col-lg-4">
                <div class="card card-custom p-4">
                    <div class="section-header">Apa itu Badal Umrah?</div>
                    <p class="small text-muted mb-3">Badal Umrah adalah pelaksanaan ibadah umrah yang dilakukan oleh seseorang untuk orang lain yang tidak mampu melakukannya sendiri karena uzur syar'i, berdasarkan dalil-dalil yang shahih.</p>
                    <div class="p-3 bg-cream rounded" style="background-color: #f9f8f4; border-left: 3px solid var(--gold);">
                        <p class="small fst-italic text-muted mb-0">"Dari Ibnu Abbas radhiyallahu 'anhuma, bahwa seorang wanita dari Juhainah datang kepada Nabi ﷺ seraya berkata: 'Wahai Rasulullah, ibuku telah bernazar umrah, namun ia tidak mampu melakukannya. Apakah boleh aku mengumrahkannya?' Beliau menjawab: 'Ya, umrahkanlah dia.'"<br><br>(HR. Bukhari no. 1853)</p>
                    </div>
                </div>
            </div>

            <!-- Siapa yang Boleh -->
            <div class="col-lg-4">
                <div class="card card-custom p-4">
                    <div class="section-header">Siapa yang Boleh Di-badal-kan?</div>
                    <p class="small text-muted mb-4">Badal Umrah diperbolehkan untuk:</p>

                    <div class="numbered-item">
                        <div class="num-circle">1</div>
                        <div>
                            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-book-skull text-gold me-2"></i> Meninggal Dunia</h6>
                            <p class="small text-muted mb-0">Orang yang telah wafat dan semasa hidupnya belum sempat umrah.</p>
                        </div>
                    </div>
                    <div class="numbered-item">
                        <div class="num-circle">2</div>
                        <div>
                            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-bed text-gold me-2"></i> Sakit Parah / Uzur</h6>
                            <p class="small text-muted mb-0">Orang yang sakit parah yang tidak ada harapan sembuh.</p>
                        </div>
                    </div>
                    <div class="numbered-item">
                        <div class="num-circle">3</div>
                        <div>
                            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-person-cane text-gold me-2"></i> Usia Sangat Renta</h6>
                            <p class="small text-muted mb-0">Orang yang sudah sangat tua dan tidak lagi mampu melakukan perjalanan ke Tanah Suci.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 2 -->
        <div class="row g-4 mb-4">
            <!-- Profil Mutawwif -->
            <div class="col-lg-5">
                <div class="card card-custom p-4">
                    <div class="section-header"><i class="fa-solid fa-id-card-clip"></i> Profil Mutawwif / Pelaksana</div>
                    <p class="small text-muted mb-3">Pelaksana amanah ibadah Anda di Tanah Suci</p>
                    <div class="row text-center g-2">
                        <div class="col-4">
                            <img src="https://ui-avatars.com/api/?name=Ahmad+Fadil&background=0f3d23&color=fff&size=150" class="mutawwif-img">
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Ust. Azis Rustandi</h6>
                            <p class="text-muted" style="font-size: 0.65rem;">Mahasiswa Univ. Islam Madinah</p>
                        </div>
                        <div class="col-4">
                            <img src="https://ui-avatars.com/api/?name=Abdul+Malik&background=b8924b&color=fff&size=150" class="mutawwif-img">
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Ust. Abdul Malik</h6>
                            <p class="text-muted" style="font-size: 0.65rem;">Mukimin di Makkah</p>
                        </div>
                        <div class="col-4">
                            <img src="https://ui-avatars.com/api/?name=Salman&background=0f3d23&color=fff&size=150" class="mutawwif-img">
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Ust. Salman A.</h6>
                            <p class="text-muted" style="font-size: 0.65rem;">Tim Mutawwif Raehan Cipta</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alur Dokumentasi -->
            <div class="col-lg-7">
                <div class="card card-custom p-4">
                    <div class="section-header"><i class="fa-solid fa-video"></i> Alur Dokumentasi Pelaksanaan</div>
                    <p class="small text-muted mb-3">Bukti nyata sebagai bentuk transparansi dan ketenangan hati keluarga</p>
                    <div class="row g-2">
                        <div class="col-3 alur-step">
                            <div class="position-relative mb-3">
                                <img src="<?= base_url('img/miqat.jpeg'); ?>" class="alur-img">
                                <div class="alur-num">1</div>
                            </div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Miqat</h6>
                            <p class="text-muted lh-sm" style="font-size: 0.65rem;">Video saat pelaksana mengambil miqat & menyebutkan nama.</p>
                        </div>
                        <div class="col-3 alur-step">
                            <div class="position-relative mb-3">
                                <img src="<?= base_url('img/tawaf.jpeg'); ?>" class="alur-img">
                                <div class="alur-num">2</div>
                            </div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Tawaf</h6>
                            <p class="text-muted lh-sm" style="font-size: 0.65rem;">Video pelaksanaan tawaf di Masjidil Haram.</p>
                        </div>
                        <div class="col-3 alur-step">
                            <div class="position-relative mb-3">
                                <img src="<?= base_url('img/sai.jpeg'); ?>" class="alur-img">
                                <div class="alur-num">3</div>
                            </div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Sa'i</h6>
                            <p class="text-muted lh-sm" style="font-size: 0.65rem;">Video pelaksanaan sa'i antara Shafa dan Marwah.</p>
                        </div>
                        <div class="col-3 alur-step">
                            <div class="position-relative mb-3">
                                <img src="<?= base_url('img/tahallul.jpeg'); ?>" class="alur-img">
                                <div class="alur-num">4</div>
                            </div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.8rem;">Tahallul & Doa</h6>
                            <p class="text-muted lh-sm" style="font-size: 0.65rem;">Video tahallul dan doa di depan Ka'bah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 3 -->
        <div class="row g-4 mb-4">
            <!-- Paket & Fasilitas -->
            <div class="col-lg-6">
                <div class="card card-custom p-4">
                    <div class="section-header"><i class="fa-solid fa-gift"></i> Paket & Fasilitas</div>
                    <p class="small text-muted mb-3">Lebih dari sekadar ibadah, kami hadirkan kenangan dan doa</p>
                    <div class="row text-center g-3">
                        <div class="col-3">
                            <div class="paket-img d-flex align-items-center justify-content-center bg-light border"><i class="fa-solid fa-file-signature fa-2x text-muted"></i></div>
                            <p class="fw-bold lh-sm" style="font-size: 0.75rem;">Sertifikat Digital & Cetak</p>
                        </div>
                        <div class="col-3">
                            <div class="paket-img d-flex align-items-center justify-content-center bg-light border"><i class="fa-solid fa-bottle-water fa-2x text-primary"></i></div>
                            <p class="fw-bold lh-sm" style="font-size: 0.75rem;">Air Zamzam<br>(1 / 5 Liter)</p>
                        </div>
                        <div class="col-3">
                            <div class="paket-img d-flex align-items-center justify-content-center bg-light border"><i class="fa-solid fa-hands-praying fa-2x text-warning"></i></div>
                            <p class="fw-bold lh-sm" style="font-size: 0.75rem;">Souvenir Islami<br>(Sajadah, Tasbih)</p>
                        </div>
                        <div class="col-3">
                            <div class="paket-img d-flex align-items-center justify-content-center bg-light border"><i class="fa-solid fa-id-badge fa-2x text-secondary"></i></div>
                            <p class="fw-bold lh-sm" style="font-size: 0.75rem;">Pin / ID Card<br>Badal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panti Asuhan -->
            <div class="col-lg-6">
                <div class="card card-custom panti-bg">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="section-header"><i class="fa-solid fa-house-chimney-window"></i> Bingkisan untuk Panti Asuhan</div>
                            <p class="small text-dark mb-4 fw-medium">Sebagai bentuk sedekah jariyah, kami menyalurkan bingkisan ke panti asuhan atas nama almarhum/jamaah.</p>
                            <h4 class="font-serif text-green fst-italic">"Bahagia mereka, <br>menjadi bagian dari pahala beliau."</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 4: Testimoni -->
        <div class="card card-custom p-4 mb-4">
            <div class="section-header"><i class="fa-solid fa-shield-heart"></i> Testimoni Keluarga Jamaah</div>
            <p class="small text-muted mb-4">Kepuasan dan kepercayaan mereka adalah amanah bagi kami</p>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex">
                        <img src="https://ui-avatars.com/api/?name=Siti+Rahayu&background=b8924b&color=fff" class="testi-avatar">
                        <div>
                            <p class="small text-muted fst-italic mb-2">"Alhamdulillah, prosesnya sangat mudah dan terpercaya. Sertifikat dan videonya lengkap. Terima kasih Azis Rustandi."</p>
                            <div class="text-warning mb-1" style="font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">Ibu Ripa Sopianti</h6>
                            <p class="text-muted mb-0" style="font-size: 0.7rem;">(Anak dari Almarhumah Ibu Ereh)</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=0f3d23&color=fff" class="testi-avatar">
                        <div>
                            <p class="small text-muted fst-italic mb-2">"Kami merasa tenang karena semua dilakukan dengan amanah dan profesional. Doa kami tersampaikan di depan Ka'bah. Jazakumullah khairan."</p>
                            <div class="text-warning mb-1" style="font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">Bapak Andi Pratama</h6>
                            <p class="text-muted mb-0" style="font-size: 0.7rem;">(Anak dari Almarhumah Ibu Hj. Sumarni)</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <img src="https://ui-avatars.com/api/?name=Nur+Aisyah&background=b8924b&color=fff" class="testi-avatar">
                        <div>
                            <p class="small text-muted fst-italic mb-2">"Pelayanannya sangat baik, komunikatif, dan dokumentasinya lengkap. Semoga semakin banyak yang terbantu."</p>
                            <div class="text-warning mb-1" style="font-size: 0.8rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">Ibu Nani</h6>
                            <p class="text-muted mb-0" style="font-size: 0.7rem;">(Orang Tua Jamaah)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 5: Konsultasi -->
        <div class="card card-custom p-4 border border-warning" style="background-color: #fcfbf8;">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <!-- Mengubah Judul dan Tombol CTA -->
                    <div class="section-header mb-1"><i class="fa-solid fa-file-signature"></i> Pendaftaran & Konsultasi</div>
                    <p class="small text-muted mb-3">Tim kami siap membantu proses pendaftaran Anda dengan ramah dan profesional.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="https://wa.me/6282111133929" target="_blank" class="btn btn-wa text-decoration-none"><i class="fa-brands fa-whatsapp me-2"></i> Chat via WhatsApp</a>
                        <!-- Nantinya href ini bisa diarahkan ke halaman/rute form pendaftaran CI4 -->
                        <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-outline-dark text-decoration-none"><i class="fa-regular fa-pen-to-square me-2"></i> Isi Formulir Pendaftaran</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row text-center g-2">
                        <div class="col-3">
                            <i class="fa-regular fa-clock fa-2x text-gold mb-2"></i>
                            <p class="fw-bold mb-0" style="font-size: 0.75rem;">Respon Cepat</p>
                        </div>
                        <div class="col-3">
                            <i class="fa-regular fa-address-book fa-2x text-gold mb-2"></i>
                            <p class="fw-bold mb-0" style="font-size: 0.75rem;">Informasi Lengkap</p>
                        </div>
                        <div class="col-3">
                            <i class="fa-regular fa-comments fa-2x text-gold mb-2"></i>
                            <p class="fw-bold mb-0" style="font-size: 0.75rem;">Gratis Konsultasi</p>
                        </div>
                        <div class="col-3">
                            <i class="fa-solid fa-user-shield fa-2x text-gold mb-2"></i>
                            <p class="fw-bold mb-0" style="font-size: 0.75rem;">Pendampingan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer mt-2">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <i class="fa-solid fa-kaaba fa-2x text-gold me-3"></i>
                <div>
                    <h6 class="mb-0 fw-bold font-serif text-white">Azis Rustandi</h6>
                    <small class="text-gold" style="font-size: 0.7rem;">Amanah dalam Ibadah, Indah dalam Layanan</small>
                </div>
            </div>

            <div class="text-center font-serif fst-italic text-gold d-none d-md-block" style="font-size: 1rem;">
                "Setiap langkah di Tanah Suci,<br>adalah doa untuk mereka yang kita cinta."
            </div>

            <div class="text-end text-light" style="font-size: 0.8rem; opacity: 0.8;">
                Makkah | Madinah | Untuk Umat
            </div>
        </div>
    </footer>

    <!-- Script Interaksi Cek Sertifikat Asli -->
    <script>
        const hasilCekSertifikat = document.getElementById('hasilCekSertifikat');
        const tampilkanHasilCek = data => {
            hasilCekSertifikat.replaceChildren();
            hasilCekSertifikat.classList.remove('d-none');

            const resultCard = document.createElement('div');
            resultCard.className = 'cek-hasil-card';
            const heading = document.createElement('div');
            heading.className = 'fw-bold text-gold mb-2';
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
                pdfLink.className = 'btn btn-sm btn-danger';
                pdfLink.innerHTML = '<i class="fa-solid fa-file-pdf me-1"></i> Unduh PDF';
                const jpgLink = document.createElement('a');
                jpgLink.href = data.url_jpg;
                jpgLink.target = '_blank';
                jpgLink.rel = 'noopener';
                jpgLink.className = 'btn btn-sm btn-info text-white';
                jpgLink.innerHTML = '<i class="fa-solid fa-image me-1"></i> Lihat JPG';
                certificateActions.append(pdfLink, jpgLink);
                resultCard.append(certificateActions);
            }

            if (data.videos && data.videos.length > 0) {
                const videoHeading = document.createElement('div');
                videoHeading.className = 'fw-bold text-gold mb-2';
                videoHeading.textContent = 'Video dokumentasi';
                resultCard.append(videoHeading);

                data.videos.forEach(video => {
                    const videoCard = document.createElement('div');
                    videoCard.className = 'mb-3';
                    const name = document.createElement('div');
                    name.className = 'small mb-2 text-break';
                    name.textContent = video.name;
                    const player = document.createElement('video');
                    player.className = 'cek-hasil-video';
                    player.controls = true;
                    player.preload = 'metadata';
                    player.playsInline = true;
                    player.src = video.stream_url;
                    const download = document.createElement('a');
                    download.className = 'btn btn-sm btn-outline-light mt-2';
                    download.href = video.download_url;
                    download.innerHTML = '<i class="fa-solid fa-download me-1"></i> Unduh Video';
                    videoCard.append(name, player, download);
                    resultCard.append(videoCard);
                });
            }

            hasilCekSertifikat.append(resultCard);
        };

        document.getElementById('btnCekSertifikat').addEventListener('click', function() {
            let inputVal = document.getElementById('inputSertifikat').value;

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

            // Siapkan data untuk dikirim
            let formData = new FormData();
            formData.append('uuid', inputVal.trim());
            hasilCekSertifikat.replaceChildren();
            hasilCekSertifikat.classList.add('d-none');

            // Tembak ke Backend CI4
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
                        // Masih Proses
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
                        // Tidak Ditemukan
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
        });
    </script>
</body>

</html>