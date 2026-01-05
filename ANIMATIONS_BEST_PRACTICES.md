# Best Practices: Advanced Animations
## Implementasi Optimal untuk Dashboard 2026

---

## 📋 Checklist Implementasi

### ✅ Sudah Diterapkan di Dashboard
- [x] Scroll-based storytelling untuk welcome section
- [x] Counter animation pada statistics cards
- [x] Micro-interactions pada cards dan buttons
- [x] Staggered animations untuk report lists
- [x] Smooth scroll behavior
- [x] Micro-interactions pada links dengan underline

### ⏳ Dapat Diterapkan di Halaman Lain
- [ ] Skeleton loading untuk modal/form
- [ ] Page transitions untuk navigation
- [ ] Input animations untuk form submissions
- [ ] Notification feedback animations
- [ ] Upload file animations dengan checkmark

---

## 🎯 Use Cases & Recommendations

### 1. Report Creation Form
```html
<form @submit.prevent="submitReport">
    <!-- Input dengan animated underline -->
    <input class="input-animated" type="text" placeholder="Judul Laporan">
    
    <!-- File upload dengan checkmark animation -->
    <div id="upload-container">
        <input type="file" @change="handleFileUpload">
        <span class="checkmark-animate" v-if="fileUploaded">✓</span>
    </div>
    
    <!-- Submit button dengan micro-interaction -->
    <button class="btn-primary btn-micro" type="submit">
        Kirim Laporan
    </button>
</form>
```

### 2. Modal/Dialog
```html
<div class="section-transition" v-if="showModal">
    <div class="bg-white rounded-lg shadow-lg">
        <!-- Content dengan stagger animation -->
        <div data-stagger-list>
            <h2 class="stagger-item">Modal Title</h2>
            <p class="stagger-item">Modal content</p>
            <div class="stagger-item">Modal footer</div>
        </div>
    </div>
</div>
```

### 3. Search Results
```html
<div id="search-results" data-stagger-list>
    <!-- Results akan di-populate dengan skeleton loading dulu -->
    <template v-for="result in results">
        <div class="stagger-item micro-card">
            {{ result.title }}
        </div>
    </template>
</div>

<script>
async function handleSearch(query) {
    const container = document.getElementById('search-results');
    window.showSkeletonLoading(container, 3);
    
    const results = await fetch(`/api/search?q=${query}`);
    window.hideSkeletonLoading(container);
    // Render results...
}
</script>
```

### 4. Dashboard Statistics
```html
<!-- Statistics dengan semua animasi -->
<div class="grid grid-cols-4 gap-6 mb-16" data-section>
    <!-- Setiap card memiliki 3 animasi layer -->
    <div class="scroll-fade-in micro-card" data-observe-once="true">
        <p class="text-4xl font-bold stat-counter" data-target="25">0</p>
    </div>
</div>
```

### 5. Notification/Toast Messages
```javascript
// Show animated notification
window.showAnimatedNotification('Laporan berhasil dikirim!', 'success');
window.showAnimatedNotification('Gagal memproses file', 'error');
window.showAnimatedNotification('Menunggu persetujuan...', 'warning');

// Custom notification dengan micro-interaction
const notification = document.createElement('div');
notification.className = 'fixed top-4 right-4 px-6 py-3 bg-green-500 text-white rounded-lg animate-bounce-in';
notification.textContent = 'Success!';
document.body.appendChild(notification);
```

---

## 🔄 Animation Pipeline

### User Action Flow
```
User Action (Hover/Click/Scroll)
    ↓
Browser detects action
    ↓
CSS Transition/Animation triggers (200-600ms)
    ↓
JavaScript callback (if needed)
    ↓
Visual feedback complete
```

### Scroll Detection Flow
```
Page Load
    ↓
IntersectionObserver initialized
    ↓
User scrolls
    ↓
Element enters viewport
    ↓
"active" class added
    ↓
CSS animation/transition triggers
    ↓
Animation completes
```

### API Loading Flow
```
User triggers action
    ↓
Show skeleton loading (0.3s)
    ↓
Fetch API (200-2000ms)
    ↓
Skeleton fade out (0.3s)
    ↓
Actual content fade in with stagger
    ↓
Complete
```

---

## 💻 Code Examples

### Example 1: Dynamic Report Loading
```javascript
async function loadReports(page = 1) {
    const container = document.getElementById('reports-list');
    
    // Show loading state
    window.showReportSkeleton(container, 3);
    
    try {
        const response = await fetch(`/api/reports?page=${page}`);
        const { data, total } = await response.json();
        
        // Hide skeleton dengan fade out
        window.hideSkeletonLoading(container);
        
        // Render reports dengan stagger
        container.innerHTML = `
            <div data-stagger-list>
                ${data.map((report, i) => `
                    <div class="stagger-item micro-card">
                        <h4>${report.title}</h4>
                        <p>${report.description}</p>
                    </div>
                `).join('')}
            </div>
        `;
        
        // Observe new scroll animations
        const items = container.querySelectorAll('.stagger-item');
        window.observeScrollAnimations(items);
        
    } catch (error) {
        window.hideSkeletonLoading(container);
        window.showAnimatedNotification('Error loading reports', 'error');
    }
}
```

### Example 2: Form Submission with Feedback
```javascript
document.getElementById('report-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = form.querySelector('[type="submit"]');
    
    // Disable button dan show loading state
    submitBtn.disabled = true;
    submitBtn.classList.add('opacity-50');
    
    try {
        const formData = new FormData(form);
        const response = await fetch('/api/reports', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            // Show success notification
            window.showAnimatedNotification('Laporan berhasil dikirim!', 'success');
            
            // Reset form
            form.reset();
            
            // Reload reports
            setTimeout(() => {
                loadReports();
            }, 1500);
        } else {
            throw new Error('Failed to submit');
        }
    } catch (error) {
        window.showAnimatedNotification('Gagal mengirim laporan', 'error');
    } finally {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50');
    }
});
```

### Example 3: Scroll Detection untuk Section
```javascript
// Automatically trigger section animations saat load
document.addEventListener('DOMContentLoaded', () => {
    // Sections dengan data-section akan fade in
    document.querySelectorAll('[data-section]').forEach((section, index) => {
        section.classList.add('section-transition');
        section.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Stagger list items
    document.querySelectorAll('[data-stagger-list] > *').forEach((item, index) => {
        item.classList.add('stagger-item');
        setTimeout(() => {
            item.classList.add('active');
        }, index * 100);
    });
});
```

---

## 🎨 Animation Timing Reference

| Animation | Duration | Easing | Use Case |
|-----------|----------|--------|----------|
| Micro Interaction (Hover) | 200-250ms | ease-out | Card hover, button hover |
| Input Focus | 300-400ms | ease-out | Input underline animation |
| Scroll Trigger | 600-800ms | ease-out | Fade in, slide animations |
| Counter Animation | 1500ms | linear | Statistics counter |
| Skeleton Loading | 2000ms (infinite) | - | Loading state |
| Page Transition | 300-600ms | ease-out | Page enter/exit |
| Stagger Delay | 100ms per item | - | List items |

---

## 📊 Performance Metrics

### Optimal Performance
- FCP (First Contentful Paint): < 1s
- LCP (Largest Contentful Paint): < 2.5s
- CLS (Cumulative Layout Shift): < 0.1
- Animations: 60fps (60hz smooth)

### GPU Acceleration
```css
/* Trigger hardware acceleration -->
.micro-card {
    transform: translateZ(0);
    will-change: transform;
}

.skeleton {
    /* Already GPU accelerated via background-image animation */
}
```

---

## ⚠️ Common Pitfalls

### ❌ Hindari
```javascript
// DON'T: Animate too many properties
.card {
    transition: all 0.3s ease; /* Animates width, height, color, etc */
}

// DON'T: Long animation durations
.element {
    animation-duration: 5s; /* Terlalu lama */
}

// DON'T: Too much stagger delay
.item:nth-child(10) {
    animation-delay: 2s; /* Terlalu lama */
}
```

### ✅ Sebaiknya
```javascript
// DO: Animate specific properties
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

// DO: Reasonable durations
.element {
    animation-duration: 0.6s;
}

// DO: Reasonable stagger
.item:nth-child(5) {
    animation-delay: 0.4s; /* Max ~0.5s */
}
```

---

## 🧪 Testing Animations

### Manual Testing Checklist
- [ ] Animations smooth pada desktop (Chrome)
- [ ] Animations smooth pada Firefox
- [ ] Animations smooth pada Safari
- [ ] Touch events work on mobile
- [ ] Keyboard navigation maintains focus
- [ ] Animations respect `prefers-reduced-motion`
- [ ] No layout shift during animations
- [ ] Performance on older devices

### Browser DevTools
```javascript
// Disable animations for testing
document.documentElement.style.animationDuration = '0.01ms';
document.documentElement.style.transitionDuration = '0.01ms';

// Throttle animations (Chrome DevTools Console)
// 1. Open DevTools
// 2. Click "..." → More tools → Rendering
// 3. Check "Rendering" panel untuk FPS monitor
```

---

## 🚀 Future Enhancements

### Dapat Ditambahkan
1. **Gesture Animations**: Swipe, pinch, drag animations
2. **Parallax Scrolling**: Berbeda kecepatan scroll untuk layer
3. **SVG Animations**: Animated icons dan illustrations
4. **Lottie Integration**: Complex animations dari After Effects
5. **WebGL Effects**: Advanced 3D animations untuk hero section

### Implementation Examples
```html
<!-- Lottie animation -->
<script src="https://unpkg.com/lottie-web@latest/build/lottie.js"></script>
<div id="lottie-animation"></div>
<script>
    lottie.loadAnimation({
        container: document.getElementById('lottie-animation'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/animations/loading.json'
    });
</script>
```

---

## 📚 Resources

- [MDN: CSS Animations](https://developer.mozilla.org/en-US/docs/Web/CSS/animation)
- [MDN: CSS Transitions](https://developer.mozilla.org/en-US/docs/Web/CSS/transition)
- [Intersection Observer API](https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API)
- [Web Animations API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Animations_API)

---

**Last Updated**: January 5, 2026  
**Version**: 1.0  
**Status**: Production Ready ✨
