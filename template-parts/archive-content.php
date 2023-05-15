<div class="oes-sidebar-filter-wrapper">
    <div class="oes-page-with-sidebar"><?php

        get_template_part('template-parts/archive', 'title');

        ?>
        <div class="oes-background-white-slim">
            <div class="<?php global $oes_is_index;
            echo $oes_is_index ? 'oes-archive-container-index ' : ''; ?>oes-archive-container container">
                <div class="row gx-5">
                    <div class="oes-title-header-wrapper oes-archive-container-list oes-main-content col-12 col-lg-8 oes-mt-3"><?php

                        get_template_part('template-parts/archive', 'list-before');

                        get_template_part('template-parts/archive', 'list');

                        get_template_part('template-parts/archive', 'list-after');

                        ?>
                    </div>
                    <div class="oes-sidebar-with-toggle oes-sidebar col-12 col-lg-4 oes-mt-3"><?php

                        get_template_part('template-parts/archive', 'sidebar');

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>