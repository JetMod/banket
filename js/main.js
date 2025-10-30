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

