<?php


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null,
    [
        'head_text' => get_the_title(),
        'header_text' => get_the_title()
    ]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main id="no-subheader">
        <div id="single-post" class="wrapper-main">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </main>
<?php

/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();
?>