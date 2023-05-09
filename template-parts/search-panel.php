<div id="oes-search-panel" <?php if (isset($args['show-search']) && $args['show-search']) echo 'style="display:block;"'; ?>>
    <div class="oes-search-panel-background"></div>
    <div class="oes-search-panel-front">
        <div class="oes-search-panel-form container text-center">
            <h1><?php

                global $oes_nav_language;
                if (isset($args['search-text']) && $args['search-text']) echo $args['search-text'];
                else echo($oes->theme_labels['search__navigation__text'][$oes_nav_language] ??
                    __('Search the OES Encyclopedia', 'oes'));

                ?>
            </h1>
            <div><?php get_search_form(); ?></div>
        </div>
    </div>
</div>