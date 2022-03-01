<div id="oes-sidebar-filter-panel-content" class="">
    <div class="oes-sidebar-filter-header-padding"></div>
    <div class="oes-sidebar-filter-dropdowns">
        <div class="oes-sidebar-filter-header">
            <button type="button" id="oes-sidebar-filter-header-close" class="oes-close-contrast btn"></button>
        </div><?php
        $filter = $args['filter'] ?? [];
        if (!empty($filter['list'])) :?>
            <ul class="oes-filter-list-container"><?php
            foreach ($filter['list'] as $filterKey => $filterContainer)
                if (!empty($filterContainer['items'])) {

                    /* filter items list */
                    $filterItemsList = '<ul class="oes-filter-list collapse" id="oes-filter-component-' .
                        $filterKey . '">';

                    natcasesort($filterContainer['items']);
                    foreach ($filterContainer['items'] ?? [] as $itemKey => $itemLabel)
                        $filterItemsList .=
                            sprintf('<li class="oes-archive-filter-item"><a href="javascript:void(0)" data-filter="%s" ' .
                                'data-name="%s" data-type="%s"' .
                                ' class="oes-archive-filter-%s-%s oes-archive-filter" '.
                                'onClick="oesFilterProcessing(\'%s\', \'%s\')">%s' .
                                '<span class="oes-filter-item-count">%s</span></a></li>',
                                $itemKey,
                                $itemLabel,
                                $filterKey,
                                $filterKey,
                                $itemKey,
                                $itemKey,
                                $filterKey,
                                $itemLabel,
                                '(' . (isset($filter['json'][$filterKey][$itemKey]) ?
                                    sizeof($filter['json'][$filterKey][$itemKey]) :
                                    0) . ')'
                            );
                    $filterItemsList .= '</ul>';

                    printf('<li><a href="#oes-filter-component-%s" data-toggle="collapse" ' .
                        'aria-expanded="false" class="oes-filter-component">%s</a>%s</li>',
                        $filterKey,
                        $filterContainer['label'] ?? 'Label missing',
                        $filterItemsList
                    );
                } ?></ul><?php
        endif; ?>
    </div>
</div>