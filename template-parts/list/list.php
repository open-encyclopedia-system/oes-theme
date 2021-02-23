<?php


/* get post information that are to be displayed in an array */
global $tableArray;


/* wrap list */
?>
<div<?php
echo ' class="' . ($args['wrapper_main_class'] ? $args['wrapper_main_class'] : 'wrapper-main') . '"';
echo ' id="' . ($args['wrapper_main_id'] ? $args['wrapper_main_id'] : 'archive') . '"'; ?>><br><?php

/* loop through table data -------------------------------------------------------------------------------------------*/
foreach ($tableArray as $characterArray) :

    /* open new list */
    ?>
    <div class="wrapper" id="<?php echo $args['wrapper_id']; ?>"><?php
    if ($args['add_alphabet'] && isset($characterArray['character'])) :?>
        <div class="alphabet-initial"><?php echo $characterArray['character']; ?></div><?php
    endif; ?>
    <div class="list-entry">
        <?php

        /* loop through entries */
        foreach ($characterArray['table'] as $row) :

            /* new entry */
            ?>
            <div class="list-title"><?php

                if ($args['title_is_link']) :?>
                    <a href="<?php echo $row['permalink']; ?>"><?php echo $row['title']; ?></a><?php
                else: ?>
                    <?php echo $row['title']; ?><?php
                endif;

                if (isset($row['subtitle'])) :?>
                    <span class="subtitle"><?php echo $row['subtitle']; ?></span>
                <?php
                endif;

                if (isset($row['title_right'])) :?>
                    <span class="title_right"><?php echo $row['title_right']; ?></span>
                <?php
                endif;

                ?>
            </div>
            <div class="list-body"><?php

                $argsDetails = array_merge($args['display_table_args'], ['table_data' => $row['data'], 'table_id' => $args['table_id']]);
                get_template_part('template-parts/table/details', null, $argsDetails);

                ?>
            </div>
        <?php

        endforeach;
        ?></div>
    </div><?php

endforeach;

/* close wrapper */
?></div><?php