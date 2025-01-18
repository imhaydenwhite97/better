<?php
// In functions.php or a separate customizer.php file

function better_theme_customizer($wp_customize) {
    // LOGOS SECTION
    $wp_customize->add_section('better_logos', array(
        'title' => 'Logo Settings',
        'priority' => 30,
        'description' => 'Upload and manage all site logos'
    ));

    // Primary Logo
    $wp_customize->add_setting('primary_logo', array(
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'primary_logo', array(
        'label' => 'Primary Logo',
        'section' => 'better_logos',
        'description' => 'Main site logo for light backgrounds'
    )));

    // Inverted Logo
    $wp_customize->add_setting('inverted_logo', array(
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'inverted_logo', array(
        'label' => 'Inverted Logo',
        'section' => 'better_logos',
        'description' => 'Light version for dark backgrounds'
    )));

    // Mobile Logo
    $wp_customize->add_setting('mobile_logo', array(
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobile_logo', array(
        'label' => 'Mobile Logo',
        'section' => 'better_logos',
        'description' => 'Optimized logo for mobile devices'
    )));

    // COLORS SECTION
    $wp_customize->add_section('better_colors', array(
        'title' => 'Theme Colors',
        'priority' => 31,
        'description' => 'Customize your site color scheme'
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default' => '#007bff',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => 'Primary Color',
        'section' => 'better_colors'
    )));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#6c757d',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => 'Secondary Color',
        'section' => 'better_colors'
    )));

    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default' => '#28a745',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => 'Accent Color',
        'section' => 'better_colors'
    )));
}
add_action('customize_register', 'better_theme_customizer');

// Output Custom CSS
function better_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo get_theme_mod('primary_color', '#007bff'); ?>;
            --secondary-color: <?php echo get_theme_mod('secondary_color', '#6c757d'); ?>;
            --accent-color: <?php echo get_theme_mod('accent_color', '#28a745'); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'better_customizer_css');

// Usage in template files
function better_get_logo($type = 'primary') {
    switch($type) {
        case 'inverted':
            $logo = get_theme_mod('inverted_logo');
            break;
        case 'mobile':
            $logo = get_theme_mod('mobile_logo');
            break;
        default:
            $logo = get_theme_mod('primary_logo');
    }
    return $logo;
}
