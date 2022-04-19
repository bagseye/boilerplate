<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h2>title</h2>
        <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );?>
    </header>
    <div class="entry-content">
        <?php the_content( 'Continue reading... ' . get_the_title() ); ?>
    </div>
</article>