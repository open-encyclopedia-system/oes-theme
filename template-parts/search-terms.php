<?php

global $oes, $oes_language;
$searchTerm = $_POST['search_params']['search_term'];


/* check for terms */
$termsFound = [];
foreach ($oes->search['taxonomies'] as $object => $objectData)
    if ($taxonomy = get_taxonomy($object)) {

        $taxonomyLabel = ($oes->taxonomies[$object]['label_translations'][$oes_language] ?:
                ($oes->taxonomies[$object]['label'] ?: $taxonomy->label));

        /* check if name or slug*/
        if (in_array('name', $objectData) && $term = get_term_by('name', $searchTerm, $object))
            $termsFound[$term->term_id] = sprintf('<a href="%s">%s</a><span class="oes-search-term-label">%s</span>)',
                get_term_link($term),
                $term->name,
                $taxonomyLabel
            );
        if (in_array('slug', $objectData) && $term = get_term_by('slug', $searchTerm, $object))
            $termsFound[$term->term_id] = sprintf('<a href="%s">%s</a><span class="oes-search-term-label">%s</span>',
                get_term_link($term),
                $term->name,
                $taxonomyLabel
            );
    }

if (!empty($termsFound)):?>
    <div class="oes-see-also-wrapper"><span class="oes-see-also"><?php
    echo $oes->theme_labels['search__see_term'][$oes_language] ?? 'See also: '; ?></span><?php
    echo implode(', ', $termsFound); ?>
    </div><?php
endif;