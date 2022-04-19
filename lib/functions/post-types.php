<?php 

/**
 * Create Testimonials Post Type
 * 
*/
function boilerplate_testimonials_post_type() {

    $labels = array(
        'name' => __('Testimonials'),
        'singular_name' => __('Testimonial'),
        'all_items' => __('All Testimonials'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New'),
        'edit_item' => __('Edit'),
        'new_item' => __('New'),
        'view_item' => __('View'),
        'search_items' => __('Search'),
        'not_found' => __('No Testimonials Found'),
        'not_found_in_trash' => __('No Testimonials Found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
        'publicly_queryable' => true,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => true,  // you should exclude it from search results
        'show_in_nav_menus' => true,  // you shouldn't be able to add it to menus
        'has_archive' => false,  // it shouldn't have archive page
        'rewrite' => false,  // it shouldn't have rewrite rules
        'menu_icon' => 'dashicons-format-quote',
        'menu_position' => 21,
        'hierarchical' => false,
        'supports' => array('title', 'excerpt')
    );
    register_post_type('testimonial', $args);
}
add_action('init', 'boilerplate_testimonials_post_type');


function boilerplate_projects_post_type() {

    $labels = array(
        'name' => __('Projects'),
        'singular_name' => __('Project'),
        'all_items' => __('All Projects'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New'),
        'edit_item' => __('Edit'),
        'new_item' => __('New'),
        'view_item' => __('View'),
        'search_items' => __('Search'),
        'not_found' => __('No Testimonials Found'),
        'not_found_in_trash' => __('No Projects Found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,  // it's not public, it shouldn't have it's own permalink, and so on
        'publicly_queryable' => true,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => true,  // you should exclude it from search results
        'show_in_nav_menus' => true,  // you shouldn't be able to add it to menus
        'has_archive' => false,  // it shouldn't have archive page
        'rewrite' => false,  // it shouldn't have rewrite rules
        'menu_icon' => 'dashicons-format-quote',
        'menu_position' => 22,
        'hierarchical' => false,
        'supports' => array('title', 'excerpt')
    );
    register_post_type('projects', $args);
}
add_action('init', 'boilerplate_projects_post_type');