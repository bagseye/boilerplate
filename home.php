<?php 

global $wp_query;

/**
 * Default Home
 * 
*/

get_header();

get_template_part('lib/templates/blog');

if($wp_query->max_num_pages > 1) {
    echo '<div class="loadmore">More posts</div>';
}

get_footer();

?>