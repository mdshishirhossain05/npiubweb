import './bootstrap';
import Alpine from 'alpinejs';

// Count-up component: <span x-data="counter(2000)" x-text="value"></span>
Alpine.data('counter', (target = 0) => ({
    value: 0,
    started: false,
    init() {
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) {
            this.value = target;
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !this.started) {
                    this.started = true;
                    this.run(target);
                    io.disconnect();
                }
            });
        }, { threshold: 0.4 });
        io.observe(this.$el);
    },
    run(t) {
        const duration = 1400;
        const start = performance.now();
        const tick = (now) => {
            const p = Math.min((now - start) / duration, 1);
            // easeOutCubic
            const eased = 1 - Math.pow(1 - p, 3);
            this.value = Math.floor(eased * t);
            if (p < 1) {
                requestAnimationFrame(tick);
            } else {
                this.value = t;
            }
        };
        requestAnimationFrame(tick);
    },
}));

window.Alpine = Alpine;
Alpine.start();

// Scroll-reveal: elements marked [data-reveal] fade/rise in when scrolled into view.
document.addEventListener('DOMContentLoaded', () => {
    const els = document.querySelectorAll('[data-reveal]');
    if (! els.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        els.forEach((el) => el.classList.add('is-revealed'));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    els.forEach((el) => io.observe(el));
});

// Self-hosted webfonts, bundled by Vite (no external CDN — better privacy and
// speed on slower connections). English: Inter. Bangla: Hind Siliguri.
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';
// Modern geometric grotesk for display headings (Swiss/minimal character).
import '@fontsource/space-grotesk/500.css';
import '@fontsource/space-grotesk/600.css';
import '@fontsource/space-grotesk/700.css';
import '@fontsource/hind-siliguri/400.css';
import '@fontsource/hind-siliguri/500.css';
import '@fontsource/hind-siliguri/600.css';
import '@fontsource/hind-siliguri/700.css';
