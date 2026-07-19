// KVS — front-end interactions

// 1) Sticky header shadow + mobile menu
const header = document.getElementById('site-header');
const menuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (header) {
    const onScroll = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('hidden') === false;
        menuBtn.setAttribute('aria-expanded', String(open));
    });
}

// 2) Reveal on scroll
const revealEls = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 }
    );
    revealEls.forEach((el) => io.observe(el));
} else {
    revealEls.forEach((el) => el.classList.add('is-visible'));
}

// 3) Animated counters (Facts & Figures)
const counters = document.querySelectorAll('[data-counter]');
if ('IntersectionObserver' in window && counters.length) {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const io2 = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                const el = e.target;
                const target = parseInt(el.dataset.counter, 10);
                io2.unobserve(el);
                if (reduced) { el.textContent = target; return; }
                const dur = 1200;
                const start = performance.now();
                const tick = (now) => {
                    const p = Math.min((now - start) / dur, 1);
                    el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            });
        },
        { threshold: 0.5 }
    );
    counters.forEach((el) => io2.observe(el));
}
