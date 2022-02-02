<?php 

/**
 * Post
 * 
*/

?>

<section class="post">
    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Back to posts</a>
    <h1><?php echo get_the_title(); ?></h1>
    <h3><?php echo get_the_date('d M Y'); ?></h3>

    <?php 
    
    $cats = get_the_category();
    $cats_count = count($cats);

    $tags = get_the_tags();
    $tags_count = count($tags);

    ?>

    <?php if($cats) : ?>
    <div class="categories">
        <?php foreach($cats as $cat) : ?>
            <span><?php echo $cat->name ?></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($tags) : $i = 1; ?>
    <div class="tags">
        <?php foreach($tags as $tag) : ?>
            <?php $tag_link = get_tag_link($tag->term_id); ?>
            <a href="<?php echo $tag_link; ?>"><?php echo $tag->name; ?></a>
        <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="post--content">
        <?php the_content(); ?>
    </div>

    <?php get_template_block('lib/blocks/shareblock'); ?>
    
</section>