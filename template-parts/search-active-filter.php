<div class="oes-active-filter-container">
    <div class="oes-active-filter-wrapper container">
        <ul class="oes-active-filter-container-list"><?php
            global $oes_search;
            if (!empty($oes_search['filter_array']) && isset($oes_search['filter_array']['list']))
                foreach ($oes_search['filter_array']['list'] as $singleFilter => $ignore)
                    echo '<li><ul class="oes-active-filter-' . $singleFilter .
                        ' oes-active-filter"></ul></li>';
            ?></ul>
    </div>
</div>