<?php
global $post_type, $oes, $language, $oes_additional_objects, $is_index;
$archive = $args['archive'] ?? false;

if($archive):
?><div class="oes-subheader">
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

            $alphabetArray = oes_archive_get_alphabet_filter($archive->characters);
            foreach ($alphabetArray as $item) $alphabetList .= '<li>' . $item['content'] . '</li>';
            echo '<div class="oes-subheader-alphabet">' .
                '<ul class="oes-alphabet-list oes-horizontal-list">' . $alphabetList . '</ul></div>';
        }

        /* optional index subheader */
        if ($is_index)
            get_template_part('template-parts/subheader', 'index',
                ['objects' => $oes->theme_index['objects'] ?? []]);

        /* optional active filters */
        if (!empty($archive->filter_array))
            get_template_part('template-parts/archive', 'active-filter');


        /* add count */
        $archiveCount = (($archive->characters && sizeof($archive->characters) > 0 && $archive->count) ?
            $archive->count :
            false);
        if($archiveCount)
            get_template_part('template-parts/archive', 'count', ['archive-count' => $archiveCount]);
        ?>
    </div>
</div><?php
endif;