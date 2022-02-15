<?php 

/**
 * Default Archive
 * 
*/

get_header();

$description = get_the_archive_description();
the_archive_title('<h1>', '</h1>');

get_template_part('lib/templates/blog');

get_footer();

?>