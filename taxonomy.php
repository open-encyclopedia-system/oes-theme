<?php

global $oes_language, $oes_term, $oes_container_class;
$indexClass = (!empty($oes_term->part_of_index_pages) ? ' oes-index-page' : '');

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_term->title]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading"><?php

        get_template_part('template-parts/taxonomy', 'title');

        ?>
        <div class="oes-background-white-slim">
            <div class="oes-single-post <?php echo ($oes_container_class ?? '') . $indexClass; ?>"><?php

                /* display with sidebar */
                if (method_exists($oes_term, 'display_sidebar')) :?>
                    <div class="row gx-5">
                        <div class="oes-main-content col-12 col-lg-8 mt-5"><?php
                            echo $oes_term->get_html_main(['language' => $oes_language]); ?>
                        </div>
                        <div class="oes-sidebar col-12 col-lg-4 mt-5"><?php
                            $oes_term->display_sidebar(); ?>
                        </div>
                    </div>
                <?php

                /* display without sidebar */
                else:
                    echo $oes_term->get_html_main(['language' => $oes_language]);
                endif;

                ?></div>
        </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();