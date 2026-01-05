/**
 * Advanced Animations Module
 * Handles scroll-based storytelling, micro-interactions, and transitions
 */

class AdvancedAnimations {
    constructor() {
        this.observedElements = new Set();
        this.init();
    }

    init() {
        this.setupScrollObserver();
        this.setupMicroInteractions();
        this.setupCounterAnimation();
        this.setupPageTransitions();
        this.setupBubbleEffect();
    }

    /**
     * 1. SCROLL-BASED STORYTELLING (SCROLLYTELLING)
     * Menggunakan Intersection Observer untuk mendeteksi elemen yang masuk viewport
     */
    setupScrollObserver() {
        const options = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Tambahkan class 'active' untuk trigger animasi
                    entry.target.classList.add('active');
                    
                    // Optional: stop observing setelah animasi selesai
                    if (entry.target.dataset.observeOnce === 'true') {
                        observer.unobserve(entry.target);
                    }
                }
            });
        }, options);

        // Observe semua elemen dengan class scroll animation
        document.querySelectorAll(
            '.scroll-fade-in, .scroll-slide-left, .scroll-slide-right, .scroll-scale-in, .stat-counter'
        ).forEach(el => {
            observer.observe(el);
            this.observedElements.add(el);
        });

        // Support untuk dynamic content
        window.observeScrollAnimations = (elements) => {
            elements.forEach(el => {
                if (!this.observedElements.has(el)) {
                    observer.observe(el);
                    this.observedElements.add(el);
                }
            });
        };
    }

    /**
     * 2. MICRO-INTERACTIONS
     * Smooth feedback pada user actions seperti hover dan input focus
     */
    setupMicroInteractions() {
        // Card hover effects
        document.querySelectorAll('.micro-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)';
            });
        });

        // Input animations
        document.querySelectorAll('.input-animated').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.classList.remove('focused');
                }
            });
        });

        // Button micro-interactions
        document.querySelectorAll('.btn-micro').forEach(btn => {
            btn.addEventListener('mousedown', function() {
                this.style.transition = 'all 0.1s ease-out';
            });

            btn.addEventListener('mouseup', function() {
                this.style.transition = 'all 0.25s ease-out';
            });
        });

        // Link hover underlines
        document.querySelectorAll('.link-hover').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transition = 'color 0.3s ease-out';
            });
        });

        // Toast/notification feedback
        this.setupNotificationFeedback();
    }

    /**
     * Notification feedback animation
     */
    setupNotificationFeedback() {
        window.showAnimatedNotification = (message, type = 'success') => {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white font-semibold shadow-lg animate-bounce-in`;
            
            const bgColor = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            }[type] || 'bg-blue-500';

            notification.className += ` ${bgColor}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s ease-out forwards';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        };
    }

    /**
     * 3. COUNTER ANIMATION untuk Statistics
     * Animasi angka yang menghitung ke atas (counter-up effect)
     */
    setupCounterAnimation() {
        window.animateCounter = (element, target, duration = 1500) => {
            const start = 0;
            const increment = target / (duration / 16); // 16ms per frame (60fps)
            let current = start;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 16);
        };

        // Auto-animate all stat counters saat mereka visible
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.animated) {
                    const target = parseInt(entry.target.dataset.target) || 0;
                    this.animateCounter(entry.target, target, 1500);
                    entry.target.dataset.animated = 'true';
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-target]').forEach(el => {
            counterObserver.observe(el);
        });
    }

    animateCounter(element, target, duration) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }

    /**
     * 4. PAGE TRANSITIONS & SMOOTH SCROLLING
     * Smooth transitions antara sections
     */
    setupPageTransitions() {
        // Smooth scroll to section
        window.scrollToSection = (sectionId, offset = 80) => {
            const element = document.getElementById(sectionId);
            if (element) {
                const yOffset = -offset;
                const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        };

        // Add transition class ke semua sections saat load
        document.querySelectorAll('[data-section]').forEach((section, index) => {
            section.classList.add('section-transition');
            section.style.animationDelay = `${index * 0.1}s`;
        });

        // Staggered list animations
        document.querySelectorAll('[data-stagger-list] > *').forEach((item, index) => {
            item.classList.add('stagger-item');
            setTimeout(() => {
                item.classList.add('active');
            }, index * 100);
        });
    }

    /**
     * 4a. SKELETON LOADING SUPPORT
     * Menampilkan skeleton placeholders saat loading
     */
    setupSkeletonLoading() {
        window.showSkeletonLoading = (container, itemCount = 3) => {
            const skeleton = document.createElement('div');
            skeleton.className = 'skeleton-container';
            
            for (let i = 0; i < itemCount; i++) {
                const card = document.createElement('div');
                card.className = 'skeleton-card';
                card.innerHTML = `
                    <div class="skeleton skeleton-title"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text" style="width: 85%;"></div>
                    <div class="skeleton skeleton-text" style="width: 70%;"></div>
                `;
                skeleton.appendChild(card);
            }
            
            container.innerHTML = '';
            container.appendChild(skeleton);
        };

        window.hideSkeletonLoading = (container) => {
            const skeleton = container.querySelector('.skeleton-container');
            if (skeleton) {
                skeleton.style.animation = 'fadeOut 0.3s ease-out forwards';
                setTimeout(() => skeleton.remove(), 300);
            }
        };

        // Report skeleton
        window.showReportSkeleton = (container, itemCount = 3) => {
            const skeleton = document.createElement('div');
            skeleton.className = 'skeleton-container space-y-4';
            
            for (let i = 0; i < itemCount; i++) {
                const card = document.createElement('div');
                card.className = 'skeleton-card';
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <div class="skeleton-report-header">
                            <div class="skeleton skeleton-report-badge"></div>
                        </div>
                        <div class="skeleton skeleton-title" style="width: 100px;"></div>
                    </div>
                    <div class="skeleton skeleton-text" style="width: 80%;"></div>
                    <div class="flex gap-3 mt-3">
                        <div class="skeleton skeleton-text" style="width: 40%;"></div>
                        <div class="skeleton skeleton-text" style="width: 35%;"></div>
                    </div>
                `;
                skeleton.appendChild(card);
            }
            
            container.innerHTML = '';
            container.appendChild(skeleton);
        };
    }

    /**
     * BUBBLE EFFECT
     * Gelembung yang meledak saat button diklik
     */
    setupBubbleEffect() {
        // Handle all buttons with bubble effect
        document.addEventListener('click', (e) => {
            const button = e.target.closest('button, a[class*="btn"], input[type="submit"]');
            if (button) {
                this.createBubbles(button, e);
            }
        });

        // Support untuk dynamic buttons
        window.enableBubbleEffect = (element) => {
            if (element) {
                element.addEventListener('click', (e) => {
                    this.createBubbles(element, e);
                });
            }
        };
    }

    /**
     * Create bubble elements di posisi click
     */
    createBubbles(button, event) {
        const rect = button.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        // Determine button type untuk warna bubble
        let bubbleType = 'primary';
        if (button.classList.contains('btn-secondary')) {
            bubbleType = 'secondary';
        } else if (button.classList.contains('btn-outline')) {
            bubbleType = 'outline';
        }

        // Main bubble (meledak ke tengah)
        const bubble = this.createBubble(x, y, bubbleType, 'animate');
        button.appendChild(bubble);

        // Multiple burst bubbles (meledak ke berbagai arah)
        const burstBubbles = [
            { class: 'burst-1' },
            { class: 'burst-2' },
            { class: 'burst-3' },
            { class: 'burst-4' }
        ];

        burstBubbles.forEach((burst, index) => {
            setTimeout(() => {
                const burstBubble = this.createBubble(x, y, bubbleType, burst.class);
                button.appendChild(burstBubble);
            }, index * 50);
        });

        // Clean up bubbles after animation
        setTimeout(() => {
            const bubbles = button.querySelectorAll('.bubble');
            bubbles.forEach(b => b.remove());
        }, 800);
    }

    /**
     * Create single bubble element
     */
    createBubble(x, y, type, animationClass) {
        const bubble = document.createElement('span');
        bubble.className = `bubble ${type} ${animationClass}`;
        bubble.style.left = x + 'px';
        bubble.style.top = y + 'px';
        bubble.style.width = '0px';
        bubble.style.height = '0px';
        return bubble;
    }
}

// Initialize animations saat DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.animations = new AdvancedAnimations();
});

// Support untuk AJAX/Dynamic loading
document.addEventListener('turbo:load', () => {
    if (window.animations) {
        window.animations.setupScrollObserver();
        window.animations.setupMicroInteractions();
        window.animations.setupCounterAnimation();
    }
});
