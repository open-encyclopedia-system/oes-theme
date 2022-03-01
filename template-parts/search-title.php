<?php
global $post_type, $oes, $language, $oes_additional_objects, $is_search;
$archive = $args['search'] ?? false;
$is_search = true;

if($archive) :
    ?><div class="oes-subheader">
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
        $filter = $archive->filter_array;
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
        $archiveCount = (($archive->characters && sizeof($archive->characters) > 0 && $archive->count) ?
            $archive->count :
            false);
        if($archiveCount)
            get_template_part('template-parts/archive', 'count', ['archive-count' => $archiveCount]);
        ?>
    </div>
    </div><?php
endif;