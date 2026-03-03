<?php
/**
 * Template Name: Политика конфиденциальности
 * Description: Шаблон страницы политики конфиденциальности
 */ 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Политика конфиденциальности банкетных залов Shen. Информация о сборе, использовании и защите персональных данных.">
    <title>Политика конфиденциальности — Банкетный зал Shen</title>
    
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
<body class="page-privacy">
    <?php
    // Получаем данные Hero секции
    $hero_section = banket_get_field( 'privacy_hero_section', array(), null );
    $hero_icon = isset( $hero_section['icon'] ) ? $hero_section['icon'] : '<svg width="64" height="64" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $hero_title = isset( $hero_section['title'] ) ? $hero_section['title'] : 'Политика конфиденциальности';
    $hero_subtitle = isset( $hero_section['subtitle'] ) ? $hero_section['subtitle'] : 'Защита ваших персональных данных — наш приоритет';
    $hero_date = isset( $hero_section['date'] ) ? $hero_section['date'] : 'Последнее обновление: 1 января 2025 года';
    
    // Получаем разделы политики
    $privacy_sections = banket_get_field( 'privacy_content_sections', array(), null );
    
    // Получаем данные CTA секции
    $cta_section = banket_get_field( 'privacy_cta_section', array(), null );
    $cta_title = isset( $cta_section['title'] ) ? $cta_section['title'] : 'Готовы забронировать зал?';
    $cta_text = isset( $cta_section['text'] ) ? $cta_section['text'] : 'Свяжитесь с нами для организации незабываемого мероприятия';
    $cta_button_primary = isset( $cta_section['button_primary'] ) ? $cta_section['button_primary'] : array();
    $cta_button_primary_text = isset( $cta_button_primary['text'] ) ? $cta_button_primary['text'] : 'Перейти к контактам';
    $cta_button_primary_url_raw = isset( $cta_button_primary['url'] ) ? $cta_button_primary['url'] : '';
    $cta_button_primary_url = $cta_button_primary_url_raw ? ( is_numeric( $cta_button_primary_url_raw ) ? get_permalink( $cta_button_primary_url_raw ) : $cta_button_primary_url_raw ) : home_url('/контакты/');
    
    $cta_button_secondary = isset( $cta_section['button_secondary'] ) ? $cta_section['button_secondary'] : array();
    $cta_button_secondary_text = isset( $cta_button_secondary['text'] ) ? $cta_button_secondary['text'] : 'На главную';
    $cta_button_secondary_url_raw = isset( $cta_button_secondary['url'] ) ? $cta_button_secondary['url'] : '';
    $cta_button_secondary_url = $cta_button_secondary_url_raw ? ( is_numeric( $cta_button_secondary_url_raw ) ? get_permalink( $cta_button_secondary_url_raw ) : $cta_button_secondary_url_raw ) : home_url('/');
    ?>
    <!-- Header -->
    <?php get_header(); ?>

    <!-- Main Content -->
    <main class="main">
        <!-- Privacy Hero Section -->
        <section class="privacy-hero">
            <div class="privacy-hero__background">
                <div class="privacy-hero__overlay"></div>
            </div>
            
            <div class="privacy-hero__container container">
                <div class="privacy-hero__content">
                    <?php if ( $hero_icon ) : ?>
                    <div class="privacy-hero__icon-wrapper">
                        <div class="privacy-hero__icon">
                            <?php echo wp_kses_post( $hero_icon ); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <h1 class="privacy-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
                    <?php if ( $hero_subtitle ) : ?>
                    <p class="privacy-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
                    <?php endif; ?>
                    <?php if ( $hero_date ) : ?>
                    <p class="privacy-hero__date"><?php echo esc_html( $hero_date ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Privacy Content Section -->
        <section class="privacy-content">
            <div class="privacy-content__container container">
                <div class="privacy-content__wrapper">
                    <?php if ( ! empty( $privacy_sections ) && is_array( $privacy_sections ) ) : ?>
                        <?php foreach ( $privacy_sections as $section ) : 
                            $section_number = isset( $section['number'] ) ? $section['number'] : '';
                            $section_title = isset( $section['title'] ) ? $section['title'] : '';
                            $section_content = isset( $section['content'] ) ? $section['content'] : '';
                        ?>
                        <div class="privacy-section">
                            <?php if ( $section_title ) : ?>
                            <h2 class="privacy-section__title">
                                <?php if ( $section_number ) : ?>
                                    <?php echo esc_html( $section_number ); ?>. 
                                <?php endif; ?>
                                <?php echo esc_html( $section_title ); ?>
                            </h2>
                            <?php endif; ?>
                            <?php if ( $section_content ) : ?>
                            <div class="privacy-section__content">
                                <?php echo wp_kses_post( $section_content ); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <?php if ( $cta_title || $cta_text ) : ?>
        <section class="privacy-cta">
            <div class="privacy-cta__container container">
                <div class="privacy-cta__content">
                    <?php if ( $cta_title ) : ?>
                    <h2 class="privacy-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $cta_text ) : ?>
                    <p class="privacy-cta__text"><?php echo esc_html( $cta_text ); ?></p>
                    <?php endif; ?>
                    <div class="privacy-cta__buttons">
                        <?php if ( $cta_button_primary_text && $cta_button_primary_url ) : ?>
                        <a href="<?php echo esc_url( $cta_button_primary_url ); ?>" class="hero__button hero__button--primary">
                            <?php echo esc_html( $cta_button_primary_text ); ?>
                        </a>
                        <?php endif; ?>
                        <?php if ( $cta_button_secondary_text && $cta_button_secondary_url ) : ?>
                        <a href="<?php echo esc_url( $cta_button_secondary_url ); ?>" class="hero__button hero__button--secondary">
                            <?php echo esc_html( $cta_button_secondary_text ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
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
