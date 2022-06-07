<?php
global $oes_is_index, $oes_archive_data;
?>
<div class="oes-sidebar-filter-wrapper">
    <div id="oes-sidebar-filter-panel"><?php
        if (!empty($oes_archive_data['archive']['filter_array']))
            get_template_part('template-parts/sidebar'); ?>
    </div>
    <div class="oes-page-with-sidebar"><?php

        /* get title */
        get_template_part('template-parts/archive', 'title');

        /* add div for active filter */
        echo '<div class="oes-active-filter-wrapper container">' .
            do_shortcode('[oes_active_filter type="default"]') . '</div>';

        ?>
        <div class="<?php echo $oes_is_index ? 'oes-archive-container-index ' : '';
        ?>oes-archive-container oes-max-width-888 container">
            <div class="oes-archive-container-no-entries"><?php
                _e('No entries found for this filter combination.', 'oes'); ?></div><?php
            get_template_part('template-parts/archive', 'list');
            ?>
        </div>
    </div>
</div>