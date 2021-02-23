<?php
global $activeTab;
global $slug;

/* modify slug */
$activeTab = isset($_GET['category']) ? $_GET['category'] : 'all';
$categories = get_terms(['taxonomy' => 'oes_demo_tag_category']);


?>
<section id="subheader">
    <div id="wrapper-flex" class="wrapper-main">
        <div id="index-navigation" class="wrapper">

            <div id="tabs">
                <a href="<?php echo $slug;?>?category=all"
                   class="nav-tab <?php echo $activeTab == 'all' ? 'nav-tab-active' : ''; ?>"><?php
                    _e('All', 'oes-demo');
                    ?></a>
                <?php
                foreach($categories as $category) :
                    ?>
                    <a href="<?php echo $slug. '?category=' . $category->slug;?>"
                       class="nav-tab <?php echo $activeTab == $category->slug ? 'nav-tab-active' : ''; ?>"><?php
                        _e($category->name, 'oes-demo'); ?></a>
                <?php
                endforeach;?>
            </div>
        </div>
    </div>
</section>