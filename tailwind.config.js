/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      backgroundImage: {
        'custom-pattern': 'radial-gradient(#4083F8 0.5px, #e5e5f7 0.5px)',
      },
      backgroundSize: {
        'custom-size': '30px 30px',
      },
      backgroundPosition: {
        'custom-position': '0 0 10px 10px',
      }
    }
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

