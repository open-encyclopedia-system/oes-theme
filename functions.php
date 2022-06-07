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

    wp_register_script('oes-search',
        get_template_directory_uri() . '/assets/js/oes-search.js',
        ['jquery'],
        false,
        true);
    wp_localize_script(
        'oes-search',
        'oesSearchAJAX',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('oes_search_nonce')
        ]
    );
    wp_enqueue_script('oes-search');
}


/* redirect templates */
add_action('template_redirect', 'oes_theme_action_template_redirect');

/**
 * Redirect templates
 */
function oes_theme_action_template_redirect()
{

    /* get global parameter */
    global $oes, $oes_language, $taxonomy;
    $oes_language = sizeof($oes->languages) < 2 ? 'all' : $oes->main_language;

    /* get current link*/
    $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $switch = $_GET['oes-language-switch'] ?? false;


    /**
     * Fires before theme redirection.
     *
     * @param string $currentURL The current url.
     * @param string $oes_language The current language.
     * @param bool $switch The language switch.
     */
    do_action('oes/theme_redirect_index', $currentURL, $oes_language, $switch);


    /* redirect single for post types where archive are displayed as full list */
    if (!is_admin()) {

        /* check if page switch */
        if ($switch && is_page()) {

            /* check for translations */
            global $post;
            $translations = \OES\ACF\oes_get_field('field_oes_page_translations', $post->ID);
            if (!empty($translations))
                foreach ($translations as $translationID) {
                    $pageLanguage = oes_get_post_language($translationID);
                    if ($pageLanguage && $pageLanguage === $switch) {
                        if (is_front_page()) {
                            global $post;
                            $post = get_post($translationID);
                        } else wp_safe_redirect(get_permalink($translationID));
                    }
                }
        } elseif (is_single() && $oes->post_types) {

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

            global $oes_additional_objects, $oes_is_index, $oes_is_index_page;
            if ($oes_additional_objects = $oes->theme_index['objects'] ?? false) {
                $oes_is_index = true;
                $oes_is_index_page = true;
                if (locate_template('archive.php', true)) exit();
            }

        } elseif ($oes->taxonomies) {
            foreach ($oes->taxonomies as $taxonomyKey => $singleTaxonomy) {

                /* add action for taxonomy single pages */
                if (has_action('oes/theme_redirect_taxonomy'))
                    do_action('oes/theme_redirect_taxonomy', $taxonomyKey, $singleTaxonomy, $currentURL);

                /* Archive pages */
                if (isset($singleTaxonomy['rewrite']['slug']) &&
                    $currentURL === get_site_url() . '/' . $singleTaxonomy['rewrite']['slug'] . '/' &&
                    !is_page($singleTaxonomy['rewrite']['slug'])) {

                    global $oes_additional_objects, $oes_is_index;
                    if ($oes_additional_objects = [$taxonomyKey]) {
                        $oes_is_index = true;
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
        global $oes_language, $oes;
        $consideredLanguage = $oes_language === 'all' ? 'language0' : $oes_language;
        return $items .
            oes_theme_add_search_to_navigation($oes->theme_labels['search__navigation__label'][$consideredLanguage] ?? 'SEARCH');
    }
    return $items;
}


/**
 * Display the loading spinner
 */
function oes_theme_loading_spinner()
{
    echo '<div class="oes-loading-spinner-wrapper">' .
        '<div class="oes-loading-spinner-wrapper"></div>' .
        '<div id="oes-loading-spinner">' .
        '<div class="oes-loading-spinner-bar1"></div>' .
        '<div class="oes-loading-spinner-bar2"></div>' .
        '<div class="oes-loading-spinner-bar3"></div>' .
        '<div class="oes-loading-spinner-bar4"></div>' .
        '<div class="oes-loading-spinner-bar5"></div>' .
        '</div>' .
        '</div>';
}


/* fetch search result after page is loaded */
add_action('wp_ajax_oes_fetch_search_result_data', 'oes_fetch_search_result_data');
add_action('wp_ajax_nopriv_oes_fetch_search_result_data', 'oes_fetch_search_result_data');

/**
 * Fetch search result data
 */
function oes_fetch_search_result_data()
{
    get_template_part('template-parts/search', 'content');
    die();
}

