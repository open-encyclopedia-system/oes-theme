<?php

/* prepare results for display ---------------------------------------------------------------------------------------*/
global $oes_language;
$search = (array)oes_get_search_data(['language' => 'all']);
$search['oes_language'] = $oes_language;


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $search['label'] ?? __('Search', 'oes')]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <script type="text/javascript">
        let oes_search_results = <?php echo json_encode($search);?>;
    </script>
    <main class="oes-smooth-loading">
        <div class="oes-sidebar-filter-wrapper">
            <div class="oes-page-with-sidebar"><?php

                get_template_part('template-parts/search', 'title');

                oes_theme__loading_spinner();

                ?>
                <div id="oes-search-results"></div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();