<?php
	/* Template Name: Шаблон страницы Контакты */
get_header();
?>  
 
<section class="min-section conts-page">
    <div class="content">
        <div class="title-section">
        <?php while (have_posts()) : the_post(); ?>
            <div class="center-descrip">
                <h2><?php the_title(); ?></h2>
            </div>
            <?php the_content(); ?>
		<?php endwhile; ?>  
        </div>  
        <div class="address-block">
            <?php 
                $adresses = get_field('adress_contacts');
                $adr_count = count($adresses);
                $i = 0;
                while ($i < $adr_count) : ?>
                    <div class="address-item">
                        <h4>Город <?php echo $adresses[$i]['town'];?></h4>
                        <p><?php echo $adresses[$i]['adres'] ?></p>
                        <a href="#map<?php echo $i ?>" class="map-js">Смотреть на карте</a>
                    </div>  
            <?php $i++;endwhile; ?>
            </div>
        </div>

        <div class="center-socies">
            <h4><?php the_field('title_center_conts');?></h4>
            <p><?php the_field('text_center_conts');?></p>
            <div class="socies-links goriz">
                <a href="tel:<?php the_field('phone_link_header', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/phone-icon.png" alt=""></a>
                <?php if (get_field('telegram_link_header','option')) : ?><a href="<?php the_field('telegram_link_header','option');?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/teleg-icon.png" alt=""></a><?php endif; ?>
                <?php if (get_field('whatsapp_link_header','option')) : ?><a href="<?php the_field('whatsapp_link_header','option');?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/wts-icon.png" alt=""></a><?php endif; ?>
                <?php if (get_field('vk_link_header','option')) : ?><a href="<?php the_field('vk_link_header','option');?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/vk-icon.png" alt=""></a><?php endif; ?>
                <?php if (get_field('ok_link_header','option')) : ?><a href="<?php the_field('ok_link_header','option');?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ok-icon.png" alt=""></a><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="maps-section">
    <?php
        $i = 0;
        while ($i < $adr_count) : ?>
            <div class="map-block-wrapper" id="map<?php echo $i;?>">
            <div class="map-block">
                <div class="content">
                    <div class="map-addr">
                        <h4>Контакты</h4>
                        <p>г. <?php echo $adresses[$i]['town'] . ', ' . $adresses[$i]['adres'] ;?></p>
                        <a href="tel:<?php echo $adresses[$i]['telefon'];?>"><?php echo $adresses[$i]['telefon'];?></a>
                        <p><?php echo $adresses[$i]['time_work'];?></p>
                        <p>E-mail: <?php echo $adresses[$i]['email'];?></p>
                        <a href="#callback" class="btn-gold open-js">ОСТАВИТЬ ЗАЯВКУ</a>
                    </div>
                </div>
                <?php echo $adresses[$i]['map-iframe'];?>
            </div>
        </div>
    <?php $i++;endwhile; ?>
    </div>
</section>
<?php
get_footer();
