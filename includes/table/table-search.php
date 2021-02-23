<?php


use OES\Config\Option;
use OES\Versioning as V;
use function OES\ACF\get_acf_field;
use function OES\ACF\get_acf_field_object;


/* store results in array */
global $tableArray;

/* store count for each post type */
global $countPostsPerPostType;

/* store overall count of posts */
global $count;

/* get global search variable (WordPress search) */
global $s;


/* prepare fields for post types : loop through all post types and collect fields ------------------------------------*/
$postTypeFields = [];
foreach (OES_Project_Config::POST_TYPE_ALL as $singlePostType) {

    /* skip post type if it doesn't meet filter criteria */
    if (!in_array($singlePostType, $args['post_type'])) continue;

    /* get options for post type */
    $themeOptions = get_option(Option::THEME . '-' . $singlePostType);

    /* skip if theme options does not exist */
    if (!$themeOptions) continue;

    /* loop through fields */
    foreach ($themeOptions as $optionKey => $option) {

        /* field should be [field name]-[parameter] */
        $explodeOptionKey = explode('-', $optionKey);
        preg_match('/(.+)-(.+)/', $optionKey, $explodedOptionKey);

        /* skip if option key does not match pattern */
        if (empty($explodedOptionKey)) continue;

        /* validate exploded option key */

        /* skip if option is not 'include in search' */
        if ($explodedOptionKey[2] != 'include_in_search') continue;

        /* check if title is included */
        if ($explodedOptionKey[1] == 'wp_title') {
            $postTypeFields[$singlePostType]['wp_title'] = 'wp_title';
        } else {
            $postTypeFields[$singlePostType][$explodedOptionKey[1]] = 'text';
        }
    }
}


/* loop through posts and store values that match the filter criteria ------------------------------------------------*/
$table = [];
if (have_posts()) {
    while (have_posts()) {

        /* get post */
        the_post();


        /* skip post if post doesn't meet filter criteria ------------------------------------------------------------*/
        if (!in_array(get_post_type(), $args['post_type'])) continue;

        /* prepare occurrences count and search result ---------------------------------------------------------------*/
        $occurrences = 0;
        $tableData = [];


        /* get post main data ----------------------------------------------------------------------------------------*/

        /* loop through fields and store fields if field matches search criteria */
        foreach ($postTypeFields[get_post_type()] as $key => $fieldType) {

            /* differentiate field types */
            switch ($fieldType) {

                case 'wp_title' :

                    /* get search results */
                    $searchResultTitleArray = oes_get_highlighted_search($s, get_the_title());

                    /* add to search results to be displayed */
                    if ($searchResultTitleArray) {
                        $occurrences += substr_count(strtolower(get_the_title()), strtolower($s));
                        $tableData[] = ['th' => ['Title (WordPress)'], 'td' => [$searchResultTitleArray[0]['sentence']]];
                    }

                    break;

                case 'text' :
                case 'textarea' :
                case 'wysiwyg' :
                case 'url' :

                    /* get search results */
                    $searchResultsFields = oes_get_highlighted_search($s, get_acf_field($key));

                    /* prepare search result for display */
                    if ($searchResultsFields) {

                        /* multiple occurrences inside the field, list occurrences */
                        if (count($searchResultsFields) > 1) {

                            /* open list */
                            $returnString = '<ul id="search-results">';

                            /* loop through occurrences */
                            foreach ($searchResultsFields as $item) {

                                /* open item */
                                $returnString .= '<li>';

                                /* if not first or single occurrence, add '...' before result text */
                                if (!in_array($item['position'], ['first', 'single']))
                                    $returnString .= '<div class="dot-dot-dot">...</div>';

                                /* add result text */
                                $returnString .= $item['sentence'];

                                /* if not last or single occurrence, add '...' before result text */
                                if (!in_array($item['position'], ['last', 'single']))
                                    $returnString .= '<div class="dot-dot-dot">...</div>';

                                /* close item */
                                $returnString .= '</li>';
                            }

                            /* close list */
                            $returnString .= '</ul>';
                        } /* single occurrences inside the field */
                        else {
                            $returnString = $searchResultsFields[0]['sentence'];
                        }

                        /* add to occurrences of post */
                        $occurrences += substr_count(strtolower($returnString), strtolower($s));

                        /* add information to table */
                        $tableData[] = ['th' => [get_acf_field_object($key)['label']], 'td' => [$returnString]];
                    }

                    break;

                case 'date_picker' :
                case 'select' :
                case 'relationship' :
                    //TODO @2.0 Roadmap : more search field types
                    break;

            }
        }


        /* skip post if no results found in defined fields */
        if (empty($tableData)) continue;


        /* modify title and add version */
        $title = oes_get_display_title() . (!empty(V\get_acf_version_field(get_the_ID())) ?
                ' (Version ' . V\get_acf_version_field(get_the_ID()) . ')' : '');


        /* add information to table ----------------------------------------------------------------------------------*/
        $table[] = [
            'title' => oes_get_display_title() . (!empty(V\get_acf_version_field(get_the_ID())) ?
                    ' (Version ' . V\get_acf_version_field(get_the_ID()) . ')' : ''),
            'subtitle' => '- ' . get_post_type_object(get_post_type())->label,
            'title_right' => '(' . $occurrences . ' Occurrences)',
            'post_type' => get_post_type(),
            'post_type_label' => get_post_type_object(get_post_type())->label,
            'occurrences' => $occurrences,
            'permalink' => get_permalink(),
            'data' => $tableData
        ];

        /* add count to count array */
        $countPostsPerPostType[get_post_type()] = $countPostsPerPostType[get_post_type()] ?
            intval($countPostsPerPostType[get_post_type()]) + 1 :
            1;

        $count++;
    }
}

/* sort array */
$titles = array_column($table, 'title');
$postTypes = array_column($table, 'post_type');
$permalinks = array_column($table, 'permalink');
$occurrences = array_column($table, 'occurrences');

/* get options */
$themeSearchOptions = get_option(Option::THEME_SEARCH);

/* first sorting column */
$firstColumn = $titles;
$firstColumnSorting = SORT_ASC;
switch ($themeSearchOptions['first_sort']) {
    case 'default':
    case 'name_asc' :
        $firstColumn = $titles;
        $firstColumnSorting = SORT_ASC;
        break;
    case 'name_desc' :
        $firstColumn = $titles;
        $firstColumnSorting = SORT_DESC;
        break;
    case 'type_asc' :
        $firstColumn = $postTypes;
        $firstColumnSorting = SORT_ASC;
        break;
    case 'type_desc' :
        $firstColumn = $postTypes;
        $firstColumnSorting = SORT_DESC;
        break;
    case 'occurrences_asc' :
        $firstColumn = $occurrences;
        $firstColumnSorting = SORT_ASC;
        break;
    case 'occurrences_desc' :
        $firstColumn = $occurrences;
        $firstColumnSorting = SORT_DESC;
        break;
}

/* first sorting column */
$secondaryColumn = $postTypes;
$secondaryColumnSorting = SORT_ASC;
switch ($themeSearchOptions['secondary_sort']) {
    case 'default':
    case 'name_asc' :
        $secondaryColumn = $titles;
        $secondaryColumnSorting = SORT_ASC;
        break;
    case 'name_desc' :
        $secondaryColumn = $titles;
        $secondaryColumnSorting = SORT_DESC;
        break;
    case 'type_asc' :
        $secondaryColumn = $postTypes;
        $secondaryColumnSorting = SORT_ASC;
        break;
    case 'type_desc' :
        $secondaryColumn = $postTypes;
        $secondaryColumnSorting = SORT_DESC;
        break;
    case 'occurrences_asc' :
        $secondaryColumn = $occurrences;
        $secondaryColumnSorting = SORT_ASC;
        break;
    case 'occurrences_desc' :
        $secondaryColumn = $occurrences;
        $secondaryColumnSorting = SORT_DESC;
        break;
}

array_multisort($firstColumn, $firstColumnSorting, $secondaryColumn, $secondaryColumnSorting, $permalinks, SORT_ASC, $table);

$tableArray[] = ['table' => $table];