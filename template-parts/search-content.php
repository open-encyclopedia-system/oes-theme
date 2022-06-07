<?php
global $oes_search, $oes_language, $oes_archive_count;
if(isset($_POST['search_params'])) $oes_search = oes_search_get_results($_POST['search_params'] ?? []);
if(!$oes_language) $oes_language = $oes_search['language'] ?? 'language0';
$oes_archive_count = $oes_search['count'] ?? false;

?><div class="oes-sub-subheader">
    <div class="container"><?php

        /* optional post type filters */
        echo do_shortcode('[oes_post_type_filter type="default"]');

        /* add count */
        $oes_is_search = true;
        echo do_shortcode('[oes_archive_count type="default"]');
        ?>
    </div>
</div><?php

/* display filter */
if (isset($oes_search['filter_array']) && !empty($oes_search['filter_array']))
    get_template_part('template-parts/search', 'active-filter');

?>
<div class="oes-archive-container oes-max-width-888 container"><?php

    get_template_part('template-parts/search', 'list');
    ?>
</div>