<?php

use OES\Config as C;

/* differentiate between post types ----------------------------------------------------------------------------------*/

/* get global variable post type */
global $post_type;
$post_type_origin = get_post_type_object($post_type)->name;
switch($post_type_origin){


    /* ARTICLE -------------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_ARTICLE :

        $headText = 'Articles';
        $headerText = 'Articles';
        $subheader = 'article-categories';
        $subheaderArgs = ['section_id' => 'subheader'];
        $emptyText = 'No meta data for this article.';
        $titleField = 'oes_demo_article_title';
        $checkForVersioning = true;
        $checkForTranslation = true;
        $checkForFilter = [
            'global_variable' => 'category',
            'compare_to_object' => 'term',
            'term_slug' => 'oes_demo_tag_category',
            'term_parameter' => 'slug',
            'additional_value' => 'all',
            'master' => true
        ];
        break;


    /* CONTRIBUTOR ---------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_CONTRIBUTOR :

        $headText = 'Contributors';
        $headerText = 'Contributors';
        $subheader = 'alphabet-filter';
        $subheaderArgs = ['section_id' => 'subheader'];
        $subSubheader = false;
        $emptyText = 'No meta data for this author.';
        $titleField = 'oes_demo_contributor_title';
        break;


    /* GLOSSARY ENTRIES ----------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_GLOSSARY :

        $headText = 'Glossary';
        $headerText = 'Glossary';
        $subheader = 'alphabet-filter';
        $subheaderArgs = ['section_id' => 'subheader'];
        $subSubheader = false;
        $emptyText = 'No meta data for this glossary entry.';
        $titleField = 'oes_demo_glossary_title';
        $checkForTranslation = true;
        break;


    /* INDEX ---------------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_INDEX_PERSON :
    case OES_Project_Config::POST_TYPE_INDEX_PLACE :
    case OES_Project_Config::POST_TYPE_INDEX_TIME :
    case OES_Project_Config::POST_TYPE_INDEX_SUBJECT :
    case OES_Project_Config::POST_TYPE_INDEX_INSTITUTE :

        $post_type = OES_Project_Config::POST_TYPE_INDEX_ANY;
        $headText = 'Index';
        $headerText = 'Index';
        $subheader = 'navigation';
        $subheaderArgs = ['section_id' => 'subheader'];
        $emptyText = 'No meta data for this index.';
        $titleField = 'oes_demo_index_title';
        break;
}


/* prepare data ------------------------------------------------------------------------------------------------------*/
get_template_part('includes/archive/archive',
    null,
    [
        'post_type' => $post_type,
        'title_field' => isset($titleField) ? $titleField : false,
        'check_for_versioning' => isset($checkForVersioning) ? $checkForVersioning : false,
        'check_for_translation' => isset($checkForTranslation) ? $checkForTranslation : false,
        'check_for_filter' => isset($checkForFilter) ? $checkForFilter : false,
    ]);


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null,
    [
        'head_text' => isset($headText) ? $headText : 'OES Demo',
        'header_text' => isset($headerText) ? $headerText : 'OES Demo',
        'subheader' => isset($subheader) ? $subheader : 'navigation',
        'subheader_args' => isset($subheaderArgs) ? $subheaderArgs : [],
        'sub_subheader' => isset($subSubheader) ? $subSubheader : 'alphabet-filter',
        'sub_subheader_args' => isset($subheaderArgs) ? $subheaderArgs : [],
    ]);


/* get table data (prepare data for list/table display) --------------------------------------------------------------*/
get_template_part('includes/table/table',
    null,
    [
        'post_type' => $post_type,
        'empty_text' => isset($emptyText) ? $emptyText : 'No further information.'
    ]);


/* display main content ----------------------------------------------------------------------------------------------*/

/* check for options for archive view */
$archiveViewOptions = get_option(C\Option::THEME_TITLE . '-' . $post_type_origin . '-title');
if($archiveViewOptions['display_archive_list']){
    $listType = 'list';
    $listWrapperID = 'archive-list-simple';
    $listTableID = 'list-simple';
    $wrapperID = 'archive-list-main';
}

get_template_part('template-parts/list/' . (isset($listType) ? $listType : 'accordion'),
    null,
    [
        'wrapper_id' => isset($listWrapperID) ? $listWrapperID : 'archive-list',
        'wrapper_main_id' => isset($wrapperID) ? $wrapperID : 'archive',
        'table_id' => isset($listTableID) ? $listTableID : false,
        'accordion_id' => 'archive-list-icon',
        'title_is_link' => true,
        'add_alphabet' => true,
        'display_table_args' => ['empty_text' => isset($emptyText) ? $emptyText : 'No further information.']
    ]);


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();