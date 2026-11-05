// Single source for commission pricing, option rules and request URLs.
// The calculator on /commission-me/ and (later) the request form both read from here,
// Price or option only ever changes in this file.

export const CURRENCY = 'CAD';
export const PAYPAL_ME = 'https://paypal.me/kokonekoart';
export const KOFI_URL = 'https://ko-fi.com/kokonekogirl';
export const REQUEST_PATH = '/commission-me/request';

export type ShotId = 'hs' | 'hb' | 'fb' | 'chibi';
export type StyleId = 'sketch' | 'line' | 'flat' | 'shaded';
export type BgId = 'trans' | 'color' | 'pattern' | 'scene';
export type AddOnId = 'complex' | 'add_char' | 'ref';

export interface Option<Id extends string = string> {
  id: Id;
  label: string;
  price: number;
}

export const SHOTS: readonly Option<ShotId>[] = [
  { id: 'hs', label: 'Headshot', price: 6 },
  { id: 'hb', label: 'Halfbody', price: 9 },
  { id: 'fb', label: 'Fullbody', price: 11 },
  { id: 'chibi', label: 'Chibi', price: 9 },
];

/** `color: true` finishes unlock the Pattern and Scene backgrounds. */
export const STYLES: readonly (Option<StyleId> & { color: boolean })[] = [
  { id: 'sketch', label: 'Sketch', price: 3, color: false },
  { id: 'line', label: 'Lineart', price: 6, color: false },
  { id: 'flat', label: 'Flatcolor', price: 12, color: true },
  { id: 'shaded', label: 'Shaded', price: 18, color: true },
];

/** `needsColor: true` backgrounds are locked unless the finish is colored (or a Ref Sheet is chosen). */
export const BACKGROUNDS: readonly (Option<BgId> & { needsColor: boolean })[] = [
  { id: 'trans', label: 'Transparent', price: 3, needsColor: false },
  { id: 'color', label: 'Color', price: 3, needsColor: false },
  { id: 'pattern', label: 'Pattern', price: 6, needsColor: true },
  { id: 'scene', label: 'Scene', price: 9, needsColor: true },
];

export const ADD_ONS: readonly (Option<AddOnId> & { info?: string })[] = [
  { id: 'complex', label: 'Complex Design', price: 12 },
  { id: 'add_char', label: 'Extra Character/Shot', price: 12 },
  {
    id: 'ref',
    label: 'Ref Sheet/Custom',
    price: 28,
    info:
      'Refsheet includes two flat color full-body shots and one head-shot with a color palette & character info. ' +
      'Additional art information is included, such as accessories, pawpaws, tongue/blood color, etc.',
  },
];

/** A Ref Sheet replaces the character shot + art finish (and unlocks every background). */
export const REF_SHEET: AddOnId = 'ref';

export interface Selection {
  shot: ShotId;
  style: StyleId;
  bg: BgId;
  addOns: AddOnId[];
}

export const DEFAULT_SELECTION: Selection = { shot: 'hs', style: 'sketch', bg: 'trans', addOns: [] };

const byId = <Id extends string, T extends { id: Id }>(list: readonly T[], id: Id): T =>
  list.find((o) => o.id === id) as T;

const hasId = <Id extends string>(list: readonly { id: Id }[], value: unknown): value is Id =>
  list.some((o) => o.id === value);

/**
 * Makes any selection valid: drops unknown ids, orders add-ons, and falls back to a
 * transparent background when Pattern/Scene is picked without a colored finish.
 */
export function normalize(input: Selection): Selection {
  const shot = hasId(SHOTS, input.shot) ? input.shot : DEFAULT_SELECTION.shot;
  const style = hasId(STYLES, input.style) ? input.style : DEFAULT_SELECTION.style;
  let bg = hasId(BACKGROUNDS, input.bg) ? input.bg : DEFAULT_SELECTION.bg;
  const addOns = ADD_ONS.map((a) => a.id).filter((id) => input.addOns.includes(id));

  const colorOk = addOns.includes(REF_SHEET) || byId(STYLES, style).color;
  if (byId(BACKGROUNDS, bg).needsColor && !colorOk) bg = DEFAULT_SELECTION.bg;

  return { shot, style, bg, addOns };
}

export interface PriceLine {
  group: 'Character Shot' | 'Art Finish' | 'Background' | 'Add-on';
  id: string;
  label: string;
  price: number;
}

export function resolve(input: Selection) {
  const selection = normalize(input);
  const refSheet = selection.addOns.includes(REF_SHEET);
  const style = byId(STYLES, selection.style);
  const shot = byId(SHOTS, selection.shot);
  const bg = byId(BACKGROUNDS, selection.bg);
  const colorOk = refSheet || style.color;

  const lines: PriceLine[] = [];
  if (!refSheet) {
    lines.push({ group: 'Character Shot', id: shot.id, label: shot.label, price: shot.price });
    lines.push({ group: 'Art Finish', id: style.id, label: style.label, price: style.price });
  }
  lines.push({ group: 'Background', id: bg.id, label: bg.label, price: bg.price });
  for (const id of selection.addOns) {
    const a = byId(ADD_ONS, id);
    lines.push({ group: 'Add-on', id: a.id, label: a.label, price: a.price });
  }

  const total = lines.reduce((sum, l) => sum + l.price, 0);

  return {
    selection,
    refSheet,
    lines,
    total,
    /** Backgrounds that can't be chosen right now. */
    lockedBackgrounds: BACKGROUNDS.filter((b) => b.needsColor && !colorOk).map((b) => b.id),
    /** Values for #art-sample[data-char-shot][data-art-style] and .art-bg[data-bg]. */
    preview: {
      shot: refSheet ? REF_SHEET : selection.shot,
      style: refSheet ? '' : selection.style,
      bg: selection.bg,
    },
    /** Plain-text description for screen readers, e.g. "Headshot, Sketch, Transparent background". */
    summary: lines.map((l) => (l.group === 'Background' ? `${l.label} background` : l.label)).join(', '),
    requestUrl: buildRequestUrl(selection),
    paypalUrl: `${PAYPAL_ME}/${total}`,
  };
}

/**
 * Link to the request form, e.g.
 *   /commission-me/request?char-shots=hs&art-style=sketch&bg=trans&add-ons=complex,add_char
 *   /commission-me/request?char-shots=ref&bg=trans            (Ref Sheet: no art-style)
 */
export function buildRequestUrl(input: Selection, base: string = REQUEST_PATH): string {
  const s = normalize(input);
  const ref = s.addOns.includes(REF_SHEET);
  const params = new URLSearchParams();
  params.set('char-shots', ref ? REF_SHEET : s.shot);
  if (!ref) params.set('art-style', s.style);
  params.set('bg', s.bg);
  const others = s.addOns.filter((id) => id !== REF_SHEET);
  if (others.length) params.set('add-ons', others.join(','));
  // Keep the comma readable instead of %2C.
  return `${base}?${params.toString().replace(/%2C/g, ',')}`;
}

/** Reads a request URL's query back into a valid Selection (for the request form). */
export function parseSelection(params: URLSearchParams): Selection {
  const pick = <Id extends string>(list: readonly { id: Id }[], value: string | null, fallback: Id): Id =>
    hasId(list, value) ? value : fallback;

  const rawShot = params.get('char-shots');
  const addOns = (params.get('add-ons') ?? '')
    .split(',')
    .map((s) => s.trim())
    .filter((s): s is AddOnId => hasId(ADD_ONS, s));
  if (rawShot === REF_SHEET && !addOns.includes(REF_SHEET)) addOns.push(REF_SHEET);

  return normalize({
    shot: pick(SHOTS, rawShot, DEFAULT_SELECTION.shot),
    style: pick(STYLES, params.get('art-style'), DEFAULT_SELECTION.style),
    bg: pick(BACKGROUNDS, params.get('bg'), DEFAULT_SELECTION.bg),
    addOns,
  });
}
