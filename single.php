<?php

$postObject = null;

/* differentiate between post types ----------------------------------------------------------------------------------*/
global $post_type;
switch(get_post_type_object($post_type)->name){


    /* ARTICLE -------------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_ARTICLE :

        $postObject = new OES_Demo_Article();

        /* check if print */
        if (isset($_GET['print'])) {$postObject->create_pdf(); return;}

        $headerText = 'Article';
        $subheaderArgs = [
            'wrapper_id' => 'single-post-header',
            'include_print' => true,
            'include_translation' => $postObject->translationIDs ? $postObject->translationIDs : false,
            'subheader_title' => $postObject->get_title(),
        ];
        break;


    /* CONTRIBUTOR ---------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_CONTRIBUTOR :

        $postObject = new OES_Demo_Contributor();
        $headerText = 'Contributor';
        $subheaderArgs = [
            'wrapper_id' => 'single-post-header',
            'include_back_link' => $_SERVER['HTTP_REFERER'],
            'include_back_text' =>
                ($_SERVER['HTTP_REFERER'] ==
                    get_post_type_archive_link(OES_Project_Config::POST_TYPE_CONTRIBUTOR)) ?
                __('Back to Contributors', 'oes-demo') :
                __('Back', 'oes-demo'),
            'subheader_title' => $postObject->get_title()
        ];
        break;


    /* GLOSSARY ------------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_GLOSSARY :

        $postObject = new OES_Demo_Glossary();
        $headerText = 'Glossary Entry';
        $subheaderArgs = [
            'wrapper_id' => 'single-post-header',
            'subheader_title' => $postObject->get_title(),
            'include_translation' => $postObject->translationIDs ? $postObject->translationIDs : false,
        ];
        break;


    /* INDEX ---------------------------------------------------------------------------------------------------------*/
    case OES_Project_Config::POST_TYPE_INDEX_PERSON :
    case OES_Project_Config::POST_TYPE_INDEX_PLACE :
    case OES_Project_Config::POST_TYPE_INDEX_TIME :
    case OES_Project_Config::POST_TYPE_INDEX_SUBJECT :
    case OES_Project_Config::POST_TYPE_INDEX_INSTITUTE :

        /* get index identifier 'person', 'place', 'time' or 'subject' for header */
        $identifier = OES_Project_Config::POST_TYPE_IDENTIFIER;
        $headerText = isset($identifier[get_post_type()]) ? $identifier[get_post_type()] : 'post';

        $postObject = new OES_Demo_Index(false, get_post_type());

        $indexArchives = [
            get_permalink(get_page_by_path('oes-demo-index')),
            get_post_type_archive_link(OES_Project_Config::POST_TYPE_INDEX_PERSON),
            get_post_type_archive_link(OES_Project_Config::POST_TYPE_INDEX_PLACE),
            get_post_type_archive_link(OES_Project_Config::POST_TYPE_INDEX_TIME),
            get_post_type_archive_link(OES_Project_Config::POST_TYPE_INDEX_SUBJECT),
            get_post_type_archive_link(OES_Project_Config::POST_TYPE_INDEX_INSTITUTE),
        ];

        $subheaderArgs = [
            'wrapper_id' => 'single-post-header',
            'include_back_link' => $_SERVER['HTTP_REFERER'],
            'include_back_text' => (in_array($_SERVER['HTTP_REFERER'], $indexArchives)) ?
                __('Back to Index', 'oes-demo') :
                __('Back', 'oes-demo'),
            'subheader_title' => $postObject->get_title(),
        ];
}


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null,
    [
        'head_text' => $postObject->get_title(),
        'header_text' => isset($headerText) ? $headerText : $postObject->get_title(),
        'subheader' => isset($subheader) ? $subheader : 'title',
        'subheader_args' => isset($subheaderArgs) ? $subheaderArgs : [],
    ]);


/* display main content ----------------------------------------------------------------------------------------------*/
echo $postObject->get_html_main(['include-wrapper' => true]);


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();