<nav class="mobile-nav">
    <!-- Top Header -->
    <div class="mobile-header">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo better_get_logo(); ?>" 
                     class="mobile-logo" 
                     alt="<?php bloginfo('name'); ?>">
            </a>
        </div>
        <div class="mobile-auth">
            <button class="get-started-btn">Get Started</button>
        </div>
    </div>

    <!-- Bottom Drawer -->
    <div class="bottom-drawer">
        <a href="<?php echo home_url(); ?>" class="drawer-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <div class="drawer-item" data-menu="explore">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="drawer-item" data-menu="invest">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 2v20m5-17H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="drawer-item" data-menu="auth">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
</nav>
