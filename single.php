<?php

global $oes_post, $oes_container_class;
$indexClass = (!empty($oes_post->part_of_index_pages) ? ' oes-index-page' : '');

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_post ? $oes_post->get_tab_title() : get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading"><?php

        get_template_part('template-parts/single', 'title');

        ?>
        <div class="oes-background-white-slim">
            <div class="oes-single-post <?php echo ($oes_container_class ?? '') . $indexClass; ?>"><?php

                /* display with sidebar */
                if (method_exists($oes_post, 'display_sidebar') ||
                    is_active_sidebar('oes-single-sidebar')) :?>
                    <div class="row gx-5">
                        <div class="oes-main-content col-12 col-lg-8 oes-mt-3"><?php

                            the_content();

                            ?>
                        </div>
                        <div class="oes-sidebar col-12 col-lg-4 oes-mt-3 no-print"><?php

                            if (method_exists($oes_post, 'display_sidebar')) :
                                $oes_post->display_sidebar();
                            else :
                                oes_display_sidebar('oes-single-sidebar');
                            endif;

                            ?>
                        </div>
                    </div><?php

                /* display without sidebar */
                else:

                    the_content();

                endif; ?>
            </div>
        </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();