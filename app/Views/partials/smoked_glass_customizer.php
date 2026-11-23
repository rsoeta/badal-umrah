<?php
/**
 * Calda-Parity Glass Customizer Controls & Popover
 * Renders Theme Switcher (Smoke / Frost) + Adjust Glass Popover (Frost slider + Accent swatches)
 */
?>
<button type="button"
    class="sg-icon-btn"
    data-sg-popover-toggle
    aria-haspopup="dialog"
    aria-expanded="false"
    aria-controls="sgGlassPopover"
    aria-label="Atur tingkat kaca dan warna aksen"
    title="Atur Kaca & Aksen">
    <i class="fa-solid fa-sliders"></i>
    <span class="sg-btn-label d-none d-md-inline">Kaca</span>
</button>

<button type="button"
    class="sg-icon-btn"
    data-sg-theme-toggle
    aria-label="Ganti tema Smoke atau Frost"
    title="Ganti tema Smoke / Frost">
    <i class="fa-solid fa-sun"></i>
    <span class="sg-btn-label d-none d-lg-inline">Frost</span>
</button>

<div id="sgGlassPopover" class="sg-popover" role="dialog" aria-label="Pengaturan Tampilan Kaca" hidden>
    <div class="sg-popover__title">
        <span><i class="fa-solid fa-wand-magic-sparkles me-2 sg-text-sig"></i>Tampilan Smoked Glass</span>
    </div>

    <div class="sg-popover__label">
        <span>Tema Permukaan</span>
        <span data-sg-theme-hint>Otomatis</span>
    </div>
    <div class="sg-segmented sg-segmented--3" role="group" aria-label="Pilih tema permukaan">
        <button type="button" data-sg-theme-option="auto"><i class="fa-solid fa-clock me-1"></i> Auto</button>
        <button type="button" data-sg-theme-option="dark"><i class="fa-solid fa-moon me-1"></i> Smoke</button>
        <button type="button" data-sg-theme-option="light"><i class="fa-solid fa-sun me-1"></i> Frost</button>
    </div>

    <label class="sg-popover__label" for="sgFrostSlider">
        <span>Ketebalan Frost</span>
        <span data-sg-frost-value>50%</span>
    </label>
    <input id="sgFrostSlider" class="sg-range" type="range" min="0" max="100" value="50" data-sg-frost-slider>

    <div class="sg-popover__label"><span>Warna Aksen</span></div>
    <div class="sg-swatches" role="group" aria-label="Pilih warna aksen">
        <button type="button" class="sg-swatch" data-sg-swatch="gold" style="background: #dfb86c;" title="Gold" aria-label="Aksen Gold"></button>
        <button type="button" class="sg-swatch" data-sg-swatch="sky" style="background: #29a1f7;" title="Sky (Calda)" aria-label="Aksen Sky"></button>
        <button type="button" class="sg-swatch" data-sg-swatch="emerald" style="background: #34d399;" title="Emerald" aria-label="Aksen Emerald"></button>
        <button type="button" class="sg-swatch" data-sg-swatch="teal" style="background: #2dd4bf;" title="Teal" aria-label="Aksen Teal"></button>
        <button type="button" class="sg-swatch" data-sg-swatch="amber" style="background: #fbbf24;" title="Amber" aria-label="Aksen Amber"></button>
        <button type="button" class="sg-swatch" data-sg-swatch="rose" style="background: #fb7185;" title="Rose" aria-label="Aksen Rose"></button>
    </div>
</div>
