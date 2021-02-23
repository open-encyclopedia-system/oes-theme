<form action="<?php echo home_url('/'); ?>" method="get" id="search-form">
    <input type="text"
           name="s"
           id="search"
           value="<?php the_search_query(); ?>"
           placeholder="Search"
           required
    >
    <button type="submit" id="search"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>