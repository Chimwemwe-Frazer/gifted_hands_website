import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('countUp', (target, suffix = '') => ({
    current: 0,
    target,
    suffix,
    started: false,
    init() {
        const observer = new IntersectionObserver((entries) => {
            if (! entries[0].isIntersecting || this.started) {
                return;
            }

            this.started = true;
            observer.disconnect();
            this.animate();
        }, { threshold: 0.35 });

        observer.observe(this.$el);
    },
    animate() {
        const duration = 1400;
        const start = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);

            this.current = Math.round(this.target * eased);

            if (progress < 1) {
                requestAnimationFrame(tick);
            }
        };

        requestAnimationFrame(tick);
    },
    get value() {
        return `${this.current.toLocaleString()}${this.suffix}`;
    },
}));

Alpine.start();
