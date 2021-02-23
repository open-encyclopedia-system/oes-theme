<?php

/* open table if not only rows*/
if(!$args['only_rows']) :?>
    <table<?php echo isset($args['table_id']) ? ' id="' . $args['table_id'] . '"' : '';?>><?php
endif;

/* add row to table */
    foreach ($args['table_data'] as $row) :

        /* open row */
        ?>
        <tr<?php echo isset($args['tr_class']) ? ' class="' . $args['tr_class'] . '"' : ''; ?>><?php

            /* add cell (label) */
            if (isset($row['label'])) :
                if (is_array($row['label'])) :

                    /* multiple values */
                    foreach ($row['label'] as $entry):?>
                        <th><?php echo $entry; ?></th><?php
                    endforeach;
                else :

                    /* single values */
                    ?>
                    <th><?php echo $row['label']; ?></th><?php
                endif;
            endif;

            /* add cell (value) */
            if (isset($row['value'])) :
                if (is_array($row['value'])) :

                    /* multiple values */
                    foreach ($row['value'] as $entry):?>
                        <td<?php echo isset($args['d_col_span']) ? ' colspan="' . $args['d_col_span'] . '"' : ''; ?>><?php
                            echo $entry; ?>
                        </td><?php
                    endforeach;
                else :

                    /* single value */
                    ?>
                    <td<?php echo isset($args['d_col_span']) ? ' colspan="' . $args['d_col_span'] . '"' : ''; ?>><?php
                        echo $row['value']; ?>
                    </td><?php
                endif;
            endif;

        /* close row */
        ?></tr><?php
    endforeach;

/* close table if not only rows */
if(!$args['only_rows']) :?>
    </table><?php
endif;