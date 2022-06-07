<?php


/* set OES Post object -----------------------------------------------------------------------------------------------*/
global $oes_language, $oes_term;
oes_set_term_data();


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_term->title]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <?php get_template_part('template-parts/taxonomy', 'title', [
            'label' => $oes_term->taxonomy_label,
            'title' => $oes_term->title]); ?>
        <div class="oes-single-post oes-max-width-888 container"><?php
            echo $oes_term->get_html_main(['language' => $oes_language]); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();