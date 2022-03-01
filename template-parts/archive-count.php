<?php
global $post_type, $language, $is_search;
$archiveCount = $args['archive-count'] ?? false;

if ($archiveCount):

    if($is_search){
        $labelSingular = $oes->theme_labels['search__result__count_singular'][$language] ??
            __('Result', 'oes');
        $labelPlural = $oes->theme_labels['search__result__count_plural'][$language] ??
            __('Result', 'oes');
    }
    else{
        $labelSingular =
            $oes->post_types[$post_type]['theme_labels']['archive__entry'][$language] ?? 'Entry';
        $labelPlural =
            $oes->post_types[$post_type]['theme_labels']['archive__entries'][$language] ?? 'Entries';
    }

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