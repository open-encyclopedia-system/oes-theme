<?php

/* setup theme by adding actions and filters */
add_action('after_setup_theme', 'oes_theme_action_after_setup_theme');

/**
 * Set up the OES theme.
 */
function oes_theme_action_after_setup_theme()
{

    /* Widgets */
    add_theme_support('widgets');

    /* Enable styling for editor (block css) */
    add_theme_support('editor-styles');
    add_editor_style(get_template_directory_uri() . '/assets/css/oes-editor.css');

    /* Register menus */
    register_nav_menus([
        'oes-header-menu' => 'OES Top',
        'oes-footer-menu' => 'OES Footer',
        'oes-logo-menu' => 'OES Logo'
    ]);
    add_theme_support('menu');

    /* Add fav icon for pages */
    if (function_exists('oes_theme_add_favicon'))
        oes_theme_add_favicon(get_template_directory_uri() . '/assets/images/favicon.ico');

    /* Modify WordPress search to use OES Feature "Search" */
    if (function_exists('oes_theme_modify_search')) oes_theme_modify_search();

    /* Modify gnd display */
    if (function_exists('oes_theme_gnd_display_modified_table')) oes_theme_gnd_display_modified_table();
}


/* load styles and scripts */
add_action('wp_enqueue_scripts', 'oes_theme_action_enqueue_scripts');

/**
 * Load styles and scripts.
 */
function oes_theme_action_enqueue_scripts()
{

    /* enqueue styles */
    wp_register_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', []);
    wp_enqueue_style('font-awesome');

    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', []);
    wp_enqueue_style('bootstrap');

    wp_enqueue_style('oes-style', get_stylesheet_uri(), []);

    /* enqueue scripts */
    wp_enqueue_script('jquery');
    wp_register_script('oes-jquery',
        get_template_directory_uri() . '/assets/js/jquery.min.js');
    wp_enqueue_script('oes-jquery');

    wp_register_script('bootstrap',
        get_template_directory_uri() . '/assets/js/bootstrap.min.js',
        ['jquery'],
        false,
        true);
    wp_enqueue_script('bootstrap');

    wp_register_script('oes',
        get_template_directory_uri() . '/assets/js/oes.js',
        ['jquery'],
        false,
        true);
    wp_enqueue_script('oes');

    wp_register_script('oes-filter',
        get_template_directory_uri() . '/assets/js/oes-filter.js',
        ['jquery'],
        false,
        true);
    wp_enqueue_script('oes-filter');
}


/* redirect templates */
add_action('template_redirect', 'oes_theme_action_template_redirect');

/**
 * Redirect templates
 */
function oes_theme_action_template_redirect()
{

    /* get global parameter */
    global $oes, $language, $taxonomy;
    $language = $oes->main_language;

    /* get current link*/
    $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    /* redirect single for post types where archive are displayed as full list */
    if (!is_admin()) {
        if (is_single() && $oes->post_types) {

            /* check if archive is "flat" */
            global $post;
            if (isset($oes->post_types[$post->post_type]['archive_on_single_page']) &&
                $oes->post_types[$post->post_type]['archive_on_single_page']) {
                wp_safe_redirect(
                    get_post_type_archive_link($post->post_type) . '#' . $post->post_type . '-' . $post->ID);
                die();
            }
        } /* redirect to index page */
        elseif ($currentURL === get_site_url() . '/' . ($oes->theme_index['slug'] ?? 'index') . '/') {

            global $oes_additional_objects, $is_index;
            if ($oes_additional_objects = $oes->theme_index['objects'] ?? false) {
                $is_index = true;
                if (locate_template('archive.php', true)) exit();
            }

        } elseif ($oes->taxonomies) {
            foreach ($oes->taxonomies as $taxonomyKey => $singleTaxonomy){

                /* add action for taxonomy single pages */
                if(has_action('oes/theme_redirect_taxonomy'))
                    do_action('oes/theme_redirect_taxonomy', $taxonomy);

                /* Archive pages */
                if (isset($singleTaxonomy['rewrite']['slug']) &&
                    $currentURL === get_site_url() . '/' . $singleTaxonomy['rewrite']['slug'] . '/') {

                    global $oes_additional_objects, $is_index;
                    if ($oes_additional_objects = [$taxonomyKey]) {
                        $is_index = true;
                        if (locate_template('archive.php', true)) exit();
                    }
                }
            }
        }
    }
}


/* modify top navigation (add search) */
add_action('wp_nav_menu_items', 'oes_theme_action_wp_nav_menu_items', 10, 2);

/**
 * Add search to top navigation menu at end
 *
 * @param string $items The HTML list content for the menu items.
 * @param stdClass $menu n object containing wp_nav_menu() arguments.
 * @return string Return the modified HTML list content.
 */
function oes_theme_action_wp_nav_menu_items(string $items, stdClass $menu): string
{
    if ($menu->theme_location == 'oes-header-menu') {
        global $language, $oes;
        return $items .
            oes_theme_add_search_to_navigation($oes->theme_labels['search__navigation__label'][$language] ?? '');
    }
    return $items;
}