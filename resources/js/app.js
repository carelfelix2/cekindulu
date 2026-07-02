import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// ── Alpine Plugins ──
Alpine.plugin(persist);

// ── Theme Store ──
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        dark: Alpine.$persist(false).as('cekdulu-theme'),

        init() {
            if (this.dark === undefined) {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    this.dark = true;
                }
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
