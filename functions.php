<?php


/* load style sheets -------------------------------------------------------------------------------------------------*/

function load_css()
{
    wp_enqueue_style('oes-demo-style', get_stylesheet_uri(), [], false, 'all');

    wp_register_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', [], false, 'all');
    wp_enqueue_style('font-awesome');

    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', [], false, 'all');
    wp_enqueue_style('bootstrap');

}

add_action('wp_enqueue_scripts', 'load_css');


/* load script sheets ------------------------------------------------------------------------------------------------*/
function load_js()
{
    wp_enqueue_script('jquery');

    wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', 'jquery', false, true);
    wp_enqueue_script('bootstrap');

    wp_register_script('oes-demo-theme', get_template_directory_uri() . '/assets/js/oes-demo.js', 'jquery', false, true);
    wp_enqueue_script('oes-demo-theme');
}

add_action('wp_enqueue_scripts', 'load_js');


/* theme options -----------------------------------------------------------------------------------------------------*/
/* Nothing and that's absolutely right. */


/* include post classes ----------------------------------------------------------------------------------------------*/
require get_template_directory() . '/project/post/article.class.php';
require get_template_directory() . '/project/post/contributor.class.php';
require get_template_directory() . '/project/post/glossary.class.php';
require get_template_directory() . '/project/post/index.class.php';


/* add fav icon for pages --------------------------------------------------------------------------------------------*/
if (function_exists('oes_theme_add_favicon')) {
    oes_theme_add_favicon(get_template_directory_uri() . '/assets/images/favicon.ico');
}


/* modify wordpress search -------------------------------------------------------------------------------------------*/
if (function_exists('oes_theme_modify_search')) {
    oes_theme_modify_search();
}