<?php
/**
 * Template Name: Галерея
 * Description: Шаблон страницы галереи
 */ 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Галерея фотографий банкетного зала Shen. Более 40 фотографий интерьеров, блюд, мероприятий и деталей оформления. Вдохновитесь атмосферой наших залов.">
    <title>Галерея — Банкетный зал Shen | Фото залов, блюд и мероприятий</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-simple.svg">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body class="gallery-page">
    

<?php get_header(); ?>
  
    <!-- Main Content -->
    <main class="main">
        
        <!-- Gallery Hero Section -->
        <?php 
        $hero_section = banket_get_field('gallery_hero_section', array());
        $hero_slideshow = isset($hero_section['slideshow']) ? $hero_section['slideshow'] : array();
        $hero_label = isset($hero_section['label']) ? $hero_section['label'] : array('icon' => '📸', 'text' => 'Наша галерея');
        $hero_title = isset($hero_section['title']) ? $hero_section['title'] : 'Галерея';
        $hero_title_accent = isset($hero_section['title_accent']) ? $hero_section['title_accent'] : 'Shen';
        $hero_subtitle = isset($hero_section['subtitle']) ? $hero_section['subtitle'] : 'Вдохновитесь атмосферой наших залов, изысканными блюдами' . "\n" . 'и незабываемыми мероприятиями. Бесконечная коллекция моментов счастья.';
        $hero_stats = isset($hero_section['stats']) ? $hero_section['stats'] : array(
            array('value' => '∞', 'label' => 'Вдохновения'),
            array('value' => '4', 'label' => 'Категории'),
            array('value' => '1000+', 'label' => 'Мероприятий')
        );
        
        // Fallback изображения для слайдера
        $default_slides = array(
            get_template_directory_uri() . '/img/1.webp',
            get_template_directory_uri() . '/img/13.webp',
            get_template_directory_uri() . '/img/10.webp',
            get_template_directory_uri() . '/img/eat1.webp'
        );
        ?>
        <section class="gallery-hero">
            <!-- Фоновое слайдшоу -->
            <div class="gallery-hero__background">
                <div class="gallery-hero__slideshow">
                    <?php if (!empty($hero_slideshow)) : ?>
                        <?php foreach ($hero_slideshow as $index => $slide) : 
                            $image_url = is_array($slide) ? $slide['url'] : wp_get_attachment_image_url($slide, 'full');
                            $image_alt = is_array($slide) ? $slide['alt'] : get_post_meta($slide, '_wp_attachment_image_alt', true);
                            if (empty($image_alt)) $image_alt = 'Интерьер банкетного зала Shen';
                        ?>
                            <div class="gallery-hero__slide <?php echo $index === 0 ? 'gallery-hero__slide--active' : ''; ?>">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach ($default_slides as $index => $slide_url) : ?>
                            <div class="gallery-hero__slide <?php echo $index === 0 ? 'gallery-hero__slide--active' : ''; ?>">
                                <img src="<?php echo esc_url($slide_url); ?>" alt="Интерьер банкетного зала Shen">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="gallery-hero__overlay"></div>
            </div>

            <!-- Hero Content -->
            <div class="gallery-hero__container container">
                <div class="gallery-hero__content">
                    <?php if (!empty($hero_label)) : 
                        $label_icon = isset($hero_label['icon']) ? $hero_label['icon'] : '📸';
                        $label_text = isset($hero_label['text']) ? $hero_label['text'] : 'Наша галерея';
                    ?>
                    <span class="gallery-hero__label">
                        <span class="gallery-hero__label-icon"><?php echo esc_html($label_icon); ?></span>
                        <span class="gallery-hero__label-text"><?php echo esc_html($label_text); ?></span>
                    </span>
                    <?php endif; ?>
                    
                    <h1 class="gallery-hero__title">
                        <?php echo esc_html($hero_title); ?> <span class="gallery-hero__title-accent"><?php echo esc_html($hero_title_accent); ?></span>
                    </h1>
                    
                    <?php if (!empty($hero_subtitle)) : ?>
                    <p class="gallery-hero__subtitle">
                        <?php echo nl2br(esc_html($hero_subtitle)); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Статистика -->
                    <?php if (!empty($hero_stats)) : ?>
                    <div class="gallery-hero__stats">
                        <?php foreach ($hero_stats as $stat) : 
                            $stat_value = isset($stat['value']) ? $stat['value'] : '';
                            $stat_label = isset($stat['label']) ? $stat['label'] : '';
                        ?>
                        <div class="gallery-hero__stat">
                            <?php if (!empty($stat_value)) : ?>
                            <div class="gallery-hero__stat-value"><?php echo esc_html($stat_value); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($stat_label)) : ?>
                            <div class="gallery-hero__stat-label"><?php echo esc_html($stat_label); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Индикатор прокрутки -->
            <div class="gallery-hero__scroll" data-scroll-to="#gallery-filters" role="button" tabindex="0" aria-label="Прокрутить к фильтрам галереи">
                <div class="gallery-hero__scroll-arrow">
                    <span>↓</span>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <?php 
        $filters_section = banket_get_field('gallery_filters_section', array());
        $filters_title = isset($filters_section['title']) ? $filters_section['title'] : 'Выберите категорию';
        $filters_list = isset($filters_section['filters']) ? $filters_section['filters'] : array();
        
        // Определяем активный фильтр
        $active_filter_id = 'all';
        if (!empty($filters_list)) {
            foreach ($filters_list as $filter) {
                if (isset($filter['active']) && $filter['active']) {
                    $active_filter_id = isset($filter['filter_id']) ? $filter['filter_id'] : 'all';
                    break;
                }
            }
        }
        ?>
        <section class="gallery-filters" id="gallery-filters">
            <div class="gallery-filters__container container">
                <h2 class="gallery-filters__title"><?php echo esc_html($filters_title); ?></h2>
                <?php if (!empty($filters_list)) : ?>
                <div class="gallery-filters__buttons">
                    <?php foreach ($filters_list as $filter) : 
                        $filter_id = isset($filter['filter_id']) ? $filter['filter_id'] : '';
                        $filter_icon = isset($filter['icon']) ? $filter['icon'] : '';
                        $filter_text = isset($filter['text']) ? $filter['text'] : '';
                        $filter_count = isset($filter['count']) ? intval($filter['count']) : 0;
                        $is_active = ($filter_id === $active_filter_id);
                    ?>
                    <button class="gallery-filters__btn <?php echo $is_active ? 'gallery-filters__btn--active' : ''; ?>" data-filter="<?php echo esc_attr($filter_id); ?>">
                        <?php if (!empty($filter_icon)) : ?>
                        <span class="gallery-filters__icon"><?php echo esc_html($filter_icon); ?></span>
                        <?php endif; ?>
                        <span class="gallery-filters__text"><?php echo esc_html($filter_text); ?></span>
                        <span class="gallery-filters__count" id="count-<?php echo esc_attr($filter_id); ?>"><?php echo esc_html($filter_count); ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Masonry Gallery Grid -->
        <?php 
        $images_section = banket_get_field('gallery_images_section', array());
        $gallery_items = isset($images_section['items']) ? $images_section['items'] : array();
        $items_per_page = isset($images_section['items_per_page']) ? intval($images_section['items_per_page']) : 12;
        $load_more_text = isset($images_section['load_more_text']) ? $images_section['load_more_text'] : 'Загрузить ещё';
        ?>
        <section class="gallery-masonry">
            <div class="gallery-masonry__container container">
                <div class="gallery-masonry__grid" id="galleryGrid">
                    <?php if (!empty($gallery_items)) : 
                        $visible_count = 0;
                        foreach ($gallery_items as $item) : 
                            $image = isset($item['image']) ? $item['image'] : array();
                            $category = isset($item['category']) ? $item['category'] : '';
                            $category_label = isset($item['category_label']) ? $item['category_label'] : array('icon' => '', 'text' => '');
                            $visible = isset($item['visible']) ? $item['visible'] : true;
                            
                            // Определяем, должно ли изображение быть скрыто
                            $is_hidden = false;
                            if (!$visible || $visible_count >= $items_per_page) {
                                $is_hidden = true;
                            }
                            if ($visible) {
                                $visible_count++;
                            }
                            
                            // Получаем данные изображения
                            if (is_array($image)) {
                                $image_url = isset($image['url']) ? $image['url'] : '';
                                $image_alt = isset($image['alt']) ? $image['alt'] : '';
                            } elseif (is_numeric($image)) {
                                $image_url = wp_get_attachment_image_url($image, 'full');
                                $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                            } else {
                                continue;
                            }
                            
                            if (empty($image_alt)) $image_alt = 'Галерея';
                            
                            // Формируем подпись категории
                            $category_icon = isset($category_label['icon']) ? $category_label['icon'] : '';
                            $category_text = isset($category_label['text']) ? $category_label['text'] : '';
                            $category_label_full = trim($category_icon . ' ' . $category_text);
                    ?>
                    <article class="gallery-card <?php echo $is_hidden ? 'gallery-card--hidden' : ''; ?>" data-category="<?php echo esc_attr($category); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="gallery-card__image" loading="lazy">
                        <div class="gallery-card__overlay">
                            <svg class="gallery-card__zoom" width="40" height="40" viewBox="0 0 24 24" fill="none">
                                <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                                <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <?php if (!empty($category_label_full)) : ?>
                        <span class="gallery-card__category"><?php echo esc_html($category_label_full); ?></span>
                        <?php endif; ?>
                    </article>
                    <?php 
                        endforeach;
                    endif; 
                    ?>

                </div>

                <!-- Load More Button -->
                <?php if (!empty($load_more_text)) : ?>
                <div class="gallery-masonry__load-more" id="loadMoreSection">
                    <button class="gallery-masonry__load-btn" id="loadMoreBtn">
                        <span class="gallery-masonry__load-text"><?php echo esc_html($load_more_text); ?></span>
                        <svg class="gallery-masonry__load-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Lightbox Modal -->
        <?php
        $lightbox_args = array(
            'variant' => 'full',
            'id'      => 'galleryLightbox',
        );
        set_query_var( 'lightbox_args', $lightbox_args );
        get_template_part( 'template-parts/lightbox-gallery' );
        ?>

        <!-- Booking Section -->
        <?php 
        $booking_section = banket_get_field('gallery_booking_section', array());
        $booking_label = isset($booking_section['label']) ? $booking_section['label'] : '';
        $booking_title = isset($booking_section['title']) ? $booking_section['title'] : 'ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ';
        $booking_subtitle = isset($booking_section['subtitle']) ? $booking_section['subtitle'] : 'Оставьте заявку и мы свяжемся с вами для обсуждения деталей';
        $booking_wrapper = isset($booking_section['wrapper']) ? $booking_section['wrapper'] : true;
        $booking_form_id = isset($booking_section['form_id']) ? $booking_section['form_id'] : 'bookingForm';
        
        $booking_args = array(
            'label'    => $booking_label,
            'title'    => $booking_title,
            'subtitle' => $booking_subtitle,
            'wrapper'  => $booking_wrapper,
            'form_id'  => $booking_form_id,
        );
        set_query_var( 'booking_args', $booking_args );
        get_template_part( 'template-parts/section-booking' );
        ?>

    </main>

    <!-- Кнопка "Наверх" -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Наверх">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

     <!-- Footer -->
     <footer class="footer">
    <?php get_footer(); ?>
</body>
</html>

