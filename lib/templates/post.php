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

    <div class="post--share">
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false">Share on Facebook</a>
        <a href="http://twitter.com/share?text=Currently reading <?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" title="Click to share this post on Twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Share on Twitter</a>
        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php the_title(); ?>&summary=&source=<?php bloginfo('name'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Share on Linkedin</a>
    </div>
</section>