// ================================
// Hero Improved - Interactive Effects
// ================================

const HeroImproved = {
    // Параллакс эффект
    initParallax() {
        const parallaxImg = document.querySelector('[data-parallax]');
        if (!parallaxImg) return;

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const parallaxValue = parallaxImg.dataset.parallax || 0.5;
            parallaxImg.style.transform = `translateY(${scrollTop * parallaxValue}px)`;
        });
    },

    // Header scroll эффект
    initHeaderScroll() {
        const header = document.querySelector('.header');
        if (!header) return;

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                header.classList.add('is-scrolled');
            } else {
                header.classList.remove('is-scrolled');
            }
        });
    },

    // Плавная прокрутка по якорям
    initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href === '#') return;

                const target = document.querySelector(href);
                if (!target) return;

                e.preventDefault();

                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 80;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            });
        });
    },

    // Intersection Observer для анимаций при прокрутке
    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Наблюдаем за элементами
        document.querySelectorAll('.features__item, .showcase__item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    },

    // Эффект наведения для карточек
    initCardHoverEffects() {
        document.querySelectorAll('.card-feature').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    },

    // Анимация чисел при виде
    initCounterAnimation() {
        const animateCounter = (element, target, duration = 2000) => {
            let current = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        };

        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.animated) {
                    const numbers = entry.target.querySelectorAll('.hero-improved__stat-number');
                    numbers.forEach(num => {
                        const text = num.textContent.trim();
                        const numValue = parseInt(text);
                        if (!isNaN(numValue)) {
                            animateCounter(num, numValue, 1500);
                        }
                    });
                    entry.target.dataset.animated = 'true';
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.hero-improved__stats');
        if (statsSection) {
            observer.observe(statsSection);
        }
    },

    // Мобильное меню
    initMobileMenu() {
        const burger = document.querySelector('.header__burger');
        const menu = document.querySelector('.header__menu');
        if (!burger || !menu) return;

        burger.addEventListener('click', () => {
            menu.classList.toggle('header__menu--active');
            burger.classList.toggle('header__burger--active');
        });

        // Закрываем меню при клике на ссылку
        document.querySelectorAll('.header__menu-link').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('header__menu--active');
                burger.classList.remove('header__burger--active');
            });
        });
    },

    // Кнопка бронирования
    initBookingButton() {
        const buttons = document.querySelectorAll('.hero-improved__btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                // Добавляем ripple эффект
                const ripple = document.createElement('span');
                const rect = btn.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.pointerEvents = 'none';
                ripple.style.animation = 'ripple-animation 0.6s ease-out';

                if (btn.style.position !== 'relative') {
                    btn.style.position = 'relative';
                }

                btn.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });

        // CSS для ripple анимации
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple-animation {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    },

    // Инициализация всех эффектов
    init() {
        console.log('🎨 Инициализация Hero Improved эффектов...');

        // Проверяем если на странице есть hero-improved
        if (document.querySelector('.hero-improved')) {
            this.initParallax();
            this.initHeaderScroll();
            this.initSmoothScroll();
            this.initScrollAnimations();
            this.initCardHoverEffects();
            this.initCounterAnimation();
            this.initMobileMenu();
            this.initBookingButton();

            console.log('✨ Все эффекты инициализированы!');
        }
    }
};

// Запуск при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    HeroImproved.init();
});

// Дополнительные утилиты для анимаций
window.HeroUtils = {
    // Функция для добавления класса при видимости элемента
    onVisible(selector, callback) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    callback(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll(selector).forEach(el => observer.observe(el));
    },

    // Функция для плавного появления элементов
    fadeInUp(elements) {
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `all 0.6s ease-out ${index * 0.1}s`;

            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 10);
        });
    },

    // Функция для текста с эффектом печатания
    typeWriter(element, text, speed = 50) {
        let index = 0;
        element.textContent = '';

        const type = () => {
            if (index < text.length) {
                element.textContent += text.charAt(index);
                index++;
                setTimeout(type, speed);
            }
        };

        type();
    }
};
