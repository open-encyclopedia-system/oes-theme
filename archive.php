<?php

global $oes_archive;

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => strip_tags($oes_archive['page_title'] ?? '')]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading"><?php

        get_template_part('template-parts/archive', 'content');

        ?>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();