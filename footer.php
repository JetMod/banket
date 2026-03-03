<?php
// Получаем данные Footer из ACF Options
$footer_about = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_about', array(), 'option' ) : array();
$footer_navigation = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_navigation', array(), 'option' ) : array();
$footer_services = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_services', array(), 'option' ) : array();
$footer_contacts = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_contacts', array(), 'option' ) : array();
$footer_bottom = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_bottom', array(), 'option' ) : array();
$footer_modal = function_exists( 'banket_get_field' ) ? banket_get_field( 'footer_modal', array(), 'option' ) : array();

// О компании
$about_logo_text = isset( $footer_about['logo_text'] ) ? $footer_about['logo_text'] : 'SHEN';
$about_logo_subtitle = isset( $footer_about['logo_subtitle'] ) ? $footer_about['logo_subtitle'] : 'BANQUET HALLS';
$about_description = isset( $footer_about['description'] ) ? $footer_about['description'] : 'Премиальный банкетный зал для незабываемых мероприятий. Создаем идеальную атмосферу для ваших торжеств.';
$about_social = isset( $footer_about['social_links'] ) ? $footer_about['social_links'] : array();

// Навигация
$nav_title = isset( $footer_navigation['title'] ) ? $footer_navigation['title'] : 'Навигация';
$nav_links = isset( $footer_navigation['links'] ) ? $footer_navigation['links'] : array();

// Услуги
$services_title = isset( $footer_services['title'] ) ? $footer_services['title'] : 'Услуги';
$services_links = isset( $footer_services['links'] ) ? $footer_services['links'] : array();

// Контакты
$contacts_title = isset( $footer_contacts['title'] ) ? $footer_contacts['title'] : 'Контакты';
$contacts_phone = isset( $footer_contacts['phone'] ) ? $footer_contacts['phone'] : '+7 (978) 187-28-27';
$contacts_email = isset( $footer_contacts['email'] ) ? $footer_contacts['email'] : 'banquet@shen.ru';
$contacts_address = isset( $footer_contacts['address'] ) ? $footer_contacts['address'] : 'г. Симферополь, ул. Генерала Васильева, 40А';
$contacts_hours = isset( $footer_contacts['hours'] ) ? $footer_contacts['hours'] : 'Ежедневно с 09:00 до 18:00';
$phone_link = preg_replace( '/[^0-9+]/', '', $contacts_phone );

// Нижняя часть
$copyright_text = isset( $footer_bottom['copyright'] ) ? $footer_bottom['copyright'] : '© {year} Shen Banquet Halls. Все права защищены.';
$copyright_text = str_replace( '{year}', date( 'Y' ), $copyright_text );
$privacy_link = isset( $footer_bottom['privacy_link'] ) ? $footer_bottom['privacy_link'] : array();
$privacy_link_text = isset( $privacy_link['text'] ) ? $privacy_link['text'] : 'Политика конфиденциальности';
$privacy_link_url_raw = isset( $privacy_link['url'] ) ? $privacy_link['url'] : '';
$privacy_link_url = $privacy_link_url_raw ? ( is_numeric( $privacy_link_url_raw ) ? get_permalink( $privacy_link_url_raw ) : ( strpos( $privacy_link_url_raw, 'http' ) === 0 ? $privacy_link_url_raw : home_url( $privacy_link_url_raw ) ) ) : home_url('/политика-конфиденциальности/');

// Модальное окно
$modal_title = isset( $footer_modal['title'] ) ? $footer_modal['title'] : 'Забронировать зал';
$modal_subtitle = isset( $footer_modal['subtitle'] ) ? $footer_modal['subtitle'] : 'Оставьте заявку и мы свяжемся с вами в ближайшее время';
$modal_aria_close = isset( $footer_modal['aria_close'] ) ? $footer_modal['aria_close'] : 'Закрыть модальное окно';
?>

<!-- Footer -->
<footer class="footer">
        <div class="footer__top">
            <div class="footer__container container">
                <div class="footer__grid">
                    <!-- О компании -->
                    <div class="footer__col footer__col--about">
                        <div class="footer__logo">
                            <?php if ( $about_logo_text ) : ?>
                            <h3 class="footer__logo-text"><?php echo esc_html( $about_logo_text ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $about_logo_subtitle ) : ?>
                            <span class="footer__logo-subtitle"><?php echo esc_html( $about_logo_subtitle ); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $about_description ) : ?>
                        <p class="footer__description">
                            <?php echo esc_html( $about_description ); ?>
                        </p>
                        <?php endif; ?>
                        <?php if ( ! empty( $about_social ) && is_array( $about_social ) ) : ?>
                        <div class="footer__social">
                            <?php foreach ( $about_social as $social ) : 
                                $social_url = isset( $social['url'] ) ? $social['url'] : '';
                                $social_icon = isset( $social['icon'] ) ? $social['icon'] : '';
                                $social_aria = isset( $social['aria_label'] ) ? $social['aria_label'] : ( isset( $social['name'] ) ? $social['name'] : '' );
                            ?>
                            <?php if ( $social_url && $social_icon ) : ?>
                            <a href="<?php echo esc_url( $social_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer__social-link" aria-label="<?php echo esc_attr( $social_aria ); ?>">
                                <?php echo wp_kses_post( $social_icon ); ?>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Навигация -->
                    <?php if ( ! empty( $nav_links ) || $nav_title ) : ?>
                    <div class="footer__col">
                        <?php if ( $nav_title ) : ?>
                        <h4 class="footer__col-title"><?php echo esc_html( $nav_title ); ?></h4>
                        <?php endif; ?>
                        <?php if ( ! empty( $nav_links ) && is_array( $nav_links ) ) : ?>
                        <ul class="footer__list">
                            <?php foreach ( $nav_links as $link ) : 
                                $link_text = isset( $link['text'] ) ? $link['text'] : '';
                                $link_url_raw = isset( $link['url'] ) ? $link['url'] : '';
                                $link_url = $link_url_raw ? ( strpos( $link_url_raw, 'http' ) === 0 ? $link_url_raw : home_url( $link_url_raw ) ) : '#';
                            ?>
                            <li><a href="<?php echo esc_url( $link_url ); ?>" class="footer__link"><?php echo esc_html( $link_text ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Услуги -->
                    <?php if ( ! empty( $services_links ) || $services_title ) : ?>
                    <div class="footer__col">
                        <?php if ( $services_title ) : ?>
                        <h4 class="footer__col-title"><?php echo esc_html( $services_title ); ?></h4>
                        <?php endif; ?>
                        <?php if ( ! empty( $services_links ) && is_array( $services_links ) ) : ?>
                        <ul class="footer__list">
                            <?php foreach ( $services_links as $link ) : 
                                $link_text = isset( $link['text'] ) ? $link['text'] : '';
                                $link_url_raw = isset( $link['url'] ) ? $link['url'] : '';
                                $link_url = $link_url_raw ? ( strpos( $link_url_raw, 'http' ) === 0 ? $link_url_raw : home_url( $link_url_raw ) ) : '#';
                            ?>
                            <li><a href="<?php echo esc_url( $link_url ); ?>" class="footer__link"><?php echo esc_html( $link_text ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Контакты -->
                    <div class="footer__col">
                        <?php if ( $contacts_title ) : ?>
                        <h4 class="footer__col-title"><?php echo esc_html( $contacts_title ); ?></h4>
                        <?php endif; ?>
                        <ul class="footer__list footer__list--contacts">
                            <?php if ( $contacts_phone ) : ?>
                            <li>
                                <a href="tel:<?php echo esc_attr( $phone_link ); ?>" class="footer__link footer__link--phone">
                                    <?php echo esc_html( $contacts_phone ); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if ( $contacts_email ) : ?>
                            <li>
                                <a href="mailto:<?php echo esc_attr( $contacts_email ); ?>" class="footer__link">
                                    <?php echo esc_html( $contacts_email ); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if ( $contacts_address ) : ?>
                            <li class="footer__address">
                                <?php echo esc_html( $contacts_address ); ?>
                            </li>
                            <?php endif; ?>
                            <?php if ( $contacts_hours ) : ?>
                            <li class="footer__hours">
                                <?php echo esc_html( $contacts_hours ); ?>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="footer__container container">
                <div class="footer__bottom-content">
                    <?php if ( $copyright_text ) : ?>
                    <p class="footer__copyright"><?php echo esc_html( $copyright_text ); ?></p>
                    <?php endif; ?>
                    <?php if ( $privacy_link_text && $privacy_link_url ) : ?>
                    <div class="footer__links">
                        <a href="<?php echo esc_url( $privacy_link_url ); ?>" class="footer__bottom-link"><?php echo esc_html( $privacy_link_text ); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
 
    <!-- Модальное окно для формы обратной связи -->
    <div class="modal" id="bookingModal">
        <div class="modal__overlay"></div>
        <div class="modal__container">
            <button class="modal__close" aria-label="<?php echo esc_attr( $modal_aria_close ); ?>">
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
                    <?php if ( $modal_title ) : ?>
                    <h2 class="modal__title"><?php echo esc_html( $modal_title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $modal_subtitle ) : ?>
                    <p class="modal__subtitle"><?php echo esc_html( $modal_subtitle ); ?></p>
                    <?php endif; ?>
                </div>

                <?php echo do_shortcode('[contact-form-7 id="d9171cd" title="Модальное окно"]'); ?>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>

