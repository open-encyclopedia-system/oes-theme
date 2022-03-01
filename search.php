<?php

global $oes, $language;


/* prepare results for display ---------------------------------------------------------------------------------------*/
$search = new OES_Search($language);
$label = $search->label ?? __('Search', 'oes');
$results = $search->prepared_posts;
$filter = $search->filter_array;

/* sort table data according to occurrences */
krsort($results);


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $label]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <div class="oes-sidebar-filter-wrapper">
            <div class="oes-page-with-sidebar"><?php
                get_template_part('template-parts/search', 'title', ['search' => $search]);
                ?>
                <div class="oes-active-filter-container">
                    <div class="oes-active-filter-wrapper container">
                        <ul class="oes-active-filter-container-list"><?php
                            if (!empty($filter) && isset($filter['list']))
                                foreach ($filter['list'] as $singleFilter => $ignore)
                                    echo '<li>HH<ul class="oes-active-filter-' . $singleFilter .
                                        ' oes-active-filter"></ul></li>';
                            ?></ul>
                    </div>
                </div>
                <div class="oes-archive-container oes-max-width-888 container"><?php
                    get_template_part('template-parts/search', 'list', ['data' => $results]);
                    ?>
                </div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();