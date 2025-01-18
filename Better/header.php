<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <?php 
    // Check if we're on a dashboard page
    $is_dashboard = is_page('dashboard') || is_page_template('template-dashboard.php');

    if ($is_dashboard && is_user_logged_in()) {
        // Show dashboard navigation on dashboard pages for logged-in users
        if (wp_is_mobile()) {
            get_template_part('template-parts/navigation/mobile-dashboard');
        } else {
            get_template_part('template-parts/navigation/desktop-dashboard');
        }
    } else {
        // Show regular navigation everywhere else
        if (wp_is_mobile()) {
            get_template_part('template-parts/navigation/mobile-menu');
        } else {
            get_template_part('template-parts/navigation/desktop-menu');
        }
    }
    ?>
