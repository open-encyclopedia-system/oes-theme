<?php

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => get_the_title()]);

/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <div class="oes-subheader">
            <div class="container">
                <div class="text-center"><h3 class="oes-title-header"><?php the_title(); ?></h3></div>
            </div>
        </div>
        <div class="oes-single-post oes-max-width-888 container"><?php the_content(); ?></div>
    </main>
<?php

/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();