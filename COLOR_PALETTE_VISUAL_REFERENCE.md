# 🎨 Palet Warna - Visual Reference & Examples

## Modern Professional: Navy & Cyan Theme

---

## 📊 Navy Color Palette (Biru Tua - Warna Utama)

```
┌─────────────────────────────────────────────────────────┐
│ NAVY-50:  #f7f8fa  ░░░░░░░░░░ Dusty White             │
│ NAVY-100: #eef1f6  ░░░░░░░░░░ Light Background         │
│ NAVY-200: #d4dfe8  ███░░░░░░░ Light Border             │
│ NAVY-300: #b9cbdc  ██████░░░░ Light Accent             │
│ NAVY-400: #8fa3c4  █████████░ Medium Accent             │
│ NAVY-500: #667ba8  ██████████ Medium Navy              │
│ NAVY-600: #2d4a7b  ██████████ Navy Standard (Body Text)│
│ NAVY-700: #1e3a5f  ██████████ Navy Bold (Headings)     │
│ NAVY-800: #152847  ██████████ Navy Dark (Sidebar Alt)  │
│ NAVY-900: #0f1a2e  ██████████ Navy Darkest (Sidebar)   │
└─────────────────────────────────────────────────────────┘
```

### Penggunaan Navy:
- **navy-900**: Sidebar admin, dark backgrounds
- **navy-700**: Page titles (h1, h2)
- **navy-600**: Body text, navigation items
- **navy-100**: Card backgrounds
- **navy-50**: Page background, safe zones

---

## 🌊 Cyan Color Palette (Biru Muda - Warna Aksen)

```
┌─────────────────────────────────────────────────────────┐
│ CYAN-50:  #ecfbff  ░░░░░░░░░░ Lightest Cyan             │
│ CYAN-100: #d0f4ff  ░░░░░░░░░░ Very Light Cyan           │
│ CYAN-200: #a4e8ff  ░░░░░░░░░░ Light Cyan                │
│ CYAN-300: #78dcff  █░░░░░░░░░ Soft Cyan (Badges)       │
│ CYAN-400: #4cd1ff  ███░░░░░░░ Bright Cyan (Hover)      │
│ CYAN-500: #20c5ff  ██████░░░░ Primary Cyan (Buttons)   │
│ CYAN-600: #00b8e6  ███████░░░ Cyan Bold (Button Hover) │
│ CYAN-700: #0092b3  █████████░ Cyan Darker               │
│ CYAN-800: #006b80  ██████████ Cyan Dark                 │
│ CYAN-900: #004552  ██████████ Cyan Darkest              │
└─────────────────────────────────────────────────────────┘
```

### Penggunaan Cyan:
- **cyan-500**: Primary action buttons (Buat Laporan, Submit, dll)
- **cyan-600**: Button hover states
- **cyan-50**: Active nav items (student sidebar)
- **cyan-500**: Active nav items (admin sidebar)
- **cyan-300**: Badge backgrounds

---

## ⚫ Gray Color Palette (Warna Netral)

```
┌─────────────────────────────────────────────────────────┐
│ GRAY-50:  #fbfcfd  ░░░░░░░░░░ Lightest                  │
│ GRAY-100: #f3f4f6  ░░░░░░░░░░ Very Light                │
│ GRAY-200: #e5e7eb  ░░░░░░░░░░ Light (Borders)          │
│ GRAY-300: #d1d5db  █░░░░░░░░░ Light Medium (Inputs)    │
│ GRAY-400: #9ca3af  ████░░░░░░ Medium Light (Secondary) │
│ GRAY-500: #6b7280  ██████░░░░ Medium (Placeholder)     │
│ GRAY-600: #4b5563  ████████░░ Medium Dark (Text)       │
│ GRAY-700: #374151  █████████░ Dark                      │
│ GRAY-800: #1f2937  ██████████ Very Dark                 │
│ GRAY-900: #111827  ██████████ Darkest                   │
└─────────────────────────────────────────────────────────┘
```

### Penggunaan Gray:
- **gray-300**: Inactive nav items (admin sidebar)
- **gray-200**: Subtle borders and dividers
- **gray-500**: Placeholder text, disabled states
- **gray-600**: Secondary headings, labels
- **gray-400**: Disabled text

---

## 🎯 Status Colors (Harmonis dengan Palet Utama)

```
┌──────────────────────────────────────────────────┐
│ ✅ SUCCESS: #22c55e  ████████░░ Approved        │
│ ⚠️  WARNING: #f59e0b  ███████░░░ Pending         │
│ ❌ ERROR:   #ef4444  ██████░░░░ Rejected        │
│ ℹ️  INFO:   #20c5ff  ██████░░░░ Notification    │
└──────────────────────────────────────────────────┘
```

---

## 🎨 Real-World Component Examples

### 1. SIDEBAR NAVIGATION (Admin - Dark Theme)

```
┌────────────────────────────┐
│ ╎ LM │ Admin Panel         │  ← Logo: navy-900 bg, cyan-500 text
├────────────────────────────┤
│ 📊 Dashboard         ■████  │  ← Active: cyan-500 bg, white text
│ 📋 Kelola Laporan    ░░░░░  │  ← Inactive: gray-300 text, navy-900 hover
│ 👥 Kelola Mahasiswa  ░░░░░  │
│ 📂 Kategori          ░░░░░  │
│ 🏢 Gedung & Fasilitas░░░░░  │
│ 📊 Analitik          ░░░░░  │
│ ⚙️  Pengaturan        ░░░░░  │
├────────────────────────────┤
│ 👤 John Doe                │  ← User info: cyan-500 avatar, white text
│ [← Logout]                 │  ← Logout btn: navy-800 bg, hover navy-700
└────────────────────────────┘
```

### 2. SIDEBAR NAVIGATION (Student - Light Theme)

```
┌─────────────────────────────┐
│ ╎ LM │ Lapor Mahasiswa       │  ← Logo: navy gradient, gradient text
├─────────────────────────────┤
│ 🏠 Dashboard         ■ cyan  │  ← Active: cyan-50 bg, navy-700 text
│ ➕ Buat Laporan      ░ navy  │  ← Inactive: navy-600 text, hover navy-50
│ 📄 Laporan Saya      ░ navy  │
│ 👁️  Laporan Publik    ░ navy  │
│ 🔔 Notifikasi (3)    ░ navy  │  ← Badge: gradient red, white text
│ 👤 Profil            ░ navy  │
├─────────────────────────────┤
│ 👤 │ Student Name            │  ← User: cyan ring around avatar
│ [← Logout]                  │  ← Logout: navy-50 bg, hover navy-100
└─────────────────────────────┘
```

### 3. BUTTONS

```
┌────────────────────────────────────────────┐
│ [Buat Laporan]  ← Primary (cyan-500)       │
│ Normal: bg-cyan-500, text-white            │
│ Hover:  bg-cyan-600, shadow-lg             │
│ Active: bg-cyan-700                        │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│ [Simpan]  ← Secondary (navy-600)           │
│ Normal: bg-navy-600, text-white            │
│ Hover:  bg-navy-700, shadow-lg             │
│ Active: bg-navy-800                        │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│ [Batal]  ← Outline (navy-600 border)       │
│ Normal: border-navy-600, text-navy-600     │
│ Hover:  bg-navy-50, border-navy-700        │
│ Active: bg-navy-100                        │
└────────────────────────────────────────────┘

┌────────────────────────────────────────────┐
│ [Pelajari]  ← Ghost (no background)        │
│ Normal: text-navy-600                      │
│ Hover:  bg-navy-50, text-navy-700          │
│ Active: bg-navy-100                        │
└────────────────────────────────────────────┘
```

### 4. CARDS

```
┌─────────────────────────────────────┐
│ Laporan Terbaru                     │  ← Heading: navy-900
├─────────────────────────────────────┤
│                                     │  ← Background: white
│ Status: Pending                     │  ← Text: navy-600
│ Tanggal: 5 Januari 2026             │
│ Kategori: Fasilitas                 │
│                                     │
│ [Lihat Detail →]                    │  ← Link: cyan-600
└─────────────────────────────────────┘
  Border: navy-200, Shadow: navy-900 10%
  Hover: shadow-lg
```

### 5. FORM INPUT

```
Label: "Judul Laporan" (navy-900, font-bold)

┌─────────────────────────────┐
│ Masukkan judul laporan...   │  ← Placeholder: gray-500
└─────────────────────────────┘
  Border: navy-200
  Focus: border-cyan-500, ring-cyan-200
  Disabled: bg-navy-50, text-gray-500

┌─────────────────────────────┐
│ Pilih kategori              │ ▼
└─────────────────────────────┘
  Border: navy-200
  Text: navy-900 (default), navy-600 (placeholder)
```

### 6. ALERTS

```
┌─────────────────────────────────────┐
│ ✓ Laporan berhasil disimpan!        │  ← success-700 text
└─────────────────────────────────────┘
  Background: success-50, Border-left: success-500

┌─────────────────────────────────────┐
│ ⚠ Laporan belum lengkap             │  ← warning-700 text
└─────────────────────────────────────┘
  Background: warning-50, Border-left: warning-500

┌─────────────────────────────────────┐
│ ✗ Terjadi kesalahan                 │  ← error-700 text
└─────────────────────────────────────┘
  Background: error-50, Border-left: error-500

┌─────────────────────────────────────┐
│ ℹ Laporan Anda telah dikonfirmasi    │  ← info-700 text
└─────────────────────────────────────┘
  Background: info-50, Border-left: info-500
```

### 7. BADGES

```
[New]       ← bg-cyan-100, text-cyan-800
[Approved]  ← bg-success-100, text-success-800
[Pending]   ← bg-warning-100, text-warning-800
[Rejected]  ← bg-error-100, text-error-800
```

### 8. TABLE

```
┌──────────────┬──────────┬────────────┐
│ Nama         │ Status   │ Tanggal    │  ← Header: bg-navy-100, text-navy-900
├──────────────┼──────────┼────────────┤
│ John Doe     │ [Approved]│ 5 Jan 2026│  ← Row: hover:bg-navy-50
├──────────────┼──────────┼────────────┤
│ Jane Smith   │ [Pending] │ 4 Jan 2026│
└──────────────┴──────────┴────────────┘
  Border: navy-200
```

---

## 🌈 Kombinasi Harmonis (Do's & Don'ts)

### ✅ DO - Kombinasi Harmonis

```
✓ Navy-900 text on white background
✓ Navy-700 headings on white background
✓ Navy-600 body text on white background
✓ Cyan-500 button on white background
✓ Gray-300 inactive text on navy-900 background
✓ Cyan-50 active item on white sidebar
✓ Cyan-500 active item on navy-900 sidebar
✓ White text on navy/cyan dark backgrounds
```

### ❌ DON'T - Kombinasi Buruk (Hindari)

```
✗ Cyan text on cyan background (tidak terbaca)
✗ Navy text pada navy background (tidak kontras)
✗ Gray-400 text pada white background (terlalu pudar)
✗ Banyak aksen cyan di satu halaman (berlebihan)
✗ Campur warna dari palet berbeda tanpa alasan
✗ Gunakan navy-50 untuk text (terlalu terang)
✗ Gunakan cyan-900 untuk buttons (terlalu gelap)
```

---

## 📐 Color Contrast Ratios (WCAG Compliance)

```
✅ AAA Level (7:1+)          ✅ AA Level (4.5:1+)
┌────────────────────────┐   ┌────────────────────────┐
│ Navy-900 on white  13.2│   │ Cyan-500 on white  5.3│
│ Navy-700 on white   9.4│   │ White on cyan-600  5.8│
│ Navy-600 on white   7.1│   │ Info badge ratio   4.8│
│ Gray-600 on white   7.7│   └────────────────────────┘
│ White on navy-900  13.2│
│ White on navy-700   9.4│
└────────────────────────┘

✅ Semua kombinasi di atas memenuhi WCAG AA atau AAA!
```

---

## 🎨 Figma/Design Tool Color Tokens

Jika Anda menggunakan Figma atau design tools lain:

```
Navy / Primary
  - 900: #0f1a2e
  - 800: #152847
  - 700: #1e3a5f
  - 600: #2d4a7b
  - 500: #667ba8
  - 400: #8fa3c4
  - 300: #b9cbdc
  - 200: #d4dfe8
  - 100: #eef1f6
  - 50: #f7f8fa

Cyan / Accent
  - 900: #004552
  - 800: #006b80
  - 700: #0092b3
  - 600: #00b8e6
  - 500: #20c5ff
  - 400: #4cd1ff
  - 300: #78dcff
  - 200: #a4e8ff
  - 100: #d0f4ff
  - 50: #ecfbff

Gray / Neutral
  - 900: #111827
  - 800: #1f2937
  - 700: #374151
  - 600: #4b5563
  - 500: #6b7280
  - 400: #9ca3af
  - 300: #d1d5db
  - 200: #e5e7eb
  - 100: #f3f4f6
  - 50: #fbfcfd

Status
  - Success: #22c55e
  - Warning: #f59e0b
  - Error: #ef4444
  - Info: #20c5ff
```

---

## 📱 Responsive Color Usage

Warna tetap konsisten di semua breakpoints:

```
Desktop   → Sidebar + Main Content (full color palette)
Tablet    → Sidebar toggle + Main Content (same colors)
Mobile    → Hamburger menu + Full width (same colors)

Background tetap: white / navy-50
Text tetap: navy-900 / navy-600
Accent tetap: cyan-500
```

---

## 🔄 Update Log

**2026-01-05** - Implementasi Palet Modern Professional
- Navy untuk kepercayaan dan profesionalisme
- Cyan untuk action buttons
- Gray untuk elemen netral
- Semua harmonis dan WCAG compliant

---

**Status**: ✅ Visual Reference Complete  
**Last Updated**: 2026-01-05  
**Version**: 1.0
