<?php

$image = $args['image'];

if ($image['ID']):
    $imageID = $image['ID'];

    /* prepare image data --------------------------------------------------------------------------------------------*/

    /* get options */
    $imageFieldsOption = get_option(OES\Config\Option::IMAGE);

    /* get image media license */
    $mediaLicenseValue = null;
    if (!empty(oes_get_post_meta($imageID, 'oes_media_license'))) :
        $mediaLicense = oes_get_post_meta($imageID, 'oes_media_license', true);
        $mediaLicenseValue =sprintf(__('<a href="%1s" %2s>%3s</a>', 'oes-demo'),
            $mediaLicense['url'],
            $mediaLicense['target'] ? ' target="_blank"' : '',
            $mediaLicense['title'] ? $mediaLicense['title'] : $mediaLicense['url']
        );
    endif;

    /* get image author attribution */
    $authorAttributionValue = null;
    if (!empty(oes_get_post_meta($imageID, 'oes_media_author_attribution'))) :
        $authorAttribution = oes_get_post_meta($imageID, 'oes_media_author_attribution', true);
        $authorAttributionValue =sprintf(__('<a href="%1s" %2s>%3s</a>', 'oes-demo'),
            $authorAttribution['url'],
            $authorAttribution['target'] ? ' target="_blank"' : '',
            $authorAttribution['title'] ? $authorAttribution['title'] : $authorAttribution['url']
        );
    endif;

    $imageOptions = [
            'title' => ['Title', $image['title']],
        'alt' => ['Alternative Text', oes_get_post_meta($imageID, '_wp_attachment_image_alt', true)],
        'caption' => ['Caption', $image['caption']],
        'description' => ['Description', $image['description']],
        'date' => ['Publication Date',
            date("j F Y", strtotime(str_replace('/', '-', $image['date'])))],
        'oes_media_license' => ['Media License', $mediaLicenseValue],
        'oes_media_author_attribution' => ['Author Attribution', $authorAttributionValue]
    ];

    $subtitleArray = null;
    $table = null;
    foreach($imageOptions as $key => [$label, $value]) :
        if (!empty($value)):
            /* add to subtitle */
            if($imageFieldsOption[$key . '_show_in_subtitle'])
                $subtitleArray[] = $imageFieldsOption[$key . '_prefix'] . $value;

            /* add to panel */
            if($imageFieldsOption[$key . '_show_in_panel']) :
                $newLabel = $imageFieldsOption[$key . '_new_label'] ? $imageFieldsOption[$key . '_new_label'] : $label;
                $table[$newLabel] = $value;
            endif;

        endif;
    endforeach;

    /* add credit link */
    $imageFieldsCreditOption = get_option(OES\Config\Option::IMAGE_CREDIT);

    /* check if link should be included in subtitle */
    if($imageFieldsCreditOption['include_credit_link']):

        $creditText = '';

        /* check for credit label */
        $creditLabel = $imageFieldsCreditOption['credit_label'];

        if($creditLabel) :
            $creditText .= $imageFieldsCreditOption['credit_label'];
        endif;

        /* check for link text */
        $creditField = $imageFieldsCreditOption['credit_text'];

        if(!empty($creditField) && $creditField != 'none') :
            $creditText .= $imageOptions[$creditField][1];
        endif;

        if(empty($creditText)) $creditText = 'Image Credit';

        /* add to subtitle */
        $subtitleArray[] = '<a id="expand-image-credit">' . $creditText . '</a>';

    endif;

    $imageSubtext = empty($subtitleArray) ? '' : implode('<br>', $subtitleArray);


    ?>

<figure id="expand-image-container">
    <img id="expand-image" src="<?php echo $image['url']; ?>" alt="todo">
    <figcaption><p><?php echo $imageSubtext;?></p></figcaption>
    <div id="expand-image-modal" class="modal-container">
        <span class="expand-image-close">&times;</span>
        <div id="modal-image-container"><img class="modal-content-oes" id="modal-image" alt="todo"></div>
        <div id="modal-content-text">
            <div class="details">
                <table id="table-pop-up"><?php
                    if(!empty($table)) :
                    foreach ($table as $description => $value) :
                        ?>
                        <tr>
                        <th><?php echo $description; ?></th>
                        <td><?php echo $value; ?></td></tr><?php
                    endforeach;
                    endif;?>
                </table>
            </div>
        </div>
    </div>
</figure><?php
endif; ?>