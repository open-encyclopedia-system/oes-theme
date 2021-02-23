<?php


use OES\Versioning as V;

/* get global filter values */
global $compareFilterToArray;

switch($args['compare_to_object']){

    case 'term' :

        /* get all terms for post */
        if($args['master']){
            $masterID = V\get_master_id($args['post_id']);
            $getPostCategory = get_the_terms($masterID, $args['term_slug']);
        }
        else{
            $getPostCategory = get_the_terms($args['post_id'], $args['term_slug']);
        }

        /* add additional value */
        if(isset($args['additional_value'])) $compareFilterToArray = [$args['additional_value']];

        /* loop through all values and add to array */
        foreach ($getPostCategory as $wpCategory) {

            /* differentiate between term parameters */
            switch($args['term_parameter']){

                case 'slug' :
                    $compareFilterToArray[] = $wpCategory->slug;
                    break;
            }

        }
        break;
}
