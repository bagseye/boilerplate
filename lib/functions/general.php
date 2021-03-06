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

    global $wp_query;

    wp_enqueue_script('jquery');
    wp_enqueue_script('vendor', get_template_directory_uri() . '/dist/js/vendor.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('custom', get_template_directory_uri() . '/dist/js/main.min.js', array('vendor'), '1.0.0', true);

    // AJAX LOADMORE
    // register the main script but do not enqueue it yet
    wp_register_script( 'boilerplate_loadmore', get_stylesheet_directory_uri() . '/loadmore.js', array('jquery') );

    // 	// Main navigation scripts.
	// if ( has_nav_menu( 'primary' ) ) {
	// 	wp_enqueue_script(
	// 		'twenty-twenty-one-primary-navigation-script',
	// 		get_template_directory_uri() . '/assets/js/primary-navigation.js',
	// 		array( 'twenty-twenty-one-ie11-polyfills' ),
	// 		wp_get_theme()->get( 'Version' ),
	// 		true
	// 	);
	// }

    wp_enqueue_style('style-vendor', get_template_directory_uri() . '/dist/css/vendor.min.css', false, '1.0.0', 'all');
    wp_enqueue_style('style', get_template_directory_uri() . '/dist/css/style.min.css', false, '1.0.0', 'all');

    // AJAX LOADMORE
    // we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
    // you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
    wp_localize_script('custom', 'boilerplate_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'posts' => json_encode( $wp_query->query_vars ), // AJAX LOADMORE - Everything about the loop is here
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1, // AJAX LOADMORE
        'max_page' => $wp_query->max_num_pages, // AJAX LOADMORE
        'stylesheet_dir' => get_stylesheet_directory_uri(),
        'security' => wp_create_nonce('view_post'),
    ));

    if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
        wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
    }

    // AJAX LOADMORE
    // Now enque the script
    wp_enqueue_script('boilerplate_loadmore');
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
// function boilerplate_remove_textarea() {

//     remove_post_type_support('page', 'editor');

// }
// add_action('admin_init', 'boilerplate_remove_textarea');


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

    acf_add_options_page(array(
        'page_title' => 'Testimonials',
        'menu_title' => 'Testimonials',
        'menu_slug' => 'testimonials',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

}


function boilerplate_acf_blocks_init() {
    
    // Check function exists.
    if( function_exists('acf_register_block_type') ) {
        
        // Register a video block.
        acf_register_block_type(array(
            'name'              => 'video',
            'title'             => __('Video'),
            'description'       => __('A custom video block.'),
            'render_template'   => 'lib/blocks/video.php',
            'category'          => 'formatting',
            'mode'              => 'edit',
            'supports'          => array(
                'anchor'    => true,
                'align'     => false,
            )
        ));
    }
}
add_action('acf/init', 'boilerplate_acf_blocks_init');





// CLICK COUNTER
function my_increment_counter() {
    // Name of the option 
    $option_name = 'my_click_counter';
    // Check if the option is set already 
    if(get_option($option_name) !== false) {
        $new_value = intval(get_option($option_name)) + 1;
        // The option already exisits so update it 
        update_option($option_name, $new_value);
    } else {
        // The option hasnt been created yet, so add it with $autoload set to 'no'
        $deprecated = null;
        $autoload = 'no';
        add_option($option_name, 1, $deprecated, $autoload);
    }
}

add_action('wp_ajax_increment_counter', 'my_increment_counter');
add_action('wp_ajax_nopriv_increment_counter', 'my_increment_counter');


// POST MODAL 
function load_post_by_ajax_callback() {
    check_ajax_referer('view_post', 'security');
    $args = array(
        'post_type' => 'post',
        'p' => $_POST['id'],
    );

    $posts = new WP_Query($args);

    $arr_response = array();
    if($posts->have_posts()) {
        while($posts->have_posts()) {
            $posts->the_post();

            $arr_response = array(
                'title' => get_the_title(),
                'content' => get_the_content()
            );
        }
        wp_reset_postdata();
    }

    echo json_encode($arr_response);

    wp_die();
}
add_action('wp_ajax_load_post_by_ajax', 'load_post_by_ajax_callback');
add_action('wp_ajax_nopriv_load_post_by_ajax', 'load_post_by_ajax_callback');



function boilerplate_format_comment($comment, $args, $depth) {
 
    $GLOBALS['comment'] = $comment; ?>
    
    <li id="li-comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comments__item">
            
            <div class="comments__item--media">
                <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, '160' ); ?>
            </div>
 
            <div class="comments__item--content">

                <div class="comments__item--title">
                    <?php 
                    /* translators: %s: comment author link */
                    printf( __('<h3>%s</h3>'), get_comment_author_link( $comment ) );
                    ?>
                    <div class="comments__item--date">
                        <time datetime="<?php comment_time( 'c' ) ?>">
                            <?php
                                /* translators: 1: comment time, 2: comment date */
                                printf( __( 'Posted at %1$s, %2$s' ), get_comment_time(), get_comment_date( 'd F', $comment ) );
                            ?>
                        </time>
                    </div>
                </div>

                <div class="comments__item--comment">
                    <?php comment_text(); ?>
                </div>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                <div class="comments__moderation--await">
                    <p><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                </div>
                <?php endif; ?>

                <div class="comments__item--conversation">
                    <?php
                    if (get_comment_type() == 'comment') {
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<div class="comments__item--reply">',
                            'after'     => '</div>'
                        ) ) );
                    }
                    ?>
    
                    <?php edit_comment_link( __( 'Edit' ), '<div class="comments__item--edit">', '</div>' ); ?>
                </div>

            </div>            
        </article>
         
<?php }  // function format_comment()


// AJAX LOADMORE
function boilerplate_loadmore_ajax_handler() {

    // Prepare the arguments for the query 
    $args = json_decode(stripslashes($_POST['query']), true);
    $args['paged'] = $_POST['page'] + 1; // need the next page to loaded 
    $args['post_status'] = 'publish';

    query_posts($args);

    if(have_posts()) :

        while(have_posts() ) : the_post();

            get_template_part('lib/templates/blog-item');

        endwhile;

    endif;
    die;
}

add_action('wp_ajax_loadmore', 'boilerplate_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'boilerplate_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}



/* Comment form validation */
function comment_validation_init() {
    if(is_single() && comments_open() ) { ?>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#commentform").validate({
                rules: {
                author: {
                    required: true,
                    minlength: 2,
                },
                email: {
                    required: true,
                    email: true,
                },
                comment: {
                    required: true,
                    minlength: 20,
                },
                },

                messages: {
                    author: "Please provide a name",
                    email: "Please enter a valid email address",
                    comment: "Please fill the required field",
                },

                errorElement: "div",
                errorPlacement: function (error, element) {
                element.after(error);
                },
            });
        });
        </script>
        <?php

    }
}
add_action('wp_footer', 'comment_validation_init');


// Get the section names of blocks
// For use in generating sub menu of sections on the current page
function getBlockSectionNames() {
    global $post;
    
    $blocks = parse_blocks($post->post_content);

    $section_names = array();

    foreach($blocks as $block) {
        $section_name = $block['attrs']['data']['section_name'];

        if($section_name != null) {
            $section_names[] = $section_name;
        }
    }

    return $section_names;
}


/**
* Allow the following blocks in the editor
*
*/
add_filter( 'allowed_block_types', 'boilerplate_block_types', 10, 2 );

function boilerplate_block_types( $allowed_blocks ) {
    return array(
        'core/paragraph',
        'core/heading',
        'core/buttons',
        'core/button',
        'core/list',
        'core/image',
        'core/table',
        'core/block',
        'core/gallery',
        'core/spacer',
        'core/embed',
        'core-embed/youtube',
        'core/html',
        'acf/video',
    );
}




function boilerplatePaintCard($post) {

    $post_id = get_the_ID();

    $html = $title = $link = null;
    $title = get_the_title($post_id);
    $link = get_the_permalink($post_id);

    $html = '<div class="card">
                <a href="' . $link . '">
                    ' . $title . '
                </a>
            </div>';

    return $html;
}



// Infinite Scroll
function script_load_more($args = array()) {
    // Initial posts load 
    echo '<div id="ajax-primary" class="content-area">';
        echo '<div id="ajax-content" class="content-area">';
            ajax_script_load_more($args);
        echo '</div>';
        echo '<a href="#" id="loadMore" data-page="1" data-url="' . admin_url("admin-ajax.php") . '">Loading</a>';
    echo '</div>';
}

// Create shortcode 
add_shortcode('ajax_posts', 'script_load_more');

// Loadmore script callback
function ajax_script_load_more($args) {
    // init ajax 
    $ajax = false;
    // Check ajax call or not 
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $ajax = true;
    }

    // Number of posts per page default
    $num = 2;
    // Page number
    $paged = $_POST['page'] + 1;
    // args 
    $args = array(
        'post_type' => 'projects',
        'post_status' => 'publish',
        'posts_per_page' => $num,
        'paged' => $paged
    );
    // Query 
    $query = new WP_Query($args);
    // Check 
    if($query->have_posts()) :
        // Loop articles 
        while($query->have_posts()) : $query->the_post();
            // Include articles template
            include get_template_directory() . '/lib/templates/ajax-content.php';
        endwhile;
    else : 
        echo 0;
    endif;

    // Reset post data 
    wp_reset_postdata();
    // Check ajax call 
    if($ajax) die();

}

// Load more script ajax hooks 
add_action('wp_ajax_nopriv_ajax_script_load_more', 'ajax_script_load_more');
add_action('wp_ajax_ajax_script_load_more', 'ajax_script_load_more');

/*
 * enqueue js script
 */
add_action( 'wp_enqueue_scripts', 'ajax_enqueue_script' );
/*
 * enqueue js script call back
 */
function ajax_enqueue_script() {
    wp_enqueue_script( 'script_ajax', get_theme_file_uri( 'script_ajax.js' ), array( 'jquery' ), '1.0', true );
}