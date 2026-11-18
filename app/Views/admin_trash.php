<!DOCTYPE html>
<html lang="id" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sampah Pendaftaran - Admin</title>
    <meta name="title" content="Sampah Pendaftaran - Admin">
    <meta name="description" content="Kelola sampah pendaftaran dan pemulihan arsip data pendaftar Badal Umrah.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo-utama.png?v=2'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico?v=2'); ?>" />

    <!-- Open Graph / WhatsApp / Facebook Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= base_url('admin/sampah'); ?>">
    <meta property="og:title" content="Sampah Pendaftaran - Admin">
    <meta property="og:description" content="Kelola sampah pendaftaran dan pemulihan arsip data pendaftar Badal Umrah.">
    <meta property="og:image" content="<?= base_url('img/logo-utama.png'); ?>">
    <meta property="og:site_name" content="Badal Umrah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Sampah Pendaftaran - Admin">
    <meta name="twitter:description" content="Kelola sampah pendaftaran dan pemulihan arsip data pendaftar Badal Umrah.">
    <meta name="twitter:image" content="<?= base_url('img/logo-utama.png'); ?>">

    <!-- Smoked Glass Design System & Pre-Paint Theme Loader -->
    <?= $this->include('partials/smoked_glass_head'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sg-body">

    <?= $this->include('partials/smoked_glass_bg'); ?>

    <div class="sg-frame">
        <header class="sg-topbar">
            <a class="sg-brand" href="<?= base_url('admin'); ?>">
                <img src="<?= base_url('img/logo-utama.png'); ?>" alt="Logo Admin Panel" class="sg-brand__logo">
                <div class="sg-brand__meta">
                    <span class="sg-brand__name">Admin Panel</span>
                    <span class="sg-brand__sub">Sampah &amp; Pemulihan Arsip</span>
                </div>
            </a>

            <?= view('partials/admin_nav', [
                'activeMenu'    => 'sampah',
                'jumlah_sampah' => count($pendaftar),
            ]); ?>

            <div class="sg-actions">
                <?= $this->include('partials/smoked_glass_customizer'); ?>
                <a href="<?= base_url('admin'); ?>" class="sg-icon-btn" aria-label="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="sg-btn-label">Kembali</span>
                </a>
            </div>
        </header>

        <main id="main-content" class="sg-pane sg-main">
            <header class="sg-phead pb-3 mb-4 border-bottom">
                <div>
                    <div class="sg-phead__kicker">
                        <i class="fa-solid fa-trash"></i>
                        <span>Arsip Sementara</span>
                    </div>
                    <h1 class="sg-h1">Sampah Pendaftaran</h1>
                    <p class="sg-phead__sub">Pulihkan pendaftaran atau hapus permanen beserta berkas sertifikatnya.</p>
                </div>
                <span class="sg-pill sg-pill--sig fs-6"><?= count($pendaftar); ?> data</span>
            </header>

            <section class="sg-card sg-card--flush">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No. Registrasi</th>
                                <th>Pemesan</th>
                                <th>Di-umrahkan</th>
                                <th>Status</th>
                                <th>Tanggal dihapus</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendaftar as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-bold sg-text-ink"><?= esc($row['uuid']); ?></td>
                                    <td><?= esc($row['nama_pemesan']); ?></td>
                                    <td class="fw-semibold sg-text-ink"><?= esc($row['nama_diumrahkan']); ?></td>
                                    <td>
                                        <span class="sg-pill <?= $row['status'] === 'selesai' ? 'sg-pill--good' : 'sg-pill--warn'; ?>">
                                            <?= esc(ucfirst($row['status'])); ?>
                                        </span>
                                    </td>
                                    <td><?= esc($row['deleted_at']); ?></td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 btn-restore" data-id="<?= $row['id']; ?>">
                                                <i class="fa-solid fa-rotate-left me-1"></i> Pulihkan
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-hapus-permanen" data-id="<?= $row['id']; ?>" data-uuid="<?= esc($row['uuid'], 'attr'); ?>">
                                                <i class="fa-solid fa-trash-can me-1"></i> Hapus Permanen
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ($pendaftar === []): ?>
                                <tr>
                                    <td colspan="6" class="text-center sg-text-muted py-5">
                                        <i class="fa-regular fa-folder-open fs-2 d-block mb-2"></i>
                                        Sampah kosong.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        const sendTrashAction = (url, confirmTitle, confirmText, successTitle) => {
            Swal.fire({
                title: confirmTitle,
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754'
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch(url, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'success') throw new Error(data.message);
                        return Swal.fire({
                            icon: data.warning ? 'warning' : 'success',
                            title: data.warning ? 'Perlu Perhatian' : successTitle,
                            text: data.warning || data.message
                        });
                    })
                    .then(() => location.reload())
                    .catch(error => Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan sistem.'
                    }));
            });
        };

        document.querySelectorAll('.btn-restore').forEach(button => {
            button.addEventListener('click', () => sendTrashAction(
                `<?= base_url('admin/pendaftaran'); ?>/${button.dataset.id}/restore`,
                'Pulihkan pendaftaran?',
                'Data akan muncul kembali di daftar pendaftar.',
                'Berhasil dipulihkan'
            ));
        });

        document.querySelectorAll('.btn-hapus-permanen').forEach(button => {
            button.addEventListener('click', () => sendTrashAction(
                `<?= base_url('admin/pendaftaran'); ?>/${button.dataset.id}/hapus-permanen`,
                'Hapus permanen?',
                `Data ${button.dataset.uuid}, berkas sertifikat, dan video dokumentasinya tidak dapat dipulihkan.`,
                'Berhasil dihapus'
            ));
        });
    </script>
</body>

</html>
