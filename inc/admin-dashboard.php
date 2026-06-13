<?php
/**
 * ERDU Admin Dashboard
 * Theme management panel with quick settings, module toggles, and page management
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

// ==========================================
// 1. Admin Menu Registration
// ==========================================

add_action('admin_menu', 'erdu_admin_menu');
function erdu_admin_menu()
{
    // Main menu
    add_menu_page(
        __('ERDU', 'erdu-wp'),
        __('ERDU', 'erdu-wp'),
        'manage_options',
        'erdu-dashboard',
        'erdu_dashboard_page',
        'dashicons-lightbulb',
        3
    );

    // Dashboard submenu
    add_submenu_page(
        'erdu-dashboard',
        __('Dashboard', 'erdu-wp'),
        __('Dashboard', 'erdu-wp'),
        'manage_options',
        'erdu-dashboard',
        'erdu_dashboard_page',
        1
    );

    // Customize link (external)
    add_submenu_page(
        'erdu-dashboard',
        __('Customize', 'erdu-wp'),
        __('Customize', 'erdu-wp'),
        'manage_options',
        'customize.php?autofocus[panel]=erdu_theme_options',
        '',
        2
    );

    // Settings submenu
    add_submenu_page(
        'erdu-dashboard',
        __('Settings', 'erdu-wp'),
        __('Settings', 'erdu-wp'),
        'manage_options',
        'erdu-settings',
        'erdu_settings_page',
        3
    );

    // Module Config submenu (hidden from menu, accessed via module cards)
    add_submenu_page(
        'erdu-dashboard',
        __('Module Config', 'erdu-wp'),
        __('Module Config', 'erdu-wp'),
        'manage_options',
        'erdu-module',
        'erdu_module_config_page',
        7
    );

    // License submenu
    add_submenu_page(
        'erdu-dashboard',
        __('License Activation', 'erdu-wp'),
        __('License', 'erdu-wp'),
        'manage_options',
        'erdu-license',
        'erdu_license_page',
        8
    );

    // Register Customizer panel
    add_action('customize_register', 'erdu_customizer_register');
}

// ==========================================
// 2. License Activation Page
// ==========================================

function erdu_is_theme_activated()
{
    $status = get_option('erdu_license_status', 'inactive');
    return $status === 'active';
}

function erdu_license_page()
{
    $status = get_option('erdu_license_status', 'inactive');
    $key    = get_option('erdu_license_key', '');

    if (isset($_POST['erdu_activate_license']) && check_admin_referer('erdu_license_nonce')) {
        $input_key = sanitize_text_field(wp_unslash($_POST['erdu_license_key']));
        
        // Mock activation check: Assume any key with length >= 10 is valid
        if (strlen($input_key) >= 10) {
            update_option('erdu_license_key', $input_key);
            update_option('erdu_license_status', 'active');
            $status = 'active';
            $key = $input_key;
            add_settings_error('erdu_license_messages', 'erdu_license_message', __('Theme activated successfully.', 'erdu-wp'), 'updated');
        } else {
            update_option('erdu_license_status', 'inactive');
            $status = 'inactive';
            add_settings_error('erdu_license_messages', 'erdu_license_message', __('Invalid license key. Please enter a valid commercial license.', 'erdu-wp'), 'error');
        }
    }

    if (isset($_POST['erdu_deactivate_license']) && check_admin_referer('erdu_license_nonce')) {
        delete_option('erdu_license_key');
        update_option('erdu_license_status', 'inactive');
        $status = 'inactive';
        $key = '';
        add_settings_error('erdu_license_messages', 'erdu_license_message', __('Theme deactivated.', 'erdu-wp'), 'updated');
    }
    ?>
    <div class="wrap erdu-dashboard">
        <div class="erdu-dashboard-header">
            <h1><?php _e('Theme License Activation', 'erdu-wp'); ?></h1>
        </div>

        <?php settings_errors('erdu_license_messages'); ?>

        <div class="erdu-settings-section">
            <h2><?php _e('Commercial License', 'erdu-wp'); ?></h2>
            <p class="description"><?php _e('ERDU Theme requires a commercial license to unlock all features and settings. Please enter your license key below.', 'erdu-wp'); ?></p>

            <form method="post" action="">
                <?php wp_nonce_field('erdu_license_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="erdu_license_key"><?php _e('License Key', 'erdu-wp'); ?></label></th>
                        <td>
                            <input type="text" id="erdu_license_key" name="erdu_license_key" value="<?php echo esc_attr($key); ?>" class="regular-text" <?php disabled($status, 'active'); ?>>
                            <?php if ($status === 'active') : ?>
                                <span style="color: green; font-weight: bold; margin-left: 10px;">&check; <?php _e('Activated', 'erdu-wp'); ?></span>
                            <?php else : ?>
                                <span style="color: red; font-weight: bold; margin-left: 10px;">&cross; <?php _e('Not Activated', 'erdu-wp'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <?php if ($status === 'active') : ?>
                        <input type="submit" name="erdu_deactivate_license" class="button" value="<?php _e('Deactivate License', 'erdu-wp'); ?>" onclick="return confirm('<?php _e('Are you sure you want to deactivate?', 'erdu-wp'); ?>');">
                    <?php else : ?>
                        <input type="submit" name="erdu_activate_license" class="button button-primary" value="<?php _e('Activate Theme', 'erdu-wp'); ?>">
                    <?php endif; ?>
                </p>
            </form>
        </div>
    </div>
    <?php
}

add_action('admin_notices', 'erdu_license_admin_notice');
function erdu_license_admin_notice()
{
    if (!erdu_is_theme_activated() && current_user_can('manage_options')) {
        // Exclude the license page itself
        if (isset($_GET['page']) && $_GET['page'] === 'erdu-license') {
            return;
        }
        echo '<div class="notice notice-error"><p><strong>' . __('ERDU Theme Action Required:', 'erdu-wp') . '</strong> ' . __('The theme is not activated. All modifications and settings are disabled. Please <a href="' . admin_url('admin.php?page=erdu-license') . '">activate your commercial license</a> to enable full functionality.', 'erdu-wp') . '</p></div>';
    }
}

add_action('admin_init', 'erdu_restrict_unactivated_access');
function erdu_restrict_unactivated_access() {
    if (!erdu_is_theme_activated() && current_user_can('manage_options')) {
        global $pagenow;
        
        // Restrict Customizer
        if ($pagenow === 'customize.php') {
            wp_die(__('Theme is not activated. Customizer is disabled. Please activate your commercial license.', 'erdu-wp'));
        }

        // Restrict ACF Options Pages
        if ($pagenow === 'admin.php' && isset($_GET['page'])) {
            $restricted_pages = array('erdu-theme-colors', 'erdu-header-settings', 'erdu-footer-settings');
            if (in_array($_GET['page'], $restricted_pages)) {
                wp_redirect(admin_url('admin.php?page=erdu-license'));
                exit;
            }
        }
    }
}

add_action('acf/validate_save_post', 'erdu_acf_validate_save_post', 10, 0);
function erdu_acf_validate_save_post() {
    if (!erdu_is_theme_activated()) {
        acf_add_validation_error('', __('Theme is not activated. You cannot modify settings or content. Please activate your commercial license.', 'erdu-wp'));
    }
}

// ==========================================
// 3. Dashboard Page
// ==========================================

function erdu_dashboard_page()
{
    // Handle module toggle
    if (isset($_POST['erdu_toggle_module']) && check_admin_referer('erdu_dashboard_nonce')) {
        if (!erdu_is_theme_activated()) {
            add_settings_error('erdu_messages', 'erdu_message', __('Theme not activated. Modifications are disabled.', 'erdu-wp'), 'error');
        } else {
            $module = sanitize_key($_POST['erdu_toggle_module']);
            $state  = isset($_POST['erdu_module_state']) ? true : false;
            $modules = get_option('erdu_modules', erdu_default_modules());
            if (isset($modules[$module])) {
                $modules[$module]['enabled'] = $state;
                update_option('erdu_modules', $modules);
            }
            wp_redirect(admin_url('admin.php?page=erdu-dashboard&saved=1'));
            exit;
        }
    }

    // Handle quick link clicks
    if (isset($_GET['saved'])) {
        add_settings_error('erdu_messages', 'erdu_message', __('Settings saved.', 'erdu-wp'), 'updated');
    }

    $modules = get_option('erdu_modules', erdu_default_modules());

    $page_counts = wp_count_posts('page');
    $product_counts = wp_count_posts('product');
    $case_counts = wp_count_posts('erdu_case');

    $page_count = isset($page_counts->publish) ? (int) $page_counts->publish : 0;
    $product_count = isset($product_counts->publish) ? (int) $product_counts->publish : 0;
    $case_count = isset($case_counts->publish) ? (int) $case_counts->publish : 0;
    ?>
    <div class="wrap erdu-dashboard">
        <div class="erdu-dashboard-header">
            <div class="erdu-dashboard-brand">
                <div class="erdu-dashboard-logo">
                    <span class="erdu-bg-primary" style="color: #fff; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-weight: bold;">E</span>
                    <h1><?php _e('ERDU Lighting', 'erdu-wp'); ?></h1>
                </div>
                <span class="erdu-dashboard-version">v<?php echo ERDU_VERSION; ?></span>
            </div>
            <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="erdu-btn-customize">
                <span class="dashicons dashicons-admin-customizer"></span>
                <?php _e('Go to Customizer', 'erdu-wp'); ?> 
            </a>
        </div>

        <?php settings_errors('erdu_messages'); ?>

        <!-- Stats Bar -->
        <div class="erdu-stats-bar">
            <div class="erdu-stat-item">
                <span class="erdu-stat-number"><?php echo intval($product_count); ?></span>
                <span class="erdu-stat-label"><?php _e('Products', 'erdu-wp'); ?></span>
            </div>
            <div class="erdu-stat-item">
                <span class="erdu-stat-number"><?php echo intval($case_count); ?></span>
                <span class="erdu-stat-label"><?php _e('Case Studies', 'erdu-wp'); ?></span>
            </div>
            <div class="erdu-stat-item">
                <a href="<?php echo esc_url(admin_url('edit.php?post_type=page')); ?>" class="erdu-btn-manage">
                    <?php _e('Manage Pages', 'erdu-wp'); ?>
                </a>
            </div>
        </div>

        <!-- Quick Settings — Global -->
        <div class="erdu-section-title">
            <h2><?php _e('Quick Settings', 'erdu-wp'); ?></h2>
        </div>
        <div class="erdu-quick-settings">
            <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=title_tagline')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-format-image"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Site Identity', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('Customize', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-theme-colors')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-admin-generic"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Theme Settings', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('Theme Colors', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-header-settings')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-menu-alt3"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Header', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('ACF Settings', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-list-view"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Navigation Menu', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('Settings', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-footer-settings')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-align-full-width"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Footer', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('ACF Settings', 'erdu-wp'); ?></span>
                </div>
            </a>
        </div>

        <!-- Quick Settings — Content Modules -->
        <div class="erdu-section-title">
            <h2><?php _e('Content Modules', 'erdu-wp'); ?></h2>
        </div>
        <div class="erdu-quick-settings">
            <a href="<?php echo esc_url(admin_url('edit.php')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-welcome-write-blog"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Blog', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('Posts', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=erdu_case')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-portfolio"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Case Studies', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('CPT', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=erdu_news')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-format-aside"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('News', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('CPT', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=product')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-cart"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Products', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('WooCommerce', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=erdu_exhibition')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-calendar-alt"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Exhibitions', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('CPT', 'erdu-wp'); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-footer-settings')); ?>" class="erdu-setting-card">
                <div class="erdu-setting-icon dashicons dashicons-admin-generic"></div>
                <div class="erdu-setting-info">
                    <h3><?php _e('Footer Config', 'erdu-wp'); ?></h3>
                    <span class="erdu-setting-action"><?php _e('ACF', 'erdu-wp'); ?></span>
                </div>
            </a>
        </div>

        <!-- Module Toggles -->
        <div class="erdu-section-title">
            <h2><?php _e('Modules', 'erdu-wp'); ?></h2>
            <div class="erdu-module-actions">
                <button type="button" class="erdu-link-btn" onclick="document.querySelectorAll('.erdu-module-toggle').forEach(function(t){t.checked=true;}); return false;"><?php _e('Activate All', 'erdu-wp'); ?></button>
                <button type="button" class="erdu-link-btn" onclick="document.querySelectorAll('.erdu-module-toggle').forEach(function(t){t.checked=false;}); return false;"><?php _e('Deactivate All', 'erdu-wp'); ?></button>
            </div>
        </div>
        <div class="erdu-modules-grid">
            <?php foreach ($modules as $key => $module) : ?>
                <div class="erdu-module-card">
                    <div class="erdu-module-info">
                        <h4><?php echo esc_html($module['title']); ?></h4>
                        <span class="erdu-module-meta">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-module&module=' . $key)); ?>"><?php _e('Configure', 'erdu-wp'); ?></a>
                        </span>
                    </div>
                    <form method="post" action="" class="erdu-module-form">
                        <?php wp_nonce_field('erdu_dashboard_nonce'); ?>
                        <input type="hidden" name="erdu_toggle_module" value="<?php echo esc_attr($key); ?>">
                        <label class="erdu-switch">
                            <input type="checkbox" name="erdu_module_state" class="erdu-module-toggle" value="1" <?php checked($module['enabled']); ?> onchange="this.form.submit();">
                            <span class="erdu-slider"></span>
                        </label>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

// ==========================================
// 3. Settings Page
// ==========================================

function erdu_settings_page()
{
    // Save settings
    if (isset($_POST['erdu_save_settings']) && check_admin_referer('erdu_settings_nonce')) {
        if (!erdu_is_theme_activated()) {
            add_settings_error('erdu_settings_messages', 'erdu_settings_message', __('Theme not activated. Modifications are disabled.', 'erdu-wp'), 'error');
        } else {
            $settings = array(
                'header_sticky'     => isset($_POST['erdu_header_sticky']) ? true : false,
                'show_breadcrumb'   => isset($_POST['erdu_show_breadcrumb']) ? true : false,
                'show_cta'          => isset($_POST['erdu_show_cta']) ? true : false,
                'phone'             => sanitize_text_field(wp_unslash($_POST['erdu_phone'] ?? '')),
                'email'             => sanitize_email(wp_unslash($_POST['erdu_email'] ?? '')),
                'address'           => sanitize_textarea_field(wp_unslash($_POST['erdu_address'] ?? '')),
                'hours'             => sanitize_text_field(wp_unslash($_POST['erdu_hours'] ?? '')),
                'facebook'          => esc_url_raw(wp_unslash($_POST['erdu_facebook'] ?? '')),
                'linkedin'          => esc_url_raw(wp_unslash($_POST['erdu_linkedin'] ?? '')),
                'youtube'           => esc_url_raw(wp_unslash($_POST['erdu_youtube'] ?? '')),
                'instagram'         => esc_url_raw(wp_unslash($_POST['erdu_instagram'] ?? '')),
                'twitter'           => esc_url_raw(wp_unslash($_POST['erdu_twitter'] ?? '')),
                'whatsapp'          => esc_url_raw(wp_unslash($_POST['erdu_whatsapp'] ?? '')),
                'wechat'            => sanitize_text_field(wp_unslash($_POST['erdu_wechat'] ?? '')),
                'tiktok'            => esc_url_raw(wp_unslash($_POST['erdu_tiktok'] ?? '')),
                'analytics_id'      => sanitize_text_field(wp_unslash($_POST['erdu_analytics_id'] ?? '')),
            );
            update_option('erdu_settings', $settings);
            add_settings_error('erdu_settings_messages', 'erdu_settings_message', __('Settings saved successfully.', 'erdu-wp'), 'updated');
        }
    }

    // Reset to defaults
    if (isset($_POST['erdu_reset_settings']) && check_admin_referer('erdu_settings_nonce')) {
        if (!erdu_is_theme_activated()) {
            add_settings_error('erdu_settings_messages', 'erdu_settings_message', __('Theme not activated. Modifications are disabled.', 'erdu-wp'), 'error');
        } else {
            delete_option('erdu_settings');
            add_settings_error('erdu_settings_messages', 'erdu_settings_message', __('Settings reset to defaults.', 'erdu-wp'), 'updated');
        }
    }

    $s = get_option('erdu_settings', erdu_default_settings());
    ?>
    <div class="wrap erdu-dashboard">
        <div class="erdu-dashboard-header">
            <h1><?php _e('Theme Settings', 'erdu-wp'); ?></h1>
        </div>

        <?php settings_errors('erdu_settings_messages'); ?>

        <form method="post" action="" class="erdu-settings-form">
            <?php wp_nonce_field('erdu_settings_nonce'); ?>

            <!-- Layout -->
            <div class="erdu-settings-section">
                <h2><?php _e('Layout', 'erdu-wp'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th><?php _e('Sticky Header', 'erdu-wp'); ?></th>
                        <td>
                            <label class="erdu-switch">
                                <input type="checkbox" name="erdu_header_sticky" <?php checked($s['header_sticky']); ?>>
                                <span class="erdu-slider"></span>
                            </label>
                            <span class="description"><?php _e('Header stays fixed when scrolling', 'erdu-wp'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Breadcrumb', 'erdu-wp'); ?></th>
                        <td>
                            <label class="erdu-switch">
                                <input type="checkbox" name="erdu_show_breadcrumb" <?php checked($s['show_breadcrumb']); ?>>
                                <span class="erdu-slider"></span>
                            </label>
                            <span class="description"><?php _e('Show breadcrumb navigation on inner pages', 'erdu-wp'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('CTA Section', 'erdu-wp'); ?></th>
                        <td>
                            <label class="erdu-switch">
                                <input type="checkbox" name="erdu_show_cta" <?php checked($s['show_cta']); ?>>
                                <span class="erdu-slider"></span>
                            </label>
                            <span class="description"><?php _e('Show call-to-action banners on pages', 'erdu-wp'); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Contact Info -->
            <div class="erdu-settings-section">
                <h2><?php _e('Contact Information', 'erdu-wp'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th><label for="erdu_phone"><?php _e('Phone', 'erdu-wp'); ?></label></th>
                        <td><input type="text" id="erdu_phone" name="erdu_phone" value="<?php echo esc_attr($s['phone']); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_email"><?php _e('Email', 'erdu-wp'); ?></label></th>
                        <td><input type="email" id="erdu_email" name="erdu_email" value="<?php echo esc_attr($s['email']); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_address"><?php _e('Address', 'erdu-wp'); ?></label></th>
                        <td><textarea id="erdu_address" name="erdu_address" rows="3" class="large-text"><?php echo esc_textarea($s['address']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_hours"><?php _e('Working Hours', 'erdu-wp'); ?></label></th>
                        <td><input type="text" id="erdu_hours" name="erdu_hours" value="<?php echo esc_attr($s['hours'] ?? ''); ?>" class="regular-text" placeholder="Mon - Fri, 9:00 - 18:00"></td>
                    </tr>
                </table>
            </div>

            <!-- Social Media -->
            <div class="erdu-settings-section">
                <h2><?php _e('Social Media Links', 'erdu-wp'); ?></h2>
                <p class="description"><?php _e('These links will be used globally in Header and Footer if their respective switches are enabled.', 'erdu-wp'); ?></p>
                <table class="form-table">
                    <tr>
                        <th><label for="erdu_facebook"><?php _e('Facebook', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_facebook" name="erdu_facebook" value="<?php echo esc_attr($s['facebook']); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_linkedin"><?php _e('LinkedIn', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_linkedin" name="erdu_linkedin" value="<?php echo esc_attr($s['linkedin']); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_youtube"><?php _e('YouTube', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_youtube" name="erdu_youtube" value="<?php echo esc_attr($s['youtube']); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_instagram"><?php _e('Instagram', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_instagram" name="erdu_instagram" value="<?php echo esc_attr($s['instagram']); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_twitter"><?php _e('Twitter / X', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_twitter" name="erdu_twitter" value="<?php echo esc_attr($s['twitter'] ?? ''); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_tiktok"><?php _e('TikTok', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_tiktok" name="erdu_tiktok" value="<?php echo esc_attr($s['tiktok'] ?? ''); ?>" class="regular-text" placeholder="https://"></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_whatsapp"><?php _e('WhatsApp', 'erdu-wp'); ?></label></th>
                        <td><input type="url" id="erdu_whatsapp" name="erdu_whatsapp" value="<?php echo esc_attr($s['whatsapp'] ?? ''); ?>" class="regular-text" placeholder="https://wa.me/..."></td>
                    </tr>
                    <tr>
                        <th><label for="erdu_wechat"><?php _e('WeChat ID', 'erdu-wp'); ?></label></th>
                        <td><input type="text" id="erdu_wechat" name="erdu_wechat" value="<?php echo esc_attr($s['wechat'] ?? ''); ?>" class="regular-text" placeholder="WeChat ID"></td>
                    </tr>
                </table>
            </div>

            <!-- Analytics -->
            <div class="erdu-settings-section">
                <h2><?php _e('Analytics', 'erdu-wp'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th><label for="erdu_analytics_id"><?php _e('Google Analytics ID', 'erdu-wp'); ?></label></th>
                        <td><input type="text" id="erdu_analytics_id" name="erdu_analytics_id" value="<?php echo esc_attr($s['analytics_id']); ?>" class="regular-text" placeholder="G-XXXXXXXXXX"></td>
                    </tr>
                </table>
            </div>

            <p class="submit">
                <input type="submit" name="erdu_save_settings" class="button button-primary" value="<?php _e('Save Settings', 'erdu-wp'); ?>">
                <input type="submit" name="erdu_reset_settings" class="button" value="<?php _e('Reset to Defaults', 'erdu-wp'); ?>" onclick="return confirm('<?php _e('Are you sure? This will reset all settings.', 'erdu-wp'); ?>');">
            </p>
        </form>
    </div>
    <?php
}

// ==========================================
// 5. Default Data
// ==========================================

function erdu_default_modules()
{
    return array(
        'products'    => array(
            'title'   => __('Products', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-cart',
            'fields'  => array(
                'section_title'  => array('label' => __('Section Title', 'erdu-wp'),       'type' => 'text',    'default' => __('Explore Our Product Series', 'erdu-wp')),
                'section_desc'   => array('label' => __('Section Description', 'erdu-wp'), 'type' => 'textarea','default' => __('Comprehensive 48V magnetic track lighting solutions', 'erdu-wp')),
                'per_page'       => array('label' => __('Products Per Page', 'erdu-wp'),   'type' => 'number',  'default' => 12),
                'show_filter'    => array('label' => __('Show Category Filter', 'erdu-wp'),'type' => 'toggle',  'default' => true),
                'show_search'    => array('label' => __('Show Search Box', 'erdu-wp'),     'type' => 'toggle',  'default' => true),
            ),
        ),
        'cases'       => array(
            'title'   => __('Case Studies', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-portfolio',
            'fields'  => array(
                'section_title' => array('label' => __('Section Title', 'erdu-wp'),      'type' => 'text',    'default' => __('Case Studies', 'erdu-wp')),
                'section_desc'  => array('label' => __('Section Description', 'erdu-wp'),'type' => 'textarea','default' => __('See how ERDU transforms spaces worldwide', 'erdu-wp')),
                'per_page'      => array('label' => __('Cases Per Page', 'erdu-wp'),     'type' => 'number',  'default' => 9),
                'show_filter'   => array('label' => __('Show Industry Filter', 'erdu-wp'),'type' => 'toggle', 'default' => true),
            ),
        ),
        'exhibitions' => array(
            'title'   => __('Exhibitions', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-calendar-alt',
            'fields'  => array(
                'section_title'   => array('label' => __('Section Title', 'erdu-wp'),       'type' => 'text',    'default' => __('Upcoming Exhibitions', 'erdu-wp')),
                'section_desc'    => array('label' => __('Section Description', 'erdu-wp'), 'type' => 'textarea','default' => __('Meet us at global lighting exhibitions', 'erdu-wp')),
                'show_past'       => array('label' => __('Show Past Exhibitions', 'erdu-wp'),'type' => 'toggle',  'default' => false),
                'max_display'     => array('label' => __('Max to Display', 'erdu-wp'),      'type' => 'number',  'default' => 4),
            ),
        ),
        'news'        => array(
            'title'   => __('News', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-media-document',
            'fields'  => array(
                'section_title' => array('label' => __('Section Title', 'erdu-wp'),      'type' => 'text',    'default' => __('Latest News', 'erdu-wp')),
                'section_desc'  => array('label' => __('Section Description', 'erdu-wp'),'type' => 'textarea','default' => __('Stay updated with ERDU', 'erdu-wp')),
                'per_page'      => array('label' => __('Articles Per Page', 'erdu-wp'),  'type' => 'number',  'default' => 6),
                'show_excerpt'  => array('label' => __('Show Excerpt', 'erdu-wp'),       'type' => 'toggle',  'default' => true),
            ),
        ),
        'distributor' => array(
            'title'   => __('Distributor Program', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-groups',
            'fields'  => array(
                'section_title'  => array('label' => __('Page Title', 'erdu-wp'),         'type' => 'text',    'default' => __('Global Distributor Program', 'erdu-wp')),
                'section_desc'   => array('label' => __('Page Description', 'erdu-wp'),   'type' => 'textarea','default' => __('Partner with ERDU to grow your lighting business', 'erdu-wp')),
                'success_message'=> array('label' => __('Success Message', 'erdu-wp'),   'type' => 'textarea','default' => __('Thank you! We will review your application within 3 business days.', 'erdu-wp')),
                'recipient_email'=> array('label' => __('Recipient Email', 'erdu-wp'),    'type' => 'text',    'default' => get_option('admin_email')),
            ),
        ),
        'contact_form'=> array(
            'title'   => __('Contact Form', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-email-alt',
            'fields'  => array(
                'section_title'   => array('label' => __('Form Title', 'erdu-wp'),        'type' => 'text',    'default' => __('Send Us a Message', 'erdu-wp')),
                'section_desc'    => array('label' => __('Form Description', 'erdu-wp'),  'type' => 'textarea','default' => __('Fill out the form below and we will get back to you within 24 hours.', 'erdu-wp')),
                'success_message' => array('label' => __('Success Message', 'erdu-wp'),   'type' => 'textarea','default' => __('Thank you for contacting us. We will get back to you within 24 hours.', 'erdu-wp')),
                'recipient_email' => array('label' => __('Recipient Email', 'erdu-wp'),   'type' => 'text',    'default' => get_option('admin_email')),
                'show_phone'      => array('label' => __('Show Phone Field', 'erdu-wp'),  'type' => 'toggle',  'default' => true),
                'show_company'    => array('label' => __('Show Company Field', 'erdu-wp'),'type' => 'toggle',  'default' => true),
            ),
        ),
        'testimonials'=> array(
            'title'   => __('Testimonials', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-format-quote',
            'fields'  => array(
                'section_title' => array('label' => __('Section Title', 'erdu-wp'),      'type' => 'text',    'default' => __('What Our Clients Say', 'erdu-wp')),
                'section_desc'  => array('label' => __('Section Description', 'erdu-wp'),'type' => 'textarea','default' => __('Trusted by lighting professionals worldwide', 'erdu-wp')),
                'items'         => array('label' => __('Testimonials', 'erdu-wp'),       'type' => 'repeater',
                    'sub_fields' => array(
                        'quote'  => array('label' => __('Quote', 'erdu-wp'),  'type' => 'textarea'),
                        'author' => array('label' => __('Author', 'erdu-wp'), 'type' => 'text'),
                        'role'   => array('label' => __('Role', 'erdu-wp'),   'type' => 'text'),
                    ),
                ),
            ),
        ),
        'newsletter'  => array(
            'title'   => __('Newsletter', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-email',
            'fields'  => array(
                'section_title' => array('label' => __('Title', 'erdu-wp'),         'type' => 'text',    'default' => __('Stay Updated', 'erdu-wp')),
                'section_desc'  => array('label' => __('Description', 'erdu-wp'),   'type' => 'textarea','default' => __('Subscribe to get the latest product updates and lighting insights.', 'erdu-wp')),
                'placeholder'   => array('label' => __('Input Placeholder', 'erdu-wp'),'type' => 'text',  'default' => __('Enter your email', 'erdu-wp')),
                'button_text'   => array('label' => __('Button Text', 'erdu-wp'),   'type' => 'text',    'default' => __('Subscribe', 'erdu-wp')),
            ),
        ),
        'faq'         => array(
            'title'   => __('FAQ', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-editor-help',
            'fields'  => array(
                'section_title' => array('label' => __('Section Title', 'erdu-wp'),      'type' => 'text',    'default' => __('Frequently Asked Questions', 'erdu-wp')),
                'items'         => array('label' => __('FAQ Items', 'erdu-wp'),          'type' => 'repeater',
                    'sub_fields' => array(
                        'question' => array('label' => __('Question', 'erdu-wp'), 'type' => 'text'),
                        'answer'   => array('label' => __('Answer', 'erdu-wp'),   'type' => 'textarea'),
                    ),
                ),
            ),
        ),
        'downloads'   => array(
            'title'   => __('Downloads', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-download',
            'fields'  => array(
                'require_login' => array('label' => __('Require Login to Download', 'erdu-wp'), 'type' => 'toggle', 'default' => true),
                'exclude_cn_ip' => array('label' => __('Exclude China IPs', 'erdu-wp'), 'type' => 'toggle', 'default' => false),
            ),
        ),
        'breadcrumb'  => array(
            'title'   => __('Breadcrumb', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-admin-links',
            'fields'  => array(
                'separator'  => array('label' => __('Separator', 'erdu-wp'),      'type' => 'text',   'default' => '/'),
                'home_text'  => array('label' => __('Home Text', 'erdu-wp'),      'type' => 'text',   'default' => __('Home', 'erdu-wp')),
                'show_home'  => array('label' => __('Show Home Link', 'erdu-wp'), 'type' => 'toggle', 'default' => true),
            ),
        ),
        'social_share'=> array(
            'title'   => __('Social Share', 'erdu-wp'),
            'enabled' => true,
            'icon'    => 'dashicons-share',
            'fields'  => array(
                'show_facebook'  => array('label' => __('Show Facebook', 'erdu-wp'),  'type' => 'toggle', 'default' => true),
                'show_linkedin'  => array('label' => __('Show LinkedIn', 'erdu-wp'),  'type' => 'toggle', 'default' => true),
                'show_twitter'   => array('label' => __('Show X / Twitter', 'erdu-wp'),'type' => 'toggle', 'default' => true),
                'show_email'     => array('label' => __('Show Email', 'erdu-wp'),     'type' => 'toggle', 'default' => true),
            ),
        ),
        'analytics'   => array(
            'title'   => __('Analytics', 'erdu-wp'),
            'enabled' => false,
            'icon'    => 'dashicons-chart-area',
            'fields'  => array(
                'ga_id'   => array('label' => __('Google Analytics ID', 'erdu-wp'), 'type' => 'text', 'default' => '', 'placeholder' => 'G-XXXXXXXXXX'),
                'gtm_id'  => array('label' => __('Google Tag Manager ID', 'erdu-wp'),'type' => 'text', 'default' => '', 'placeholder' => 'GTM-XXXXXX'),
                'fb_pixel'=> array('label' => __('Facebook Pixel ID', 'erdu-wp'),  'type' => 'text', 'default' => '', 'placeholder' => 'XXXXXXXXXX'),
            ),
        ),
    );
}

function erdu_default_settings()
{
    return array(
        'header_sticky'   => true,
        'show_breadcrumb' => true,
        'show_cta'        => true,
        'phone'           => '+86-760-22380830',
        'email'           => 'gg@erduled.com',
        'address'         => '6th Floor, JinYe Building, Tongyi Industrial District, Guzhen, Zhongshan, Guangdong, China',
        'facebook'        => '',
        'linkedin'        => '',
        'youtube'         => '',
        'instagram'       => '',
        'twitter'         => '',
        'whatsapp'        => '',
        'wechat'          => '',
        'tiktok'          => '',
        'analytics_id'    => '',
    );
}

// ==========================================
// 6. Customizer Integration
// ==========================================

function erdu_customizer_register($wp_customize)
{
    // NOTE: All ERDU settings including colors are now managed via ACF Theme Colors.
    // Customizer integration is intentionally removed to keep color settings unified.
}
add_action('customize_register', 'erdu_customizer_register');

// ==========================================
// 7. Auto-create Navigation Menu
// ==========================================

add_action('after_switch_theme', 'erdu_create_navigation_menu', 20); // Priority 20 = after page creation
function erdu_create_navigation_menu()
{
    $menu_name = 'ERDU Main Menu';
    $menu_obj  = wp_get_nav_menu_object($menu_name);
    $menu_id   = 0;

    // 如果菜单已存在且已有菜单项，直接跳过，避免重复写入
    if ($menu_obj) {
        $menu_id = $menu_obj->term_id;
        $existing_items = wp_get_nav_menu_items($menu_id);
        if ($existing_items && !is_wp_error($existing_items) && count($existing_items) > 0) {
            // 菜单已存在且有内容，不再重建
            return;
        }
    } else {
        $menu_id = wp_create_nav_menu($menu_name);
        if (is_wp_error($menu_id)) {
            return;
        }
    }

    // Menu items configuration
    $menu_items = array(
        array('slug' => 'home',        'label' => __('Home', 'erdu-wp'),        'url' => home_url('/'),              'position' => 1),
        array('slug' => 'about',       'label' => __('About Us', 'erdu-wp'),    'url' => '', 'position' => 2),
        array('slug' => 'products',    'label' => __('Products', 'erdu-wp'),    'url' => '', 'position' => 3),
        array('slug' => 'solutions',   'label' => __('Solutions', 'erdu-wp'),   'url' => '', 'position' => 4),
        array('slug' => 'quality',     'label' => __('Quality', 'erdu-wp'),     'url' => '', 'position' => 5),
        array('slug' => 'distributor', 'label' => __('Distributor', 'erdu-wp'), 'url' => '', 'position' => 6),
        array('slug' => 'cases',       'label' => __('Case Studies', 'erdu-wp'),'url' => '', 'position' => 7),
        array('slug' => 'news',        'label' => __('News', 'erdu-wp'),        'url' => '', 'position' => 8),
        array('slug' => 'contact',     'label' => __('Contact', 'erdu-wp'),     'url' => '', 'position' => 9),
    );

    // Build URL lookup from pages
    foreach ($menu_items as &$item) {
        if ($item['slug'] === 'home') {
            continue; // Home URL already set
        }
        $page = erdu_get_page_by_slug($item['slug']);
        if ($page && !is_wp_error($page)) {
            $item['url']  = get_permalink($page->ID);
            $item['page'] = $page->ID;
        } else {
            // Fallback: construct URL from slug
            $item['url'] = user_trailingslashit(home_url($item['slug']));
        }
    }
    unset($item);

    // Add items to menu
    foreach ($menu_items as $item) {
        if (!empty($item['page'])) {
            // Page link
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'     => $item['label'],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $item['page'],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $item['position'],
            ));
        } else {
            // Custom link fallback
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'   => $item['label'],
                'menu-item-url'     => $item['url'],
                'menu-item-type'    => 'custom',
                'menu-item-status'  => 'publish',
                'menu-item-position'=> $item['position'],
            ));
        }
    }

    // Assign to primary location
    $locations = get_theme_mod('nav_menu_locations', array());
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

// ==========================================
// 7. Module Config Page
// ==========================================

/**
 * Display a module selector page when no module is specified.
 *
 * @param array  $modules Available modules.
 * @param string $error   Optional error message.
 */
function erdu_module_selector_page($modules, $error = '')
{
    ?>
    <div class="wrap erdu-dashboard">
        <div class="erdu-dashboard-header">
            <div class="erdu-dashboard-brand">
                <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-dashboard')); ?>" class="erdu-back-link">
                    <span class="dashicons dashicons-arrow-left-alt"></span>
                </a>
                <h1><?php _e('Module Configuration', 'erdu-wp'); ?></h1>
            </div>
        </div>

        <?php if ($error) : ?>
            <div class="notice notice-error is-dismissible"><p><?php echo esc_html($error); ?></p></div>
        <?php endif; ?>

        <p class="description" style="margin: 20px 0;"><?php _e('Select a module below to configure its settings:', 'erdu-wp'); ?></p>

        <div class="erdu-quick-settings">
            <?php foreach ($modules as $key => $module) : ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-module&module=' . $key)); ?>" class="erdu-setting-card">
                    <div class="erdu-setting-icon dashicons <?php echo esc_attr($module['icon']); ?>"></div>
                    <div class="erdu-setting-info">
                        <h3><?php echo esc_html($module['title']); ?></h3>
                        <span class="erdu-setting-action"><?php _e('Configure', 'erdu-wp'); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function erdu_module_config_page()
{
    $module_key = isset($_GET['module']) ? sanitize_key($_GET['module']) : '';
    $defaults   = erdu_default_modules();

    // If no module specified, show module selector
    if (empty($module_key)) {
        erdu_module_selector_page($defaults);
        return;
    }

    // If invalid module key, show friendly error with module list
    if (!isset($defaults[$module_key])) {
        erdu_module_selector_page($defaults, sprintf(__('Module "%s" not found. Please select a module below:', 'erdu-wp'), esc_html($module_key)));
        return;
    }

    $module_def = $defaults[$module_key];
    $module_title = $module_def['title'];
    $saved_config = get_option('erdu_module_' . $module_key, array());

    // Handle save
    if (isset($_POST['erdu_module_save']) && check_admin_referer('erdu_module_nonce')) {
        if (!erdu_is_theme_activated()) {
            add_settings_error('erdu_module_messages', 'erdu_module_message', __('Theme not activated. Modifications are disabled.', 'erdu-wp'), 'error');
        } else {
            $new_config = array();
            foreach ($module_def['fields'] as $field_key => $field_def) {
                $input_name = 'erdu_mod_' . $field_key;
                if ($field_def['type'] === 'toggle') {
                    $new_config[$field_key] = isset($_POST[$input_name]) ? true : false;
                } elseif ($field_def['type'] === 'number') {
                    $new_config[$field_key] = intval($_POST[$input_name] ?? $field_def['default']);
                } elseif ($field_def['type'] === 'textarea') {
                    $new_config[$field_key] = sanitize_textarea_field(wp_unslash($_POST[$input_name] ?? ''));
                } elseif ($field_def['type'] === 'repeater') {
                    // Handle repeater - expect arrays of sub-fields
                    $repeater_data = array();
                    if (isset($_POST[$input_name]) && is_array($_POST[$input_name])) {
                        foreach ($_POST[$input_name] as $index => $row) {
                            $clean_row = array();
                            foreach ($field_def['sub_fields'] as $sub_key => $sub_def) {
                                $clean_row[$sub_key] = sanitize_text_field(wp_unslash($row[$sub_key] ?? ''));
                            }
                            // Only add non-empty rows
                            $has_value = false;
                            foreach ($clean_row as $v) {
                                if (!empty($v)) { $has_value = true; break; }
                            }
                            if ($has_value) {
                                $repeater_data[] = $clean_row;
                            }
                        }
                    }
                    $new_config[$field_key] = $repeater_data;
                } else {
                    $new_config[$field_key] = sanitize_text_field(wp_unslash($_POST[$input_name] ?? ''));
                }
            }
            update_option('erdu_module_' . $module_key, $new_config);
            $saved_config = $new_config;
            add_settings_error('erdu_module_messages', 'erdu_module_message', __('Module settings saved.', 'erdu-wp'), 'updated');
        }
    }

    // Reset to defaults
    if (isset($_POST['erdu_module_reset']) && check_admin_referer('erdu_module_nonce')) {
        if (!erdu_is_theme_activated()) {
            add_settings_error('erdu_module_messages', 'erdu_module_message', __('Theme not activated. Modifications are disabled.', 'erdu-wp'), 'error');
        } else {
            delete_option('erdu_module_' . $module_key);
            $saved_config = array();
            add_settings_error('erdu_module_messages', 'erdu_module_message', __('Module settings reset to defaults.', 'erdu-wp'), 'updated');
        }
    }

    ?>
    <div class="wrap erdu-dashboard">
        <div class="erdu-dashboard-header">
            <div class="erdu-dashboard-brand">
                <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-dashboard')); ?>" class="erdu-back-link">
                    <span class="dashicons dashicons-arrow-left-alt"></span>
                </a>
                <h1><?php printf(__('%s - Module Configuration', 'erdu-wp'), esc_html($module_title)); ?></h1>
            </div>
            <span class="erdu-dashboard-version"><?php echo esc_html($module_key); ?></span>
        </div>

        <?php settings_errors('erdu_module_messages'); ?>

        <form method="post" action="" class="erdu-settings-form">
            <?php wp_nonce_field('erdu_module_nonce'); ?>

            <?php foreach ($module_def['fields'] as $field_key => $field_def) :
                $input_name = 'erdu_mod_' . $field_key;
                $value = isset($saved_config[$field_key]) ? $saved_config[$field_key] : $field_def['default'];
            ?>
                <div class="erdu-settings-section">
                    <?php if ($field_def['type'] === 'repeater') : ?>
                        <h2><?php echo esc_html($field_def['label']); ?></h2>
                        <p class="description"><?php _e('Add, edit, or remove items below.', 'erdu-wp'); ?></p>
                        <div class="erdu-repeater" data-module="<?php echo esc_attr($module_key); ?>" data-field="<?php echo esc_attr($field_key); ?>">
                            <div class="erdu-repeater-items">
                                <?php
                                $items = is_array($value) ? $value : array();
                                // Ensure at least one empty row
                                if (empty($items)) { $items = array(array_fill_keys(array_keys($field_def['sub_fields']), '')); }
                                foreach ($items as $index => $row) : ?>
                                    <div class="erdu-repeater-row" data-index="<?php echo $index; ?>">
                                        <div class="erdu-repeater-row-header">
                                            <span class="erdu-repeater-handle">&#9776;</span>
                                            <span class="erdu-repeater-label">#<?php echo $index + 1; ?></span>
                                            <button type="button" class="erdu-repeater-remove" title="<?php _e('Remove', 'erdu-wp'); ?>">&times;</button>
                                        </div>
                                        <div class="erdu-repeater-fields">
                                            <?php foreach ($field_def['sub_fields'] as $sub_key => $sub_def) :
                                                $sub_value = isset($row[$sub_key]) ? $row[$sub_key] : '';
                                                $sub_name = $input_name . '[' . $index . '][' . $sub_key . ']';
                                            ?>
                                                <div class="erdu-repeater-field">
                                                    <label><?php echo esc_html($sub_def['label']); ?></label>
                                                    <?php if ($sub_def['type'] === 'textarea') : ?>
                                                        <textarea name="<?php echo esc_attr($sub_name); ?>" rows="3" class="large-text"><?php echo esc_textarea($sub_value); ?></textarea>
                                                    <?php else : ?>
                                                        <input type="text" name="<?php echo esc_attr($sub_name); ?>" value="<?php echo esc_attr($sub_value); ?>" class="regular-text">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="erdu-repeater-add button">
                                <span class="dashicons dashicons-plus-alt2"></span>
                                <?php _e('Add Item', 'erdu-wp'); ?>
                            </button>
                        </div>
                    <?php elseif ($field_def['type'] === 'toggle') : ?>
                        <table class="form-table">
                            <tr>
                                <th><label for="<?php echo esc_attr($input_name); ?>"><?php echo esc_html($field_def['label']); ?></label></th>
                                <td>
                                    <label class="erdu-switch">
                                        <input type="checkbox" name="<?php echo esc_attr($input_name); ?>" id="<?php echo esc_attr($input_name); ?>" value="1" <?php checked($value); ?>>
                                        <span class="erdu-slider"></span>
                                    </label>
                                </td>
                            </tr>
                        </table>
                    <?php elseif ($field_def['type'] === 'textarea') : ?>
                        <table class="form-table">
                            <tr>
                                <th><label for="<?php echo esc_attr($input_name); ?>"><?php echo esc_html($field_def['label']); ?></label></th>
                                <td>
                                    <textarea name="<?php echo esc_attr($input_name); ?>" id="<?php echo esc_attr($input_name); ?>" rows="4" class="large-text"><?php echo esc_textarea($value); ?></textarea>
                                    <?php if (!empty($field_def['placeholder'])) : ?>
                                        <p class="description"><?php echo esc_html($field_def['placeholder']); ?></p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    <?php else : // text, number ?>
                        <table class="form-table">
                            <tr>
                                <th><label for="<?php echo esc_attr($input_name); ?>"><?php echo esc_html($field_def['label']); ?></label></th>
                                <td>
                                    <input type="<?php echo esc_attr($field_def['type']); ?>"
                                           name="<?php echo esc_attr($input_name); ?>"
                                           id="<?php echo esc_attr($input_name); ?>"
                                           value="<?php echo esc_attr($value); ?>"
                                           class="regular-text"
                                           <?php if (!empty($field_def['placeholder'])) echo 'placeholder="' . esc_attr($field_def['placeholder']) . '"'; ?>
                                           <?php if ($field_def['type'] === 'number' && isset($field_def['default'])) echo 'min="1"'; ?>>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <p class="submit">
                <input type="submit" name="erdu_module_save" class="button button-primary" value="<?php _e('Save Module Settings', 'erdu-wp'); ?>">
                <input type="submit" name="erdu_module_reset" class="button" value="<?php _e('Reset to Defaults', 'erdu-wp'); ?>" onclick="return confirm('<?php _e('Reset all settings for this module?', 'erdu-wp'); ?>');">
                <a href="<?php echo esc_url(admin_url('admin.php?page=erdu-dashboard')); ?>" class="button"><?php _e('Back to Dashboard', 'erdu-wp'); ?></a>
            </p>
        </form>
    </div>

    <!-- Repeater JS Template -->
    <script type="text/template" id="erdu-repeater-template">
        <div class="erdu-repeater-row" data-index="{index}">
            <div class="erdu-repeater-row-header">
                <span class="erdu-repeater-handle">&#9776;</span>
                <span class="erdu-repeater-label">#{index_label}</span>
                <button type="button" class="erdu-repeater-remove" title="<?php _e('Remove', 'erdu-wp'); ?>">&times;</button>
            </div>
            <div class="erdu-repeater-fields">
                {fields}
            </div>
        </div>
    </script>

    <script>
    (function() {
        // Repeater add/remove functionality
        document.querySelectorAll('.erdu-repeater').forEach(function(repeater) {
            var itemsContainer = repeater.querySelector('.erdu-repeater-items');
            var addBtn = repeater.querySelector('.erdu-repeater-add');
            var template = document.getElementById('erdu-repeater-template').innerHTML;

            // Extract field names from first row
            var firstRow = itemsContainer.querySelector('.erdu-repeater-row');
            var moduleField = repeater.dataset.field;

            function updateIndexes() {
                itemsContainer.querySelectorAll('.erdu-repeater-row').forEach(function(row, idx) {
                    row.dataset.index = idx;
                    row.querySelector('.erdu-repeater-label').textContent = '#' + (idx + 1);
                    row.querySelectorAll('input, textarea').forEach(function(input) {
                        var name = input.name;
                        // Update index in name
                        name = name.replace(/\[\d+\]/, '[' + idx + ']');
                        input.name = name;
                    });
                });
            }

            // Add row
            addBtn.addEventListener('click', function() {
                var count = itemsContainer.querySelectorAll('.erdu-repeater-row').length;
                var lastRow = itemsContainer.querySelector('.erdu-repeater-row:last-child');
                if (!lastRow) return;

                var newRow = lastRow.cloneNode(true);
                newRow.querySelectorAll('input, textarea').forEach(function(input) {
                    input.value = '';
                    var name = input.name.replace(/\[\d+\]/, '[' + count + ']');
                    input.name = name;
                });
                newRow.dataset.index = count;
                newRow.querySelector('.erdu-repeater-label').textContent = '#' + (count + 1);
                itemsContainer.appendChild(newRow);
                bindRemove(newRow);
            });

            // Remove row
            function bindRemove(row) {
                var removeBtn = row.querySelector('.erdu-repeater-remove');
                removeBtn.addEventListener('click', function() {
                    if (itemsContainer.querySelectorAll('.erdu-repeater-row').length > 1) {
                        row.remove();
                        updateIndexes();
                    } else {
                        // Clear last row instead of removing
                        row.querySelectorAll('input, textarea').forEach(function(input) {
                            input.value = '';
                        });
                    }
                });
            }

            itemsContainer.querySelectorAll('.erdu-repeater-row').forEach(bindRemove);
        });
    })();
    </script>
    <?php
}
