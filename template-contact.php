<?php
/**
 * Template Name: Контакты
 * Description: Шаблон страницы контактов
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Контакты банкетного зала Shen - зал на 300 гостей в Симферополе. Забронируйте мероприятие по телефону +7 (978) 187-28-27">
    <title>Контакты — Банкетный зал Shen | До 300 гостей в Симферополе</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body class="page-contacts">
    <?php
    // Получаем данные Hero секции
    $hero_section = banket_get_field( 'contacts_hero_section', array(), null );
    
    // Слайдшоу - получаем из группы или используем дефолтные значения
    $hero_slideshow_default = array(
        get_template_directory_uri() . '/img/1.webp',
        get_template_directory_uri() . '/img/2.webp',
        get_template_directory_uri() . '/img/3.webp',
        get_template_directory_uri() . '/img/2.webp'
    );  
    // Пытаемся получить галерею из группы
    if ( isset( $hero_section['slideshow'] ) && ! empty( $hero_section['slideshow'] ) ) {
        $hero_slideshow = array();
        foreach ( $hero_section['slideshow'] as $image ) {
            if ( is_array( $image ) ) {
                $hero_slideshow[] = array(
                    'url' => isset( $image['url'] ) ? $image['url'] : ( isset( $image['sizes']['full'] ) ? $image['sizes']['full'] : '' ),
                    'alt' => isset( $image['alt'] ) ? $image['alt'] : 'Банкетный зал Shen',
                );
            } elseif ( is_numeric( $image ) ) {
                $image_data = wp_get_attachment_image_src( $image, 'full' );
                if ( $image_data ) {
                    $hero_slideshow[] = array(
                        'url' => $image_data[0],
                        'alt' => get_post_meta( $image, '_wp_attachment_image_alt', true ) ?: 'Банкетный зал Shen',
                    );
                }
            }
        }
        if ( empty( $hero_slideshow ) ) {
            $hero_slideshow = banket_get_gallery( 'contacts_hero_section_slideshow', 'full', $hero_slideshow_default, null );
        }
    } else {
        $hero_slideshow = banket_get_gallery( 'contacts_hero_section_slideshow', 'full', $hero_slideshow_default, null );
    }
    
    // Левая часть
    $hero_main_label_icon = isset( $hero_section['main_label_icon'] ) ? $hero_section['main_label_icon'] : '✨';
    $hero_main_label_text = isset( $hero_section['main_label_text'] ) ? $hero_section['main_label_text'] : 'Примеальный уровень';
    $hero_main_title = isset( $hero_section['main_title'] ) ? $hero_section['main_title'] : 'Банкетный зал';
    $hero_main_title_accent = isset( $hero_section['main_title_accent'] ) ? $hero_section['main_title_accent'] : 'Shen';
    $hero_main_subtitle = isset( $hero_section['main_subtitle'] ) ? $hero_section['main_subtitle'] : 'Ваше идеальное место для незабываемых мероприятий';
    
    // Правая часть
    $hero_form_title = isset( $hero_section['form_title'] ) ? $hero_section['form_title'] : 'Забронируйте зал';
    $hero_form_subtitle = isset( $hero_section['form_subtitle'] ) ? $hero_section['form_subtitle'] : 'Оставьте заявку, и наш менеджер свяжется с вами в ближайшее время для уточнения деталей';
    $hero_form_button_text = isset( $hero_section['form_button_text'] ) ? $hero_section['form_button_text'] : 'Отправить заявку';
    $hero_form_button_icon = isset( $hero_section['form_button_icon'] ) ? $hero_section['form_button_icon'] : '→';
    ?>
    <?php get_header(); ?>
    <!-- Hero Section -->
    <section class="hero hero--contacts">
        <!-- Hero Content -->
        <div class="hero__container">
            <!-- Левая часть - Фото -->
            <div class="contacts-hero__image-side">
                <!-- Фоновое слайдшоу -->
                <?php if ( ! empty( $hero_slideshow ) ) : ?>
                <div class="contacts-hero__slideshow">
                    <?php foreach ( $hero_slideshow as $index => $image ) : ?>
                    <div class="contacts-hero__slide <?php echo $index === 0 ? 'contacts-hero__slide--active' : ''; ?>">
                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Банкетный зал Shen' ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="contacts-hero__image-overlay"></div>
                
                <!-- Центральный контент -->
                <div class="contacts-hero__main-content">
                    <div class="contacts-hero__main-label">
                        <span class="contacts-hero__main-label-icon"><?php echo esc_html( $hero_main_label_icon ); ?></span>
                        <span class="contacts-hero__main-label-text"><?php echo esc_html( $hero_main_label_text ); ?></span>
                    </div>
                    <h2 class="contacts-hero__main-title"><?php echo esc_html( $hero_main_title ); ?><br><span class="contacts-hero__main-title-accent"><?php echo esc_html( $hero_main_title_accent ); ?></span></h2>
                    <?php if ( $hero_main_subtitle ) : ?>
                    <p class="contacts-hero__main-subtitle"><?php echo esc_html( $hero_main_subtitle ); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Правая часть - Контакты -->
            <div class="contacts-hero__info-side">
                <div class="hero__content">
                    <h1 class="contacts-hero__title"><?php echo esc_html( $hero_form_title ); ?></h1>
                    <?php if ( $hero_form_subtitle ) : ?>
                    <p class="contacts-hero__subtitle">
                        <?php echo esc_html( $hero_form_subtitle ); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Форма быстрого бронирования -->
                    <?php echo do_shortcode('[contact-form-7 id="20b6b74" title="форма в контактах"]'); ?>
                </div>
            </div>
        </div>

        <!-- Индикатор прокрутки - СКРЫТ -->
        <!-- <div class="contacts-hero__scroll" onclick="document.querySelector('#contact-info').scrollIntoView({ behavior: 'smooth' })">
            <div class="contacts-hero__scroll-arrow">
                <span>↓</span>
            </div>
        </div> -->
    </section>

    <?php
    // Получаем данные секции контактной информации
    $info_section = banket_get_field( 'contacts_info_section', array(), null );
    $info_label = isset( $info_section['label'] ) ? $info_section['label'] : 'Наши контакты';
    $info_title = isset( $info_section['title'] ) ? $info_section['title'] : 'Как с нами связаться';
    $info_divider_icon = isset( $info_section['divider_icon'] ) ? $info_section['divider_icon'] : '✨';
    $info_cards = isset( $info_section['cards'] ) ? $info_section['cards'] : array();
    ?>
    <!-- Contact Information Section -->
    <section class="about" id="contact-info">
        <div class="about__container container">
            <div class="about__header">
                <?php if ( $info_label ) : ?>
                <span class="about__label"><?php echo esc_html( $info_label ); ?></span>
                <?php endif; ?>
                <h2 class="about__title section-title"><?php echo esc_html( $info_title ); ?></h2>
                <div class="about__divider">
                    <span class="about__divider-line"></span>
                    <span class="about__divider-icon"><?php echo esc_html( $info_divider_icon ); ?></span>
                    <span class="about__divider-line"></span>
                </div>
            </div>

            <!-- Contact Cards Grid -->
            <?php if ( ! empty( $info_cards ) ) : ?>
            <div class="advantages">
                <div class="advantages__grid">
                    <?php foreach ( $info_cards as $card ) : 
                        $card_icon = isset( $card['icon'] ) ? $card['icon'] : '';
                        $card_title = isset( $card['title'] ) ? $card['title'] : '';
                        $card_text = isset( $card['text'] ) ? $card['text'] : '';
                        $card_value = isset( $card['value'] ) ? $card['value'] : '';
                        $card_link = isset( $card['link'] ) ? $card['link'] : '';
                    ?>
                    <div class="advantages__card">
                        <?php if ( $card_icon ) : ?>
                        <div class="advantages__icon">
                            <?php echo wp_kses_post( $card_icon ); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ( $card_title ) : ?>
                        <h3 class="advantages__title"><?php echo esc_html( $card_title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $card_text ) : ?>
                        <p class="advantages__text"><?php echo esc_html( $card_text ); ?></p>
                        <?php endif; ?>
                        <?php if ( $card_value ) : ?>
                            <?php if ( $card_link ) : ?>
                            <a href="<?php echo esc_url( $card_link ); ?>" class="advantages__link"><?php echo esc_html( $card_value ); ?></a>
                            <?php else : ?>
                            <p class="advantages__link"><?php echo esc_html( $card_value ); ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    // Получаем данные секции расположения
    $location_section = banket_get_field( 'contacts_location_section', array(), null );
    $location_label = isset( $location_section['label'] ) ? $location_section['label'] : 'Наше расположение';
    $location_title = isset( $location_section['title'] ) ? $location_section['title'] : 'Как нас найти';
    $location_divider_icon = isset( $location_section['divider_icon'] ) ? $location_section['divider_icon'] : '📍';
    $location_subtitle = isset( $location_section['subtitle'] ) ? $location_section['subtitle'] : 'Удобное расположение';
    $location_description = isset( $location_section['description'] ) ? $location_section['description'] : 'Наш банкетный зал Shen расположен в городской черте Симферополя, вдали от шумных дорог. Просторное помещение вмещает до 300 гостей. Для ваших гостей предусмотрена просторная собственная парковка.';
    $location_features = isset( $location_section['features'] ) ? $location_section['features'] : array();
    $location_button_text = isset( $location_section['button_text'] ) ? $location_section['button_text'] : 'Открыть в Яндекс Картах';
    $location_button_url = isset( $location_section['button_url'] ) ? $location_section['button_url'] : 'https://yandex.ru/maps/?text=Симферополь, ул. Генерала Васильева, 40А';
    ?> 
    <!-- Location and Map Section -->
    <section class="about about--alt">
        <div class="about__container container">
            <div class="about__header">
                <?php if ( $location_label ) : ?>
                <span class="about__label"><?php echo esc_html( $location_label ); ?></span>
                <?php endif; ?>
                <h2 class="about__title section-title"><?php echo esc_html( $location_title ); ?></h2>
                <div class="about__divider">
                    <span class="about__divider-line"></span>
                    <span class="about__divider-icon"><?php echo esc_html( $location_divider_icon ); ?></span>
                    <span class="about__divider-line"></span>
                </div>
            </div>

            <div class="about__content">
                <div class="about__text-block">
                    <?php if ( $location_subtitle ) : ?>
                    <h3 class="about__subtitle"><?php echo esc_html( $location_subtitle ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $location_description ) : ?>
                    <p class="about__description">
                        <?php echo esc_html( $location_description ); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $location_features ) ) : ?>
                    <div class="about__features">
                        <?php foreach ( $location_features as $feature ) : 
                            $feature_icon = isset( $feature['icon'] ) ? $feature['icon'] : '';
                            $feature_text = isset( $feature['text'] ) ? $feature['text'] : '';
                        ?>
                        <div class="about__feature">
                            <?php if ( $feature_icon ) : ?>
                            <span class="about__feature-icon"><?php echo esc_html( $feature_icon ); ?></span>
                            <?php endif; ?>
                            <?php if ( $feature_text ) : ?>
                            <span class="about__feature-text"><?php echo esc_html( $feature_text ); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $location_button_url && $location_button_text ) : ?>
                    <a href="<?php echo esc_url( $location_button_url ); ?>" 
                       target="_blank" 
                       class="hero__button hero__button--primary">
                        <?php echo esc_html( $location_button_text ); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="about__map">
                    <iframe 
                        src="<?php echo esc_url( 'https://yandex.ru/map-widget/v1/?um=constructor%3A1ad7b0dd8adf5e98eb599a8f318124d64581efcc234ff8ceea29d6371beb5e3e&source=constructor' ); ?>" 
                        width="100%" 
                        height="500" 
                        frameborder="0" 
                        allowfullscreen
                        loading="lazy"
                        style="border-radius: 20px; border: 2px solid var(--color-primary);">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Получаем данные секции формы бронирования
    $booking_section = banket_get_field( 'contacts_booking_section', array(), null );
    $booking_label = isset( $booking_section['label'] ) ? $booking_section['label'] : 'Напишите нам';
    $booking_title = isset( $booking_section['title'] ) ? $booking_section['title'] : 'Форма обратной связи';
    $booking_subtitle = isset( $booking_section['subtitle'] ) ? $booking_section['subtitle'] : 'Заполните форму, и наш менеджер свяжется с вами в ближайшее время';
    $booking_wrapper = isset( $booking_section['wrapper'] ) ? $booking_section['wrapper'] : false;
    $booking_form_id = isset( $booking_section['form_id'] ) ? $booking_section['form_id'] : 'bookingForm';
    ?>
    <!-- Contact Form Section -->
    <?php
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

    <!-- Кнопка "Наверх" -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Наверх">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg> 
    </button>

    <?php get_footer(); ?>
</body>
</html>