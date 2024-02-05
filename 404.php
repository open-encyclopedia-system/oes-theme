<?php


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, [
    'head-text' => oes_get_label('404__header', 'Page not found'),
    'show-search' => true,
    'search-text' => oes_get_label('404__search_text', 'Page not found')
]);


/* display background ------------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
    <div class="oes-page-not-found">
        <div class="oes-single-post <?php global $oes_container_class;
        echo $oes_container_class ?? ''; ?>"></div>
    </div></main><?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();