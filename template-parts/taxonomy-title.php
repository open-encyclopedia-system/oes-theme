<?php
global $is_index, $language;

?>
<div class="oes-subheader">
    <div class="container"><h3 class="oes-title-header"><?php echo $args['label'] ?? 'Label missing'; ?></h3></div>
    <div class="oes-sub-subheader">
        <div class="oes-max-width-888 container">
            <h3><?php echo $args['title'] ?? 'Term title missing'; ?></h3><?php

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