<?php

/**
 * Class OES_Demo_Glossary_Entry
 */
if (!class_exists('\OES\Theme\OES_Post_Type_Theme')) :
    class OES_Demo_Glossary {}
else :

class OES_Demo_Glossary extends \OES\Theme\OES_Post_Type_Theme
{

    // Overwrite parent function
    function get_html_main($pdf = false){

        /* add footnotes */
        $mainContent = $this->fields['oes_demo_glossary_content']['value-display'];
        $mainContent .= $this->get_html_footnotes($mainContent);

        return sprintf('<main id="with-subheader"><div id="single-post" class="wrapper-main"><div class="details">' .
            '%1s<br>%2s</div></div></main>',
            $mainContent,
            $this->get_html_meta_data(['display-header' => false]) . $this->get_html_topics(['oes_demo_tag_topic'])
        );
    }

}

endif;