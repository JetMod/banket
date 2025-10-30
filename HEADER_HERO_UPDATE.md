# 🎨 Header & Hero - Современное обновление

## ✨ КОНЦЕПЦИЯ

**Стиль:** Glassmorphism + Премиум Gold  
**Анимации:** Тонкие micro-interactions  
**Тренд:** 2025 Design System

---

## 🎯 HEADER - Изменения

### Фон и стиль
✅ Gradient фон: темный → прозрачный (сверху вниз)  
✅ `backdrop-filter: blur(5px)` для glassmorphism  
✅ Cubic-bezier анимации для premium ощущения  

### Логотип
✅ Увеличен до 55px  
✅ Улучшенный drop-shadow с золотым свечением  

### Навигационные ссылки
✅ Gradient подчеркивание (прозрачный → gold → прозрачный)  
✅ Анимация поднятия при hover (-2px)  
✅ Линия появляется от центра (scaleX transform)  

### Телефон
✅ Стильная кнопка с border и blur  
✅ При hover: золотой фон, темный текст  
✅ Box-shadow с золотым свечением  

### Dropdown меню
✅ Темный фон (rgba(26, 26, 46, 0.95))  
✅ Увеличенный blur: 25px + saturation  
✅ Вертикальная золотая полоска при hover  
✅ Золотой текст и подсветка фона  

---

## 🎬 HERO - Изменения

### Фон
✅ **Ken Burns эффект** - медленный zoom (scale 1 → 1.08)  
✅ Radial gradient с золотым свечением  
✅ Улучшенный overlay градиент  

### Типографика
✅ Адаптивные размеры: `clamp(2.5rem, 6vw, 5rem)`  
✅ Улучшенный font-weight: 700  
✅ Text-shadow для глубины  
✅ Letter-spacing: -1px для современного вида  

### "SHEN" акцент
✅ **Gradient текст:** gold → light → vibrant  
✅ **Shimmer анимация** (3s infinite)  
✅ Background-clip: text для gradient эффекта  

### Слоган
✅ Uppercase + увеличенный letter-spacing (2px)  
✅ Меньший размер шрифта: 0.95rem  

### Описание
✅ Max-width: 700px для лучшей читаемости  
✅ Centered с auto margins  

### Кнопки
✅ **Ripple эффект** при hover (::before псевдоэлемент)  
✅ Primary: gold gradient фон  
✅ Secondary: glassmorphism стиль  
✅ Увеличенные тени и transform (-4px)  
✅ Больше padding: 1.1rem × 2.75rem  

### Статистика (100-350, 2, Халяль)
✅ **Glassmorphism карточки** с blur  
✅ Hover: золотой фон + поднятие + тень  
✅ **Gradient на цифрах** (gold → light)  
✅ Border с золотым свечением при hover  
✅ Min-width: 140px для единообразия  

---

## 🎨 ЦВЕТОВАЯ ПАЛИТРА

### Новый Gold
```css
--color-gold: #E6B980          /* Rose Gold - основной */
--color-gold-light: #F5D6A8    /* Светлый */
--color-gold-vibrant: #FFD700  /* Яркий акцент */
```

### Прозрачности
```css
--color-white-soft: rgba(255,255,255,0.95)
--color-white-muted: rgba(255,255,255,0.75)
--color-white-dim: rgba(255,255,255,0.6)
```

---

## ⚡ АНИМАЦИИ

### Cubic-Bezier
```css
cubic-bezier(0.4, 0, 0.2, 1)  /* Premium easing */
```

### Ken Burns (Hero BG)
```css
0% { transform: scale(1); }
100% { transform: scale(1.08); }
/* Duration: 20s infinite alternate */
```

### Shimmer (SHEN)
```css
0%, 100% { opacity: 1; }
50% { opacity: 0.85; }
/* Duration: 3s infinite */
```

### Ripple (Кнопки)
```css
Hover: width/height 0 → 300px
Duration: 0.6s
```

---

## 🎯 СОВРЕМЕННЫЕ ТРЕНДЫ

✅ **Glassmorphism** - blur + прозрачность  
✅ **Micro-interactions** - тонкие hover эффекты  
✅ **Gradient everywhere** - текст, фон, подчеркивания  
✅ **Large Typography** - крупные адаптивные шрифты  
✅ **Soft Shadows** - объемные тени с золотым оттенком  
✅ **Ken Burns** - живой фон  
✅ **Premium Spacing** - больше воздуха  

---

## 📱 АДАПТИВНОСТЬ

Все размеры используют `clamp()`:
- Заголовок: 2.5rem → 6vw → 5rem
- Описание: 1rem → 2vw → 1.25rem  
- Цифры: 2rem → 4vw → 3rem

Gaps используют `clamp()` или фиксированные rem для консистентности.

---

**Дата:** 21 октября 2025  
**Стиль:** Premium Glassmorphism 2025
