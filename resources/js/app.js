import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ============================================================
// Dark Mode Toggle
// ============================================================
Alpine.store('theme', {
    dark: localStorage.getItem('theme') === 'dark' ||
         (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    init() {
        this.apply();
        this.$watch('dark', () => this.apply());
    },

    toggle() {
        this.dark = !this.dark;
    },

    apply() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }
});

// ============================================================
// Navbar scroll effect
// ============================================================
Alpine.data('navbar', () => ({
    scrolled: false,
    mobileOpen: false,

    init() {
        this.onScroll = () => {
            this.scrolled = window.scrollY > 20;
        };
        window.addEventListener('scroll', this.onScroll, { passive: true });
        this.scrolled = window.scrollY > 20;
    },

    destroy() {
        window.removeEventListener('scroll', this.onScroll);
    }
}));

// ============================================================
// Mobile menu drawer
// ============================================================
Alpine.data('mobileMenu', () => ({
    open: false,

    toggle() {
        this.open = !this.open;
        document.body.style.overflow = this.open ? 'hidden' : '';
    },

    close() {
        this.open = false;
        document.body.style.overflow = '';
    }
}));

Alpine.start();
