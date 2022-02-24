<?php

/* check if post type for index --------------------------------------------------------------------------------------*/
global $post_type, $oes, $language, $oes_additional_objects, $is_index;
if (!$is_index) $is_index = in_array($post_type, $oes->theme_index['objects'] ?? []);


/* do the loop -------------------------------------------------------------------------------------------------------*/
$archive = new OES_Archive();
if (!empty($oes_additional_objects)) $archive->set_additional_objects($oes_additional_objects);
$tableArray = $archive->get_data_as_table();
$alphabetArray = oes_archive_get_alphabet_filter($archive->characters);
$filter = $archive->filter_array;


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $archive->label]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <script type="text/javascript">
        var oes_filter = <?php echo json_encode($filter['json'] ?? []);?>
    </script>
    <main class="oes-smooth-loading">
        <div class="oes-sidebar-filter-wrapper">
            <div id="oes-sidebar-filter-panel"><?php
                if (!empty($filter)) get_template_part('template-parts/sidebar', '', ['filter' => $filter]); ?>
            </div>
            <div class="oes-page-with-sidebar">
                <div class="oes-subheader">
                    <div class="container">
                        <h3 class="oes-title-header"><?php echo $archive->label; ?></h3>
                    </div>
                </div>
                <div class="oes-sub-subheader">
                    <div class="container"><?php

                        /* optional alphabet subheader */
                        if ((isset($archive->filter['alphabet']) && $archive->filter['alphabet']) ||
                            !empty($oes_additional_objects)) {
                            $alphabetList = '';
                            foreach ($alphabetArray as $item) $alphabetList .= '<li>' . $item['content'] . '</li>';
                            echo '<div class="oes-subheader-alphabet">' .
                                '<ul class="oes-alphabet-list oes-horizontal-list">' . $alphabetList . '</ul></div>';
                        }

                        /* optional index subheader */
                        if ($is_index)
                            get_template_part('template-parts/subheader', 'index',
                                ['objects' => $oes->theme_index['objects'] ?? []]);

                        /* optional active filters */
                        if (!empty($filter)) : ?>
                            <div class="oes-subheader-archive">
                            <div class="oes-subheader-archive-wrapper">
                                <button type="button" id="oes-filter-panel-button" class="btn"><?php
                                    _e('Filter', 'oes'); ?></button>
                            </div>
                            </div><?php endif;


                        /* add count */
                        $archiveCount = (($archive->characters && sizeof($archive->characters) > 0 && $archive->count) ?
                            $archive->count :
                            false);
                        if ($archiveCount):
                            $labelSingular =
                                $oes->post_types[$post_type]['theme_labels']['archive__entry'][$language] ?? 'Entry';
                            $labelPlural =
                                $oes->post_types[$post_type]['theme_labels']['archive__entries'][$language] ?? 'Entries';

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
                <div class="<?php echo $is_index ? 'oes-archive-container-index ' : '';
                ?>oes-archive-container oes-max-width-888 container">
                    <div class="oes-archive-container-no-entries"><?php
                        _e('No entries found for this filter combination.', 'oes');?></div><?php
                    echo get_template_part('template-parts/archive', 'list', [
                        'data' => $tableArray,
                        'add-alphabet' => false,
                        'title-is-link' => !$archive->display_content
                    ]);
                    ?>
                </div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();