/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#E6F2FD',
          100: '#92B7FF', 
          600: '#344BFA',
          900: '#212292',
        },
      },
    },
  },
  plugins: [],
}
