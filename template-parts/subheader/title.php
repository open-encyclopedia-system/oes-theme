<div id="subheader">
    <div class="wrapper-basic">
        <div<?php echo $args['wrapper_id'] ? ' id=' . $args['wrapper_id'] : ''; ?> class="wrapper-main">
            <div class="title"><?php 
                echo $args['subheader_title']; ?>
            </div>
            <div class="buttons">
                <?php 
                
                /* include print button */
                if ($args['include_print']): ?>
                    <div class="dropdown" id="box">
                        <div class="dropdown-base">
                            <a href="?print=true" target="_blank"><?php 
                                _e('Download', 'oes-demo');?>
                            </a>
                        </div>
                    </div>
                <?php endif;
                
                /* include back link button */
                if ($args['include_back_link']):?>
                    <div class="dropdown" id="box">
                        <div class="dropdown-base">
                            <a href="<?php echo $args['include_back_link']; ?>"><?php 
                                echo $args['include_back_text']?>
                            </a>
                        </div>
                    </div>
                <?php endif;
                
                /* include version comparison button */
                if ($args['include_version_comparison']):?>
                    <div class="dropdown" id="box">
                        <div class="dropdown-base">
                            <a><?php
                                _e('Compare to', 'oes-demo');?>
                                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="dropdown-content" id="version">
                            <?php
                            foreach ($args['include_version_comparison'] as $version) : ?>
                                <a class="check-if-active"
                                   href="?compare_versions=<?php echo $version['id']; ?>"><?php
                                    echo 'Version ' . $version['version']; ?>
                                </a><?php
                            endforeach; ?>
                        </div>
                    </div><?php
                endif;
                
                /* include translation button */
                if ($args['include_translation']):

                    /* get post permalink */
                    foreach($args['include_translation'] as $postID => $language) :?>
                        <div class="dropdown" id="box">
                            <div class="dropdown-base">
                                <a href="<?php echo get_permalink($postID);?>"><?php echo $language;?></a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                endif;?>
            </div>
        </div>
    </div>
</div>