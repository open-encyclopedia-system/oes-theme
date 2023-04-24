<?php

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <?php get_template_part('template-parts/page', 'title'); ?>
        <div class="oes-background-white-slim">
            <div class="oes-single-post <?php global $oes_container_class; echo $oes_container_class ?? ''; ?>"><?php

                the_content();

                ?>
            </div>
        </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();