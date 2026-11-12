// Reading behaviour on a portfolio piece (the slide presentation), anonymous and label-only:
// which piece, how long it was actually read, which slide they got to / ended on, and whether
// they jumped to the end or started over. Nothing about the visitor is sent.
//
// Events (all carry `piece`):
//   portfolio-skip-to-end  they pressed "View final results" instead of paging through
//   portfolio-restart      they went back to the start from the final slide
//   portfolio-piece-read   ONE summary when they leave or switch tabs:
//       seconds / time   active reading time (idle gaps over 60s and hidden tabs don't count)
//       furthest, last   the furthest slide reached and the slide they ended on (1-based)
//       of               how many slides the piece has
//       viewed           how many different slides they saw
//       reached_end      they saw the final slide
//       skipped_to_end   they used the skip button
//       restarts         how many times they started over
//       entered_at_end   they arrived on the final slide through a link
//       from             the page they came from (/portfolio, /, a category page, or external/direct)
//       dwell            seconds spent on each slide, in order, e.g. "12,30,5,8"
import { track } from './track';

const IDLE_MS = 60_000;
const bucket = (s: number) => (s < 10 ? 'under 10s' : s < 30 ? '10-30s' : s < 60 ? '30-60s' : s < 120 ? '1-2 min' : s < 300 ? '2-5 min' : '5+ min');

const cameFrom = () => {
  try {
    if (!document.referrer) return 'direct';
    const r = new URL(document.referrer);
    return r.origin === location.origin ? r.pathname.replace(/\/+$/, '') || '/' : 'external';
  } catch {
    return 'direct';
  }
};

export function trackPresentation(opts: { piece: string; total: number; start: number; enteredAtEnd?: boolean }) {
  const { piece, total } = opts;
  const dwell = new Array<number>(total).fill(0);
  const viewed = new Set<number>([opts.start]);
  let current = opts.start;
  let active = 0;
  let lastAct = Date.now();
  let skipped = false;
  let restarts = 0;
  let sent = false;

  const act = () => (lastAct = Date.now());
  ['pointerdown', 'keydown', 'touchstart', 'scroll', 'mousemove'].forEach((t) => addEventListener(t, act, { passive: true }));

  // Once a second: count it only when the tab is visible and the person did something in the last minute.
  setInterval(() => {
    if (sent || document.visibilityState !== 'visible' || Date.now() - lastAct > IDLE_MS) return;
    active += 1000;
    dwell[current] += 1000;
  }, 1000);

  const send = () => {
    if (sent || active === 0) return;
    sent = true;
    const seconds = Math.round(active / 1000);
    const furthest = Math.max(...viewed) + 1;
    track('portfolio-piece-read', {
      piece,
      seconds,
      time: bucket(seconds),
      furthest,
      last: current + 1,
      of: total,
      viewed: viewed.size,
      reached_end: viewed.has(total - 1),
      skipped_to_end: skipped,
      restarts,
      entered_at_end: !!opts.enteredAtEnd,
      from: cameFrom(),
      dwell: dwell.map((ms) => Math.round(ms / 1000)).join(','),
    });
  };
  addEventListener('pagehide', send);
  document.addEventListener('visibilitychange', () => document.visibilityState === 'hidden' && send());

  return {
    /** Call whenever the active slide changes. */
    slide(index: number) {
      current = index;
      viewed.add(index);
      act();
    },
    skippedToEnd() {
      skipped = true;
      track('portfolio-skip-to-end', { piece, from_slide: current + 1, of: total });
    },
    restarted() {
      restarts++;
      track('portfolio-restart', { piece, from_slide: current + 1, of: total });
    },
  };
}
