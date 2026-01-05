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
        // ============================================
        // Modern Professional Color Palette
        // Biru Tua (Navy) & Putih dengan Aksen Cyan
        // ============================================
        
        // Warna Utama: Navy/Biru Tua (Trust, Professional, Focus)
        navy: {
          50: '#f7f8fa',    // Dusty White (background alt)
          100: '#eef1f6',   // Light background
          200: '#d4dfe8',   // Light border
          300: '#b9cbdc',   // Light accent
          400: '#8fa3c4',   // Medium accent
          500: '#667ba8',   // Medium navy
          600: '#2d4a7b',   // Navy standard
          700: '#1e3a5f',   // Navy bold
          800: '#152847',   // Navy dark
          900: '#0f1a2e',   // Navy darkest (sidebar, headers)
        },
        
        // Warna Aksen: Cyan Cerah (Action buttons, highlights)
        cyan: {
          50: '#ecfbff',    // Lightest cyan
          100: '#d0f4ff',   // Very light cyan
          200: '#a4e8ff',   // Light cyan
          300: '#78dcff',   // Soft cyan
          400: '#4cd1ff',   // Bright cyan (hover)
          500: '#20c5ff',   // Primary cyan (actions)
          600: '#00b8e6',   // Cyan bold
          700: '#0092b3',   // Cyan darker
          800: '#006b80',   // Cyan dark
          900: '#004552',   // Cyan darkest
        },
        
        // Warna Pendamping: Grays (Neutral, readable)
        gray: {
          50: '#fbfcfd',    // Lightest
          100: '#f3f4f6',   // Very light
          200: '#e5e7eb',   // Light gray
          300: '#d1d5db',   // Medium light
          400: '#9ca3af',   // Medium
          500: '#6b7280',   // Medium dark
          600: '#4b5563',   // Dark
          700: '#374151',   // Very dark
          800: '#1f2937',   // Almost black
          900: '#111827',   // Black
        },
        
        // Warna Status: Harmonis dengan palet utama
        success: {
          50: '#f0fdf4',
          100: '#dcfce7',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
        },
        warning: {
          50: '#fffbeb',
          100: '#fef3c7',
          500: '#f59e0b',
          600: '#d97706',
          700: '#b45309',
        },
        error: {
          50: '#fef2f2',
          100: '#fee2e2',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
        },
        info: {
          50: '#ecfbff',
          100: '#d0f4ff',
          500: '#20c5ff',
          600: '#00b8e6',
          700: '#0092b3',
        },
        
        // Legacy colors for compatibility (mapped to new palette)
        primary: {
          50: '#f7f8fa',
          100: '#eef1f6',
          200: '#d4dfe8',
          300: '#b9cbdc',
          400: '#8fa3c4',
          500: '#667ba8',
          600: '#2d4a7b',
          700: '#1e3a5f',
          800: '#152847',
          900: '#0f1a2e',
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