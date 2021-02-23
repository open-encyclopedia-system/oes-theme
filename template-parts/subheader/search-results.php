<section id="subheader">
    <div id="wrapper-flex" class="wrapper-main">
        <?php

        /* get result count */
        global $count;
        if ($count) : ?>
            <div class="result-text"><?php
                printf(__('Results for  \'%s\' :', 'oes-demo'), get_search_query()); ?></div>
            <div class="display-entry-count"><?php
            echo $count . ($count > 1 ? ' Entries' : ' Entry'); ?></div><?php

        /* no results */
        else:?>
            <div class="result-text"><?php
            printf(__('No results for  \'%s\'.', 'oes-demo'), get_search_query()); ?></div><?php
        endif; ?>
    </div>
</section>