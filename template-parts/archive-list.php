<?php

/* check if list already displayed (used by other plugins such as OES Timeline, OES Map) */
global $oes_archive_displayed;
$oes_archive_displayed = false;

/* call hook or get template (return $oes_archive_displayed) */
do_action('oes/theme_archive_list');

if (!$oes_archive_displayed):

    global $post_type, $oes_archive_data, $oes_archive_alphabet_initial, $oes_archive_skipped_posts, $oes_language;
    if (!$oes_archive_skipped_posts) $oes_archive_skipped_posts = [];

    /* display empty results */
    if (empty($oes_archive_data) || count($oes_archive_data) == 0) :
        echo oes_get_label('no_results_found', 'No results.');

    /* loop through table data -------------------------------------------------------------------------------------------*/
    else:
        foreach ($oes_archive_data as $characterArray) {

            $thisCharacter = $characterArray['character'] === "#" ?
                'other' :
                strtolower($characterArray['character']);

            /* optional: add additional character */
            $alphabetInitialString = '';
            if ($oes_archive_alphabet_initial && isset($characterArray['character']))
                $alphabetInitialString .= '<div class="oes-alphabet-initial">' . $characterArray['character'] . '</div>';


            /* loop through entries */
            $containerString = '';
            foreach ($characterArray['table'] ?? [] as $row)
                if (isset($row['id']) && !in_array($row['id'], $oes_archive_skipped_posts)) {

                    /* check if title is link */
                    $title = (isset($oes_archive_data['archive']) &&
                        (($oes_archive_data['archive']['display_content'] ?? false) ||
                        (!$oes_archive_data['archive']['title_is_link'] ?? false))) ?
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
                                        $dataRow['value'] . '</td></tr>';
                                else
                                    $previewTable .= '<tr><th colspan="2">' . $dataRow['value'] . '</th></tr>';
                            }

                    /* display row with preview */
                    if ($previewTable)
                        $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s">' .
                            '<div class="oes-post-filter-wrapper-toggles">' .
                            '<a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus oes-toggle-down-before"></a>' .
                            '%s' .
                            '</div>' .
                            '<div class="oes-archive-table-wrapper collapse" id="row%s"><table class="oes-archive-table oes-simple-table">%s</table></div></div>',
                            oes_get_post_language($row['id']) ?: 'all',
                            $row['id'],
                            $row['id'],
                            $title . (is_string($row['additional']) ? $row['additional'] : '') . $content,
                            $row['id'],
                            $previewTable);
                    elseif (!isset($args['skip-empty']) || !$args['skip-empty'])
                        $containerString .= sprintf('<div class="oes-post-filter-wrapper oes-post-%s oes-post-filter-%s">%s</div>',
                            oes_get_post_language($row['id']) ?: 'all',
                            $row['id'],
                            $title . (empty($row['additional']) || !is_string($row['additional']) ? '' : $row['additional']) . $content
                        );
                }

            if (!empty($containerString))
                printf('<div class="oes-archive-wrapper" data-alphabet="%s">%s' .
                    '<div class="oes-alphabet-container">%s</div>' .
                    '</div>',
                    $thisCharacter,
                    $alphabetInitialString,
                    $containerString);
        }
    endif;
endif;