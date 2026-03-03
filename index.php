<?php
/**
 * Fallback функции, если functions.php не загружен
 */
if ( ! function_exists( 'banket_get_field' ) ) {
    function banket_get_field( $field_name, $default = '', $post_id = null ) {
        if ( function_exists( 'get_field' ) ) {
            $value = get_field( $field_name, $post_id );
            return $value !== false && $value !== null ? $value : $default;
        }
        return $default;
    }
}

if ( ! function_exists( 'banket_get_image' ) ) {
    function banket_get_image( $field_name, $size = 'full', $default_url = '', $post_id = null ) {
        if ( function_exists( 'get_field' ) ) {
            $image = get_field( $field_name, $post_id );
            if ( $image ) {
                if ( is_array( $image ) ) {
                    return array(
                        'url' => isset( $image['sizes'][$size] ) ? $image['sizes'][$size] : $image['url'],
                        'alt' => isset( $image['alt'] ) ? $image['alt'] : '',
                        'width' => isset( $image['sizes'][$size . '-width'] ) ? $image['sizes'][$size . '-width'] : ( isset( $image['width'] ) ? $image['width'] : '' ),
                        'height' => isset( $image['sizes'][$size . '-height'] ) ? $image['sizes'][$size . '-height'] : ( isset( $image['height'] ) ? $image['height'] : '' ),
                    );
                } elseif ( is_numeric( $image ) ) {
                    $image_data = wp_get_attachment_image_src( $image, $size );
                    if ( $image_data ) {
                        return array(
                            'url' => $image_data[0],
                            'alt' => get_post_meta( $image, '_wp_attachment_image_alt', true ),
                            'width' => $image_data[1],
                            'height' => $image_data[2],
                        );
                    }
                }
            }
        }
        return array(
            'url' => $default_url,
            'alt' => '',
            'width' => '',
            'height' => '',
        );
    }
}

if ( ! function_exists( 'banket_get_gallery' ) ) {
    function banket_get_gallery( $field_name, $size = 'full', $default_images = array(), $post_id = null ) {
        if ( function_exists( 'get_field' ) ) {
            $gallery = get_field( $field_name, $post_id );
            if ( $gallery && is_array( $gallery ) ) {
                $images = array();
                foreach ( $gallery as $image ) {
                    if ( is_array( $image ) ) {
                        $images[] = array(
                            'url' => isset( $image['sizes'][$size] ) ? $image['sizes'][$size] : $image['url'],
                            'alt' => isset( $image['alt'] ) ? $image['alt'] : '',
                            'width' => isset( $image['sizes'][$size . '-width'] ) ? $image['sizes'][$size . '-width'] : ( isset( $image['width'] ) ? $image['width'] : '' ),
                            'height' => isset( $image['sizes'][$size . '-height'] ) ? $image['sizes'][$size . '-height'] : ( isset( $image['height'] ) ? $image['height'] : '' ),
                        );
                    } elseif ( is_numeric( $image ) ) {
                        $image_data = wp_get_attachment_image_src( $image, $size );
                        if ( $image_data ) {
                            $images[] = array(
                                'url' => $image_data[0],
                                'alt' => get_post_meta( $image, '_wp_attachment_image_alt', true ),
                                'width' => $image_data[1],
                                'height' => $image_data[2],
                            );
                        }
                    }
                }
                if ( ! empty( $images ) ) {
                    return $images;
                }
            }
        }
        $default_result = array();
        foreach ( $default_images as $url ) {
            $default_result[] = array(
                'url' => $url,
                'alt' => '',
                'width' => '',
                'height' => '',
            );
        }
        return $default_result;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Банкетный зал ShenCrystal в Симферополе — корпоративы, свадьбы, банкеты до 300 гостей. Восточная и европейская кухня, продукты Халяль, свежее приготовление из печи. ✨ Нет предела совершенству ✨">
    <title>Банкетный зал Shen | Корпоративы, банкеты до 300 гостей в Симферополе</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/img/logo-simple.svg">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/logo-simple.svg">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/logo-simple.svg">
    
    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>
<body>
    
    <main class="main">
        
        <!-- Hero Section -->
        <?php
        // Получаем данные Hero секции из ACF
        $hero_section = banket_get_field( 'hero_section', array() );
        
        // Заголовки
        $hero_title = banket_get_field( 'hero_section_title', 'Банкетный зал', null );
        $hero_title_accent = banket_get_field( 'hero_section_title_accent', 'ShenCrystal', null );
        $hero_slogan = banket_get_field( 'hero_section_slogan', '✨ Нет предела совершенству ✨', null );
        
        // Рейтинг
        $hero_rating = banket_get_field( 'hero_section_rating', array(), null );
        $hero_rating_value = isset( $hero_rating['value'] ) ? $hero_rating['value'] : '5.0';
        $hero_rating_text = isset( $hero_rating['text'] ) ? $hero_rating['text'] : 'рейтинг';
        
        // Кнопки
        $hero_button_primary = banket_get_field( 'hero_section_button_primary', array(), null );
        $hero_button_primary_text = isset( $hero_button_primary['text'] ) ? $hero_button_primary['text'] : 'Забронировать';
        $hero_button_primary_action = isset( $hero_button_primary['action'] ) ? $hero_button_primary['action'] : 'open-booking';
        
        $hero_button_secondary = banket_get_field( 'hero_section_button_secondary', array(), null );
        $hero_button_secondary_text = isset( $hero_button_secondary['text'] ) ? $hero_button_secondary['text'] : 'Узнать больше';
        $hero_button_secondary_scroll = isset( $hero_button_secondary['scroll_to'] ) ? $hero_button_secondary['scroll_to'] : '#about';
        
        // Информационные блоки
        $hero_info = banket_get_field( 'hero_section_info', array(
            array( 'type' => 'guests', 'number' => '300', 'text' => 'гостей' ),
            array( 'type' => 'premium', 'text' => 'премиум' ),
            array( 'type' => 'halal', 'text' => 'халяль' )
        ), null );
        
        // Слайдер изображений
        $hero_slider_default = array(
            get_template_directory_uri() . '/img/13.webp',
            get_template_directory_uri() . '/img/10.webp',
            get_template_directory_uri() . '/img/1.webp',
            get_template_directory_uri() . '/img/2.webp',
            get_template_directory_uri() . '/img/3.webp'
        );
        $hero_slider_images = banket_get_gallery( 'hero_section_slider', 'full', $hero_slider_default, null );
        ?>
        <section class="hero">
            <!-- Header внутри Hero -->
            <?php get_header(); ?>
            
            <div class="hero__background">
                <div class="hero__slider">
                    <?php foreach ( $hero_slider_images as $index => $image ) : ?>
                        <div class="hero__slide <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Банкетный зал Shen' ); ?>" class="hero__bg-img" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="hero__overlay"></div>
            </div>
            
            <div class="hero__container container">
                <div class="hero__content">
                    <div class="hero__left">
                        <div class="hero__rating hero__rating--left">
                            <div class="rating-card">
                                <span class="rating-card__icon">⭐</span>
                                <span class="rating-card__number"><?php echo esc_html( $hero_rating_value ); ?></span>
                                <span class="rating-card__separator">•</span>
                                <span class="rating-card__text"><?php echo esc_html( $hero_rating_text ); ?></span>
                            </div>
                        </div>
                        <h1 class="hero__title">
                            <?php echo esc_html( $hero_title ); ?>
                            <br>
                            <span class="hero__title-accent"><?php echo esc_html( $hero_title_accent ); ?></span>
                        </h1>
                        <?php if ( $hero_slogan ) : ?>
                            <p class="hero__slogan"><?php echo esc_html( $hero_slogan ); ?></p>
                        <?php endif; ?>
                        <div class="hero__buttons">
                            <button class="hero__button hero__button--primary" data-action="<?php echo esc_attr( $hero_button_primary_action ); ?>">
                                <?php echo esc_html( $hero_button_primary_text ); ?>
                            </button>
                            <button class="hero__button hero__button--secondary" data-scroll-to="<?php echo esc_attr( $hero_button_secondary_scroll ); ?>">
                                <?php echo esc_html( $hero_button_secondary_text ); ?>
                            </button>
                        </div>
                        
                        <div class="hero__info">
                            <?php foreach ( $hero_info as $info_item ) : 
                                $info_type = isset( $info_item['type'] ) ? $info_item['type'] : '';
                                $info_number = isset( $info_item['number'] ) ? $info_item['number'] : '';
                                $info_text = isset( $info_item['text'] ) ? $info_item['text'] : '';
                            ?>
                                <div class="hero__info-item <?php echo $info_type === 'premium' ? 'hero__info-item--premium' : ''; ?>">
                                    <?php if ( $info_type === 'guests' && $info_number ) : ?>
                                        <div class="hero__info-top">
                                            <div class="hero__info-number"><?php echo esc_html( $info_number ); ?></div>
                                        </div>
                                    <?php elseif ( $info_type === 'premium' ) : ?>
                                        <div class="hero__info-stars">✨</div>
                                    <?php else : ?>
                                        <div class="hero__info-icon--check">✓</div>
                                    <?php endif; ?>
                                    <div class="hero__info-text"><?php echo esc_html( $info_text ); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="hero__scroll" data-scroll-to="<?php echo esc_attr( $hero_button_secondary_scroll ); ?>" role="button" tabindex="0" aria-label="Прокрутить к разделу О нас">
                            <div class="hero__scroll-arrow">
                                <span>↓</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hero__right">
                      
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <?php
        // Получаем данные About секции из ACF
        $about_section = banket_get_field( 'about_section', array(), null );
        
        $about_label = banket_get_field( 'about_section_label', 'О нас', null );
        $about_title = banket_get_field( 'about_section_title', 'Банкетный зал Shen Crystal', null );
        $about_text = banket_get_field( 'about_section_text', 'Shen Crystal — это многопрофильный банкетный зал премиум-класса, объединяющий в себе элегантность, функциональность и безупречный сервис. Мы создали идеальное пространство для проведения самых разноплановых мероприятий: от торжественных корпоративных праздников и церемоний вручения премий до презентаций новых продуктов и бизнес-конференций. Наш зал вмещает до 300 гостей и готов принять ваше мероприятие любого масштаба.', null );
        
        $about_stats = banket_get_field( 'about_section_stats', array(
            array( 'number' => '300', 'label' => 'Гостей' ),
            array( 'number' => '100%', 'label' => 'Качество' ),
            array( 'number' => '24/7', 'label' => 'Поддержка' )
        ), null );
        
        $about_slider_default = array(
            get_template_directory_uri() . '/img/1.webp',
            get_template_directory_uri() . '/img/2.webp',
            get_template_directory_uri() . '/img/3.webp',
            get_template_directory_uri() . '/img/4.webp'
        );
        $about_slider_images = banket_get_gallery( 'about_section_slider', 'full', $about_slider_default, null );
        ?>
        <section class="about" id="about">
            <div class="about__container container">
                <div class="about__header">
                    <?php if ( $about_label ) : ?>
                        <span class="about__label"><?php echo esc_html( $about_label ); ?></span>
                    <?php endif; ?>
                    <h2 class="about__title section-title"><?php echo esc_html( $about_title ); ?></h2>
                    <div class="about__divider">
                        <span class="about__divider-line"></span>
                        <span class="about__divider-icon">✨</span>
                        <span class="about__divider-line"></span>
                    </div>
                </div>

                <div class="about__content">
                    <div class="about__content-left">
                        <div class="about__text-wrapper">
                            <?php if ( $about_text ) : ?>
                                <p class="about__text">
                                    <?php echo wp_kses_post( $about_text ); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ( ! empty( $about_stats ) ) : ?>
                                <div class="about__stats">
                                    <?php foreach ( $about_stats as $stat ) : 
                                        $stat_number = isset( $stat['number'] ) ? $stat['number'] : '';
                                        $stat_label = isset( $stat['label'] ) ? $stat['label'] : '';
                                    ?>
                                        <div class="about__stat">
                                            <div class="about__stat-number"><?php echo esc_html( $stat_number ); ?></div>
                                            <div class="about__stat-label"><?php echo esc_html( $stat_label ); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="about__content-right">
                        <div class="about__slider">
                            <div class="about__slider-wrapper">
                                <div class="about__slider-track">
                                    <?php foreach ( $about_slider_images as $index => $image ) : ?>
                                        <div class="about__slide <?php echo $index === 0 ? 'about__slide--active' : ''; ?>">
                                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Интерьер банкетного зала Shen Crystal' ); ?>" class="about__slide-image" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                                            <div class="about__slide-overlay"></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Стрелки навигации -->
                            <button class="about__slider-btn about__slider-btn--prev" aria-label="Предыдущее изображение">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button class="about__slider-btn about__slider-btn--next" aria-label="Следующее изображение">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            
                            <!-- Индикаторы -->
                            <div class="about__slider-dots">
                                <?php foreach ( $about_slider_images as $index => $image ) : ?>
                                    <button class="about__slider-dot <?php echo $index === 0 ? 'about__slider-dot--active' : ''; ?>" data-slide="<?php echo esc_attr( $index ); ?>"></button>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="about__image-decoration"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Advantages Section -->
        <?php
        // Получаем данные Advantages секции из ACF
        $advantages_title = banket_get_field( 'advantages_section_title', 'Почему выбирают Shen Crystal', null );
        $advantages_items = banket_get_field( 'advantages_section_items', array(
            array( 'title' => '1000+ мероприятий', 'text' => 'Богатый опыт организации торжеств любого формата и масштаба', 'number' => '01' ),
            array( 'title' => 'Индивидуальное меню', 'text' => 'Персонализация меню под ваши предпочтения и особенности мероприятия', 'number' => '02' ),
            array( 'title' => 'Свежее из печи', 'text' => 'Приготовление блюд непосредственно перед подачей, горячее прямо из печи', 'number' => '03' ),
            array( 'title' => 'Удобное расположение', 'text' => 'В городской черте, вдали от шумных дорог с собственной парковкой', 'number' => '04' ),
            array( 'title' => 'Профессионалы', 'text' => 'Опытная банкетная команда для безупречной организации вашего события', 'number' => '05' ),
            array( 'title' => 'VIP-сервис', 'text' => 'Индивидуальный подход, гардероб и персональный менеджер', 'number' => '06' )
        ), null );
        ?>
        <section class="advantages" id="advantages">
            <div class="advantages__container container">
                <div class="advantages__header">
                    <h2 class="advantages__title"><?php echo esc_html( $advantages_title ); ?></h2>
                    <div class="advantages__divider">
                        <span class="advantages__divider-line"></span>
                        <span class="advantages__divider-icon">◆</span>
                        <span class="advantages__divider-line"></span>
                    </div>
                </div>

                <div class="advantages__grid">
                    <?php if ( ! empty( $advantages_items ) ) : 
                        foreach ( $advantages_items as $item ) :
                            $item_title = isset( $item['title'] ) ? $item['title'] : '';
                            $item_text = isset( $item['text'] ) ? $item['text'] : '';
                            $item_number = isset( $item['number'] ) ? $item['number'] : '';
                            $item_icon = isset( $item['icon'] ) ? $item['icon'] : '';
                    ?>
                        <div class="advantage-card">
                            <div class="advantage-card__icon-wrapper">
                                <?php if ( $item_icon ) : ?>
                                    <?php echo $item_icon; ?>
                                <?php else : ?>
                                    <!-- Дефолтная иконка -->
                                    <svg class="advantage-card__icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M32 8l6.928 14.032L54 24.472l-11 10.736L45.856 50 32 42.472 18.144 50 21 35.208 10 24.472l15.072-2.44z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    </svg>
                                <?php endif; ?>
                                <div class="advantage-card__icon-bg"></div>
                            </div>
                            <h3 class="advantage-card__title"><?php echo esc_html( $item_title ); ?></h3>
                            <p class="advantage-card__text">
                                <?php echo esc_html( $item_text ); ?>
                            </p>
                            <?php if ( $item_number ) : ?>
                                <div class="advantage-card__number"><?php echo esc_html( $item_number ); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; 
                    endif; ?>
                </div>
            </div>
        </section>

        <!-- Clients Section -->
        <?php
        // Получаем данные Clients секции из ACF
        $clients_title = banket_get_field( 'clients_section_title', 'НАС ВЫБРАЛИ', null );
        $clients_list = banket_get_field( 'clients_section_list', array(
            array( 'name' => 'IC' ),
            array( 'name' => 'АТО EVENTS' ),
            array( 'name' => 'ОНТИКО' ),
            array( 'name' => 'АНКТ' ),
            array( 'name' => 'OCS' ),
            array( 'name' => 'gallaDance' ),
            array( 'name' => 'ФЕДЕРАЛЬНАЯ ЭКЗАМЕНАЦИОННАЯ СЛУЖБА' )
        ), null );
        ?>
        <section class="clients">
            <div class="clients__container container">
                <h2 class="clients__title"><?php echo esc_html( $clients_title ); ?></h2>
                <div class="clients__slider">
                    <div class="clients__track">
                        <?php if ( ! empty( $clients_list ) ) : 
                            // Дублируем для бесконечной прокрутки
                            $clients_list_doubled = array_merge( $clients_list, $clients_list );
                            foreach ( $clients_list_doubled as $client ) :
                                $client_name = isset( $client['name'] ) ? $client['name'] : '';
                        ?>
                            <div class="clients__item">
                                <span class="clients__name"><?php echo esc_html( $client_name ); ?></span>
                            </div>
                        <?php endforeach; 
                        endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Menu Section -->
        <?php
        // Получаем данные Menu секции из ACF
        $menu_title = banket_get_field( 'menu_section_title', 'Меню и кухня', null );
        $menu_subtitle = banket_get_field( 'menu_section_subtitle', 'Восточная и европейская кухня от наших шеф-поваров', null );
        $menu_heading = banket_get_field( 'menu_section_heading', 'Разнообразие вкусов', null );
        $menu_description_1 = banket_get_field( 'menu_section_description_1', 'Основу меню составляет восточная и европейская кухня. Предлагаемый ассортимент можно дополнить в соответствии с вашими пожеланиями.', null );
        $menu_description_2 = banket_get_field( 'menu_section_description_2', 'Только свежие премиальные продукты, лучшие рецепты, высокое мастерство и высококлассный сервис — это основные принципы работы банкетных залов SHEN.', null );
        $menu_features = banket_get_field( 'menu_section_features', array(
            array( 'icon' => '🥘', 'title' => 'Восточная кухня', 'text' => 'Традиционные блюда с аутентичным вкусом' ),
            array( 'icon' => '🍴', 'title' => 'Европейская кухня', 'text' => 'Классические рецепты европейской кулинарии' ),
            array( 'icon' => '✨', 'title' => 'Премиальные ингредиенты', 'text' => 'Только свежие продукты высшего качества от проверенных поставщиков' )
        ), null );
        $menu_images_default = array(
            get_template_directory_uri() . '/img/eat1.webp',
            get_template_directory_uri() . '/img/eat2.webp'
        );
        $menu_images = banket_get_gallery( 'menu_section_images', 'full', $menu_images_default, null );
        ?>
        <section class="menu" id="menu">
            <div class="menu__container container">
                <div class="menu__header">
                    <h2 class="menu__title section-title"><?php echo esc_html( $menu_title ); ?></h2>
                    <?php if ( $menu_subtitle ) : ?>
                        <p class="menu__subtitle section-subtitle">
                            <?php echo esc_html( $menu_subtitle ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="menu__content">
                    <div class="menu__text">
                        <div class="menu__description">
                            <?php if ( $menu_heading ) : ?>
                                <h3 class="menu__heading"><?php echo esc_html( $menu_heading ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $menu_description_1 ) : ?>
                                <p><?php echo esc_html( $menu_description_1 ); ?></p>
                            <?php endif; ?>
                            <?php if ( $menu_description_2 ) : ?>
                                <p><?php echo esc_html( $menu_description_2 ); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if ( ! empty( $menu_features ) ) : ?>
                            <div class="menu__features">
                                <?php foreach ( $menu_features as $feature ) : 
                                    $feature_icon = isset( $feature['icon'] ) ? $feature['icon'] : '';
                                    $feature_title = isset( $feature['title'] ) ? $feature['title'] : '';
                                    $feature_text = isset( $feature['text'] ) ? $feature['text'] : '';
                                ?>
                                    <div class="menu__feature">
                                        <?php if ( $feature_icon ) : ?>
                                            <div class="menu__feature-icon"><?php echo esc_html( $feature_icon ); ?></div>
                                        <?php endif; ?>
                                        <div class="menu__feature-content">
                                            <h4 class="menu__feature-title"><?php echo esc_html( $feature_title ); ?></h4>
                                            <p class="menu__feature-text"><?php echo esc_html( $feature_text ); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $menu_images ) ) : ?>
                        <div class="menu__images">
                            <?php foreach ( $menu_images as $image ) : ?>
                                <div class="menu__image-item">
                                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Блюда' ); ?>" class="menu__img" loading="lazy">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Reels Section -->
        <?php
        // Получаем данные Reels секции из ACF
        $reels_badge = banket_get_field( 'reels_section_badge', '✨ Нет предела совершенству', null );
        $reels_title = banket_get_field( 'reels_section_title', 'Живые моменты', null );
        $reels_subtitle = banket_get_field( 'reels_section_subtitle', 'коротко о главном — атмосфера, кухня, эмоции', null );
        $reels_cta_text = banket_get_field( 'reels_section_cta_text', 'Забронировать дату', null );
        $reels_phone = banket_get_field( 'reels_section_phone', '+7 (978) 187-28-27', null );
        $reels_videos = banket_get_field( 'reels_section_videos', array(), null );
        
        // Дефолтные видео
        $reels_videos_default = array(
            array( 'video_file' => get_template_directory_uri() . '/video/6.MP4', 'active' => false ),
            array( 'video_file' => get_template_directory_uri() . '/video/1.MP4', 'active' => false ),
            array( 'video_file' => get_template_directory_uri() . '/video/2.MP4', 'active' => true ),
            array( 'video_file' => get_template_directory_uri() . '/video/3.MP4', 'active' => false ),
            array( 'video_file' => get_template_directory_uri() . '/video/4.MP4', 'active' => false )
        );
        
        if ( empty( $reels_videos ) ) {
            $reels_videos = $reels_videos_default;
        }
        ?>
        <section class="reels" id="reels">
            <div class="reels__container container">
                <div class="reels__layout">
                    <div class="reels__content">
                        <?php if ( $reels_badge ) : ?>
                            <span class="reels__badge"><?php echo esc_html( $reels_badge ); ?></span>
                        <?php endif; ?>
                        <div class="reels__header">
                            <h2 class="reels__title"><?php echo esc_html( $reels_title ); ?></h2>
                            <?php if ( $reels_subtitle ) : ?>
                                <p class="reels__subtitle"><?php echo esc_html( $reels_subtitle ); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="reels__cta-row">
                            <a class="reels__cta" href="#booking" data-action="open-booking">
                                <span class="reels__cta-text"><?php echo esc_html( $reels_cta_text ); ?></span>
                            </a>
                            <div class="reels__phone-wrapper">
                                <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $reels_phone ) ); ?>" class="reels__phone"><?php echo esc_html( $reels_phone ); ?></a>
                            </div>
                        </div>
                    </div>
 
                    <div class="reels__media">
                        <div class="reels__slider" aria-label="Слайдер с видео">
                            <button class="reels__btn reels__btn--prev" aria-label="Предыдущее видео" type="button"></button>

                            <div class="reels__viewport">
                                <div class="reels__track">
                                    <?php foreach ( $reels_videos as $index => $video ) : 
                                        $video_file = '';
                                        $is_active = false;
                                        
                                        if ( is_array( $video ) ) {
                                            if ( isset( $video['video_file'] ) ) {
                                                if ( is_array( $video['video_file'] ) && isset( $video['video_file']['url'] ) ) {
                                                    $video_file = $video['video_file']['url'];
                                                } elseif ( is_string( $video['video_file'] ) ) {
                                                    $video_file = $video['video_file'];
                                                }
                                            }
                                            $is_active = isset( $video['active'] ) && $video['active'];
                                        } elseif ( is_string( $video ) ) {
                                            $video_file = $video;
                                        }
                                        
                                        // Если не нашли активное, делаем первое активным
                                        if ( $index === 0 && ! $is_active && empty( array_filter( $reels_videos, function($v) { return is_array($v) && isset($v['active']) && $v['active']; } ) ) ) {
                                            $is_active = true;
                                        }
                                    ?>
                                        <div class="reels__slide <?php echo $is_active ? 'reels__slide--active' : ''; ?>">
                                            <div class="reels__card">
                                                <video class="reels__video" src="<?php echo esc_url( $video_file ); ?>" muted playsinline preload="metadata" loop volume="0"></video>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <button class="reels__btn reels__btn--next" aria-label="Следующее видео" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <?php
        // Получаем данные Gallery секции из ACF
        $gallery_title = banket_get_field( 'gallery_section_title', 'Галерея', null );
        $gallery_subtitle = banket_get_field( 'gallery_section_subtitle', 'Атмосфера наших залов и мероприятий', null );
        $gallery_link_text = banket_get_field( 'gallery_section_link_text', 'Смотреть все фото', null );
        $gallery_link_url = banket_get_field( 'gallery_section_link_url', '/галерея/', null );
        
        // Дефолтные изображения
        $gallery_images_default = array(
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
        $gallery_images = banket_get_gallery( 'gallery_section_images', 'full', $gallery_images_default, null );
        
        // Большие элементы
        $gallery_large_items = banket_get_field( 'gallery_section_large_items', array(
            array( 'index' => 6 ),
            array( 'index' => 7 )
        ), null );
        $large_indices = array();
        if ( ! empty( $gallery_large_items ) ) {
            foreach ( $gallery_large_items as $item ) {
                if ( isset( $item['index'] ) ) {
                    $large_indices[] = (int) $item['index'];
                }
            }
        }
        ?>
        <section class="gallery" id="gallery">
            <div class="gallery__container container">
                <div class="gallery__header">
                    <h2 class="gallery__title section-title"><?php echo esc_html( $gallery_title ); ?></h2>
                    <?php if ( $gallery_subtitle ) : ?>
                        <p class="gallery__subtitle section-subtitle">
                            <?php echo esc_html( $gallery_subtitle ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="gallery__grid">
                    <?php if ( ! empty( $gallery_images ) ) : 
                        foreach ( $gallery_images as $index => $image ) :
                            $is_large = in_array( $index, $large_indices );
                    ?>
                        <div class="gallery__item <?php echo $is_large ? 'gallery__item--large' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Галерея' ); ?>" class="gallery__img" loading="<?php echo $index < 4 ? 'eager' : 'lazy'; ?>">
                            <div class="gallery__overlay">
                                <svg class="gallery__zoom-icon" width="40" height="40" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                                    <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                    <?php endforeach; 
                    endif; ?>
                </div>

                <!-- Lightbox Modal -->
                <div class="gallery__lightbox" id="galleryLightbox">
                    <button class="gallery__lightbox-close" aria-label="Закрыть">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    
                    <button class="gallery__lightbox-prev" aria-label="Предыдущее фото">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M15 18l-6-6 6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    
                    <button class="gallery__lightbox-next" aria-label="Следующее фото">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M9 18l6-6-6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button> 
                    
                    <div class="gallery__lightbox-content">
                        <h2 id="lightbox-title" class="visually-hidden">Просмотр галереи</h2>
                        <div class="gallery__lightbox-img-wrap">
                            <img src="" alt="" class="gallery__lightbox-img" id="lightboxImg" aria-describedby="lightboxCounter">
                            <div class="gallery__lightbox-toolbar">
                                <button type="button" class="gallery__lightbox-tool-btn" id="shareBtn" title="Поделиться" aria-label="Поделиться">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="18" cy="5" r="3"/>
                                        <circle cx="6" cy="12" r="3"/>
                                        <circle cx="18" cy="19" r="3"/>
                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                                    </svg>
                                </button>
                                <button type="button" class="gallery__lightbox-tool-btn" id="downloadBtn" title="Скачать" aria-label="Скачать">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="gallery__lightbox-counter" id="lightboxCounter" aria-live="polite" aria-atomic="true">1 / 14</div>
                    </div>
                </div>

                <div class="gallery__footer">
                    <a href="<?php echo esc_url( home_url( $gallery_link_url ) ); ?>" class="gallery__link button button--primary">
                        <?php echo esc_html( $gallery_link_text ); ?>
                        <svg class="gallery__link-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7 4l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Booking Section -->
        <?php
        // Получаем данные Booking секции из ACF
        $booking_label = banket_get_field( 'booking_section_label', '', null );
        $booking_title = banket_get_field( 'booking_section_title', 'ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ', null );
        $booking_subtitle = banket_get_field( 'booking_section_subtitle', 'Оставьте заявку и мы свяжемся с вами для обсуждения деталей', null );
        $booking_wrapper = banket_get_field( 'booking_section_wrapper', true, null );
        $booking_form_id = banket_get_field( 'booking_section_form_id', 'bookingForm', null );
        
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

        <!-- Contacts Section -->
        <?php
        // Получаем данные Contacts секции из ACF
        $contacts_title = banket_get_field( 'contacts_section_title', 'КОНТАКТЫ', null );
        $contacts_phone = banket_get_field( 'contacts_section_phone', '+7 (978) 187-28-27', null );
        $contacts_email = banket_get_field( 'contacts_section_email', 'banquet@shen.ru', null );
        $contacts_address = banket_get_field( 'contacts_section_address', 'г. Симферополь, ул. Генерала Васильева, 40А', null );
        $contacts_map_code = banket_get_field( 'contacts_section_map_code', 'https://yandex.ru/map-widget/v1/?um=constructor%3A331be3a5bae9d4421f82ff3cc734dca26e90ab2b49adf24a3be4bd725584b85b&amp;source=constructor', null );
        
        $contacts_rating = banket_get_field( 'contacts_section_rating', array(), null );
        $contacts_rating_title = isset( $contacts_rating['title'] ) ? $contacts_rating['title'] : 'НАШ ПРОФЕССИОНАЛИЗМ ЦЕНЯТ';
        $contacts_rating_score = isset( $contacts_rating['score'] ) ? $contacts_rating['score'] : '5,0';
        $contacts_rating_count = isset( $contacts_rating['count'] ) ? $contacts_rating['count'] : '12001 оценка';
        ?>
        <section class="contacts" id="contacts">
            <div class="contacts__container container">
                <h2 class="contacts__title"><?php echo esc_html( $contacts_title ); ?></h2>
                
                <div class="contacts__cards">
                    <div class="contacts__card">
                        <div class="contacts__card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M26 21.5C24.4 21.5 22.9 21.2 21.5 20.7C21.1 20.5 20.6 20.6 20.3 20.9L17.4 23.8C13.6 22 10 18.4 8.2 14.6L11.1 11.7C11.4 11.4 11.5 10.9 11.3 10.5C10.8 9.1 10.5 7.6 10.5 6C10.5 5.2 9.8 4.5 9 4.5H6C5.2 4.5 4.5 5.2 4.5 6C4.5 17.8 14.2 27.5 26 27.5C26.8 27.5 27.5 26.8 27.5 26V22.5C27.5 21.7 26.8 21 26 21.5Z" fill="white"/>
                            </svg>
                        </div>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contacts_phone ) ); ?>" class="contacts__card-text"><?php echo esc_html( $contacts_phone ); ?></a>
                    </div>

                    <div class="contacts__card">
                        <div class="contacts__card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M26.7 6.7H5.3C4 6.7 3 7.7 3 9V23C3 24.3 4 25.3 5.3 25.3H26.7C28 25.3 29 24.3 29 23V9C29 7.7 28 6.7 26.7 6.7ZM26.7 23L16 15.3L5.3 23V11.7L16 19.3L26.7 11.7V23Z" fill="white"/>
                            </svg>
                        </div>
                        <a href="mailto:<?php echo esc_attr( $contacts_email ); ?>" class="contacts__card-text"><?php echo esc_html( $contacts_email ); ?></a>
                    </div>

                    <div class="contacts__card">
                        <div class="contacts__card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M16 4C11.6 4 8 7.6 8 12C8 18 16 28 16 28C16 28 24 18 24 12C24 7.6 20.4 4 16 4ZM16 15C14.3 15 13 13.7 13 12C13 10.3 14.3 9 16 9C17.7 9 19 10.3 19 12C19 13.7 17.7 15 16 15Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="contacts__card-text"><?php echo esc_html( $contacts_address ); ?></p>
                    </div>
                </div>

                <div class="contacts__map-section">
                    <div class="contacts__map-wrapper">
                        <?php if ( $contacts_map_code ) : ?>
                            <?php 
                            // Если это iframe код, выводим как есть, иначе оборачиваем в iframe
                            if ( strpos( $contacts_map_code, '<iframe' ) !== false ) {
                                echo $contacts_map_code;
                            } else {
                            ?>
                                <iframe 
                                    src="<?php echo esc_url( $contacts_map_code ); ?>" 
                                    width="750" 
                                    height="500" 
                                    frameborder="0"
                                    class="contacts__map"
                                    title="Карта расположения банкетных залов Shen">
                                </iframe>
                            <?php } ?>
                        <?php endif; ?>
                    </div>

                    <div class="contacts__rating">
                        <h3 class="contacts__rating-title"><?php echo esc_html( $contacts_rating_title ); ?></h3>
                        <div class="contacts__rating-score"><?php echo esc_html( $contacts_rating_score ); ?></div>
                        <div class="contacts__rating-stars">
                            <span class="contacts__star">★</span>
                            <span class="contacts__star">★</span>
                            <span class="contacts__star">★</span>
                            <span class="contacts__star">★</span>
                            <span class="contacts__star">★</span>
                        </div>
                        <p class="contacts__rating-count"><?php echo esc_html( $contacts_rating_count ); ?></p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Кнопка "Наверх" -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Наверх">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <?php get_footer(); ?>