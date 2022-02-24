<?php
global $post_type;

/* display empty results */
$tableArray = $args['data'] ?? [];
if (empty($tableArray) || count($tableArray) == 0) : echo 'No results';

/* loop through table data ---------------------------------------------------------------------------------------*/
else:
    foreach ($tableArray as $characterArray) :?>
        <div class="oes-archive-wrapper filter-<?php echo($characterArray['character'] === "#" ?
            'other' :
            strtolower($characterArray['character'])); ?>"><?php

        /* add initial character */
        if (isset($args['add-alphabet']) && $args['add-alphabet'] && isset($characterArray['character'])) :?>
            <div class="oes-alphabet-initial"><?php echo $characterArray['character']; ?></div><?php
        endif;

        /* add container for character */
        ?>
        <div class="oes-alphabet-container"><?php

            /* loop through entries */
            foreach ($characterArray['table'] as $row) {

                /* check if title is link */
                $title = (isset($args['title-is-link']) && $args['title-is-link']) ?
                    sprintf('<a href="%s" class="oes-archive-title">%s</a>',
                        $row['permalink'],
                        $row['title']
                    ) :
                    sprintf('<span class="oes-archive-title" id="%s">%s</span>',
                        $post_type . '-' . $row['id'],
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
                    printf('<div class="oes-post-filter-wrapper oes-post-filter-%s">' .
                        '<a href="#row%s" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus"></a>' .
                        '%s<table class="oes-archive-table collapse" id="row%s">%s</table></div>',
                        $row['id'],
                        $row['id'],
                        $title . $row['additional'] . $content,
                        $row['id'],
                        $previewTable);
                else
                    printf('<div class="oes-post-filter-wrapper oes-post-filter-%s">%s</div>',
                        $row['id'],
                        $title . (empty($row['additional']) ? '' : $row['additional']) . $content
                    );
            }
            ?>
        </div>
        </div><?php
    endforeach;
endif;