/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme:  {
    extend: {
      colors: {
        primary: {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
        },
        accent: {
          50: '#e0f2fe',
          100: '#bae6fd',
          200: '#7dd3fc',
          300: '#38bdf8',
          400: '#0ea5e9',
          500: '#0284c7',
          600: '#0369a1',
          700: '#075985',
          800: '#0c4a6e',
          900: '#082f49',
        },
        navy: {
          50: '#f0f4f8',
          100: '#d9e2ec',
          200: '#b3cde8',
          300: '#8db4e2',
          400: '#6d98d8',
          500: '#1e3a5f',
          600: '#1a3052',
          700: '#152d47',
          800: '#0f2232',
          900: '#0a151d',
        },
      },
    },
  },
  plugins:  [],
}