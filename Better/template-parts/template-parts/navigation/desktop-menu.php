<header class="desktop-header">
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo better_get_logo(); ?>" 
                 class="desktop-logo" 
                 alt="<?php bloginfo('name'); ?>">
            <img src="<?php echo better_get_logo('mobile'); ?>" 
                 class="mobile-logo" 
                 alt="<?php bloginfo('name'); ?>">
        </a>
    </div>

    <nav class="priority-links">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'desktop-menu',
            'container' => false,
            'walker' => new Desktop_Menu_Walker(),
            'items_wrap' => '%3$s'
        ));
        ?>
    </nav>

    <div class="user-auth">
        <button class="login-btn">Log In</button>
        <button class="register-btn">Register</button>
    </div>
</header>
