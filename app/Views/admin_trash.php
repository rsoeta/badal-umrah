<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampah Pendaftaran - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/jpeg" href="<?= base_url('img/Gemini_Generated_Image_wfab1ywfab1ywfab.jpeg'); ?>" />
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark shadow-sm mb-4" style="background-color: #0f3d23;">
        <div class="container-fluid px-md-4">
            <a class="navbar-brand fw-bold" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-kaaba me-2 text-warning"></i> Admin Panel
            </a>
            <a href="<?= base_url('admin'); ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="container-fluid px-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h4 class="fw-bold mb-1"><i class="fa-solid fa-trash me-2 text-secondary"></i>Sampah Pendaftaran</h4>
                <p class="text-muted mb-0">Pulihkan pendaftaran atau hapus permanen beserta berkas sertifikatnya.</p>
            </div>
            <span class="badge bg-secondary rounded-pill fs-6"><?= count($pendaftar); ?> data</span>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                                <td class="ps-4 fw-bold"><?= esc($row['uuid']); ?></td>
                                <td><?= esc($row['nama_pemesan']); ?></td>
                                <td><?= esc($row['nama_diumrahkan']); ?></td>
                                <td><span class="badge bg-<?= $row['status'] === 'selesai' ? 'success' : 'warning text-dark'; ?>"><?= esc(ucfirst($row['status'])); ?></span></td>
                                <td><?= esc($row['deleted_at']); ?></td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-success btn-restore" data-id="<?= $row['id']; ?>">
                                            <i class="fa-solid fa-rotate-left me-1"></i> Pulihkan
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-permanen" data-id="<?= $row['id']; ?>" data-uuid="<?= esc($row['uuid'], 'attr'); ?>">
                                            <i class="fa-solid fa-trash-can me-1"></i> Hapus Permanen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if ($pendaftar === []): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fa-regular fa-folder-open fs-2 d-block mb-2"></i>
                                    Sampah kosong.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

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
                `Data ${button.dataset.uuid} dan berkas sertifikatnya tidak dapat dipulihkan.`,
                'Berhasil dihapus'
            ));
        });
    </script>
</body>

</html>
