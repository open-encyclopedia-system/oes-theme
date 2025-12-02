<?php

/* activate theme features */
add_action('after_setup_theme', 'oes_theme__after_setup_theme');
add_action('wp_enqueue_scripts', 'oes_theme__action_enqueue_scripts');
add_action('widgets_init', 'oes_theme__widget_init');

/* prepare theme labels */
add_filter('oes/prepare_theme_labels_oes_config', 'oes_theme__labels_oes_config');
add_filter('oes/prepare_theme_labels_taxonomy', 'oes_theme__labels_object', 10, 2);
add_filter('oes/prepare_theme_labels_post', 'oes_theme__labels_object', 10, 2);

/* fetch search result after page is loaded */
add_action('wp_ajax_oes_theme__fetch_search_result_data', 'oes_theme__fetch_search_result_data');
add_action('wp_ajax_nopriv_oes_theme__fetch_search_result_data', 'oes_theme__fetch_search_result_data');

/* redirect theme */
add_action('oes/redirect_template', 'oes_theme__redirect_template');


/**
 * Set up the OES theme.
 * @return void
 */
function oes_theme__after_setup_theme(): void
{

    /* enable widgets */
    add_theme_support('widgets');


    /* enable styling for editor (block css) */
    add_theme_support('editor-styles');


    /* register menus */
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
    $menus = apply_filters('oes/theme_menus', $menus);


    register_nav_menus($menus);


    /* add fav icon for pages */
    if (function_exists('oes_theme_add_favicon'))
        oes_theme_add_favicon(get_template_directory_uri() . '/assets/images/favicon.ico');


    /* modify the WordPress search to use OES feature "Search" */
    if (function_exists('oes_theme_modify_search')) oes_theme_modify_search();

    /* set global parameters */
    global $oes_archive_alphabet_initial, $oes_container_class;
    $oes_archive_alphabet_initial = true;
    $oes_container_class = 'container';
}


/**
 * Load styles and scripts.
 * @return void
 */
function oes_theme__action_enqueue_scripts(): void
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
function oes_theme__widget_init(): void
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
function oes_theme__labels_oes_config(array $themeLabels): array
{
    return array_merge([
        '404__header' => [
            'language0' => 'Page not found',
            'name' => '404 Page Not Found, Header',
            'location' => 'Page not found, tab header',
            'classic' => 2.3
        ],
        '404__search_text' => [
            'language0' => 'Page not found',
            'name' => '404 Page Not Found, Search Text',
            'location' => 'Page not found, search text',
            'classic' => 2.3
        ],
        '404_page_content' => [
            'language0' => '',
            'name' => '404 Page Not Found, Content',
            'location' => 'Page not found, content',
            'classic' => 2.3
        ],
        'sidebar__archive_header__refine_search' => [
            'language0' => 'Refine search',
            'name' => 'Archive sidebar header label',
            'location' => 'archive sidebar',
            'classic' => 2.3
        ],
        'no_results_found' => [
            'language0' => 'No entries found for this filter combination.',
            'name' => 'No entries found for filter combination.',
            'location' => 'e.g. archive and search',
            'classic' => 2.3
        ],
        'search__navigation__text' => [
            'language0' => 'Search the OES Encyclopedia',
            'name' => 'Search Panel, Text',
            'location' => 'Search Panel, above the search field',
            'classic' => 2.3
        ],
        'sidebar__archive_header__responsive_expand' => [
            'language0' => 'Refine Search',
            'name' => 'Sidebar archive header refine search for responsive',
            'location' => 'Archive Sidebar',
            'classic' => 2.3
        ],
        'search__no_results' => [
            'language0' => 'No results.',
            'name' => 'Search Results Page, No results',
            'location' => 'Search results page, no results found',
            'classic' => 2.3
        ],
        'search__result_table__header_occurrences' => [
            'language0' => 'Occurrences',
            'name' => 'Search Result table Header, Occurrences',
            'location' => 'Search results, result table header',
            'classic' => 2.3
        ],
        'search__see_term' => [
            'language0' => 'See also: ',
            'name' => 'Search Result Page, See also term',
            'location' => 'Search results page',
            'classic' => 2.3
        ],
        'search__result__count_singular' => [
            'language0' => 'Result',
            'name' => 'Search Result Page, Entries Count Label (Singular)',
            'location' => 'Search results page',
            'classic' => 2.3
        ],
        'search__result__count_plural' => [
            'language0' => 'Results',
            'name' => 'Search Result Page, Entries Count Label (Plural)',
            'location' => 'Search results page',
            'classic' => 2.3
        ],
        'archive__entry' => [
            'language0' => 'Entry',
            'name' => 'Archive Result Page, Entries Count Label (Singular)',
            'location' => 'Archive page',
            'classic' => 2.3
        ],
        'archive__entries' => [
            'language0' => 'Entries',
            'name' => 'Archive Result Page, Entries Count Label (Plural)',
            'location' => 'Archive page',
            'classic' => 2.3
        ],
        'single__sub_line__author_by' => [
            'name' => 'Sub line, author by label',
            'location' => 'Single view, subline',
            'language0' => 'by',
            'classic' => 2.3
        ],
        'single__sub_line__translation' => [
            'name' => 'Sub line, other language version available',
            'location' => 'Single view, subline',
            'language0' => 'Different language version available: ',
            'classic' => 2.3
        ],
        'single__toc__header_toc' => [
            'name' => 'Header: Table of Contents',
            'location' => 'Single view, table of contents header',
            'language0' => 'Table of Contents',
            'classic' => 2.3
        ],
        'single__toc__header_citation' => [
            'name' => 'Header: Citation',
            'location' => 'Single view, citation header',
            'language0' => 'Citation',
            'classic' => 2.3
        ],
        'single__toc__header_notes' => [
            'name' => 'Header: Notes',
            'location' => 'Single view, notes header',
            'language0' => 'Notes',
            'classic' => 2.3
        ],
        'single__toc__header_metadata' => [
            'name' => 'Header: Metadata',
            'location' => 'Single view, metadata header',
            'language0' => 'Metadata',
            'classic' => 2.3
        ],
        'single__toc__index' => [
            'language0' => 'Referred to in',
            'name' => 'Single (Index header)',
            'location' => 'Single view, related objects',
            'classic' => 2.3
        ],
        'single__toc__index_language_header' => [
            'language0' => 'Articles in other languages:',
            'name' => 'Single (Index header, language differentiation)',
            'location' => 'Single view, related objects',
            'classic' => 2.3
        ],
        'single__toc__index_contributor' => [
            'language0' => 'Published Articles',
            'name' => 'Single (Index header, Contributor)',
            'location' => 'Single view, related objects for contributor type',
            'classic' => 2.3
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
function oes_theme__labels_object(array $themeLabels, string $object): array
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
function oes_theme__fetch_search_result_data(): void
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
    $class = $args['class'] ?? 'oes-sidebar-list';
    if (is_active_sidebar($sidebar)):?>
    <div class="<?php echo $class . '-wrapper'; ?>">
        <ul class="<?php echo $class; ?>"><?php
            dynamic_sidebar($sidebar); ?></ul>
        </div><?php
    endif;
}


/**
 * Display the loading spinner
 * @return void
 */
function oes_theme__loading_spinner(): void
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


/**
 * Redirect template.
 *
 * @return void
 */
function oes_theme__redirect_template(): void
{
    if (locate_template('archive.php', true)) exit();
}


/**
 * Display search results per language.
 * 
 * @param array $results The results.
 * @return void
 */
function oes_theme__display_search_results(array $results): void
{
    /* sort results by occurrences */
    krsort($results);
    foreach ($results as $type => $posts) :

        /* loop through entries */
        krsort($posts);
        $containerString = '';
        $displayType = true;
        foreach ($posts as $rowData) {
            ksort($rowData);
            foreach ($rowData as $row) {

                /* display type for first element */
                if ($displayType):
                    echo '<div class="oes-search-archive-container oes-archive-wrapper oes-post-type-filter oes-post-type-filter-' . $type .
                        '" data-alphabet="' . $type . '">' .
                        '<div class="oes-alphabet-initial">' . ($row['type'] ?? $type) . '</div>';
                    $displayType = false;
                endif;

                /* prepare title */
                $title = sprintf('<a href="%s" class="oes-archive-title">%s</a>',
                    $row['permalink'],
                    $row['occurrences']['title']['value'] ?? ($row['title'] ?: 'Title missing')
                );

                /* add version */
                $additionalInfo = [];
                if (!empty($row['version'])) $additionalInfo[] = __('Version ', 'oes') . $row['version'];

                /* add occurrences */
                $additionalInfo[] = $row['occurrences-count'] . ' ' .
                    oes_get_label('search__result_table__header_occurrences', 'Occurrences');

                $title .= '<span class="oes-search-result-version-info">(' .
                    implode(' | ', $additionalInfo) .
                    ')</span>';

                /* check for results */
                $resultsTable = false;
                foreach ($row['occurrences'] ?? [] as $dataRow)
                    if (isset($dataRow['value']) &&
                        (!empty($dataRow['value']) &&
                            (is_string($dataRow['value']) && strlen(trim($dataRow['value'])) != 0))) {
                        if (!empty($dataRow['label'] ?? ''))
                            $resultsTable .= sprintf('<tr><th>%s</th><td>%s</td></tr>',
                                $dataRow['label'],
                                $dataRow['value']);
                        else
                            $resultsTable .= '<tr><td colspan="2">' .
                                do_shortcode(\OES\Popup\render_for_frontend($dataRow['value'])) . '</td></tr>';
                    }

                /* display row with results */
                if ($resultsTable)
                    $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s" data-post="%s">' .
                        '<a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus oes-toggle-down-before"></a>' .
                        '%s<div class="oes-archive-table-wrapper collapse" id="row%s">' .
                        '<table class="oes-archive-table oes-simple-table">%s' .
                        '</table>' .
                        '</div></div>',
                        ($row['language'] ?: 'all'),
                        $row['id'],
                        $row['id'],
                        $row['id'],
                        $title . (is_string($row['additional']) ? $row['additional'] : ''),
                        $row['id'],
                        $resultsTable);
                else
                    $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s" data-post="%s">%s</div>',
                        ($row['language'] ?: 'all'),
                        $row['id'],
                        $row['id'],
                        $title . (empty($row['additional']) || !is_string($row['additional']) ? '' : $row['additional'])
                    );
            }
        }

        if (!empty($containerString))
            printf('<div class="oes-search-archive-wrapper oes-archive-wrapper oes-post-type-filter oes-post-type-filter-%s">%s</div>',
                $type,
                $containerString);

        echo '</div>';
    endforeach;
}