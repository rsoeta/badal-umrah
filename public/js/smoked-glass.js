/* ==========================================================================
   Smoked Glass Theme & Frost Controller (Calda Parity)
   - Persists theme (dark/light), frost opacity (0..1), and accent color
   - Manages interactive "Adjust Glass" popover & quick theme switcher
   ========================================================================== */
(function () {
    const STORAGE_KEYS = {
        theme: 'bu_sg_theme',
        frost: 'bu_sg_frost',
        sigDark: 'bu_sg_sig_dark',
        sigLight: 'bu_sg_sig_light',
        sigName: 'bu_sg_sig_name'
    };

    const ACCENT_PRESETS = {
        gold:    { label: 'Gold',    dark: '#dfb86c', light: '#b8924b', inkDark: '#17191c', inkLight: '#ffffff', textDark: '#f6ddb0', textLight: '#856426' },
        sky:     { label: 'Sky',     dark: '#29a1f7', light: '#1e9bf0', inkDark: '#0b1824', inkLight: '#ffffff', textDark: '#d3eaff', textLight: '#0c63a8' },
        emerald: { label: 'Emerald', dark: '#34d399', light: '#15803d', inkDark: '#092016', inkLight: '#ffffff', textDark: '#a7f3d0', textLight: '#166534' },
        teal:    { label: 'Teal',    dark: '#2dd4bf', light: '#0f766e', inkDark: '#071f1d', inkLight: '#ffffff', textDark: '#99f6e4', textLight: '#115e59' },
        amber:   { label: 'Amber',   dark: '#fbbf24', light: '#b45309', inkDark: '#1c1505', inkLight: '#ffffff', textDark: '#fde68a', textLight: '#92400e' },
        rose:    { label: 'Rose',    dark: '#fb7185', light: '#be123c', inkDark: '#23080d', inkLight: '#ffffff', textDark: '#fecdd3', textLight: '#9f1239' }
    };

    const hexToRgba = (hex, alpha) => {
        const clean = hex.replace('#', '');
        const r = parseInt(clean.slice(0, 2), 16);
        const g = parseInt(clean.slice(2, 4), 16);
        const b = parseInt(clean.slice(4, 6), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    };

    const applyAccent = (presetKey, theme) => {
        const preset = ACCENT_PRESETS[presetKey] || ACCENT_PRESETS.gold;
        const root = document.documentElement;
        const isLight = theme === 'light';
        const sig = isLight ? preset.light : preset.dark;
        root.style.setProperty('--sig', sig);
        root.style.setProperty('--sig-ink', isLight ? preset.inkLight : preset.inkDark);
        root.style.setProperty('--sig-text', isLight ? preset.textLight : preset.textDark);
        root.style.setProperty('--sig-soft', hexToRgba(sig, isLight ? 0.14 : 0.16));
        root.style.setProperty('--sig-border', hexToRgba(sig, 0.42));
    };

    const getState = () => {
        const theme = localStorage.getItem(STORAGE_KEYS.theme) === 'light' ? 'light' : 'dark';
        const rawFrost = parseFloat(localStorage.getItem(STORAGE_KEYS.frost));
        const frost = Number.isFinite(rawFrost) ? Math.min(1, Math.max(0, rawFrost)) : 0.5;
        const accent = localStorage.getItem(STORAGE_KEYS.sigName) || 'gold';
        return { theme, frost, accent };
    };

    const applyState = ({ theme, frost, accent }) => {
        const root = document.documentElement;
        root.setAttribute('data-theme', theme);
        root.style.setProperty('--frost', String(frost));
        applyAccent(accent, theme);

        const metaTheme = document.querySelector('meta[name="theme-color"]');
        if (metaTheme) {
            metaTheme.setAttribute('content', theme === 'light' ? '#c9cbce' : '#2a2c2f');
        }

        // Update theme toggle button icon/label if present
        document.querySelectorAll('[data-sg-theme-toggle]').forEach(btn => {
            const icon = btn.querySelector('i');
            const label = btn.querySelector('.sg-btn-label');
            const isLight = theme === 'light';
            if (icon) {
                icon.className = isLight ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
            }
            if (label) {
                label.textContent = isLight ? 'Smoke' : 'Frost';
            }
            btn.setAttribute('aria-label', isLight ? 'Ganti ke tema Smoke (gelap)' : 'Ganti ke tema Frost (terang)');
            btn.setAttribute('title', isLight ? 'Ganti ke tema Smoke (gelap)' : 'Ganti ke tema Frost (terang)');
        });

        // Sync controls inside popover if mounted
        document.querySelectorAll('[data-sg-theme-option]').forEach(el => {
            el.classList.toggle('is-active', el.dataset.sgThemeOption === theme);
        });

        document.querySelectorAll('[data-sg-frost-slider]').forEach(slider => {
            slider.value = String(Math.round(frost * 100));
        });

        document.querySelectorAll('[data-sg-frost-value]').forEach(out => {
            out.textContent = `${Math.round(frost * 100)}%`;
        });

        document.querySelectorAll('[data-sg-swatch]').forEach(sw => {
            sw.classList.toggle('is-active', sw.dataset.sgSwatch === accent);
        });
    };

    const syncTabbarPills = () => {
        const navs = document.querySelectorAll('.sg-nav:not(.sg-nav--desktop-only)');
        if (navs.length === 0) {
            document.body.classList.remove('sg-has-tabbar');
            return;
        }

        document.body.classList.add('sg-has-tabbar');
        const isMobile = window.matchMedia('(max-width: 767.98px)').matches;

        navs.forEach(nav => {
            const pill = nav.querySelector('.tabbar__pill');
            if (!pill) return;

            if (!isMobile) {
                nav.classList.remove('has-tabbar-pill');
                pill.classList.remove('is-ready');
                pill.style.width = '';
                pill.style.transform = '';
                return;
            }

            const activeItem =
                nav.querySelector('.sg-nav__item.is-active, .sg-nav__item[aria-current="page"]') ||
                nav.querySelector('.sg-nav__item');

            if (!activeItem) return;

            const width = activeItem.offsetWidth;
            const left = activeItem.offsetLeft;
            if (width > 0) {
                nav.classList.add('has-tabbar-pill');
                pill.style.width = `${width}px`;
                pill.style.transform = `translateX(${left}px)`;
                pill.classList.add('is-ready');
            }
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        applyState(getState());
        syncTabbarPills();
        window.addEventListener('resize', syncTabbarPills, { passive: true });

        // Quick Theme Toggle Buttons & Tabbar Interactions
        document.addEventListener('click', (e) => {
            if (!(e.target instanceof Element)) return;

            const navItem = e.target.closest('.sg-nav__item');
            if (navItem) {
                const href = navItem.getAttribute('href') || '';
                if (href.startsWith('#')) {
                    const nav = navItem.closest('.sg-nav');
                    if (nav) {
                        nav.querySelectorAll('.sg-nav__item').forEach(item => {
                            item.classList.remove('is-active');
                            item.removeAttribute('aria-current');
                        });
                        navItem.classList.add('is-active');
                        navItem.setAttribute('aria-current', 'page');
                        syncTabbarPills();
                    }
                }
            }

            const toggleBtn = e.target.closest('[data-sg-theme-toggle]');
            if (toggleBtn) {
                const state = getState();
                state.theme = state.theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem(STORAGE_KEYS.theme, state.theme);
                applyState(state);
                return;
            }

            const themeOpt = e.target.closest('[data-sg-theme-option]');
            if (themeOpt) {
                const state = getState();
                state.theme = themeOpt.dataset.sgThemeOption === 'light' ? 'light' : 'dark';
                localStorage.setItem(STORAGE_KEYS.theme, state.theme);
                applyState(state);
                return;
            }

            const swatch = e.target.closest('[data-sg-swatch]');
            if (swatch) {
                const state = getState();
                state.accent = swatch.dataset.sgSwatch || 'gold';
                localStorage.setItem(STORAGE_KEYS.sigName, state.accent);
                applyState(state);
                return;
            }

            const popTrigger = e.target.closest('[data-sg-popover-toggle]');
            const popover = document.getElementById('sgGlassPopover');
            if (popTrigger && popover) {
                const isHidden = popover.hasAttribute('hidden');
                if (isHidden) {
                    popover.removeAttribute('hidden');
                    popTrigger.setAttribute('aria-expanded', 'true');
                } else {
                    popover.setAttribute('hidden', '');
                    popTrigger.setAttribute('aria-expanded', 'false');
                }
                return;
            }

            if (popover && !popover.hasAttribute('hidden') && !e.target.closest('#sgGlassPopover')) {
                popover.setAttribute('hidden', '');
                const trigger = document.querySelector('[data-sg-popover-toggle]');
                if (trigger) trigger.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('input', (e) => {
            if (!(e.target instanceof Element)) return;
            const slider = e.target.closest('[data-sg-frost-slider]');
            if (!slider) return;
            const state = getState();
            state.frost = Math.min(1, Math.max(0, parseInt(slider.value, 10) / 100));
            localStorage.setItem(STORAGE_KEYS.frost, String(state.frost));
            applyState(state);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const popover = document.getElementById('sgGlassPopover');
                if (popover && !popover.hasAttribute('hidden')) {
                    popover.setAttribute('hidden', '');
                    const trigger = document.querySelector('[data-sg-popover-toggle]');
                    if (trigger) {
                        trigger.setAttribute('aria-expanded', 'false');
                        trigger.focus();
                    }
                }
            }
        });
    });

    // Register Progressive Web App Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            const swMeta = document.querySelector('meta[name="sg-sw-url"]');
            const scopeMeta = document.querySelector('meta[name="sg-sw-scope"]');
            const swUrl = swMeta ? swMeta.getAttribute('content') : '/sw.js';
            const swScope = scopeMeta ? scopeMeta.getAttribute('content') : '/';

            navigator.serviceWorker
                .register(swUrl, { scope: swScope, updateViaCache: 'none' })
                .catch((err) => {
                    console.warn('Service Worker registration failed:', err);
                });
        });
    }
})();
