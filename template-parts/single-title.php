<?php
global $oes, $oes_post, $oes_language, $oes_container_class;

/* Prepare archive link */
$archiveLink = get_post_type_archive_link($oes_post->post_type);

$archiveLinkText = sprintf('<a href="%s">%s</a>',
    $archiveLink,
    ($oes->post_types[$oes_post->post_type]['label_translations'][$oes_language] ??
        ($oes->post_types[$oes_post->post_type]['theme_labels']['archive__header'][$oes_language] ??
        $oes_post->post_type_label))
    );

?>
<div class="oes-subheader">
    <div class="oes-subheader-title-container oes-show-on-shrink">
        <div class="<?php echo $oes_container_class ?? ''; ?>">
            <span class="oes-page-title"><?php echo $archiveLinkText;?></span>
            <span class="oes-page-title-text"><?php

                if(method_exists($oes_post, 'get_html_short_title')):
                    echo $oes_post->get_html_short_title();
                else:
                    echo $oes_post->get_title();
                endif;

                ?></span>
        </div>
    </div>
    <div class="oes-subheader-title-container oes-default">
        <div class="<?php echo $oes_container_class ?? ''; ?>">
            <div class="oes-page-title print-black"><?php echo $archiveLinkText;?></div>
        </div>
    </div><?php

    if($oes_post->has_theme_subtitle && method_exists($oes_post, 'get_html_sub_header')):
        echo $oes_post->get_html_sub_header();
    endif;

    ?>
</div>