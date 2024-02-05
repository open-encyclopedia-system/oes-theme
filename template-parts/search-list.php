<?php

/* get global OES instance parameter */
global $post_type, $oes_language, $oes, $oes_search;


/* display empty results */
$results = $oes_search['prepared_posts'] ?? [];
if (empty($results) || count($results) == 0) :
    echo oes_get_label('search__no_results', 'No results.');

/* loop through table data -------------------------------------------------------------------------------------------*/
else:?>
    <div class="oes-search-list-wrapper"><?php

    if (isset($results[$oes_language])) oes_theme__display_search_results($results[$oes_language]);

    foreach ($results as $languageKey => $languageResults):
        if ($languageKey !== $oes_language):?>
            <div class="oes-search-archive-container"><?php

            echo '<div class="oes-index-language-dependent"><h2>' .
                oes_get_label('single__toc__index_language_header') . ' ' .
                (OES()->languages[$languageKey]['label'] ?? $languageKey) .
                '</h2></div>';

            oes_theme__display_search_results($languageResults);

            ?></div><?php
        endif;
    endforeach; ?></div><?php
endif;