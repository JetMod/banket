<?php
/**
 * Функции и определения темы Банкетного
 *
 * @package Банкетного
 */

/**
 * Подключение стилей и скриптов
 */
function banket_assets() {
    // Получаем версию темы
    $theme_version = wp_get_theme()->get('Version');
    if (empty($theme_version)) {
        $theme_version = '1.0.0';
    }
    
    $template_uri = get_template_directory_uri();
    $template_dir = get_template_directory();
    
    // Подключение style.css (заголовок темы WordPress - обязателен)
    wp_enqueue_style( 
        'banket-style', 
        get_stylesheet_uri(), 
        array(), 
        $theme_version 
    );
    
    // Подключение базовых CSS файлов (в правильном порядке)
    $base_styles = array(
        'variables' => '/css/variables.css',
        'reset' => '/css/reset.css',
        'utilities' => '/css/utilities.css',
    );
    
    $dependencies = array('banket-style');
    foreach ($base_styles as $handle => $path) {
        $file_path = $template_dir . $path;
        if (file_exists($file_path)) {
            $version = filemtime($file_path);
            wp_enqueue_style( 
                'banket-' . $handle, 
                $template_uri . $path, 
                $dependencies, 
                $version 
            );
            $dependencies[] = 'banket-' . $handle;
        }
    }
    
    // Подключение основных блоков CSS (всегда)
    $blocks = array(
        'header', 'hero', 'hero-info', 'about', 'advantages', 
        'clients', 'menu', 'gallery', 'reels', 'booking', 
        'contacts', 'footer', 'modal'
    );
    
    foreach ($blocks as $block) {
        $path = '/css/blocks/' . $block . '.css';
        $file_path = $template_dir . $path;
        if (file_exists($file_path)) {
            $version = filemtime($file_path);
            wp_enqueue_style( 
                'banket-' . $block, 
                $template_uri . $path,  
                $dependencies, 
                $version 
            );
        }
    } 

    // gallery-page.css — лайтбокс с кнопками «Поделиться» и «Скачать» (страница Галерея)
    $gallery_page_path = $template_dir . '/css/blocks/gallery-page.css';
    if (file_exists($gallery_page_path)) {
        wp_enqueue_style( 
            'banket-gallery-page', 
            $template_uri . '/css/blocks/gallery-page.css', 
            $dependencies, 
            filemtime($gallery_page_path) 
        );
    }
    
    // Условная загрузка стилей для специальных страниц
    // Reviews Page
    if (is_page('reviews') || basename(get_page_template()) === 'template-reviews.php') {
        $reviews_blocks = array('reviews-hero', 'reviews-stats', 'reviews-filter', 'review-card', 'reviews-gallery', 'yandex-widget');
        foreach ($reviews_blocks as $block) {
            $path = '/css/blocks/' . $block . '.css';
            $file_path = $template_dir . $path;
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                wp_enqueue_style( 
                    'banket-' . $block, 
                    $template_uri . $path, 
                    $dependencies, 
                    $version 
                );
            }
        }
    }
    
    // Events Page
    if (is_page('events') || basename(get_page_template()) === 'template-events.php') {
        $events_blocks = array('events-hero', 'events-nav', 'event-section', 'events-gallery', 'contact-cta');
        foreach ($events_blocks as $block) {
            $path = '/css/blocks/' . $block . '.css';
            $file_path = $template_dir . $path;
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                wp_enqueue_style( 
                    'banket-' . $block, 
                    $template_uri . $path, 
                    $dependencies, 
                    $version 
                );
            } 
        }
    }
    
    // Menu Page
    if (is_page('menu') || basename(get_page_template()) === 'template-menu.php') {
        $menu_path = $template_dir . '/css/blocks/menu-page.css';
        if (file_exists($menu_path)) {
            $version = filemtime($menu_path);
            wp_enqueue_style( 
                'banket-menu-page', 
                $template_uri . '/css/blocks/menu-page.css', 
                $dependencies, 
                $version 
            );
        }
    }
    
    // Privacy Page
    if (is_page('privacy') || basename(get_page_template()) === 'template-privacy.php') {
        $privacy_path = $template_dir . '/css/blocks/privacy.css';
        if (file_exists($privacy_path)) {
            $version = filemtime($privacy_path);
            wp_enqueue_style( 
                'banket-privacy', 
                $template_uri . '/css/blocks/privacy.css', 
                $dependencies, 
                $version 
            );
        }
    }
    
    // Contacts Page
    if (is_page('contacts') || basename(get_page_template()) === 'template-contact.php') {
        // Подключение contacts-hero.css
        $contacts_hero_path = $template_dir . '/css/contacts-hero.css';
        if (file_exists($contacts_hero_path)) {
            $version = filemtime($contacts_hero_path);
            wp_enqueue_style( 
                'banket-contacts-hero', 
                $template_uri . '/css/contacts-hero.css', 
                $dependencies, 
                $version 
            );
        }
    }
    
    // Подключение JavaScript
    $main_js_path = $template_dir . '/js/main.js';
    if (file_exists($main_js_path)) {
        $main_js_version = filemtime($main_js_path);
        wp_enqueue_script( 
            'banket-main-js', 
            $template_uri . '/js/main.js', 
            array(), 
            $main_js_version, 
            true 
        );
    }
}
add_action( 'wp_enqueue_scripts', 'banket_assets' );

/**
 * Favicon (иконка во вкладке браузера) на всех страницах Shen
 */
function banket_favicon() {
    $favicon_url = get_template_directory_uri() . '/img/logo-simple.svg';
    ?>
    <!-- Favicon Shen -->
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( $favicon_url ); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url( $favicon_url ); ?>">
    <link rel="shortcut icon" href="<?php echo esc_url( $favicon_url ); ?>">
    <?php
}
add_action( 'wp_head', 'banket_favicon', 1 );

/**
 * Поддержка функций темы
 */
function banket_theme_support() {
    // Поддержка миниатюр записей
    add_theme_support( 'post-thumbnails' );
    
    // Поддержка заголовка документа
    add_theme_support( 'title-tag' );
    
    // Поддержка HTML5 разметки
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
}
add_action( 'after_setup_theme', 'banket_theme_support' );

/**
 * Регистрация меню
 */
function banket_register_menus() {
    register_nav_menus( array(
        'primary' => 'Основное меню',
        'footer'  => 'Меню в подвале',
    ) );
}
add_action( 'init', 'banket_register_menus' );

/**
 * Поддержка ACF JSON
 */
function banket_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}
add_filter( 'acf/settings/save_json', 'banket_acf_json_save_point' );
 
function banket_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'banket_acf_json_load_point' );

/**
 * Глобальные настройки (ACF Options) для переиспользуемых блоков template-parts
 */
function banket_register_acf_options_pages() {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( array(
            'page_title'  => 'Настройки блоков',
            'menu_title'  => 'Настройки блоков',
            'menu_slug'   => 'banket-blocks-settings',
            'capability'  => 'edit_posts',
            'redirect'    => false,
            'position'    => 61,
            'icon_url'    => 'dashicons-layout',
            'update_button' => 'Сохранить настройки',
            'updated_message' => 'Настройки сохранены',
        ) );
    }
}
add_action( 'acf/init', 'banket_register_acf_options_pages' );

/**
 * Хелпер функция для получения ACF поля с fallback значением
 * 
 * @param string $field_name Имя поля ACF
 * @param mixed $default Значение по умолчанию
 * @param int|string $post_id ID поста (опционально)
 * @return mixed Значение поля или значение по умолчанию
 */
function banket_get_field( $field_name, $default = '', $post_id = null ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name, $post_id );
        return $value !== false && $value !== null ? $value : $default;
    }
    return $default;
}

/**
 * Хелпер функция для получения изображения ACF с fallback
 * 
 * @param string $field_name Имя поля ACF
 * @param string $size Размер изображения
 * @param string $default_url URL изображения по умолчанию
 * @param int|string $post_id ID поста (опционально)
 * @return array Массив с url, alt, width, height
 */
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

/**
 * Хелпер функция для получения галереи ACF с fallback
 * 
 * @param string $field_name Имя поля ACF
 * @param string $size Размер изображений
 * @param array $default_images Массив URL изображений по умолчанию
 * @param int|string $post_id ID поста (опционально)
 * @return array Массив изображений
 */
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
    
    // Возвращаем изображения по умолчанию
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
