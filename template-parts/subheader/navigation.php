<div id="subheader" class="wrapper-basic">
    <div id="wrapper-flex" class="wrapper-main">
        <div id="index-navigation" class="wrapper">
            <div id="tabs">
                <a href="<?php echo get_permalink(get_page_by_path('oes-demo-index')); ?>"
                   class="check-if-active"><?php _e('All', 'oes-demo'); ?>
                </a>
                <?php if(get_post_type_object('oes_index_person')->show_in_nav_menus) : ?>
                <a href="<?php echo get_post_type_archive_link('oes_index_person'); ?>"
                   class="check-if-active"><?php _e('People', 'oes-demo'); ?>
                </a>
                <?php endif;?>
                <?php if(get_post_type_object('oes_index_institute')->show_in_nav_menus) : ?>
                    <a href="<?php echo get_post_type_archive_link('oes_index_institute'); ?>"
                       class="check-if-active"><?php _e('Institutions', 'oes-demo'); ?>
                    </a>
                <?php endif;?>
                <?php if(get_post_type_object('oes_index_place')->show_in_nav_menus) : ?>
                <a href="<?php echo get_post_type_archive_link('oes_index_place'); ?>"
                   class="check-if-active"><?php _e('Places', 'oes-demo'); ?>
                </a>
                <?php endif;?>
                <?php if(get_post_type_object('oes_index_time')->show_in_nav_menus) : ?>
                <a href="<?php echo get_post_type_archive_link('oes_index_time'); ?>"
                   class="check-if-active"><?php _e('Times', 'oes-demo'); ?>
                </a>
                <?php endif;?>
                <?php if(get_post_type_object('oes_index_subject')->show_in_nav_menus) : ?>
                <a href="<?php echo get_post_type_archive_link('oes_index_subject'); ?>"
                   class="check-if-active"><?php _e('Subjects', 'oes-demo'); ?>
                </a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>