<table id="search-table">
    <tr>
        <th id="before"></th>
        <th id="third"><?php _e('Name', 'oes-demo'); ?></th>
        <th id="third"><?php _e('Type', 'oes-demo'); ?></th>
        <th id="third"><?php _e('Occurrences', 'oes-demo'); ?></th>
    </tr><?php

    /* loop through results */
    global $tableArray;
    foreach ($tableArray as $characterArray) :
        foreach ($characterArray['table'] as $row) :?>
            <tr>
                <td id="before" class="search-accordion">
                    <a><div class="search-toggle"></div></a>
                </td>
                <td><?php
                    if ($args['title_is_link']) :?>
                        <a href="<?php echo $row['permalink']; ?>"><?php echo $row['title']; ?></a><?php
                    else: ?>
                        <?php echo $row['title']; ?><?php
                    endif; ?>
                </td>
                <td><?php echo $row['post_type_label']; ?></td>
                <td><?php echo $row['occurrences']; ?></td>
            </tr>
            <tr class="search-accordion-panel">
            <td colspan="4" id="nested"><?php
                get_template_part('template-parts/table/details-search', null, ['data' => $row['data']]); ?>
            </td>
            </tr><?php
        endforeach;
    endforeach; ?>
</table>