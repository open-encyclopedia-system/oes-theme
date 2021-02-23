<?php

/* get the title */
$term = get_queried_object();


/* display header ----------------------------------------------------------------------------------------------------*/
get_header(null,
    [
        'head_text' => 'Keyword - ' . $term->name,
        'header_text' => 'Author Keyword',
        'subheader' => 'title',
        'subheader_args' => ['wrapper_id' => 'single-post-header', 'subheader_title' => $term->name]
    ]);


/* display main content ----------------------------------------------------------------------------------------------*/
?>
<main id="with-subheader">
    <div id="single-post" class="wrapper-main">

        <div class="details"><?php
            if($term->description && !empty($term->description)) :?>
                <h3>Description</h3><?php
                echo $term->description;
            endif;
            ?>
        </div><?php

        /* get contributor relations ---------------------------------------------------------------------------------*/
        global $tableData;
        get_template_part('includes/archive/archive-topic',
            null,
            [
                'taxonomy' => 'oes_demo_tag_topic',
                'term_id' => $term->term_id
            ]
        );

        /* display relations -----------------------------------------------------------------------------------------*/
        if($tableData):?>
            <div>
                <h3><?php _e('Connected Content', 'oes-demo');?></h3><?php

                /* display details */
                get_template_part('template-parts/table/details',
                    null,
                    ['table_data' => $tableData]); ?>
            </div><?php
        else:
            _e('This topic has no related articles.', 'oes-demo');
        endif;

        ?>
    </div>
</main>
<?php


/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();