<?php

global $oes, $oes_nav_language;

$homeURL = '';
if ($oes_nav_language != $oes->main_language)
    $homeURL = strtolower($oes->languages[$oes_nav_language]['abb'] ?? '');
if (empty($oes_nav_language)) $oes_nav_language = 'language0';

$homeLogo = get_option('oes_theme-header_logo');
$homeLogoSrc = (!empty($homeLogo) ?
    $homeLogo :
    get_stylesheet_directory_uri() . '/assets/images/oes-home-logo.png');

$homeLogoPrint = get_option('oes_theme-header_logo_print');
$homeLogoPrintSrc = (!empty($homeLogoPrint) ?
    $homeLogoPrint :
    get_stylesheet_directory_uri() . '/assets/images/oes-home-logo.png');

?>
<nav class="container navbar navbar-expand-lg navbar-light">
    <div class="oes-home-logos">
        <div class="oes-home-logo-online">
            <a href="<?php echo home_url($homeURL); ?>" class="navbar-brand">
                <picture><img src="<?php echo $homeLogoSrc; ?>" alt="Logo" class="oes-home-img"></picture>
            </a>
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#oes-top-menus"
            aria-controls="oes-top-menus" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="oes-top-menus">
        <div class="oes-top-menu-container">
            <div id="oes-utility-nav"><?php

                if (has_nav_menu('oes-utility-menu-' . $oes_nav_language))
                    wp_nav_menu([
                        'theme_location' => 'oes-utility-menu-' . $oes_nav_language,
                        'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                    ]);

                ?>
            </div>
            <div id="oes-main-nav"><?php

                if (has_nav_menu('oes-header-menu-' . $oes_nav_language))
                    wp_nav_menu([
                        'theme_location' => 'oes-header-menu-' . $oes_nav_language,
                        'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                    ]);

                ?>
            </div>
        </div>
    </div>
</nav>
<div class="d-none d-print-block">
    <picture><img src="<?php echo $homeLogoPrintSrc; ?>" alt="Logo" class="oes-home-img"></picture>
</div>