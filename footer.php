</div> <!-- .site-wrapper -->

<?php get_template_part('lib/blocks/toast'); ?>
<?php get_template_part('lib/blocks/cookie'); ?>

<footer>
    <div class="footer--logo">
        <a href="<?php echo home_url('/'); ?>">
            <?php 
            
            $footer_logo = get_field('footer_logo', 'options');

            if(!empty($footer_logo)) :

                echo '<picture>
                        ' . wp_filter_content_tags('<img class="wp-image-' . $footer_logo['ID'] . '" src="' . $footer_logo['sizes']['logo'] . '" alt="' . $footer_logo['alt'] . '" />') . '
                      </picture>';
         
            endif; 
            
            ?>
        </a>
    </div>

    <?php if(have_rows('social_media', 'options')) : ?>
    <div class="footer--socials">
        <?php while(have_rows('social_media', 'options')) : ?>

            <?php 
            
            $linkedin = get_sub_field('linkedin');
            $linkedin_link = $linkedin['link'];

            $twitter = get_sub_field('twitter');
            $twitter_link = $twitter['link'];

            $facebook = get_sub_field('facebook');
            $facebook_link = $facebook['link'];
                
            ?>

            <?php if($linkedin_link) : ?> 
                <a href="<?php echo $linkedin_link; ?>" target="_blank">LinkedIn</a>
            <?php endif; ?>

            <?php if($twitter_link) : ?> 
                <a href="<?php echo $twitter_link; ?>" target="_blank">Twitter</a>
            <?php endif; ?>

            <?php if($facebook_link) : ?> 
                <a href="<?php echo $facebook_link; ?>" target="_blank">Facebook</a>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>