<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width">
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php
    $appleIcon = get_option('oes_theme-favicon_apple');
    echo(!empty($appleIcon) ?
        $appleIcon :
        get_template_directory_uri() . '/assets/images/apple-touch-icon.ico'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php
    $icon32 = get_option('oes_theme-favicon_32_32');
    echo(!empty($icon32) ?
        $icon32 :
        get_template_directory_uri() . '/assets/images/favicon-32x32.ico'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php
    $icon16 = get_option('oes_theme-favicon_16_16');
    echo(!empty($icon16) ?
        $icon16 :
        get_template_directory_uri() . '/assets/images/favicon-16x16.ico'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php
    $icon = get_option('oes_theme-favicon');
    echo(!empty($icon) ?
        $icon :
        get_template_directory_uri() . '/assets/images/favicon.ico'); ?>">
    <title><?php echo $args['head-text'] ?? wp_get_document_title(); ?></title><?php

    wp_head();

    /* prepare theme colors */
    if ($colorsJSON = get_option('oes_theme-colors')) :
        if ($colors = json_decode($colorsJSON, true)):
            if (!empty($colors)):

                $colorsSTYLE = '';
                foreach ($colors as $colorID => $hex) $colorsSTYLE .= $colorID . ': ' . $hex . ';';

                if (!empty($colorsSTYLE)):?>
                    <style type="text/css" id="oes-colors">
                    :root {
                    <?php echo $colorsSTYLE; ?>
                    }
                    </style><?php
                endif;
            endif;
        endif;
    endif;
    ?>
</head>
<body <?php

global $oes, $oes_nav_language;

$homeURL = '';
if($oes_nav_language != $oes->main_language)
    $homeURL = strtolower($oes->languages[$oes_nav_language]['abb'] ?? '');

$homeLogo = get_option('oes_theme-header_logo');
$homeLogoSrc = (!empty($homeLogo) ?
    $homeLogo :
    get_stylesheet_directory_uri() . '/assets/images/oes-home-logo.png');

body_class(['oes-body-' . $oes_nav_language]); ?>>
<div class="oes-body-wrapper">
    <header class="fixed-top d-print-none">
        <nav class="container navbar navbar-expand-lg navbar-light">
            <a href="<?php echo home_url($homeURL); ?>" class="navbar-brand">
                <picture><img src="<?php echo $homeLogoSrc; ?>" alt="Logo" class="oes-home-img"></picture>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#oes-top-menus"
                    aria-controls="oes-top-menus" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="oes-top-menus">
                <div class="oes-top-menu-container">
                    <div id="oes-utility-nav"><?php

                        if (has_nav_menu('oes-utility-menu-' . $oes_nav_language))
                            wp_nav_menu([
                                'theme_location' => 'oes-utility-menu-' . $oes_nav_language,
                                'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                            ]);

                        ?>
                    </div>
                    <div id="oes-main-nav"><?php

                        if (has_nav_menu('oes-header-menu-' . $oes_nav_language))
                            wp_nav_menu([
                                'theme_location' => 'oes-header-menu-' . $oes_nav_language,
                                'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                            ]);

                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="d-none d-print-block">
        <picture><img src="<?php echo $homeLogoSrc; ?>" alt="Logo" class="oes-home-img"></picture>
    </div>
    <div id="oes-search-panel" <?php if (isset($args['show-search']) && $args['show-search']) echo 'style="display:block;"'; ?>>
        <div class="oes-search-panel-background"></div>
        <div class="oes-search-panel-front">
            <div class="oes-search-panel-form container text-center">
                <h1><?php

                    if (isset($args['search-text']) && $args['search-text']) echo $args['search-text'];
                    else echo($oes->theme_labels['search__navigation__text'][$oes_nav_language] ??
                        __('Search the OES Encyclopedia', 'oes'));

                    ?>
                </h1>
                <div><?php get_search_form(); ?></div>
            </div>
        </div>
    </div>