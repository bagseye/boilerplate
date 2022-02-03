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

    <?php get_template_part('lib/blocks/authorblock'); ?>

    <?php 
    
    $cats = get_the_category();
    $tags = get_the_tags();

    ?>



    <?php if($cats) : $cats_count = count($cats); ?>
    <div class="categories">
        <?php foreach($cats as $cat) : ?>
            <span><a href="<?php echo get_category_link($cat->term_id) ?>"><?php echo $cat->name ?></a></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php 
    
    if($tags) : 
        $i = 1;
        $tags_count = count($tags);

    ?>
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

    <?php get_template_part('lib/blocks/shareblock'); ?>

</section>