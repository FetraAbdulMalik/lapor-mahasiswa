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
        // Modern Professional - Navy & Cyan Theme
        navy: {
          50: '#f8fafb',
          100: '#eef2f6',
          200: '#d4dfe8',
          300: '#b9cbdc',
          400: '#8fa3c4',
          500: '#667ba8',
          600: '#1e3a5f',
          700: '#1a2f52',
          800: '#152847',
          900: '#0f1a2e',
        },
        cyan: {
          50: '#ecfbff',
          100: '#d0f4ff',
          200: '#a4e8ff',
          300: '#78dcff',
          400: '#4cd1ff',
          500: '#20c5ff',
          600: '#00b8e6',
          700: '#0092b3',
          800: '#006b80',
          900: '#004552',
        },
        // Legacy colors for compatibility
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
          50: '#ecfbff',
          100: '#d0f4ff',
          200: '#a4e8ff',
          300: '#78dcff',
          400: '#4cd1ff',
          500: '#20c5ff',
          600: '#00b8e6',
          700: '#0092b3',
          800: '#006b80',
          900: '#004552',
        },
      },
      animation: {
        'shimmer': 'shimmer 0.5s ease-in',
        'ripple': 'ripple 0.6s ease-out',
        'slide-up': 'slideUp 0.4s ease-out',
        'glow': 'glow 2s ease-in-out infinite',
        'bounce-in': 'bounce-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)',
        'pulse-ring': 'pulse-ring 2s ease-out infinite',
      },
    },
  },
  plugins:  [],
}