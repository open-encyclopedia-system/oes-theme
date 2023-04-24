<?php

/* get global OES instance parameter */
global $post_type, $oes_language, $oes, $oes_search;


/* display empty results */
$results = $oes_search['posts'] ?? [];
if (empty($results) || count($results) == 0) :
    echo $oes->theme_labels['search__no_results'][$oes_language] ?? 'No results.';

/* loop through table data -------------------------------------------------------------------------------------------*/
else:?><div class="oes-search-archive-container"><?php

    /* sort results by occurrences */
    krsort($results);
    foreach ($results as $occurrences => $posts) :

        /* loop through entries */
        ksort($posts);
        $containerString = '';
        foreach ($posts as $row) {

            /* prepare title */
            $title = sprintf('<a href="%s" class="oes-archive-title">%s</a>',
                $row['permalink'],
                $row['occurrences']['title']['td'][0] ?? ($row['title'] ?: 'Title missing')
            );

            /* add version */
            $additionalInfo = [];
            if (!empty($row['version'])) $additionalInfo[] = __('Version ', 'oes') . $row['version'];

            /* add language */
            $postLanguage = $row['language'] ?: false;
            if ($postLanguage) $additionalInfo[] = $oes->languages[$postLanguage]['label'] ?? $postLanguage;

            /* add occurrences */
            $additionalInfo[] = $occurrences . ' ' .
                ($oes->theme_labels['search__result_table__header_occurrences'][$oes_language] ?? 'Occurrences');

            $title .= '<span class="oes-search-result-version-info">(' . implode(' | ', $additionalInfo) . ')</span>';

            /* check for results */
            $resultsTable = false;
            if (!empty($row['occurrences']))
                foreach ($row['occurrences'] as $rowKey => $dataRow)
                    if (isset($dataRow['th']))
                        foreach ($dataRow['th'] as $position => $singleOccurrence)
                            if (isset($dataRow['td'][$position])) {
                                if ($rowKey === 'content')
                                    $resultsTable .= '<tr><td colspan="2">' . $dataRow['td'][$position] . '</td></tr>';
                                else $resultTable = '<tr>' .
                                    '<th>' . $singleOccurrence . '</th>' .
                                    '<td>' . $dataRow['td'][$position] . '</td></tr>';
                            }

            /* display row with results */
            if ($resultsTable)
                $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s oes-post-type-filter oes-post-type-filter-%s">' .
                    '<a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus oes-toggle-down-before"></a>' .
                    '%s<div class="oes-archive-table-wrapper collapse" id="row%s">' .
                    '<table class="oes-archive-table oes-simple-table">%s' .
                    '</table>' .
                    '</div></div>',
                    $postLanguage ?: 'all',
                    $row['id'],
                    $row['post_type'],
                    $row['id'],
                    $title . (is_string($row['additional']) ? $row['additional'] : ''),
                    $row['id'],
                    $resultsTable);
            else
                $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s">%s</div>',
                    $postLanguage ?: 'all',
                    $row['id'],
                    $title . (empty($row['additional']) || !is_string($row['additional']) ? '' : $row['additional'])
                );
        }

        if (!empty($containerString))
            printf('<div class="oes-search-archive-wrapper oes-archive-wrapper filter-%s">%s</div>',
                $occurrences,
                $containerString);
    endforeach;?></div><?php
endif;