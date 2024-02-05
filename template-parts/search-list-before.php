<div class="oes-archive-wrapper-header"><?php
    echo oes_get_label('search__result__count_plural', 'Results'); ?>
</div>
<div class="oes-archive-count"><?php
    echo oes_archive_count_html(); ?>
</div>
<div class="oes-archive-container-no-entries"><?php
    echo oes_get_label('no_results_found', 'No entries found for this filter combination.'); ?>
</div><?php

/* show terms with name */
global $oes;
if (isset($oes->search['taxonomies']) && !empty($oes->search['taxonomies']))
    get_template_part('template-parts/search', 'terms');