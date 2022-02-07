<?php 

/**
 * Block: Hero Slide
 * 
 * 
*/

?>

<?php if(have_rows('slides')) : ?>
<div class="hero hero__slide splide">
    <div class="splide__track">
        <div class="splide__list">
        <?php while(have_rows('slides')) : the_row(); ?>

            <?php 
            
            $slide_title = get_sub_field('slide_title');
            $slide_img = get_sub_field('slide_image');
            
            ?>
            <div class="splide__slide">
                <div class="hero__media">
                    <picture>
                        <?php echo wp_filter_content_tags('<img class="wp-image-' . $slide_img['ID'] . '" src="' . $slide_img['sizes']['full'] . '" alt="' . $slide_img['alt'] . '" />'); ?>
                    </picture>
                </div>
                <h1><?php echo $slide_title; ?></h1>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
</div>
<?php else : ?>

<?php endif; ?>