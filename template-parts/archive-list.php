<?php
global $post_type, $oes_archive_data, $oes_archive_alphabet_initial, $oes_archive_skipped_posts;
if (!$oes_archive_skipped_posts) $oes_archive_skipped_posts = [];

/* display empty results */
$tableArray = $oes_archive_data['table-array'] ?? [];
if (empty($tableArray) || count($tableArray) == 0) : echo 'No results';

/* loop through table data -------------------------------------------------------------------------------------------*/
else:
    foreach ($tableArray as $characterArray) {

        $thisCharacter = $characterArray['character'] === "#" ?
            'other' :
            strtolower($characterArray['character']);

        /* optional: add additional character */
        $alphabetInitialString = '';
        if ($oes_archive_alphabet_initial && isset($characterArray['character']))
            $alphabetInitialString .= '<div class="oes-alphabet-initial">' . $characterArray['character'] . '</div>';


        /* loop through entries */
        $containerString = '';
        foreach ($characterArray['table'] as $row)
            if (isset($row['id']) && !in_array($row['id'], $oes_archive_skipped_posts)) {

                /* check if title is link */
                $title = ($oes_archive_data['archive']['display_content'] ?? false) ?
                    sprintf('<span class="oes-archive-title" id="%s">%s</span>',
                        $post_type . '-' . $row['id'],
                        $row['title']
                    ) :
                    sprintf('<a href="%s" class="oes-archive-title">%s</a>',
                        $row['permalink'],
                        $row['title']
                    );

                /* check for content */
                $content = ($row['content'] ?? '');

                /* check for archive preview */
                $previewTable = false;
                if (!empty($row['data']))
                    foreach ($row['data'] as $dataRow)
                        if (isset($dataRow['value']) && (!empty($dataRow['value']) && (is_string($dataRow['value'])
                                    && strlen(trim($dataRow['value'])) != 0))) {
                            if (isset($dataRow['label']))
                                $previewTable .= '<tr><th>' .
                                    ($dataRow['label'] ?? 'Label missing') . '</th><td>' .
                                    ($dataRow['value'] ?? '') . '</td></tr>';
                            else
                                $previewTable .= '<tr><th colspan="2">' .
                                    ($dataRow['value'] ?? '') . '</th></tr>';
                        }

                /* display row with preview */
                if ($previewTable)
                    $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-filter-%s">' .
                        '<a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus"></a>' .
                        '%s<table class="oes-archive-table collapse" id="row%s">%s</table></div>',
                        $row['id'],
                        $row['id'],
                        $title . (is_string($row['additional']) ? $row['additional'] : '') . $content,
                        $row['id'],
                        $previewTable);
                elseif (!isset($args['skip-empty']) || !$args['skip-empty'])
                    $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-filter-%s">%s</div>',
                        $row['id'],
                        $title . (empty($row['additional']) || !is_string($row['additional']) ? '' : $row['additional']) . $content
                    );
            }

        printf('<div class="oes-archive-wrapper filter-%s" data-alphabet="%s">%s' .
            '<div class="oes-alphabet-container">%s</div>' .
            '</div>',
            $thisCharacter,
            $thisCharacter,
            $alphabetInitialString,
            $containerString);
    }
endif;