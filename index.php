<?php 

/**
 * Index Template
 * 
*/

get_header();

if(!is_page()) : 

    get_template_part('lib/templates/blog');

else : 

    get_template_part('lib/blocks/page-builder');

endif;

get_footer(); 

?>