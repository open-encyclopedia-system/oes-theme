<!DOCTYPE HTML>
<html lang="en">
<?php

global $oes_language;
if (empty($oes_language)) $oes_language = 'language0';

get_template_part('template-parts/header', 'head', $args ?? []);

?>
<body <?php body_class(['oes-body-' . $oes_language]); ?>>
<div class="oes-body-wrapper">
    <header class="fixed-top d-print-none"><?php

        get_template_part('template-parts/header', 'navigation'); ?>

    </header><?php

get_template_part('template-parts/search', 'panel', $args ?? []);