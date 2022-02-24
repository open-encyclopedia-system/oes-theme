<?php


/* check if post type for index --------------------------------------------------------------------------------------*/
global $post_type, $post, $oes, $language, $index_post_types, $oes_post;
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
        <div class="oes-subheader">
            <div class="container"><h3 class="oes-title-header"><?php echo $label; ?></h3></div>
            <div class="oes-sub-subheader">
                <div class="oes-max-width-888 container">
                    <h3><?php echo $oes_post->get_title(); ?></h3><?php

                    /* add language switch */
                    if ($oes_post->translations && isset($oes_post->translations[0]['id'])):
                        foreach ($oes_post->translations as $translation):
                            if (isset($translation['id'])) :?>
                                <span class="oes-post-buttons">
                                <button type="button" id="oes-language-switch-button" class="btn">
                            <a href="<?php echo get_permalink($translation['id']); ?>"><?php
                                echo $oes->languages[$translation['language']]['label'] ?: 'Language'; ?></a>
                        </button>
                                </span><?php
                            endif;
                        endforeach;
                    endif;

                    /* add back to index button */
                    if ($is_index) :?>
                        <span class="oes-post-buttons">
                        <button type="button" class="btn">
                            <a href="<?php echo get_site_url() . '/' . ($oes->theme_index['slug'] ??
                                    __('index', 'oes')) ?>/"><?php
                                echo $oes->theme_labels['single__back_to_index_button'][$oes_post->language] ??
                                    __('Back to index', 'oes')
                                ?></a>
                        </button>
                        </span><?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="oes-single-post oes-max-width-888 container"><?php the_content(); ?></div>
    </main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();