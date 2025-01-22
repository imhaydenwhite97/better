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
    wp_enqueue_script('mobile-navigation', get_template_directory_uri() . '/assets/js/navigation/mobile.js', array(), '1.0.0', true);
    
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

function register_auth_pages() {
    add_rewrite_rule('^login/?$', 'index.php?pagename=login', 'top');
    add_rewrite_rule('^register/?$', 'index.php?pagename=register', 'top');
}
add_action('init', 'register_auth_pages');

// Register Auth Templates
function register_auth_templates($templates) {
    $templates['template-parts/auth/login.php'] = 'Login Page';
    $templates['template-parts/auth/register.php'] = 'Register Page';
    return $templates;
}
add_filter('theme_page_templates', 'register_auth_templates');

//Register Form
function handle_custom_registration() {
    if (isset($_POST['custom_registration_submit'])) {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'custom_registration_nonce')) {
            return;
        }

        // Create base user
        $userdata = array(
            'user_login'    => sanitize_email($_POST['email']),
            'user_email'    => sanitize_email($_POST['email']),
            'user_pass'     => $_POST['password'],
            'first_name'    => sanitize_text_field($_POST['first_name']),
            'last_name'     => sanitize_text_field($_POST['last_name']),
            'role'          => 'subscriber'
        );

        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            // Store additional user meta
            update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
            update_user_meta($user_id, 'dob', sanitize_text_field($_POST['dob']));
            update_user_meta($user_id, 'address', sanitize_text_field($_POST['address']));

            // Handle profile image upload
            if (!empty($_FILES['profile_image'])) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');

                $attachment_id = media_handle_upload('profile_image', 0);
                if (!is_wp_error($attachment_id)) {
                    update_user_meta($user_id, 'profile_image', $attachment_id);
                }
            }

            $user = new WP_User($user_id);
            $user->set_role($_POST['user_role']); // Assigns the selected role

            wp_set_auth_cookie($user_id);
            wp_redirect(home_url());
            exit;
        }
    }
}add_action('init', 'handle_custom_registration');

// Add this for login redirect
function custom_login_redirect($redirect_to, $request, $user) {
    return home_url();
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);
//Auth CSS
function theme_enqueue_styles() {
    wp_enqueue_style('better-style', get_stylesheet_uri());
    wp_enqueue_style('auth-styles', get_template_directory_uri() . '/assets/css/auth/auth.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Custom User Dashboard Fields
// Add custom user profile fields
function add_custom_user_profile_fields($user) {
    ?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="dob">Date of Birth</label></th>
            <td>
                <input type="date" name="dob" id="dob" value="<?php echo esc_attr(get_user_meta($user->ID, 'dob', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="address">Address</label></th>
            <td>
                <input type="text" name="address" id="address" value="<?php echo esc_attr(get_user_meta($user->ID, 'address', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

// Save custom user profile fields
function save_custom_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    update_user_meta($user_id, 'phone', $_POST['phone']);
    update_user_meta($user_id, 'dob', $_POST['dob']);
    update_user_meta($user_id, 'address', $_POST['address']);
}

add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');


// Handle profile image display
function get_user_profile_image($user_id) {
    $profile_image_id = get_user_meta($user_id, 'profile_image', true);
    if ($profile_image_id) {
        return wp_get_attachment_url($profile_image_id);
    }
    return get_avatar_url($user_id);
}

// Add profile image field to user profile
function add_profile_image_field($user) {
    ?>
    <tr>
        <th><label for="profile_image">Profile Image</label></th>
        <td>
            <img src="<?php echo get_user_profile_image($user->ID); ?>" style="width: 96px; height: 96px; object-fit: cover; border-radius: 50%;" />
            <input type="file" name="profile_image" id="profile_image" accept="image/*" />
        </td>
    </tr>
    <?php
}
add_action('show_user_profile', 'add_profile_image_field');
add_action('edit_user_profile', 'add_profile_image_field');

function enqueue_auth_scripts() {
    wp_enqueue_script('register-form', get_template_directory_uri() . '/assets/js/auth/register.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_auth_scripts');

function enqueue_user_menu_script() {
    if (is_user_logged_in()) {
        wp_enqueue_script('user-menu', get_template_directory_uri() . '/assets/js/navigation/user-menu.js', array(), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_user_menu_script');

function add_custom_user_roles() {
    add_role('co-buyer', 'Co-buyer', array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false
    ));
    
    add_role('renter', 'Renter', array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false
    ));
}
add_action('init', 'add_custom_user_roles');

// Add the combined role
function add_combined_user_role() {
    add_role('co-buyer-renter', 'Co-buyer & Renter', array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false
    ));
}
add_action('init', 'add_combined_user_role');

// Function to handle role upgrade
function upgrade_user_role($user_id) {
    $user = new WP_User($user_id);
    $current_role = $user->roles[0];
    
    if ($current_role === 'renter') {
        $user->set_role('co-buyer-renter');
    }
}

// Example usage when user subscribes:
// upgrade_user_role($user_id);

function enqueue_dashboard_styles() {
    if (is_page_template('template-parts/dashboard/dashboard.php')) {
        wp_enqueue_style('dashboard-styles', get_template_directory_uri() . '/assets/css/dashboard/dashboard.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_dashboard_styles');

function register_dashboard_template($templates) {
    $templates['template-parts/dashboard/dashboard.php'] = 'User Dashboard';
    return $templates;
}
add_filter('theme_page_templates', 'register_dashboard_template');

function enqueue_series_styles() {
    if (is_page_template('template-parts/series/create-series.php')) {
        wp_enqueue_style('series-styles', get_template_directory_uri() . '/assets/css/series/create-series.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_series_styles');

function handle_series_creation() {
    if (!isset($_POST['series_title']) || !current_user_can('administrator')) {
        return;
    }

    $post_data = array(
        'post_title'    => sanitize_text_field($_POST['series_title']),
        'post_content'  => wp_kses_post($_POST['series_description']),
        'post_status'   => 'publish',
        'post_type'     => 'investment_series'
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Save investment details as meta
        update_post_meta($post_id, 'investment_amount', floatval($_POST['investment_amount']));
        update_post_meta($post_id, 'minimum_investment', floatval($_POST['minimum_investment']));
        update_post_meta($post_id, 'expected_roi', floatval($_POST['expected_roi']));
        update_post_meta($post_id, 'property_location', sanitize_text_field($_POST['property_location']));

        // Handle image uploads
        if (!empty($_FILES['property_images'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $files = $_FILES['property_images'];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name'     => $files['name'][$key],
                        'type'     => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error'    => $files['error'][$key],
                        'size'     => $files['size'][$key]
                    );
                    $_FILES = array('upload_file' => $file);
                    $attachment_id = media_handle_upload('upload_file', $post_id);
                }
            }
        }

        wp_redirect(get_permalink($post_id));
        exit;
    }
}
add_action('admin_post_create_series', 'handle_series_creation');

function register_investment_series_post_type() {
    register_post_type('investment_series', array(
        'labels' => array(
            'name' => 'Investment Series',
            'singular_name' => 'Series'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-money-alt'
    ));
}
add_action('init', 'register_investment_series_post_type');

function register_series_template($templates) {
    $templates['template-parts/series/create-series.php'] = 'Create Series';
    return $templates;
}
add_filter('theme_page_templates', 'register_series_template');

function register_explore_series_template($templates) {
    $templates['template-parts/series/explore-series.php'] = 'Explore Series';
    return $templates;
}
add_filter('theme_page_templates', 'register_explore_series_template');

function enqueue_explore_series_styles() {
    if (is_page_template('template-parts/series/explore-series.php')) {
        wp_enqueue_style('explore-series-styles', get_template_directory_uri() . '/assets/css/series/explore-series.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_explore_series_styles');

function enqueue_single_series_styles() {
    if (is_singular('investment_series')) {
        wp_enqueue_style('single-series-styles', get_template_directory_uri() . '/assets/css/series/single-series.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_single_series_styles');

function load_auth_template($template) {
    if (wp_is_mobile()) {
        if (is_page('login')) {
            return get_template_directory() . '/template-parts/auth/mobile-login.php';
        }
        if (is_page('register')) {
            return get_template_directory() . '/template-parts/auth/mobile-register.php';
        }
    }
    return $template;
}
add_filter('template_include', 'load_auth_template');

// Mobile Login Handler
function handle_mobile_login() {
    if (!isset($_POST['mobile_login_security']) || 
        !wp_verify_nonce($_POST['mobile_login_security'], 'mobile_login_nonce')) {
        wp_die('Security check failed');
    }

    $credentials = array(
        'user_login'    => sanitize_user($_POST['username']),
        'user_password' => $_POST['password'],
        'remember'      => true
    );

    $user = wp_signon($credentials);

    if (is_wp_error($user)) {
        wp_redirect(add_query_arg('login_error', '1', wp_get_referer()));
        exit;
    }

    wp_redirect(home_url('/dashboard'));
    exit;
}
add_action('admin_post_mobile_login_action', 'handle_mobile_login');
add_action('admin_post_nopriv_mobile_login_action', 'handle_mobile_login');

// Mobile Register Handler
function handle_mobile_register() {
    if (!isset($_POST['mobile_register_security']) || 
        !wp_verify_nonce($_POST['mobile_register_security'], 'mobile_register_nonce')) {
        wp_die('Security check failed');
    }

    $user_data = array(
        'user_login' => sanitize_user($_POST['username']),
        'user_email' => sanitize_email($_POST['email']),
        'user_pass'  => $_POST['password'],
        'role'       => 'subscriber'
    );

    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        wp_redirect(add_query_arg('register_error', '1', wp_get_referer()));
        exit;
    }

    // Auto-login after registration
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    wp_redirect(home_url('/dashboard'));
    exit;
}
add_action('admin_post_mobile_register_action', 'handle_mobile_register');
add_action('admin_post_nopriv_mobile_register_action', 'handle_mobile_register');

function enqueue_mobile_auth() {
    if (wp_is_mobile()) {
        wp_enqueue_script('mobile-auth', get_template_directory_uri() . '/assets/js/auth/mobile-auth.js', array('jquery'), '1.0', true);
        wp_localize_script('mobile-auth', 'mobileAuth', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mobile_auth_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_mobile_auth');

function handle_mobile_auth_login() {
    check_ajax_referer('mobile_auth_nonce', 'security');
    
    $credentials = array(
        'user_login' => $_POST['username'],
        'user_password' => $_POST['password'],
        'remember' => true
    );

    $user = wp_signon($credentials);
    
    if (!is_wp_error($user)) {
        wp_send_json_success(array(
            'redirect' => home_url('/dashboard')
        ));
    } else {
        wp_send_json_error(array(
            'message' => $user->get_error_message()
        ));
    }
}
add_action('wp_ajax_nopriv_mobile_auth_login', 'handle_mobile_auth_login');

function handle_mobile_auth_register() {
    check_ajax_referer('mobile_auth_nonce', 'security');
    
    $user_data = array(
        'user_login' => $_POST['username'],
        'user_email' => $_POST['email'],
        'user_pass' => $_POST['password'],
        'role' => 'subscriber'
    );

    $user_id = wp_insert_user($user_data);
    
    if (!is_wp_error($user_id)) {
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_send_json_success(array(
            'redirect' => home_url('/dashboard')
        ));
    } else {
        wp_send_json_error(array(
            'message' => $user_id->get_error_message()
        ));
    }
}
add_action('wp_ajax_nopriv_mobile_auth_register', 'handle_mobile_auth_register');