</main>
<footer>
    <div class="wrapper-basic">
        <div id="footer-top">
            <div class="wrapper-container">
                <div id="footer-left" class="wrapper-item">
                    <div id="footer-left-container" class="wrapper">
                        <ul id="footer-navigation">
                            <li><a href="<?php echo wp_login_url(); ?>">Login to Backend</a></li>
                            <li><a href="http://www.open-encyclopedia-system.org/legal-notice/index.html" target="_blank">Legal
                                    Notice</a></li>
                            <li><a class="check-if-active"
                                   href="<?php echo get_permalink(get_page_by_path('oes-demo-contact')); ?>"><?php
                                    _e('Contact', 'oes-demo');?>
                            </li>
                            <li><a href="https://twitter.com/oesdigital"><i class="fa fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="footer-right">
                    <a href="https://www.open-encyclopedia-system.org/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/oes_logo_RGB_1200px_grey.png"
                         alt="oesProjectLogo">
                    </a>
                </div>
            </div>
        </div>
        <div id="footer-bottom">
            <div class="wrapper-container">
                <div class="wrapper">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fu-logo.png"
                         alt="fuLogo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dfg_logo_schriftzug_blau_foerderung_en.jpg"
                         alt="dfgLogo">
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>