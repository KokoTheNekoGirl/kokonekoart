// Single source for the contact form: the platform list, the length limits and the service
// inquiry fields. The form markup, the browser validation and the API route all read from here.
import { SERVICES, type ServiceId } from './services';

export const CONTACT_PLATFORMS = [
  { id: 'discord', label: 'Discord' },
  { id: 'email', label: 'Email' },
  { id: 'bluesky', label: 'Bluesky' },
  { id: 'cara', label: 'Cara' },
  { id: 'facebook', label: 'Facebook' },
  { id: 'instagram', label: 'Instagram' },
] as const;

export type PlatformId = (typeof CONTACT_PLATFORMS)[number]['id'];

/** Choosing this platform shows the Email field instead of Username. */
export const EMAIL_PLATFORM: PlatformId = 'email';

export const CONTACT_LIMITS = {
  name: 80,
  username: 80,
  email: 254,
  subject: 120,
  message: 200,
} as const;

/** What the message is about: any service from the Services page, or "not sure". Blank means a general message. */
export type InquiryId = ServiceId | 'not-sure';

export const INQUIRY_OPTIONS: readonly { id: InquiryId; label: string }[] = [
  ...SERVICES.map((s) => ({ id: s.id, label: s.title })),
  { id: 'not-sure', label: 'I’m not sure yet' },
];

/** Choices for the "platform" dropdowns in a service inquiry. */
export const SITE_PLATFORMS = [
  'WordPress',
  'WooCommerce',
  'Shopify',
  'Squarespace',
  'Wix',
  'Carrd',
  'Toyhouse',
  'Custom code / React',
  'Discord',
  'Other / not sure',
] as const;

export type ServiceFieldId = 'site_url' | 'site_platform' | 'new_platform' | 'timeline';

/** The extra questions a service inquiry can ask. Names double as the form control names and error keys. */
export const SERVICE_FIELD_DEFS: Record<
  ServiceFieldId,
  { label: string; type: 'text' | 'select'; max?: number; hint?: string; missing: string }
> = {
  site_url: {
    label: 'Website/Domain',
    type: 'text',
    max: 200,
    hint: 'For example kokoneko.art',
    missing: `I need your website URL or a domain you want to use.`,
  },
  site_platform: { label: 'Current platform', type: 'select', missing: 'Please choose your current platform.' },
  new_platform: { label: 'New platform', type: 'select', missing: 'Please choose the platform you want to move to.' },
  timeline: {
    label: 'Ideal timeline',
    type: 'text',
    max: 80,
    hint: 'A date or a rough idea, like “within 2 months”.',
    missing: 'Please tell me your ideal timeline.',
  },
};

/** Which extra questions each inquiry type shows, and whether they are required. */
export const SERVICE_FIELDS: Record<InquiryId, Partial<Record<ServiceFieldId, 'required' | 'optional'>>> = {
  maintenance: { site_url: 'required', site_platform: 'required' },
  audit: { site_url: 'required', timeline: 'optional' },
  redesign: { site_url: 'required', site_platform: 'required', timeline: 'optional' },
  rebuild: { site_url: 'required', site_platform: 'required', new_platform: 'required', timeline: 'optional' },
  overhaul: { site_url: 'required', site_platform: 'required', timeline: 'optional' },
  custom: { site_url: 'optional', site_platform: 'optional', timeline: 'optional' },
  'not-sure': { site_url: 'optional' },
};
