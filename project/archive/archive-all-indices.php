<?php

/* store post count for display */
global $count;

/* store posts in array */
global $objectArray;

/* store alphabet information */
global $alphabetArrayInput;


/* prepare data ------------------------------------------------------------------------------------------------------*/
$objectArray = [];
$collectAlphabet = [];


/* get filter --------------------------------------------------------------------------------------------------------*/
$filter = isset($_GET['filter']) ? $_GET['filter'] : false;


/* query posts -------------------------------------------------------------------------------------------------------*/
$args = ['post_type' => OES_Project_Config::POST_TYPE_INDEX, 'post_status' => 'publish', 'posts_per_page' => -1];
$queryRelations = new WP_Query($args);


/* loop through all posts --------------------------------------------------------------------------------------------*/
$otherKeys = false;
if ($queryRelations->have_posts()) {
    while ($queryRelations->have_posts()) {

        $queryRelations->the_post();

        $key = strtoupper(substr(oes_get_display_title(), 0, 1));

        /* check if non alphabetic key */
        if (!in_array($key, range('A', 'Z'))) {
            $key = 'other';
            $otherKeys = true;
        }


        /* add information to array ------------------------------------------------------------------------------*/
        if (!$filter || strtoupper($key) == strtoupper($filter)) {
            $objectArray[$key][oes_get_display_title() . get_the_ID()][] = [
                'title' => oes_get_display_title(),
                'permalink' => get_permalink(),
                'postID' => get_the_ID(),
                'post_type' => get_post_type()
            ];
            $count++;
        }

        if ($key != 'other') $collectAlphabet[$key] = [$key];
        else $collectAlphabet['other'] = ['other'];


        wp_reset_postdata();
    }
}


/* extract all keys of object array for filter -----------------------------------------------------------------------*/
$alphabetArrayInput = array_keys($collectAlphabet);
asort($alphabetArrayInput);