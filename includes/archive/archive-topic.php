<?php


use OES\Versioning as V;


/* store post information that are to be displayed in an array */
global $tableData;


/* get information about occurrences ---------------------------------------------------------------------------------*/
$args = [
    'post_type' => OES_Project_Config::POST_TYPE_ALL,
    'posts_per_page' => -1,
    'tax_query' => [[
        'taxonomy' => $args['taxonomy'],
        'field' => 'term_id',
        'terms' => $args['term_id']
    ]]
];
$queryRelations = new WP_Query($args);


/* get details of occurrences ----------------------------------------------------------------------------------------*/
if ($queryRelations->have_posts()) {

    /* add header for table display */
    $tableData[] = ['label' => ['Title', 'Type',  'Version']];

    /* loop through relations */
    while ($queryRelations->have_posts()) {

        /* get connected post */
        $queryRelations->the_post();

        /* title, type, version */
        $tableData[] = ['value' => [
            sprintf('<a href="%1s">%2s</a>', get_permalink(), oes_get_display_title()),
            get_post_type_object(get_post_type())->label,
            V\get_acf_version_field(get_the_ID())]];
    }
}


/* add info if no data */
if (empty($tableData)) $tableData[] = ['value' => 'There are no posts connected to this tag.'];