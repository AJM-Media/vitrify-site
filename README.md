# 🧊 Vitrify – Creative Consultancy WordPress Theme

A bold, glassmorphism-inspired WordPress theme tailored for creative consultancies and agencies. Built with **Timber (Twig)**, **TailwindCSS**, and **ACF**, featuring dynamic content and modular, scalable styling.

---

## 🚀 Project Overview

**Vitrify** is a modern, performant WordPress theme designed to showcase case studies, company values, and team structure with style and clarity. Key features include:

- 🌐 Dynamic content from **WordPress REST API** and **ACF**
- 🧱 Modular Twig templating with **Timber**
- 🎨 Fully custom design using **TailwindCSS CLI**
- 🔁 Custom Post Types (Case Studies) with archive + single views
- 📱 **Fully responsive** and **accessibility-aware**
- 💎 **Glassmorphism** UI effects across components
- 📦 Easy to maintain, extend, and share

---

## 📦 Features & Functionality

### ✅ Pages & Routing

- Glass-style fixed navbar and footer
- Hero intro with custom blobs and animated background
- Responsive call-to-action
- Designed for fullscreen (min-h-screen) layout

### 🧾 About Page

`views/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you’ll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. Just an FYI.

`tests/` ... basically don't worry about (or remove) this unless you know what it is and want to.

### 📁 Case Studies (Custom Post Type)

- Archive template shows custom meta:
  - `client_name`, `project_duration`, `services_provided`
- Styled with hover effects and blurred glass cards
- Single post template includes ACF fields, featured image, and "Visit Project" link

---

### ✅ Case Studies (Custom Post Type)

- Custom post type: `case_study`
- ACF fields:
  - `client_name`
  - `project_duration`
  - `services_provided` (CSV parsed into list)
  - `external_url`
- Loop via Timber’s `posts` context variable
- Archive and single templates styled with:
  - Glass cards
  - Hover animations
  - Responsive layouts

---

### ✅ Tailwind Styling & UI

- Built using **Tailwind CLI** for fast dev and small CSS bundle
- Components styled with:
  - `backdrop-blur`, `bg-white/10`, border/glow effects
  - Consistent use of `max-w-*`, `px-*`, `gap-*`, `grid`, `flex`
- Fully responsive at `sm`, `md`, `lg`, `xl` breakpoints
- Focus/hover/active states for all buttons and links
- Centralized layout: header → content → footer
- Viewport-centered section layouts with `min-h-screen` & `flex`

---

### ✅ About Page Highlights

- 📣 Hero introduction
- 📊 Mission + key stats (client retention, rating, etc.)
- 🧭 6 core values in a glassy card grid
- 🤝 Partner logo grid (5-column)
- 👥 Team grid (4-column) with avatar cards

---

### ✅ Theme Architecture

| File / Folder           | Purpose                                      |
|--------------------------|----------------------------------------------|
| `src/input.css`          | Tailwind source                             |
| `src/output.css`         | Compiled Tailwind file                      |
| `templates/`             | Timber views (Twig)                         |
| `templates/home.twig`    | Home page template                          |
| `templates/about.twig`   | About page template                         |
| `templates/archive-case_study.twig` | CPT archive                      |
| `templates/single-case_study.twig`  | CPT single view                   |
| `partials/`              | Reusable elements (nav, head, footer)       |
| `tailwind.config.js`     | Tailwind config                             |
| `functions.php`          | Theme logic, CPT/ACF registration, enqueue  |
| `package.json`           | CLI build scripts                           |

---

## 🔌 Integrations

| Tool/Package         | Role                                  |
|----------------------|----------------------------------------|
| **Timber**           | Twig templating for WordPress          |
| **TailwindCSS**      | Styling framework (CLI version)        |
| **ACF**              | Meta fields for Case Studies           |
| **WordPress REST API**| Data source for posts, ACF, etc.     |
| **LocalWP** *(or similar)* | Dev environment                  |
| **npm**              | CLI tooling and scripts                |

---

## 🧠 Developer Notes

### 🧩 ACF Setup (Example)

Add custom fields to `case_study` CPT:

| Field Name         | Type        |
|--------------------|-------------|
| `client_name`      | Text        |
| `project_duration` | Text        |
| `services_provided`| Text (CSV)  |
| `external_url`     | URL         |

Use `post.meta('field_name')` in Twig templates.

---

### 📂 Git Ignore

```gitignore
/vendor/
/wordpress/
.phpunit.result.cache
/node_modules/
.env
*.log
