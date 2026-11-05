import { execFileSync } from 'node:child_process';
import { statSync } from 'node:fs';

function git(args: string[]): string | null {
  try {
    return execFileSync('git', args, { encoding: 'utf8', stdio: ['ignore', 'pipe', 'ignore'] }).trim();
  } catch {
    return null; // git missing, or not a repository
  }
}

/**
 * When a file last changed:
 * - committed and unmodified -> date of the last commit that touched it (what production builds use)
 * - edited but not committed, untracked, or no git -> the file's modified time (so `astro dev` shows "now")
 * `file` is a path relative to the project root, e.g. entry.filePath from a content collection.
 */
export function lastModified(file: string): Date {
  if (git(['status', '--porcelain', '--', file]) === '') {
    const iso = git(['log', '-1', '--format=%cI', '--', file]);
    if (iso) return new Date(iso);
  }
  return statSync(file).mtime;
}

const TIME_ZONE = 'America/Winnipeg'; // build servers run in UTC; this keeps the date your local day

/** DD MONTH, YYYY Pass timeZone 'UTC' for date-only values written by hand (they parse as UTC midnight). */
export function formatDate(date: Date, timeZone: string = TIME_ZONE): string {
  const parts = Object.fromEntries(
    new Intl.DateTimeFormat('en-CA', { day: 'numeric', month: 'long', year: 'numeric', timeZone })
      .formatToParts(date)
      .map((p) => [p.type, p.value]),
  );
  return `${parts.day} ${parts.month}, ${parts.year}`;
}

/** YYYY-MM-DD for <time datetime> and JSON-LD */
export function isoDate(date: Date, timeZone: string = TIME_ZONE): string {
  return new Intl.DateTimeFormat('en-CA', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    timeZone,
  }).format(date);
}
