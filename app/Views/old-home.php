<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>Raehan Cipta Pesona - Layanan Badal Umroh Amanah</title>
    <meta name="title" content="Raehan Cipta Pesona - Layanan Badal Umroh Amanah">
    <meta name="description" content="Jasa Badal Umroh terpercaya untuk orang tercinta yang sudah meninggal atau udzur syar'i. Amanah, bersertifikat resmi, dan didokumentasikan lengkap.">

    <!-- Favicon (Ikon kecil di tab browser) -->
    <!-- Jika di CodeIgniter, gunakan: href="<?= base_url('img/logo.jpeg') ?>" -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('img/logo.jpeg') ?>">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url(); ?>">
    <meta property="og:title" content="🕋 Badal Umroh - Raehan Cipta Pesona">
    <meta property="og:description" content="Hadiah ibadah terbaik untuk orang tercinta yang telah tiada. Dilaksanakan oleh tenaga profesional, dilengkapi video dokumentasi & sertifikat eksklusif. Klik untuk info paket!">

    <!-- PENTING: OG Image wajib menggunakan URL Absolut (lengkap dengan https://...) agar terbaca oleh WhatsApp -->
    <!-- Jika di CI4: content="<?= base_url('img/logo.jpeg') ?>" -->
    <meta property="og:image" content="<?= base_url('img/logo.jpeg') ?>">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="800">

    <!-- Twitter (Opsional, tapi bagus untuk SEO) -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= base_url(); ?>">
    <meta property="twitter:title" content="🕋 Badal Umroh - Raehan Cipta Pesona">
    <meta property="twitter:description" content="Hadiah ibadah terbaik untuk orang tercinta yang telah tiada. Dilengkapi video dokumentasi & sertifikat eksklusif.">
    <meta property="twitter:image" content="<?= base_url('img/logo.jpeg') ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ... (Kode CSS yang sebelumnya tetap ada di sini) ... */
        :root {
            --navy-dark: #071324;
            --navy-light: #10243e;
            --gold-primary: #d4af37;
            --gold-light: #f3e5ab;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Tema Klasik untuk Judul */
        .font-serif {
            font-family: 'Cinzel', serif;
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .bg-navy {
            background-color: var(--navy-dark) !important;
        }

        .bg-navy-light {
            background-color: var(--navy-light) !important;
        }

        /* Navbar */
        .navbar {
            background-color: #ffffff;
            border-bottom: 3px solid var(--gold-primary);
        }

        .navbar-brand img {
            height: 45px;
            object-fit: contain;
        }

        .navbar-brand span {
            font-weight: 700;
            color: var(--navy-dark);
            font-size: 1.2rem;
            margin-left: 10px;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(7, 19, 36, 0.85), rgba(7, 19, 36, 0.9)), url('https://images.unsplash.com/photo-1591814246083-09ebfaeebc03?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            color: white;
            padding: 120px 0 80px;
            border-bottom: 5px solid var(--gold-primary);
        }

        .hero-title {
            font-size: 4rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            letter-spacing: 2px;
        }

        /* Custom SweetAlert2 Mobile-Friendly */
        .swal-mobile-custom {
            font-size: 0.85rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
        }

        .swal-title-custom {
            font-size: 1.1rem !important;
        }

        /* Floating WA Button */
        .float-wa {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .float-wa i {
            margin-top: 15px;
        }

        .float-wa:hover {
            color: white;
            background-color: #20b858;
        }

        .section-title {
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--gold-primary);
        }

        /* Card Paket VIP */
        .card-paket {
            border: 2px solid var(--gold-primary);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-paket .card-header {
            background-color: var(--navy-dark);
            color: var(--gold-light);
            border-bottom: 2px solid var(--gold-primary);
        }

        .btn-gold {
            background-color: var(--gold-primary);
            color: var(--navy-dark);
            font-weight: bold;
        }

        .btn-gold:hover {
            background-color: #b5952f;
            color: white;
        }

        /* Icon Box */
        .icon-box {
            background: var(--navy-light);
            padding: 25px;
            border-radius: 10px;
            border: 1px solid var(--gold-primary);
            color: white;
            height: 100%;
            transition: 0.3s;
        }

        .icon-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .icon-box i {
            color: var(--gold-primary);
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <!-- Ganti src dengan nama file logo asli Kang Rian (misal: logo.jpg) -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<?= base_url('img/logo.jpeg'); ?>" alt="Logo Raehan Cipta Pesona">
                <span>Raehan Cipta Pesona</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark" href="#cek-sertifikat">Cek Sertifikat</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#paket">Paket Umroh</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title font-serif text-gold mb-3">BADAL UMROH</h1>
            <h4 class="fw-bold mb-4" style="color: var(--gold-light);">HADIAH IBADAH TERBAIK UNTUK ORANG TERCINTA</h4>
            <p class="lead mb-5 mx-auto" style="max-width: 800px;">
                Jasa Badal Umroh untuk orang tercinta yang sudah meninggal atau sudah tidak memungkinkan berangkat umroh lagi.
            </p>
            <a href="#paket" class="btn btn-gold btn-lg px-5 rounded-pill shadow"><i class="fa-brands fa-whatsapp me-2"></i>Hubungi Kami</a>
        </div>
    </section>

    <!-- 1. Cek Sertifikat Section (Tema Terang) -->
    <section id="cek-sertifikat" class="py-5 bg-white">
        <div class="container text-center">
            <h3 class="section-title">Validasi Sertifikat Digital</h3>
            <p class="text-muted mb-4">Masukkan Nomor Registrasi untuk mengunduh sertifikat berbingkai resmi dari Raehan Cipta Pesona.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3 shadow-sm border border-warning rounded">
                        <input type="text" id="inputSertifikat" class="form-control form-control-lg border-0" placeholder="Nomor Registrasi...">
                        <button class="btn btn-gold px-4" type="button" id="btnCekSertifikat"><i class="fa-solid fa-search"></i> Cek</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Keunggulan & Dalil (Tema Navy) -->
    <section id="keunggulan" class="py-5 bg-navy-light text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 text-center">
                    <i class="fa-solid fa-quote-left fa-3x text-gold mb-3"></i>
                    <h3 class="font-serif text-gold mb-3">"Sempurnakanlah Ibadah Haji dan Umrah Karena Allah."</h3>
                    <p class="fw-bold text-light">— QS. Al-Baqarah: 196 —</p>

                    <div class="mt-5 p-4 border border-warning rounded" style="background: rgba(212, 175, 55, 0.1);">
                        <h5 class="text-gold fw-bold mb-3"><i class="fa-solid fa-gift me-2"></i>Program Spesial Pahala Jariyah</h5>
                        <p class="mb-0 text-start small">Sebagai pelengkap ibadah, layanan kami memfasilitasi <b>Pemberian Bingkisan ke Panti Asuhan</b> atas nama Almarhum/Almarhumah beserta doa bersama anak yatim.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="icon-box text-center">
                                <i class="fa-solid fa-shield-halved"></i>
                                <h5 class="fw-bold">Amanah</h5>
                                <p class="small mb-0">Dilaksanakan dengan penuh tanggung jawab sesuai syariat Islam.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon-box text-center">
                                <i class="fa-solid fa-certificate"></i>
                                <h5 class="fw-bold">Bersertifikat</h5>
                                <p class="small mb-0">Mendapatkan sertifikat resmi cetak dan digital beresolusi tinggi.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon-box text-center">
                                <i class="fa-solid fa-user-tie"></i>
                                <h5 class="fw-bold">Profesional</h5>
                                <p class="small mb-0">Dilakukan oleh ustadz dan mukimin berpengalaman di Tanah Suci.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon-box text-center">
                                <i class="fa-solid fa-camera"></i>
                                <h5 class="fw-bold">Dokumentasi</h5>
                                <p class="small mb-0">Video lengkap dari Miqat, Tawaf, Sa'i, hingga Tahallul.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Paket Badal Umroh -->
    <section id="paket" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center">Pilihan Paket Badal Umroh</h2>
            <div class="row justify-content-center mt-5 g-4">

                <!-- Paket 1.5 JT -->
                <div class="col-md-5">
                    <div class="card card-paket h-100 shadow-lg">
                        <div class="card-header text-center py-4">
                            <h4 class="font-serif fw-bold mb-0">PAKET STANDAR</h4>
                            <h2 class="display-6 fw-bold mt-2 mb-0">Rp 1,5 Jt</h2>
                        </div>
                        <div class="card-body bg-light p-4">
                            <ul class="list-group list-group-flush mb-4 bg-transparent">
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Pelaksanaan oleh Mutawwif Profesional</li>
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Dokumentasi Video Pelaksanaan</li>
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Sertifikat Digital (PDF/JPG)</li>
                                <li class="list-group-item bg-transparent text-muted"><i class="fa-solid fa-minus me-2"></i> Tanpa Sertifikat Cetak Bingkai</li>
                                <li class="list-group-item bg-transparent text-muted"><i class="fa-solid fa-minus me-2"></i> Tanpa Bingkisan Panti Asuhan</li>
                            </ul>
                            <div class="d-grid mt-auto">
                                <a href="https://wa.me/6282111133929" target="_blank" class="btn btn-outline-dark fw-bold">Pilih Paket</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paket 2 JT (Unggulan) -->
                <div class="col-md-5">
                    <div class="card card-paket h-100 shadow-lg" style="transform: scale(1.03); border-width: 3px;">
                        <div class="card-header text-center py-4 position-relative">
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold rounded-start border-bottom border-light">TERFAVORIT</div>
                            <h4 class="font-serif fw-bold mb-0">PAKET PARIPURNA</h4>
                            <h2 class="display-6 fw-bold mt-2 mb-0 text-gold">Rp 2 Jt</h2>
                        </div>
                        <div class="card-body bg-light p-4">
                            <ul class="list-group list-group-flush mb-4 bg-transparent">
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Pelaksanaan oleh Mutawwif Profesional</li>
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Dokumentasi Video Pelaksanaan</li>
                                <li class="list-group-item bg-transparent"><i class="fa-solid fa-check text-success me-2"></i> Sertifikat Digital (PDF/JPG)</li>
                                <li class="list-group-item bg-transparent fw-bold"><i class="fa-solid fa-check text-success me-2"></i> Sertifikat Cetak & Bingkai Eksklusif</li>
                                <li class="list-group-item bg-transparent fw-bold text-success"><i class="fa-solid fa-check text-success me-2"></i> Bingkisan Panti Asuhan Atas Nama Almarhum</li>
                            </ul>
                            <div class="d-grid mt-auto">
                                <a href="https://wa.me/6282111133929" target="_blank" class="btn btn-gold fw-bold shadow">Pilih Paket Paripurna</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-navy text-white pt-5 pb-4 border-top" style="border-color: var(--gold-primary) !important; border-width: 3px !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold fw-bold mb-3">Raehan Cipta Pesona</h5>
                    <p class="small text-light pe-lg-5">Menghadirkan layanan Badal Umroh terbaik dan amanah untuk menyempurnakan ibadah keluarga tercinta Anda yang telah tiada atau memiliki udzur syar'i.</p>
                </div>
                <div class="col-md-6 mb-4 text-md-end">
                    <h5 class="text-gold mb-3">Hubungi Kami</h5>
                    <h3 class="fw-bold mb-3"><i class="fa-brands fa-whatsapp text-success me-2"></i>0821-1113-3929</h3>
                    <p class="small text-light"><i class="fa-solid fa-location-dot me-2"></i> Kantor Layanan Utama: Jawa Barat</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6282111133929" class="float-wa" target="_blank" title="Konsultasi via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Script Interaksi -->
    <script>
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

            // Simulasi proses pencarian data
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sertifikat Ditemukan!',
                    text: 'Sertifikat atas registrasi ' + inputVal + ' siap diunduh.',
                    showDenyButton: true,
                    confirmButtonText: '<i class="fa fa-file-pdf"></i> PDF',
                    denyButtonText: '<i class="fa fa-image"></i> JPG',
                    customClass: {
                        popup: 'swal-mobile-custom',
                        title: 'swal-title-custom'
                    }
                });
            }, 1500);
        });
    </script>
</body>

</html>