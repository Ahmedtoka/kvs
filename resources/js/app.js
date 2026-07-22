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


// 4) First-party analytics — send behaviour events to /track
(function () {
    var meta = document.querySelector('meta[name="csrf-token"]');
    var csrf = meta ? meta.content : '';
    var page = window.location.pathname || '/';

    function track(event, label) {
        var body = JSON.stringify({ event: event, page: page, label: label || null });
        try {
            if (navigator.sendBeacon) {
                navigator.sendBeacon('/track', new Blob([body], { type: 'application/json' }));
            } else {
                fetch('/track', {
                    method: 'POST', keepalive: true,
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: body,
                });
            }
        } catch (e) { /* tracking must never break the page */ }
    }

    // CTA buttons explicitly tagged with data-track
    document.querySelectorAll('[data-track]').forEach(function (el) {
        el.addEventListener('click', function () { track('cta_click', el.getAttribute('data-track')); });
    });

    // WhatsApp + phone taps
    document.querySelectorAll('a[href^="https://wa.me"], a[href^="tel:"]').forEach(function (el) {
        el.addEventListener('click', function () {
            var isCall = el.getAttribute('href').indexOf('tel:') === 0;
            var label = el.getAttribute('data-label') || el.getAttribute('href');
            track(isCall ? 'call_click' : 'whatsapp_click', label);
        });
    });

    // Header navigation usage
    document.querySelectorAll('#site-header a[href^="/"]').forEach(function (el) {
        if (el.hasAttribute('data-track')) return; // counted as cta_click instead
        el.addEventListener('click', function () { track('nav_click', el.getAttribute('href')); });
    });

    // Lead form scrolled into view (funnel step)
    var form = document.querySelector('form[action*="/leads"], #lead-form');
    if (form && 'IntersectionObserver' in window) {
        var seen = false;
        var fo = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) { if (e.isIntersecting && !seen) { seen = true; track('form_view'); fo.disconnect(); } });
        }, { threshold: 0.4 });
        fo.observe(form);
        form.addEventListener('submit', function () { track('form_submit'); });
    }

    // Reached 75% of the page
    var deep = false;
    window.addEventListener('scroll', function () {
        if (deep) return;
        var h = document.documentElement;
        if ((h.scrollTop + window.innerHeight) / h.scrollHeight >= 0.75) { deep = true; track('scroll_75'); }
    }, { passive: true });
})();
