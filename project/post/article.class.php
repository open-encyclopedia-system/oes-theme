<?php

use OES\Config\Post_Type;
use function OES\ACF\get_acf_field;

/**
 * Class OES_Demo_Article
 */
if (!class_exists('\OES\Theme\OES_Post_Type_Theme')) :
    class OES_Demo_Article {}
else :

class OES_Demo_Article extends \OES\Theme\OES_Post_Type_Theme
{

    // Overwrite jump icon
    protected $tableOfContentJumpIcon = '<i class="fa fa-angle-double-up" aria-hidden="true" id="toc-icon"></i>';

    var $translation = false;

    // Overwrite parent function
    function set_fields($overwrite = false)
    {
        /* Set all fields according to the configuration inside the admin panel. */
        parent::set_fields($overwrite);

        /* Overwrite licence field to be displayed as link. */
        $this->set_single_field('oes_demo_article_licence_type', ['link' => true]);

        /* Check if post is translation */
        $this->translation = !empty(OES\Versioning\get_origin_version_id($this->postID));
    }


    // Overwrite parent function
    function get_html_main($args = [])
    {
        /* prepare data to be displayed after table of content -------------------------------------------------------*/
        /* This needs to be generated first to include headings for the table of content. */

        /* add content, meta data and topics */
        $dataAfterToC = $this->get_html_content() .
            $this->get_html_meta_data($this->translation ? ['display-header' => 'Metadaten'] : []) .
            $this->get_html_topics(['oes_demo_tag_topic']);


        /* build html string for output ------------------------------------------------------------------------------*/

        /* content contains of sub line, table of content and prepared data after table of content */
        $prepareString = $this->get_html_sub_line()
            . $this->get_html_table_of_content($this->translation ? ['toc-header' => 'Inhaltsverzeichnis'] : [])
            . $dataAfterToC;


        /* return whole string ---------------------------------------------------------------------------------------*/
        return $args['include-wrapper'] ?
            '<main id="with-subheader"><div id="single-post" class="wrapper-main">' . $prepareString . '</div></main>' :
            $prepareString;
    }


    /**
     * Display sub line.
     */
    function get_html_sub_line()
    {

        /* first line ------------------------------------------------------------------------------------------------*/
        $firstLine = '';

        /* display authors */
        if ($this->check_if_field_not_empty('oes_demo_article_author')) {

            $firstLine = sprintf('<div class="authors"><span id="%1s">%2s%3s</span>%4s</div>',
                $this->pdf ? 'replace-ul' : 'author-by',
                $this->translation ? 'Von' : 'By',
                $this->pdf ? '&nbsp;' : '',
                $this->pdf ? $this->pdf_list_array($this->fields['oes_demo_article_author']['value']) :
                    $this->fields['oes_demo_article_author']['value-display']
            );
        }

        /* second line -----------------------------------------------------------------------------------------------*/
        $secondLine = '';

        /* prepare information for display */
        $furtherInformation = [];

        /* prepare version list */
        if ($this->check_if_field_not_empty(Post_Type::ACF_FIELD_VERSION)) {

            /* get current version */
            $label = 'Version ';
            $value = $this->fields[Post_Type::ACF_FIELD_VERSION]['value-display'];


            /* check if there are more versions, skip if pdf display */
            if ($this->masterID && !$this->pdf) {

                /* get all versions connected to the master post */
                $allVersions = $this->get_all_versions();

                /* add each version to the version dropdown */
                if (!empty($allVersions)) {

                    /* prepare selection values */
                    $selectLabels = '';
                    foreach ($allVersions as $version) {
                        $selectLabels .= sprintf('<a href="%1s">Version %2s</a>',
                            $version['permalink'],
                            $version['version']
                        );
                    }

                    /* prepare base for dropdown */
                    $label = sprintf('<span class="dropdown">' .
                        '<div class="dropdown-base"><a>Version %1s ' .
                        '<i class="fa fa-angle-double-down" aria-hidden="true"></i></a></div>' .
                        '<div class="dropdown-content" id="version">%2s</div></span>',
                        $this->fields[Post_Type::ACF_FIELD_VERSION]['value-display'],
                        $selectLabels
                    );

                    /* unset value */
                    $value = '';
                }
            }

            /* add information for second line */
            $furtherInformation[] = [
                'label' => $label,
                'value-display' => $value
            ];

            /* get latest change date and add information for second line, if empty check for publication date */
            if ($this->check_if_field_not_empty('oes_demo_article_latest_change')) {
                $furtherInformation[] = $this->fields['oes_demo_article_latest_change'];
            } elseif ($this->check_if_field_not_empty('oes_demo_article_pub_date')) {
                $furtherInformation[] = $this->fields['oes_demo_article_pub_date'];
            }
        } /* if no version exists, get publication date and add information for second line*/
        else {
            if ($this->check_if_field_not_empty('oes_demo_article_pub_date')) {
                $furtherInformation[] = $this->fields['oes_demo_article_pub_date'];
            }
        }

        /* get doi and add information for second line */
        if ($this->check_if_field_not_empty('oes_demo_article_doi_system')) {
            $furtherInformation[] = $this->fields['oes_demo_article_doi_system'];
        }

        /* display further information */
        if (!empty($furtherInformation)) {

            /* prepare information */
            $secondLineContent = '';
            foreach ($furtherInformation as $key => $info) {

                /* check if first element */
                reset($furtherInformation);

                if ($this->pdf) {
                    $secondLineContent .= sprintf('%1s<span class="replace-ul">%2s %3s</span>',
                        ($key === key($furtherInformation)) ? '' : '   |   ',
                        $info['label'],
                        $info['value-display']
                    );
                } else {
                    $secondLineContent .= sprintf('<li>%1s %2s</li>',
                        $info['label'],
                        $info['value-display']
                    );
                }
            }

            $secondLine .= sprintf('<div class="status">%1s</div>',
                $this->pdf ? $secondLineContent : '<ul id="value-list-id">' . $secondLineContent . '</ul>'
            );

        }

        return '<div class="sub-line">' . $firstLine . $secondLine . '</div>';
    }


    // Overwrite parent function
    function get_html_content()
    {

        /* main content ----------------------------------------------------------------------------------------------*/
        $mainContent = '';
        if ($this->check_if_field_not_empty('oes_demo_article_content')) {

            /* replace header tags in content with frontend header for table of content */
            $mainContent = sprintf('<div class="content">%s</div>',
                $this->replace_header_tags_in_string($this->fields['oes_demo_article_content']['value'])
            );
        }

        /* related links ---------------------------------------------------------------------------------------------*/
        $relatedLinks = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($this->check_if_field_not_empty('oes_demo_article_related_link_' . $i)) {

                /* add link with icon */
                $relatedLinks .= sprintf('<li><a href="%1s/" target="%2s" rel="noopener">' .
                    '<i class="fa fa fa-chevron-right" style="padding-right:.5rem;"></i>%3s</a></li>',
                    $this->fields['oes_demo_article_related_link_' . $i]['value']['url'],
                    $this->fields['oes_demo_article_related_link_' . $i]['value']['target'],
                    $this->fields['oes_demo_article_related_link_' . $i]['value']['title']
                );
            }
        }
        /* wrap list */
        if ($relatedLinks) $mainContent .= sprintf('<ul id="related-links">%s</ul>', $relatedLinks);


        /* footnotes -------------------------------------------------------------------------------------------------*/
        $mainContent .= $this->get_html_footnotes($mainContent, $this->translation ? 'Endnoten' : false);


        /* bibliographic entries -------------------------------------------------------------------------------------*/
        $bibliographicEntries = '';

        /* get bibliographic entries */
        if ($this->check_if_field_not_empty('oes_demo_article_biblio')) {

            /* collect all bibliographic entries */
            $bibliographicEntriesList = [];
            foreach ($this->fields['oes_demo_article_biblio']['value'] as $entry) {

                /* get information from bibliographic entry */
                $bibliographicEntriesList[] =
                    sprintf('<div class="biblio-entry">%1s</div>',
                        get_acf_field('oes_demo_bibliography_main', $entry->ID)
                    );
            }

            /* sort alphabetically */
            sort($bibliographicEntriesList);

            $bibliographicEntries = sprintf('<div class="bibliography">%1s%2s</div>',
                $this->generate_table_of_content_header($this->translation ? 'Bibliographie' : 'References'),
                implode('', $bibliographicEntriesList)
            );
        }

        /* citation --------------------------------------------------------------------------------------------------*/
        $citation = '';

        if ($this->check_if_field_not_empty('oes_demo_article_citation_style')) {

            $citation = sprintf('<div class="citation">%1s%2s</div>',
                $this->generate_table_of_content_header($this->translation ? 'Zitierweise' : 'Citation'),
                $this->fields['oes_demo_article_citation_style']['value-display']
            );
        }

        return $mainContent . $bibliographicEntries . $citation;
    }


    // Overwrite parent function
    function pdf_footer()
    {
        return '<table>' .
            '<tr><td style="width:90%">' . $this->title . ", " . '$version' . " vom " . '$date' . '</td>' .
            '<td style="width:10%;text-align: right;">{PAGENO}/{nbpg}</td></tr>' .
            '</table>';
    }


    /**
     * Parse array to html display (instead of list ul)
     *
     * @param array $listItems An array containing list items.
     * @return string $returnString Return array as html display.
     */
    function pdf_list_array($listItems)
    {
        /* sort list */
        $listItemsSorted = oes_sort_post_array_by_title($listItems);
        $returnString = '';

        $first = true;
        foreach ($listItemsSorted as $item) {

            /* add separator before if not first entry */
            if ($first) $first = false;
            else $returnString .= '<span class="separator">|</span>';

            $returnString .= '<span class="replace-ul"><a href="' . get_permalink($item->ID) . '">' .
                oes_get_display_title($item->ID) . '</a></span>';
        }

        return $returnString;
    }


    // Overwrite parent function
    function pdf_style()
    {
        return '
            <html>
            <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
            <style>
        @page {
            width:100%;
            margin-left: 20mm;
            margin-right: 20mm;
        }
        body {
            line-height: 15pt;
            font-size: 10pt;
            font-family: Noto !important;
        } 
        .pdf-header {
            background-color: #c2cee1;
            text-align:center;
            height:60px;
            padding-top:30px;
        }
        img#header-home {
            height:40px;
            padding-right:2rem;
        }
        .pdf-header .title {
            font-size:30px;
            color:#666d73;
        }
        .sub-line {
            padding-top:15px;
        }
        .authors {
            color:#666d73;
        }
        .status {
            color:#666d73;
            padding-bottom:15px;
        }
        table {
            width:100%;
        }
        table th,
        table td,
        table tr {
            padding:.5rem;
            border-top:1px solid lightgrey;
            border-bottom:1px solid lightgrey;
        }
        table th {
            width:20%;
            font-weight: normal;
        }
        .content {
            padding-bottom:30px;
        }
        .data-tags {
            margin-top:15px;
        }
        .oes-badge {
            margin-right:5px;
            min-width: 10px;
            padding: 3px 7px;
            font-size: 15px;
        }
        .table-of-content {
            padding-bottom:1rem;
        }
        .content-table-header1,
        .content-table-header2,
        .content-table-header3,
        .content-table-header4,
        .content-table-header5,
        .content-table-header6 {
            font-size:2rem;
            margin-top:30px;
            margin-bottom:20px;
            font-weight: 500;
            line-height:1.5;
        }                
        .content-table-header2 {
            font-size:1.75rem;
        }
        .content-table-header3 {
            font-size:1.5rem;
        }
        .content-table-header4 {
            font-size:1.25rem;
        }
        .content-table-header5,
        .content-table-header6 {
             font-size:1rem;
        }
            </style>
            </head>';
    }

}

endif;