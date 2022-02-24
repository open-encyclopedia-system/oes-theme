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
        <div class="oes-subheader">
            <div class="container"><h3 class="oes-title-header"><?php echo $label; ?></h3></div>
            <div class="oes-sub-subheader">
                <div class="oes-max-width-888 container">
                    <h3><?php echo $termObject->title; ?></h3><?php

                    /* add back to index button */
                    if ($is_index) :?>
                        <span class="oes-post-buttons">
                        <button type="button" class="btn">
                            <a href="<?php echo get_site_url(). '/'. ($oes->theme_index['slug'] ?? 'index') ?>/"><?php
                                echo $oes->theme_labels['single__back_to_index_button'][$language] ?? 'Back to index'
                                ?></a>
                        </button>
                        </span><?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="oes-single-post oes-max-width-888 container"><?php
            echo $termObject->get_html_main(['language' => $language]); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();