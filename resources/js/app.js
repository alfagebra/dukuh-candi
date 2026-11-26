// ===== Menu navigasi di layar kecil (HP) =====
const toggle = document.getElementById('nav-toggle');
const menu = document.getElementById('mobile-menu');

if (toggle && menu) {
    toggle.addEventListener('click', () => {
        const isHidden = menu.classList.toggle('hidden');
        const isOpen = !isHidden;

        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
    });
}

// ===== Lightbox foto =====
// Tautan dengan atribut data-lightbox="nama-grup" membuka foto di jendela besar.
const dialog = document.getElementById('lightbox');

if (dialog) {
    const image = dialog.querySelector('[data-lightbox-image]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    const counter = dialog.querySelector('[data-lightbox-counter]');
    const prev = dialog.querySelector('[data-lightbox-prev]');
    const next = dialog.querySelector('[data-lightbox-next]');

    let items = [];
    let index = 0;

    const show = (i) => {
        index = (i + items.length) % items.length;
        const el = items[index];
        const text = el.dataset.caption || '';

        image.src = el.href;
        image.alt = text;
        caption.textContent = text;
        counter.textContent = items.length > 1 ? `${index + 1} / ${items.length}` : '';
    };

    document.querySelectorAll('[data-lightbox]').forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const group = link.dataset.lightbox;
            items = Array.from(document.querySelectorAll('[data-lightbox]'))
                .filter((el) => el.dataset.lightbox === group);

            prev.classList.toggle('hidden', items.length < 2);
            next.classList.toggle('hidden', items.length < 2);

            show(items.indexOf(link));
            dialog.showModal();
        });
    });

    prev.addEventListener('click', () => show(index - 1));
    next.addEventListener('click', () => show(index + 1));
    dialog.querySelector('[data-lightbox-close]').addEventListener('click', () => dialog.close());

    // Klik area gelap di luar foto menutup jendela.
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    dialog.addEventListener('keydown', (event) => {
        if (items.length < 2) return;
        if (event.key === 'ArrowLeft') show(index - 1);
        if (event.key === 'ArrowRight') show(index + 1);
    });

    dialog.addEventListener('close', () => image.removeAttribute('src'));
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const all = Array.from(
        document.querySelectorAll('[data-reveal], main h2, main .grid > *')
    );

    const targets = all.filter(
        (el) => !all.some((other) => other !== el && other.contains(el))
    );

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach((el) => {
        if (el.getBoundingClientRect().top < window.innerHeight * 0.85) {
            return;
        }

        const index = Array.from(el.parentElement.children).indexOf(el);
        el.style.setProperty('--reveal-delay', `${(index % 4) * 80}ms`);
        el.classList.add('reveal');
        observer.observe(el);
    });
});