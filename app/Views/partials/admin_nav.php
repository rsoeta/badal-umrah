<?php
/**
 * Shared Admin Navigation (Desktop Topbar Pill Nav + Mobile Floating Bottom Tabbar)
 * Uses Calda-parity `span.tabbar__pill` active indicator capsule on mobile.
 *
 * Expected optional vars:
 * - $activeMenu: 'pendaftar' | 'pengaturan' | 'sampah'
 * - $totalPendaftar: int|null
 * - $jumlah_sampah: int|null
 */
$activeMenu = $activeMenu ?? 'pendaftar';
?>
<nav class="sg-nav" aria-label="Menu Admin">
    <span class="tabbar__pill" aria-hidden="true"></span>
    <a href="<?= base_url('admin'); ?>" class="sg-nav__item<?= $activeMenu === 'pendaftar' ? ' is-active' : ''; ?>"<?= $activeMenu === 'pendaftar' ? ' aria-current="page"' : ''; ?>>
        <i class="fa-solid fa-table-list"></i>
        <span>Pendaftar</span>
        <?php if (isset($totalPendaftar)): ?>
            <span class="sg-nav__count"><?= (int) $totalPendaftar; ?></span>
        <?php endif; ?>
    </a>
    <a href="<?= base_url('admin/pengaturan'); ?>" class="sg-nav__item<?= $activeMenu === 'pengaturan' ? ' is-active' : ''; ?>"<?= $activeMenu === 'pengaturan' ? ' aria-current="page"' : ''; ?>>
        <i class="fa-solid fa-sliders"></i>
        <span>Pengaturan</span>
    </a>
    <a href="<?= base_url('admin/sampah'); ?>" class="sg-nav__item<?= $activeMenu === 'sampah' ? ' is-active' : ''; ?>"<?= $activeMenu === 'sampah' ? ' aria-current="page"' : ''; ?>>
        <i class="fa-solid fa-trash"></i>
        <span>Sampah</span>
        <?php if (! empty($jumlah_sampah) && (int) $jumlah_sampah > 0): ?>
            <span class="sg-nav__count"><?= (int) $jumlah_sampah; ?></span>
        <?php endif; ?>
    </a>
    <a href="<?= base_url('/'); ?>" target="_blank" rel="noopener" class="sg-nav__item">
        <i class="fa-solid fa-globe"></i>
        <span>Lihat Web</span>
    </a>
</nav>
