<?php 

/**
 * Functions
 * 
 * This file contains general functions
*/

define('THEME_DIRECTORY', get_template_directory());
define('THEME_NAME', 'boilerplate');


/**
 * Disable the theme editor
 * 
*/
define('DISALLOW_FILE_EDIT', true);


/**
 * Remove version info
 * - make it a bit more difficult for hackers
 * 
*/
function boilerplate_version_removal() {
    return '';
} 
add_filter('the_generator', 'boilerplate_version_removal');


/**
 * Remove info from the headers
 * - remove the stuff thats not needed
 * 
*/
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Excerpt
 * - This theme supports excerpts
 * 
*/
add_post_type_support('page', 'excerpt');

function boilerplate_excerpt_more($more) {
    global $post;
    return '...';
}

function boilerplate_excerpt($limit) {

    $excerpt = explode(' ', get_the_excerpt(), $limit);

    if(count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }

    $excerpt = preg_replace('`\[[^\]]*\`', '', $excerpt);

    return $content;
}


/**
 * Thumbnails
 * - this theme supports thumbnails
 * 
*/
add_theme_support('post-thumbnails');
add_image_size('full', 3000, 3000, true);
add_image_size('logo', 200, 200, true);


/**
 * Scripts & Styles
 * - include the scripts and stylesheets
 * 
*/
add_action('wp_enqueue_scripts', 'script_enqueues');

add_filter('gform_init_scripts_footer', function() {
    return true;
});

function script_enqueues() {

    if(wp_script_is('jquery', 'registered')) {

        wp_deregister_script('jquery');

    }

    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '2.2.4', false);
    wp_enqueue_script('custom', get_template_directory_uri() . '/dist/js/main.min.js', array(), '1.0.0', true);

    wp_enqueue_style('style', get_template_directory_uri() . '/dist/css/style.min.css', false, '1.0.0', 'all');

}


/**
 * Admin Bar
 * - Hide the admin bar
*/
add_filter('show_admin_bar', '__return_false');


/**
 * Menus
 * - Enable WordPress Menus
*/
if(function_exists('register_nav_menus')) {
    register_nav_menus(
        array(
            'header' => __('Main Nav'),
            'footer' => __('Footer Nav'),
        )
    );
}


/**
 * Menu Classes
 * - Add first and last to menu items
*/
function boilerplate_first_and_last_menu_class($items) {

    $items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';

    return $items;

}
add_filter('wp_nav_menu_objects', 'boilerplate_first_and_last_menu_class');


/**
 * Admin Menus
 * - Hide unused menu items
 * 
*/
function remove_menus() {

    remove_menu_page('edit-comments.php');

}
add_action('admin_menu', 'remove_menus');


/**
 * SVG
 * - Enable SVG upload
 * 
*/
function boilerplate_mime_types($mimes) {

    $mimes['svg'] = 'image/svg+xml';

    return $mimes;

}
add_filter('upload_mimes', 'boilerplate_mime_types');


/**
 * Content Area
 * - Remove the content area
 * 
*/
function boilerplate_remove_textarea() {

    remove_post_type_support('page', 'editor');

}
add_action('admin_init', 'boilerplate_remove_textarea');


/**
 * Yoast Breadcrumbs
 * 
*/
function boilerplate_yoast_to_bottom() {
    
    return 'low';

}
add_filter('wpseo_metabox_prio', 'boilerplate_yoast_to_bottom');


/**
 * ACF Options
 * - Register the ACF options
*/

if(function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

}






