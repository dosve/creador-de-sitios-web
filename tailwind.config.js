/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./public/**/*.js",  // ✅ Incluir componentes del editor
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}