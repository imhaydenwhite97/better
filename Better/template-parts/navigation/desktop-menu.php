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
        <?php if (is_user_logged_in()): ?>
            <?php 
            $current_user = wp_get_current_user();
            $profile_image = get_user_meta($current_user->ID, 'profile_image', true);
            $first_name = $current_user->first_name;
            $last_name = $current_user->last_name;
            $initials = strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
            ?>
            <div class="user-profile" id="userProfileTrigger">
                <span class="menu-arrow">▼</span>
                <div class="user-info">
                    <span class="welcome-text">Welcome,</span>
                    <span class="user-name"><?php echo $first_name . ' ' . $last_name; ?></span>
                </div>
                <div class="user-avatar">
                    <?php if ($profile_image): ?>
                        <img src="<?php echo wp_get_attachment_url($profile_image); ?>" alt="Profile">
                    <?php else: ?>
                        <div class="user-initials"><?php echo $initials; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="side-menu" id="userMenu">
                <div class="menu-header">
                    <div class="user-info-large">
                        <div class="user-avatar-large">
                            <?php if ($profile_image): ?>
                                <img src="<?php echo wp_get_attachment_url($profile_image); ?>" alt="Profile">
                            <?php else: ?>
                                <div class="user-initials"><?php echo $initials; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="user-details">
    <span class="user-name-large"><?php echo $first_name . ' ' . $last_name; ?></span>
    <div class="role-badge">
        <svg class="role-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
        </svg>
        <span class="user-role"><?php 
            $user_roles = $current_user->roles;
            $role = ucfirst($user_roles[0]); 
            echo $role;
        ?></span>
    </div>
</div>
                    </div>
                </div>
                <nav class="menu-items">
                    <a href="/dashboard" class="menu-item">
                        <span class="icon">📊</span>
                        Dashboard
                    </a>
                    <?php if (current_user_can('administrator')): ?>
                        <a href="/create-series" class="menu-item">
                            <span class="icon">✨</span>
                            Create Series
                        </a>
                    <?php endif; ?>
                    <a href="/profile" class="menu-item">
                        <span class="icon">👤</span>
                        Profile Settings
                    </a>
                    <a href="/investments" class="menu-item">
                        <span class="icon">💰</span>
                        My Investments
                    </a>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="menu-item logout">
                        <span class="icon">🚪</span>
                        Log Out
                    </a>
                </nav>
            </div>
        <?php else: ?>
            <a href="<?php echo home_url('/login'); ?>" class="button login-btn">Log In</a>
            <a href="<?php echo home_url('/register'); ?>" class="button register-btn">Sign Up</a>
        <?php endif; ?>
    </div>
</header>
