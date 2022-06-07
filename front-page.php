<?php


/* skip OES rendering */
global $oes_language, $oes_frontpage;
$oes_frontpage = true;
$oes_language = oes_get_post_language(get_the_ID()) ?? 'language0';


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <div class="oes-front-page"><?php the_content(); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();