<?php
global $taxonomy, $oes, $oes_term, $oes_container_class, $oes_language;

/* Prepare archive link */
$archiveLink = $taxonomy;
if ($taxonomyObject = get_taxonomy($taxonomy))
    $archiveLink = sprintf('<a href="%s">%s</a>',
        (get_site_url() . '/' . $taxonomyObject->rewrite['slug'] . '/'),
        ($oes->taxonomies[$taxonomy]['label_translations'][$oes_language] ??
            ($oes->taxonomies[$taxonomy]['label_translations'][$oes_language] ??
            ($oes->taxonomies[$taxonomy]['label'] ?: $taxonomyObject->label)))
    );


?>
<div class="oes-subheader d-print-none">
        <div class="oes-subheader-title-container">
        <div class="<?php echo $oes_container_class ?? ''; ?>">
            <div class="oes-page-title print-black"><?php echo $archiveLink;?></div>
        </div>
    </div><?php

    if($oes_term->has_theme_subtitle && method_exists($oes_term, 'get_html_sub_header')):
        echo $oes_term->get_html_sub_header();
    endif;

    ?>
</div>