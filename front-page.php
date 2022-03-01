<?php

/* skip OES rendering */
global $language, $oes_frontpage, $post;
$oes_frontpage = true;
$language = oes_get_post_language($post->ID) ?? 'language0';


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