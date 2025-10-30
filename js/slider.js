// ================================
// Slider - Автоматический слайдер фона
// ================================

class BackgroundSlider {
    constructor() {
        this.slides = document.querySelectorAll('.hero-improved__slide');
        this.indicators = document.querySelectorAll('.hero-improved__indicator');
        this.currentSlide = 0;
        this.autoSlideInterval = null;
        this.autoSlideDuration = 5000; // 5 секунд
        
        this.init();
    }
    
    init() {
        // Обработчики для индикаторов
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.goToSlide(index);
                this.resetAutoSlide();
            });
        });
        
        // Запуск автоматического переключения
        this.startAutoSlide();
    }
    
    goToSlide(slideIndex) {
        // Удаляем активный класс со всех слайдов и индикаторов
        this.slides.forEach(slide => slide.classList.remove('hero-improved__slide--active'));
        this.indicators.forEach(indicator => indicator.classList.remove('hero-improved__indicator--active'));
        
        // Добавляем активный класс текущему слайду и индикатору
        this.slides[slideIndex].classList.add('hero-improved__slide--active');
        this.indicators[slideIndex].classList.add('hero-improved__indicator--active');
        
        this.currentSlide = slideIndex;
    }
    
    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    }
    
    startAutoSlide() {
        this.autoSlideInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoSlideDuration);
    }
    
    resetAutoSlide() {
        // Очищаем старый интервал
        clearInterval(this.autoSlideInterval);
        
        // Запускаем новый
        this.startAutoSlide();
    }
    
    stop() {
        clearInterval(this.autoSlideInterval);
    }
    
    play() {
        this.startAutoSlide();
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    window.backgroundSlider = new BackgroundSlider();
    
    console.log('🎬 Слайдер фона инициализирован!');
    console.log('⏱️ Автоматическое переключение каждые 5 секунд');
});

// Опционально: добавим паузу слайдера при наведении мыши на hero
window.addEventListener('load', () => {
    const hero = document.querySelector('.hero-improved');
    
    if (hero && window.backgroundSlider) {
        hero.addEventListener('mouseenter', () => {
            window.backgroundSlider.stop();
        });
        
        hero.addEventListener('mouseleave', () => {
            window.backgroundSlider.play();
        });
    }
});
