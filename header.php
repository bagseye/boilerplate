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
            <?php $site_logo = get_field('site_logo', 'options'); ?>
            <?php if(!empty($site_logo)) : ?>
                <img src="<?php echo $site_logo['url'] ?>" alt="<?php $site_logo['alt'] ?>">
            <?php endif; ?>
        </a>
    </div>

    <div class="masthead__nav">
        <?php 
        
        wp_nav_menu(
            array(
                'theme_location' => 'header',
                'container' => 'false'
            )
        );

        ?>
    </div>

    <div class="masthead__Search">
        <?php get_search_form(); ?>
    </div>
</header>

<div class="overlay"></div>
<div class="site-wrapper">