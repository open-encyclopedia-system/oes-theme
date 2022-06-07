<?php

/* get global OES instance parameter */
global $post_type, $oes_language, $oes, $oes_search;


/* display empty results */
$results = $oes_search['posts'] ?? [];
if (empty($results) || count($results) == 0) : echo 'No results.';

/* loop through table data -------------------------------------------------------------------------------------------*/
else:

    /* sort results by occurrences */
    krsort($results);

    ?>
    <table class="oes-search-wrapper table">
    <thead>
    <tr>
        <th colspan="2"><?php echo $oes->theme_labels['search__result_table__header_title'][$oes_language] ?? 'Title';?></th>
        <th><?php echo $oes->theme_labels['search__result_table__header_type'][$oes_language] ?? 'Type';?></th>
        <th><?php echo $oes->theme_labels['search__result_table__header_occurrences'][$oes_language] ?? 'Occurrences';?></th>
    </tr>
    </thead>
    <?php
    foreach ($results as $occurrences => $posts) :?>
        <tbody><?php


        /* add container for character */

        /* loop through entries */
        ksort($posts);
        foreach ($posts as $row) {

            /* check if title is link */
            $title = sprintf('<a href="%s" class="oes-archive-title">%s</a>',
                $row['permalink'],
                $row['occurrences']['title']['td'][0] ?? ($row['title'] ?: 'Title missing')
            );
            if(!empty($row['version']))
                $title .= '<span class="oes-search-result-version-info">(' .
                     __('Version ', 'oes') . $row['version'] . ')</span>';

            /* check for results */
            $resultsTable = false;
            if (!empty($row['occurrences']))
                foreach ($row['occurrences'] as $rowKey => $dataRow)
                    if (isset($dataRow['th']))
                        foreach ($dataRow['th'] as $position => $singleOccurrence)
                            if (isset($dataRow['td'][$position])) {
                                $resultsTable .= '<div class="oes-search-occurrence-type-container">' .
                                    ($rowKey && in_array($rowKey, ['content', 'title']) ?
                                        '' :
                                        ('<strong>' . $singleOccurrence . '</strong>: ')) .
                                    ($rowKey === 'title' ?
                                        '<strong>' . $dataRow['td'][$position] . '</strong>' :
                                        $dataRow['td'][$position]) .
                                    '</div>';
                            }

            /* display row with results */
            if ($resultsTable)
                printf('<tr class="oes-search-row-wrapper oes-post-filter-wrapper oes-post-filter-%s oes-post-type-filter oes-post-type-filter-%s">' .
                    '<td><a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus"></a>%s</td>' .
                    '<td></td><td>%s</td>' .
                    '<td><a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-search-occurrences">%s</a></td>' .
                    '</tr>' .
                    '<tr class="oes-search-data-row collapse" id="row%s"><td colspan="4">%s' .
                    '<div class="oes-read-more-button-container"><span class="oes-read-more-button"><a href="%s">%s</a></span></div>' .
                    '</td></tr>',
                    $row['id'],
                    $row['post_type'],
                    $row['id'],
                    $title,
                    $row['type'],
                    $row['id'],
                    $row['occurrences-count'] ?? 0,
                    $row['id'],
                    $resultsTable,
                    $row['permalink'],
                    $oes->theme_labels['general__read_more'][$oes_language] ?? 'Read more'
                );
            else
                printf('<tr class="oes-search-row-wrapper oes-post-filter-wrapper oes-post-filter-%s">' .
                    '<td>%s</td><td></td><td>%s</td><td>%s</td></tr>',
                    $row['id'],
                    $title,
                    $row['type'],
                    $row['occurrences-count'] ?? 0
                );
        }
        ?>
        </tbody><?php
    endforeach;
    ?></table><?php
endif;