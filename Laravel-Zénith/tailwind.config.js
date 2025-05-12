/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
    './app/Http/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      // Palette personnalisée Digit All
      colors: {
        digitall: {
          orange: '#FFA726',
          blue: '#1A1333',
          light: '#F8F9FB',
          white: '#FFFFFF',
        },
      },
      // Ajout d'une animation fade-in
      animation: {
        'fade-in': 'fadeIn 1s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
      },
    },
  },
  plugins: [],
}
