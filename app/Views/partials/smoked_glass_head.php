<?php
/**
 * Shared Head Tags for Calda-Inspired Smoked Glass Design System
 * - Synchronous pre-paint theme/frost/accent initializer (prevents FOUC/flicker)
 * - Preloads local pre-blurred background image
 * - Loads Urbanist variable font & Playfair Display serif font
 * - Loads smoked-glass.css and smoked-glass.js
 */
?>
<meta name="theme-color" content="#2a2c2f">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Badal Umrah">
<meta name="sg-sw-url" content="<?= base_url('sw.js'); ?>">
<meta name="sg-sw-scope" content="<?= rtrim(base_url(), '/') . '/'; ?>">
<link rel="manifest" href="<?= base_url('manifest.json'); ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('icons/icon-192x192.png'); ?>">
<link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('icons/icon-512x512.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('icons/apple-touch-icon-180x180.png'); ?>">
<script>
(function () {
    try {
        var r = document.documentElement;
        var theme = localStorage.getItem('bu_sg_theme') === 'light' ? 'light' : 'dark';
        var frost = parseFloat(localStorage.getItem('bu_sg_frost'));
        if (!isFinite(frost) || frost < 0 || frost > 1) frost = 0.5;
        var presets = {
            gold:    { dark: '#dfb86c', light: '#b8924b', inkDark: '#17191c', inkLight: '#ffffff', textDark: '#f6ddb0', textLight: '#856426' },
            sky:     { dark: '#29a1f7', light: '#1e9bf0', inkDark: '#0b1824', inkLight: '#ffffff', textDark: '#d3eaff', textLight: '#0c63a8' },
            emerald: { dark: '#34d399', light: '#15803d', inkDark: '#092016', inkLight: '#ffffff', textDark: '#a7f3d0', textLight: '#166534' },
            teal:    { dark: '#2dd4bf', light: '#0f766e', inkDark: '#071f1d', inkLight: '#ffffff', textDark: '#99f6e4', textLight: '#115e59' },
            amber:   { dark: '#fbbf24', light: '#b45309', inkDark: '#1c1505', inkLight: '#ffffff', textDark: '#fde68a', textLight: '#92400e' },
            rose:    { dark: '#fb7185', light: '#be123c', inkDark: '#23080d', inkLight: '#ffffff', textDark: '#fecdd3', textLight: '#9f1239' }
        };
        var accentKey = localStorage.getItem('bu_sg_sig_name') || 'gold';
        var p = presets[accentKey] || presets.gold;
        var isLight = theme === 'light';
        var sig = isLight ? p.light : p.dark;
        r.setAttribute('data-theme', theme);
        r.style.setProperty('--frost', String(frost));
        r.style.setProperty('--sig', sig);
        r.style.setProperty('--sig-ink', isLight ? p.inkLight : p.inkDark);
        r.style.setProperty('--sig-text', isLight ? p.textLight : p.textDark);
        var metaTheme = document.querySelector('meta[name="theme-color"]');
        if (metaTheme) metaTheme.setAttribute('content', isLight ? '#c9cbce' : '#2a2c2f');
    } catch (e) {}
})();
</script>
<link rel="preload" as="image" href="<?= base_url('img/bg-haram-blur.jpg'); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/smoked-glass.css?v=2'); ?>">
<script src="<?= base_url('js/smoked-glass.js?v=2'); ?>" defer></script>
