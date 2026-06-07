<?php
/**
 * Template Functions
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * Get page URL by slug
 * Falls back to pretty permalink structure if page not found
 */
function erdu_get_page_url($slug)
{
    // Try to find the page by slug
    $page = get_page_by_path($slug, OBJECT, 'page');
    if ($page && !is_wp_error($page)) {
        return get_permalink($page->ID);
    }

    // Try by title as fallback
    $page = get_page_by_title($slug);
    if ($page && !is_wp_error($page)) {
        return get_permalink($page->ID);
    }

    // Final fallback: construct URL from permalink structure
    $permalink_structure = get_option('permalink_structure');
    if ($permalink_structure) {
        return user_trailingslashit(home_url($slug));
    }
    // Plain permalinks fallback
    return add_query_arg('page_id', 0, home_url('/'));
}

/**
 * Check if current page matches URL
 * Works for pages, custom post types, and archive pages
 */
function erdu_is_current_page($url)
{
    $current_url = trailingslashit(get_permalink());
    $check_url   = trailingslashit($url);

    // Exact URL match
    if ($check_url === $current_url) {
        return true;
    }

    // Check by template and page type (avoid repeated DB queries)
    $home = trailingslashit(home_url('/'));
    if ($check_url === $home) {
        return is_front_page();
    }

    // Map URL endings to template / condition checks
    $path = wp_parse_url($url, PHP_URL_PATH);
    if ($path) {
        $slug = basename(untrailingslashit($path));
        switch ($slug) {
            case 'about':
                return is_page_template('page-about.php');
            case 'products':
                return is_page_template('page-products.php');
            case 'solutions':
                return is_page_template('page-solutions.php');
            case 'quality':
                return is_page_template('page-quality.php');
            case 'distributor':
                return is_page_template('page-distributor.php');
            case 'cases':
                return is_page_template('page-cases.php') || is_singular('erdu_case');
            case 'news':
                return is_page_template('page-news.php');
            case 'blog':
                return is_page_template('page-blog.php') || is_singular('erdu_blog') || is_post_type_archive('erdu_blog');
            case 'contact':
                return is_page_template('page-contact.php');
        }
    }

    return false;
}

/**
 * Get option with ACF fallback
 */
function erdu_get_option($key, $default = '')
{
    if (function_exists('get_field')) {
        $value = get_field($key);
        if ($value !== null && $value !== '') {
            return $value;
        }
    }
    return $default;
}

/**
 * Render section header
 */
function erdu_section_header($title, $subtitle = '')
{
    ?>
    <div class="text-center mb-10">
        <h2 class="erdu-h2"><?php echo esc_html($title); ?></h2>
        <?php if ($subtitle) : ?>
            <p class="text-gray-500 mt-2"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Render CTA section
 */
function erdu_cta_section($title, $primary_text, $primary_url, $secondary_text = '', $secondary_url = '')
{
    ?>
    <section class="py-16" style="background: linear-gradient(135deg, #F37021 0%, #D45A0F 100%);">
        <div class="erdu-container text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-6"><?php echo esc_html($title); ?></h2>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo esc_url($primary_url); ?>" class="erdu-btn erdu-btn-white">
                    <?php echo esc_html($primary_text); ?>
                </a>
                <?php if ($secondary_text) : ?>
                    <a href="<?php echo esc_url($secondary_url); ?>" class="erdu-btn erdu-btn-outline">
                        <?php echo esc_html($secondary_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Render breadcrumb
 */
function erdu_breadcrumb()
{
    // Check if breadcrumb module is enabled
    if (!erdu_module_enabled('breadcrumb')) return;
    if (is_front_page()) return;

    $sep      = erdu_module_config('breadcrumb', 'separator', '/');
    $home_text= erdu_module_config('breadcrumb', 'home_text', __('Home', 'erdu-wp'));
    $show_home= erdu_module_config('breadcrumb', 'show_home', true);
    ?>
    <div class="erdu-breadcrumb">
        <div class="erdu-container">
            <?php if ($show_home) : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html($home_text); ?></a>
                <span class="mx-1"><?php echo esc_html($sep); ?></span>
            <?php endif; ?>
            <span><?php the_title(); ?></span>
        </div>
    </div>
    <?php
}

/**
 * Get placeholder image
 */
function erdu_placeholder($width = 400, $height = 300)
{
    return "https://placehold.co/{$width}x{$height}/F37021/FFFFFF?text=ERDU+Lighting";
}

/**
 * Pagination
 */
function erdu_pagination()
{
    global $wp_query;
    if ($wp_query->max_num_pages <= 1) return;
    ?>
    <div class="flex justify-center mt-8 gap-2">
        <?php
        echo paginate_links(array(
            'current'   => max(1, get_query_var('paged')),
            'total'     => $wp_query->max_num_pages,
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'mid_size'  => 2,
        ));
        ?>
    </div>
    <?php
}

/**
 * Pagination for custom queries
 */
function erdu_pagination_custom($query = null)
{
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }
    if ($query->max_num_pages <= 1) return;
    ?>
    <div class="flex justify-center mt-8 gap-2">
        <?php
        echo paginate_links(array(
            'current'   => max(1, $query->query_vars['paged'] ?: 1),
            'total'     => $query->max_num_pages,
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'mid_size'  => 2,
        ));
        ?>
    </div>
    <?php
}

// ==========================================
// Custom Nav Menu Walkers
// ==========================================

/**
 * Desktop Navigation Walker
 */
class ERDU_Walker_Nav_Menu extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $is_active = false;
        if (isset($item->url)) {
            $is_active = erdu_is_current_page($item->url);
        }
        if (!$is_active) {
            $is_active = in_array('current-menu-item', $item->classes) ||
                         in_array('current-menu-parent', $item->classes) ||
                         in_array('current-menu-ancestor', $item->classes);
        }
        $class = $is_active ? 'erdu-nav-link active' : 'erdu-nav-link';
        $output .= sprintf(
            '<a href="%s" class="%s">%s</a>',
            esc_url($item->url),
            esc_attr($class),
            esc_html($item->title)
        );
    }
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}
    public function end_el(&$output, $item, $depth = 0, $args = null) {}
}

/**
 * Mobile Navigation Walker
 */
class ERDU_Walker_Mobile_Menu extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $is_active = in_array('current-menu-item', $item->classes) ||
                     in_array('current-menu-parent', $item->classes);
        if (!$is_active && isset($item->url)) {
            $is_active = erdu_is_current_page($item->url);
        }
        $class = $is_active ? 'text-orange-600 bg-orange-50 font-semibold' : 'hover:bg-gray-50 hover:text-orange-600';
        $output .= sprintf(
            '<a href="%s" class="block px-4 py-3 text-base rounded-md transition-colors %s">%s</a>',
            esc_url($item->url),
            esc_attr($class),
            esc_html($item->title)
        );
    }
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}
    public function end_el(&$output, $item, $depth = 0, $args = null) {}
}

// ==========================================
// Module System
// ==========================================

/**
 * Check if a theme module is enabled
 */
function erdu_module_enabled($module_key)
{
    $modules = get_option('erdu_modules', erdu_default_modules());
    return isset($modules[$module_key]) && !empty($modules[$module_key]['enabled']);
}

/**
 * Get theme setting value
 */
function erdu_setting($key, $default = '')
{
    $settings = get_option('erdu_settings', erdu_default_settings());
    return isset($settings[$key]) ? $settings[$key] : $default;
}

/**
 * Get module configuration value
 * Usage: erdu_module_config('products', 'section_title', __('Default', 'erdu-wp'))
 */
function erdu_module_config($module_key, $field_key, $default = '')
{
    $defaults = erdu_default_modules();
    $saved = get_option('erdu_module_' . $module_key, array());

    // Return saved value if exists
    if (isset($saved[$field_key])) {
        return $saved[$field_key];
    }

    // Return default from module definition
    if (isset($defaults[$module_key]['fields'][$field_key]['default'])) {
        return $defaults[$module_key]['fields'][$field_key]['default'];
    }

    return $default;
}

// ==========================================
// ACF Data Compatibility Helpers
// ==========================================

/**
 * Normalize metrics data from ACF (supports both Pro repeater and Free text)
 * Returns array of ['metric_label' => ..., 'metric_value' => ...]
 */
function erdu_normalize_metrics($metrics)
{
    if (empty($metrics)) {
        return array();
    }
    // Pro version: already an array of arrays
    if (is_array($metrics) && isset($metrics[0]) && is_array($metrics[0])) {
        return $metrics;
    }
    // Free version: text "Label: Value" or "Label|Value", one per line
    if (is_string($metrics)) {
        $result = array();
        $lines = preg_split('/\r\n|\r|\n/', $metrics);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            // Try "Label: Value" format
            if (strpos($line, ':') !== false) {
                list($label, $value) = explode(':', $line, 2);
                $result[] = array('metric_label' => trim($label), 'metric_value' => trim($value));
            } elseif (strpos($line, '|') !== false) {
                // Try "Label|Value" format
                list($label, $value) = explode('|', $line, 2);
                $result[] = array('metric_label' => trim($label), 'metric_value' => trim($value));
            } else {
                $result[] = array('metric_label' => $line, 'metric_value' => '');
            }
        }
        return $result;
    }
    return array();
}

/**
 * Normalize products data from ACF (supports both Pro repeater and Free text)
 * Returns array of ['product_name' => ...]
 */
function erdu_normalize_products($products)
{
    if (empty($products)) {
        return array();
    }
    // Pro version: already an array of arrays
    if (is_array($products) && isset($products[0]) && is_array($products[0])) {
        return $products;
    }
    // Free version: text, one per line
    if (is_string($products)) {
        $result = array();
        $lines = preg_split('/\r\n|\r|\n/', $products);
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $result[] = array('product_name' => $line);
            }
        }
        return $result;
    }
    return array();
}

/**
 * Normalize stats data from ACF (supports both Pro repeater and Free text)
 * Returns array of ['stat_number' => ..., 'stat_label' => ...]
 */
function erdu_normalize_stats($stats)
{
    if (empty($stats)) {
        return array();
    }
    // Pro version: already an array of arrays
    if (is_array($stats) && isset($stats[0]) && is_array($stats[0])) {
        return $stats;
    }
    // Free version: text "Number|Label", one per line
    if (is_string($stats)) {
        $result = array();
        $lines = preg_split('/\r\n|\r|\n/', $stats);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            if (strpos($line, '|') !== false) {
                list($number, $label) = explode('|', $line, 2);
                $result[] = array('stat_number' => trim($number), 'stat_label' => trim($label));
            } else {
                $result[] = array('stat_number' => $line, 'stat_label' => '');
            }
        }
        return $result;
    }
    return array();
}
