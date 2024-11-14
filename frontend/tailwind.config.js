/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}', // Tailwind will scan these files for class names
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
