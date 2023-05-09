<div class="oes-sidebar-toggle oes-toggle-down">
    <a href="#oes-sidebar" data-toggle="collapse" aria-expanded="false" class="oes-archive-plus collapsed"><?php

        global $oes, $oes_nav_language;
        echo($oes->theme_labels['sidebar__archive_header__refine_search'][$oes_nav_language] ??
            __('Expand Sidebar', 'oes'));?></a>
</div>
<div id="oes-sidebar" class=""><?php oes_display_sidebar('oes-search-sidebar'); ?></div>