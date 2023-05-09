<?php

/* activate theme features */
add_action('after_setup_theme', 'oes_theme_action_after_setup_theme');
add_filter('init', 'oes_theme_set_language_cookie', 999);
add_action('wp_enqueue_scripts', 'oes_theme_action_enqueue_scripts');
add_action('widgets_init', 'oes_widget_init');

/* prepare theme labels */
add_filter('oes/prepare_theme_labels_oes_config', 'oes_theme_labels_oes_config');
add_filter('oes/prepare_theme_labels_taxonomy', 'oes_theme_labels_object', 10, 2);
add_filter('oes/prepare_theme_labels_post', 'oes_theme_labels_object', 10, 2);

/* fetch search result after page is loaded */
add_action('wp_ajax_oes_fetch_search_result_data', 'oes_fetch_search_result_data');
add_action('wp_ajax_nopriv_oes_fetch_search_result_data', 'oes_fetch_search_result_data');


/**
 * Set up the OES theme.
 * @return void
 */
function oes_theme_action_after_setup_theme(): void
{

    /* Widgets */
    add_theme_support('widgets');


    /* Enable styling for editor (block css) */
    add_theme_support('editor-styles');


    /* Register menus */
    $menus = [];

    /* prepare menu locations for all languages */
    global $oes;
    if (isset($oes->languages)) {
        foreach ($oes->languages as $languageKey => $languageData) {
            $menus = array_merge([
                'oes-utility-menu-' . $languageKey => 'OES Utility (' . ($languageData['abb'] ?? $languageKey) . ')',
                'oes-header-menu-' . $languageKey => 'OES Top (' . ($languageData['abb'] ?? $languageKey) . ')',
                'oes-footer-menu-' . $languageKey => 'OES Footer (' . ($languageData['abb'] ?? $languageKey) . ')',
                'oes-logo-menu-' . $languageKey => 'OES Logo (' . ($languageData['abb'] ?? $languageKey) . ')',
                'oes-social-menu-' . $languageKey => 'OES Social (' . ($languageData['abb'] ?? $languageKey) . ')'
            ],
                $menus);
        }
    } else
        $menus = [
            'oes-utility-menu-language0' => 'OES Utility',
            'oes-header-menu-language0' => 'OES Top',
            'oes-footer-menu-language0' => 'OES Footer',
            'oes-logo-menu-language0' => 'OES Logo',
            'oes-social-menu-language0' => 'OES Social'
        ];
    ksort($menus);


    /**
     * Filters the menus before registration.
     *
     * @param array $menus The menus.
     */
    if (has_filter('oes/theme_menus'))
        $menus = apply_filters('oes/theme_menus', $menus);

    register_nav_menus($menus);


    /* Add fav icon for pages */
    if (function_exists('oes_theme_add_favicon'))
        oes_theme_add_favicon(get_template_directory_uri() . '/assets/images/favicon.ico');


    /* Modify the WordPress search to use OES Feature "Search" */
    if (function_exists('oes_theme_modify_search')) oes_theme_modify_search();
}


/**
 * Set up language cookie.
 * @return void
 */
function oes_theme_set_language_cookie(): void
{
    if (isset($_GET['oes-language-switch']) || !isset($_COOKIE['oes_language'])) {
        global $oes;
        $newValue = $_GET['oes-language-switch'] ?? 'language0';
        if (isset($oes->languages[$newValue]))
            if (setcookie('oes_language', $newValue, time() + (30 * DAY_IN_SECONDS), '/')) {
                global $oes_language_switched;
                $oes_language_switched = $newValue;
            }
    }
}


/**
 * Load styles and scripts.
 * @return void
 */
function oes_theme_action_enqueue_scripts(): void
{
    /* enqueue styles */
    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');

    wp_enqueue_style('oes-style', get_template_directory_uri() . '/style.css');

    wp_register_style('oes-print', get_template_directory_uri() . '/assets/css/print.css');
    wp_enqueue_style('oes-print');

    wp_register_style('oes-scrolled', get_template_directory_uri() . '/assets/css/scrolled.css');
    wp_enqueue_style('oes-scrolled');

    wp_register_style('oes-responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    wp_enqueue_style('oes-responsive');

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

    global $post;
    wp_register_script('oes-paging',
        get_template_directory_uri() . '/assets/js/oes-paging.js',
        ['jquery'],
        false,
        true);
    wp_localize_script(
        'oes-paging',
        'oesPaging',
        [
            'current_id' => $post->ID ?? false
        ]
    );
    wp_enqueue_script('oes-paging');

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


/**
 * Register sidebars
 * @return void
 */
function oes_widget_init(): void
{
    register_sidebar([
        'name' => 'Archive Sidebar',
        'id' => 'oes-archive-sidebar']);

    register_sidebar([
        'name' => 'Single Sidebar',
        'id' => 'oes-single-sidebar']);

    register_sidebar([
        'name' => 'Search Sidebar',
        'id' => 'oes-search-sidebar']);
}


/**
 * Prepare general theme labels.
 *
 * @param array $themeLabels The theme labels.
 * @return array Return the modified theme labels.
 */
function oes_theme_labels_oes_config(array $themeLabels): array
{
    return array_merge([
        '404__header' => [
            'language0' => 'Page not found',
            'name' => '404 Page Not Found, Header',
            'location' => 'Page not found, tab header'
        ],
        '404__search_text' => [
            'language0' => 'Page not found',
            'name' => '404 Page Not Found, Search Text',
            'location' => 'Page not found, search text'
        ],
        '404_page_content' => [
            'language0' => '',
            'name' => '404 Page Not Found, Content',
            'location' => 'Page not found, content'
        ],
        'no_results_found' => [
            'language0' => 'No entries found for this filter combination.',
            'name' => 'No entries found for filter combination.',
            'location' => 'e.g. archive and search'
        ],
        'search__navigation__text' => [
            'language0' => 'Search the OES Encyclopedia',
            'name' => 'Search Panel, Text',
            'location' => 'Search Panel, above the search field'
        ],
        'sidebar__archive_header__responsive_expand' => [
            'language0' => 'Refine Search',
            'name' => 'Sidebar archive header refine search for responsive',
            'location' => 'Archive Sidebar'
        ],
        'search__no_results' => [
            'language0' => 'No results.',
            'name' => 'Search Results Page, No results',
            'location' => 'Search results page, no results found'
        ],
        'search__result_table__header_occurrences' => [
            'language0' => 'Occurrences',
            'name' => 'Search Result table Header, Occurrences',
            'location' => 'Search results, result table header'
        ],
        'search__see_term' => [
            'language0' => 'See also: ',
            'name' => 'Search Result Page, See also term',
            'location' => 'Search results page'
        ]
    ], $themeLabels);
}


/**
 * Prepare theme labels for objects.
 *
 * @param array $themeLabels The theme labels.
 * @param string $object Object key.
 * @return array Return the modified theme labels.
 */
function oes_theme_labels_object(array $themeLabels, string $object): array
{
    global $oes;
    $themeLabelsDefaults = [
        'archive__header' => [
            'name' => 'Archive: sub title',
            'location' => 'Archive view, Header'
        ]
    ];

    foreach ($themeLabelsDefaults as $themeLabelKey => $defaultInfo) {
        foreach ($oes->languages as $languageKey => $languageData)
            $themeLabelsDefaults[$themeLabelKey][$languageKey] = $object . ' (' . $defaultInfo['name'] . ')';
    }

    return array_merge($themeLabelsDefaults, $themeLabels);
}


/**
 * Fetch search result data
 */
function oes_fetch_search_result_data()
{
    get_template_part('template-parts/search', 'content');
    die();
}


/**
 * Display sidebar
 *
 * @param string $sidebar The sidebar id.
 * @param array $args Additional arguments.
 * @return void
 */
function oes_display_sidebar(string $sidebar, array $args = []): void
{

    $args = array_merge([
        'class' => 'oes-sidebar-list'
    ], $args);

    if (is_active_sidebar($sidebar)):?>
    <div class="<?php echo $args['class'] . '-wrapper'; ?>">
        <ul class="<?php echo $args['class']; ?>"><?php
            dynamic_sidebar($sidebar); ?></ul>
        </div><?php
    endif;
}


/**
 * Display the loading spinner
 * @return void
 */
function oes_theme_loading_spinner(): void
{
    echo '<div class="oes-loading-spinner-wrapper">' .
        '<div id="oes-loading-spinner">' .
        '<div class="oes-loading-spinner-bar1"></div>' .
        '<div class="oes-loading-spinner-bar2"></div>' .
        '<div class="oes-loading-spinner-bar3"></div>' .
        '<div class="oes-loading-spinner-bar4"></div>' .
        '<div class="oes-loading-spinner-bar5"></div>' .
        '</div>' .
        '</div>';
}