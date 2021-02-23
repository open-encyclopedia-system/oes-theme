<?php

/**
 * Class OES_Demo_Index
 */
if (!class_exists('\OES\Theme\OES_Post_Type_Theme')) :
    class OES_Demo_Index {}
else :

class OES_Demo_Index extends \OES\Theme\OES_Post_Type_Theme
{

    function check_if_post_is_hidden(){
        /* check if connected to any article : oes_demo_index_articles field is empty */
        return empty($this->fields['oes_demo_index_articles']['value']);
    }

    // Overwrite parent function
    function get_html_main($args = [])
    {
        /* get table data */
        $tableData = $this->get_prepared_table_distinct($this->fields['oes_demo_index_articles']['value']);

        /* prepare table content string */
        $tableContent = '';
        foreach ($tableData as $row) $tableContent .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';

        return sprintf(
            '<main id="with-subheader"><div id="single-post" class="wrapper-main"><div class="details">' .
            '%1s' . //description
            '%2s' . //meta
            '<div class="content-table-header1"><h3>Referred to in</h3></div>' . //connected content
            '<table><tr><th>Title</th><th>Type</th><th>Version(s)</th></tr>%3s</table>' .
            '</div></div></main>',
            $this->fields['oes_demo_index_description_display']['value-display'],
            $this->get_html_meta_data(['display-header' => '<h3>Details</h3>']),
            $tableContent
        );
    }

    function modify_meta_data($field)
    {
        /* modify gnd links */
        if (in_array($field['key'],
            ['oes_demo_index_person_gnd_nr', 'oes_demo_index_place_gnd_nr', 'oes_demo_index_institute_gnd_nr'])) {
            $field['value-display'] = '<a href="http://d-nb.info/gnd/' . $field['value-display'] .
                '" target="_blank">http://d-nb.info/gnd/' . $field['value-display'] . '</a>';
        } elseif ($field['key'] == 'oes_demo_index_place_geonames') {
            $field['value-display'] = '<a href="https://www.geonames.org/' . $field['value-display'] .
                '" target="_blank">https://www.geonames.org/' . $field['value-display'] . '</a>';
        }

        /* modify bibliographical data */
        if (in_array($field['key'],
            ['oes_demo_index_person_living_dates_start', 'oes_demo_index_person_living_dates_end'])) {

            /* if both are part of meta data, replace birth by full date and skip death date */
            $birthField = $this->fields['oes_demo_index_person_living_dates_start'];
            $deathField = $this->fields['oes_demo_index_person_living_dates_end'];

            if ($birthField['meta'] && $deathField['meta']) {

                /* get values */
                $birth = $birthField['value-display'];
                $death = $deathField['value-display'];

                /* replace birth with biographical data */
                if ($field['key'] == 'oes_demo_index_person_living_dates_start') {

                    /* check if BC or AC */
                    if (intval($birth) < 0 && intval($death) < 0) {
                        $date = -$birth . ' - ' . -$death . ' BC';
                    } elseif (intval($birth) < 0) {
                        $date = -$birth . ' BC - ' . $death . ' AC';
                    } else {
                        $date = $birth . ' - ' . $death;
                    }

                    /* set new values */
                    $field['value-display'] = $date;
                    $field['label'] = 'Biographical Data';
                }
                /* skip death date*/
                else {
                    $field['skip'] = true;
                }
            }
        }

        return $field;
    }

}

endif;