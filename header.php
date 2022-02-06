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

    <div class="masthead__nav">
        <?php 

        get_template_part('lib/templates/nav');

        ?>
    </div>

    <div class="masthead__Search">
        <?php get_search_form(); ?>
    </div>
</header>

<div class="overlay"></div>
<div class="site-wrapper" data-aos="fade">
    <?php get_template_part('lib/blocks/hero-slide'); ?>