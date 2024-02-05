<div id="oes-search-panel" <?php if (isset($args['show-search']) && $args['show-search']) echo 'style="display:block;"'; ?>>
    <div class="oes-search-panel-background"></div>
    <div class="oes-search-panel-front">
        <div class="oes-search-panel-form container text-center">
            <h1><?php

                if (isset($args['search-text']) && $args['search-text']) echo $args['search-text'];
                else echo oes_get_label('search__navigation__text', 'Search the OES Encyclopedia');

                ?>
            </h1>
            <div><?php get_search_form(); ?></div>
        </div>
    </div>
</div>