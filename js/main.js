// =================================
// Главный модуль приложения
// =================================

const ShenApp = {
  // Инициализация приложения
  init() {
    this.initMenu();
    this.initSmoothScroll();
    this.initForm();
    this.initHeader();
  },

  // =================================
  // Мобильное меню
  // =================================
  initMenu() {
    const burger = document.querySelector('.header__burger');
    const nav = document.querySelector('.header__nav');
    const menuLinks = document.querySelectorAll('.header__menu-link');
    const dropdownItems = document.querySelectorAll('.header__menu-item--dropdown');

    if (!burger || !nav) return;

    // Открытие/закрытие меню
    burger.addEventListener('click', () => {
      burger.classList.toggle('header__burger--active');
      nav.classList.toggle('header__nav--active');
      
      // Блокировка скролла при открытом меню
      if (nav.classList.contains('header__nav--active')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Мобильное выпадающее меню
    dropdownItems.forEach(item => {
      const link = item.querySelector('.header__menu-link');
      
      link.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
          e.preventDefault();
          item.classList.toggle('active');
          
          // Закрыть другие открытые dropdown
          dropdownItems.forEach(otherItem => {
            if (otherItem !== item) {
              otherItem.classList.remove('active');
            }
          });
        }
      });
    });

    // Закрытие меню при клике на ссылку (не dropdown)
    menuLinks.forEach(link => {
      const parentItem = link.closest('.header__menu-item');
      
      link.addEventListener('click', () => {
        // Не закрывать если это dropdown на мобильном
        if (window.innerWidth <= 768 && parentItem.classList.contains('header__menu-item--dropdown')) {
          return;
        }
        
        burger.classList.remove('header__burger--active');
        nav.classList.remove('header__nav--active');
        document.body.style.overflow = '';
      });
    });

    // Закрытие при клике на dropdown link
    const dropdownLinks = document.querySelectorAll('.header__dropdown-link');
    dropdownLinks.forEach(link => {
      link.addEventListener('click', () => {
        burger.classList.remove('header__burger--active');
        nav.classList.remove('header__nav--active');
        document.body.style.overflow = '';
        
        // Закрыть все dropdown
        dropdownItems.forEach(item => {
          item.classList.remove('active');
        });
      });
    });

    // Закрытие меню при клике вне его
    document.addEventListener('click', (e) => {
      const isClickInsideMenu = nav.contains(e.target);
      const isClickOnBurger = burger.contains(e.target);

      if (!isClickInsideMenu && !isClickOnBurger && nav.classList.contains('header__nav--active')) {
        burger.classList.remove('header__burger--active');
        nav.classList.remove('header__nav--active');
        document.body.style.overflow = '';
        
        // Закрыть все dropdown
        dropdownItems.forEach(item => {
          item.classList.remove('active');
        });
      }
    });

    // Закрыть dropdown при изменении размера окна
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        dropdownItems.forEach(item => {
          item.classList.remove('active');
        });
      }
    });
  },

  // =================================
  // Плавная прокрутка к якорям
  // =================================
  initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
      link.addEventListener('click', (e) => {
        const href = link.getAttribute('href');
        
        // Игнорируем пустые якоря и внешние ссылки
        if (!href || href === '#' || !href.startsWith('#')) return;
        
        e.preventDefault();
        
        const targetElement = document.querySelector(href);
        
        if (targetElement) {
          const targetPosition = targetElement.offsetTop - 20;

          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  },

  // =================================
  // Изменение хедера при скролле (отключено)
  // =================================
  initHeader() {
    // Header больше не фиксированный, эффекты при скролле не нужны
  },

  // =================================
  // Валидация и отправка формы бронирования
  // =================================
  initForm() {
    const form = document.querySelector('#bookingForm');
    const message = document.querySelector('#bookingMessage');

    if (!form) return;

    // Маска для телефона
    const phoneInput = form.querySelector('#phone');
    if (phoneInput) {
      phoneInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.startsWith('7')) {
          value = value.substring(1);
        }
        
        let formattedValue = '+7';
        
        if (value.length > 0) {
          formattedValue += ' (' + value.substring(0, 3);
        }
        if (value.length >= 4) {
          formattedValue += ') ' + value.substring(3, 6);
        }
        if (value.length >= 7) {
          formattedValue += '-' + value.substring(6, 8);
        }
        if (value.length >= 9) {
          formattedValue += '-' + value.substring(8, 10);
        }
        
        e.target.value = formattedValue;
      });
    }

    // Отправка формы
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Получение данных формы
      const formData = new FormData(form);
      const data = Object.fromEntries(formData);

      // Валидация
      if (!this.validateForm(data)) {
        this.showMessage(message, 'Пожалуйста, заполните все обязательные поля', 'error');
        return;
      }

      // Показ сообщения об успехе (имитация отправки)
      this.showMessage(message, 'Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время.', 'success');
      
      // Очистка формы
      form.reset();

      // Здесь можно добавить реальную отправку на сервер
      // await this.sendFormData(data);
    });
  },

  // Валидация формы
  validateForm(data) {
    // Проверка имени
    if (!data.name || data.name.trim().length < 2) {
      return false;
    }

    // Проверка телефона
    const phoneDigits = data.phone.replace(/\D/g, '');
    if (phoneDigits.length !== 11) {
      return false;
    }

    // Проверка даты
    if (!data.date) {
      return false;
    }

    // Проверка количества гостей
    if (!data.guests) {
      return false;
    }

    return true;
  },

  // Показ сообщения
  showMessage(messageElement, text, type) {
    if (!messageElement) return;

    messageElement.textContent = text;
    messageElement.className = 'booking__message';
    messageElement.classList.add(`booking__message--${type}`);

    // Автоматическое скрытие сообщения через 5 секунд
    setTimeout(() => {
      messageElement.className = 'booking__message';
      messageElement.textContent = '';
    }, 5000);
  },

  // Отправка данных на сервер (пример)
  async sendFormData(data) {
    try {
      const response = await fetch('/api/booking', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });

      if (!response.ok) {
        throw new Error('Ошибка отправки');
      }

      return await response.json();
    } catch (error) {
      console.error('Ошибка:', error);
      throw error;
    }
  }
};

// =================================
// Инициализация при загрузке DOM
// =================================
document.addEventListener('DOMContentLoaded', () => {
  ShenApp.init();
  
  // Консольное сообщение
  console.log('%c✨ Shen - Нет предела совершенству ✨', 
    'color: #c9a961; font-size: 20px; font-weight: bold;'
  );
});

// =================================
// Дополнительные утилиты
// =================================

// Debounce функция для оптимизации
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Проверка видимости элемента
function isElementInViewport(el) {
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}


// =================================
// =================================
// Animated Number Counter
// =================================
function initNumberCounter() {
  const numberElement = document.querySelector('.hero__info-number');
  
  if (!numberElement) return;
  
  const targetNumber = 300;
  const duration = 2000; // 2 seconds
  const startTime = performance.now();
  
  function updateNumber(currentTime) {
    const elapsedTime = currentTime - startTime;
    const progress = Math.min(elapsedTime / duration, 1);
    
    // Easing function (easeOutExpo)
    const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
    
    const currentNumber = Math.floor(easeProgress * targetNumber);
    numberElement.textContent = currentNumber;
    
    if (progress < 1) {
      requestAnimationFrame(updateNumber);
    } else {
      numberElement.textContent = targetNumber;
    }
  }
  
  // Начать анимацию после загрузки
  setTimeout(() => {
    requestAnimationFrame(updateNumber);
  }, 800);
}

// =================================
// Hero Background Slider - автоматическая смена каждые 5 секунд
function initHeroSlider() {
  const slides = document.querySelectorAll('.hero__slide');
  if (!slides.length) return;
  
  let currentSlide = 0;
  
  function showSlide(index) {
    // Убираем active у всех слайдов
    slides.forEach(slide => slide.classList.remove('active'));
    
    // Добавляем active к нужному слайду
    slides[index].classList.add('active');
  }
  
  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }
  
  // Автоматическая смена каждые 5 секунд
  setInterval(nextSlide, 5000);
}

// =================================
// Слайдер в секции About
// =================================
function initAboutSlider() {
  const slider = document.querySelector('.about__slider');
  if (!slider) {
    console.log('❌ Слайдер не найден');
    return;
  }
  
  console.log('✅ Слайдер найден');
  
  const slides = slider.querySelectorAll('.about__slide');
  const prevBtn = slider.querySelector('.about__slider-btn--prev');
  const nextBtn = slider.querySelector('.about__slider-btn--next');
  const dots = slider.querySelectorAll('.about__slider-dot');
  
  console.log(`📸 Найдено слайдов: ${slides.length}`);
  console.log(`🔘 Найдено точек: ${dots.length}`);
  
  let currentSlide = 0;
  let autoplayInterval;
  
  // Показать слайд
  function showSlide(index) {
    // Удалить активный класс у всех слайдов и точек
    slides.forEach(slide => slide.classList.remove('about__slide--active'));
    dots.forEach(dot => dot.classList.remove('about__slider-dot--active'));
    
    // Добавить активный класс текущему слайду и точке
    slides[index].classList.add('about__slide--active');
    dots[index].classList.add('about__slider-dot--active');
  }
  
  // Следующий слайд
  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }
  
  // Предыдущий слайд
  function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  }
  
  // Перейти к определенному слайду
  function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
    resetAutoplay();
  }
  
  // Автопрокрутка
  function startAutoplay() {
    autoplayInterval = setInterval(nextSlide, 5000);
  }
  
  function stopAutoplay() {
    clearInterval(autoplayInterval);
  }
  
  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }
  
  // События для кнопок
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      resetAutoplay();
    });
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      resetAutoplay();
    });
  }
  
  // События для точек
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      goToSlide(index);
    });
  });
  
  // Пауза при наведении
  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);
  
  // Поддержка свайпов на мобильных
  let touchStartX = 0;
  let touchEndX = 0;
  
  slider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  });
  
  slider.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        nextSlide();
      } else {
        prevSlide();
      }
      resetAutoplay();
    }
  }
  
  // Клавиатурная навигация
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      prevSlide();
      resetAutoplay();
    } else if (e.key === 'ArrowRight') {
      nextSlide();
      resetAutoplay();
    }
  });
  
  // Запустить автопрокрутку
  startAutoplay();
}

// =================================
// Reels Video Slider (Instagram-like)
// =================================
function initReelsSlider() {
  const slider = document.querySelector('.reels__slider');
  if (!slider) return;

  const track = slider.querySelector('.reels__track');
  const viewport = slider.querySelector('.reels__viewport');
  const slides = Array.from(slider.querySelectorAll('.reels__slide'));
  const prevBtn = slider.querySelector('.reels__btn--prev');
  const nextBtn = slider.querySelector('.reels__btn--next');
  const dots = Array.from(slider.querySelectorAll('.reels__dot'));
  const videos = slides.map(s => s.querySelector('.reels__video'));

  let current = 0;
  let autoplayTimer = null;
  const AUTOPLAY_MS = 5000;
  let cachedSlideWidth = null; // точная ширина для расчёта без дрожания

  // Раскладка ширины слайдов под 1/2/3 видимых
  const layoutSlides = () => {
    const viewportWidth = Math.floor(viewport.getBoundingClientRect().width);
    const gap = parseFloat(getComputedStyle(track).gap || '0');
    const visibleTarget = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
    const slideWidth = Math.floor((viewportWidth - gap * (visibleTarget - 1)) / visibleTarget);
    cachedSlideWidth = slideWidth;
    slides.forEach(s => { s.style.width = `${slideWidth}px`; });
  };

  // Подсчёт метрик: фиксируем число видимых карточек по брейкпоинтам,
  // чтобы всегда показывалось ровно 3/2/1 без «обрезков»
  const getMetrics = () => {
    const slideWidth = cachedSlideWidth ?? Math.floor(slides[0].getBoundingClientRect().width);
    const gap = parseFloat(getComputedStyle(track).gap || '0');
    const visibleCount = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
    const maxIndex = Math.max(0, slides.length - visibleCount);
    return { slideWidth, gap, visibleCount, maxIndex };
  };

  // Вспомогательные функции
  const updateActive = (index) => {
    const { visibleCount } = getMetrics();
    const middleOffset = Math.floor(visibleCount / 2);
    const activeIndex = Math.min(slides.length - 1, index + middleOffset);
    slides.forEach((s, i) => s.classList.toggle('reels__slide--active', i === activeIndex));
    dots.forEach((d, i) => d.classList.toggle('reels__dot--active', i === index));
  };

  const scrollToIndex = (index) => {
    const { slideWidth, gap } = getMetrics();
    const offset = Math.round(index * (slideWidth + gap));
    track.style.transform = `translateX(${-offset}px)`;
  };

  const pauseAll = () => {
    videos.forEach((v) => {
      if (!v) return;
      v.pause();
      v.currentTime = Math.min(v.currentTime, (v.duration || 0));
    });
  };

  const playActive = () => {
    const v = videos[current];
    if (!v) return;
    // Автовоспроизведение возможно только при mute и playsinline
    v.muted = true;
    const playPromise = v.play();
    if (playPromise && typeof playPromise.then === 'function') {
      playPromise.catch(() => {});
    }
  };

  const goTo = (index) => {
    const { maxIndex } = getMetrics();
    if (index > maxIndex) {
      current = 0;
    } else if (index < 0) {
      current = maxIndex;
    } else {
      current = index;
    }
    updateActive(current);
    scrollToIndex(current);
    pauseAll();
    playActive();
  };

  const next = () => goTo(current + 1);
  const prev = () => goTo(current - 1);

  // Пагинация по страницам (по 3/2/1 сразу) при двойном клике на стрелку
  const pageNext = () => { const { visibleCount } = getMetrics(); goTo(current + visibleCount); };
  const pagePrev = () => { const { visibleCount } = getMetrics(); goTo(current - visibleCount); };

  // Если потребуется — можно переключить на pageNext/pagePrev


  // Автовоспроизведение
  const startAutoplay = () => {
    stopAutoplay();
    autoplayTimer = setInterval(next, AUTOPLAY_MS);
  };
  const stopAutoplay = () => {
    if (autoplayTimer) clearInterval(autoplayTimer);
    autoplayTimer = null;
  };

  // События
  if (prevBtn) prevBtn.addEventListener('click', prev);
  if (nextBtn) nextBtn.addEventListener('click', next);
  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

  // Пауза при наведении
  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);

  // Свайпы на мобильных
  let touchStartX = 0;
  slider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });
  slider.addEventListener('touchend', (e) => {
    const dx = e.changedTouches[0].screenX - touchStartX;
    if (Math.abs(dx) > 40) {
      dx < 0 ? next() : prev();
    }
  });

  // Пауза, когда секция вне экрана
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        startAutoplay();
        playActive();
      } else {
        stopAutoplay();
        pauseAll();
      }
    });
  }, { threshold: 0.25 });
  observer.observe(slider);

  // Инициализация
  const handleResize = () => {
    layoutSlides();
    const { maxIndex } = getMetrics();
    if (current > maxIndex) current = maxIndex;
    scrollToIndex(current);
  };
  window.addEventListener('resize', handleResize);

  layoutSlides();
  updateActive(current);
  scrollToIndex(current);
  playActive();
  startAutoplay();
}

// Добавить в инициализацию ShenApp
const originalInit = ShenApp.init;
ShenApp.init = function() {
  originalInit.call(this);
  initNumberCounter();
  initHeroSlider();
  initAboutSlider();
  initReelsSlider();
};

