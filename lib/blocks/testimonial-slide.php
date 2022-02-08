
<?php if(have_rows('testimonial', 'options')) : ?>
<section class="testimonial splide">
    <div class="splide__track">
        <div class="splide__list">
            <?php while(have_rows('testimonial', 'options')) : the_row(); ?>

            <?php 
            
            $testimonial_message = get_sub_field('message');
            $testimonial_name = get_sub_field('name');
            
            ?>
            <div class="splide__slide">
                <blockquote>
                    <?php echo $testimonial_message; ?>
                </blockquote>
                <cite><?php echo $testimonial_name; ?></cite>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>