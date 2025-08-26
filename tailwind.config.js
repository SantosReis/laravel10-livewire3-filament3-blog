import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/livewire/flux/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php'
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Helvetica', ...defaultTheme.fontFamily.sans]
      }
    }
  },

  plugins: [forms, typography],
  darkMode: 'class'
}
