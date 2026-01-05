# 🎯 Button Animations & Effects Guide

Aplikasi Lapor Mahasiswa memiliki sistem animasi button yang modern dan interaktif. Berikut adalah dokumentasi lengkapnya.

## 📚 Tipe-tipe Button

### 1. **Primary Button (.btn-primary)**
Button warna Navy dengan efek ripple yang elegan.

**Fitur:**
- 🔵 Warna Navy (#152d47)
- ✨ Ripple effect saat diklik
- 🎯 Scale down effect (95%) saat active
- 💫 Shadow enhancement pada hover
- 🎨 Smooth color transition

**Implementasi:**
```html
<a href="#" class="btn-primary">Primary Action</a>
<button class="btn-primary">Click Me</button>
```

**Styling:**
```css
.btn-primary {
    background: navy-700;
    transition: all 300ms ease-out;
    hover: shadow-lg, bg-navy-800;
    active: scale-95;
}
```

---

### 2. **Secondary Button (.btn-secondary)**
Button warna Cyan/Accent untuk aksi sekunder yang tetap penting.

**Fitur:**
- 🔷 Warna Cyan Terang (#0284c7)
- ✨ Ripple effect saat diklik
- 🎯 Scale down effect pada active
- 💫 Shadow enhancement pada hover
- 🌟 Gradient background option

**Implementasi:**
```html
<a href="#" class="btn-secondary">Register Now</a>
<button class="btn-secondary">Submit</button>
```

---

### 3. **Outline Button (.btn-outline)**
Button dengan border style untuk aksi tersier.

**Fitur:**
- 🔲 Border Navy 2px
- ✨ Ripple effect saat diklik
- 🎯 Background fill pada hover
- 💫 Shadow enhancement pada hover
- 🔄 Color transition smooth

**Implementasi:**
```html
<a href="#" class="btn-outline">Learn More</a>
<button class="btn-outline">Cancel</button>
```

---

### 4. **CTA Button (.btn-cta)**
Call-to-Action button dengan perhatian maksimal.

**Fitur:**
- 🌈 Gradient background (cyan-500 → cyan-600)
- ✨ Enhanced ripple effect
- 💥 Stronger shadow on hover
- 🎯 Prominent active state
- ⚡ Perfect untuk homepage CTA

**Implementasi:**
```html
<a href="#" class="btn-cta">Start Now</a>
<button class="btn-cta px-8 py-3">Get Started</button>
```

---

### 5. **Icon Button (.btn-icon)**
Button kecil untuk icon-only actions.

**Fitur:**
- ⭕ Circular shape (w-10 h-10)
- 🔵 Navy background
- ✨ Hover effects
- 🎯 Scale down on active (scale-90)
- 📱 Perfect untuk toolbar & compact UI

**Implementasi:**
```html
<button class="btn-icon">
    <svg class="w-5 h-5"><!-- icon --></svg>
</button>
```

---

### 6. **Small Button (.btn-sm)**
Button kecil untuk aksi minor.

**Fitur:**
- 📏 Smaller padding (px-3 py-1)
- 📝 Smaller text (text-sm)
- ✨ All animations applied
- 🎯 Active scale 95%

**Implementasi:**
```html
<a href="#" class="btn-sm btn-primary">Small</a>
<button class="btn-sm btn-outline">Kecil</button>
```

---

### 7. **Large Button (.btn-lg)**
Button besar untuk aksi utama.

**Fitur:**
- 📏 Larger padding (px-8 py-3)
- 📝 Larger text (text-lg)
- ✨ All animations applied
- 🎯 More prominent active state

**Implementasi:**
```html
<a href="#" class="btn-lg btn-secondary">Large Button</a>
<button class="btn-lg btn-primary">Tombol Besar</button>
```

---

## ✨ Animation Details

### Ripple Effect
```
Saat tombol ditekan:
1. Lingkaran putih muncul di center button
2. Meluas dengan cepat ke seluruh tombol
3. Fade out setelah mencapai ukuran maksimal
```

**Durasi:** 600ms
**Easing:** ease-out

### Active State
```
Saat tombol dalam kondisi active/pressed:
1. Skala turun menjadi 95% (scale-95)
2. Shadow berkurang untuk efek "push down"
3. Ripple effect terlihat jelas
```

**Durasi:** 100ms
**Easing:** ease-out

### Hover State
```
Saat mouse mengarah ke tombol:
1. Warna background berubah lebih gelap
2. Shadow enhancement (shadow-lg)
3. Icon dalam button bisa scale up
```

**Durasi:** 300ms
**Easing:** ease-out

---

## 🎨 Color Variants

Gunakan kombinasi class untuk styling:

```html
<!-- Navy Primary -->
<button class="btn-primary">Navy Button</button>

<!-- Cyan Secondary -->
<button class="btn-secondary">Cyan Button</button>

<!-- Navy Outline -->
<button class="btn-outline">Outline Button</button>

<!-- Gradient CTA -->
<button class="btn-cta">CTA Button</button>
```

---

## 📱 Responsive Behavior

Semua button responsif dan bekerja baik pada:
- ✅ Desktop (hover effects aktif)
- ✅ Tablet (touch optimized)
- ✅ Mobile (touch-friendly sizing)

---

## 🚀 Advanced: Custom Button

Buat custom button dengan menggabungkan classes:

```html
<!-- Large Secondary CTA -->
<a href="#" class="btn-secondary btn-lg">
    <span class="flex items-center space-x-2">
        <svg class="w-6 h-6"><!-- icon --></svg>
        <span>Custom Button</span>
    </span>
</a>

<!-- Icon dengan text -->
<button class="btn-primary group">
    <span class="flex items-center space-x-2">
        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform">
            <!-- icon yang rotate on hover -->
        </svg>
        <span>Advanced Button</span>
    </span>
</button>
```

---

## 🎯 Best Practices

1. **Gunakan `.btn-primary` untuk aksi utama**
   ```html
   <a href="{{ route('submit') }}" class="btn-primary">Submit</a>
   ```

2. **Gunakan `.btn-secondary` untuk CTA penting**
   ```html
   <a href="{{ route('register') }}" class="btn-secondary">Sign Up</a>
   ```

3. **Gunakan `.btn-outline` untuk aksi sekunder**
   ```html
   <a href="{{ route('back') }}" class="btn-outline">Back</a>
   ```

4. **Kombinasikan dengan sizing**
   ```html
   <button class="btn-secondary btn-lg">Large Action</button>
   <button class="btn-primary btn-sm">Small Action</button>
   ```

5. **Tambahkan icon untuk clarity**
   ```html
   <button class="btn-primary group">
       <svg class="w-5 h-5 group-hover:scale-110 transition-transform"></svg>
       <span>Action</span>
   </button>
   ```

---

## 🔧 Customization

Edit `resources/css/app.css` untuk mengubah animasi:

```css
@keyframes ripple {
    to {
        transform: scale(4);      /* ubah ukuran ripple */
        opacity: 0;
    }
}

.btn-primary {
    transition: all 300ms ease-out;  /* ubah durasi */
    /* tambahkan custom styles */
}
```

---

## 📋 Checklist Implementasi

- ✅ Semua button menggunakan `.btn-*` classes
- ✅ Icon buttons menggunakan `.btn-icon`
- ✅ Sizing buttons menggunakan `.btn-sm` atau `.btn-lg`
- ✅ Focus states visible untuk accessibility
- ✅ Animations smooth dan tidak berlebihan
- ✅ Colors sesuai dengan palet warna (Navy & Cyan)

---

## 💡 Tips & Tricks

### 1. Icon Animation
```html
<button class="btn-primary group">
    <svg class="w-5 h-5 group-hover:scale-110 transition-transform"></svg>
</button>
```

### 2. Loading State
```html
<button class="btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
    Loading...
</button>
```

### 3. Button Group
```html
<div class="flex gap-2">
    <button class="btn-primary">Save</button>
    <button class="btn-outline">Cancel</button>
</div>
```

---

**Terakhir Updated:** 5 Januari 2026  
**Version:** 1.0  
**Status:** ✅ Production Ready
