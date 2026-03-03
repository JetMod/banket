<?php
/**
 * Template Name: Мероприятия
 * Description: Шаблон страницы мероприятий
 */

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
    <meta name="description" content="Организация мероприятий в банкетном зале Shen: свадьбы, корпоративы, юбилеи, дни рождения. Профессиональная команда, премиальное обслуживание, вместимость до 300 гостей.">
    <title>Мероприятия в Shen | Свадьбы, Корпоративы, Дни Рождения, Юбилеи</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo-simple.svg">
    
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
        $events_hero = banket_get_field( 'events_hero', array(), null );
        
        $hero_label = isset( $events_hero['label'] ) ? $events_hero['label'] : 'Незабываемые мероприятия';
        $hero_label_icon = isset( $events_hero['label_icon'] ) ? $events_hero['label_icon'] : '✨';
        $hero_title = isset( $events_hero['title'] ) ? $events_hero['title'] : 'Создаем волшебство ваших праздников';
        $hero_title_accent = isset( $events_hero['title_accent'] ) ? $events_hero['title_accent'] : 'волшебство';
        $hero_subtitle = isset( $events_hero['subtitle'] ) ? $events_hero['subtitle'] : 'От камерных celebrations до масштабных торжеств. Профессиональная организация мероприятий любого формата в премиальном банкетном зале Shen.';
        
        // Слайдер
        $hero_slider_default = array(
            get_template_directory_uri() . '/img/1.webp',
            get_template_directory_uri() . '/img/2.webp',
            get_template_directory_uri() . '/img/3.webp',
            get_template_directory_uri() . '/img/4.webp',
            get_template_directory_uri() . '/img/5.webp'
        );
        $hero_slider_images = banket_get_gallery( 'events_hero_slider', 'full', $hero_slider_default, null );
        
        // Навигационные карточки
        $hero_nav_cards = isset( $events_hero['nav_cards'] ) ? $events_hero['nav_cards'] : array(
            array( 'icon' => '💍', 'title' => 'Свадьбы', 'count' => '150+', 'anchor' => 'wedding' ),
            array( 'icon' => '🎉', 'title' => 'Корпоративы', 'count' => '200+', 'anchor' => 'corporate' ),
            array( 'icon' => '🎂', 'title' => 'Дни рождения', 'count' => '300+', 'anchor' => 'birthday' ),
            array( 'icon' => '🎊', 'title' => 'Юбилеи', 'count' => '180+', 'anchor' => 'anniversary' ),
            array( 'icon' => '🎓', 'title' => 'Выпускные', 'count' => '50+', 'anchor' => 'graduation' ),
            array( 'icon' => '💼', 'title' => 'Конференции', 'count' => '80+', 'anchor' => 'conference' ),
            array( 'icon' => '🎈', 'title' => 'Детские', 'count' => '120+', 'anchor' => 'kids' ),
            array( 'icon' => '🎄', 'title' => 'Новогодние', 'count' => '60+', 'anchor' => 'newyear' )
        );
        ?>
        <section class="events-hero">
        <?php get_header(); ?>
            
            <!-- Hero Background -->
            <div class="events-hero__background">
                <div class="events-hero__slideshow">
                    <?php foreach ( $hero_slider_images as $index => $image ) : ?>
                        <div class="events-hero__slide <?php echo $index === 0 ? 'events-hero__slide--active' : ''; ?>">
                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?: 'Мероприятие в Shen' ); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="events-hero__overlay"></div>
            </div>
            
            <!-- Hero Content -->
            <div class="events-hero__container container">
                <div class="events-hero__content">
                    <?php if ( $hero_label ) : ?>
                        <span class="events-hero__label">
                            <?php if ( $hero_label_icon ) : ?>
                                <span class="events-hero__label-icon"><?php echo esc_html( $hero_label_icon ); ?></span>
                            <?php endif; ?>
                            <?php echo esc_html( $hero_label ); ?>
                        </span>
                    <?php endif; ?>
                    
                    <h1 class="events-hero__title">
                        <?php 
                        $title_parts = explode( $hero_title_accent, $hero_title );
                        if ( count( $title_parts ) > 1 ) {
                            echo esc_html( $title_parts[0] );
                            echo '<span class="events-hero__title-accent">' . esc_html( $hero_title_accent ) . '</span>';
                            echo esc_html( $title_parts[1] );
                        } else {
                            echo esc_html( $hero_title );
                        }
                        ?>
                    </h1>
                    
                    <?php if ( $hero_subtitle ) : ?>
                        <p class="events-hero__subtitle">
                            <?php echo nl2br( esc_html( $hero_subtitle ) ); ?>
                        </p>
                    <?php endif; ?>
                    
                    <!-- Навигационные карточки -->
                    <?php if ( ! empty( $hero_nav_cards ) ) : ?>
                        <div class="events-hero__nav-cards">
                            <?php foreach ( $hero_nav_cards as $card ) : 
                                $card_icon = isset( $card['icon'] ) ? $card['icon'] : '';
                                $card_title = isset( $card['title'] ) ? $card['title'] : '';
                                $card_count = isset( $card['count'] ) ? $card['count'] : '';
                                $card_anchor = isset( $card['anchor'] ) ? $card['anchor'] : '';
                            ?>
                                <a href="#<?php echo esc_attr( $card_anchor ); ?>" class="events-hero__nav-card">
                                    <?php if ( $card_icon ) : ?>
                                        <span class="events-hero__nav-icon"><?php echo esc_html( $card_icon ); ?></span>
                                    <?php endif; ?>
                                    <span class="events-hero__nav-title"><?php echo esc_html( $card_title ); ?></span>
                                    <?php if ( $card_count ) : ?>
                                        <span class="events-hero__nav-count"><?php echo esc_html( $card_count ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        
        <!-- Events Navigation Bar (Sticky) -->
        <?php
        // Получаем секции мероприятий для навигации
        $events_sections = banket_get_field( 'events_sections', array(), null );
        ?>
        <nav class="events-nav" id="events-nav">
            <div class="container">
                <ul class="events-nav__list">
                    <?php if ( ! empty( $events_sections ) ) : 
                        foreach ( $events_sections as $section ) :
                            $section_id = isset( $section['section_id'] ) ? $section['section_id'] : '';
                            $section_label = isset( $section['label'] ) ? $section['label'] : '';
                            // Извлекаем иконку и текст из метки
                            $label_parts = explode( ' ', $section_label, 2 );
                            $nav_icon = ! empty( $label_parts[0] ) ? $label_parts[0] : '';
                            $nav_label = ! empty( $label_parts[1] ) ? $label_parts[1] : $section_label;
                    ?>
                        <li class="events-nav__item">
                            <a href="#<?php echo esc_attr( $section_id ); ?>" class="events-nav__link" data-section="<?php echo esc_attr( $section_id ); ?>">
                                <?php if ( $nav_icon ) : ?>
                                    <span class="events-nav__icon"><?php echo esc_html( $nav_icon ); ?></span>
                                <?php endif; ?>
                                <span class="events-nav__label"><?php echo esc_html( $nav_label ); ?></span>
                            </a>
                        </li>
                    <?php endforeach; 
                    endif; ?>
                </ul>
            </div>
        </nav>
        
        <!-- Sections: Мероприятия -->
        <?php
        // Получаем секции мероприятий из ACF
        if ( empty( $events_sections ) ) {
            // Дефолтные секции, если ACF не заполнено
            $events_sections = array(
                array(
                    'section_id' => 'wedding',
                    'style' => 'light',
                    'label' => '💍 Свадьбы',
                    'title' => 'Ваша свадьба — начало волшебной истории',
                    'description' => 'Ваша свадьба в Shen — это начало новой главы в атмосфере роскоши и элегантности. Мы создаем незабываемые торжества, где каждая деталь продумана до мелочей. Премиальный банкетный зал с безупречным сервисом и изысканной атмосферой.',
                    'stats' => array(
                        array( 'number' => '150+', 'label' => 'проведенных свадеб' ),
                        array( 'number' => '4.9', 'label' => 'средний рейтинг' ),
                        array( 'number' => '98%', 'label' => 'рекомендуют нас' )
                    ),
                    'cta' => array( 'text' => 'Забронировать свадьбу', 'note' => 'Бронируйте заранее — лучшие даты разбирают за 6-12 месяцев' )
                ),
                array(
                    'section_id' => 'corporate',
                    'style' => 'dark',
                    'label' => '🎉 Корпоративы',
                    'title' => 'Корпоративные праздники с размахом',
                    'description' => 'Корпоративные мероприятия в Shen — это идеальное сочетание делового подхода и праздничной атмосферы. Организуем Новогодние корпоративы, team building события, празднования успехов компании и деловые вечера. Профессиональная команда, современное оборудование для презентаций, изысканное меню и безупречный сервис — всё для успеха вашего корпоративного мероприятия.',
                    'stats' => array(
                        array( 'number' => '200+', 'label' => 'корпоративов' ),
                        array( 'number' => '4.8', 'label' => 'рейтинг' ),
                        array( 'number' => '95%', 'label' => 'повторные заказы' )
                    ),
                    'cta' => array( 'text' => 'Заказать корпоратив', 'note' => 'Специальные условия для постоянных клиентов' )
                ),
                array(
                    'section_id' => 'birthday',
                    'style' => 'light',
                    'label' => '🎂 Дни рождения',
                    'title' => 'Праздник, который запомнится надолго!',
                    'description' => 'День рождения в Shen — это праздник, который запомнится надолго! Создаем атмосферу радости и веселья для гостей любого возраста. От ужина на 20 человек до масштабной вечеринки на 300 гостей. Индивидуальное оформление, тематические декорации, профессиональное обслуживание и изысканное меню — мы воплотим в жизнь праздник вашей мечты.',
                    'stats' => array(
                        array( 'number' => '300+', 'label' => 'дней рождения' ),
                        array( 'number' => '4.9', 'label' => 'рейтинг' ),
                        array( 'number' => '100%', 'label' => 'радости гостей' )
                    ),
                    'cta' => array( 'text' => 'Организовать праздник', 'note' => 'Бонусы именинникам — торт или шампанское в подарок!' )
                ),
                array(
                    'section_id' => 'anniversary',
                    'style' => 'dark',
                    'label' => '🎊 Юбилеи',
                    'title' => 'Торжественный размах особенной даты',
                    'description' => 'Юбилей — особенная дата, требующая торжественного размаха. В Shen мы организуем юбилеи с особым шиком: 30, 40, 50, 60 лет и другие значимые даты. Элегантная атмосфера, изысканное меню, внимание к каждой детали и тёплая семейная обстановка. Мы создаём торжество, достойное ваших достижений и окружённое теплом близких людей.',
                    'stats' => array(
                        array( 'number' => '180+', 'label' => 'юбилеев' ),
                        array( 'number' => '5.0', 'label' => 'рейтинг' ),
                        array( 'number' => '100%', 'label' => 'счастливых именинников' )
                    ),
                    'cta' => array( 'text' => 'Отпраздновать юбилей', 'note' => 'Скидки для больших компаний от 100 гостей' )
                ),
                array(
                    'section_id' => 'graduation',
                    'style' => 'light',
                    'label' => '🎓 Выпускные',
                    'title' => 'Незабываемый вечер прощания с юностью',
                    'description' => 'Выпускной вечер — это прощание с беззаботной юностью и шаг во взрослую жизнь. Организуем выпускные для школ, колледжей и университетов. Стильное оформление, молодёжная атмосфера, современная музыка и праздничное меню. Создаём вечер, который станет ярким воспоминанием на всю жизнь для выпускников и их родителей.',
                    'stats' => array(
                        array( 'number' => '50+', 'label' => 'выпускных' ),
                        array( 'number' => '4.9', 'label' => 'рейтинг' )
                    ),
                    'cta' => array( 'text' => 'Забронировать выпускной', 'note' => 'Ранее бронирование — лучшие даты разбирают за 8-10 месяцев' )
                ),
                array(
                    'section_id' => 'conference',
                    'style' => 'dark',
                    'label' => '💼 Конференции',
                    'title' => 'Деловые мероприятия формата премиум',
                    'description' => 'Деловые мероприятия в формате премиум. Организуем конференции, презентации, семинары, бизнес-встречи и тренинги любого уровня. Профессиональное техническое оснащение, удобная рассадка, кофе-брейки и бизнес-ланчи. Создаём идеальные условия для продуктивной работы и нетворкинга в комфортной обстановке с безупречным сервисом.',
                    'stats' => array(
                        array( 'number' => '80+', 'label' => 'мероприятий' ),
                        array( 'number' => '4.8', 'label' => 'рейтинг' ),
                        array( 'number' => '300', 'label' => 'макс. участников' )
                    ),
                    'cta' => array( 'text' => 'Организовать мероприятие', 'note' => 'Индивидуальные условия для длительной аренды' )
                ),
                array(
                    'section_id' => 'kids',
                    'style' => 'light',
                    'label' => '🎈 Детские праздники',
                    'title' => 'Волшебство для маленьких гостей',
                    'description' => 'Детский праздник в Shen — это волшебство! Создаем сказочные celebrations для маленьких гостей. Дни рождения, выпускные в детском саду, первое причастие и другие детские торжества. Яркое тематическое оформление, детское меню, безопасное пространство и весёлая атмосфера. Помогаем организовать аниматоров, шоу-программы и сладкий стол для незабываемого праздника.',
                    'stats' => array(
                        array( 'number' => '120+', 'label' => 'детских праздников' ),
                        array( 'number' => '5.0', 'label' => 'рейтинг' ),
                        array( 'number' => '100%', 'label' => 'счастливых детей' )
                    ),
                    'cta' => array( 'text' => 'Устроить детский праздник', 'note' => '' )
                ),
                array(
                    'section_id' => 'newyear',
                    'style' => 'dark',
                    'label' => '🎄 Новогодние мероприятия',
                    'title' => 'Встречайте Новый год в атмосфере сказки',
                    'description' => 'Встречайте Новый год в атмосфере сказки и волшебства! Новогодние корпоративы, семейные celebrations и дружеские вечеринки в Shen. Праздничное оформление в новогодней тематике, изысканное праздничное меню, живая музыка или DJ, шоу-программы и, конечно, бой курантов в окружении близких людей. Создаём волшебную атмосферу для встречи самого главного праздника года.',
                    'stats' => array(
                        array( 'number' => '60+', 'label' => 'новогодних вечеров' ),
                        array( 'number' => '4.9', 'label' => 'рейтинг' ),
                        array( 'number' => '31 дек', 'label' => 'бронируйте заранее!' )
                    ),
                    'cta' => array( 'text' => 'Забронировать Новый год', 'note' => 'Бронирование на 31 декабря открыто — количество мест ограничено!' )
                )
            );
        }
        
        // Выводим секции
        if ( ! empty( $events_sections ) ) :
            foreach ( $events_sections as $section ) :
                $section_id = isset( $section['section_id'] ) ? $section['section_id'] : '';
                $section_style = isset( $section['style'] ) ? $section['style'] : 'light';
                $section_label = isset( $section['label'] ) ? $section['label'] : '';
                $section_title = isset( $section['title'] ) ? $section['title'] : '';
                $section_description = isset( $section['description'] ) ? $section['description'] : '';
                $section_stats = isset( $section['stats'] ) ? $section['stats'] : array();
                $section_cta = isset( $section['cta'] ) ? $section['cta'] : array();
                $cta_text = isset( $section_cta['text'] ) ? $section_cta['text'] : 'Забронировать';
                $cta_note = isset( $section_cta['note'] ) ? $section_cta['note'] : '';
                
                // Галерея для секции (из repeater поля)
                $section_gallery = isset( $section['gallery'] ) && is_array( $section['gallery'] ) ? $section['gallery'] : array();
                if ( ! empty( $section_gallery ) ) {
                    $gallery_images = array();
                    foreach ( $section_gallery as $img ) {
                        if ( is_array( $img ) ) {
                            $gallery_images[] = array(
                                'url' => isset( $img['url'] ) ? $img['url'] : ( isset( $img['sizes']['full'] ) ? $img['sizes']['full'] : '' ),
                                'alt' => isset( $img['alt'] ) ? $img['alt'] : '',
                            );
                        } elseif ( is_numeric( $img ) ) {
                            $img_data = wp_get_attachment_image_src( $img, 'full' );
                            if ( $img_data ) {
                                $gallery_images[] = array(
                                    'url' => $img_data[0],
                                    'alt' => get_post_meta( $img, '_wp_attachment_image_alt', true ),
                                );
                            }
                        }
                    }
                    $section_gallery = $gallery_images;
                }
        ?>
        <section class="event-section event-section--<?php echo esc_attr( $section_style ); ?>" id="<?php echo esc_attr( $section_id ); ?>">
            <div class="container">
                <div class="event-section__content">
                    <?php if ( $section_label ) : ?>
                        <span class="event-section__label"><?php echo esc_html( $section_label ); ?></span>
                    <?php endif; ?>
                    
                    <?php if ( $section_title ) : ?>
                        <h2 class="event-section__title"><?php echo esc_html( $section_title ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( $section_description ) : ?>
                        <p class="event-section__description">
                            <?php echo nl2br( esc_html( $section_description ) ); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $section_stats ) ) : ?>
                        <div class="event-section__stats">
                            <?php foreach ( $section_stats as $stat ) : 
                                $stat_number = isset( $stat['number'] ) ? $stat['number'] : '';
                                $stat_label = isset( $stat['label'] ) ? $stat['label'] : '';
                            ?>
                                <div class="event-stat">
                                    <span class="event-stat__number"><?php echo esc_html( $stat_number ); ?></span>
                                    <span class="event-stat__label"><?php echo esc_html( $stat_label ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="event-section__cta">
                        <a href="<?php echo esc_url( home_url('/контакты/') ); ?>" class="button button--primary button--large" data-action="open-booking">
                            <span class="button__text"><?php echo esc_html( $cta_text ); ?></span>
                            <span class="button__icon">→</span>
                        </a>
                        <?php if ( $cta_note ) : ?>
                            <p class="event-section__cta-note"><?php echo esc_html( $cta_note ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php 
            endforeach;
        endif; ?>
        
        <!-- Contact CTA Section -->
        <?php
        // Получаем данные Contact CTA секции из ACF
        $contact_cta = banket_get_field( 'events_contact_cta', array(), null );
        
        $cta_title = isset( $contact_cta['title'] ) ? $contact_cta['title'] : 'Готовы создать незабываемое мероприятие?';
        $cta_subtitle = isset( $contact_cta['subtitle'] ) ? $contact_cta['subtitle'] : 'Свяжитесь с нами для консультации и бронирования';
        $cta_phone = isset( $contact_cta['phone'] ) ? $contact_cta['phone'] : '+7 (978) 187-28-27';
        $cta_whatsapp = isset( $contact_cta['whatsapp'] ) ? $contact_cta['whatsapp'] : '79781872827';
        $cta_button_text = isset( $contact_cta['button_text'] ) ? $contact_cta['button_text'] : 'Забронировать';
        ?>
        <section class="contact-cta" id="contact-cta">
            <div class="container">
                <div class="contact-cta__content">
                    <h2 class="contact-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
                    <?php if ( $cta_subtitle ) : ?>
                        <p class="contact-cta__subtitle"><?php echo esc_html( $cta_subtitle ); ?></p>
                    <?php endif; ?>
                    
                    <div class="contact-cta__methods">
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $cta_phone ) ); ?>" class="contact-method">
                            <span class="contact-method__icon">📞</span>
                            <span class="contact-method__text"><?php echo esc_html( $cta_phone ); ?></span>
                        </a>
                        <?php if ( $cta_whatsapp ) : ?>
                            <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $cta_whatsapp ) ); ?>" class="contact-method">
                                <span class="contact-method__icon">💬</span>
                                <span class="contact-method__text">WhatsApp</span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( home_url('/контакты/') ); ?>" class="button button--primary button--large" data-action="open-booking">
                            <span class="button__text"><?php echo esc_html( $cta_button_text ); ?></span>
                            <span class="button__icon">→</span>
                        </a>
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

     <!-- Footer -->
     <footer class="footer">
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