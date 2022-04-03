<?php 

/**
 * Front Page Template
 * 
*/

get_header();

// if(!is_page()) : 

//     get_template_part('lib/templates/blog');

// else : 

//     get_template_part('lib/blocks/page-builder');

// endif;
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
		the_post();
        the_content();

		//get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
	}

}

get_footer(); 

?>