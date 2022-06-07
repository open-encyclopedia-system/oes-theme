<?php
global $oes, $oes_language, $oes_is_search, $oes_search;
if($oes_search) :
    ?><div class="oes-subheader">
    <div class="container">
        <h3 class="oes-title-header oes-search-results-header"><?php
            echo ($oes->theme_labels['search__result__text'][$oes_language] ?? __('Results for', 'oes')) .
                ' <span class="oes-search-term">' . esc_html(get_search_query()) . '</span>';
            ?></h3>
    </div>
</div><?php
endif;