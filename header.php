<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<header class="masthead">
    <div class="masthead--logo">
        <a href="<?php echo home_url('/'); ?>" class="masthead__logo--link">
            <?php 
            
            $header_logo = get_field('header_logo', 'options');

            if(!empty($header_logo)) :

                echo '<picture>
                        ' . wp_filter_content_tags('<img class="wp-image-' . $header_logo['ID'] . '" src="' . $header_logo['sizes']['logo'] . '" alt="' . $header_logo['alt'] . '" />') . '
                      </picture>';
         
            endif; 
            
            ?>
        </a>
    </div>

	<!-- <nav id="site-navigation" class="primary-navigation" aria-label="<?php// esc_attr_e( 'Primary menu', THEME_NAME ); ?>">
        <button id="primary-mobile-menu" class="burger" type="button" aria-expanded="false" aria-label="Toggle Navigation">
            <span></span>
            <span></span>
            <span></span>
        </button> -->
		<?php
		// wp_nav_menu(
		// 	array(
		// 		'theme_location'  => 'primary',
		// 		'menu_class'      => 'menu-wrapper',
		// 		'container_class' => 'primary-menu-container',
		// 		'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
		// 		'fallback_cb'     => false,
		// 	)
		// );
		?>
	<!-- </nav> -->

    <div class="masthead__nav">
        <nav>
        <?php get_template_part('lib/templates/nav'); ?>
        </nav>
        <button class="burger" type="button" aria-expanded="false" aria-label="Toggle Navigation">
            <p class="sr__only">Menu</p>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="masthead__Search">
        <?php get_search_form(); ?>
    </div>
</header>

<div class="overlay"></div>
<div class="site-wrapper">
    <?php get_template_part('lib/blocks/hero-slide'); ?>
    <?php get_template_part('lib/blocks/hero-video'); ?>