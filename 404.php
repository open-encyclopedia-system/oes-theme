<?php


/* display header ----------------------------------------------------------------------------------------------------*/
global $oes, $oes_language, $oes_container_class;
get_header(null, [
    'head-text' => $oes->theme_labels['404__header'][$oes_language] ?? 'Page not found... :(',
    'show-search' => true,
    'search-text' => $oes->theme_labels['404__search_text'][$oes_language] ?? 'Page not found... '
]);


/* display background ------------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
    <div class="oes-page-not-found">
        <div class="oes-single-post <?php echo $oes_container_class ?? '';?>"><?php
            echo $oes->theme_labels['404_page_content'][$oes_language] ?? 'Page not found... :('; ?></div>
    </div></main><?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();