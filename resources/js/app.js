import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// ── Alpine Plugins ──
Alpine.plugin(persist);

// ── Theme Store ──
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        // Default to light mode (false = light, true = dark)
        dark: Alpine.$persist(false).as('cekdulu-theme'),

        init() {
            // Force light mode as default if no preference is stored
            // User must explicitly toggle to dark mode
            if (this.dark === null || this.dark === undefined) {
                this.dark = false;
            }
        },

        toggle() {
            this.dark = !this.dark;
        },
    });
});

// ── Navbar scroll store ──
Alpine.data('navbar', () => ({
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 10;
        }, { passive: true });
    },
}));

// ── Bootstrap Alpine ──
window.Alpine = Alpine;
Alpine.start();
