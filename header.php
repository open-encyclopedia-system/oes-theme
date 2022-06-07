<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon-32x32.ico">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico">
    <title><?php echo $args['head-text'] ?? wp_get_document_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="fixed-top">
    <nav class="container navbar navbar-expand-lg navbar-light">
        <a href="<?php echo home_url(); ?>" class="navbar-brand">
            <picture>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/oes-demo_logo_large.png"
                     alt="Logo"
                     class="oes-home-img">
            </picture>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#oes-main-nav" aria-controls="oes-main-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="oes-main-nav"><?php
            wp_nav_menu([
                'theme_location' => 'oes-header-menu',
                'container' => false,
                'menu_class' => 'navbar-nav ml-auto mt-lg-0'
            ]);
            ?>
        </div>
    </nav>
</header>
<div id="oes-header-padding"></div>
<div id="oes-search-panel" <?php if (isset($args['show-search']) && $args['show-search']) echo 'style="display:block;"'; ?>>
    <div class="oes-search-panel-background"></div>
    <div class="oes-search-panel-front">
        <div class="oes-search-panel-form container text-center">
            <h1><?php

                /* get global parameters and OES instance parameter*/
                global $oes_language, $oes;

                if(isset($args['search-text']) && $args['search-text']) echo $args['search-text'];
                else echo ($oes->theme_labels['search__navigation__text'][$oes_language] ??
                    __('Search the OES Encyclopedia', 'oes'));?></h1>
            <div><?php get_search_form(); ?></div>
        </div>
    </div>
</div>