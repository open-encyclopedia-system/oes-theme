<?php

/* get generated alphabet information */
global $alphabetArray;

/* get post count for display */
global $count;

get_template_part('includes/alphabet/alphabet');

?>
<section id="<?php echo $args['section_id']; ?>">
    <div id="wrapper-flex" class="wrapper-main">
        <div class="wrapper">
            <div class="wrapper-block"><?php
            if ($alphabetArray) :
                ?><ul id="vertical-filter"><?php
                    foreach ($alphabetArray as $item) :
                        ?><li<?php echo isset($item['style']) ? $item['style'] : ''; ?>><?php
                            echo isset($item['content']) ? $item['content'] : '';
                        ?></li><?php
                    endforeach;
                ?></ul><?php
            endif;
            ?></div><?php
            if ($count) :
                ?><div class="display-entry-wrapper">
                    <div class="display-entry-count"><?php
                        echo $count . ($count > 1 ? ' Entries' : ' Entry'); ?>
                    </div>
                </div><?php
            endif;?>
        </div>
    </div>
</section>