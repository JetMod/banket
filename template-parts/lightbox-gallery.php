<?php
/**
 * Lightbox для галереи
 * 
 * Использование:
 * $lightbox_args = array(
 *     'variant' => 'full',  // или 'simple'
 *     'id'      => 'galleryLightbox',
 * );
 * set_query_var( 'lightbox_args', $lightbox_args );
 * get_template_part( 'template-parts/lightbox-gallery' );
 */

$defaults = array(
    'variant' => 'full',
    'id'      => 'galleryLightbox',
);
 
// Получаем аргументы из query_var или используем значения по умолчанию
$lightbox_args = get_query_var( 'lightbox_args', array() );
$args = wp_parse_args( $lightbox_args, $defaults );

// Глобальные тексты (Настройки блоков → Блок: Lightbox галереи)
$tp_lightbox = function_exists( 'banket_get_field' ) ? banket_get_field( 'tp_lightbox', array(), 'option' ) : array();
$aria_close = isset( $tp_lightbox['aria_close'] ) ? $tp_lightbox['aria_close'] : 'Закрыть';
$aria_prev = isset( $tp_lightbox['aria_prev'] ) ? $tp_lightbox['aria_prev'] : 'Предыдущее фото';
$aria_next = isset( $tp_lightbox['aria_next'] ) ? $tp_lightbox['aria_next'] : 'Следующее фото';
$aria_slideshow = isset( $tp_lightbox['aria_slideshow'] ) ? $tp_lightbox['aria_slideshow'] : 'Запустить слайдшоу';
$title_zoom = isset( $tp_lightbox['title_zoom'] ) ? $tp_lightbox['title_zoom'] : 'Zoom';
$title_share = isset( $tp_lightbox['title_share'] ) ? $tp_lightbox['title_share'] : 'Поделиться';
$title_download = isset( $tp_lightbox['title_download'] ) ? $tp_lightbox['title_download'] : 'Скачать';
$counter_fallback = isset( $tp_lightbox['counter_fallback'] ) ? $tp_lightbox['counter_fallback'] : '1 / 14';
$category_fallback = isset( $tp_lightbox['category_fallback'] ) ? $tp_lightbox['category_fallback'] : '🏛 Интерьер';

// Простой вариант (для reviews)
if ( $args['variant'] === 'simple' ) :
?>

<!-- Lightbox Modal -->
<div class="gallery__lightbox" id="<?php echo esc_attr( $args['id'] ); ?>">
    <button class="gallery__lightbox-close" aria-label="<?php echo esc_attr( $aria_close ); ?>">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
    
    <button class="gallery__lightbox-prev" aria-label="<?php echo esc_attr( $aria_prev ); ?>">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
            <path d="M15 18l-6-6 6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    
    <button class="gallery__lightbox-next" aria-label="<?php echo esc_attr( $aria_next ); ?>">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
            <path d="M9 18l6-6-6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button> 
    
    <div class="gallery__lightbox-content">
        <div class="gallery__lightbox-img-wrap">
            <img src="" alt="" class="gallery__lightbox-img" id="lightboxImg">
            <!-- Toolbar справа внутри изображения -->
            <div class="gallery__lightbox-toolbar">
                <button type="button" class="gallery__lightbox-tool-btn" id="shareBtn" title="<?php echo esc_attr( $title_share ); ?>" aria-label="<?php echo esc_attr( $title_share ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="18" cy="5" r="3"/>
                        <circle cx="6" cy="12" r="3"/>
                        <circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                </button>
                <button type="button" class="gallery__lightbox-tool-btn" id="downloadBtn" title="<?php echo esc_attr( $title_download ); ?>" aria-label="<?php echo esc_attr( $title_download ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="gallery__lightbox-counter" id="lightboxCounter"><?php echo esc_html( $counter_fallback ); ?></div>
    </div>
</div>

<?php else : // Полный вариант (для gallery) ?>

<!-- Lightbox Modal -->
<div class="gallery-lightbox" id="<?php echo esc_attr( $args['id'] ); ?>">
    <button class="gallery-lightbox__close" aria-label="<?php echo esc_attr( $aria_close ); ?>" id="lightboxClose">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
    
    <button class="gallery-lightbox__prev" aria-label="<?php echo esc_attr( $aria_prev ); ?>" id="lightboxPrev">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
            <path d="M15 18l-6-6 6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    
    <button class="gallery-lightbox__next" aria-label="<?php echo esc_attr( $aria_next ); ?>" id="lightboxNext">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
            <path d="M9 18l6-6-6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <!-- Slideshow Button -->
    <button class="gallery-lightbox__slideshow" aria-label="<?php echo esc_attr( $aria_slideshow ); ?>" id="lightboxSlideshow">
        <svg class="gallery-lightbox__slideshow-icon gallery-lightbox__slideshow-icon--play" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M8 5v14l11-7z" fill="white"/>
        </svg>
        <svg class="gallery-lightbox__slideshow-icon gallery-lightbox__slideshow-icon--pause" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display: none;">
            <path d="M6 4h4v16H6zM14 4h4v16h-4z" fill="white"/>
        </svg>
    </button>
    
    <div class="gallery-lightbox__content">
        <img src="" alt="" class="gallery-lightbox__img" id="lightboxImg">
        
        <!-- Toolbar с дополнительными кнопками -->
        <div class="gallery-lightbox__toolbar">
            <button class="gallery-lightbox__tool-btn" id="zoomBtn" title="<?php echo esc_attr( $title_zoom ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                    <line x1="11" y1="8" x2="11" y2="14"/>
                    <line x1="8" y1="11" x2="14" y2="11"/>
                </svg>
            </button>
            <button class="gallery-lightbox__tool-btn" id="shareBtn" title="<?php echo esc_attr( $title_share ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="18" cy="5" r="3"/>
                    <circle cx="6" cy="12" r="3"/>
                    <circle cx="18" cy="19" r="3"/>
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                </svg>
            </button>
            <button class="gallery-lightbox__tool-btn" id="downloadBtn" title="<?php echo esc_attr( $title_download ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
            </button>
        </div>
        
        <div class="gallery-lightbox__info">
            <div class="gallery-lightbox__counter" id="lightboxCounter">
                <span class="gallery-lightbox__counter-text"><?php echo esc_html( $counter_fallback ); ?></span>
                <div class="gallery-lightbox__progress">
                    <div class="gallery-lightbox__progress-bar" id="lightboxProgress"></div>
                </div>
            </div>
            <div class="gallery-lightbox__category" id="lightboxCategory"><?php echo esc_html( $category_fallback ); ?></div>
        </div>
    </div>
</div>

<?php endif; ?>

