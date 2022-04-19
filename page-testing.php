<?php get_header(); ?>

<?php 

// $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// $args = array(
//     'post_type' => 'projects',
//     'post_status' => 'publish',
//     'posts_per_page' => 1,
//     'paged' => $paged,

// );

// $loop = new WP_Query($args);

// if($loop->have_posts()):
//     while($loop->have_posts()) : $loop->the_post();
//         echo boilerplatePaintCard($loop);
//     endwhile;

//     $total_pages = $loop->max_num_pages;

//     if ($total_pages > 1){

//         $current_page = max(1, get_query_var('paged'));

//         echo paginate_links(array(
//             'base' => get_pagenum_link(1) . '%_%',
//             'format' => '/page/%#%',
//             'current' => $current_page,
//             'total' => $total_pages,
//             'prev_text'    => __('« prev'),
//             'next_text'    => __('next »'),
//         ));
//     } 


// endif;


// wp_reset_postdata();

echo do_shortcode('[ajax_posts]'); 

?>

<?php get_footer(); ?>