# 🧊 Vitrify – Creative Consultancy Theme (WordPress + TailwindCSS)

A modern, animated, glassmorphism-inspired WordPress theme designed for creative consultancies, powered by **TailwindCSS**, **Timber (Twig)**, and modular frontend components.

> This project is in active early development. It’s designed as a clean, performant and beautiful starting point for showcasing agency work, values, and team — built to impress clients and employers.

---

## 🌟 Project Overview

Vitrify is a sleek, single-repo WordPress theme integrating:

- ✨ Elegant **glassmorphism UI** via TailwindCSS
- ⚡ Fast prototyping with **Twig templates via Timber**
- 🧠 Organised template architecture for maintainability
- 📄 Support for custom pages like **Home**, **About**, and **Case Studies**
- 🔧 Tailwind CLI-powered build system for easy styling

---

## 🎯 Pages & Sections

### 🏠 Home Page

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

## ⚙️ Stack & Tools

| Tech/Tool         | Purpose                                |
|-------------------|----------------------------------------|
| **WordPress**     | CMS backend                            |
| **Timber**        | PHP + Twig templating in WordPress     |
| **TailwindCSS**   | Utility-first styling                  |
| **Tailwind CLI**  | Local dev build pipeline               |
| **ACF**           | Custom meta fields for case studies    |
| **npm**           | Build management for Tailwind CLI      |

---

## 💻 Development Setup

```bash
# Clone the repo
git clone https://github.com/ajm-media/vitrify-theme
cd vitrify-theme

# Install dependencies
npm install

# Start Tailwind in dev mode
npm run dev
