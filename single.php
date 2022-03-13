<?php 

/**
 * Default Single
 * 
*/

get_header();

get_template_part('lib/templates/post');

// If comments are open or there is at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
}

get_footer();

?>