<?php

/* check if post type for index --------------------------------------------------------------------------------------*/
global $post_type, $oes, $language, $oes_additional_objects, $is_index, $archive_alphabet;
if (!$is_index) $is_index = in_array($post_type, $oes->theme_index['objects'] ?? []);


/* do the loop -------------------------------------------------------------------------------------------------------*/
$archive = new OES_Archive();
if (!empty($oes_additional_objects)) $archive->set_additional_objects($oes_additional_objects);
$tableArray = $archive->get_data_as_table();
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
            <div class="oes-page-with-sidebar"><?php
                get_template_part('template-parts/archive', 'title', ['archive' => $archive]);
                ?>
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
                    get_template_part('template-parts/archive', 'list', [
                        'data' => $tableArray,
                        'add-alphabet' => $archive_alphabet ?? false,
                        'title-is-link' => !$archive->display_content
                    ]);
                    ?>
                </div>
            </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();