<?php


/* set OES Post object -----------------------------------------------------------------------------------------------*/
global $oes_post;
oes_set_post_data();


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_post ? $oes_post->get_title() : get_the_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading"><?php
        get_template_part('template-parts/single', 'title', [
                'label' => $oes_post ? $oes_post->post_type_label : ''
        ]); ?>
        <div class="oes-single-post oes-max-width-888 container"><?php the_content(); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();