<?php 

/**
 * Block: Author
 * 
*/

global $post;

$post_ID = $post->ID;
$author_id = $post->post_author;
$author_id = get_the_author_meta('ID', $author_id);
$author_name = get_the_author_meta('display_name', $author_id);
$author_description = get_the_author_meta('description', $author_id);

?>


<div class="authorblock">
    <div class="authorblock__container">
        <div class="authorblock__media">
            <?php echo get_avatar($author_avatar, 160); ?>
        </div>
        
        <?php if(!empty($author_name) || !empty($author_description)) : ?>
        <div class="authorblock__content">
            <p><?php echo esc_attr($author_name); ?></p>
            <p><?php echo esc_attr($author_description); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>