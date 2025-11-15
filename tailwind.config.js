module.exports = {
  content: [
    './*.php',
    './**/*.php',  // scan all subfolders
    './assets/js/**/*.js', // optional for JS if using Tailwind classes
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}