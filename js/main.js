// =================================
// Главный модуль приложения
// =================================

const ShenApp = {
  // Инициализация приложения
  init() {
    this.initEventDelegation(); // Инициализация обработки data-атрибутов
    this.initMenu();
    this.initSmoothScroll();
    this.initForm();
    this.initHeader();
    this.initGalleryLightbox();
    this.initModal();
  },

  // =================================
  // Централизованная обработка событий через data-атрибуты
  // =================================
  initEventDelegation() {
    // Обработка data-action атрибутов
    document.addEventListener('click', (e) => {
      const target = e.target.closest('[data-action]');
      if (!target) return;

      const action = target.getAttribute('data-action');
      
      switch (action) {
        case 'open-booking':
          e.preventDefault();
          if (typeof window.openBookingModal === 'function') {
            window.openBookingModal();
          } else {
            const bookingSection = document.querySelector('#booking');
            if (bookingSection) {
              bookingSection.scrollIntoView({ behavior: 'smooth' });
            }
          }
          break;
      }
    });

    // Обработка data-scroll-to атрибутов
    document.addEventListener('click', (e) => {
      const target = e.target.closest('[data-scroll-to]');
      if (!target) return;

      const selector = target.getAttribute('data-scroll-to');
      const targetElement = document.querySelector(selector);
      
      if (targetElement) {
        e.preventDefault();
        const offset = 20;
        const targetPosition = targetElement.offsetTop - offset;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });

    // Поддержка клавиатуры для элементов с data-scroll-to
    document.addEventListener('keydown', (e) => {
      const target = e.target;
      if (!target.hasAttribute('data-scroll-to')) return;

      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        target.click();
      }
    });
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
      const isActive = nav.classList.contains('header__nav--active');
      
      burger.classList.toggle('header__burger--active');
      nav.classList.toggle('header__nav--active');
      
      // Обновление ARIA атрибутов
      burger.setAttribute('aria-expanded', !isActive);
      
      // Блокировка скролла при открытом меню
      if (!isActive) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Мобильное выпадающее меню
    dropdownItems.forEach(item => {
      const link = item.querySelector('.header__menu-link');
      let touchStarted = false;
      
      // Функция переключения dropdown
      const toggleDropdown = (e) => {
        if (window.innerWidth <= 980) {
          e.preventDefault();
          e.stopPropagation();
          
          // Предотвращаем двойное срабатывание на touch устройствах
          if (e.type === 'click' && touchStarted) {
            touchStarted = false;
            return;
          }
          
          if (e.type === 'touchstart') {
            touchStarted = true;
            setTimeout(() => touchStarted = false, 500);
          }
          
          const isActive = item.classList.contains('active');
          item.classList.toggle('active');
          
          // Обновление ARIA атрибутов
          const link = item.querySelector('.header__menu-link');
          if (link) {
            link.setAttribute('aria-expanded', !isActive);
          }
          
          // Закрыть другие открытые dropdown
          dropdownItems.forEach(otherItem => {
            if (otherItem !== item) {
              otherItem.classList.remove('active');
              const otherLink = otherItem.querySelector('.header__menu-link');
              if (otherLink) {
                otherLink.setAttribute('aria-expanded', 'false');
              }
            }
          });
        }
      };
      
      // Для iOS: используем touchstart (срабатывает быстрее чем click)
      link.addEventListener('touchstart', toggleDropdown, { passive: false });
      // Для desktop: обычный click
      link.addEventListener('click', toggleDropdown);
    });

    // Закрытие меню при клике на ссылку (не dropdown)
    menuLinks.forEach(link => {
      const parentItem = link.closest('.header__menu-item');
      
      link.addEventListener('click', () => {
        // Не закрывать если это dropdown на мобильном
        if (window.innerWidth <= 980 && parentItem.classList.contains('header__menu-item--dropdown')) {
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

    // Закрыть dropdown при изменении размера окна (с debounce)
    const handleResize = debounce(() => {
      if (window.innerWidth > 980) {
        dropdownItems.forEach(item => {
          item.classList.remove('active');
        });
      }
    }, 250);
    
    window.addEventListener('resize', handleResize);
  },

  // =================================
  // Плавная прокрутка к якорям
  // =================================
  initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
      // Пропускаем элементы с data-атрибутами (они обрабатываются отдельно)
      if (link.hasAttribute('data-action') || link.hasAttribute('data-scroll-to')) {
        return;
      }

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
      const validation = this.validateForm(data);
      if (!validation.isValid) {
        const errorText = validation.errors.length > 0 
          ? validation.errors.join('. ') 
          : 'Пожалуйста, заполните все обязательные поля';
        this.showMessage(message, errorText, 'error');
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
    const errors = [];

    // Проверка имени
    if (!data.name || data.name.trim().length < 2) {
      errors.push('Имя должно содержать минимум 2 символа');
    }

    // Проверка телефона
    const phoneDigits = data.phone.replace(/\D/g, '');
    if (phoneDigits.length !== 11) {
      errors.push('Введите корректный номер телефона');
    }

    // Проверка даты (если поле присутствует)
    if (data.date) {
      const selectedDate = new Date(data.date);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      
      if (selectedDate < today) {
        errors.push('Дата не может быть в прошлом');
      }
    }

    // Проверка количества гостей (если поле присутствует)
    if (data.guests) {
      const guests = parseInt(data.guests);
      if (isNaN(guests) || guests < 1 || guests > 1000) {
        errors.push('Количество гостей должно быть от 1 до 1000');
      }
    }

    return {
      isValid: errors.length === 0,
      errors
    };
  },

  // =================================
  // Модальное окно для формы
  // =================================
  initModal() {
    const modal = document.querySelector('#bookingModal');
    const modalForm = document.querySelector('#modalBookingForm');
    const modalMessage = document.querySelector('#modalMessage');
    const closeBtn = modal?.querySelector('.modal__close');
    const overlay = modal?.querySelector('.modal__overlay');

    if (!modal) return;

    // Функция открытия модального окна
    window.openBookingModal = () => {
      modal.classList.add('modal--active');
      document.body.style.overflow = 'hidden';
      
      // Фокус на первое поле
      const firstInput = modalForm?.querySelector('#modalName');
      if (firstInput) {
        setTimeout(() => firstInput.focus(), 300);
      }
    };

    // Функция закрытия модального окна
    const closeModal = () => {
      modal.classList.remove('modal--active');
      document.body.style.overflow = '';
      
      // Очистка формы и сообщений
      if (modalForm) {
        modalForm.reset();
      }
      if (modalMessage) {
        modalMessage.textContent = '';
        modalMessage.className = 'modal__message';
      }
    };

    // Закрытие по кнопке
    if (closeBtn) {
      closeBtn.addEventListener('click', closeModal);
    }

    // Закрытие по клику на overlay
    if (overlay) {
      overlay.addEventListener('click', closeModal);
    }

    // Закрытие по Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('modal--active')) {
        closeModal();
      }
    });

    // Маска для телефона в модальном окне
    const modalPhoneInput = modalForm?.querySelector('#modalPhone');
    if (modalPhoneInput) {
      modalPhoneInput.addEventListener('input', (e) => {
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

    // Отправка формы модального окна
    if (modalForm) {
      modalForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData);

        // Валидация
        if (!data.name || data.name.trim().length < 2) {
          this.showModalMessage(modalMessage, 'Пожалуйста, введите ваше имя', 'error');
          return;
        }

        const phoneDigits = data.phone.replace(/\D/g, '');
        if (phoneDigits.length !== 11) {
          this.showModalMessage(modalMessage, 'Пожалуйста, введите корректный номер телефона', 'error');
          return;
        }

        // Показ сообщения об успехе
        this.showModalMessage(modalMessage, 'Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время.', 'success');
        
        // Очистка формы
        modalForm.reset();

        // Автоматическое закрытие через 3 секунды после успешной отправки
        setTimeout(() => {
          closeModal();
        }, 3000);

        // Здесь можно добавить реальную отправку на сервер
        // await this.sendFormData(data);
      });
    }
  },

  // Показ сообщения в модальном окне
  showModalMessage(messageElement, text, type) {
    if (!messageElement) return;

    messageElement.textContent = text;
    messageElement.className = 'modal__message';
    messageElement.classList.add(`modal__message--${type}`);
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
  },

  // =================================
  // Галерея с Lightbox
  // =================================
  initGalleryLightbox() {
    // Поддержка обычной галереи и галереи меню
    const galleryItems = document.querySelectorAll('.gallery__item, .menu-gallery__item');
    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const closeBtn = lightbox?.querySelector('.gallery__lightbox-close');
    const prevBtn = lightbox?.querySelector('.gallery__lightbox-prev');
    const nextBtn = lightbox?.querySelector('.gallery__lightbox-next');
    
    if (!lightbox || galleryItems.length === 0) return;

    let currentIndex = 0;
    const images = Array.from(galleryItems).map(item => {
      const img = item.querySelector('.gallery__img, .menu-gallery__img');
      return {
        src: img?.src || '',
        alt: img?.alt || ''
      };
    }).filter(img => img.src);

    // Открытие lightbox
    const openLightbox = (index) => {
      currentIndex = index;
      updateLightboxImage();
      lightbox.classList.add('active');
      document.body.style.overflow = 'hidden';
    };

    // Закрытие lightbox
    const closeLightbox = () => {
      lightbox.classList.remove('active');
      document.body.style.overflow = '';
    };

    // Обновление изображения
    const updateLightboxImage = () => {
      const img = images[currentIndex];
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      lightboxCounter.textContent = `${currentIndex + 1} / ${images.length}`;
    };

    // Показать следующее изображение
    const showNext = () => {
      currentIndex = (currentIndex + 1) % images.length;
      updateLightboxImage();
    };

    // Показать предыдущее изображение
    const showPrev = () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      updateLightboxImage();
    };

    // События клика на элементы галереи
    galleryItems.forEach((item, index) => {
      item.addEventListener('click', () => openLightbox(index));
    });

    // События кнопок
    closeBtn?.addEventListener('click', closeLightbox);
    nextBtn?.addEventListener('click', showNext);
    prevBtn?.addEventListener('click', showPrev);

    // Закрытие по клику на фон
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        closeLightbox();
      }
    });

    // Управление клавиатурой
    document.addEventListener('keydown', (e) => {
      if (!lightbox.classList.contains('active')) return;
      
      switch(e.key) {
        case 'Escape':
          closeLightbox();
          break;
        case 'ArrowRight':
          showNext();
          break;
        case 'ArrowLeft':
          showPrev();
          break;
      }
    });

    // Поддержка свайпов на мобильных
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    });

    lightbox.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    });

    const handleSwipe = () => {
      const swipeThreshold = 50;
      if (touchStartX - touchEndX > swipeThreshold) {
        showNext();
      } else if (touchEndX - touchStartX > swipeThreshold) {
        showPrev();
      }
    };
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

// Throttle функция для оптимизации частых событий
function throttle(func, limit) {
  let inThrottle;
  return function(...args) {
    if (!inThrottle) {
      func.apply(this, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
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

  // Отключаем звук для всех видео
  videos.forEach((v) => {
    if (v) {
      v.muted = true;
      v.volume = 0;
    }
  });

  // Инициализируем current с центрального слайда
  // Вычисляем центральный индекс: для 5 слайдов это будет 2 (третий слайд)
  const initialCenterIndex = Math.floor(slides.length / 2);
  let current = initialCenterIndex;
  let autoplayTimer = null;
  const AUTOPLAY_MS = 7000; // Увеличено до 10 секунд
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
    // maxIndex теперь позволяет прокрутить до последнего слайда
    const maxIndex = Math.max(0, slides.length - 1);
    return { slideWidth, gap, visibleCount, maxIndex };
  };

  // Вспомогательные функции
  const updateActive = (index) => {
    const { visibleCount } = getMetrics();
    
    // Активный слайд всегда равен текущему индексу
    // Это позволяет каждому слайду стать активным и воспроизводиться
    const activeIndex = index;
    
    slides.forEach((s, i) => s.classList.toggle('reels__slide--active', i === activeIndex));
    dots.forEach((d, i) => d.classList.toggle('reels__dot--active', i === index));
    
    // Обновляем воспроизведение при изменении активного слайда
    pauseAll();
    playActive();
  };

  const scrollToIndex = (index) => {
    const { slideWidth, gap, visibleCount } = getMetrics();
    
    // Вычисляем смещение для центрирования активного слайда
    const middleOffset = Math.floor(visibleCount / 2);
    const maxStartIndex = Math.max(0, slides.length - visibleCount);
    
    // Вычисляем индекс первого видимого слайда
    let startIndex;
    
    // Пытаемся центрировать активный слайд
    const desiredStartIndex = index - middleOffset;
    
    if (desiredStartIndex < 0) {
      // В начале: начинаем с 0
      startIndex = 0;
    } else if (desiredStartIndex > maxStartIndex) {
      // В конце: показываем последние visibleCount слайдов
      startIndex = maxStartIndex;
    } else {
      // В середине: центрируем активный слайд
      startIndex = desiredStartIndex;
    }
    
    // Вычисляем смещение для прокрутки
    const offset = Math.round(startIndex * (slideWidth + gap));
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
    // Находим активный слайд по центру
    const activeSlide = slides.find(s => s.classList.contains('reels__slide--active'));
    if (!activeSlide) return;
    
    const v = activeSlide.querySelector('.reels__video');
    if (!v) return;
    
    // Автовоспроизведение возможно только при mute и playsinline
    v.muted = true;
    v.volume = 0;
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
    updateActive(current);
    scrollToIndex(current);
  };
  window.addEventListener('resize', handleResize);

  layoutSlides();
  updateActive(current);
  scrollToIndex(current);
  startAutoplay();
}

// Анимация появления карточек контактов при скролле
function initContactCardsAnimation() {
  const cards = document.querySelectorAll('.advantages__card');
  
  if (cards.length === 0) return;

  const observerOptions = {
    threshold: 0.2,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  cards.forEach((card) => {
    observer.observe(card);
  });
}

// Добавить в инициализацию ShenApp
const originalInit = ShenApp.init;
ShenApp.init = function() {
  originalInit.call(this);
  initNumberCounter();
  initHeroSlider();
  initAboutSlider();
  initReelsSlider();
  initContactCardsAnimation();
  initContactHeroSlideshow();
};

// Фоновое слайдшоу на странице контактов
function initContactHeroSlideshow() {
  const slides = document.querySelectorAll('.contacts-hero__slide');
  
  if (slides.length === 0) return;

  let currentSlide = 0;
  const totalSlides = slides.length;

  function showNextSlide() {
    // Убираем active class с текущего слайда
    slides[currentSlide].classList.remove('contacts-hero__slide--active');
    
    // Переходим к следующему слайду
    currentSlide = (currentSlide + 1) % totalSlides;
    
    // Добавляем active class к новому слайду
    slides[currentSlide].classList.add('contacts-hero__slide--active');
  }

  // Запускаем смену слайдов каждые 4 секунды
  setInterval(showNextSlide, 4000);
}

// =================================
// Reviews Hero Slideshow
// =================================
function initReviewsHeroSlideshow() {
  const slides = document.querySelectorAll('.reviews-hero__slide');
  
  if (slides.length === 0) return;

  let currentSlide = 0;
  const totalSlides = slides.length;

  function showNextSlide() {
    slides[currentSlide].classList.remove('reviews-hero__slide--active');
    currentSlide = (currentSlide + 1) % totalSlides;
    slides[currentSlide].classList.add('reviews-hero__slide--active');
  }

  setInterval(showNextSlide, 5000);
}

// ================================
// Events Page Functionality
// ================================

// Events Hero Slideshow
function initEventsHeroSlideshow() {
  const slideshowContainer = document.querySelector('.events-hero__slideshow');
  if (!slideshowContainer) return;

  const slides = slideshowContainer.querySelectorAll('.events-hero__slide');
  const scrollBtn = document.querySelector('.events-hero__scroll');
  
  let currentSlide = 0;
  let autoplayInterval;

  // Функция показа слайда
  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('events-hero__slide--active'));
    slides[index].classList.add('events-hero__slide--active');
    currentSlide = index;
  }

  // Функция автоматической смены слайдов
  function showNextSlide() {
    const nextSlide = (currentSlide + 1) % slides.length;
    showSlide(nextSlide);
  }

  // Запуск автопроигрывания
  function startAutoplay() {
    autoplayInterval = setInterval(showNextSlide, 5000);
  }

  // Остановка автопроигрывания
  function stopAutoplay() {
    if (autoplayInterval) {
      clearInterval(autoplayInterval);
    }
  }

  // Клик по кнопке прокрутки
  if (scrollBtn) {
    scrollBtn.addEventListener('click', () => {
      const nextSection = document.querySelector('.events-nav');
      if (nextSection) {
        nextSection.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  // Пауза при наведении на hero секцию
  const heroSection = document.querySelector('.events-hero');
  if (heroSection) {
    heroSection.addEventListener('mouseenter', stopAutoplay);
    heroSection.addEventListener('mouseleave', startAutoplay);
  }

  // Запуск автопроигрывания
  startAutoplay();
}

// Events Navigation - Sticky & Active States
function initEventsNavigation() {
  const eventsNav = document.getElementById('events-nav');
  if (!eventsNav) return;

  const navLinks = eventsNav.querySelectorAll('.events-nav__link');
  const sections = document.querySelectorAll('.event-section');

  // Smooth scroll
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href');
      const targetSection = document.querySelector(targetId);
      if (targetSection) {
        const offset = 150;
        const targetPosition = targetSection.offsetTop - offset;
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // Update active state on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const sectionId = entry.target.id;
        navLinks.forEach(link => {
          link.classList.remove('events-nav__link--active');
          if (link.getAttribute('data-section') === sectionId) {
            link.classList.add('events-nav__link--active');
          }
        });
      }
    });
  }, {
    threshold: 0.3,
    rootMargin: '-150px 0px -50% 0px'
  });

  sections.forEach(section => observer.observe(section));
}

// Gallery Filtering
function initGalleryFiltering() {
  const filterBtns = document.querySelectorAll('.filter-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');

  if (filterBtns.length === 0 || galleryItems.length === 0) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;

      // Update active button
      filterBtns.forEach(b => b.classList.remove('filter-btn--active'));
      btn.classList.add('filter-btn--active');

      // Filter items
      galleryItems.forEach((item, index) => {
        const category = item.dataset.category;

        if (filter === 'all' || category === filter) {
          item.classList.remove('gallery-item--filtering-out');
          setTimeout(() => {
            item.style.display = 'block';
          }, 50);
          setTimeout(() => {
            item.style.animation = `fadeIn 0.4s ease ${index * 0.05}s both`;
          }, 100);
        } else {
          item.classList.add('gallery-item--filtering-out');
          setTimeout(() => {
            item.style.display = 'none';
          }, 300);
        }
      });
    });
  });
}

// Scroll Animations
function initScrollAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  });

  const elementsToAnimate = document.querySelectorAll('.event-section__content, .gallery-item');
  elementsToAnimate.forEach(el => observer.observe(el));
}

// Smooth Scroll for all anchor links
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#' || href === '#!') return;

      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const offset = 150;
        const targetPosition = target.offsetTop - offset;
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });
}

// =================================
// Gallery Page Module
// =================================

const GalleryPage = {
  currentIndex: 0,
  allImages: [],
  visibleImages: [],
  currentFilter: 'all',
  slideshowInterval: null,
  isPlaying: false,

  init() {
    // Проверяем, находимся ли мы на странице галереи
    if (!document.querySelector('.gallery-page')) return;

    this.initHeroSlideshow();
    this.initFilters();
    this.initMasonry();
    this.initLightbox();
    this.initLoadMore();
    // this.initParallax(); // Отключен параллакс эффект
    this.initCounters();
    // this.initScrollToTop() - перенесено в универсальную функцию
    this.initLightboxTools(); // 🆕 Zoom, Share, Download
    // this.initInfiniteScroll(); // Отключен - вернули кнопку "Загрузить ещё"
    this.updateAllImages();
  },

  // Hero Background Slideshow
  initHeroSlideshow() {
    const slides = document.querySelectorAll('.gallery-hero__slide');
    if (slides.length === 0) return;

    let currentSlide = 0;

    setInterval(() => {
      slides[currentSlide].classList.remove('gallery-hero__slide--active');
      currentSlide = (currentSlide + 1) % slides.length;
      slides[currentSlide].classList.add('gallery-hero__slide--active');
    }, 5000);
  },

  // Parallax Effect
  initParallax() {
    const hero = document.querySelector('.gallery-hero');
    const heroContent = document.querySelector('.gallery-hero__content');
    const heroBackground = document.querySelector('.gallery-hero__background');
    
    if (!hero || !heroContent || !heroBackground) return;

    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const heroHeight = hero.offsetHeight;
      
      if (scrolled < heroHeight) {
        // Parallax для фона
        heroBackground.style.transform = `translateY(${scrolled * 0.5}px)`;
        
        // Parallax для контента
        heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
        heroContent.style.opacity = 1 - (scrolled / heroHeight) * 1.5;
      }
    });
  },

  // Animated Counters
  initCounters() {
    const stats = document.querySelectorAll('.gallery-hero__stat-value');
    let animated = false;

    const animateCounter = (element, target) => {
      const duration = 2000;
      const start = 0;
      const increment = target / (duration / 16);
      let current = start;

      const updateCounter = () => {
        current += increment;
        if (current < target) {
          element.textContent = Math.floor(current) + (element.textContent.includes('+') ? '+' : '');
          requestAnimationFrame(updateCounter);
        } else {
          element.textContent = element.getAttribute('data-target');
        }
      };

      updateCounter();
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !animated) {
          animated = true;
          stats.forEach(stat => {
            const originalText = stat.textContent.trim();
            const target = parseInt(originalText);
            
            // Не анимировать если это символ бесконечности или не число
            if (originalText === '∞' || isNaN(target)) {
              // Просто добавим fade-in эффект
              stat.style.opacity = '0';
              setTimeout(() => {
                stat.style.transition = 'opacity 1s ease';
                stat.style.opacity = '1';
              }, 100);
              return;
            }
            
            stat.setAttribute('data-target', originalText);
            stat.textContent = '0';
            animateCounter(stat, target);
          });
        }
      });
    }, { threshold: 0.5 });

    stats.forEach(stat => observer.observe(stat));
  },

  // 3D Tilt Effect for Cards
  init3DTilt() {
    const cards = document.querySelectorAll('.gallery-card');
    
    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px) scale(1.03)`;
      });
      
      card.addEventListener('mouseleave', () => {
        card.style.transform = '';
      });
    });
  },

  // Filter Buttons
  initFilters() {
    const filterBtns = document.querySelectorAll('.gallery-filters__btn');
    const cards = document.querySelectorAll('.gallery-card:not(.gallery-card--hidden)');
    
    // Initialize 3D Tilt after filters are set
    this.init3DTilt();

    if (filterBtns.length === 0) return;

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const filter = btn.dataset.filter;
        this.currentFilter = filter;

        // Обновить активную кнопку
        filterBtns.forEach(b => b.classList.remove('gallery-filters__btn--active'));
        btn.classList.add('gallery-filters__btn--active');

        // Фильтрация карточек
        cards.forEach((card, index) => {
          const category = card.dataset.category;

          if (filter === 'all' || category === filter) {
            card.style.display = 'block';
            setTimeout(() => {
              card.style.animation = `fadeInUp 0.4s ease ${index * 0.05}s both`;
            }, 50);
          } else {
            card.style.display = 'none';
          }
        });

        // Пересчитать Masonry после фильтрации
        setTimeout(() => {
          this.calculateMasonry();
          this.updateVisibleImages();
          this.init3DTilt(); // Re-initialize 3D Tilt
        }, 100);
      });
    });
  },

  // Masonry Layout - теперь используется CSS columns, расчеты не нужны
  initMasonry() {
    // CSS columns автоматически создает Masonry layout
    // Никаких расчетов не требуется!
    console.log('Masonry layout использует CSS columns');
  },

  // Lightbox Functionality
  initLightbox() {
    const cards = document.querySelectorAll('.gallery-card');
    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const lightboxCategory = document.getElementById('lightboxCategory');
    const closeBtn = document.getElementById('lightboxClose');
    const prevBtn = document.getElementById('lightboxPrev');
    const nextBtn = document.getElementById('lightboxNext');
    const slideshowBtn = document.getElementById('lightboxSlideshow');

    if (!lightbox) return;

    // Открытие lightbox
    cards.forEach((card, index) => {
      card.addEventListener('click', () => {
        if (card.style.display === 'none' || card.classList.contains('gallery-card--hidden')) return;
        
        this.updateVisibleImages();
        const visibleIndex = this.visibleImages.findIndex(img => img === card);
        if (visibleIndex !== -1) {
          this.openLightbox(visibleIndex);
        }
      });
    });

    // Закрытие lightbox
    closeBtn.addEventListener('click', () => this.closeLightbox());
    
    // Закрытие по клику на фон
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        this.closeLightbox();
      }
    });

    // Закрытие по ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && lightbox.classList.contains('active')) {
        this.closeLightbox();
      }
    });

    // Навигация
    prevBtn.addEventListener('click', () => this.showPrevImage());
    nextBtn.addEventListener('click', () => this.showNextImage());

    // Навигация стрелками
    document.addEventListener('keydown', (e) => {
      if (!lightbox.classList.contains('active')) return;
      
      if (e.key === 'ArrowLeft') {
        this.showPrevImage();
      } else if (e.key === 'ArrowRight') {
        this.showNextImage();
      }
      // Space для slideshow - DISABLED
    });

    // Slideshow - DISABLED
    // slideshowBtn.addEventListener('click', () => this.toggleSlideshow());

    // 📱 Swipe Gestures для мобильных
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    lightboxImg.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
      touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    lightboxImg.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      touchEndY = e.changedTouches[0].screenY;
      
      const diffX = touchStartX - touchEndX;
      const diffY = touchStartY - touchEndY;

      // Swipe horizontal (влево/вправо)
      if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
        if (diffX > 0) {
          this.showNextImage(); // Swipe left
        } else {
          this.showPrevImage(); // Swipe right
        }
      }
      // Swipe vertical down для закрытия
      else if (diffY < -100) {
        this.closeLightbox();
      }
    }, { passive: true });
  },

  updateAllImages() {
    this.allImages = Array.from(document.querySelectorAll('.gallery-card'));
    this.updateVisibleImages();
  },

  updateVisibleImages() {
    this.visibleImages = this.allImages.filter(card => {
      return card.style.display !== 'none' && !card.classList.contains('gallery-card--hidden');
    });
  },

  openLightbox(index) {
    this.currentIndex = index;
    const lightbox = document.getElementById('galleryLightbox');
    const card = this.visibleImages[index];
    const img = card.querySelector('.gallery-card__image');
    const category = card.querySelector('.gallery-card__category');

    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const lightboxCategory = document.getElementById('lightboxCategory');

    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt;
    lightboxCounter.textContent = `${index + 1} / ${this.visibleImages.length}`;
    lightboxCategory.textContent = category.textContent;

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
  },

  closeLightbox() {
    const lightbox = document.getElementById('galleryLightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
    
    // Остановить слайдшоу
    if (this.isPlaying) {
      this.toggleSlideshow();
    }
  },

  showPrevImage() {
    this.currentIndex = (this.currentIndex - 1 + this.visibleImages.length) % this.visibleImages.length;
    this.updateLightboxImage();
  },

  showNextImage() {
    this.currentIndex = (this.currentIndex + 1) % this.visibleImages.length;
    this.updateLightboxImage();
  },

  updateLightboxImage() {
    const card = this.visibleImages[this.currentIndex];
    const img = card.querySelector('.gallery-card__image');
    const category = card.querySelector('.gallery-card__category');

    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const lightboxCategory = document.getElementById('lightboxCategory');
    const lightboxProgress = document.getElementById('lightboxProgress');

    // Анимация смены изображения
    lightboxImg.style.opacity = '0';
    
    setTimeout(() => {
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      
      // Update counter
      const counterText = lightboxCounter.querySelector('.gallery-lightbox__counter-text');
      if (counterText) {
        counterText.textContent = `${this.currentIndex + 1} / ${this.visibleImages.length}`;
      } else {
        lightboxCounter.textContent = `${this.currentIndex + 1} / ${this.visibleImages.length}`;
      }
      
      // Update progress bar
      if (lightboxProgress) {
        const progress = ((this.currentIndex + 1) / this.visibleImages.length) * 100;
        lightboxProgress.style.width = `${progress}%`;
      }
      
      lightboxCategory.textContent = category.textContent;
      lightboxImg.style.opacity = '1';
    }, 150);
  },

  toggleSlideshow() {
    const slideshowBtn = document.getElementById('lightboxSlideshow');
    const playIcon = slideshowBtn.querySelector('.gallery-lightbox__slideshow-icon--play');
    const pauseIcon = slideshowBtn.querySelector('.gallery-lightbox__slideshow-icon--pause');

    if (this.isPlaying) {
      // Остановить
      clearInterval(this.slideshowInterval);
      this.isPlaying = false;
      slideshowBtn.classList.remove('gallery-lightbox__slideshow--playing');
      playIcon.style.display = 'block';
      pauseIcon.style.display = 'none';
    } else {
      // Запустить
      this.slideshowInterval = setInterval(() => {
        this.showNextImage();
      }, 3000);
      this.isPlaying = true;
      slideshowBtn.classList.add('gallery-lightbox__slideshow--playing');
      playIcon.style.display = 'none';
      pauseIcon.style.display = 'block';
    }
  },

  // 🆕 Scroll to Top Button
  initScrollToTop() {
    const scrollBtn = document.getElementById('scrollToTop');
    if (!scrollBtn) return;

    // Show/hide based on scroll position
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        scrollBtn.classList.add('visible');
      } else {
        scrollBtn.classList.remove('visible');
      }
    });

    // Scroll to top on click
    scrollBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  },

  // 🆕 Lightbox Tools (Share, Download) - Zoom removed
  initLightboxTools() {
    const lightboxImg = document.getElementById('lightboxImg');
    const zoomBtn = document.getElementById('zoomBtn');
    const shareBtn = document.getElementById('shareBtn');
    const downloadBtn = document.getElementById('downloadBtn');

    if (!lightboxImg) return;

    // Zoom functionality - DISABLED
    // if (zoomBtn) {
    //   zoomBtn.addEventListener('click', () => {
    //     lightboxImg.classList.toggle('zoomed');
    //   });
    // }

    // Double-click to zoom - DISABLED
    // lightboxImg.addEventListener('dblclick', () => {
    //   lightboxImg.classList.toggle('zoomed');
    // });

    // Share functionality
    if (shareBtn) {
      shareBtn.addEventListener('click', async () => {
        const shareData = {
          title: 'Галерея Shen',
          text: 'Посмотрите это фото из банкетного зала Shen!',
          url: window.location.href
        };

        try {
          if (navigator.share) {
            await navigator.share(shareData);
          } else {
            // Fallback: copy to clipboard
            await navigator.clipboard.writeText(window.location.href);
            this.showNotification('Ссылка скопирована в буфер обмена!');
          }
        } catch (err) {
          console.log('Share failed:', err);
        }
      });
    }

    // Download functionality
    if (downloadBtn) {
      downloadBtn.addEventListener('click', () => {
        const currentCard = this.visibleImages[this.currentIndex];
        const img = currentCard.querySelector('.gallery-card__image');
        
        const link = document.createElement('a');
        link.href = img.src;
        link.download = `shen-gallery-${this.currentIndex + 1}.jpg`;
        link.click();
        
        this.showNotification('Загрузка началась...');
      });
    }
  },

  // 🆕 Notification helper
  showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'gallery-notification';
    notification.textContent = message;
    notification.style.cssText = `
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.9);
      color: white;
      padding: 16px 32px;
      border-radius: 50px;
      font-size: 14px;
      z-index: 10000;
      animation: fadeInUp 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'fadeOut 0.3s ease';
      setTimeout(() => notification.remove(), 300);
    }, 2000);
  },

  // 🆕 Infinite Scroll
  initInfiniteScroll() {
    const loadMoreSection = document.getElementById('loadMoreSection');
    if (!loadMoreSection) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          // Auto-load more when section is visible
          const loadBtn = document.getElementById('loadMoreBtn');
          if (loadBtn && !loadBtn.disabled) {
            loadBtn.click();
          }
        }
      });
    }, {
      rootMargin: '200px' // Load before reaching the button
    });

    observer.observe(loadMoreSection);
  },

  // Load More Functionality
  initLoadMore() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const hiddenCards = document.querySelectorAll('.gallery-card--hidden');

    if (!loadMoreBtn || hiddenCards.length === 0) {
      // Скрыть кнопку, если нет скрытых карточек
      const loadMoreSection = document.getElementById('loadMoreSection');
      if (loadMoreSection) {
        loadMoreSection.style.display = 'none';
      }
      return;
    }

    loadMoreBtn.addEventListener('click', () => {
      const hiddenCards = document.querySelectorAll('.gallery-card--hidden');
      const cardsToShow = Array.from(hiddenCards).slice(0, 12);

      cardsToShow.forEach((card, index) => {
        setTimeout(() => {
          card.classList.remove('gallery-card--hidden');
          card.style.animation = `fadeInUp 0.4s ease ${index * 0.05}s both`;
        }, index * 50);
      });

      // Обновить список изображений после показа новых карточек
      setTimeout(() => {
        this.updateAllImages();
      }, 500);

      // Скрыть кнопку, если больше нет скрытых карточек
      setTimeout(() => {
        const remainingHidden = document.querySelectorAll('.gallery-card--hidden');
        if (remainingHidden.length === 0) {
          const loadMoreSection = document.getElementById('loadMoreSection');
          if (loadMoreSection) {
            loadMoreSection.style.display = 'none';
          }
        }
      }, 600);
    });
  }
};

// Инициализация при загрузке DOM
if (document.readyState === 'loading') {
  // 🆕 Universal Scroll to Top Button
  function initScrollToTop() {
    const scrollBtn = document.getElementById('scrollToTop');
    if (!scrollBtn) return;

    // Show/hide based on scroll position (с throttle для оптимизации)
    const handleScroll = throttle(() => {
      if (window.pageYOffset > 300) {
        scrollBtn.classList.add('visible');
      } else {
        scrollBtn.classList.remove('visible');
      }
    }, 100);

    window.addEventListener('scroll', handleScroll, { passive: true });

    // Scroll to top on click
    scrollBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    initContactCardsAnimation();
    initContactHeroSlideshow();
    initReviewsHeroSlideshow();
    initEventsHeroSlideshow();
    initEventsNavigation();
    initGalleryFiltering();
    initScrollAnimations();
    initSmoothScroll();
    initScrollToTop(); // 🆕 Инициализация кнопки "Наверх" на всех страницах
    GalleryPage.init(); // Инициализация Gallery Page
  });
} else {
  initContactCardsAnimation();
  initContactHeroSlideshow();
  initReviewsHeroSlideshow();
  initEventsHeroSlideshow();
  initEventsNavigation();
  initGalleryFiltering();
  initScrollAnimations();
  initSmoothScroll();
  GalleryPage.init(); // Инициализация Gallery Page
}

