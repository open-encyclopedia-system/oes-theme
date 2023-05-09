<?php
global $oes_search;
$searchTerm = '';
if($oes_search) $searchTerm = (is_array($oes_search) && isset($oes_search['search_term'])) ? $oes_search['search_term'] : $oes_search->search_term;

?><form action="<?php echo home_url('/'); ?>" method="get" id="oes-search-form"><?php

    /* check for other languages */
    global $oes, $oes_language;
    if ($oes_language && $oes_language !== $oes->main_language): ?>
        <label for="oes-language-hidden-input"></label>
        <input type="text" name="oes-language-switch" id="oes-language-hidden-input" value="<?php echo $oes_language; ?>"
               required hidden><?php
    endif;

    ?>
    <label for="s"></label>
    <input type="text" name="s" id="s" value="<?php echo $searchTerm; ?>" required>
    <button type="submit"></button>
</form>