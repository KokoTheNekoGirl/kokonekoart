// Click tracking for the whole site, with no per-link markup needed.
// Loaded once from the layout. Sends labels only (page, platform, piece slug), never visitor data.
import { track } from './track';

const here = () => location.pathname;

document.addEventListener('click', (e) => {
  const a = (e.target as Element | null)?.closest<HTMLAnchorElement>('a[href]');
  if (!a) return;

  let url: URL;
  try {
    url = new URL(a.href, location.href);
  } catch {
    return;
  }
  const from = here();

  // Social icons (the icon rows on the home, about and contact pages)
  if (a.closest('.icon-group') && url.origin !== location.origin) {
    track('social-click', { platform: (a.getAttribute('aria-label') ?? url.hostname).replace(/ profile$/, ''), from });
    return;
  }

  // Other links that leave the site: the "View code / live / design" buttons, Ko-fi, etc.
  if (url.origin !== location.origin) {
    track('outbound-click', { host: url.hostname, from });
    return;
  }

  const path = url.pathname.replace(/\/+$/, '');

  if (path.startsWith('/commission-me/request')) return track('commission-request-click', { from });
  if (path === '/commission-me') return track('commission-prices-click', { from });
  if (path === '/portfolio') return track('portfolio-click', { from });
  if (path.startsWith('/portfolio/project/')) return track('portfolio-category-click', { category: path.split('/').pop() ?? '', from });
  if (path.startsWith('/portfolio/')) {
    // Which piece, from which page, and what they pressed (image / title / read-more / carousel).
    const card = a.closest<HTMLElement>('[data-piece]');
    const via = a.closest('.portfolio-preview-swiper') ? 'carousel' : a.closest('.featured-image') ? 'image' : a.closest('.mini-box') ? 'read-more' : 'link';
    return track('portfolio-piece-click', {
      piece: path.split('/').pop() ?? '',
      from,
      via,
      ...(card?.dataset.position ? { position: Number(card.dataset.position) } : {}),
    });
  }
  if (path === '/about-me') return track('about-click', { from });
  if (path === '/contact') return track('contact-click', { from });
});

// Portfolio lists (/portfolio and the category pages): which entries people scroll to.
// An entry counts as seen once it has been mostly on screen for a second, so flicking past
// doesn't count. One event per entry per visit.
const cards = document.querySelectorAll<HTMLElement>('.portfolio-piece[data-piece]');
if (cards.length) {
  const seenPieces = new Set<string>();
  const timers = new Map<Element, ReturnType<typeof setTimeout>>();
  const watch = new IntersectionObserver(
    (entries) =>
      entries.forEach((en) => {
        const card = en.target as HTMLElement;
        const piece = card.dataset.piece ?? '';
        if (!en.isIntersecting) {
          clearTimeout(timers.get(card));
          timers.delete(card);
          return;
        }
        if (seenPieces.has(piece) || timers.has(card)) return;
        timers.set(
          card,
          setTimeout(() => {
            seenPieces.add(piece);
            watch.unobserve(card);
            timers.delete(card);
            track('portfolio-piece-seen', {
              piece,
              position: Number(card.dataset.position ?? 0),
              of: Number(card.dataset.total ?? 0),
              from: here(),
            });
          }, 1000),
        );
      }),
    { threshold: 0.6 },
  );
  cards.forEach((c) => watch.observe(c));
}

// Home page scroll depth: which sections actually get seen, once each.
if (location.pathname === '/') {
  const seen = new Set<string>();
  const io = new IntersectionObserver(
    (entries) =>
      entries.forEach((en) => {
        if (!en.isIntersecting) return;
        const name = [...en.target.classList].find((c) => c.endsWith('-section'))?.replace('-section', '') ?? 'unknown';
        if (!seen.has(name)) {
          seen.add(name);
          track('home-section-seen', { section: name });
        }
        io.unobserve(en.target);
      }),
    { threshold: 0.4 },
  );
  document.querySelectorAll('.hero-section, .about-section, .commissions-section, .portfolio-section, .contact-section').forEach((s) => io.observe(s));
}
