<!DOCTYPE HTML>
<html lang="en">
<?php

global $oes_nav_language;
if (empty($oes_nav_language)) $oes_nav_language = 'language0';

get_template_part('template-parts/header', 'head');

?>
<body <?php body_class(['oes-body-' . $oes_nav_language]); ?>>
<div class="oes-body-wrapper">
    <header class="fixed-top d-print-none"><?php

        get_template_part('template-parts/header', 'navigation'); ?>

    </header><?php

get_template_part('template-parts/search', 'panel');