<?php

global $is_index, $taxonomy, $term, $language, $oes;
$is_index = in_array($taxonomy, $oes->theme_index['objects'] ?? []);

/* get term object */
$label = $oes->taxonomies[$taxonomy]['label_translations'][$language] ??
    ($oes->taxonomies[$taxonomy]['label'] ?: (get_taxonomy($taxonomy)->labels->singular_name ?? 'Label missing'));

$termID = get_term_by('slug', $term, $taxonomy)->term_id ?? false;
$termObject = class_exists($taxonomy) ? new $taxonomy($termID) : new OES_Taxonomy($termID);


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null, ['head-text' => $termObject->title]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
    <main class="oes-smooth-loading">
        <?php get_template_part('template-parts/taxonomy', 'title', ['label' => $label, 'title' => $termObject->title]); ?>
        <div class="oes-single-post oes-max-width-888 container"><?php
            echo $termObject->get_html_main(['language' => $language]); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();