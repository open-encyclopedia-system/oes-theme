<?php
global $oes, $oes_language;
?>
    <div class="oes-archive-wrapper-header"><?php echo($oes->theme_labels['search__result__count_plural'][$oes_language] ??
            __('Results', 'oes')); ?></div>
    <div class="oes-archive-count"><?php echo oes_archive_count_html(); ?></div>
    <div class="oes-archive-container-no-entries"><?php
echo $oes->theme_labels['no_results_found'][$oes_language] ?? 'No entries found for this filter combination.'; ?>
    </div><?php

/* show terms with name */
if (isset($oes->search['taxonomies']) && !empty($oes->search['taxonomies']))
    get_template_part('template-parts/search', 'terms');