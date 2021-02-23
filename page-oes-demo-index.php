<?php


/* prepare data ------------------------------------------------------------------------------------------------------*/
get_template_part('project/archive/archive-all-indices');


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null,
    ['head_text' => 'Index',
        'header_text' => 'Index',
        'subheader' => 'navigation',
        'sub_subheader' => 'alphabet-filter',
        'sub_subheader_args' => ['section_id' => 'sub-subheader']
    ]);


/* get table data ----------------------------------------------------------------------------------------------------*/
get_template_part('includes/table/table',
    null,
    [
        'post_type' => OES_Project_Config::POST_TYPE_INDEX_ANY,
        'empty_text' => 'No connected articles.'
    ]);


/* display main content ----------------------------------------------------------------------------------------------*/
get_template_part('template-parts/list/accordion',
    null,
    [
        'wrapper_id' => 'archive-list',
        'title_is_link' => true,
        'add_alphabet' => true,
        'display_table_args' => ['empty_text' => 'No connected articles.']]);


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();