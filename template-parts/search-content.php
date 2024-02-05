<?php
global $oes_search, $oes_language, $oes_archive_count, $oes_filter;
if (isset($_POST['search_params'])) $oes_search = oes_search_get_results($_POST['search_params'] ?? []);
$oes_archive_count = $oes_search['count'] ?? false;
$oes_filter = $oes_search['filter_array'];
$oes_is_search = true;

?>
<div class="oes-background-white-slim">
    <div class="oes-archive-container container">
        <div class="row gx-5">
            <div class="oes-title-header-wrapper oes-archive-container-list oes-main-content col-12 col-lg-8 oes-mt-3"><?php

                get_template_part('template-parts/search', 'list-before');

                get_template_part('template-parts/search', 'list');

                get_template_part('template-parts/search', 'list-after');

                ?>
            </div>
            <div class="oes-sidebar-with-toggle oes-sidebar col-12 col-lg-4 oes-mt-3"><?php

                get_template_part('template-parts/search', 'sidebar');

                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let oes_filter = <?php echo json_encode($oes_search['filter_array']['json'] ?? []);?>;
    localStorage.setItem('oesDisplayedIds', <?php echo json_encode($oes_search['post_ids'] ?? [])?>);
    localStorage.setItem('oesSearchResultsURL', <?php echo json_encode(get_search_link($oes_search['search_term'] ?? '')); ?>);
</script>