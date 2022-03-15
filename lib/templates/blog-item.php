<?php 
                
$cats = get_the_category();

$post_type = get_post_type();

?>

<div class="blogitem">
    <?php if($cats) : ?>
        <?php foreach($cats as $cat) : ?>
            <span><?php echo $cat->name; ?></span>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="<?php echo get_the_permalink(get_the_ID()); ?>">
        <div class="blogitem__media">
            <?php
            $blog_item_thumbnail = has_post_thumbnail();

            if($blog_item_thumbnail) {
                $blog_item_thumbnail_id = get_post_thumbnail_id();
                $blog_item_thumbnail_url = get_the_post_thumbnail_url();
                $blog_item_thumbnail_alt = get_post_meta($blog_item_thumbnail_id, '_wp_attachment_image_alt', true);

                $media_markup = '<picture>
                                    ' . wp_filter_content_tags('<img class="wp-image-' . $blog_item_thumbnail_id . '" src="' . $blog_item_thumbnail_url . '" alt="' . $blog_item_thumbnail_alt . '" />') . '
                                </picture>';

            } else {
                $blog_item_placeholder = get_field('blog_item_placeholder', 'options');

                $media_markup = '<picture>
                                    ' . wp_filter_content_tags('<img class="wp-image-' . $blog_item_placeholder['ID'] . '" src="' . $blog_item_placeholder['sizes']['logo'] . '" alt="' . $blog_item_placeholder['alt'] . '" />') . '
                                </picture>';
            } 
            ?>
        </div>

        <?php var_dump($blog_item_thumbnail) ?>
        
        <div class="blogitem__content">
            <?php echo $blog_item_thumbnail ?>
            <h2><?php echo get_the_title(); ?></h2>
            <p><?php echo wp_trim_words(get_the_excerpt(), 16) ?></p>
            <span>Read More</span>
        </div>
    </a>
</div>