# 🎬 Animation Utilities & Effects Guide

Panduan lengkap untuk menggunakan animasi modern yang telah diintegrasikan ke dalam aplikasi Lapor Mahasiswa.

---

## 🎯 Built-in Animations

### 1. **Shimmer Animation**
Efek kilau yang elegan pada button atau elemen.

**Property:** `animate-shimmer`  
**Durasi:** 0.5s  
**Easing:** ease-in

**Implementasi:**
```html
<button class="animate-shimmer">Shimmer Effect</button>
<div class="animate-shimmer">Shimmering Element</div>
```

**Use Case:**
- Loading states
- Highlight effect
- Attention grabbing

---

### 2. **Ripple Animation**
Efek riak modern seperti Material Design.

**Property:** `animate-ripple`  
**Durasi:** 0.6s  
**Easing:** ease-out

**Implementasi:**
```html
<button class="animate-ripple">Ripple Effect</button>
```

**Use Case:**
- Button click effects (sudah built-in di .btn-* classes)
- Interactive feedback

---

### 3. **Slide Up Animation**
Animasi masuk dari bawah.

**Property:** `animate-slide-up`  
**Durasi:** 0.4s  
**Easing:** ease-out

**Implementasi:**
```html
<div class="animate-slide-up">Content slides up on appear</div>
```

**Use Case:**
- Modal/dialog opening
- Content reveal
- Page transitions

---

### 4. **Glow Animation**
Efek cahaya berkelip yang menarik perhatian.

**Property:** `animate-glow`  
**Durasi:** 2s (infinite)  
**Easing:** ease-in-out

**Implementasi:**
```html
<button class="animate-glow bg-accent-500">Glowing Button</button>
<div class="animate-glow">Important Element</div>
```

**Use Case:**
- Featured elements
- Active status indicators
- Call-to-action highlights

---

### 5. **Bounce In Animation**
Efek masuk dengan bounce untuk perhatian maksimal.

**Property:** `animate-bounce-in`  
**Durasi:** 0.6s  
**Easing:** cubic-bezier(0.34, 1.56, 0.64, 1)

**Implementasi:**
```html
<h1 class="animate-bounce-in">Bouncing Heading</h1>
<div class="animate-bounce-in">Bouncy Content</div>
```

**Use Case:**
- Heading on page load
- Important announcements
- Success messages

---

### 6. **Pulse Ring Animation**
Efek pulse yang terus menerus untuk status/notifikasi.

**Property:** `animate-pulse-ring`  
**Durasi:** 2s (infinite)  
**Easing:** ease-out

**Implementasi:**
```html
<div class="animate-pulse-ring">Pulsing Indicator</div>
<span class="animate-pulse-ring">Live Status</span>
```

**Use Case:**
- Live indicators
- Recording status
- Active connections
- Notification badges

---

## 🎨 Combining Animations

Kombinasikan animasi dengan Tailwind utilities:

```html
<!-- Glow + Text animation -->
<h2 class="animate-bounce-in">
    <span class="animate-glow">Featured Section</span>
</h2>

<!-- Multiple animations -->
<div class="animate-slide-up">
    <button class="btn-secondary animate-glow">
        Call to Action
    </button>
</div>

<!-- Responsive animations -->
<div class="hidden md:block animate-pulse-ring">
    Desktop only animation
</div>
```

---

## 🎬 Advanced: Custom Animation Timing

Ubah timing menggunakan inline style atau custom class:

```html
<!-- Slower animation -->
<div class="animate-glow" style="animation-duration: 3s;">
    Slower Glow
</div>

<!-- Faster animation -->
<div class="animate-bounce-in" style="animation-duration: 0.3s;">
    Fast Bounce
</div>

<!-- Add delay -->
<div class="animate-slide-up" style="animation-delay: 0.5s;">
    Delayed Slide
</div>
```

---

## 🎯 Common Patterns

### Loading Spinner with Shimmer
```html
<div class="flex items-center space-x-2 animate-shimmer">
    <div class="w-2 h-2 bg-accent-500 rounded-full animate-pulse"></div>
    <span>Loading...</span>
</div>
```

### Attention Grabbing Button
```html
<button class="btn-secondary animate-glow">
    🎯 Important Action
</button>
```

### Success Message
```html
<div class="animate-slide-up animate-bounce-in">
    ✅ Success! Your report has been submitted.
</div>
```

### Featured Card
```html
<div class="card animate-slide-up">
    <div class="animate-glow">Featured Content</div>
</div>
```

### Live Status Indicator
```html
<div class="flex items-center space-x-2">
    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse-ring"></span>
    <span>Status: Online</span>
</div>
```

---

## ⚙️ Configuration

Semua animasi didefinisikan di `resources/css/app.css`:

```css
@keyframes shimmer {
    0% { /* start state */ }
    100% { /* end state */ }
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* dll... */
```

Untuk mengedit animasi, ubah nilai dalam `@keyframes`:

```css
@keyframes ripple {
    to {
        transform: scale(5);    /* ubah dari 4 ke 5 */
        opacity: 0;
    }
}
```

Atau ubah timing di Tailwind config:

```javascript
// tailwind.config.js
animation: {
    'glow': 'glow 3s ease-in-out infinite',  // ubah 2s jadi 3s
}
```

---

## 🎯 Performance Tips

1. **Hindari animasi berlebihan**
   ```html
   <!-- ✅ Baik -->
   <button class="btn-primary">Click me</button>
   
   <!-- ❌ Berlebihan -->
   <button class="animate-glow animate-bounce-in animate-shimmer">Too Much</button>
   ```

2. **Gunakan `will-change` untuk smooth animation**
   ```html
   <div class="animate-glow will-change-auto">Smooth Glow</div>
   ```

3. **Hati-hati dengan infinite animation**
   ```html
   <!-- ✅ Baik untuk notifikasi penting -->
   <div class="animate-glow">Important</div>
   
   <!-- ❌ Terlalu banyak bisa mengganggu -->
   <div class="animate-glow animate-pulse-ring">Too Flashy</div>
   ```

---

## 📱 Responsive Animations

```html
<!-- Animation hanya di desktop -->
<div class="hidden md:block animate-glow">
    Desktop Animation
</div>

<!-- Different animation per breakpoint -->
<div class="animate-slide-up md:animate-bounce-in">
    Different on mobile/desktop
</div>

<!-- No animation on mobile -->
<div class="animate-glow md:animate-glow lg:animate-glow">
    Keep smooth on mobile
</div>
```

---

## 🚀 Best Practices

### ✅ DO:
- Gunakan animasi untuk feedback interaktif
- Gunakan glow untuk highlight elemen penting
- Gunakan slide-up untuk reveal content
- Gunakan bounce-in untuk attention grabbing
- Test pada perangkat dengan performa rendah

### ❌ DON'T:
- Jangan gunakan banyak infinite animation sekaligus
- Jangan override default button animations tanpa alasan
- Jangan gunakan animasi pada background yang sudah animated
- Jangan gunakan 10+ animasi dalam satu page
- Jangan animasi setiap elemen

---

## 🔧 Troubleshooting

### Animasi tidak terlihat?
1. Periksa apakah CSS sudah di-build: `npm run build`
2. Clear browser cache: `Ctrl + Shift + Delete`
3. Pastikan class name benar: `animate-glow` bukan `animate-gloow`

### Animasi terlalu cepat/lambat?
1. Ubah nilai di Tailwind config
2. Atau gunakan inline style: `style="animation-duration: 3s;"`

### Ripple effect tidak bekerja?
- Ripple hanya work di `.btn-*` classes
- Untuk element lain, gunakan `.animate-shimmer`

---

## 📚 References

- **Button Animations:** `resources/css/app.css`
- **Tailwind Config:** `tailwind.config.js`
- **Usage Examples:** `BUTTON_ANIMATIONS.md`

---

**Last Updated:** 5 Januari 2026  
**Version:** 1.0  
**Status:** ✅ Production Ready
