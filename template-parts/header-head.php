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