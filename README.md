# Badal Umrah

Aplikasi web untuk mengelola pendaftaran layanan badal umrah dan menerbitkan sertifikat pelaksanaan. Aplikasi dibuat dengan CodeIgniter 4.

## Fitur

- Formulir pendaftaran badal umrah dan pembuatan nomor registrasi.
- Pemeriksaan status pendaftaran dan tautan unduh sertifikat PDF/JPG.
- Panel admin untuk melihat pendaftaran, mengisi data pelaksanaan, dan membuat sertifikat.
- Pengaturan data master, termasuk nama direktur, daftar mutawwif, serta kredensial admin.
- Sertifikat menggunakan template gambar dan dapat menyertakan tanda tangan pelaksana.

## Teknologi

- PHP 8.2 atau lebih baru
- CodeIgniter 4
- MySQL/MariaDB
- Intervention Image dan FPDF

Ekstensi PHP yang diperlukan: `intl`, `mbstring`, `mysqli`, dan `gd`. Ekstensi `json` juga harus tersedia.

## Persiapan

1. Siapkan PHP dan MySQL/MariaDB, lalu buat database kosong untuk aplikasi.
2. Pasang dependensi PHP:

   ```sh
   composer install
   ```

3. Salin berkas konfigurasi contoh dan sesuaikan pengaturan aplikasi:

   ```powershell
   Copy-Item env .env
   ```

   Atur `app.baseURL` serta `database.default.hostname`, `database.default.database`, `database.default.username`, dan `database.default.password` di `.env`.

4. Jalankan migrasi untuk membuat tabel:

   ```sh
   php spark migrate
   ```

   Migrasi terbaru menambahkan soft delete untuk data pendaftaran. Pastikan migrasi ini dijalankan pada database lama sebelum menggunakan menu Sampah.

5. Jalankan server pengembangan:

   ```sh
   php spark serve
   ```

   Buka URL yang ditampilkan oleh perintah tersebut. Untuk deployment, arahkan document root web server ke direktori `public`, bukan ke root proyek.

## Penggunaan

- Pengunjung membuka `/pendaftaran` untuk mendaftar. Setelah berhasil, aplikasi menampilkan nomor registrasi yang digunakan untuk memeriksa sertifikat.
- Pengunjung menggunakan formulir cek sertifikat di halaman utama untuk melihat status dan mengunduh sertifikat yang sudah selesai.
- Admin masuk melalui `/login`. Pada instalasi baru tanpa kata sandi admin tersimpan, kredensial awal adalah **admin / rahasia123**. Segera ganti kata sandi melalui menu pengaturan setelah login.
- Admin mengelola data melalui `/admin`, lalu mengatur informasi master melalui menu pengaturan. Berkas template sertifikat berada di `public/templates/template_sertifikat.png`; tanda tangan pelaksana diletakkan di `public/signatures/`.
- Berkas sertifikat yang dihasilkan disimpan di `public/storage/certificates/`.
- Pendaftaran yang dihapus masuk ke menu **Sampah** pada panel admin. Data dapat dipulihkan atau dihapus permanen; penghapusan permanen juga menghapus berkas sertifikat PDF/JPG terkait.

Pastikan direktori penyimpanan yang digunakan aplikasi dapat ditulis oleh proses PHP. Jangan menyimpan kredensial produksi di repositori.

## Deploy otomatis melalui GitHub

Workflow `.github/workflows/deploy.yml` menjalankan deploy setiap ada push ke branch `main`, atau saat workflow dijalankan manual dari tab **Actions** di GitHub. Server diperbarui melalui SSH dengan `git pull --ff-only origin main`, lalu dependensi produksi dipasang menggunakan Composer. Migrasi database **tidak** dijalankan otomatis; jalankan `php spark migrate` secara manual setelah meninjau perubahan migrasi.

Persyaratan di hosting:

- SSH dan Git tersedia.
- Aplikasi sudah di-clone ke server, branch yang digunakan bernama `main`, dan remote `origin` menunjuk ke repositori ini.
- Server dapat mengakses repositori GitHub untuk menjalankan `git pull` (misalnya dengan deploy key GitHub yang hanya memiliki akses baca).
- PHP serta Composer tersedia di shell SSH server.

Tambahkan secrets berikut di **GitHub repository → Settings → Secrets and variables → Actions**:

| Secret | Nilai |
| --- | --- |
| `SSH_HOST` | Hostname server SSH |
| `SSH_PORT` | Port SSH; boleh tidak diisi jika menggunakan port `22` |
| `SSH_USER` | Username SSH |
| `SSH_PRIVATE_KEY` | Private key SSH yang diizinkan login ke hosting; simpan public key pasangannya di hosting |
| `SSH_KNOWN_HOSTS` | Host key server SSH yang telah diverifikasi |
| `DEPLOY_PATH` | Path absolut direktori aplikasi di server, yaitu direktori yang berisi `spark` dan `.git` |

Gunakan kunci SSH khusus deployment, jangan gunakan password akun hosting atau private key pribadi. Verifikasi fingerprint host key melalui penyedia hosting sebelum menyimpannya sebagai `SSH_KNOWN_HOSTS`. Setelah secrets terpasang, lakukan push ke `main` untuk memicu deploy. Periksa hasilnya di tab **Actions**; workflow akan gagal secara eksplisit jika koneksi SSH, `git pull`, atau Composer gagal.

## Pengujian

Jalankan pengujian dengan PHPUnit:

```sh
composer test
```
