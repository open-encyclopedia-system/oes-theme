<?php

/* display header ----------------------------------------------------------------------------------------------------*/

use function OES\ACF\get_acf_field;

get_header(null,
    [
        'head_text' => 'OES Demo',
        'header_text' => 'Welcome',
    ]);

?>
    <main id="no-subheader">
        <div id="home-first-block">
            <div class="wrapper-main" id="frontpage">
                <div class="row">
                    <div class="col-sm-6"><?php
                        $frontPage = get_page_by_path('oes-demo-front-page');
                        echo $frontPage->post_content;
                        ?><br>
                    </div>
                    <div class="col-sm-6">
                        <div><?php
                            $frontPage = get_page_by_path('oes-demo-use-cases');
                            echo $frontPage->post_content;
                            ?><br><br>
                        </div>
                        <div id="use-case-carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#use-case-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#use-case-carousel" data-slide-to="1"></li>
                                <li data-target="#use-case-carousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/oes_comdeg.jpg"
                                         alt="comdeg">
                                    <div class="carousel-caption">
                                        <h3><a href="https://comdeg.eu/" target="_blank">ComDeG</a></h3>
                                        <p><a href="https://comdeg.eu/" target="_blank">Online-Compendium<br>der
                                                deutsch-griechischen Verflechtungen</a></p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/oes_compendium_heroicum.jpg"
                                         alt="compendium">
                                    <div class="carousel-caption">
                                        <h3><a href="https://www.compendium-heroicum.de/" target="_blank">Compendium
                                                Heroicum</a></h3>
                                        <p><a href="https://www.compendium-heroicum.de/" target="_blank">Online-Lexikon
                                                des SFB 948<br>"Helden-Heroisierung-Heroismen"</a></p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/oes_eiserner_vorhang.jpg"
                                         alt="eiserner-vorhang">
                                    <div class="carousel-caption">
                                        <h3><a href="https://todesopfer.eiserner-vorhang.de/" target="_blank">Eiserner
                                                Vorhang</a></h3>
                                        <p><a href="https://todesopfer.eiserner-vorhang.de/" target="_blank">Tödliche
                                                Fluchten<br>und Rechtsbeugung</a></p>
                                    </div>
                                </div>
                            </div>
                            <a class="left carousel-control" href="#use-case-carousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#use-case-carousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="home-second-block">
            <div class="wrapper-main" id="frontpage">
                <div id="featured-article">
                    <div class="featured-article-content">
                        <div><?php

                            /* get featured post */

                            /* get option */
                            $imageFieldsOption = get_option(OES\Config\Option::FRONTPAGE);
                            $postID = $imageFieldsOption['featured_post'];
                            $postText = $imageFieldsOption['post_text'];

                            /* check if latest article */
                            if($postID == 'oes_demo_article' || !$imageFieldsOption){
                                $latest = get_posts("post_type=oes_demo_article&numberposts=1");
                                $postID = $latest[0]->ID;
                            }

                            /* generate article */
                            $article = new OES_Demo_Article($postID);
                            $title = $article->get_title();

                            /* get main content */
                            $excerpt = $article->fields['oes_demo_article_excerpt']['value-display'];
                            $permalink = get_permalink($postID);
                            $content = '';
                            if ($excerpt) {
                                $content = $excerpt . '<div class="read-more"><a href="' . $permalink .
                                    '">Read More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>';
                            }

                            /* get image */
                            $image = get_acf_field('oes_demo_article_media_gallery', $postID);


                            ?>
                            <div class="featured-article-title"><?php
                                echo !empty($postText) ? $postText : __('Featured Article : ', 'oes-demo')?>
                                <a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></div>
                            <div><?php echo $content; ?></div>
                        </div>
                    </div>
                    <div class="featured-article-image"><?php
                        if (!empty($image)):
                            get_template_part('template-parts/image/image', null, ['image' => $image,]);
                        else: ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/oes-logo-colored-background.png"
                                 alt="<?php echo esc_attr($image['alt']); ?>"/>
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </main>

<?php
get_footer();
?>
