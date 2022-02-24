<?php

$title = 'Page not found... :(';

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, [
    'head-text' => 'Page not found... :(',
    'show-search' => true,
    'search-text' => 'Page not found... '
]);

/* display background ------------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
    <div class="oes-page-not-found">
        <div class="oes-single-post oes-max-width-888 container"><?php echo $title; ?></div>
    </div></main><?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();