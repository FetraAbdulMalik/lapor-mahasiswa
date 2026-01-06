# 🎨 Dokumentasi Lengkap Animasi Lapor Mahasiswa

## Daftar Isi
1. [Bubble Animations](#bubble-animations)
2. [Button Animations](#button-animations)
3. [Text & Fade Animations](#text--fade-animations)
4. [Utility Animations](#utility-animations)
5. [Tailwind Extended Animations](#tailwind-extended-animations)

---

## 🫧 Bubble Animations

### 1. **Bubble Pop** (Gelembung Meledak)
```css
@keyframes bubblePop {
    0% {
        width: 0;
        height: 0;
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 1;
    }
    100% {
        width: 100px;
        height: 100px;
        opacity: 0;
        transform: translate(-50%, -50%) scale(1);
    }
}
```
**Keterangan**: Gelembung membesar dari 0 dan meledak/menghilang dengan opacity 0.

---

### 2. **Bubble 1** (Gelembung ke Kiri Atas)
```css
@keyframes bubble1 {
    0% {
        width: 0;
        height: 0;
        opacity: 0.8;
        transform: translate(0, 0) scale(1);
    }
    100% {
        width: 60px;
        height: 60px;
        opacity: 0;
        transform: translate(-30px, -50px) scale(0.5);
        /* Bergerak ke kiri dan atas */
    }
}
```
**Keterangan**: Gelembung terbang ke arah kiri atas sambil mengecil.

---

### 3. **Bubble 2** (Gelembung ke Kanan Atas)
```css
@keyframes bubble2 {
    0% {
        width: 0;
        height: 0;
        opacity: 0.8;
        transform: translate(0, 0) scale(1);
    }
    100% {
        width: 50px;
        height: 50px;
        opacity: 0;
        transform: translate(30px, -40px) scale(0.5);
        /* Bergerak ke kanan dan atas */
    }
}
```
**Keterangan**: Gelembung terbang ke arah kanan atas sambil mengecil.

---

### 4. **Bubble 3** (Gelembung ke Bawah Kiri)
```css
@keyframes bubble3 {
    0% {
        width: 0;
        height: 0;
        opacity: 0.8;
        transform: translate(0, 0) scale(1);
    }
    100% {
        width: 45px;
        height: 45px;
        opacity: 0;
        transform: translate(-10px, 40px) scale(0.5);
        /* Bergerak ke kiri dan bawah */
    }
}
```
**Keterangan**: Gelembung terbang ke arah kiri bawah sambil mengecil.

---

### 5. **Bubble 4** (Gelembung ke Kanan Bawah)
```css
@keyframes bubble4 {
    0% {
        width: 0;
        height: 0;
        opacity: 0.8;
        transform: translate(0, 0) scale(1);
    }
    100% {
        width: 55px;
        height: 55px;
        opacity: 0;
        transform: translate(40px, 30px) scale(0.5);
        /* Bergerak ke kanan dan bawah */
    }
}
```
**Keterangan**: Gelembung terbang ke arah kanan bawah sambil mengecil.

---

### 6. **Bubble Float** (Gelembung Melayang)
```css
@keyframes bubbleFloat {
    0% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    100% {
        opacity: 0;
        transform: translateY(-80px) scale(0.3);
        /* Melayang ke atas */
    }
}
```
**Keterangan**: Gelembung melayang ke atas sambil menghilang opacity.

---

## 🔘 Button Animations

### 1. **Shimmer** (Efek Berkilau)
```css
@keyframes shimmer {
    0% {
        box-shadow: inset 0 0 0 0 rgba(255, 255, 255, 0.5);
    }
    100% {
        box-shadow: inset 0 0 0 100px rgba(255, 255, 255, 0);
    }
}
```
**Keterangan**: Cahaya bergerak melintasi tombol dari kiri ke kanan.

---

### 2. **Ripple** (Efek Riak)
```css
@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
```
**Keterangan**: Gelombang melebar dari titik klik dengan opacity menghilang.

---

### 3. **Glow** (Bersinar)
```css
@keyframes glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(14, 165, 233, 0.3), 
                    0 0 20px rgba(14, 165, 233, 0.1);
    }
    50% {
        box-shadow: 0 0 10px rgba(14, 165, 233, 0.5), 
                    0 0 30px rgba(14, 165, 233, 0.2);
    }
}
```
**Keterangan**: Cahaya bersinar dan memburam secara berulang pada elemen.

---

### 4. **Pulse Ring** (Cincin Berdenyut)
```css
@keyframes pulse-ring {
    0% {
        box-shadow: 0 0 0 0 rgba(30, 41, 59, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(30, 41, 59, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(30, 41, 59, 0);
    }
}
```
**Keterangan**: Cincin melebar dan menghilang secara berulang.

---

## ✨ Text & Fade Animations

### 1. **Fade In** (Muncul Perlahan)
```css
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn forwards;
}
```
**Keterangan**: Elemen muncul dari bawah dengan transparency berubah menjadi solid.

---

### 2. **Bounce In** (Melompat Masuk)
```css
@keyframes bounce-in {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
```
**Keterangan**: Elemen melompat masuk dengan efek bounce di tengah.

---

### 3. **Slide Up** (Geser Ke Atas)
```css
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```
**Keterangan**: Elemen bergeser dari bawah ke atas sambil muncul.

---

### 4. **Shake** (Goyang/Guncang)
```css
@keyframes shake {
    0%, 100% { 
        transform: translateX(0); 
    }
    25% { 
        transform: translateX(-5px); 
    }
    75% { 
        transform: translateX(5px); 
    }
}

.animate-shake {
    animation: shake 0.4s ease-in-out;
}
```
**Keterangan**: Elemen berguncang kiri-kanan (digunakan untuk error message).

---

## 🎯 Utility Animations

### 1. **Pulse** (Detak)
Bawaan Tailwind CSS yang membuat elemen berdenyut.
```html
<div class="animate-pulse"></div>
```

---

### 2. **Spin** (Berputar)
Bawaan Tailwind CSS yang membuat elemen berputar.
```html
<svg class="animate-spin"></svg>
```

---

### 3. **Bounce** (Lompat)
Bawaan Tailwind CSS yang membuat elemen melompat.
```html
<div class="animate-bounce"></div>
```

---

## 🎨 Tailwind Extended Animations

File: `tailwind.config.js`

### Extended Animations
```javascript
extend: {
  animation: {
    'fade-in': 'fadeIn 0.5s ease-out forwards',
    'bounce-in': 'bounce-in 0.6s ease-out',
    'slide-up': 'slideUp 0.4s ease-out',
    'pulse-ring': 'pulse-ring 1.5s ease-out infinite',
    'glow': 'glow 2s ease-in-out infinite',
    'shimmer': 'shimmer 2s infinite',
    'shake': 'shake 0.4s ease-in-out',
  }
}
```

---

## 🎬 Penggunaan di Blade Template

### Menggunakan Animasi Bubble
```html
<!-- Hero Section dengan Bubble -->
<div class="relative overflow-hidden h-96">
    <div class="bubble bubble-1" style="animation: bubble1 1s ease-out forwards;"></div>
    <div class="bubble bubble-2" style="animation: bubble2 1.2s ease-out forwards;"></div>
    <div class="bubble bubble-3" style="animation: bubble3 1.4s ease-out forwards;"></div>
    <div class="bubble bubble-4" style="animation: bubble4 1.6s ease-out forwards;"></div>
</div>
```

### CSS untuk Bubble
```css
.bubble {
    position: absolute;
    border-radius: 50%;
    background: rgba(45, 74, 123, 0.3);
    border: 2px solid rgba(45, 74, 123, 0.5);
}

.bubble-1 { width: 60px; height: 60px; top: 50%; left: 50%; }
.bubble-2 { width: 50px; height: 50px; top: 60%; left: 40%; }
.bubble-3 { width: 45px; height: 45px; top: 40%; left: 60%; }
.bubble-4 { width: 55px; height: 55px; top: 50%; left: 55%; }
```

### Menggunakan Animasi Text
```html
<!-- Fade In Text -->
<h1 class="animate-fade-in">Judul dengan Fade In</h1>

<!-- Bounce In Text -->
<p class="animate-bounce-in">Teks dengan Bounce In</p>

<!-- Slide Up Text -->
<div class="animate-slide-up">Konten dengan Slide Up</div>

<!-- Shake untuk Error -->
<p class="animate-shake text-red-600">Pesan Error</p>
```

### Menggunakan Animasi Button
```html
<!-- Button dengan Glow -->
<button class="btn-primary animate-glow">Klik Saya</button>

<!-- Button dengan Pulse Ring -->
<button class="btn-secondary animate-pulse-ring">Daftar Sekarang</button>

<!-- Loading dengan Spin -->
<svg class="w-5 h-5 animate-spin"></svg>
```

---

## 📍 Lokasi File Animasi

```
resources/
├── css/
│   └── app.css (Semua @keyframes CSS)
├── js/
│   └── app.js
└── views/
    ├── welcome.blade.php (Bubble animations)
    ├── pages/
    │   ├── about.blade.php
    │   ├── faq.blade.php
    │   └── statistics.blade.php
    └── student/
        └── reports/
            ├── create.blade.php (Animasi form)
            └── edit.blade.php

tailwind.config.js (Extended animations config)
```

---

## 🎭 Tips Menggunakan Animasi

### 1. **Kombinasi Animasi**
```html
<!-- Glow + Shimmer -->
<button class="animate-glow animate-shimmer">Kombinasi</button>
```

### 2. **Custom Duration**
```html
<!-- Fade In dengan durasi custom -->
<div style="animation: fadeIn 2s ease-out forwards;">
    Durasi 2 detik
</div>
```

### 3. **Delay Animasi**
```html
<!-- Staggered Animation -->
<div class="animate-fade-in" style="animation-delay: 0s;">Item 1</div>
<div class="animate-fade-in" style="animation-delay: 0.1s;">Item 2</div>
<div class="animate-fade-in" style="animation-delay: 0.2s;">Item 3</div>
```

### 4. **Infinite Animations**
```css
.animate-glow {
    animation: glow 2s ease-in-out infinite;
}
```

### 5. **Animation Fill Mode**
```css
.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
    /* forwards = tetap di state akhir */
    /* backwards = kembali ke state awal */
}
```

---

## 🔧 Performa Tips

✅ **Gunakan `transform` dan `opacity`** - Paling efisien
❌ Hindari animasi `width`, `height`, `left`, `top` - Heavy

---

**Last Updated**: January 6, 2026  
**Version**: 1.0
