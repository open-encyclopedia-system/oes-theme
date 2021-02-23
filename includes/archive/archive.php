<?php


use OES\Versioning as V;


/* store post count for display */
global $count;

/* store posts in array */
global $objectArray;

/* store alphabet information */
global $alphabetArrayInput;


/* prepare data ------------------------------------------------------------------------------------------------------*/
$objectArray = [];
$collectAlphabet = [];


/* get alphabet filter -----------------------------------------------------------------------------------------------*/
$filter = isset($_GET['filter']) ? $_GET['filter'] : false;


/* loop through all posts --------------------------------------------------------------------------------------------*/
$otherKeys = false;
if (have_posts()) {
    while (have_posts()) {

        the_post();

        /* skip if status is not 'publish' */
        if('publish' != get_post_status()) continue;

        /* Optional: check if more current version exists. If it does, skip this post. -------------------------------*/
        if ($args['check_for_versioning']) {

            /* get current version from master post */
            $currentVersionPostID = V\get_current_version_id(get_the_ID());

            /* if current version is different from this post than skip and go to next post */
            if ($currentVersionPostID && $currentVersionPostID != get_the_ID()) continue;
        }


        /* Optional: check if post is a translation of a origin post. If it is, skip post. ---------------------------*/
        if($args['check_for_translation'] && V\get_origin_version_id(get_the_ID())) continue;


        /* Optional: check if post meets filter option. If it doesn't, skip this post. -------------------------------*/
        if ($args['check_for_filter']) {

            /* get filter */
            $filterValue = isset($_GET[$args['check_for_filter']['global_variable']]) ?
                $_GET[$args['check_for_filter']['global_variable']] : false;

            /* get post value */
            $argsFilter = array_merge($args['check_for_filter'], ['post_id' => get_the_ID()]);
            get_template_part('includes/filter/filter-compare-to-values', null, $argsFilter);

            /* skip if post does not meet the criteria */
            global $compareFilterToArray;
            if ($filterValue && !in_array($filterValue, $compareFilterToArray)) continue;
        }


        /* get post data ---------------------------------------------------------------------------------------------*/
        $titleDisplay = oes_get_list_title();

        /* get first character of displayed title */

        /* check option for sorting title */
        $sortingTitle = oes_get_sorting_title();

        $key = strtoupper(substr($sortingTitle, 0, 1));

        /* check if non alphabetic key */
        if (!in_array($key, range('A', 'Z'))) {
            $key = 'other';
            $otherKeys = true;
        }


        /* prepare array with existing first characters of displayed posts */
        if ($key != 'other') $collectAlphabet[$key] = [$key];
        else $collectAlphabet['other'] = ['other'];


        /* skip post if filter is active and doesn't match the key ---------------------------------------------------*/
        if ($filter && strtoupper($key) != strtoupper($filter)) continue;


        /* add information  ------------------------------------------------------------------------------------------*/
        $objectArray[$key][$sortingTitle .' ' . get_the_ID()][] = [
            'postID' => get_the_ID(),
            'title' =>  oes_get_display_title(get_the_ID()),
            'titleForDisplay' => $titleDisplay,
            'permalink' => get_permalink()
        ];

        $count++;
    }
}


/* extract all keys of object array containing the posts and sort them alphabetically --------------------------------*/
$alphabetArrayInput = array_keys($collectAlphabet);
asort($alphabetArrayInput);