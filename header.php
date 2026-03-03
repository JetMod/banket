<?php
// Получаем данные Header из ACF Options
$header_logo = function_exists( 'banket_get_field' ) ? banket_get_field( 'header_logo', array(), 'option' ) : array();
$header_mobile_logo = function_exists( 'banket_get_field' ) ? banket_get_image( 'header_mobile_logo', 'full', get_template_directory_uri() . '/img/logo.png', 'option' ) : array( 'url' => get_template_directory_uri() . '/img/logo.png', 'alt' => 'Shen Banquet Halls' );
$header_menu = function_exists( 'banket_get_field' ) ? banket_get_field( 'header_menu', array(), 'option' ) : array();
$header_contacts = function_exists( 'banket_get_field' ) ? banket_get_field( 'header_contacts', array(), 'option' ) : array();
$header_aria_labels = function_exists( 'banket_get_field' ) ? banket_get_field( 'header_aria_labels', array(), 'option' ) : array();

// Логотип
// Проверяем, находимся ли мы на странице контактов или политики конфиденциальности
$is_special_page = false;
if ( function_exists( 'is_page_template' ) ) {
    if ( is_page_template( 'template-contact.php' ) || is_page_template( 'template-privacy.php' ) ) {
        $is_special_page = true;
    }
} elseif ( function_exists( 'get_page_template_slug' ) ) {
    $template_slug = get_page_template_slug();
    if ( $template_slug === 'template-contact.php' || $template_slug === 'template-privacy.php' ) {
        $is_special_page = true;
    }
}

// Если специальная страница (контакты или политика конфиденциальности), используем shen_logo.svg
if ( $is_special_page ) {
    $shen_logo_path = get_template_directory() . '/img/shen_logo.svg';
    if ( file_exists( $shen_logo_path ) ) {
        $logo_svg = file_get_contents( $shen_logo_path );
        $logo_type = 'svg';
    } else {
        // Если файл не найден, используем стандартную логику
        $logo_type = isset( $header_logo['type'] ) ? $header_logo['type'] : 'svg';
        $logo_svg = isset( $header_logo['svg'] ) ? $header_logo['svg'] : '';
    }
    $logo_image = array();
    $logo_image_url = '';
} else {
    // Стандартная логика для остальных страниц
    $logo_type = isset( $header_logo['type'] ) ? $header_logo['type'] : 'svg';
    $logo_svg = isset( $header_logo['svg'] ) ? $header_logo['svg'] : '';
    $logo_image = isset( $header_logo['image'] ) ? $header_logo['image'] : array();
    $logo_image_url = is_array( $logo_image ) && isset( $logo_image['url'] ) ? $logo_image['url'] : ( is_numeric( $logo_image ) ? wp_get_attachment_image_url( $logo_image, 'full' ) : '' );
}

// Контакты
$header_phone = isset( $header_contacts['phone'] ) ? $header_contacts['phone'] : '+7 (978) 187-28-27';
$header_address = isset( $header_contacts['address'] ) ? $header_contacts['address'] : 'ул. Генерала Васильева, 40А';

// ARIA labels
$aria_nav = isset( $header_aria_labels['nav'] ) ? $header_aria_labels['nav'] : 'Основная навигация';
$aria_burger = isset( $header_aria_labels['burger'] ) ? $header_aria_labels['burger'] : 'Открыть меню';
$aria_arrow = isset( $header_aria_labels['arrow'] ) ? $header_aria_labels['arrow'] : 'Раскрыть подменю';

// Формируем телефон для ссылки
$phone_link = preg_replace( '/[^0-9+]/', '', $header_phone );
?>

<!-- Header внутри Hero -->
<header class="header" id="header">
    <div class="header__container container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
            <?php if ( $logo_type === 'svg' && $logo_svg ) : ?>
                <?php echo wp_kses_post( $logo_svg ); ?>
            <?php elseif ( $logo_type === 'image' && $logo_image_url ) : ?>
                <img src="<?php echo esc_url( $logo_image_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="header__logo-svg">
            <?php else : ?>
                <!-- Fallback логотип -->
                <svg class="header__logo-svg" width="120" height="50" viewBox="0 0 120 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 25L8 19L2 13" stroke="url(#gold-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="18" y="32" font-family="'Playfair Display', serif" font-size="24" font-weight="600" fill="url(#gold-gradient)" letter-spacing="2">SHEN</text>
                    <path d="M118 25L112 31L118 37" stroke="url(#gold-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="60" y="44" font-family="'Inter', sans-serif" font-size="7" fill="rgba(255,255,255,0.8)" text-anchor="middle" letter-spacing="3">BANQUET HALLS</text>
                    <defs>
                        <linearGradient id="gold-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d4af37;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#f4d03f;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#c9a961;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            <?php endif; ?>
        </a>
        
        <nav class="header__nav" id="header-nav" aria-label="<?php echo esc_attr( $aria_nav ); ?>">
            <!-- Логотип для мобильного меню -->
            <div class="header__nav-logo">
                <img src="<?php echo esc_url( $header_mobile_logo['url'] ); ?>" alt="<?php echo esc_attr( $header_mobile_logo['alt'] ?: get_bloginfo( 'name' ) ); ?>" class="header__nav-logo-img" width="120" height="50">
            </div>
             
            <?php if ( ! empty( $header_menu ) && is_array( $header_menu ) ) : ?>
            <ul class="header__menu" role="menubar">
                <?php foreach ( $header_menu as $menu_item ) : 
                    $menu_title = isset( $menu_item['title'] ) ? $menu_item['title'] : '';
                    $menu_url_raw = isset( $menu_item['url'] ) ? $menu_item['url'] : '';
                    $menu_url = $menu_url_raw ? ( strpos( $menu_url_raw, 'http' ) === 0 ? $menu_url_raw : home_url( $menu_url_raw ) ) : '#';
                    $has_dropdown = isset( $menu_item['has_dropdown'] ) && $menu_item['has_dropdown'];
                    $dropdown_items = isset( $menu_item['dropdown_items'] ) ? $menu_item['dropdown_items'] : array();
                    $dropdown_aria_label = isset( $menu_item['dropdown_aria_label'] ) ? $menu_item['dropdown_aria_label'] : 'Подменю';
                ?>
                <li class="header__menu-item <?php echo $has_dropdown ? 'header__menu-item--dropdown' : ''; ?>" role="none">
                    <a href="<?php echo esc_url( $menu_url ); ?>" class="header__menu-link" role="menuitem" <?php echo $has_dropdown ? 'aria-haspopup="true" aria-expanded="false"' : ''; ?>>
                        <?php echo esc_html( $menu_title ); ?>
                        <?php if ( $has_dropdown ) : ?>
                        <svg class="header__menu-arrow" width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <?php endif; ?>
                    </a>
                    <?php if ( $has_dropdown && ! empty( $dropdown_items ) ) : ?>
                    <ul class="header__dropdown" role="menu" aria-label="<?php echo esc_attr( $dropdown_aria_label ); ?>">
                        <?php foreach ( $dropdown_items as $dropdown_item ) : 
                            $dropdown_title = isset( $dropdown_item['title'] ) ? $dropdown_item['title'] : '';
                            $dropdown_url_raw = isset( $dropdown_item['url'] ) ? $dropdown_item['url'] : '';
                            $dropdown_url = $dropdown_url_raw ? ( strpos( $dropdown_url_raw, 'http' ) === 0 ? $dropdown_url_raw : home_url( $dropdown_url_raw ) ) : '#';
                        ?>
                        <li class="header__dropdown-item" role="none">
                            <a href="<?php echo esc_url( $dropdown_url ); ?>" class="header__dropdown-link" role="menuitem"><?php echo esc_html( $dropdown_title ); ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
             
            <!-- Контакты в мобильном меню -->
            <div class="header__nav-contacts">
                <?php if ( $header_phone ) : ?>
                <a href="tel:<?php echo esc_attr( $phone_link ); ?>" class="header__nav-phone"><?php echo esc_html( $header_phone ); ?></a>
                <?php endif; ?>
                <?php if ( $header_address ) : ?>
                <p class="header__nav-address"><?php echo esc_html( $header_address ); ?></p>
                <?php endif; ?>
            </div>
        </nav>
        
        <?php if ( $header_phone ) : ?>
        <a href="tel:<?php echo esc_attr( $phone_link ); ?>" class="header__phone"><?php echo esc_html( $header_phone ); ?></a>
        <?php endif; ?>
        
        <button class="header__burger" aria-label="<?php echo esc_attr( $aria_burger ); ?>" aria-expanded="false" aria-controls="header-nav">
            <span class="header__burger-line" aria-hidden="true"></span>
            <span class="header__burger-line" aria-hidden="true"></span>
            <span class="header__burger-line" aria-hidden="true"></span>
        </button>
    </div>
</header>