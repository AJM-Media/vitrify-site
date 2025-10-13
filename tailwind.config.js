/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./views/**/*.{twig,html}", // ALL twig files in views (layouts, partials, templates)
      "./*.php",                  // Root-level PHP files
      "./src/**/*.{html,js}"     // Any future HTML/JS files in src
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  };
  