<?php 

/**
 * Block: Page Builder
 * 
*/

if(have_rows('page_builder')) :
    while (have_rows('page_builder')) : the_row();

        if(get_row_layout() == 'hero') :
            
            get_template_part('lib/blocks/hero');

        endif;

    endwhile;

else : 

    get_template_part('lib/blocks/no-content');

endif;

?>