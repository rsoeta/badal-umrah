<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f1ea;
        }

        .text-gold {
            color: #b8924b;
        }

        .bg-green {
            background-color: #0f3d23;
        }

        .btn-gold {
            background-color: #b8924b;
            color: white;
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background-color: #9c7b3e;
            color: white;
        }

        .card-form {
            border: none;
            border-top: 5px solid #b8924b;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
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
    </style>
</head>

<body>

    <!-- Header Sederhana -->
    <div class="bg-green py-3 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="<?= base_url('/'); ?>" class="text-white text-decoration-none d-flex align-items-center">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Azis Rustandi" style="height: 40px; object-fit: contain;" class="me-2 bg-white rounded p-1">
                <span class="fw-bold font-serif d-none d-md-block">Azis Rustandi</span>
            </a>
            <a href="<?= base_url('/'); ?>" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="text-center mb-4">
                    <h2 class="fw-bold font-serif" style="color: #0f3d23;">Formulir Pendaftaran</h2>
                    <p class="text-muted small">Silakan lengkapi data di bawah ini untuk pendaftaran Badal Umrah.</p>
                </div>

                <div class="card card-form">
                    <div class="card-body p-4 p-md-5">
                        <form id="formPendaftaran" enctype="multipart/form-data">

                            <h6 class="fw-bold text-gold mb-3 border-bottom pb-2"><i class="fa-solid fa-user-pen me-2"></i>Data Pemesan (Keluarga)</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemesan" class="form-control" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-medium">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="number" name="no_wa_pemesan" class="form-control" placeholder="Contoh: 08123456789" required>
                                <div class="form-text" style="font-size: 0.7rem;">Nomor ini akan digunakan untuk mengirimkan update dan dokumentasi.</div>
                            </div>

                            <h6 class="fw-bold text-gold mb-3 border-bottom pb-2 mt-4"><i class="fa-solid fa-bed me-2"></i>Data Almarhum / Jamaah</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">Nama Lengkap yang Di-umrahkan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_diumrahkan" class="form-control" placeholder="Contoh: H. Fulan bin Fulan" required>
                                <div class="form-text" style="font-size: 0.7rem;">Tuliskan nama lengkap beserta nama ayah (Bin/Binti).</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-medium">Foto untuk Sertifikat <span class="text-muted">(Opsional)</span></label>
                                <input type="file" name="foto_jamaah" class="form-control" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text" style="font-size: 0.7rem;">Format JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4 pada sertifikat.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-medium">Pilihan Paket <span class="text-danger">*</span></label>
                                <select name="paket_pilihan" class="form-select" required>
                                    <option value="">-- Pilih Paket --</option>
                                    <option value="Paket Standar (Rp 1.5 Jt)">Paket Standar (Rp 1,5 Jt)</option>
                                    <option value="Paket Paripurna (Rp 2 Jt)">Paket Paripurna + Santunan (Rp 2 Jt)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-gold w-100 py-2 mt-2 shadow-sm"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Pendaftaran</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4 text-muted small">
                    <p><i class="fa-solid fa-lock me-1"></i> Data Anda dijamin kerahasiaan dan keamanannya.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Proses Form -->
    <script>
        document.getElementById('formPendaftaran').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // SweetAlert2 Loading
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
                        // SweetAlert2 Berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Alhamdulillah, Terdaftar!',
                            html: `Pendaftaran Anda telah kami terima.<br><br><b>Nomor Registrasi:</b><br><span style="color:#0f3d23; font-size:1.2rem; font-weight:bold;">${data.uuid}</span><br><br><small>Mohon simpan nomor registrasi di atas untuk keperluan pengecekan sertifikat.</small>`,
                            confirmButtonText: 'Selesai',
                            customClass: {
                                popup: 'swal-mobile-custom',
                                title: 'swal-title-custom'
                            }
                        }).then(() => {
                            // Reset form setelah sukses
                            document.getElementById('formPendaftaran').reset();
                            // Opsi: Arahkan langsung ke chat WA Admin membawa nomor registrasi
                            // window.location.href = `https://wa.me/6282111133929?text=Assalamu'alaikum,%20saya%20sudah%20mendaftar%20Badal%20Umrah%20dengan%20Nomor%20Registrasi:%20${data.uuid}`;
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