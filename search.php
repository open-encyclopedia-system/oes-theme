<?php


/* prepare results for display ---------------------------------------------------------------------------------------*/
global $oes_search, $wp_query;
$oes_search = oes_get_search_data();


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_search['label'] ?? __('Search', 'oes')]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <script type="text/javascript">
        let oes_search_results = <?php echo json_encode($oes_search);?>;
    </script>
    <main class="oes-smooth-loading">
        <div class="oes-sidebar-filter-wrapper">
            <div class="oes-page-with-sidebar"><?php

                /* display title */
                get_template_part('template-parts/search', 'title');

                oes_theme_loading_spinner();

                ?>
                <div id="oes-search-results"></div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();