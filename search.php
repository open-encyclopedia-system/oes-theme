<?php


/* prepare results for display ---------------------------------------------------------------------------------------*/
get_template_part('includes/table/table-search', null, ['post_type' => OES_Project_Config::POST_TYPE_ALL]);


/* display header ----------------------------------------------------------------------------------------------------*/

//TODO @2.0 Roadmap : Replace with Referer?
$slug = '?' . (isset($_GET['s']) ? 's=' . $_GET['s'] : '')  . (isset($_GET['page_id']) ? '&page_id=' . $_GET['page_id'] : '');

get_header(null,
    [
        'head_text' => 'OES Demo: Search',
        'header_text' => sprintf(__('Results for  \'%s\' :', 'oes-demo'), get_search_query()),
        'subheader' => 'search-results',
        'subheader_args' => ['slug' => $slug]
    ]);

/* display results ---------------------------------------------------------------------------------------------------*/
?>
<main id="with-subheader">
        <div class="wrapper-main" id="search">
            <?php

            /* display table list ------------------------------------------------------------------------------------*/
            global $count;
            if($count != 0) get_template_part('template-parts/list/accordion-in-list',
                null,
                ['title_is_link' => true]);
            ?>
        </div>
    </main>
<?php

/* display footer ----------------------------------------------------------------------------------------------------*/
get_footer();