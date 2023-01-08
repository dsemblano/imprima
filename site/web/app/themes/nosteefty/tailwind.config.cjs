// https://tailwindcss.com/docs/configuration
module.exports = {
  content: ["./index.php", "./app/**/*.php", "./resources/**/*.{php,vue,js}"],
  theme: {
    container: {
      center: true,
      padding: '1rem',
    },
    extend: {
      colors: {
        greennos: '#1ebe85',
        graynos: '#a6a6a6',
        greennoshover: '#22A3A5',
        greymenu: '#3e4435',
        greymenuhover: '#57604a',
        greydarkest: '#262a31'
      }, // Extend Tailwind's default colors
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('@tailwindcss/typography')
  ],
};
