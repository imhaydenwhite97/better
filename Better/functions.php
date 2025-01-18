<?php
/**
 * Theme Functions
 */

// Navigation Scripts and Styles
function theme_enqueue_navigation() {
    // Desktop Navigation
    wp_enqueue_style('navigation-desktop', get_template_directory_uri() . '/assets/css/navigation/desktop.css');
    wp_enqueue_script('navigation-desktop', get_template_directory_uri() . '/assets/js/navigation/desktop.js', array('jquery'), '1.0.0', false);
    
    // Mobile Navigation
    wp_enqueue_style('navigation-mobile', get_template_directory_uri() . '/assets/css/navigation/mobile.css');
    wp_enqueue_script('navigation-mobile', get_template_directory_uri() . '/assets/js/navigation/mobile.js', array('jquery'), '1.0.0', true);
    
    // Dashboard Navigation
    if (is_user_logged_in()) {
        wp_enqueue_style('desktop-dashboard', get_template_directory_uri() . '/assets/css/navigation/desktop-dashboard.css');
        wp_enqueue_style('mobile-dashboard', get_template_directory_uri() . '/assets/css/navigation/mobile-dashboard.css');
        wp_enqueue_script('desktop-dashboard', get_template_directory_uri() . '/assets/js/navigation/desktop-dashboard.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('mobile-dashboard', get_template_directory_uri() . '/assets/js/navigation/mobile-dashboard.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_navigation');

// Register Navigation Menus
function register_theme_menus() {
    register_nav_menus(array(
        'desktop-menu' => 'Desktop Navigation',
        'mobile-menu' => 'Mobile Navigation',
        'desktop-dashboard' => 'Desktop Dashboard',
        'mobile-dashboard' => 'Mobile Dashboard'
    ));
}
add_action('init', 'register_theme_menus');

// Include Walker Classes
require_once get_template_directory() . '/inc/classes/menu-walkers/desktop-walker.php';
require_once get_template_directory() . '/inc/classes/menu-walkers/dashboard-walker.php';


// Removes Admin Toolbar on Front end
add_filter('show_admin_bar', '__return_false');

// In Customizer
function better_customize_register($wp_customize) {
    $wp_customize->add_setting('site_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
        'label' => 'Upload Logo',
        'section' => 'title_tagline'
    )));
}
add_action('customize_register', 'better_customize_register');

// Call Customizer
require_once get_template_directory() . '/inc/customizer.php';

//Helper for Mega Menu Content
function better_get_mega_menu_content($variation = 'buy') {
    return array(
        'image' => get_theme_mod("mega_menu_{$variation}_image"),
        'text' => get_theme_mod("mega_menu_{$variation}_text"),
        'cta_text' => get_theme_mod("mega_menu_{$variation}_cta_text"),
        'cta_url' => get_theme_mod("mega_menu_{$variation}_cta_url")
    );
}

// Add SVG to allowed upload types
function add_svg_support($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'add_svg_support');

// Ensure SVG uploads are properly handled
function handle_svg_upload($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype($filename, $mimes);
    
    if ('svg' === $filetype['ext']) {
        $data['type'] = 'image/svg+xml';
        $data['ext'] = 'svg';
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'handle_svg_upload', 10, 4);
