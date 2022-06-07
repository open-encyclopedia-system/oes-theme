<?php
global $oes, $oes_language, $post_type, $taxonomy;
if (isset($oes->theme_index['objects']) && !empty($oes->theme_index['objects'])) :
    ?>
    <div class="oes-subheader-index">
    <ul class="oes-horizontal-list"><?php

        /* add navigation item to get to index page */
        printf('<li class=""><a href="%s" class="text-uppercase">%s</a></li>',
            get_site_url() . '/' . ($oes->theme_index['slug'] ?? 'index') . '/',
            $oes->theme_labels['archive__filter__all_button'][$oes_language] ?? 'ALL'
        );

        foreach ($oes->theme_index['objects'] as $object) {

            /* get name and link from post type or taxonomy */
            $link = $name = false;
            if ($postTypeObject = get_post_type_object($object)) {
                $name = ($oes->post_types[$object]['theme_labels']['archive__header'][$oes_language] ??
                    ($oes->post_types[$object]['label'] ?? $postTypeObject->label));
                $link = get_post_type_archive_link($object);
            } elseif ($taxonomyObject = get_taxonomy($object)) {
                $name = ($oes->taxonomies[$object]['label_translations'][$oes_language] ??
                    ($oes->taxonomies[$object]['label'] ?? $taxonomyObject->label));
                $link = (get_site_url() . '/' . $oes->taxonomies[$object]['rewrite']['slug'] . '/');
            }

            /* add navigation item */
            if ($name && $link)
                printf('<li><a href="%s" class="text-uppercase %s">%s</a></li>',
                    $link,
                    (($object === $post_type || $object === $taxonomy) ?  'active' : ''),
                    $name
                );
        }
        ?>
    </ul>
    </div><?php
endif;