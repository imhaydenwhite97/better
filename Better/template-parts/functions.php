<?php
/**
 * Theme Functions
 */

// Navigation Scripts and Styles
function theme_enqueue_navigation() {
    // Desktop Navigation
    wp_enqueue_style('navigation-desktop', get_template_directory_uri() . '/assets/css/navigation/desktop.css', array(), '1.0.0');
    wp_enqueue_script('navigation-desktop', get_template_directory_uri() . '/assets/js/navigation/desktop.js', array('jquery'), '1.0.0', false);
    
    // Mobile Navigation
    wp_enqueue_style('navigation-mobile', get_template_directory_uri() . '/assets/css/navigation/mobile.css', array(), '1.0.0');
    wp_enqueue_script('navigation-mobile', get_template_directory_uri() . '/assets/js/navigation/mobile.js', array('jquery'), '1.0.0', true);
    
    // Dashboard Navigation
    if (is_user_logged_in()) {
        wp_enqueue_style('desktop-dashboard', get_template_directory_uri() . '/assets/css/navigation/desktop-dashboard.css', array(), '1.0.0');
        wp_enqueue_style('mobile-dashboard', get_template_directory_uri() . '/assets/css/navigation/mobile-dashboard.css', array(), '1.0.0');
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

// Include Required Files
require_once get_template_directory() . '/inc/classes/menu-walkers/desktop-walker.php';
require_once get_template_directory() . '/inc/classes/menu-walkers/dashboard-walker.php';
require_once get_template_directory() . '/inc/customizer.php';

// Remove Admin Toolbar
add_filter('show_admin_bar', '__return_false');

// Theme Logo Support
function better_customize_register($wp_customize) {
    $wp_customize->add_setting('site_logo', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
        'label' => 'Upload Logo',
        'section' => 'title_tagline',
        'settings' => 'site_logo'
    )));
}
add_action('customize_register', 'better_customize_register');

// Mega Menu Content Helper
function better_get_mega_menu_content($menu_id) {
    $menu_item = get_post($menu_id);
    $slug = $menu_item ? $menu_item->post_name : 'default';
    
    $variations = array(
        'buy' => 'buy',
        'rent' => 'rent',
        'sell' => 'sell',
        'default' => 'default'
    );
    
    $variation = isset($variations[$slug]) ? $variations[$slug] : 'default';
    
    return array(
        'image' => get_theme_mod("mega_menu_{$variation}_image", ''),
        'text' => get_theme_mod("mega_menu_{$variation}_text", ''),
        'cta_text' => get_theme_mod("mega_menu_{$variation}_cta_text", ''),
        'cta_url' => get_theme_mod("mega_menu_{$variation}_cta_url", '')
    );
}

// SVG Upload Support
function add_svg_support($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'add_svg_support');

function handle_svg_upload($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype($filename, $mimes);
    
    if ('svg' === $filetype['ext']) {
        $data['type'] = 'image/svg+xml';
        $data['ext'] = 'svg';
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'handle_svg_upload', 10, 4);

// Theme Support
function better_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'better_theme_support');
