# ⚡ QUICK REFERENCE - ПРЕМИУМ HERO

## 🎯 Быстрый справочник по стилям

### Layout Grid
```css
.hero__content {
  display: grid;
  grid-template-columns: 1fr 0.8fr;  /* левая колонна > правой */
  gap: 4rem;
  align-items: center;
}
```

### Заголовок
```css
.hero__title {
  font-size: clamp(3.5rem, 8vw, 6rem);
  font-weight: 700;
  letter-spacing: -1px;
  line-height: 1.15;
}

.hero__title::before {
  width: 5px;
  background: linear-gradient(180deg, var(--color-gold), transparent);
}
```

### Анимация при загрузке
```css
@keyframes slideInLeft {
  from { opacity: 0; transform: translateX(-50px); }
  to { opacity: 1; transform: translateX(0); }
}

/* Применить к элементу */
animation: slideInLeft 0.8s ease-out;
animation: slideInLeft 0.8s ease-out 0.2s forwards; /* с задержкой */
```

### Кнопки
```css
/* Primary */
.button--primary { background: var(--color-gold); }
.button--primary:hover { transform: translateY(-2px); }

/* Secondary */
.button--secondary { border: 2px solid var(--color-white); }
.button--secondary:hover { background: var(--color-white); }
```

### Инфо блоки (hover эффект)
```css
.hero__info-item:hover {
  transform: translateX(5px);
}

.hero__info-item::before {
  opacity: 0;
}

.hero__info-item:hover::before {
  opacity: 1;  /* золотая линия появляется */
}

.hero__info-item:hover .hero__info-number {
  transform: scale(1.05);  /* число на 5% больше */
}
```

---

## 🎨 Цветовая палитра

| Использование | Переменная | Значение |
|---|---|---|
| Основной акцент | `--color-gold` | #D4AF37 |
| Основной текст | `--color-white` | #FFFFFF |
| Мягкий текст | `--color-white-soft` | (более светлый) |
| На золотом фоне | `--color-secondary` | #2c3e50 |

---

## 📏 Типография

| Элемент | Размер | Вес | Extra |
|---|---|---|---|
| `hero__title` | clamp(3.5rem, 8vw, 6rem) | 700 | -1px letter-spacing |
| `hero__slogan` | 1.1rem | 400 | uppercase, 3px letter-spacing |
| `hero__description` | 1.25rem | 300 | 1.9 line-height |
| `hero__info-number` | clamp(2.5rem, 4vw, 3.5rem) | 700 | line-height: 1 |
| `button` | 1rem | 500 | 1.5px letter-spacing |

---

## ⏱️ Анимация Timeline

```
t=0ms     → hero__title начинает двигаться
t=200ms   → hero__slogan начинает двигаться
t=400ms   → hero__description начинает двигаться
t=600ms   → hero__buttons начинают двигаться
t=800ms   → hero__info начинает двигаться
t=1600ms  → все элементы полностью видны (0.8s + 0.8s)
```

---

## 🖱️ Hover Effects

### Кнопки
- Primary: `translateY(-2px)` + усиленная тень
- Secondary: фон меняется на white + текст темнеет

### Инфо блоки
- Линия слева: `opacity: 0 → 1`
- Блок: `translateX(5px)`
- Число: `scale(1.05)`

---

## 📱 Адаптивные размеры

```css
/* Title */
clamp(3.5rem, 8vw, 6rem)
/* мин 3.5rem, если 8vw ≤ 3.5rem → используй 3.5rem
   если 8vw ≥ 6rem → используй 6rem
   иначе используй 8vw */

/* Info number */
clamp(2.5rem, 4vw, 3.5rem)
/* мин 2.5rem, max 3.5rem */
```

---

## 🔧 Как изменить...

### ...цвет золота?
```css
/* В style.css найди: */
--color-gold: #D4AF37;
/* И замени на нужный */
```

### ...размер заголовка?
```css
.hero__title {
  font-size: clamp(2.5rem, 7vw, 5.5rem);  /* измени эти значения */
}
```

### ...скорость анимации?
```css
animation: slideInLeft 0.8s ease-out;  /* 0.8s → твой размер */
```

### ...gap между колонками?
```css
.hero__content {
  gap: 4rem;  /* 4rem → твой размер */
}
```

### ...соотношение grid колонок?
```css
grid-template-columns: 1fr 0.8fr;  /* 1fr 0.8fr → твое соотношение */
```

---

## ✅ Проверка

Откройте DevTools (F12) и проверьте:
- [ ] Анимации плавные при загрузке
- [ ] Hover на кнопках работает
- [ ] Золотая линия появляется в инфо
- [ ] На мобильных grid адаптируется
- [ ] Тени видны, но не слишком яркие

---

## 📞 Файлы для справки

1. `css/style.css` - основной файл стилей
2. `HERO_UPDATE_LOG.md` - пошаговое объяснение
3. `CSS_UPDATES.md` - технические детали

