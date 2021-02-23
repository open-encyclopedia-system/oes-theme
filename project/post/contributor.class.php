<?php

/**
 * Class OES_Demo_Contributor
 */
if (!class_exists('\OES\Theme\OES_Post_Type_Theme')) :
    class OES_Demo_Contributor {}
else :

class OES_Demo_Contributor extends \OES\Theme\OES_Post_Type_Theme
{

    // Overwrite parent function
    function get_archive_data()
    {
        /* add full name to archive */
        $fullNameArray = [];
        foreach (['oes_demo_contributor_acadtitle',
                     'oes_demo_contributor_given_name',
                     'oes_demo_contributor_family_name'] as $field) {
            if (!empty($this->fields[$field]['value-display']))
                $fullNameArray[] = $this->fields[$field]['value-display'];
        }
        $this->add_archive_data(implode(' ', $fullNameArray), 'Full Name', 1);

        return $this->archiveData;
    }

    function modify_meta_data($field)
    {

        /* set authority file id */
        if ($field['key'] == 'oes_demo_contributor_file_id') {
            if (!empty($this->fields['oes_demo_contributor_file_name']['value-display'])
                && !empty($field['value-display'])) {

                $hrefPrae = "";
                switch ($this->fields['oes_demo_contributor_file_name']['value']) {

                    case 'GND':
                        $hrefPrae = 'http://d-nb.info/gnd/';
                        break;
                    case 'ORCID' :
                        $hrefPrae = 'https://orcid.org/';
                        break;
                    case 'Wikidata' :
                        $hrefPrae = 'https://www.wikidata.org/wiki/';
                        break;
                }

                $fileID = $field['value-display'];
                $field['value-display'] = '<a href="' . $hrefPrae . $fileID . '" target="_blank">' .
                    $hrefPrae . $fileID . '</a>';
            }
        }

        return $field;
    }


    // Overwrite parent function
    function get_html_main($args = [])
    {
        /* check for connected content in articles and glossary entries */
        $connectedIDs = [];

        /* add connected articles */
        if ($this->check_if_field_not_empty('oes_demo_contributor_article')) {
            $connectedIDs = $this->fields['oes_demo_contributor_article']['value'];
        }

        /* add connected glossary entries */
        if ($this->check_if_field_not_empty('oes_demo_contributor_glossary')) {
            if (!empty($connectedIDs)) {
                array_merge($connectedIDs, $this->fields['oes_demo_contributor_glossary']['value']);
            } else {
                $connectedIDs = $this->fields['oes_demo_contributor_glossary']['value'];
            }
        }

        /* get table data */
        $tableData = $this->get_prepared_table_distinct($connectedIDs);

        /* prepare table content string */
        $tableContent = '';
        foreach ($tableData as $row) $tableContent .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';

        return sprintf(
            '<main id="with-subheader"><div id="single-post" class="wrapper-main"><div class="details">' .
            '%1s' . //meta
            '<div class="content-table-header1"><h3>Author of</h3></div>' . //connected content
            '<table><tr><th>Title</th><th>Type</th><th>Version(s)</th></tr>%2s</table>' .
            '</div></div></main>',
            $this->get_html_meta_data(['display-header' => '<h3>Details</h3>']),
            $tableContent
        );
    }

}

endif;