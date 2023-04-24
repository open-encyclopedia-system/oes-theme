<?php

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading"><?php
        get_template_part('template-parts/front-page', 'title'); ?>
        <div class="oes-front-page"><?php

            the_content();

            ?>
        </div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();