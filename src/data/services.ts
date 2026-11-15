// Single source for freelance services and their FAQ.
// The /services page (cards, FAQ, structured data) reads everything from here, so a price,
// hour range or answer only ever changes in this file. A future service request form can
// import SERVICES for its dropdown too.

import type { ImageMetadata } from 'astro';
import { Audit, Custom, Maintenance, Migration, Overhaul, Redesign } from '@services';

export const CURRENCY = 'CAD';

export type ServiceId = 'maintenance' | 'audit' | 'redesign' | 'rebuild' | 'overhaul' | 'custom';

export interface Service {
  id: ServiceId;
  title: string;
  summary: string;
  includes: string;
  image: ImageMetadata;
  imageAlt: string;
  hours: string;
  price: { min: number; max?: number; per?: 'month' | 'hour' };
}

export const SERVICES: readonly Service[] = [
  {
    id: 'maintenance',
    title: 'Monthly Website Maintenance',
    summary:
      'Let me handle your website so you can focus on other things.',
    includes:
      'Core and security updates, backups, uptime and performance monitoring, content changes and small fixes (1 hour per month).',
    image: Maintenance,
    imageAlt: 'KokoNekoArt: Monthly maintenance for your website, over a WordPress dashboard.',
    hours: '1 hour / month',
    price: { min: 30, max: 60, per: 'month' },
  },
  {
    id: 'audit',
    title: 'Website Audit',
    summary:
      'Get a full report to see where your site can improve.',
    includes:
      'A complete audit testing performance and speed, accessibility, mobile responsiveness, SEO, user and customer experience, broken links and best practices, tailored to your business needs. Findings are sorted into critical fixes, medium tweaks and low-priority nice-to-haves. Starts with one meeting to understand what you want to uncover.',
    image: Audit,
    imageAlt: 'KokoNekoArt: Find out where your website can improve, over a website audit report.',
    hours: '8 – 16 hours',
    price: { min: 200, max: 400 },
  },
  {
    id: 'redesign',
    title: 'Website Redesign',
    summary:
      'A fresh new design for your website without changing your platform.',
    includes:
      'A redesign that keeps your existing back-end (Wix, Squarespace, WordPress or Shopify) while redoing layouts, themes, templates, brand and website UI. Discovery meeting, moodboard, rough wireframes, design mockups, then a custom HTML/CSS front-end rebuild on your existing platform, taken from development to live where applicable.',
    image: Redesign,
    imageAlt: 'KokoNekoArt: Give your website a new look, over a website page mockup.',
    hours: '24 – 40 hours',
    price: { min: 600, max: 1000 },
  },
  {
    id: 'rebuild',
    title: 'Website Rebuild or Migration',
    summary:
      'Your current platform not working for you? I can help migrate you to a new one!',
    includes:
      'A move to a different platform while keeping the same look (for example Shopify to WordPress, or Squarespace to Wix): recreating the current design, restructuring data, URLs and redirects, and testing. Discovery meeting, a staging or development site, feedback and revisions, then pushing changes live.',
    image: Migration,
    imageAlt: 'KokoNekoArt: Move your website to a new platform, like from Squarespace to WordPress.',
    hours: '30 – 50 hours',
    price: { min: 750, max: 1250 },
  },
  {
    id: 'overhaul',
    title: 'Complete Website Overhaul',
    summary:
      'A full site reset. From site audit, redesign, rebuild or migration, to launch in one project.',
    includes:
      'Everything in the redesign and rebuild services plus a site audit. Full discovery, site audit, wireframes and mockups, then a custom redesign, platform migration and custom front-end development.',
    image: Overhaul,
    imageAlt: 'KokoNekoArt: Complete website rebuild, from an old site layout to a new redesigned one.',
    hours: '50 – 90 hours',
    price: { min: 1250, max: 2250 },
  },
  {
    id: 'custom',
    title: 'Custom Web Service',
    summary:
      `Can be just about anything, as long as it's made from scratch!`,
    includes:
      'Custom functionality for WordPress, WooCommerce, Shopify, React, Discord, Carrd or Toyhouse: new page templates and layouts, plugin or add-on installs, single page redesigns, blog implementation, custom apps and sites, Discord bots and simple CSS templating. Hours vary, contact for scope.',
    image: Custom,
    imageAlt: 'KokoNekoArt: Custom web or app deployment, with the React and Discord logos.',
    hours: 'Hours vary · contact for scope',
    price: { min: 25, per: 'hour' },
  },
];

const money = (n: number) => `$${n.toLocaleString('en-CA')}`;

export function priceParts({ min, max, per }: Service['price']): { amount: string; unit: string } {
  return {
    amount: max ? `${money(min)}–${money(max)}` : money(min),
    unit: `${CURRENCY}${per ? ` / ${per}` : ''}`,
  };
}

export interface Faq {
  id: string;
  question: string;
  answer: string;
}

export const FAQS: readonly Faq[] = [
  {
    id: 'quote-includes',
    question: 'What does the quote include?',
    answer:
      'Your quote includes the agreed scope and reasonable minor revisions. I’ll check in before 80% of the planned time is used if new requirements, additions or feedback may affect the timeline or budget. Non-profits can [contact me](/contact) for a reduced rate.',
  },
  {
    id: 'estimate',
    question: 'Will I get an estimate before you start?',
    answer:
      'Yes. I’ll review the requirements of your request, your current setup and any technical constraints, then provide a scoped estimate before development begins',
  },
  {
    id: 'payments',
    question: 'How do payments work?',
    answer:
      'A 30% deposit on the quote is required to start, and the remainder is paid when the project is complete. Your site launches once final payment is received. I invoice through PayPal. Non-profits and trusted clients can arrange other options, such as a reduced rate or an e-transfer in Canada.',
  },
  {
    id: 'timeline',
    question: 'How long will my project take?',
    answer:
      'I work 8 – 10 hours a day, Monday to Saturday, availability permitting. Expect a turnaround within 1 – 2 months.',
  },
  {
    id: 'ownership',
    question: 'Do I own the finished work and code?',
    answer:
      'You receive a license to use the finished designs, assets and code commercially for your business once final payment is received, and credit is not required. I keep the copyright. Your own content, logos and brand materials always remain yours. See my [TOS](/services/tos) for the full details.',
  },
  {
    id: 'custom-work',
    question: 'What kinds of custom work can you build?',
    answer:
      'I can custom code in HTML, CSS, JavaScript, TypeScript, React, Liquid or PHP, or build on WordPress, WooCommerce, Shopify, Squarespace, Wix, Carrd, Toyhouse or Discord bot development.',
  },
  {
    id: 'hosting',
    question: 'Do you provide web or bot hosting, or domain management?',
    answer:
      'Yes. Annual hosting and management is custom priced and includes website maintenance, and monthly maintenance is also available with a default one-year term you can cancel at any time. Please [contact me](/contact) if you’d like either service.',
  },
  {
    id: 'non-profit',
    question: 'Do you offer a reduced rate for non-profits?',
    answer: 'Yes, non-profits are welcome to [contact me](/contact) for a reduced rate.',
  },
  {
    id: 'getting-started',
    question: 'What do you need from me to get started?',
    answer:
      'Your brand guidelines, an admin login, your website content, and any web design or live site examples you’d like me to use as reference.',
  },
  {
    id: 'small-change',
    question: 'What if I just need a small change?',
    answer: 'Choose the Custom Web Service and we can discuss what you need.',
  },
  {
    id: 'not-sure',
    question: 'What if I’m not sure which service I need?',
    answer: 'Start with a Website Audit and we can go from there!',
  },
];
