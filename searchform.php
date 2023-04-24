<form action="<?php echo home_url('/'); ?>" method="get" id="oes-search-form"><?php

    /* check for other languages */
    global $oes, $oes_language;
    if ($oes_language && $oes_language !== $oes->main_language): ?>
        <label for="oes-language-hidden-input"></label>
        <input type="text" name="oes-language" id="oes-language-hidden-input" value="<?php echo $oes_language; ?>"
               required hidden><?php
    endif;

    ?>
    <label for="s"></label>
    <input type="text" name="s" id="s" value="<?php the_search_query(); ?>" required>
    <button type="submit"></button>
</form>