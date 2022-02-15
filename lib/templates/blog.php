<?php 

/**
 * Template: Blog
 * 
*/

$categories = get_categories();

$current_page = get_query_var('cat');

?>

<?php get_template_part('lib/blocks/filter'); ?>

<section class="blog-posts <?php if(!have_posts()) : ?>blog-posts--no-posts<?php endif; ?>">
    <div class="blog-posts__container">

        <?php if(have_posts()) : $i = 0; ?>

            <div class="blog-posts__posts">
                <?php while (have_posts()) : the_post(); ?>

                <?php 
                
                $cats = get_the_category();

                $post_type = get_post_type();
                
                ?>

                <div class="blog-posts__post-wrapper<?php if($i === 0) : ?>blog-posts__post-wrapper--first<?php endif; ?>">
                    <div class="blog-posts__post">
                        <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
                            <?php if($cats) : ?>
                                <?php foreach($cats as $cat) : ?>
                                    <span><?php echo $cat->name; ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <h2><?php echo get_the_title(); ?></h2>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 16) ?></p>
                        </a>
                    </div>

                </div>
            </div>

            <?php $i++;
            endwhile; ?>

            <?php if(paginate_links()) : ?>
            <div class="blog-posts__paginate-links">
                <p><?php echo paginate_links(); ?></p>
            </div>
            <?php endif; ?>

        <?php else : ?>

            <h1 class="blog-posts__no-posts"><?php _e('No pages or posts found, please try another search term', 'boilerplate'); ?></h1>

        <?php wp_reset_query(); ?>

        <?php endif; ?>

    </div>
</section>