<?php

/* get alphabet information */
global $alphabetArrayInput;
global $alphabetArray;

/* build variable string */
$headVariables = $_GET;
$headVariablesWithoutFilter = '';
$firstVariable = true;
if ($headVariables) {
    foreach ($headVariables as $key => $variable) {

        /* skip filter variable */
        if ($key != 'filter'){

            /* check if first entry */
            $preamble = '';
            if($firstVariable) {
                $preamble = '?';
                $firstVariable = false;
            }
            else $preamble = '&';

            $headVariablesWithoutFilter .= $preamble . $key . '=' . $variable;
        }
    }
}



/* prepare alphabet array */
$alphabetArray = [];
$allAlphabet = array_merge(range('A', 'Z'), ['other']);

/* calculate width for each li */
$liWidth = 100 / 29;

/* first entry */
$allHref = '?';
if(!empty($headVariablesWithoutFilter)) $allHref = $headVariablesWithoutFilter;
$alphabetArray[] = [
    'style' => '',
    'content' => '<a class="check-if-active" href="' . $allHref . '">ALL</a>'
];

/* loop through entries */
foreach ($allAlphabet as $key => $firstCharacter) {

    /* check if last key */
    $styleText = '';
    //if ($key != 'Z') $styleText = ' style="width: ' . $liWidth . '%"';

    /* check if not part of alphabet */
    if ($firstCharacter == 'other') $firstCharacterDisplay = '#';
    else {
        $firstCharacterDisplay = $firstCharacter;

        /* make sure it's uppercase */
        $firstCharacter = strtoupper($firstCharacter);
    }

    /* check if in list */
    if (in_array($firstCharacter, $alphabetArrayInput)) {

        /* modify head variable */
        if (empty($headVariablesWithoutFilter)) $filter = '?filter=' . $firstCharacter;
        else $filter = '&filter=' . $firstCharacter;

        /* add character to list */
        $alphabetArray[] = [
            'style' => $styleText,
            'content' => '<a class="check-if-active" href="' . $headVariablesWithoutFilter . $filter . '">' .
                $firstCharacterDisplay . '</a>'
        ];

    } else {

        /* add character to list */
        $alphabetArray[] = [
            'style' => $styleText . ' class="inactive"',
            'content' => '<p>' . $firstCharacterDisplay . '</p>'
        ];
    }
}
