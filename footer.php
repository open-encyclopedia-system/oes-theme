<?php
global $oes_nav_language;
?>
<footer class="d-print-none">
    <div class="oes-footer-logo">
        <div class="container text-center"><?php

            if (has_nav_menu('oes-logo-menu-' . $oes_nav_language))
                wp_nav_menu([
                    'theme_location' => 'oes-logo-menu-' . $oes_nav_language,
                    'menu_class' => 'nav justify-content-center'
                ]);

            ?>
        </div>
    </div>
    <div class="oes-footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6"><?php

                    if (has_nav_menu('oes-social-menu-' . $oes_nav_language))
                        wp_nav_menu([
                            'theme_location' => 'oes-social-menu-' . $oes_nav_language,
                            'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                        ]);

                    ?>
                </div>
                <div class="col-md-6"><?php

                    if (has_nav_menu('oes-footer-menu-' . $oes_nav_language))
                        wp_nav_menu([
                            'theme_location' => 'oes-footer-menu-' . $oes_nav_language,
                            'menu_class' => 'oes-nav navbar-nav ml-auto mt-lg-0'
                        ]);

                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>