<footer>
    <div class="oes-footer-top">
        <div class="container"><?php
            wp_nav_menu([
                'theme_location' => 'oes-footer-menu',
                'container' => false,
                'menu_class' => 'navbar-nav ml-auto mt-lg-0'
            ]); ?>
        </div>
    </div>
    <div class="oes-footer-logo">
        <div class="container text-center"><?php
            wp_nav_menu([
                'theme_location' => 'oes-logo-menu',
                'container' => false,
                'menu_class' => 'nav justify-content-center'
            ]); ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>