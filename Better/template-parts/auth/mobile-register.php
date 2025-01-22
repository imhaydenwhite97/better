<div class="mobile-auth-container">
    <form class="mobile-register-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('mobile_register_nonce', 'mobile_register_security'); ?>
        <input type="hidden" name="action" value="mobile_register_action">
        
        <div class="form-field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" required />
        </div>
        <div class="form-field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="username" required />
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Create Account</button>
    </form>
</div>
