<?php

/* get current active page -------------------------------------------------------------------------------------------*/
global $wp;
$currentPage = home_url($wp->request);


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <title><?php echo $args['head_text'] ? $args['head_text'] : "OES DEMO"; ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a name="top"></a>
<div id="body-wrap">
    <header class="oes-demo">
        <div class="wrapper-basic">
            <div id="header-top" class="wrapper-container">
                <div id="header-left" class="wrapper-item">
                    <div id="header-left-container" class="wrapper">
                        <div class="wrapper-item">
                            <div class="wrapper">
                                <a href="<?php echo home_url(); ?>">
                                    <picture>
                                        <source media="(max-width: 1200px)"
                                                srcset="<?php
                                                echo get_template_directory_uri();
                                                ?>/assets/images/oes-demo_logo_RGB-b.png">
                                        <img src="<?php echo get_template_directory_uri();
                                        ?>/assets/images/oes-demo_logo_RGB-a.png"
                                             alt="oesLogo"
                                             id="header-home"
                                        >
                                    </picture>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="header-right" class="wrapper-item">
                    <span id="navigation">
                        <div class="dropdown-base">
                            <a class="check-if-active"
                               href="<?php echo get_permalink(get_page_by_path('oes-demo-about')); ?>"><?php
                                _e('About OES Demo', 'oes-demo');?>
                            </a>
                        </div>
                    </span>
                    <span id="navigation">
                        <div class="dropdown-base">
                            <a class="check-if-active"
                               href="<?php echo get_post_type_archive_link('oes_demo_contributor'); ?>"><?php
                                _e('Contributors', 'oes-demo');?>
                            </a>
                        </div>
                    </span>
                    <span class="dropdown" id="navigation">
                        <div class="dropdown-base">
                            <a class="check-if-active"
                               href="<?php echo get_post_type_archive_link('oes_demo_article'); ?>"><?php
                                _e('Articles', 'oes-demo');?>
                            </a>
                        </div>
                        <div class="dropdown-content">
                            <?php

                            /* check for article categories */
                            $categories = get_terms(['taxonomy' => 'oes_demo_tag_category', 'orderby' => 'slug']);
                            foreach ($categories as $category) : ?>
                                <a class="check-if-active"
                                   href="<?php echo get_post_type_archive_link('oes_demo_article') .
                                       '?category=' . $category->slug; ?>"><?php echo $category->name; ?></a>
                            <?php
                            endforeach; ?>
                        </div>
                    </span>
                    <span id="navigation">
                        <div class="dropdown-base">
                            <a class="check-if-active"
                               href="<?php echo get_post_type_archive_link('oes_demo_glossary'); ?>"><?php
                                _e('Glossary', 'oes-demo');?>
                            </a>
                        </div>
                    </span>
                    <span class="dropdown" id="navigation"><?php

                        /* Include index navigation, check if active page is index page ------------------------------*/
                        $indexPageClass = 'check-if-active';
                        foreach (['oes_index_person', 'oes_index_place', 'oes_index_time', 'oes_index_subject'] as $indexType) :
                            $link = get_post_type_archive_link($indexType);
                            if ($link == $currentPage) $indexPageClass = 'active';
                        endforeach;
                        ?>
                        <div class="dropdown-base">
                            <a class="<?php echo $indexPageClass; ?>"
                               href="<?php echo get_permalink(get_page_by_path('oes-demo-index')); ?>"><?php
                                _e('Index', 'oes-demo');?>
                            </a>
                        </div>
                        <div class="dropdown-content" id="index"><?php

                            if (get_post_type_object('oes_index_person')->show_in_nav_menus) : ?>
                                <a href="<?php echo get_post_type_archive_link('oes_index_person'); ?>"
                                   class="check-if-active"><?php _e('People', 'oes-demo'); ?>
                                </a><?php
                            endif;

                            if (get_post_type_object('oes_index_institute')->show_in_nav_menus) : ?>
                                <a href="<?php echo get_post_type_archive_link('oes_index_institute'); ?>"
                                   class="check-if-active"><?php _e('Institutions', 'oes-demo'); ?>
                                </a><?php
                            endif;

                            if (get_post_type_object('oes_index_place')->show_in_nav_menus) : ?>
                                <a href="<?php echo get_post_type_archive_link('oes_index_place'); ?>"
                                   class="check-if-active"><?php _e('Places', 'oes-demo'); ?>
                                </a><?php
                            endif;

                            if (get_post_type_object('oes_index_time')->show_in_nav_menus) : ?>
                                <a href="<?php echo get_post_type_archive_link('oes_index_time'); ?>"
                                   class="check-if-active"><?php _e('Times', 'oes-demo'); ?>
                                </a><?php
                            endif;

                            if (get_post_type_object('oes_index_subject')->show_in_nav_menus) : ?>
                                <a href="<?php echo get_post_type_archive_link('oes_index_subject'); ?>"
                                   class="check-if-active"><?php _e('Subjects', 'oes-demo'); ?>
                                </a><?php
                            endif;

                            ?>
                        </div>
                    </span><?php

                    /* Include search, check if active page is search page -------------------------------------------*/
                    $searchFormActive = (home_url() == $currentPage) ? ' class="search-active"' : ''; ?>
                    <span id="nav-search">
                        <a<?php echo $searchFormActive; ?>><?php get_search_form(); ?></a>
                    </span>
                </div>
            </div>
            <div id="header-bottom">
                <div class="wrapper-container"><?php echo $args['header_text']; ?></div>
            </div>
            <?php

            /* Include subheader -------------------------------------------------------------------------------------*/
            if ($args['subheader']) get_template_part('template-parts/subheader/' . $args['subheader'], null, $args['subheader_args']);
            if ($args['sub_subheader']) get_template_part('template-parts/subheader/' . $args['sub_subheader'], null, $args['sub_subheader_args']);

            ?>
        </div>
    </header>
    <main class="wrapper-basic" id="main-scrollable">