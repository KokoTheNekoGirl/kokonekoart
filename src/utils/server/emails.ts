import { CONTACT_PLATFORMS, INQUIRY_OPTIONS, SERVICE_FIELD_DEFS, type ServiceFieldId } from '@data/contact';
import { money } from '../commission-form';
import type { ContactValues } from '../contact-form';
import { escapeHtml, plainRows, rows, wrap } from './mail';

export function contactEmail(v: ContactValues) {
  const platform = CONTACT_PLATFORMS.find((p) => p.id === v.platform)!.label;
  const inquiry = v.inquiry ? INQUIRY_OPTIONS.find((o) => o.id === v.inquiry)?.label : undefined;
  const serviceRows = (Object.keys(SERVICE_FIELD_DEFS) as ServiceFieldId[])
    .filter((f) => v.service[f])
    .map((f): [string, string] => [SERVICE_FIELD_DEFS[f].label, v.service[f]]);
  const items: [string, string][] = [
    ['Platform', platform],
    ['Name', v.name],
    [v.email ? 'Email' : 'Username', v.email || v.username],
    ...(inquiry ? ([['Service', inquiry], ...serviceRows] as [string, string][]) : []),
    ['Subject', v.subject || '(none)'],
    ['Message', v.message],
  ];
  return {
    subject: inquiry
      ? `NEW Service Inquiry: ${inquiry}${v.subject ? ` (${v.subject})` : ''}`
      : `NEW Connection Request${v.subject ? `: ${v.subject}` : ''}`,
    html: wrap(`<h2 style="margin:0 0 12px">New ${inquiry ? 'service inquiry' : 'connection request'}</h2>${rows(items)}`),
    text: plainRows(items),
  };
}

interface Order {
  orderId: string;
  captureId: string;
  paymentStatus: string;
  total: number;
  lines: { group: string; label: string; price: number }[];
  email: string;
  details: string;
  payerEmail?: string;
  files: string[];
  warning?: string;
}

const lineItems = (o: Order): [string, string][] => o.lines.map((l) => [l.group, `${l.label} ($${l.price})`]);

export function commissionAdminEmail(o: Order) {
  const items: [string, string][] = [
    ['Payment', `${o.paymentStatus}, ${money(o.total)}`],
    ['PayPal order', o.orderId],
    ['PayPal capture', o.captureId],
    ['Payer email', o.payerEmail || '(not provided)'],
    ...lineItems(o),
    ['Contact email', o.email],
    ['Request details', o.details || '(none)'],
    ['Reference images', o.files.length ? o.files.join(', ') + ' (attached)' : '(none)'],
  ];
  const warn = o.warning ? `<p style="background:#ffe0e0;padding:8px 12px"><b>Check this order:</b> ${escapeHtml(o.warning)}</p>` : '';
  return {
    subject: `NEW Commission Request - ${o.orderId}`,
    html: wrap(`<h2 style="margin:0 0 12px">New commission request</h2>${warn}${rows(items)}`),
    text: (o.warning ? `CHECK THIS ORDER: ${o.warning}\n\n` : '') + plainRows(items),
  };
}

export function commissionCustomerEmail(o: Order) {
  const items: [string, string][] = [
    ['Order', o.orderId],
    ...lineItems(o),
    ['Total', money(o.total)],
    ['Request details', o.details || '(none)'],
  ];
  const intro =
    'Thank you for commissioning me! I will reach out if I require further information & for progress updates. ' +
    'Your artwork will begin within the next 2 weeks.';
  return {
    subject: 'Thanks for your order!',
    html: wrap(`<p>Hello,</p><p>${escapeHtml(intro)}</p><p>Here are your order details:</p>${rows(items)}`),
    text: `Hello,\n\n${intro}\n\nHere are your order details:\n${plainRows(items)}`,
  };
}
