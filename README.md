# Vitrify – Creative Consultancy WordPress Theme

A bold, glassmorphism-inspired WordPress theme for creative consultancies and agencies. Built with **Timber (Twig)**, **TailwindCSS**, and **ACF**, with dynamic content and modular styling. Suited for portfolios, case studies, and agency sites.

---

## Requirements

- **WordPress** 5.9+
- **PHP** 7.4+
- **Timber** (timber/timber) – Twig templating
- **Advanced Custom Fields (ACF)** – for Theme Options, About/Services/Contact/Case Study fields (field groups are registered in the theme)

---

## Theme setup

### 1. Install dependencies

- Install and activate the **Timber** plugin (`timber/timber` from the Plugins screen or [wordpress.org/plugins/timber-library](https://wordpress.org/plugins/timber-library/)).
- Install and activate **Advanced Custom Fields** ([advancedcustomfields.com](https://www.advancedcustomfields.com/) or Pro). The theme registers its own field groups; no manual ACF setup is required.
- Build Tailwind CSS (see [Build assets](#build-assets) below).

### 2. Create pages

Create these pages (any order). The theme uses **slugs** to route them:

| Slug        | Purpose                    |
|------------|----------------------------|
| (any)      | **Home** – set as front page |
| `about`    | About (mission, values, team) |
| `services` | Services (repeater: title, description, icon) |
| `contact`  | Contact (details + form shortcode) |
| (optional) | **Blog** – set as “Posts page” for the blog index |

### 3. WordPress settings

- **Settings → Reading**: set “Your homepage displays” to **A static page** and choose your Home page; optionally set the **Posts page** to your Blog page.
- **Appearance → Menus**: create a menu, add the pages (and “Case Studies” link to `/case-studies`), assign it to **Primary Menu**.
- **Appearance → Theme Options** (ACF): edit the hero (badge, headline, subtext, CTA labels and URLs) for the home page.

### 4. Case studies

- Add case studies under **Case Studies** in the admin. Each supports: title, content, featured image, and ACF fields: **Client name**, **Project duration**, **Services provided** (comma-separated), **External URL**.
- The archive is at `/case-studies`; single case studies use the same slug and show prev/next links.

### 5. Contact form (optional)

Edit the Contact page and add a form shortcode in the content (e.g. **Contact Form 7**, **WPForms**). Use the Contact page ACF fields for address, email, and phone.

---

## Build assets

Tailwind CSS is built from `src/input.css` into `src/output.css`.

```bash
npm install
npm run build
```

For development with watch:

```bash
npm run watch
```

---

## Features

- **Pages**: Home (hero from Theme Options), About, Services, Contact, Case Studies archive, Blog index, Search, 404.
- **Custom post type**: Case Studies with archive and single templates, prev/next navigation.
- **ACF**: Theme Options (hero), About (intro, mission, stats, values, partner logos, team), Services (repeater), Contact (address, email, phone), Case Study (client, duration, services, URL). All field groups are registered in `inc/acf-fields.php`.
- **Navigation**: Primary menu (Appearance → Menus), logo from theme directory, header search form.
- **Styling**: Glassmorphism (backdrop blur, borders), orange accents, responsive layout, footer with copyright and nav.

---

## Theme architecture

| Path | Purpose |
|------|--------|
| `views/` | Twig templates (home, about, contact, services, page) |
| `views/layouts/base.twig` | Base layout (nav, footer, blobs) |
| `views/partials/` | Header, footer, menu, tease, pagination, comments |
| `views/templates/` | Archive, single, single-case_study, search, 404 |
| `inc/acf-fields.php` | ACF options page + field group registration |
| `functions.php` | Theme support, menus, CPT, template routing, context |
| `front-page.php` | Renders home when a static front page is set |
| `home.php` | Blog index when “Posts page” is set |
| `tailwind.config.js` | Tailwind config; content: views, PHP, src |

---

## Customization

- **Logo**: Replace `Logo-01.png` in the theme root or use a child theme and enqueue your logo; the base layout uses `site.theme_link ~ '/Logo-01.png'`.
- **Child theme**: To add custom CSS/JS without losing updates, create a child theme and enqueue your assets from the child’s `functions.php`. The theme does not provide a bundled child; use a standard WordPress child theme setup.

---

## Demo content (optional)

To match the look of the demo:

1. Create the pages and set Home/Blog as above.
2. Assign the Primary menu.
3. Add a few case studies with featured images and ACF fields.
4. Fill Theme Options (hero) and About page ACF (mission, stats, values, team, partner logos) as desired.

The theme uses fallback copy and placeholders when ACF data is empty, so it works even before all options are filled.

---

## License

GPLv2 or later. See `style.css` for theme metadata.
