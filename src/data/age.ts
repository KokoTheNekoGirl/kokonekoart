// Kept separate from about.ts on purpose: the browser script imports getAge from here,
// and about.ts pulls in astro:assets and image files that must stay out of the client bundle.

export const BIRTHDAY = '2001-08-13'; // YYYY-MM-DD

export function parseBirthday() {
  const [year, month, day] = BIRTHDAY.split('-').map(Number);
  return { year, month, day };
}

/** Age in whole years; increments on the birthday itself. */
export function getAge(today: Date = new Date()): number {
  const { year, month, day } = parseBirthday();
  const m = today.getMonth() + 1;
  const had = m > month || (m === month && today.getDate() >= day);
  return today.getFullYear() - year - (had ? 0 : 1);
}