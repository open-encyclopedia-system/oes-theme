<?php
global $oes_archive_data;
$archive = $oes_archive_data['archive'] ?? false;

if ($archive):?>
    <div class="oes-subheader d-print-none">
    <div class="oes-subheader-title-container">
        <div class="container">
            <div class="oes-archive-header oes-page-title print-black"><?php echo $archive['label']; ?></div>
        </div>
    </div>
    </div><?php
endif;