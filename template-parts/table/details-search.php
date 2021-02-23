<table id="nested-table"><?php

    /* loop through results for a single post */
    foreach ($args['data'] as $row) :?>
        <tr>
            <td id="before"></td><?php

                /* add header cells (th) */
                if (is_array($row['th'])) :
                    foreach ($row['th'] as $entry):?>
                        <th id="third"><?php echo $entry; ?></th><?php
                    endforeach;
                else :?>
                    <th id="third"><?php echo $row['th']; ?></th><?php
                endif; ?><?php

                /* add normal cells (td) */
                if (is_array($row['td'])) :
                    foreach ($row['td'] as $entry):?>
                        <td id="two-third"><?php echo $entry; ?></td><?php
                    endforeach;
                else :?>
                    <td id="two-third"><?php echo $row['td']; ?></td><?php
                endif; ?>
        </tr><?php
    endforeach; ?>
</table>