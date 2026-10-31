# KokoNekoArt: custom WordPress theme

A hand-coded WordPress theme that powers **[kokoneko.art](https://www.kokoneko.art/)**, my portfolio, commission, and resume site.

> **This repository is a portfolio piece, not a product.** It's here so you can read the code behind the live site. It isn't packaged for installation, and it depends on content and field data that live in my WordPress database.

**Jess Humphrey** · [LinkedIn](https://www.linkedin.com/in/jesshumphrey/) · [kokoneko.art](https://www.kokoneko.art/)

---

## What it is

I wanted a custom site for my portfolio and my commissions that was coded from scratch. I started with blankslate and wrote the rest myself. I have many custom snippets that add unqiue interactions on my site.

## What this project shows

| Skill | Where to look |
|---|---|
| **Custom WordPress theme development** | Template hierarchy, `functions.php` hooks and filters, shortcodes, nav menu and widget registration |
| **Structured content with ACF / SCF** | 11 field groups in `scf-json/`, with the field definitions version-controlled within the them instead of stored only in the database |
| **Front-end architecture** | Modular Sass (`css/base`, `components`, `layout`) with shared variables and mixins |
| **Interactive JavaScript** | `js/scripts.js`: a live commission price calculator with business rules, plus the animated star field |
| **Web security basics** | A hand-written Content Security Policy and security headers, in `koko_add_csp_header()` |
| **Accessibility & SEO** | Skip link, ARIA labels, semantic landmarks, `screen-reader-text` utilities, schema.org microdata |
| **Attention to design** | A consistent design system built from CSS custom properties, with animation and a custom pastel branded UI |

## Highlights

### Interactive commission calculator
`page-commission-me.php` and `js/scripts.js`

Clients build a commission by choosing a character shot (headshot, half body, full body, chibi or reference sheet), an art style, a background and add-ons.

- The total price updates live.
- A preview image changes through `data-*` attributes, with the CSS doing the swapping.
- Some choices lock others out. For example, sketch and line-art styles can't use pattern or scene backgrounds, and the UI resets itself to a valid combination.
- It generates a PayPal payment link for the exact total.
- It also builds a **pre-filled request-form URL** from the selections, so the client's choices carry over to the form.
- Prices and descriptions come from custom fields, so I can change them without touching code.

### Content model in version control
`scf-json/scf-master.json`, `functions.php`

ACF/SCF field groups are saved to the theme as JSON through the `acf/settings/save_json` and `load_json` filters. The data model is therefore reviewable and diffable in Git, and not hidden in the database. It covers 11 field groups, including:

- the home page sections
- commission prices
- the resume
- portfolio post metadata
- site-wide options
- a per-category colour field

### Dynamic, content-driven pages
- **Home:** hero, about, commissions, portfolio and contact sections have repeaters for some flexibility in the content while maintaining a restricted layout.
- **Portfolio:** category "pills" are coloured from a field. `get_contrast_color()` calculates the luminance of each colour (the standard `0.299 / 0.587 / 0.114` weighting) and chooses black or white text, so labels stay readable whatever colour I pick.
- **Project pages:** optional buttons (code, live demo, Figma design or prototype, mockup PDF, external site) appear only if the matching field is filled in.
- **RSS aggregator:** a template merges several feeds, sorts them by date, filters out YouTube Shorts and reports feeds that failed. This page is private and for personal use. It was fun to play around with.
- **Resume:** a print-styled, `noindex` page built from fields, so I edit it in the admin and don't hand-maintain a separate document.
- **Hidden pages:** a field toggle returns a real `404` status, with the theme's 404 template, to logged-out visitors.

### Security
`koko_add_csp_header()` in `functions.php`

- A Content Security Policy that allow-lists only the origins the site really needs
- `Strict-Transport-Security`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy` and `Permissions-Policy`
- A `robots` `noai, noimageai` meta tag, because the site hosts my own artwork

### Accessibility & semantics
- A skip-to-content link
- `role` attributes and landmark elements (`header`, `nav`, `main`, `footer`)
- Labelled form controls and `aria-label` text on the site badge
- Screen-reader-only text on "read more" links
- `schema.org` microdata, with the page type chosen per request (`Article`, `ProfilePage`, `SearchResultsPage` or `WebPage`)
- Responsive, fluid type using `clamp()`

### Styling
`css/`

- Sass with `@use` modules, split into base, layout and components
- A single `_vars.scss` that holds the asset path and a `sample()` mixin, which replaced about twenty repeated `background: url(...)` rules
- Brand colours and type scale as CSS custom properties, so the whole palette can change in one place
- Scroll and entrance animation through Animate.css, with staggered delays
- A twinkling star field and drifting clouds, generated in JavaScript and animated in CSS

## Tech stack

| Layer | Tools |
|---|---|
| CMS | WordPress |
| Back end | PHP 8.4 |
| Content modelling | Advanced Custom Fields / Secure Custom Fields (JSON sync) |
| Front end | HTML5, Sass/SCSS, vanilla JavaScript, jQuery (bundled with WordPress) |
| Libraries | Slick carousel, Animate.css, Font Awesome 7 |
| Fonts | Fuzzy Bubbles, Spinnaker, Reem Kufi (Google Fonts, with `preconnect` and `display=swap`) |

## Project structure

```
kokonekoart/
├── functions.php            # theme setup, assets, security headers, SCF sync, helpers
├── shortcodes.php           # [quick_info] [my_age] [birthday] [art_samples] [commission_goal]
├── header.php, footer.php, sidebar.php, comments.php
├── page-home.php            # section-based landing page
├── page-about-me.php
├── page-commission-me.php   # interactive price calculator
├── page-contact.php
├── page-resume.php          # standalone print-styled résumé
├── page-tos.php
├── archive.php              # "Portfolio" page template
├── category.php, entry*.php, single.php, nav-below*.php
├── template-rss-feed.php    # "RSS Feed" page template
├── css/
│   ├── theme.scss           # entry point
│   ├── base/                # _vars, _root, _stars, _responsive
│   ├── components/          # _btn, _form, _slider, _art-samples, _viewports
│   └── layout/              # _header, _nav, _footer, _content, _sections
├── js/                      # scripts.js, slick.min.js
├── scf-json/                # ACF/SCF field groups as JSON
└── img/                     # local assets
```

## By the numbers

- About 1,400 lines of PHP, 2,350 lines of Sass and 190 lines of JavaScript, not counting vendored libraries
- 11 field groups
- 8 custom page templates, plus the standard WordPress fallbacks

## A note on the artwork

The illustrations, character designs and brand assets on the live site are **not** covered by this repository's code licence. Artwork credits are on the live site's pages. The code is licensed under the [GNU GPL v3 or later](https://www.gnu.org/licenses/gpl.html).

## Get in touch

I'm looking for remote work anywhere in Canada. You can reach me through [LinkedIn](https://www.linkedin.com/in/jesshumphrey/) or the contact page on [kokoneko.art](https://www.kokoneko.art/).
