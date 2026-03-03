<?php
/**
 * Template Name: Отзывы
 * Description: Шаблон страницы отзывов
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Отзывы гостей банкетного зала Shen. Реальные отзывы о свадьбах, корпоративах и других мероприятиях. Рейтинг 4.9/5.">
    <title>Отзывы гостей — Банкетный зал Shen | Реальные отзывы о мероприятиях</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body class="page-reviews">
    <?php get_header(); ?>
 
    <!-- Hero Section -->
    <?php 
    $hero_section = banket_get_field('reviews_hero_section', array());
    $hero_slideshow = isset($hero_section['slideshow']) ? $hero_section['slideshow'] : array();
    $hero_label = isset($hero_section['label']) ? $hero_section['label'] : array('icon' => '⭐', 'text' => 'Мнение наших гостей');
    $hero_title = isset($hero_section['title']) ? $hero_section['title'] : 'Отзывы о';
    $hero_title_accent = isset($hero_section['title_accent']) ? $hero_section['title_accent'] : 'Банкетном зале Shen';
    $hero_subtitle = isset($hero_section['subtitle']) ? $hero_section['subtitle'] : 'Нам доверяют тысячи гостей! Более 2900 оценок подтверждают наш профессионализм.' . "\n" . 'Спасибо за ваше доверие и максимальный рейтинг 5.0!';
    $hero_stats = isset($hero_section['stats']) ? $hero_section['stats'] : array(
        array('value' => '5.0', 'stars' => '⭐⭐⭐⭐⭐', 'label' => ''),
        array('value' => '2926', 'stars' => '', 'label' => 'Оценок'),
        array('value' => '99%', 'stars' => '', 'label' => 'Довольных гостей')
    );
    
    // Fallback изображения для слайдера
    $default_slides = array(
        get_template_directory_uri() . '/img/1.webp',
        get_template_directory_uri() . '/img/2.webp',
        get_template_directory_uri() . '/img/3.webp'
    );
    ?>
    <section class="reviews-hero">
        <!-- Фоновое слайдшоу -->
        <div class="reviews-hero__background">
            <div class="reviews-hero__slideshow">
                <?php if (!empty($hero_slideshow)) : ?>
                    <?php foreach ($hero_slideshow as $index => $slide) : 
                        $image_url = is_array($slide) ? $slide['url'] : wp_get_attachment_image_url($slide, 'full');
                        $image_alt = is_array($slide) ? $slide['alt'] : get_post_meta($slide, '_wp_attachment_image_alt', true);
                        if (empty($image_alt)) $image_alt = 'Банкетный зал Shen';
                    ?>
                        <div class="reviews-hero__slide <?php echo $index === 0 ? 'reviews-hero__slide--active' : ''; ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach ($default_slides as $index => $slide_url) : ?>
                        <div class="reviews-hero__slide <?php echo $index === 0 ? 'reviews-hero__slide--active' : ''; ?>">
                            <img src="<?php echo esc_url($slide_url); ?>" alt="Банкетный зал Shen">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="reviews-hero__overlay"></div>
        </div>

        <!-- Контент Hero -->
        <div class="reviews-hero__container container">
            <div class="reviews-hero__content">
                <?php if (!empty($hero_label)) : 
                    $label_icon = isset($hero_label['icon']) ? $hero_label['icon'] : '⭐';
                    $label_text = isset($hero_label['text']) ? $hero_label['text'] : 'Мнение наших гостей';
                ?>
                <span class="reviews-hero__label">
                    <span class="reviews-hero__label-icon"><?php echo esc_html($label_icon); ?></span>
                    <span class="reviews-hero__label-text"><?php echo esc_html($label_text); ?></span>
                </span>
                <?php endif; ?>
                
                <h1 class="reviews-hero__title"><?php echo esc_html($hero_title); ?><br><span class="reviews-hero__title-accent"><?php echo esc_html($hero_title_accent); ?></span></h1>
                
                <?php if (!empty($hero_subtitle)) : ?>
                <p class="reviews-hero__subtitle">
                    <?php echo nl2br(esc_html($hero_subtitle)); ?>
                </p>
                <?php endif; ?>

                <!-- Статистика в Hero -->
                <?php if (!empty($hero_stats)) : ?>
                <div class="reviews-hero__stats">
                    <?php foreach ($hero_stats as $stat) : 
                        $stat_value = isset($stat['value']) ? $stat['value'] : '';
                        $stat_stars = isset($stat['stars']) ? $stat['stars'] : '';
                        $stat_label = isset($stat['label']) ? $stat['label'] : '';
                    ?>
                    <div class="reviews-hero__stat">
                        <?php if (!empty($stat_value)) : ?>
                        <div class="reviews-hero__stat-value"><?php echo esc_html($stat_value); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($stat_stars)) : ?>
                        <div class="reviews-hero__stat-stars"><?php echo esc_html($stat_stars); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($stat_label)) : ?>
                        <div class="reviews-hero__stat-label"><?php echo esc_html($stat_label); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Индикатор прокрутки -->
        <div class="reviews-hero__scroll" data-scroll-to="#reviews-stats" role="button" tabindex="0" aria-label="Прокрутить к статистике отзывов">
            <div class="reviews-hero__scroll-arrow">
                <span>↓</span>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <?php 
    $stats_section = banket_get_field('reviews_stats_section', array());
    $stats_label = isset($stats_section['label']) ? $stats_section['label'] : 'Наша статистика';
    $stats_title = isset($stats_section['title']) ? $stats_section['title'] : 'Что говорят цифры';
    $stats_main = isset($stats_section['main']) ? $stats_section['main'] : array('rating' => '5.0', 'stars' => '⭐⭐⭐⭐⭐', 'text' => 'На основе 2926 оценок');
    $stats_distribution = isset($stats_section['distribution']) ? $stats_section['distribution'] : array(
        array('stars' => '5★', 'percent' => 96),
        array('stars' => '4★', 'percent' => 3),
        array('stars' => '3★', 'percent' => 1),
        array('stars' => '2★', 'percent' => 0),
        array('stars' => '1★', 'percent' => 0)
    );
    ?>
    <section class="reviews-stats" id="reviews-stats">
        <div class="reviews-stats__container container">
            <div class="reviews-stats__header">
                <?php if (!empty($stats_label)) : ?>
                <span class="reviews-stats__label"><?php echo esc_html($stats_label); ?></span>
                <?php endif; ?>
                <h2 class="reviews-stats__title section-title"><?php echo esc_html($stats_title); ?></h2>
                <div class="reviews-stats__divider">
                    <span class="reviews-stats__divider-line"></span>
                    <span class="reviews-stats__divider-icon">📊</span>
                    <span class="reviews-stats__divider-line"></span>
                </div>
            </div>

            <div class="reviews-stats__grid">
                <!-- Общий рейтинг -->
                <?php if (!empty($stats_main)) : 
                    $main_rating = isset($stats_main['rating']) ? $stats_main['rating'] : '5.0';
                    $main_stars = isset($stats_main['stars']) ? $stats_main['stars'] : '⭐⭐⭐⭐⭐';
                    $main_text = isset($stats_main['text']) ? $stats_main['text'] : 'На основе 2926 оценок';
                ?>
                <div class="reviews-stats__card reviews-stats__card--main">
                    <div class="reviews-stats__rating-big"><?php echo esc_html($main_rating); ?></div>
                    <div class="reviews-stats__stars"><?php echo esc_html($main_stars); ?></div>
                    <p class="reviews-stats__text"><?php echo esc_html($main_text); ?></p>
                </div>
                <?php endif; ?>

                <!-- Распределение оценок -->
                <?php if (!empty($stats_distribution)) : ?>
                <div class="reviews-stats__card reviews-stats__card--distribution">
                    <h3 class="reviews-stats__card-title">Распределение оценок</h3>
                    <div class="reviews-stats__bars">
                        <?php foreach ($stats_distribution as $dist) : 
                            $dist_stars = isset($dist['stars']) ? $dist['stars'] : '';
                            $dist_percent = isset($dist['percent']) ? intval($dist['percent']) : 0;
                        ?>
                        <div class="reviews-stats__bar">
                            <span class="reviews-stats__bar-label"><?php echo esc_html($dist_stars); ?></span>
                            <div class="reviews-stats__bar-track">
                                <div class="reviews-stats__bar-fill" style="width: <?php echo esc_attr($dist_percent); ?>%"></div>
                            </div>
                            <span class="reviews-stats__bar-value"><?php echo esc_html($dist_percent); ?>%</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Yandex Reviews Widget -->
    <?php 
    $yandex_section = banket_get_field('reviews_yandex_section', array());
    $yandex_label = isset($yandex_section['label']) ? $yandex_section['label'] : 'Яндекс Карты';
    $yandex_title = isset($yandex_section['title']) ? $yandex_section['title'] : 'Отзывы на Яндексе';
    $yandex_subtitle = isset($yandex_section['subtitle']) ? $yandex_section['subtitle'] : 'Мы также собираем отзывы на Яндекс Картах. Будем благодарны за ваше мнение!';
    $yandex_widget_url = isset($yandex_section['widget_url']) ? $yandex_section['widget_url'] : 'https://yandex.ru/maps-reviews-widget/1013938334?comments';
    $yandex_widget_height = isset($yandex_section['widget_height']) ? intval($yandex_section['widget_height']) : 800;
    $yandex_map_url = isset($yandex_section['map_url']) ? $yandex_section['map_url'] : 'https://yandex.ru/maps/org/shen/1013938334/';
    $yandex_reviews_url = isset($yandex_section['reviews_url']) ? $yandex_section['reviews_url'] : 'https://yandex.ru/maps/org/1013938334/reviews';
    $yandex_button_text = isset($yandex_section['button_text']) ? $yandex_section['button_text'] : 'Все отзывы на Яндекс Картах';
    ?>
    <section class="yandex-widget">
        <div class="yandex-widget__container container">
            <div class="yandex-widget__header">
                <?php if (!empty($yandex_label)) : ?>
                <span class="yandex-widget__label"><?php echo esc_html($yandex_label); ?></span>
                <?php endif; ?>
                <h2 class="yandex-widget__title section-title"><?php echo esc_html($yandex_title); ?></h2>
                <div class="yandex-widget__divider">
                    <span class="yandex-widget__divider-line"></span>
                    <span class="yandex-widget__divider-icon">🗺</span>
                    <span class="yandex-widget__divider-line"></span>
                </div>
                <?php if (!empty($yandex_subtitle)) : ?>
                <p class="yandex-widget__subtitle">
                    <?php echo nl2br(esc_html($yandex_subtitle)); ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Виджет Яндекс карт -->
            <?php if (!empty($yandex_widget_url)) : ?>
            <div class="yandex-widget__embed">
                <div style="width:100%;height:<?php echo esc_attr($yandex_widget_height); ?>px;overflow:hidden;position:relative;">
                    <iframe 
                        style="width:100%;height:100%;border:1px solid #e6e6e6;border-radius:20px;box-sizing:border-box" 
                        src="<?php echo esc_url($yandex_widget_url); ?>">
                    </iframe>
                    <?php if (!empty($yandex_map_url)) : ?>
                    <a href="<?php echo esc_url($yandex_map_url); ?>" 
                       target="_blank" 
                       style="box-sizing:border-box;text-decoration:none;color:#b3b3b3;font-size:10px;font-family:YS Text,sans-serif;padding:0 20px;position:absolute;bottom:8px;width:100%;text-align:center;left:0;overflow:hidden;text-overflow:ellipsis;display:block;max-height:14px;white-space:nowrap;padding:0 16px;box-sizing:border-box">
                        Shen на карте Симферополя — Яндекс Карты
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Кнопка к отзывам на Яндекс -->
            <?php if (!empty($yandex_reviews_url)) : ?>
            <div class="yandex-widget__cta">
                <a href="<?php echo esc_url($yandex_reviews_url); ?>" target="_blank" class="yandex-widget__button">
                    <span class="yandex-widget__button-text"><?php echo esc_html($yandex_button_text); ?></span>
                    <svg class="yandex-widget__button-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>


  <!-- Gallery Section -->
  <?php 
  $gallery_section = banket_get_field('reviews_gallery_section', array());
  $gallery_title = isset($gallery_section['title']) ? $gallery_section['title'] : 'Галерея';
  $gallery_subtitle = isset($gallery_section['subtitle']) ? $gallery_section['subtitle'] : 'Атмосфера наших залов и мероприятий';
  $gallery_images = isset($gallery_section['images']) ? $gallery_section['images'] : array();
  $gallery_large_items = isset($gallery_section['large_items']) ? $gallery_section['large_items'] : array();
  $gallery_link_text = isset($gallery_section['link_text']) ? $gallery_section['link_text'] : 'Смотреть все фото';
  $gallery_link_url = isset($gallery_section['link_url']) ? $gallery_section['link_url'] : '';
  if (empty($gallery_link_url)) {
      $gallery_link_url = home_url('/галерея/');
  }
  
  // Формируем массив больших индексов
  $large_indexes = array();
  if (!empty($gallery_large_items)) {
      foreach ($gallery_large_items as $large_item) {
          if (isset($large_item['index'])) {
              $large_indexes[] = intval($large_item['index']);
          }
      }
  }
  
  // Fallback изображения
  $default_gallery_images = array(
      get_template_directory_uri() . '/img/13.webp',
      get_template_directory_uri() . '/img/eat1.webp',
      get_template_directory_uri() . '/img/11.webp',
      get_template_directory_uri() . '/img/5.webp',
      get_template_directory_uri() . '/img/4.webp',
      get_template_directory_uri() . '/img/6.webp',
      get_template_directory_uri() . '/img/10.webp',
      get_template_directory_uri() . '/img/1.webp',
      get_template_directory_uri() . '/img/eat2.webp',
      get_template_directory_uri() . '/img/eat4.webp',
      get_template_directory_uri() . '/img/eat5.webp',
      get_template_directory_uri() . '/img/3.webp',
      get_template_directory_uri() . '/img/12.webp',
      get_template_directory_uri() . '/img/2.webp'
  );
  $gallery_images = banket_get_gallery('reviews_gallery_section_images', 'full', $default_gallery_images);
  ?>
  <section class="gallery" id="gallery">
    <div class="gallery__container container">
        <div class="gallery__header">
            <h2 class="gallery__title section-title"><?php echo esc_html($gallery_title); ?></h2>
            <?php if (!empty($gallery_subtitle)) : ?>
            <p class="gallery__subtitle section-subtitle">
                <?php echo esc_html($gallery_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($gallery_images)) : ?>
        <div class="gallery__grid">
            <?php foreach ($gallery_images as $index => $image) : 
                $image_url = isset($image['url']) ? $image['url'] : $image;
                $image_alt = isset($image['alt']) ? $image['alt'] : 'Галерея';
                if (empty($image_alt)) $image_alt = 'Галерея';
                $is_large = in_array($index, $large_indexes);
            ?>
            <div class="gallery__item <?php echo $is_large ? 'gallery__item--large' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="gallery__img">
                <div class="gallery__overlay">
                    <svg class="gallery__zoom-icon" width="40" height="40" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                        <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Lightbox Modal -->
        <?php
        $lightbox_args = array(
            'variant' => 'simple',
            'id'      => 'galleryLightbox',
        );
        set_query_var( 'lightbox_args', $lightbox_args );
        get_template_part( 'template-parts/lightbox-gallery' );
        ?>

        <?php if (!empty($gallery_link_text)) : ?>
        <div class="gallery__footer">
            <a href="<?php echo esc_url($gallery_link_url); ?>" class="gallery__link button button--primary">
                <?php echo esc_html($gallery_link_text); ?>
                <svg class="gallery__link-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7 4l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

    <!-- CTA Section -->
    <?php 
    $cta_section = banket_get_field('reviews_cta_section', array());
    $cta_label = isset($cta_section['label']) ? $cta_section['label'] : 'Поделитесь впечатлениями';
    $cta_title = isset($cta_section['title']) ? $cta_section['title'] : 'Оставьте свой отзыв';
    $cta_description = isset($cta_section['description']) ? $cta_section['description'] : 'Ваше мнение очень важно для нас! Если вы уже посетили наш банкетный зал,' . "\n" . 'будем благодарны за отзыв на Яндекс Картах.';
    $cta_button_primary = isset($cta_section['button_primary']) ? $cta_section['button_primary'] : array('text' => 'Оставить отзыв на Яндекс', 'url' => 'https://yandex.ru/maps/org/1013938334/reviews');
    $cta_button_secondary = isset($cta_section['button_secondary']) ? $cta_section['button_secondary'] : array('text' => 'Забронировать мероприятие', 'action' => 'open-booking', 'url' => '');
    if (empty($cta_button_secondary['url'])) {
        $cta_button_secondary['url'] = home_url('/контакты/');
    }
    ?>
    <section class="about about--cta">
        <div class="about__container container">
            <div class="about__header">
                <?php if (!empty($cta_label)) : ?>
                <span class="about__label"><?php echo esc_html($cta_label); ?></span>
                <?php endif; ?>
                <h2 class="about__title section-title"><?php echo esc_html($cta_title); ?></h2>
                <div class="about__divider">
                    <span class="about__divider-line"></span>
                    <span class="about__divider-icon">✨</span>
                    <span class="about__divider-line"></span>
                </div>
                <?php if (!empty($cta_description)) : ?>
                <p class="about__description">
                    <?php echo nl2br(esc_html($cta_description)); ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="about__cta-buttons">
                <?php if (!empty($cta_button_primary)) : 
                    $btn_primary_text = isset($cta_button_primary['text']) ? $cta_button_primary['text'] : 'Оставить отзыв на Яндекс';
                    $btn_primary_url = isset($cta_button_primary['url']) ? $cta_button_primary['url'] : '';
                ?>
                <a href="<?php echo esc_url($btn_primary_url); ?>" target="_blank" class="hero__button hero__button--primary">
                    <?php echo esc_html($btn_primary_text); ?>
                </a>
                <?php endif; ?>
                
                <?php if (!empty($cta_button_secondary)) : 
                    $btn_secondary_text = isset($cta_button_secondary['text']) ? $cta_button_secondary['text'] : 'Забронировать мероприятие';
                    $btn_secondary_url = isset($cta_button_secondary['url']) ? $cta_button_secondary['url'] : '';
                    $btn_secondary_action = isset($cta_button_secondary['action']) ? $cta_button_secondary['action'] : '';
                ?>
                <a href="<?php echo esc_url($btn_secondary_url); ?>" class="hero__button hero__button--secondary" <?php echo !empty($btn_secondary_action) ? 'data-action="' . esc_attr($btn_secondary_action) . '"' : ''; ?>>
                    <?php echo esc_html($btn_secondary_text); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Кнопка "Наверх" -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Наверх">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <!-- Модальное окно для формы обратной связи -->
    <div class="modal" id="bookingModal">
        <div class="modal__overlay"></div>
        <div class="modal__container">
            <button class="modal__close" aria-label="Закрыть модальное окно">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            
            <div class="modal__content">
                <div class="modal__header">
                    <div class="modal__icon-wrapper">
                        <svg class="modal__icon" width="48" height="48" viewBox="0 0 24 24" fill="none">
                            <path d="M3 8L10.89 13.26C11.2187 13.4793 11.6049 13.5963 12 13.5963C12.3951 13.5963 12.7813 13.4793 13.11 13.26L21 8M5 19H19C19.5304 19 20.0391 18.7893 20.4142 18.4142C20.7893 18.0391 21 17.5304 21 17V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H5C4.46957 5 3.96086 5.21071 3.58579 5.58579C3.21071 5.96086 3 6.46957 3 7V17C3 17.5304 3.21071 18.0391 3.58579 18.4142C3.96086 18.7893 4.46957 19 5 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="modal__title">Забронировать зал</h2>
                    <p class="modal__subtitle">Оставьте заявку и мы свяжемся с вами в ближайшее время</p>
                </div>

                <form class="modal__form" id="modalBookingForm">
                    <div class="modal__field">
                        <label for="modalName" class="modal__label">Ваше имя</label>
                        <input 
                            type="text" 
                            id="modalName" 
                            name="name" 
                            class="modal__input" 
                            placeholder="Введите ваше имя"
                            required
                        >
                    </div>

                    <div class="modal__field">
                        <label for="modalPhone" class="modal__label">Номер телефона</label>
                        <input 
                            type="tel" 
                            id="modalPhone" 
                            name="phone" 
                            class="modal__input" 
                            placeholder="+7 (978) 187-28-27"
                            required
                        >
                    </div>

                    <div class="modal__field">
                        <label for="modalComment" class="modal__label">Комментарий</label>
                        <textarea 
                            id="modalComment" 
                            name="comment" 
                            class="modal__textarea" 
                            placeholder="Расскажите о вашем мероприятии..."
                            rows="4"
                        ></textarea>
                    </div>

                    <div class="modal__privacy">
                        <label class="modal__checkbox">
                            <input type="checkbox" class="modal__checkbox-input" required>
                            <span class="modal__checkbox-custom"></span>
                            <span class="modal__checkbox-text">
                                Я принимаю условия <a href="<?php echo esc_url( home_url('/политика-конфиденциальности/') ); ?>" target="_blank" class="modal__privacy-link">политики конфиденциальности</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="modal__button">
                        <span class="modal__button-text">Отправить заявку</span>
                        <svg class="modal__button-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="modal__message" id="modalMessage"></div>
                </form>
            </div>
        </div>
    </div>

    <?php get_footer(); ?>
</body>
</html>

