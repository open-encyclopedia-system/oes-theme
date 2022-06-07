<?php
global $oes_additional_objects, $oes_is_index, $oes_archive_data;
$archive = $oes_archive_data['archive'] ?? false;

if($archive):
?><div class="oes-subheader">
    <div class="container">
        <h3 class="oes-title-header"><?php echo $archive['label']; ?></h3>
    </div>
</div>
<div class="oes-sub-subheader">
    <div class="container"><?php

        /* optional alphabet subheader */
        if ((isset($archive['filter']['alphabet']) && $archive['filter']['alphabet']) ||
            !empty($oes_additional_objects)) {
            $alphabetList = '';

            $alphabetArray = oes_archive_get_alphabet_filter($archive['characters']);
            foreach ($alphabetArray as $item) $alphabetList .= '<li>' . $item['content'] . '</li>';
            echo '<div class="oes-subheader-alphabet">' .
                '<ul class="oes-alphabet-list oes-horizontal-list">' . $alphabetList . '</ul></div>';
        }

        /* optional index subheader */
        if ($oes_is_index) get_template_part('template-parts/subheader', 'index');

        /* optional filter button */
        if (!empty($archive['filter_array']))
            get_template_part('template-parts/archive', 'active-filter');

        /* add count */
        echo do_shortcode('[oes_archive_count type="default"]');

        ?>
    </div>
</div><?php
endif;