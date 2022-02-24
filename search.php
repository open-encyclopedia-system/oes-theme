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
            <div class="oes-page-with-sidebar">
                <div class="oes-subheader">
                    <div class="container">
                        <h3 class="oes-title-header oes-search-results-header"><?php
                            echo ($oes->theme_labels['search__result__text'][$language] ?? __('Results for', 'oes')) .
                                ' <span class="oes-search-term">' . esc_html(get_search_query()) . '</span>';
                            ?></h3>
                    </div>
                </div>
                <div class="oes-sub-subheader">
                    <div class="container"><?php


                        /* optional active filters */
                        $filterList = '';
                        if (!empty($filter['list']['objects']['items']))
                            foreach ($filter['list']['objects']['items'] as $key => $label){
                            $filterList .= sprintf('<li><a href="javascript:void(0);" ' .
                                'onClick="oesFilterPostTypes(\'%s\')" ' .
                                'class="oes-filter-post-type oes-filter-post-type-%s">%s</a></li>',
                            $key, $key, $label);
                        }

                        if (!empty($filterList)) :?>
                            <div class="oes-subheader-archive">
                            <ul class="oes-post-type-list oes-horizontal-list">
                                 <?php echo $filterList; ?></ul>
                            </div><?php
                        endif;


                        /* add count */
                        $archiveCount = (($search->characters && sizeof($search->characters) > 0 && $search->count) ?
                            $search->count :
                            false);
                        if ($archiveCount):
                            $labelSingular = $oes->theme_labels['search__result__count_singular'][$language] ??
                                __('Result', 'oes');
                            $labelPlural = $oes->theme_labels['search__result__count_plural'][$language] ??
                                __('Result', 'oes');

                            ?>
                            <div class="oes-subheader-count">
                            <span class="oes-archive-count-number"><?php
                                echo $archiveCount . ' '; ?></span><span class="oes-archive-count-label-singular" <?php
                            if ($archiveCount > 1) echo ' style="display:none";' ?>><?php
                                echo $labelSingular; ?></span><span class="oes-archive-count-label-plural" <?php
                            if ($archiveCount < 2) echo ' style="display:none";' ?>><?php
                                echo $labelPlural; ?></span>
                            </div><?php
                        endif;
                        ?>
                    </div>
                </div>
                <div class="oes-active-filter-container">
                    <div class="oes-active-filter-wrapper container">
                        <ul class="oes-active-filter-container-list"><?php
                            if (!empty($filter) && isset($filter['list']))
                                foreach ($filter['list'] as $singleFilter => $ignore)
                                    echo '<li><ul class="oes-active-filter-' . $singleFilter .
                                        ' oes-active-filter"></ul></li>';
                            ?></ul>
                    </div>
                </div>
                <div class="oes-archive-container oes-max-width-888 container"><?php
                    echo get_template_part('template-parts/search', 'list', ['data' => $results]);
                    ?>
                </div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();