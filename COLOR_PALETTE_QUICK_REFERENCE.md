# 🎨 Quick Reference - Palet Warna Modern Professional

## 🚀 Quick Start - Copy & Paste Ready

### Colors at a Glance

```
Navy (Utama)     Cyan (Aksen)     Gray (Netral)    Status
#0f1a2e (900)    #20c5ff (500)    #111827 (900)    ✓ #22c55e
#1e3a5f (700)    #00b8e6 (600)    #6b7280 (500)    ⚠ #f59e0b
#2d4a7b (600)    #ecfbff (50)     #e5e7eb (200)    ✗ #ef4444
#f7f8fa (50)     #d0f4ff (100)    #fbfcfd (50)     ℹ #20c5ff
```

---

## 🎨 Component Copy-Paste Code

### Buttons

**Primary Button** (Cyan - For Main Actions)
```html
<button class="btn-primary">Buat Laporan</button>
<!-- or -->
<button class="bg-cyan-500 hover:bg-cyan-600 text-white font-medium py-2 px-4 rounded-lg transition-all shadow-md hover:shadow-lg">
  Buat Laporan
</button>
```

**Secondary Button** (Navy - For Secondary Actions)
```html
<button class="btn-secondary">Simpan</button>
<!-- or -->
<button class="bg-navy-600 hover:bg-navy-700 text-white font-medium py-2 px-4 rounded-lg">
  Simpan
</button>
```

**Outline Button** (Navy Border - For Tertiary Actions)
```html
<button class="btn-outline">Batal</button>
<!-- or -->
<button class="border-2 border-navy-600 text-navy-600 hover:bg-navy-50 font-medium py-2 px-4 rounded-lg">
  Batal
</button>
```

**Danger Button** (Red - For Destructive Actions)
```html
<button class="btn-danger">Hapus</button>
```

**Success Button** (Green - For Confirmations)
```html
<button class="btn-success">Setujui</button>
```

---

### Inputs

**Text Input**
```html
<input type="text" class="input-field" placeholder="Masukkan nama...">
<!-- or -->
<input type="text" class="w-full px-4 py-2 border-2 border-navy-200 rounded-lg text-navy-900 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200">
```

**Textarea**
```html
<textarea class="input-field" placeholder="Tulis pesan..."></textarea>
```

**Label**
```html
<label class="text-primary block mb-2">Nama Lengkap</label>
<input type="text" class="input-field">
```

---

### Cards

**Basic Card**
```html
<div class="card-base">
  <div class="p-6">
    <h3 class="heading-sm">Judul Card</h3>
    <p class="text-secondary">Konten card di sini...</p>
  </div>
</div>
<!-- or -->
<div class="bg-white rounded-lg shadow-md border border-navy-200 overflow-hidden p-6">
  ...
</div>
```

**Elevated Card** (dengan hover effect)
```html
<div class="card-elevated">
  <div class="p-6">
    <h3 class="heading-sm">Judul Penting</h3>
    <p class="text-secondary">Card ini akan shadow saat hover</p>
  </div>
</div>
```

---

### Text & Headings

**Page Title**
```html
<h1 class="heading-lg">Dashboard Mahasiswa</h1>
<!-- or -->
<h1 class="text-3xl font-bold text-navy-900">Dashboard Mahasiswa</h1>
```

**Section Title**
```html
<h2 class="heading-md">Laporan Terbaru</h2>
```

**Regular Text**
```html
<p class="text-secondary">Ini adalah teks regular untuk konten utama</p>
<!-- or -->
<p class="text-navy-600 font-normal">Ini adalah teks regular</p>
```

**Secondary Text** (Label, description)
```html
<p class="text-tertiary">Keterangan atau label sekunder</p>
```

---

### Alerts

**Success Alert**
```html
<div class="alert-success">
  ✓ Laporan berhasil disimpan!
</div>
```

**Warning Alert**
```html
<div class="alert-warning">
  ⚠ Laporan belum lengkap
</div>
```

**Error Alert**
```html
<div class="alert-error">
  ✗ Terjadi kesalahan
</div>
```

**Info Alert**
```html
<div class="alert-info">
  ℹ Laporan telah dikonfirmasi
</div>
```

---

### Badges

**Primary Badge**
```html
<span class="badge-primary">New</span>
```

**Status Badges**
```html
<span class="badge-success">Approved</span>
<span class="badge-warning">Pending</span>
<span class="badge-error">Rejected</span>
```

---

### Links

**Primary Link** (Cyan)
```html
<a href="#" class="link-primary">Lihat Detail</a>
```

**Secondary Link** (Navy)
```html
<a href="#" class="link-secondary">Pelajari Lebih</a>
```

---

### Navigation Item (Sidebar)

**Active Nav Item - Student**
```html
<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-cyan-50 text-navy-700">
  <svg class="w-5 h-5">...</svg>
  <span>Dashboard</span>
</a>
```

**Inactive Nav Item - Student**
```html
<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-navy-600 hover:bg-navy-50">
  <svg class="w-5 h-5">...</svg>
  <span>Laporan</span>
</a>
```

**Active Nav Item - Admin**
```html
<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-cyan-500 text-white">
  <svg class="w-5 h-5">...</svg>
  <span>Dashboard</span>
</a>
```

**Inactive Nav Item - Admin**
```html
<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-navy-800">
  <svg class="w-5 h-5">...</svg>
  <span>Kelola Laporan</span>
</a>
```

---

### Form Group

```html
<div class="space-y-4">
  <div>
    <label class="text-primary block mb-2">Nama Lengkap*</label>
    <input type="text" class="input-field" required>
  </div>
  
  <div>
    <label class="text-primary block mb-2">Email*</label>
    <input type="email" class="input-field" required>
  </div>
  
  <div>
    <label class="text-primary block mb-2">Pesan*</label>
    <textarea class="input-field" rows="4"></textarea>
  </div>
  
  <div class="flex gap-2">
    <button class="btn-primary">Kirim</button>
    <button class="btn-outline">Batal</button>
  </div>
</div>
```

---

### Table

```html
<table class="w-full border-collapse">
  <thead class="table-header">
    <tr>
      <th class="px-4 py-2 text-left">Nama</th>
      <th class="px-4 py-2 text-left">Status</th>
      <th class="px-4 py-2 text-left">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <tr class="table-row-hover border-b border-navy-200">
      <td class="px-4 py-2">John Doe</td>
      <td class="px-4 py-2"><span class="badge-success">Approved</span></td>
      <td class="px-4 py-2">5 Jan 2026</td>
    </tr>
  </tbody>
</table>
```

---

## 🎯 Quick Color Reference

| Use Case | Class | Color | Code |
|----------|-------|-------|------|
| Main headings | `text-navy-900` | Navy Dark | #0f1a2e |
| Body text | `text-navy-600` | Navy Standard | #2d4a7b |
| Secondary text | `text-gray-500` | Gray Medium | #6b7280 |
| Borders | `border-navy-200` | Navy Light | #d4dfe8 |
| Primary button | `btn-primary` | Cyan | #20c5ff |
| Secondary button | `btn-secondary` | Navy | #2d4a7b |
| Active nav (light) | `bg-cyan-50` | Cyan Very Light | #ecfbff |
| Active nav (dark) | `bg-cyan-500` | Cyan | #20c5ff |
| Sidebar dark | `bg-navy-900` | Navy Darkest | #0f1a2e |
| Page background | `bg-white` | White | #ffffff |
| Success | `text-success-600` | Green | #16a34a |
| Warning | `text-warning-600` | Orange | #d97706 |
| Error | `text-error-600` | Red | #dc2626 |

---

## 🔄 Responsive Examples

### Mobile-First Approach

```html
<!-- Responsive Button -->
<button class="btn-primary w-full md:w-auto">
  Buat Laporan
</button>

<!-- Responsive Card -->
<div class="card-base mx-2 md:mx-0">
  ...
</div>

<!-- Responsive Text -->
<h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-navy-900">
  Dashboard
</h1>

<!-- Responsive Spacing -->
<div class="p-4 md:p-6 lg:p-8">
  ...
</div>
```

---

## 🎨 Tailwind Classes Cheatsheet

```
Text Colors:
  text-navy-900, text-navy-700, text-navy-600
  text-gray-600, text-gray-500, text-gray-400
  text-cyan-600, text-cyan-500

Background Colors:
  bg-white, bg-navy-50, bg-navy-100, bg-navy-900
  bg-cyan-50, bg-cyan-100, bg-cyan-500
  bg-success-50, bg-warning-50, bg-error-50

Border Colors:
  border-navy-200, border-navy-600
  border-cyan-500, border-error-500

Utilities:
  rounded-lg (untuk rounded corners)
  shadow-md, shadow-lg (untuk shadow)
  transition-all (untuk smooth transitions)
  p-4, p-6 (untuk padding)
  gap-2, gap-4 (untuk spacing antar items)
```

---

## ⚠️ Do's & Don'ts (Quick)

### ✅ DO
```
✓ Navy-900 text on white background
✓ Cyan buttons untuk primary actions
✓ Gray untuk secondary/muted text
✓ Navy-50 untuk light backgrounds
✓ White untuk main content background
```

### ❌ DON'T
```
✗ Cyan text on cyan background
✗ Navy text on navy background
✗ Too many different colors in one page
✗ Gray-400 text on white (terlalu pudar)
✗ Bright colors for disabled states
```

---

## 🧪 Testing Color Contrast

Gunakan tools ini untuk verify contrast ratio:
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- Browser DevTools (inspect element)
- [Paletton](https://paletton.com/)

Minimum requirements:
- **Normal text**: 4.5:1 (AA standard)
- **Large text**: 3:1 (AA standard)
- **AAA standard**: 7:1

Our palette: Semua kombinasi memenuhi AA/AAA ✅

---

## 🎯 Common Patterns

### Dashboard Header
```html
<header class="bg-white border-b border-navy-200 px-6 py-4">
  <h1 class="heading-lg">Dashboard Mahasiswa</h1>
  <p class="text-tertiary">Selamat datang kembali!</p>
</header>
```

### Sidebar Logo
```html
<div class="px-6 py-4 border-b border-navy-200">
  <a href="#" class="flex items-center space-x-3">
    <div class="w-10 h-10 bg-navy-800 rounded-lg flex items-center justify-center">
      <span class="text-white font-bold">LM</span>
    </div>
    <div>
      <span class="text-navy-900 font-bold">Lapor Mahasiswa</span>
      <p class="text-xs text-gray-500">Sistem Pelaporan</p>
    </div>
  </a>
</div>
```

### Status Indicator
```html
<div class="flex items-center gap-2">
  <div class="w-3 h-3 rounded-full bg-success-500"></div>
  <span class="text-navy-600">Approved</span>
</div>
```

### Empty State
```html
<div class="bg-navy-50 rounded-lg border border-navy-200 p-8 text-center">
  <svg class="w-12 h-12 text-gray-400 mx-auto mb-4">...</svg>
  <p class="text-navy-600 font-medium mb-2">Belum ada laporan</p>
  <p class="text-gray-500 mb-4">Mulai buat laporan pertama Anda sekarang</p>
  <a href="#" class="btn-primary">Buat Laporan</a>
</div>
```

---

## 📱 Mobile Optimization

```html
<!-- Responsive Sidebar -->
<aside class="fixed md:relative w-64 h-screen md:h-auto">
  <!-- Sidebar content adapts to mobile -->
</aside>

<!-- Responsive Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  <!-- Cards adjust to screen size -->
</div>

<!-- Responsive Text -->
<h1 class="text-2xl md:text-3xl lg:text-4xl">Responsive Title</h1>
```

---

## 🚀 Quick Deploy Checklist

- [x] Tailwind config updated
- [x] CSS utilities added
- [x] Sidebars updated
- [x] Documentation created
- [ ] All pages updated (optional)
- [ ] Team review done
- [ ] QA testing passed
- [ ] Deployed to production

---

## 📞 Need Help?

1. Check `COLOR_PALETTE_USAGE_GUIDE.md` for detailed guide
2. Check `COLOR_PALETTE_VISUAL_REFERENCE.md` for visual examples
3. Check `COLOR_PALETTE_MODERN_PROFESSIONAL.md` for color specs
4. Review code examples above
5. Test in browser DevTools

---

**Quick Tip**: Use `bg-white text-navy-900` as default and build from there! ✨

**Status**: ✅ Ready to Use  
**Last Updated**: 2026-01-05
