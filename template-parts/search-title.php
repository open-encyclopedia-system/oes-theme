<?php
global $oes_search;
if ($oes_search) :
    ?>
    <div class="oes-subheader d-print-none">
        <div class="oes-subheader-title-container">
            <div class="container">
                <div class="oes-page-title"><?php get_search_form(); ?></div>
            </div>
        </div>
    </div><?php
endif;