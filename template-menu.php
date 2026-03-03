<?php
/**
 * Template Name: Меню
 * Description: Шаблон страницы меню
 */ 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Меню банкетного зала Shen. Восточная и европейская кухня, продукты Халяль, свежее приготовление из печи. Банкетные сеты, горячие блюда, десерты.">
    <title>Меню — Банкетный зал Shen | Восточная и Европейская кухня</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-simple.svg">
    <link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-simple.svg">
    <link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-simple.svg">
    
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>
<body class="page-menu">
     
    <!-- Hero Section -->
    <?php 
    $hero_section = banket_get_field('menu_hero_section', array());
    $hero_slideshow = isset($hero_section['slideshow']) ? $hero_section['slideshow'] : array();
    $hero_badges = isset($hero_section['badges']) ? $hero_section['badges'] : array(
        array('type' => 'halal', 'icon' => '⭐', 'text' => 'Халяль'),
        array('type' => 'fresh', 'icon' => '🔥', 'text' => 'Свежее из печи')
    );
    $hero_title_line = isset($hero_section['title_line']) ? $hero_section['title_line'] : 'Наше';
    $hero_title_accent = isset($hero_section['title_accent']) ? $hero_section['title_accent'] : 'Меню';
    $hero_subtitle = isset($hero_section['subtitle']) ? $hero_section['subtitle'] : 'Восточная и европейская кухня премиум-класса.' . "\n" . 'Свежее приготовление блюд непосредственно перед подачей.';
    $hero_button_primary = isset($hero_section['button_primary']) ? $hero_section['button_primary'] : array('text' => 'Смотреть меню', 'action' => '#menu-gallery');
    $hero_button_secondary = isset($hero_section['button_secondary']) ? $hero_section['button_secondary'] : array('text' => 'Консультация шефа', 'phone' => '+7 (978) 8064657');
    
    // Fallback изображения для слайдера
    $default_slides = array(
        get_template_directory_uri() . '/img/eat2.webp',
        get_template_directory_uri() . '/img/eat4.webp',
        get_template_directory_uri() . '/img/eat8.webp'
    );
    ?>
    <section class="menu-hero">
        <?php get_header(); ?>
        
        <!-- Hero Background -->
        <div class="menu-hero__background">
            <div class="menu-hero__slideshow">
                <?php if (!empty($hero_slideshow)) : ?>
                    <?php foreach ($hero_slideshow as $index => $slide) : 
                        $image_url = is_array($slide) ? $slide['url'] : wp_get_attachment_image_url($slide, 'full');
                        $image_alt = is_array($slide) ? $slide['alt'] : get_post_meta($slide, '_wp_attachment_image_alt', true);
                        if (empty($image_alt)) $image_alt = 'Блюда банкетного зала Shen';
                    ?>
                        <div class="menu-hero__slide <?php echo $index === 0 ? 'menu-hero__slide--active' : ''; ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach ($default_slides as $index => $slide_url) : ?>
                        <div class="menu-hero__slide <?php echo $index === 0 ? 'menu-hero__slide--active' : ''; ?>">
                            <img src="<?php echo esc_url($slide_url); ?>" alt="Блюда банкетного зала Shen" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="menu-hero__overlay"></div>
        </div>
        
        <!-- Декоративные элементы -->
        <div class="menu-hero__decorative-lines">
            <div class="menu-hero__line menu-hero__line--left"></div>
            <div class="menu-hero__line menu-hero__line--right"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="menu-hero__container container">
            <div class="menu-hero__content">
                <?php if (!empty($hero_badges)) : ?>
                <div class="menu-hero__badges">
                    <?php foreach ($hero_badges as $badge) : 
                        $badge_type = isset($badge['type']) ? $badge['type'] : 'halal';
                        $badge_icon = isset($badge['icon']) ? $badge['icon'] : '⭐';
                        $badge_text = isset($badge['text']) ? $badge['text'] : 'Халяль';
                    ?>
                    <div class="menu-hero__badge menu-hero__badge--<?php echo esc_attr($badge_type); ?>">
                        <span class="menu-hero__badge-icon"><?php echo esc_html($badge_icon); ?></span>
                        <span class="menu-hero__badge-text"><?php echo esc_html($badge_text); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <div class="menu-hero__title-wrapper">
                    <div class="menu-hero__title-decoration menu-hero__title-decoration--left"></div>
                    <h1 class="menu-hero__title">
                        <span class="menu-hero__title-line"><?php echo esc_html($hero_title_line); ?></span>
                        <span class="menu-hero__title-accent"><?php echo esc_html($hero_title_accent); ?></span>
                    </h1>
                    <div class="menu-hero__title-decoration menu-hero__title-decoration--right"></div>
                </div>
                
                <?php if (!empty($hero_subtitle)) : ?>
                <p class="menu-hero__subtitle">
                    <?php echo nl2br(esc_html($hero_subtitle)); ?>
                </p>
                <?php endif; ?>
                
                <div class="menu-hero__buttons">
                    <?php if (!empty($hero_button_primary)) : 
                        $btn_primary_text = isset($hero_button_primary['text']) ? $hero_button_primary['text'] : 'Смотреть меню';
                        $btn_primary_action = isset($hero_button_primary['action']) ? $hero_button_primary['action'] : '#menu-gallery';
                    ?>
                    <a href="<?php echo esc_url($btn_primary_action); ?>" class="menu-hero__button menu-hero__button--primary">
                        <span><?php echo esc_html($btn_primary_text); ?></span>
                        <svg class="menu-hero__button-arrow" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($hero_button_secondary)) : 
                        $btn_secondary_text = isset($hero_button_secondary['text']) ? $hero_button_secondary['text'] : 'Консультация шефа';
                        $btn_secondary_phone = isset($hero_button_secondary['phone']) ? $hero_button_secondary['phone'] : '+7 (978) 8064657';
                    ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $btn_secondary_phone)); ?>" class="menu-hero__button menu-hero__button--secondary">
                        <span><?php echo esc_html($btn_secondary_text); ?></span>
                        <svg class="menu-hero__button-phone" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M3.5 2C2.67 2 2 2.67 2 3.5V14.5C2 15.33 2.67 16 3.5 16H14.5C15.33 16 16 15.33 16 14.5V3.5C16 2.67 15.33 2 14.5 2H3.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7 5H11M7 8H11M7 11H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <?php 
    $gallery_section = banket_get_field('menu_gallery_section', array());
    $gallery_title = isset($gallery_section['title']) ? $gallery_section['title'] : 'Галерея блюд';
    $gallery_subtitle = isset($gallery_section['subtitle']) ? $gallery_section['subtitle'] : 'Вдохновитесь нашими блюдами';
    $gallery_images = isset($gallery_section['images']) ? $gallery_section['images'] : array();
    
    // Fallback изображения
    $default_gallery_images = array();
    for ($i = 1; $i <= 9; $i++) {
        $default_gallery_images[] = get_template_directory_uri() . '/img/menu/' . $i . '.jpg';
    }
    $gallery_images = banket_get_gallery('menu_gallery_section_images', 'full', $default_gallery_images);
    ?>
    <section class="menu-gallery" id="menu-gallery">
        <div class="menu-gallery__container container">
            <div class="menu-gallery__header">
                <h2 class="menu-gallery__title section-title"><?php echo esc_html($gallery_title); ?></h2>
                <?php if (!empty($gallery_subtitle)) : ?>
                <p class="menu-gallery__subtitle section-subtitle">
                    <?php echo esc_html($gallery_subtitle); ?>
                </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($gallery_images)) : ?>
            <div class="menu-gallery__grid">
                <?php foreach ($gallery_images as $index => $image) : 
                    $image_url = isset($image['url']) ? $image['url'] : $image;
                    $image_alt = isset($image['alt']) ? $image['alt'] : 'Блюдо из меню Shen';
                    if (empty($image_alt)) $image_alt = 'Блюдо из меню Shen';
                ?>
                <div class="menu-gallery__item" data-index="<?php echo esc_attr($index); ?>">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="menu-gallery__img" loading="lazy">
                    <div class="menu-gallery__overlay">
                        <svg class="menu-gallery__zoom-icon" width="40" height="40" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                            <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <path d="M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <?php endforeach; ?>  
            </div>
            <?php endif; ?>

            <!-- Lightbox для галереи блюд -->
            <?php
            $lightbox_args = array(
                'variant' => 'simple',
                'id'      => 'galleryLightbox',
            );
            set_query_var( 'lightbox_args', $lightbox_args );
            get_template_part( 'template-parts/lightbox-gallery' );
            ?>
        </div>
    </section>

    <!-- Menu Categories Section -->
    <?php 
    $categories_section = banket_get_field('menu_categories_section', array());
    $categories_label = isset($categories_section['label']) ? $categories_section['label'] : 'Меню';
    $categories_title = isset($categories_section['title']) ? $categories_section['title'] : 'Категории блюд';
    $categories_description = isset($categories_section['description']) ? $categories_section['description'] : 'Мы предлагаем широкий выбор блюд восточной и европейской кухни. Все продукты сертифицированы как Халяль, блюда готовятся свежими из печи.';
    $categories_list = isset($categories_section['categories']) ? $categories_section['categories'] : array();
    
    // Определяем активную категорию
    $active_category_id = '';
    if (!empty($categories_list)) {
        foreach ($categories_list as $cat) {
            if (isset($cat['active']) && $cat['active']) {
                $active_category_id = isset($cat['category_id']) ? $cat['category_id'] : '';
                break;
            }
        }
        // Если нет активной, берем первую
        if (empty($active_category_id) && isset($categories_list[0]['category_id'])) {
            $active_category_id = $categories_list[0]['category_id'];
        }
    }
    ?>
    <section class="menu-page" id="menu-categories">
        <div class="menu-page__container container">
            <div class="menu-page__header">
                <?php if (!empty($categories_label)) : ?>
                <span class="menu-page__label"><?php echo esc_html($categories_label); ?></span>
                <?php endif; ?>
                <h2 class="menu-page__title section-title"><?php echo esc_html($categories_title); ?></h2>
                <div class="menu-page__divider">
                    <span class="menu-page__divider-line"></span>
                    <span class="menu-page__divider-icon">✨</span>
                    <span class="menu-page__divider-line"></span>
                </div>
                <?php if (!empty($categories_description)) : ?>
                <p class="menu-page__description">
                    <?php echo esc_html($categories_description); ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Табы для категорий -->
            <?php if (!empty($categories_list)) : ?>
            <div class="menu-page__tabs">
                <?php foreach ($categories_list as $category) : 
                    $cat_id = isset($category['category_id']) ? $category['category_id'] : '';
                    $cat_icon = isset($category['icon']) ? $category['icon'] : '🍽️';
                    $cat_name = isset($category['name']) ? $category['name'] : '';
                    $is_active = ($cat_id === $active_category_id);
                ?>
                <button class="menu-page__tab <?php echo $is_active ? 'menu-page__tab--active' : ''; ?>" data-category="<?php echo esc_attr($cat_id); ?>">
                    <span class="menu-page__tab-icon"><?php echo esc_html($cat_icon); ?></span>
                    <span class="menu-page__tab-text"><?php echo esc_html($cat_name); ?></span>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Контент категорий -->
            <?php if (!empty($categories_list)) : ?>
            <div class="menu-page__categories-wrapper">
                <?php foreach ($categories_list as $category) : 
                    $cat_id = isset($category['category_id']) ? $category['category_id'] : '';
                    $cat_title = isset($category['title']) ? $category['title'] : '';
                    $cat_description = isset($category['description']) ? $category['description'] : '';
                    $cat_items = isset($category['items']) ? $category['items'] : array();
                    $is_active = ($cat_id === $active_category_id);
                ?>
                <div class="menu-page__category-content <?php echo $is_active ? 'menu-page__category-content--active' : ''; ?>" data-content="<?php echo esc_attr($cat_id); ?>">
                    <div class="menu-page__category-info">
                        <?php if (!empty($cat_title)) : ?>
                        <h3 class="menu-page__category-title"><?php echo esc_html($cat_title); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($cat_description)) : ?>
                        <p class="menu-page__category-description">
                            <?php echo esc_html($cat_description); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($cat_items)) : ?>
                    <div class="menu-page__items-grid">
                        <?php foreach ($cat_items as $item) : 
                            $item_name = isset($item['name']) ? $item['name'] : '';
                            $item_desc = isset($item['description']) ? $item['description'] : '';
                        ?>
                        <div class="menu-page__item-card">
                            <div class="menu-page__item-header">
                                <?php if (!empty($item_name)) : ?>
                                <h4 class="menu-page__item-name"><?php echo esc_html($item_name); ?></h4>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item_desc)) : ?>
                            <p class="menu-page__item-desc"><?php echo esc_html($item_desc); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <?php 
    $cta_section = banket_get_field('menu_contact_cta_section', array());
    $cta_badge = isset($cta_section['badge']) ? $cta_section['badge'] : 'Индивидуальный подход';
    $cta_title_line = isset($cta_section['title_line']) ? $cta_section['title_line'] : 'Готовы составить';
    $cta_title_accent = isset($cta_section['title_accent']) ? $cta_section['title_accent'] : 'меню для вашего мероприятия?';
    $cta_text = isset($cta_section['text']) ? $cta_section['text'] : 'Свяжитесь с нами для консультации с шеф-поваром и составления индивидуального меню';
    $cta_primary = isset($cta_section['primary']) ? $cta_section['primary'] : array('label' => 'Позвонить', 'phone' => '+7 (978) 8064657');
    $cta_secondary = isset($cta_section['secondary']) ? $cta_section['secondary'] : array('label' => 'Контакты', 'subtitle' => 'Написать нам', 'url' => '');
    ?>
    <section class="contact-cta">
        <div class="contact-cta__background">
            <div class="contact-cta__pattern"></div>
            <div class="contact-cta__glow contact-cta__glow--top"></div>
            <div class="contact-cta__glow contact-cta__glow--bottom"></div>
        </div>
        
        <div class="contact-cta__container">
            <div class="contact-cta__wrapper">
                <div class="contact-cta__decorative contact-cta__decorative--left"></div>
                <div class="contact-cta__decorative contact-cta__decorative--right"></div>
                
                <div class="contact-cta__content">
                    <?php if (!empty($cta_badge)) : ?>
                    <div class="contact-cta__badge">
                        <svg class="contact-cta__badge-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span><?php echo esc_html($cta_badge); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <h2 class="contact-cta__title">
                        <span class="contact-cta__title-line"><?php echo esc_html($cta_title_line); ?></span>
                        <span class="contact-cta__title-accent"><?php echo esc_html($cta_title_accent); ?></span>
                    </h2>
                    
                    <?php if (!empty($cta_text)) : ?>
                    <p class="contact-cta__text">
                        <?php echo esc_html($cta_text); ?>
                    </p>
                    <?php endif; ?>
                    
                    <div class="contact-cta__actions">
                        <?php if (!empty($cta_primary)) : 
                            $cta_primary_label = isset($cta_primary['label']) ? $cta_primary['label'] : 'Позвонить';
                            $cta_primary_phone = isset($cta_primary['phone']) ? $cta_primary['phone'] : '+7 (978) 8064657';
                        ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $cta_primary_phone)); ?>" class="contact-cta__action contact-cta__action--primary">
                            <div class="contact-cta__action-icon-wrapper">
                                <svg class="contact-cta__action-icon" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M3 2C2.44772 2 2 2.44772 2 3V5.15287C2 5.64171 2.35341 6.0589 2.8356 6.13927L7.27147 6.87858C7.70451 6.95075 8.13397 6.73206 8.3303 6.3394L9.10437 4.79126C11.8783 5.90756 14.0924 8.12167 15.2087 10.8956L13.6606 11.6697C13.2679 11.866 13.0492 12.2955 13.1214 12.7285L13.8607 17.1644C13.9411 17.6466 14.3583 18 14.8471 18H17C17.5523 18 18 17.5523 18 17V15C18 7.8203 12.1797 2 5 2H3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="contact-cta__action-content">
                                <span class="contact-cta__action-label"><?php echo esc_html($cta_primary_label); ?></span>
                                <span class="contact-cta__action-phone"><?php echo esc_html($cta_primary_phone); ?></span>
                            </div>
                            <div class="contact-cta__action-arrow">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($cta_secondary)) : 
                            $cta_secondary_label = isset($cta_secondary['label']) ? $cta_secondary['label'] : 'Контакты';
                            $cta_secondary_subtitle = isset($cta_secondary['subtitle']) ? $cta_secondary['subtitle'] : 'Написать нам';
                            $cta_secondary_url = isset($cta_secondary['url']) ? $cta_secondary['url'] : '';
                            if (empty($cta_secondary_url)) {
                                $cta_secondary_url = home_url('/контакты/');
                            }
                        ?>
                        <a href="<?php echo esc_url($cta_secondary_url); ?>" class="contact-cta__action contact-cta__action--secondary">
                            <div class="contact-cta__action-icon-wrapper">
                                <svg class="contact-cta__action-icon" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M3 5L11 11L19 5M3 5H19M3 5V17C3 17.5523 3.44772 18 4 18H18C18.5523 18 19 17.5523 19 17V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="contact-cta__action-content">
                                <span class="contact-cta__action-label"><?php echo esc_html($cta_secondary_label); ?></span>
                                <?php if (!empty($cta_secondary_subtitle)) : ?>
                                <span class="contact-cta__action-subtitle"><?php echo esc_html($cta_secondary_subtitle); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="contact-cta__action-arrow">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>
    
    <?php wp_footer(); ?>
    
    <!-- JavaScript для табов и слайдшоу -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menu Hero Slideshow
        (function() {
            const slides = document.querySelectorAll('.menu-hero__slide');
            if (slides.length === 0) return;
            
            let currentSlide = 0;
            
            function nextSlide() {
                slides[currentSlide].classList.remove('menu-hero__slide--active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('menu-hero__slide--active');
            }
            
            // Автоматическое переключение
            setInterval(nextSlide, 5000);
        })();

        // Menu Tabs
        (function() {
            const tabs = document.querySelectorAll('.menu-page__tab');
            const contents = document.querySelectorAll('.menu-page__category-content');
            
            if (tabs.length === 0) return;
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const category = tab.getAttribute('data-category');
                    
                    // Убираем активный класс со всех табов
                    tabs.forEach(t => t.classList.remove('menu-page__tab--active'));
                    // Добавляем активный класс к выбранному табу
                    tab.classList.add('menu-page__tab--active');
                    
                    // Скрываем все контенты
                    contents.forEach(content => {
                        content.classList.remove('menu-page__category-content--active');
                    });
                    
                    // Показываем выбранный контент
                    const targetContent = document.querySelector(`[data-content="${category}"]`);
                    if (targetContent) {
                        targetContent.classList.add('menu-page__category-content--active');
                    }
                });
            });
        })();
    });
    </script>
</body>
</html>
