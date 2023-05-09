<div class="oes-archive-count-container"><?php echo oes_archive_count_html(); ?></div>
<div class="oes-archive-container-no-entries"><?php
    global $oes, $oes_language;
    echo $oes->theme_labels['no_results_found'][$oes_language] ?? 'No entries found for this filter combination.'; ?>
</div>