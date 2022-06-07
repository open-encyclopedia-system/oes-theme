<form action="<?php echo home_url('/'); ?>" method="get" id="oes-search-form">
    <label for="s"></label>
    <input type="text" name="s" id="s" value="<?php the_search_query(); ?>" required>
    <button type="submit"></button>
</form>