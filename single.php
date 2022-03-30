<?php 

/**
 * Default Single
 * 
*/

get_header();
// var_dump(getBlocks());

$block_section_names = getBlockSectionNames();

echo '<ul class="testnav">';
foreach($block_section_names as $section_name) {
    $section_as_anchor = str_replace(' ', '', $section_name);
    echo "<li><a href='#{$section_as_anchor}'>{$section_name}</a></li>";
}
echo '</ul>';

get_template_part('lib/templates/post');



// If comments are open or there is at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
}

get_footer();

?>