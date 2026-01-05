# Advanced Animations untuk Dashboard 2026
## Panduan Lengkap 4 Fitur Animasi Modern

---

## 📚 Daftar Isi
1. [Scroll-Based Storytelling (Scrollytelling)](#1-scroll-based-storytelling)
2. [Micro-Interactions](#2-micro-interactions)
3. [Skeleton Loading](#3-skeleton-loading)
4. [Smooth Page Transitions](#4-smooth-page-transitions)

---

## 1. Scroll-Based Storytelling (Scrollytelling)

### ✨ Deskripsi
Animasi yang terpicu saat pengguna melakukan scrolling. Elemen akan fade-in, slide, atau scale ketika memasuki viewport, menciptakan pengalaman cerita yang dinamis.

### 🎯 Fitur Utama
- **Fade In & Up**: Elemen muncul dengan opacity transition
- **Slide Left/Right**: Elemen masuk dari samping
- **Scale In**: Elemen muncul dengan scale effect
- **Counter Animation**: Angka yang menghitung ke atas (0 → target)

### 📝 Class yang Tersedia
```html
<!-- Fade in with slide up -->
<div class="scroll-fade-in">Konten Anda</div>

<!-- Slide in dari kiri -->
<div class="scroll-slide-left">Konten Anda</div>

<!-- Slide in dari kanan -->
<div class="scroll-slide-right">Konten Anda</div>

<!-- Scale in dari kecil ke normal -->
<div class="scroll-scale-in">Konten Anda</div>

<!-- Counter animation untuk angka -->
<p class="stat-counter" data-target="150">0</p>
```

### 💡 Contoh Implementasi di Dashboard
```html
<!-- Statistics Cards dengan scroll animation -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="scroll-fade-in micro-card" data-observe-once="true">
        <p class="text-4xl font-bold stat-counter" data-target="25">0</p>
        <p>Total Laporan</p>
    </div>
    
    <div class="scroll-slide-left micro-card" data-observe-once="true">
        <p class="text-4xl font-bold stat-counter" data-target="12">0</p>
        <p>Menunggu Review</p>
    </div>
</div>

<!-- Recent Reports dengan staggered animation -->
<div data-stagger-list>
    <div class="stagger-item">Item 1</div>
    <div class="stagger-item">Item 2</div>
    <div class="stagger-item">Item 3</div>
</div>
```

### 🔧 JavaScript API
```javascript
// Observe elemen tertentu setelah load dynamic content
window.observeScrollAnimations([element1, element2, element3]);

// Animate counter manually
window.animateCounter(element, targetNumber, duration);
// Contoh: animateCounter(element, 150, 1500); // 1.5 detik

// Scroll to section dengan smooth
window.scrollToSection('sectionId', offset);
// Contoh: scrollToSection('reports', 80);
```

### ⚙️ Konfigurasi
- **Threshold**: 0.1 (10% elemen harus visible)
- **Duration**: 0.8s untuk scroll animations, 1.5s untuk counter
- **Easing**: ease-out untuk smooth feeling

---

## 2. Micro-Interactions

### ✨ Deskripsi
Animasi kecil dengan durasi pendek (200-300ms) yang memberikan feedback instan pada user actions. Membuat interface terasa lebih responsif dan modern.

### 🎯 Fitur Utama
- **Hover Effects**: Card lift up dengan shadow
- **Input Animations**: Underline yang bergerak saat focus
- **Button Feedback**: Tombol yang turun saat ditekan
- **Link Underlines**: Garis bawah yang muncul saat hover

### 📝 Class yang Tersedia

#### Card Hover
```html
<div class="micro-card">
    <!-- Akan lift up 4px saat hover -->
</div>
```

#### Button Micro-Interaction
```html
<button class="btn-micro">
    Klik Saya
    <!-- Akan turun 2px saat ditekan -->
</button>
```

#### Link Hover Underline
```html
<a href="#" class="link-hover">
    Hover untuk lihat underline animasi
</a>
```

#### Input Animated
```html
<input class="input-animated" type="text" placeholder="Ketik sesuatu">
<!-- Underline berwarna akan muncul saat focus -->
```

### 💡 Contoh Implementasi di Dashboard
```html
<!-- Card dengan micro-interaction -->
<div class="bg-white rounded-lg p-6 micro-card">
    <h3>Laporan Terbaru</h3>
    <p>Konten laporan</p>
</div>

<!-- Button dengan micro-interaction -->
<a href="/reports" class="btn-primary btn-micro">
    <svg class="w-4 h-4 ml-2">...</svg>
    Lihat Semua
</a>

<!-- Link dengan underline animation -->
<a href="#" class="text-blue-600 link-hover">
    Detail Laporan
</a>
```

### 🔧 Timing
- **Card Hover**: 0.25s
- **Button Press**: 0.1s saat mousedown, 0.25s saat mouseup
- **Input Focus**: 0.4s untuk underline
- **Link Hover**: 0.3s

### 📱 Mobile Friendly
Micro-interactions bekerja dengan:
- Touch events (auto-converted ke hover)
- Keyboard navigation (focus states)
- Accessibility features

---

## 3. Skeleton Loading

### ✨ Deskripsi
Menampilkan kerangka abu-abu yang berdenyut menyerupai struktur konten, bukan loading spinner tradisional. Modern, minimalis, dan tidak membuat mata lelah.

### 🎯 Fitur Utama
- **Pulsing Skeleton**: Animasi pulse yang smooth (2s cycle)
- **Contextual Shapes**: Skeleton sesuai dengan konten yang akan ditampilkan
- **Placeholder Text**: Multiple lines untuk paragraf
- **Report Card Skeleton**: Khusus untuk report items

### 📝 Class yang Tersedia
```html
<!-- Skeleton text -->
<div class="skeleton skeleton-text"></div>

<!-- Skeleton title -->
<div class="skeleton skeleton-title"></div>

<!-- Skeleton card container -->
<div class="skeleton-card">
    <div class="skeleton skeleton-title"></div>
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-text" style="width: 85%;"></div>
    <div class="skeleton skeleton-text" style="width: 70%;"></div>
</div>

<!-- Report skeleton -->
<div class="skeleton-report">
    <div class="skeleton-report-header">
        <div class="skeleton skeleton-report-badge"></div>
    </div>
    <div class="skeleton skeleton-text"></div>
    <div class="flex gap-3">
        <div class="skeleton skeleton-text" style="width: 40%;"></div>
        <div class="skeleton skeleton-text" style="width: 35%;"></div>
    </div>
</div>
```

### 🔧 JavaScript API
```javascript
// Show skeleton loading
window.showSkeletonLoading(containerElement, itemCount);
// Contoh: showSkeletonLoading(document.getElementById('reports'), 3);

// Show report-specific skeleton
window.showReportSkeleton(containerElement, itemCount);

// Hide skeleton (dengan fade out animation)
window.hideSkeletonLoading(containerElement);
```

### 💡 Contoh Implementasi
```javascript
// Saat fetch data dari API
async function loadReports() {
    const container = document.getElementById('reports-container');
    
    // Show skeleton
    window.showReportSkeleton(container, 3);
    
    try {
        const response = await fetch('/api/reports');
        const data = await response.json();
        
        // Hide skeleton
        window.hideSkeletonLoading(container);
        
        // Render actual content
        container.innerHTML = renderReports(data);
    } catch (error) {
        window.hideSkeletonLoading(container);
        console.error(error);
    }
}
```

### 🎨 Customization
```css
/* Ganti warna skeleton */
.skeleton {
    animation: skeleton-loading 2s infinite;
    background: linear-gradient(90deg, 
        #f0f0f0 25%, 
        #e0e0e0 50%, 
        #f0f0f0 75%);
    background-size: 200% 100%;
}

/* Ubah kecepatan animasi */
.skeleton {
    animation-duration: 3s; /* 3s instead of 2s */
}
```

---

## 4. Smooth Page Transitions

### ✨ Deskripsi
Transisi halus antar bagian/halaman untuk menjaga orientasi spasial pengguna. Menciptakan alur cerita yang koheren dan naratif.

### 🎯 Fitur Utama
- **Fade & Slide**: Section fade in dengan slide up effect
- **Staggered Lists**: Setiap item muncul dengan delay berbeda
- **Smooth Scroll**: Scroll behavior yang smooth
- **Page Enter/Exit**: Animasi saat halaman masuk atau keluar

### 📝 Class yang Tersedia

#### Section Transition
```html
<!-- Section akan fade in saat page load -->
<section class="section-transition" data-section>
    Konten section
</section>

<!-- Staggered list items -->
<div data-stagger-list>
    <div class="stagger-item">Item 1</div>
    <div class="stagger-item">Item 2</div>
    <div class="stagger-item">Item 3</div>
</div>
```

#### Timing untuk Stagger
- Item 1: 0.1s delay
- Item 2: 0.2s delay
- Item 3: 0.3s delay
- Item 4: 0.4s delay
- Item 5: 0.5s delay

### 💡 Contoh Implementasi di Dashboard
```html
<!-- Welcome section dengan transition -->
<div class="section-transition" data-section>
    <h2>Selamat Datang, User!</h2>
    <p>Konten welcome</p>
</div>

<!-- Statistics dengan stagger -->
<div data-stagger-list>
    <div class="stagger-item">Stat 1</div>
    <div class="stagger-item">Stat 2</div>
    <div class="stagger-item">Stat 3</div>
    <div class="stagger-item">Stat 4</div>
</div>

<!-- Reports dengan stagger -->
<div data-stagger-list>
    @foreach($reports as $report)
        <div class="stagger-item">
            <div class="report-card">{{ $report->title }}</div>
        </div>
    @endforeach
</div>
```

### 🔧 JavaScript API
```javascript
// Scroll ke section dengan smooth behavior
window.scrollToSection('sectionId', offsetFromTop);

// Contoh:
// scrollToSection('reports', 80); // Scroll ke #reports dengan offset 80px

// Manual page transition
document.addEventListener('turbo:load', () => {
    // Animasi sections otomatis
});
```

### 🎨 Keyframe Animations
```css
@keyframes pageEnter {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

### ⏱️ Timing
- **Section Transition**: 0.6s
- **Stagger Delay**: 0.1s between items
- **List Item Animation**: 0.6s per item

---

## 🎭 Kombinasi Animasi

Semua 4 fitur dapat dikombinasikan untuk UX yang optimal:

```html
<section class="section-transition" data-section data-stagger-list>
    <!-- Welcome -->
    <div class="scroll-fade-in">
        <h2>Dashboard Anda</h2>
    </div>
    
    <!-- Statistics dengan counter -->
    <div class="grid grid-cols-4 gap-4">
        <div class="scroll-fade-in micro-card stat-counter" data-target="25">0</div>
        <div class="scroll-slide-left micro-card stat-counter" data-target="12">0</div>
        <div class="scroll-slide-right micro-card stat-counter" data-target="8">0</div>
        <div class="scroll-scale-in micro-card stat-counter" data-target="5">0</div>
    </div>
    
    <!-- Reports dengan skeleton loading + stagger + micro -->
    <div id="reports-container" data-stagger-list>
        <div class="stagger-item micro-card">Report 1</div>
        <div class="stagger-item micro-card">Report 2</div>
        <div class="stagger-item micro-card">Report 3</div>
    </div>
</section>
```

---

## 🚀 Performance Tips

1. **Gunakan `data-observe-once="true"`** untuk elemen yang hanya perlu animate sekali
2. **Batasi jumlah stagger items** maksimal 5-6 items
3. **Skeleton loading** untuk API calls > 200ms
4. **Disable animations di slow devices** (media query prefers-reduced-motion)

```css
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

---

## 📱 Browser Support
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support (v12+)
- Mobile Browsers: ✅ Full support

---

## 🔍 Debugging
```javascript
// Check jika animations sudah initialized
console.log(window.animations);

// Manually trigger scroll observer
window.animations.setupScrollObserver();

// Show skeleton loading
window.showSkeletonLoading(element, 3);

// Animate counter
window.animateCounter(element, 150, 1500);
```

---

## 📞 Support
Untuk pertanyaan atau issue dengan animations, silakan buka issue di repository.

**Created**: January 5, 2026  
**Version**: 1.0  
**Modern UI/UX**: 2026 Ready ✨
