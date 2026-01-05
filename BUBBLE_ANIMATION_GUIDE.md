# 🫧 Bubble Animation Effect
## Dokumentasi Lengkap Animasi Gelembung pada Button

---

## 📚 Daftar Isi
1. [Overview](#overview)
2. [Cara Kerja](#cara-kerja)
3. [Implementasi](#implementasi)
4. [Customization](#customization)
5. [JavaScript API](#javascript-api)

---

## 🎬 Overview

### Apa itu Bubble Animation?
Animasi gelembung yang muncul saat user menekan button. Efeknya:
1. **Main Bubble**: Gelembung utama yang meledak dari posisi klik
2. **Burst Bubbles**: 4 gelembung tambahan yang melesat ke berbagai arah
3. **Duration**: 0.6-0.8 detik per animasi
4. **Effect**: Modern, playful, dan engaging

### Kapan Digunakan?
- Semua jenis button (primary, secondary, outline)
- Form submission buttons
- CTA (Call To Action) buttons
- Interactive elements

### Browser Support
✅ Chrome 90+  
✅ Firefox 88+  
✅ Safari 14+  
✅ Edge 90+  
✅ Mobile browsers

---

## 🎯 Cara Kerja

### Step-by-Step Flow
```
1. User klik button
   ↓
2. Click event terdeteksi
   ↓
3. Hitung posisi klik (x, y)
   ↓
4. Tentukan tipe button (primary/secondary/outline)
   ↓
5. Buat main bubble di posisi klik
   ↓
6. Trigger animasi "bubblePop" (meledak ke tengah)
   ↓
7. Dengan delay 50ms, buat 4 burst bubbles
   ↓
8. Trigger animasi "burst-1,2,3,4" (meledak ke arah berbeda)
   ↓
9. Animasi selesai (0.6-0.8 detik)
   ↓
10. Remove bubbles dari DOM
```

### Animasi yang Tersedia

#### 1. **bubblePop** (Main Bubble)
```css
@keyframes bubblePop {
    0% { width: 0; height: 0; opacity: 1; }
    100% { width: 100px; height: 100px; opacity: 0; }
}
```
- Duration: 0.6s
- Easing: ease-out
- Ukuran: 0 → 100px

#### 2. **bubble1, bubble2, bubble3, bubble4** (Burst Bubbles)
```css
@keyframes bubble1 {
    0% { width: 0; height: 0; opacity: 0.8; }
    100% { 
        width: 60px; height: 60px; 
        opacity: 0; 
        transform: translate(-30px, -50px); 
    }
}
```
- Duration: 0.6s
- Easing: ease-out
- Arah: Ke berbagai sudut
- Dengan stagger: 50ms delay antara setiap bubble

---

## 💻 Implementasi

### Automatic (Default Behavior)
Bubble effect **otomatis aktif** pada semua button:

```html
<!-- Semua button ini akan punya bubble effect -->
<button class="btn-primary">Buat Laporan</button>
<button class="btn-secondary">Lihat Laporan</button>
<a href="#" class="btn-outline">Download</a>
<input type="submit" value="Submit" class="btn-primary">
```

**Tidak perlu setup tambahan!** Bubble effect sudah berjalan otomatis.

### Manual Enable untuk Dynamic Buttons
Jika button dibuat secara dinamis via JavaScript:

```javascript
// Buat button secara dinamis
const button = document.createElement('button');
button.className = 'btn-primary';
button.textContent = 'New Button';
document.body.appendChild(button);

// Enable bubble effect
window.enableBubbleEffect(button);
```

---

## 🎨 Customization

### Warna Bubble Sesuai Button Type

#### Primary Button
```html
<button class="btn-primary">Click me</button>
<!-- Bubble: white dengan opacity 0.4 -->
```

#### Secondary Button
```html
<button class="btn-secondary">Click me</button>
<!-- Bubble: white dengan opacity 0.4 -->
```

#### Outline Button
```html
<button class="btn-outline">Click me</button>
<!-- Bubble: navy-800 dengan opacity 0.2 -->
```

### Customize CSS

Untuk mengubah durasi animasi:
```css
.bubble.animate {
    animation: bubblePop 0.8s ease-out forwards; /* Change 0.6s to 0.8s */
}

.bubble.burst-1,
.bubble.burst-2,
.bubble.burst-3,
.bubble.burst-4 {
    animation-duration: 0.8s; /* Slower animation */
}
```

Untuk mengubah ukuran bubble:
```css
@keyframes bubblePop {
    0% { width: 0; height: 0; }
    100% { width: 150px; height: 150px; } /* Bigger bubble */
}
```

Untuk mengubah warna bubble:
```css
.bubble.primary {
    background: rgba(255, 255, 255, 0.6); /* More opaque */
}

.bubble.secondary {
    background: rgba(59, 130, 246, 0.3); /* Blue bubble */
}
```

---

## 🔧 JavaScript API

### Events

#### Global Click Handler
Otomatis mendeteksi semua clicks pada buttons:

```javascript
// Sudah implemented di AdvancedAnimations class
// Tidak perlu setup tambahan
```

### Methods

#### Enable Bubble untuk Dynamic Elements
```javascript
window.enableBubbleEffect(element);
```

**Contoh**:
```javascript
// Dynamically created button
const newButton = document.createElement('button');
newButton.className = 'btn-primary';
newButton.textContent = 'Dynamic Button';
document.body.appendChild(newButton);

// Enable bubble
window.enableBubbleEffect(newButton);
```

#### Manual Bubble Creation
Jika ingin trigger bubble secara manual:

```javascript
const button = document.querySelector('.btn-primary');
const event = new MouseEvent('click', {
    clientX: 100,
    clientY: 50,
    bubbles: true
});
button.dispatchEvent(event);
```

---

## 📝 Code Examples

### Example 1: Basic Usage
```html
<!-- HTML -->
<div class="flex gap-4">
    <button class="btn-primary">Buat Laporan</button>
    <button class="btn-secondary">Lihat Semua</button>
    <button class="btn-outline">Cancel</button>
</div>

<!-- Bubble effect otomatis bekerja! -->
```

### Example 2: Form dengan Bubble
```html
<form @submit.prevent="submitReport">
    <input type="text" placeholder="Judul Laporan">
    <textarea placeholder="Deskripsi"></textarea>
    
    <!-- Button akan punya bubble effect -->
    <button type="submit" class="btn-primary">
        Kirim Laporan
    </button>
</form>
```

### Example 3: Dynamic Button dengan Bubble
```javascript
function addNewButton() {
    const container = document.getElementById('buttons-container');
    
    const button = document.createElement('button');
    button.className = 'btn-primary';
    button.textContent = 'New Action';
    button.onclick = () => console.log('Clicked!');
    
    container.appendChild(button);
    
    // Enable bubble effect
    window.enableBubbleEffect(button);
}

// Panggil function
addNewButton();
```

### Example 4: Multiple Bubbles Style
```html
<!-- Primary button dengan bubble -->
<button class="btn-primary">Primary Action</button>

<!-- Secondary button dengan bubble -->
<button class="btn-secondary">Secondary Action</button>

<!-- Outline button dengan bubble berbeda warna -->
<button class="btn-outline">Outline Action</button>

<!-- CTA button dengan bubble -->
<button class="btn-cta">Start Now</button>
```

---

## 🎬 Animation Timeline

### Single Click Bubble Timeline
```
Time:    0ms     50ms    100ms   150ms   200ms   250ms   300ms   350ms   400ms   450ms   500ms   550ms   600ms   650ms   700ms   750ms   800ms
         |-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|-------|
Main B:  ████████████████████████████████████████████████████████████████ (bubblePop)
Burst1:                  ████████████████████████████████████████████████ (bubble1)
Burst2:                              ████████████████████████████████████████ (bubble2)
Burst3:                                          ████████████████████████████████ (bubble3)
Burst4:                                                      ████████████████████ (bubble4)

████ = Animasi sedang berjalan
```

---

## ⚡ Performance Tips

### Optimization
1. **Automatic Cleanup**: Bubbles otomatis dihapus setelah 800ms
2. **GPU Acceleration**: Menggunakan `transform` untuk smooth animation
3. **Pointer Events**: Bubbles tidak intercept clicks (`pointer-events: none`)

### Memory Usage
- Per click: 5 bubble elements (1 main + 4 burst)
- Lifetime: 800ms
- Auto cleanup: Yes
- Memory leak: No

---

## 🐛 Troubleshooting

### Bubble tidak muncul
**Solution**: Pastikan button memiliki `position: relative` (sudah di-set di `.btn-* styles`)

```css
button {
    position: relative; /* PENTING! */
    overflow: hidden;   /* PENTING! */
}
```

### Bubble keluar dari button
**Solution**: Gunakan `overflow: hidden` pada button

```css
button {
    overflow: hidden; /* Clip bubbles di dalam button */
}
```

### Animasi terlalu cepat/lambat
**Solution**: Ubah duration di CSS

```css
.bubble.animate {
    animation-duration: 0.4s; /* Faster */
    /* atau */
    animation-duration: 1s;   /* Slower */
}
```

### Warna bubble tidak sesuai
**Solution**: Pastikan element memiliki class yang benar

```javascript
// Check class
console.log(button.classList);

// Pastikan ada btn-primary, btn-secondary, atau btn-outline
```

---

## 📊 Browser Compatibility

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| iOS Safari | 14+ | ✅ Full |
| Android Chrome | 90+ | ✅ Full |
| IE 11 | - | ❌ Not supported |

---

## 🎨 Styling Reference

### CSS Classes
```css
.bubble              /* Base bubble element */
.bubble.primary     /* Bubble untuk primary button */
.bubble.secondary   /* Bubble untuk secondary button */
.bubble.outline     /* Bubble untuk outline button */
.bubble.animate     /* Main bubble animation */
.bubble.burst-1     /* Burst animation 1 */
.bubble.burst-2     /* Burst animation 2 */
.bubble.burst-3     /* Burst animation 3 */
.bubble.burst-4     /* Burst animation 4 */
.bubble.float       /* Floating bubble animation */
```

### HTML Structure Saat Click
```html
<button class="btn-primary">
    Click me
    <span class="bubble primary animate"></span>
    <!-- Burst bubbles akan ditambah dengan delay -->
    <span class="bubble primary burst-1"></span>
    <span class="bubble primary burst-2"></span>
    <span class="bubble primary burst-3"></span>
    <span class="bubble primary burst-4"></span>
</button>
```

---

## 🚀 Advanced Usage

### Custom Bubble Effect untuk Specific Button
```html
<button class="btn-primary custom-bubble" data-bubble="true">
    Special Button
</button>

<script>
document.querySelector('.custom-bubble').addEventListener('click', (e) => {
    // Custom logic here
    console.log('Special button clicked!');
});
</script>
```

### Combine dengan Notification
```javascript
function submitWithBubble() {
    const button = document.querySelector('.btn-primary');
    
    // Trigger bubble via click event
    button.click();
    
    // Show notification setelah bubble animation
    setTimeout(() => {
        window.showAnimatedNotification('Report submitted!', 'success');
    }, 800);
}
```

---

## 📞 Support & Questions

Untuk pertanyaan tentang bubble animation, lihat:
1. [ADVANCED_ANIMATIONS_2026.md](ADVANCED_ANIMATIONS_2026.md)
2. [ANIMATIONS_BEST_PRACTICES.md](ANIMATIONS_BEST_PRACTICES.md)
3. File ini untuk reference lengkap

---

**Created**: January 5, 2026  
**Version**: 1.0  
**Status**: ✅ Production Ready
