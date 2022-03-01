<?php


/* check if post type for index --------------------------------------------------------------------------------------*/
global $post_type, $post, $oes, $language, $index_post_types, $oes_post, $is_index;
$is_index = in_array($post_type, $oes->theme_index['objects'] ?? []);

/* get post object (prepare rendered content to derive table of content etc) */
$oes_post = class_exists($post_type) ? new $post_type(get_the_ID(), $language) : new OES_Post(get_the_ID(), $language);
$label = $oes->post_types[$post_type]['label_translations'][$language] ?: ($oes->post_types[$post_type]['label'] ??
        (get_post_type_object($post_type)->labels->singular_name ?? 'Label missing'));

/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $oes_post->get_title()]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <?php get_template_part('template-parts/single', 'title', ['label' => $label]); ?>
        <div class="oes-single-post oes-max-width-888 container"><?php the_content(); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();