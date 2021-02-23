<?php

/* get array containing the posts */
global $objectArray;

/* store post information that are to be displayed in an array */
global $tableArray;


/* prepare table -----------------------------------------------------------------------------------------------------*/
$tableArray = [];


/* loop through array ------------------------------------------------------------------------------------------------*/
if(is_array($objectArray)) ksort($objectArray);
foreach ($objectArray as $firstCharacter => $objectContainer) {

    /* sort array */
    ksort($objectContainer);

    /* loop through single object */
    $table = [];
    foreach ($objectContainer as $objects) {
        foreach ($objects as $object) {


            /* gather information ------------------------------------------------------------------------------------*/
            $postID = isset($object['postID']) ? $object['postID'] : false;
            $tableData = [];
            $title = 'Title missing';
            $permalink = $object['permalink'];
            $hidePost = false;


            if ($postID) {

                /* prepare title */
                $title = $object['titleForDisplay'] ? $object['titleForDisplay'] : $object['title'];

                /* get post */
                $postType = $args['post_type'];

                if(class_exists($postType))$post = new $postType($postID);
                else $post = new \OES\Theme\OES_Post_Type_Theme($postID);

                /* check if post is hidden */
                if(method_exists($post, 'check_if_post_is_hidden'))
                    $hidePost = $post->check_if_post_is_hidden();

                /* get data to be displayed in dropdown table */
                $tableData = $post->get_archive_data();

                /* sort table */
                if(is_array($tableData)) ksort($tableData);

            }

            /* add info if no archive data found */
            if (empty($tableData) && !$hidePost) {
                if(empty($args['empty_text'])) $args['empty_text'] = 'No further information.';
                $tableData[] = ['value' => $args['empty_text']];
            }


            /* add information to table ------------------------------------------------------------------------------*/
            if(!$hidePost) $table[] = ['title' => $title, 'permalink' => $permalink, 'data' => $tableData];

        }
    }


    /* add table to array --------------------------------------------------------------------------------------------*/
    if($firstCharacter == 'other') $firstCharacter = '#';
    if(!empty($table)) $tableArray[] = ['character' => $firstCharacter, 'table' => $table];
}