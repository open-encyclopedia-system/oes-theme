<?php


/* get post object (prepare rendered content to derive table of content etc) -----------------------------------------*/
global $oes_language, $oes_post;
$oes_post = new OES_Post(get_the_ID(), $oes_language);
$oes_language = $oes_post->language;


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <?php get_template_part('template-parts/page', 'title'); ?>
        <div class="oes-single-post oes-max-width-888 container"><?php the_content(); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();