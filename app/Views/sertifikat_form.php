<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Sertifikat Badal Umrah</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            width: 100%;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #004494;
        }

        /* Custom styling agar SweetAlert2 ringkas dan nyaman di mobile */
        .swal-mobile-custom {
            font-size: 0.85rem !important;
            width: 85% !important;
            max-width: 320px !important;
            padding: 1em !important;
        }

        .swal-title-custom {
            font-size: 1.1rem !important;
        }

        .swal-btn-custom {
            padding: 8px 16px !important;
            font-size: 0.85rem !important;
        }
    </style>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="card">
        <h3 style="text-align: center; color: #333; margin-top: 0;">Sertifikat Badal Umrah</h3>
        <form id="formSertifikat" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Pelaksana</label>
                <select name="pelaksana_data" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">-- Pilih Pelaksana --</option>
                    <!-- Format value: "Nama Lengkap|namafile.png" -->
                    <option value="Ust. Azis Rustandi|ttd-azis.png">Ust. Azis Rustandi</option>
                    <option value="Ust. Ahmad Fadil|ttd-ahmad.png">Ust. Ahmad Fadil</option>
                    <!-- Tambahkan pelaksana lain di sini nantinya -->
                </select>
            </div>
            <div class="form-group">
                <label>Nama Di-umrahkan</label>
                <input type="text" name="nama_diumrahkan" required placeholder="Contoh: Hj. Siti Aminah binti Fulan">
            </div>
            <div class="form-group">
                <label>Foto untuk Sertifikat (Opsional)</label>
                <input type="file" name="foto_jamaah" accept="image/jpeg,image/png,image/webp">
                <small>JPG, PNG, atau WEBP, maksimal 5 MB. Foto akan dipotong ke rasio 3:4.</small>
            </div>
            <div class="form-group">
                <label>Tanggal Miqat (Masehi)</label>
                <!-- Menggunakan input date -->
                <input type="date" name="tanggal_miqat" required>
            </div>
            <div class="form-group">
                <label>Tanggal Cetak (Masehi)</label>
                <!-- Menggunakan input date -->
                <input type="date" name="tanggal_cetak" required>
            </div>
            <div class="form-group" style="background: #eef9ff; padding: 10px; border-radius: 5px;">
                <label>Koreksi Selisih Hari Hijriah (Jika Ada)</label>
                <p style="font-size: 11px; margin-top:0; color:#555;">Isi <b>1</b> atau <b>-1</b> jika penanggalan Hijriah hari ini meleset. Biarkan 0 jika sudah pas.</p>
                <input type="number" name="koreksi_hijriah" value="0" required>
            </div>
            <button type="submit">Generate Sertifikat</button>
        </form>
    </div>

    <script>
        document.getElementById('formSertifikat').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // SweetAlert2 Loading State (Mobile Custom)
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang membuat sertifikat, mohon tunggu.',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-mobile-custom',
                    title: 'swal-title-custom'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url('sertifikat/generate') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Sertifikat gagal dibuat.',
                            customClass: {
                                popup: 'swal-mobile-custom'
                            }
                        });
                        return;
                    }

                    // SweetAlert2 Berhasil dengan Opsi Salin Tautan (Mobile Custom)
                    Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: 'Sertifikat berhasil di-generate.',
                        showDenyButton: true,
                        confirmButtonText: '<i class="fa fa-file-pdf"></i> Buka PDF',
                        denyButtonText: '<i class="fa fa-image"></i> Buka JPG',
                        customClass: {
                            popup: 'swal-mobile-custom',
                            title: 'swal-title-custom',
                            confirmButton: 'swal-btn-custom',
                            denyButton: 'swal-btn-custom'
                        }
                    }).then((result) => {
                        // Memberikan opsi apakah admin ingin membuka PDF atau JPG-nya
                        if (result.isConfirmed) {
                            window.open(data.url_pdf, '_blank');
                        } else if (result.isDenied) {
                            window.open(data.url_jpg, '_blank');
                        }
                    });
                    // Reset form jika sudah selesai
                    document.getElementById('formSertifikat').reset();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.',
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