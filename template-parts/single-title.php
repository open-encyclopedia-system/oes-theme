<?php
global $oes, $oes_post, $oes_is_index;
?>
<div class="oes-subheader">
    <div class="oes-max-width-888 container"><h3 class="oes-title-header"><?php echo $args['label'] ?? 'Label missing'; ?></h3></div>
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
            if ($oes_is_index) :?>
                <span class="oes-post-buttons">
                <button type="button" class="btn">
                    <a href="<?php
                    echo(get_site_url() . '/' . ($oes->theme_index['slug'] ?? __('index', 'oes'))); ?>/"><?php
                        echo($oes->theme_labels['single__back_to_index_button'][$oes_post->language] ??
                            __('Back to index', 'oes')); ?></a>
                </button>
                </span><?php
            endif;
            ?>
        </div>
    </div>
</div>