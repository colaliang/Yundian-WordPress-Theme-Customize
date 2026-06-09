<?php
/**
 * ERDU Lighting Theme Functions
 *
 * @package ERDU_Lighting
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define theme constants
 */
define('ERDU_VERSION', '1.6.12');
define('ERDU_DIR', get_template_directory());
define('ERDU_URI', get_template_directory_uri());

/**
 * Include required files
 */
require_once ERDU_DIR . '/inc/theme-setup.php';
require_once ERDU_DIR . '/inc/enqueue-scripts.php';
require_once ERDU_DIR . '/inc/custom-post-types.php';
require_once ERDU_DIR . '/inc/acf-fields.php';
require_once ERDU_DIR . '/inc/acf-page-fields.php';
require_once ERDU_DIR . '/inc/acf-blocks.php';
require_once ERDU_DIR . '/inc/acf-block-renders.php';
require_once ERDU_DIR . '/inc/template-functions.php';
require_once ERDU_DIR . '/inc/admin-dashboard.php';
require_once ERDU_DIR . '/inc/editor-tweaks.php';

/**
 * Load Header & Footer Builder
 */
require_once ERDU_DIR . '/inc/builder/class-erdu-builder-header.php';
Erdu_Builder_Header::get_instance();

require_once ERDU_DIR . '/inc/builder/class-erdu-builder-footer.php';
Erdu_Builder_Footer::get_instance();

/**
 * Load Dynamic CSS Generator & Theme Color Settings
 */
require_once ERDU_DIR . '/inc/class-erdu-dynamic-css.php';
Erdu_Dynamic_CSS::get_instance();

require_once ERDU_DIR . '/inc/acf-theme-colors.php';

/**
 * Load SEO, GEO & AEO Optimization Module
 */
require_once ERDU_DIR . '/inc/seo-geo-aeo.php';

/**
 * Load WooCommerce B2B Enhancements
 */
if (class_exists('WooCommerce')) {
    require_once ERDU_DIR . '/inc/woocommerce-b2b.php';
}

/**
 * Theme Setup
 */
add_action('after_setup_theme', 'erdu_theme_setup');
function erdu_theme_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'erdu-wp'),
        'footer'    => __('Footer Menu', 'erdu-wp'),
    ));

    // Load text domain
    load_theme_textdomain('erdu-wp', ERDU_DIR . '/languages');

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1280;
    }
}

/**
 * ACF Pro check notice
 */
add_action('admin_notices', 'erdu_acf_notice');
function erdu_acf_notice()
{
    if (!class_exists('ACF') && current_user_can('manage_options')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>ERDU Lighting Theme:</strong> ';
        echo 'Advanced Custom Fields (ACF) Pro is recommended for full functionality. ';
        echo '<a href="' . admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term') . '">Install ACF</a>';
        echo '</p></div>';
    }
}

// ==========================================
// Auto-create pages on theme activation
// ==========================================

/**
 * Helper: Get page by slug (WordPress 6.1+ compatible)
 */
function erdu_get_page_by_slug($slug)
{
    $pages = get_posts(array(
        'post_type'      => 'page',
        'name'           => $slug,
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));
    return !empty($pages) ? $pages[0] : null;
}

/**
 * Create required pages with proper templates on theme activation
 */
add_action('after_switch_theme', 'erdu_create_theme_pages');
function erdu_create_theme_pages()
{
    $pages = array(
        'about'       => array('title' => 'About Us',            'template' => 'page-about.php'),
        'products'    => array('title' => 'Products',            'template' => 'page-products.php'),
        'solutions'   => array('title' => 'Solutions',           'template' => 'page-solutions.php'),
        'quality'     => array('title' => 'Quality First',       'template' => 'page-quality.php'),
        'distributor' => array('title' => 'Distributor Program', 'template' => 'page-distributor.php'),
        'cases'       => array('title' => 'Case Studies',        'template' => 'page-cases.php'),
        'news'        => array('title' => 'News & Events',       'template' => 'page-news.php'),
        'blog'        => array('title' => 'Blog',                'template' => 'page-blog.php'),
        'contact'     => array('title' => 'Contact Us',          'template' => 'page-contact.php'),
    );

    foreach ($pages as $slug => $page_data) {
        $existing = erdu_get_page_by_slug($slug);
        if (!$existing) {
            $page_id = wp_insert_post(array(
                'post_title'   => $page_data['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ));
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }

    // Set homepage
    $home_page = erdu_get_page_by_slug('home');
    if (!$home_page) {
        $home_id = wp_insert_post(array(
            'post_title'   => 'Home',
            'post_name'    => 'home',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ));
        if ($home_id && !is_wp_error($home_id)) {
            update_post_meta($home_id, '_wp_page_template', 'front-page.php');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_id);
        }
    } else {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page->ID);
    }

    // Create a blog page
    $blog_page = erdu_get_page_by_slug('blog');
    if (!$blog_page) {
        $blog_id = wp_insert_post(array(
            'post_title'   => 'Blog',
            'post_name'    => 'blog',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ));
        if ($blog_id && !is_wp_error($blog_id)) {
            update_option('page_for_posts', $blog_id);
        }
    }

    // Mark that we need to seed ACF defaults (after ACF is loaded)
    update_option('erdu_seed_acf_needed', 'yes');
    update_option('erdu_flush_rewrite', 'yes');

    // Mark that we need to create sample content
    update_option('erdu_seed_content_needed', 'yes');
}

/**
 * Seed ACF default data for all theme pages.
 * Runs after ACF is initialized. Only fills empty fields.
 */
add_action('acf/init', 'erdu_seed_acf_defaults', 30);
function erdu_seed_acf_defaults()
{
    if (get_option('erdu_seed_acf_needed') !== 'yes') {
        return;
    }
    delete_option('erdu_seed_acf_needed');

    $page_slugs = array('home', 'about', 'products', 'solutions', 'quality', 'distributor', 'cases', 'news', 'blog', 'contact');

    foreach ($page_slugs as $slug) {
        $page = erdu_get_page_by_slug($slug);
        if (!$page) {
            continue;
        }
        $pid = $page->ID;

        $defaults = erdu_get_page_acf_defaults($slug);
        if (!$defaults) {
            continue;
        }

        foreach ($defaults as $field_name => $default_value) {
            $current = get_field($field_name, $pid);
            if ($current === null || $current === '' || $current === false || (is_array($current) && empty($current))) {
                // If it's a repeater (like aeo_takeaways), ensure we structure it correctly for ACF
                if ($field_name === 'aeo_takeaways' && is_array($default_value)) {
                    update_field($field_name, $default_value, $pid);
                } else {
                    update_field($field_name, $default_value, $pid);
                }
            }
        }
    }
}

/**
 * Get ACF default values for a given page slug.
 */
function erdu_get_page_acf_defaults($slug)
{
    $defaults = array(
        // Universal fields (all pages)
        'page_subtitle' => array(
            'about'       => '"Innovating Lighting, Illuminating the World" — Since 2009',
            'quality'     => "From raw material inspection to final packaging, ERDU's quality assurance system ensures every product meets international standards.",
            'solutions'   => 'Tailored magnetic track lighting solutions for every application scenario',
            'products'    => 'Professional 48V magnetic track lighting series for commercial, residential, and industrial applications',
            'contact'     => 'Get in touch with our team for product inquiries, project consultations, and partnership opportunities',
            'distributor' => 'Join our global network of lighting distributors and grow your business with ERDU',
            'cases'       => 'Discover how ERDU lighting transforms spaces worldwide',
            'news'        => 'Stay updated with the latest from ERDU Lighting',
        ),

        // About page
        'about_company_intro' => '<p>ERDU Lighting: Your Reliable 48V Magnetic Track Light Manufacturer in China</p>',
        'about_timeline_title' => 'Our Journey',
        'about_timeline' => array(
            array('year' => '2009', 'title' => 'Company Founded', 'description' => 'Established in Guzhen, China'),
            array('year' => '2010', 'title' => 'First Exhibition', 'description' => 'Hong Kong International Lighting Fair debut'),
            array('year' => '2015', 'title' => 'Sanan Partnership', 'description' => 'Became partner of Sanan Optoelectronics'),
            array('year' => '2017', 'title' => 'Magnetic Track Launch', 'description' => 'First 48V magnetic track system'),
            array('year' => '2019', 'title' => 'ISO9001 Certified', 'description' => 'Quality management certification'),
            array('year' => '2022', 'title' => 'Factory Expansion', 'description' => 'Expanded to 6300m² facility'),
            array('year' => '2024', 'title' => 'UT16 Smart Series', 'description' => 'Smart home integrated lighting'),
            array('year' => '2025', 'title' => 'Global Strategy', 'description' => '20+ country distributor program'),
        ),
        'about_values' => array(
            array('title' => 'Quality First', 'description' => 'Every product undergoes rigorous testing'),
            array('title' => 'Customer Focus', 'description' => 'Solutions tailored to client needs'),
            array('title' => 'Innovation Driven', 'description' => 'R&D investment keeps us at the edge'),
            array('title' => 'Integrity', 'description' => 'Honest communication and fair pricing'),
            array('title' => 'Sustainability', 'description' => 'Energy-efficient lighting solutions'),
        ),
        'about_team' => array(
            array('name' => 'David Deng', 'role' => 'General Manager', 'bio' => '20+ years in LED industry'),
            array('name' => 'Eileen Zhang', 'role' => 'Sales Director', 'bio' => '15+ years in export sales'),
            array('name' => 'Michael Chen', 'role' => 'Technical Director', 'bio' => '18+ years in R&D'),
            array('name' => 'Lisa Wang', 'role' => 'QC Manager', 'bio' => '12+ years in quality control'),
        ),

        // Quality page — Hero
        'quality_hero_title'    => 'Quality First',
        'quality_hero_subtitle' => "From raw material inspection to final packaging, ERDU's quality assurance system ensures every product meets international standards.",
        'quality_hero_btn'      => 'View Certifications',
        'quality_hero_btn2'     => 'Contact Us',

        // Quality page — Content
        'quality_page_editor' => '',

        // Quality page — Introduction
        'quality_intro' => '<p>At ERDU, quality is not just a promise — it is a systematic process embedded in every stage of production.</p>',
        'quality_certs' => array(
            array('name' => 'CE (LVD/EMC)', 'org' => 'TÜV Rheinland', 'valid' => '2028'),
            array('name' => 'RoHS 2.0', 'org' => 'SGS', 'valid' => '2027'),
            array('name' => 'ISO 9001:2015', 'org' => 'BV', 'valid' => '2027'),
            array('name' => 'ETL / cETL', 'org' => 'Intertek', 'valid' => '2027'),
            array('name' => 'SAA', 'org' => 'JAS-ANZ', 'valid' => '2027'),
            array('name' => 'CB Scheme', 'org' => 'IECEE', 'valid' => '2027'),
        ),
        'quality_params' => array(
            array('param' => 'Aging Test', 'value' => '48 hours'),
            array('param' => 'Lifespan (L70)', 'value' => '50,000 hrs'),
            array('param' => 'Color Consistency', 'value' => 'SDCM ≤ 3'),
            array('param' => 'Surge Protection', 'value' => '4kV (standard) / 6kV'),
            array('param' => 'Operating Temp', 'value' => '-20°C ~ +45°C'),
            array('param' => 'IP Rating', 'value' => 'IP20 (IP44 optional)'),
        ),

        // Quality page — CTA
        'quality_cta_override' => false,
        'quality_cta_title'    => 'Want Quality Products?',
        'quality_cta_button'   => 'Contact Us',
        'quality_cta_button2'  => 'Download Certifications',

        // Solutions page — Hero
        'solutions_hero_title'    => 'Solutions',
        'solutions_hero_subtitle' => 'Tailored magnetic track lighting solutions for every application scenario',
        'solutions_hero_btn'      => 'View All Products',
        'solutions_hero_btn2'     => 'Contact Us',

        // Solutions page — Content
        'solutions_page_editor' => '',

        // Solutions page — Introduction
        'solutions_intro' => '<p>ERDU provides tailored lighting solutions for commercial, residential, hospitality, and industrial applications. Our 48V magnetic track system offers the flexibility to adapt to any project requirement.</p>',

        // Solutions page — Categories
        'solutions_categories' => array(
            array('key' => 'commercial', 'name' => 'Commercial Lighting', 'description' => 'Office buildings, retail stores, shopping malls, and conference centers.', 'image' => '', 'link' => ''),
            array('key' => 'residential', 'name' => 'Residential Lighting', 'description' => 'Living rooms, bedrooms, kitchens, and home theaters.', 'image' => '', 'link' => ''),
            array('key' => 'hospitality', 'name' => 'Hospitality Lighting', 'description' => 'Hotels, restaurants, cafes, and bars.', 'image' => '', 'link' => ''),
            array('key' => 'industrial', 'name' => 'Industrial Lighting', 'description' => 'Warehouses, factories, and production facilities.', 'image' => '', 'link' => ''),
            array('key' => 'custom', 'name' => 'Custom Projects', 'description' => 'Bespoke lighting designs for unique architectural projects.', 'image' => '', 'link' => ''),
        ),

        // Solutions page — CTA
        'solutions_cta_override' => false,
        'solutions_cta_title'    => 'Need a Custom Solution?',
        'solutions_cta_button'   => 'Get Free Consultation',
        'solutions_cta_button2'  => 'Download Catalog',

        // Products page — Hero
        'products_hero_title'    => 'Products',
        'products_hero_subtitle' => 'Professional 48V magnetic track lighting series for commercial, residential, and industrial applications',
        'products_hero_btn'      => 'View All Series',
        'products_hero_btn2'     => 'Contact Us',

        // Products page — Content
        'products_page_editor' => '',

        // Products page — Introduction
        'products_intro' => '<p>Explore our comprehensive range of 48V magnetic track lighting products. All series are designed for seamless compatibility and professional performance.</p>',

        // Products page — CTA
        'products_cta_override' => false,
        'products_cta_title'    => 'Need a Custom Solution?',
        'products_cta_button'   => 'Discuss Your Project',
        'products_cta_button2'  => 'Download Catalog',

        // Distributor page — Hero
        'dist_hero_title'    => 'Distributor Program',
        'dist_hero_subtitle' => 'Join our global network of lighting distributors and grow your business with ERDU',
        'dist_hero_btn'      => 'Apply Now',
        'dist_hero_btn2'     => 'Contact Us',

        // Distributor page — Content
        'dist_page_editor' => '',

        // Distributor page — Introduction
        'dist_intro' => '<p>Join the ERDU global distributor network and grow your lighting business with a trusted partner.</p>',
        'dist_benefits' => array(
            array('title' => 'Factory-Direct Pricing', 'description' => 'Competitive wholesale prices with no middlemen'),
            array('title' => 'Exclusive Territory', 'description' => 'Protected sales regions to prevent channel conflict'),
            array('title' => 'Marketing Support', 'description' => 'Product catalogs, samples, and promotional materials'),
            array('title' => 'Technical Training', 'description' => 'Product knowledge and installation training provided'),
            array('title' => 'Flexible MOQ', 'description' => 'Starter programs for new partners'),
            array('title' => '3-Year Warranty', 'description' => 'Comprehensive product warranty and after-sales support'),
        ),

        // Distributor page — CTA (disabled by default since page has application form)
        'dist_cta_override' => false,
        'dist_cta_title'    => 'Want to Become a Distributor?',
        'dist_cta_button'   => 'Apply Now',
        'dist_cta_button2'  => 'Download Partner Guide',

        // Cases page — CTA
        'cases_cta_override' => false,
        'cases_cta_title'    => 'Have a Project in Mind?',
        'cases_cta_button'   => 'Discuss Your Project',
        'cases_cta_button2'  => 'View Products',

        // Contact page — Hero
        'contact_hero_title'    => 'Contact Us',
        'contact_hero_subtitle' => 'Get in touch with our team for product inquiries, project consultations, and partnership opportunities',
        'contact_hero_btn'      => 'Send a Message',
        'contact_hero_btn2'     => 'Call Us',

        // Contact page — Content
        'contact_page_editor' => '',

        // Contact page — Introduction
        'contact_intro' => '<p>Our team is ready to assist you with any inquiries. Whether you need product information, technical support, or want to discuss a custom lighting project, we are here to help.</p>',
        'contact_faq' => array(
            array('question' => 'What is your MOQ?', 'answer' => 'Our standard MOQ is 50 pieces per model for existing products. For custom projects, MOQ varies depending on specifications.'),
            array('question' => 'What is the lead time?', 'answer' => 'Sample orders: 3-5 business days. Bulk orders: 15-25 business days. Custom products: 30-45 days after design confirmation.'),
            array('question' => 'Do you provide OEM/ODM services?', 'answer' => 'Yes, we offer both OEM and ODM services. Our engineering team can customize products according to your specifications.'),
            array('question' => 'What certifications do you have?', 'answer' => 'Our products are certified with CE, RoHS, ISO9001, ETL, and SAA. We can also assist with additional certifications required for specific markets.'),
        ),

        // Cases page — Hero
        'cases_hero_title'    => 'Case Studies',
        'cases_hero_subtitle' => 'Discover how ERDU lighting transforms spaces worldwide',
        'cases_hero_btn'      => 'View All Projects',
        'cases_hero_btn2'     => 'Contact Us',

        // Cases page — Content
        'cases_page_editor' => '',

        // Cases page — Introduction
        'cases_intro' => '<p>Explore our portfolio of lighting projects from around the world.</p>',

        // Cases page — Source
        'cases_source' => 'custom',
        'cases_count'  => 6,
        'cases_list' => array(
            array('title' => 'Luxury Hotel Lobby Renovation', 'industry' => 'hospitality', 'description' => 'Complete lighting overhaul for a 5-star hotel lobby using ERDU magnetic track system.'),
            array('title' => 'Flagship Retail Store Lighting', 'industry' => 'retail', 'description' => 'Custom lighting design for a premium retail brand\'s flagship location.'),
            array('title' => 'Tech Company HQ Lighting', 'industry' => 'office', 'description' => 'Smart lighting integration for a modern tech headquarters.'),
            array('title' => 'Modern Villa Lighting Design', 'industry' => 'residential', 'description' => 'Bespoke lighting solution for a luxury residential villa project.'),
            array('title' => 'Shopping Mall Lighting Upgrade', 'industry' => 'commercial', 'description' => 'Energy-efficient LED retrofit for a large commercial shopping complex.'),
            array('title' => 'Boutique Hotel Rooms', 'industry' => 'hospitality', 'description' => 'Ambient lighting design for boutique hotel guest rooms.'),
        ),

        // Blog page — Hero
        'blog_hero_title'    => 'Blog',
        'blog_hero_subtitle' => 'Insights, tips, and trends in 48V magnetic track lighting technology.',
        'blog_hero_btn'      => '',
        'blog_hero_btn2'     => '',

        // Blog page — Content
        'blog_page_editor' => '',

        // Blog page — Introduction
        'blog_intro' => '<p>Welcome to the ERDU Lighting blog. Discover the latest insights on 48V magnetic track lighting, industry trends, product guides, and expert tips.</p>',

        // Blog page — Settings
        'blog_count'              => 9,
        'blog_show_categories'    => true,
        'blog_show_excerpt'       => true,
        'blog_show_date'          => true,
        'blog_show_author'        => true,
        'blog_show_readmore'      => true,
        'blog_featured_show'      => true,
        'blog_featured_title'     => 'Featured Articles',
        'blog_featured_count'     => 3,

        // Blog page — CTA
        'blog_cta_override' => false,
        'blog_cta_title'    => 'Stay Updated with Our Blog',
        'blog_cta_button'   => 'Subscribe',

        // News page — Hero
        'news_hero_title'    => 'News & Events',
        'news_hero_subtitle' => 'Stay updated with the latest from ERDU Lighting',
        'news_hero_btn'      => 'View Exhibitions',
        'news_hero_btn2'     => 'Contact Us',

        // News page — Content
        'news_page_editor' => '',

        // News page — Introduction
        'news_intro' => '<p>Stay updated with the latest news, product launches, and industry insights from ERDU Lighting.</p>',

        // News page — Settings
        'news_count' => 6,
        'news_expo_source' => 'custom',
        'news_expo_count'  => 3,
        'news_exhibitions' => array(
            array('name' => 'Hong Kong International Lighting Fair', 'date' => 'October 27-30, 2026', 'booth' => 'Hall 1A-C12'),
            array('name' => 'Frankfurt Light + Building', 'date' => 'March 8-13, 2026', 'booth' => 'Hall 4.0-B20'),
            array('name' => 'Dubai LED Expo', 'date' => 'January 16-18, 2026', 'booth' => 'Zabeel Hall 3'),
        ),

        // About page
        'about_hero_title'    => 'About Us',
        'about_hero_subtitle' => '"Innovating Lighting, Illuminating the World" — Since 2009',
        'about_hero_btn'      => 'Explore Products',
        'about_hero_btn_link' => '',  // Uses default page link
        'about_hero_btn2'     => 'Contact Us',
        'about_hero_btn2_link' => '',  // Uses default page link
        'about_highlight'     => 'ERDU Lighting: Your Reliable 48V Magnetic Track Light Manufacturer in China',
        'about_company_intro' => '<p>Zhongshan Erdu Lighting Technology Co., Ltd. specializes in developing, designing, producing and selling LED products. Established in 2009 in Guzhen, China.</p>',
        'about_profile_stats' => array(
            array('label' => 'Founded:', 'value' => '2009'),
            array('label' => 'Location:', 'value' => 'Zhongshan, Guzhen'),
            array('label' => 'Area:', 'value' => '6300m²'),
            array('label' => 'Employees:', 'value' => '100+'),
            array('label' => 'Key Partners:', 'value' => 'Sanan, Aishi'),
            array('label' => 'Export:', 'value' => '20+ Countries'),
        ),
        'about_mission_title' => 'Our Mission',
        'about_mission_text'  => '"To Illuminate Global Spaces with Innovative, Reliable, and Sustainable LED Lighting Solutions."',
        'about_factory_title' => 'Factory Tour',
        'about_factory_images' => array(
            array('url' => 'https://images.unsplash.com/photo-1565043666747-69f6646db940?w=400', 'caption' => 'Production Line'),
            array('url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400', 'caption' => 'Aging Test Area'),
            array('url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400', 'caption' => 'Showroom'),
        ),
        'about_factory_stats' => array(
            array('label' => 'Production Lines', 'value' => '6'),
            array('label' => 'Daily Capacity', 'value' => '3,000+'),
            array('label' => 'QC Stations', 'value' => '12'),
            array('label' => 'Warehouse', 'value' => '2,000m²'),
        ),
        'about_partners_title' => 'Supply Chain Partners',
        'about_partners_list' => array(
            array('logo' => '', 'name' => 'Sanan',    'category' => 'LED Chip Partner'),
            array('logo' => '', 'name' => 'Samsung',  'category' => 'LED Chip Partner'),
            array('logo' => '', 'name' => 'Aishi',    'category' => 'Capacitor Partner'),
            array('logo' => '', 'name' => 'Lifud',    'category' => 'Driver Partner'),
            array('logo' => '', 'name' => 'OSRAM',    'category' => 'Optical Partner'),
            array('logo' => '', 'name' => 'CREE',     'category' => 'LED Chip Partner'),
            array('logo' => '', 'name' => 'PHILIPS',  'category' => 'Technology Partner'),
            array('logo' => '', 'name' => 'tuya',     'category' => 'Smart Partner'),
        ),

        // About page — Certifications
        'about_certs_title' => 'Certifications',
        'about_certs_list' => array(
            array('icon' => '', 'name' => 'CE Certification',    'org' => 'EU',        'scope' => 'International'),
            array('icon' => '', 'name' => 'RoHS Certification',  'org' => 'EU',        'scope' => 'International'),
            array('icon' => '', 'name' => 'ERP Certification',   'org' => 'EU',        'scope' => 'International'),
            array('icon' => '', 'name' => 'ISO9001:2015',        'org' => 'TUV',       'scope' => 'Quality'),
            array('icon' => '', 'name' => 'ETL/cETL',            'org' => 'Intertek',  'scope' => 'International'),
            array('icon' => '', 'name' => 'REACH',               'org' => 'EU',        'scope' => 'Environmental'),
        ),

        // About page — Downloads
        'about_downloads_title' => 'Downloads & Resources',
        'about_downloads_show'  => true,

        // AEO defaults for core pages
        'aeo_summary' => array(
            'home' => 'ERDU Lighting is a premier manufacturer of 48V magnetic track lights and commercial LED solutions in China. With over a decade of OEM/ODM experience, we deliver high-quality, certified lighting systems to global distributors and projects.',
            'about' => 'Founded in 2009, ERDU Lighting has grown into a trusted B2B partner for commercial lighting. Our ISO9001 factory ensures strict quality control from raw materials to final assembly, supporting global brands with reliable LED manufacturing.',
            'quality' => 'Quality is the cornerstone of ERDU Lighting. We maintain a rigorous quality assurance system, subjecting every product to a 48-hour aging test and strict optical verifications to meet international commercial standards.',
            'distributor' => "ERDU's Global Distributor Program is designed for B2B lighting wholesalers and project contractors. We offer protected territories, factory-direct pricing, and comprehensive technical support to ensure our partners' success."
        ),
        'aeo_takeaways' => array(
            'home' => array(
                array('text' => 'Direct manufacturer with 6,300m² facility in Zhongshan, China.'),
                array('text' => 'Specializing in 48V magnetic track systems, downlights, and spotlights.'),
                array('text' => 'Comprehensive OEM/ODM services for commercial lighting projects.'),
                array('text' => 'ISO9001 certified with CE, RoHS, and ETL product approvals.')
            ),
            'about' => array(
                array('text' => 'Established in 2009, over 15 years of LED manufacturing expertise.'),
                array('text' => 'Strict quality control process (IQC, IPQC, Aging, OQC).'),
                array('text' => 'Exporting to over 20 countries worldwide.'),
                array('text' => 'Strategic partnerships with top component suppliers like Sanan and OSRAM.')
            ),
            'quality' => array(
                array('text' => '100% of products undergo a minimum 48-hour aging test.'),
                array('text' => 'Products certified for global markets: CE, RoHS, ERP, ETL, SAA.'),
                array('text' => 'High color consistency (SDCM ≤ 3) and excellent lifespan (L70 > 50,000 hrs).'),
                array('text' => 'Multi-stage inspection process from incoming components to final packaging.')
            ),
            'distributor' => array(
                array('text' => 'Factory-direct pricing to maximize distributor margins.'),
                array('text' => 'Exclusive territory protection to prevent market conflicts.'),
                array('text' => 'Full marketing and technical training support provided.'),
                array('text' => 'Standard 3-year warranty on all commercial lighting products.')
            )
        ),

        // Quality page - new fields
        'quality_steps' => array(
            array('icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'IQC — Incoming QC', 'description' => 'LED chips, drivers, and raw materials inspected upon arrival'),
            array('icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'IPQC — In-Process QC', 'description' => 'Real-time monitoring during SMT, assembly, and welding'),
            array('icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Aging Test', 'description' => '48-hour continuous operation under rated voltage'),
            array('icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'OQC — Final Inspection', 'description' => 'Color temperature, luminous flux, and beam angle verification'),
            array('icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'title' => 'Packaging QC', 'description' => 'Carton integrity, label accuracy, and drop test'),
        ),

        // Distributor page - new fields
        'dist_partner_title' => 'Why Partner with ERDU?',
        'dist_partner_content' => 'Join our growing network of distributors worldwide. We provide comprehensive support to help you succeed in your market.',
        'dist_req_title' => 'Distributor Requirements',
        'dist_requirements' => array(
            array('text' => 'Established lighting business with physical showroom or warehouse'),
            array('text' => 'Annual purchase commitment (negotiable by region)'),
            array('text' => 'Technical sales capability for specification and installation support'),
            array('text' => 'Good reputation and business credit in local market'),
        ),

        // Cases page - new fields
        'cases_industries' => array(
            array('key' => '', 'label' => 'All Industries'),
            array('key' => 'commercial', 'label' => 'Commercial'),
            array('key' => 'hospitality', 'label' => 'Hospitality'),
            array('key' => 'retail', 'label' => 'Retail'),
            array('key' => 'office', 'label' => 'Office'),
            array('key' => 'residential', 'label' => 'Residential'),
        ),

        // Contact page - new fields
        'contact_info_title' => 'Contact Information',
        'contact_address' => "6th Floor, JinYe Building\nTongyi Industrial District, Guzhen, Zhongshan\nGuangdong, China",
        'contact_phone' => '+86-760-22380830',
        'contact_mobile' => '+86-18938760626 / +86-13726005031',
        'contact_email' => 'gg@erduled.com',
        'contact_hours' => 'Mon-Fri 9:00-18:00 CST',

        // Contact persons
        'contact_persons' => array(
            array('name' => 'David Deng', 'title' => 'Sales Manager', 'email' => 'david@erduled.com', 'phone' => '', 'initial' => 'D'),
            array('name' => 'Eileen Zhang', 'title' => 'Export Director', 'email' => 'eileen@erduled.com', 'phone' => '', 'initial' => 'E'),
        ),

        // Social links
        'contact_social_label' => 'Connect With Us',
        'contact_whatsapp' => '+8618938760626',
        'contact_wechat' => 'ERDU_Lighting',

        // Contact page — CTA (disabled by default)
        'contact_cta_override' => false,
        'contact_cta_title'    => 'Need Help?',
        'contact_cta_button'   => 'Call Us Now',

        // Footer — Logo & About
        'ft_logo_type'   => 'text',
        'ft_logo_text'   => 'ERDU LIGHTING',
        'ft_logo_icon'   => true,
        'ft_logo_icon_text' => 'E',
        'ft_about'       => 'Professional 48V Magnetic Track Light Manufacturer since 2009. 6300m² factory, 100+ employees, exporting to 20+ countries.',

        // Footer — Social Links
        'ft_social_show'  => true,
        'ft_social_links' => array(
            array('platform' => 'facebook',  'url' => 'https://www.facebook.com/erduled',        'label' => 'Facebook'),
            array('platform' => 'linkedin',  'url' => 'https://www.linkedin.com/company/erduled', 'label' => 'LinkedIn'),
            array('platform' => 'youtube',   'url' => 'https://www.youtube.com/@erduled',         'label' => 'YouTube'),
            array('platform' => 'instagram', 'url' => 'https://www.instagram.com/erduled',        'label' => 'Instagram'),
        ),

        // Footer — Quick Links
        'ft_quicklinks_show'  => true,
        'ft_quicklinks_title' => 'Quick Links',
        'ft_quicklinks' => array(
            array('label' => 'Products',           'url' => erdu_get_page_url('products')),
            array('label' => 'Solutions',          'url' => erdu_get_page_url('solutions')),
            array('label' => 'About Us',           'url' => erdu_get_page_url('about')),
            array('label' => 'Quality First',      'url' => erdu_get_page_url('quality')),
            array('label' => 'Distributor Program', 'url' => erdu_get_page_url('distributor')),
            array('label' => 'Case Studies',       'url' => erdu_get_page_url('cases')),
            array('label' => 'News',               'url' => erdu_get_page_url('news')),
            array('label' => 'Contact',            'url' => erdu_get_page_url('contact')),
        ),

        // Footer — Contact Info
        'ft_contact_show'    => true,
        'ft_contact_title'   => 'Contact Info',
        'ft_contact_address' => "6th Floor, JinYe Building, Tongyi Industrial District, Guzhen, Zhongshan, Guangdong, China",
        'ft_contact_phone'   => '+86-760-22380830',
        'ft_contact_mobile'  => '+86-18938760626',
        'ft_contact_email'   => 'gg@erduled.com',
        'ft_contact_hours'   => 'Mon-Fri 9:00-18:00 CST',

        // Footer — Newsletter
        'ft_newsletter_show'       => true,
        'ft_newsletter_title'      => 'Newsletter',
        'ft_newsletter_desc'       => 'Stay updated with latest products & lighting trends.',
        'ft_newsletter_placeholder'=> 'Your email',
        'ft_newsletter_button'     => 'Subscribe',
        'ft_newsletter_footer'     => 'Join 500+ lighting professionals who trust our updates.',

        // Footer — Copyright
        'ft_copyright_text' => '© {year} ERDU Lighting Technology Co., Ltd. All Rights Reserved.',
        'ft_copyright_links' => array(
            array('label' => 'Privacy Policy',   'url' => '#'),
            array('label' => 'Terms of Service', 'url' => '#'),
        ),

        // Footer — Appearance
        'ft_bg_color'         => '#1a1a2e',
        'ft_text_color'       => '#9ca3af',
        'ft_heading_color'    => '#ffffff',
        'ft_link_hover_color' => '#F37021',
        'ft_border_color'     => '#374151',

        // News page - new fields
        'news_tab_news_label' => 'News',
        'news_tab_expo_label' => 'Exhibitions',
        'news_empty_title' => 'Stay Tuned for Latest Updates',
        'news_empty_text' => 'News articles will be published here soon.',

        // News page — CTA
        'news_cta_override' => false,
        'news_cta_title'    => 'Want Product Updates?',
        'news_cta_button'   => 'Subscribe to Newsletter',
        'news_cta_button2'  => 'Contact Us',

        // Home page
        'home_hero_title'    => 'Professional 48V Magnetic Track Lights',
        'home_hero_subtitle' => 'Illuminate Your Space with ERDU — Trusted by 20+ Countries Since 2009',
        'home_hero_bg'       => 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1200',
        'home_hero_btn'      => 'Explore Products',
        'home_hero_btn_link' => '',
        'home_hero_btn2'     => 'Contact Us',
        'home_hero_btn2_link'=> '',
        'home_hero_video_enabled' => false,
        'home_hero_video'    => '',
        'home_hero_video_poster' => '',
        'home_stats' => array(
            array('number' => '2009', 'label' => 'Founded'),
            array('number' => '6300', 'label' => 'm² Factory'),
            array('number' => '100+', 'label' => 'Employees'),
            array('number' => '20+',  'label' => 'Countries'),
            array('number' => '8',    'label' => 'Categories'),
            array('number' => '15+',  'label' => 'Partners'),
        ),
        'home_about_title'     => 'About ERDU Lighting',
        'home_about_highlight' => 'ERDU Lighting: Your Reliable 48V Magnetic Track Light Manufacturer in China',
        'home_about_info' => array(
            array('label' => 'Founded:', 'value' => '2009'),
            array('label' => 'Location:', 'value' => 'Zhongshan, Guzhen'),
            array('label' => 'Area:', 'value' => '6300m²'),
            array('label' => 'Employees:', 'value' => '100+'),
            array('label' => 'Key Partners:', 'value' => 'Sanan, Aishi'),
            array('label' => 'Export:', 'value' => '20+ Countries'),
        ),
        'home_products_title' => 'Our Product Series',
        'home_products_desc'  => 'Professional LED lighting for commercial, residential and industrial applications',
        'home_products_count'  => 4,
        'home_apps_title' => 'Applications',
        'home_apps_desc'  => 'Tailored lighting solutions for every space',
        'home_apps' => array(
            array('name' => 'Retail Store', 'description' => 'Highlight merchandise with adjustable spotlights', 'icon' => '🛍️'),
            array('name' => 'Hotel Lobby', 'description' => 'Create elegant ambiance with modular lighting', 'icon' => '🏨'),
            array('name' => 'Office Space', 'description' => 'Boost productivity with glare-free illumination', 'icon' => '🏢'),
            array('name' => 'Residential Living', 'description' => 'Flexible no-main-light design for modern homes', 'icon' => '🏠'),
        ),
        'home_cta_title' => 'Ready to Upgrade Your Lighting Project?',
        'home_cta_btn'   => 'Request a Quote',
        'home_cta_btn2'  => 'Download Catalog',
        'home_testi_title' => 'What Our Clients Say',
        'home_testi_desc'  => 'Trusted by lighting professionals worldwide',
        'home_testimonials' => array(
            array('quote' => "ERDU's 48V magnetic track lights transformed our hotel lobby project. The modular design made installation incredibly efficient, and the CRI90+ quality exceeded client expectations.", 'author' => 'David Chen', 'role' => 'Lighting Designer, Luxe Interiors — Singapore'),
        ),
        'home_expo_title'  => 'Upcoming Exhibitions',
        'home_expo_desc'   => 'Meet us at leading lighting trade shows',
        'home_expo_source' => 'custom',
        'home_expo_count'  => 3,
        'home_expo_custom' => array(
            array('name' => 'Guangzhou International Lighting Exhibition', 'date' => 'Jun 2026', 'location' => 'Guangzhou, China', 'booth' => 'Hall 10.2, B18'),
            array('name' => 'Hong Kong Lighting Fair', 'date' => 'Oct 2026', 'location' => 'Hong Kong', 'booth' => '3C-E18'),
            array('name' => 'Guzhen Lighting Exhibition', 'date' => 'Mar 2026', 'location' => 'Zhongshan, China', 'booth' => 'A18'),
        ),
        'home_partners_title' => 'Trusted by Industry Leaders',
        'home_partners' => array(
            array('name' => 'Sanan'), array('name' => 'Aishi'), array('name' => 'Samsung'),
            array('name' => 'Lifud'), array('name' => 'OSRAM'), array('name' => 'CREE'),
            array('name' => 'PHILIPS'), array('name' => 'tuya'),
        ),
        'home_faq_title' => 'Frequently Asked Questions',
        'home_faq_items' => array(
            array('question' => 'What is 48V magnetic track light?', 'answer' => '48V magnetic track lights are low-voltage lighting fixtures that attach magnetically to a track rail, allowing easy repositioning without tools. They operate at a safe 48V DC voltage and offer flexible lighting arrangements for commercial and residential spaces.'),
            array('question' => 'How to install ERDU magnetic track system?', 'answer' => "ERDU's magnetic track system features tool-free installation. Simply mount the track rail to the ceiling, then magnetically attach the light fixtures. Each fixture can be repositioned, removed, or swapped instantly without an electrician."),
            array('question' => 'What certifications do ERDU products have?', 'answer' => 'All ERDU products are CE, RoHS, and ERP certified. We also hold ISO9001:2015 quality management certification. Specific products have ETL/cETL certification for North American markets.'),
        ),
        'home_news_title'       => 'Stay Updated',
        'home_news_placeholder' => 'Enter your email',
        'home_news_button'      => 'Subscribe',
    );

    // Extract the per-slug values for universal fields
    $result = array();
    foreach ($defaults as $field_name => $value) {
        if (in_array($field_name, array('page_subtitle', 'aeo_summary', 'aeo_takeaways'), true) && is_array($value)) {
            if (isset($value[$slug])) {
                $result[$field_name] = $value[$slug];
            }
        } elseif (!is_array($value) || (isset($value[0]) && is_array($value[0]))) {
            // Direct value or repeater rows — only include for matching slug scope
            $slug_map = array(
                'about'       => array('about_hero_title', 'about_hero_subtitle', 'about_hero_bg', 'about_hero_btn', 'about_hero_btn_link', 'about_hero_btn2', 'about_hero_btn2_link', 'about_page_editor', 'about_highlight', 'about_company_intro', 'about_profile_image', 'about_profile_stats', 'about_team', 'about_timeline_title', 'about_timeline', 'about_mission_title', 'about_mission_text', 'about_values', 'about_factory_title', 'about_factory_images', 'about_factory_stats', 'about_partners_title', 'about_partners_list', 'about_certs_title', 'about_certs_list', 'about_downloads_title', 'about_downloads_show', 'about_cta_override', 'about_cta_title', 'about_cta_button', 'about_cta_link', 'about_cta_button2', 'about_cta_link2'),
                'quality'     => array('quality_hero_title', 'quality_hero_subtitle', 'quality_hero_bg', 'quality_hero_btn', 'quality_hero_btn_link', 'quality_hero_btn2', 'quality_hero_btn2_link', 'quality_page_editor', 'quality_intro', 'quality_certs', 'quality_params', 'quality_steps', 'quality_process', 'quality_cta_override', 'quality_cta_title', 'quality_cta_button', 'quality_cta_link', 'quality_cta_button2', 'quality_cta_link2'),
                'solutions'   => array('solutions_hero_title', 'solutions_hero_subtitle', 'solutions_hero_bg', 'solutions_hero_btn', 'solutions_hero_btn_link', 'solutions_hero_btn2', 'solutions_hero_btn2_link', 'solutions_page_editor', 'solutions_intro', 'solutions_categories', 'solutions_cta_override', 'solutions_cta_title', 'solutions_cta_button', 'solutions_cta_link', 'solutions_cta_button2', 'solutions_cta_link2'),
                'products'    => array('products_hero_title', 'products_hero_subtitle', 'products_hero_bg', 'products_hero_btn', 'products_hero_btn_link', 'products_hero_btn2', 'products_hero_btn2_link', 'products_page_editor', 'products_intro', 'products_cta_override', 'products_cta_title', 'products_cta_button', 'products_cta_link', 'products_cta_button2', 'products_cta_link2'),
                'distributor' => array('dist_hero_title', 'dist_hero_subtitle', 'dist_hero_bg', 'dist_hero_btn', 'dist_hero_btn_link', 'dist_hero_btn2', 'dist_hero_btn2_link', 'dist_page_editor', 'dist_intro', 'dist_partner_title', 'dist_partner_content', 'dist_benefits', 'dist_req_title', 'dist_req_intro', 'dist_requirements', 'dist_cta_override', 'dist_cta_title', 'dist_cta_button', 'dist_cta_link', 'dist_cta_button2', 'dist_cta_link2'),
                'contact'     => array('contact_hero_title', 'contact_hero_subtitle', 'contact_hero_bg', 'contact_hero_btn', 'contact_hero_btn_link', 'contact_hero_btn2', 'contact_hero_btn2_link', 'contact_page_editor', 'contact_intro', 'contact_info_title', 'contact_address', 'contact_phone', 'contact_email', 'contact_hours', 'contact_map_embed', 'contact_map_image', 'contact_faq', 'contact_cta_override', 'contact_cta_title', 'contact_cta_button', 'contact_cta_link', 'contact_cta_button2', 'contact_cta_link2'),
                'cases'       => array('cases_hero_title', 'cases_hero_subtitle', 'cases_hero_bg', 'cases_hero_btn', 'cases_hero_btn_link', 'cases_hero_btn2', 'cases_hero_btn2_link', 'cases_page_editor', 'cases_intro', 'cases_source', 'cases_count', 'cases_list', 'cases_industries', 'cases_cta_override', 'cases_cta_title', 'cases_cta_button', 'cases_cta_link', 'cases_cta_button2', 'cases_cta_link2'),
                'news'        => array('news_hero_title', 'news_hero_subtitle', 'news_hero_bg', 'news_hero_btn', 'news_hero_btn_link', 'news_hero_btn2', 'news_hero_btn2_link', 'news_page_editor', 'news_intro', 'news_count', 'news_expo_source', 'news_expo_count', 'news_exhibitions', 'news_tab_news_label', 'news_tab_expo_label', 'news_empty_title', 'news_empty_text', 'news_cta_override', 'news_cta_title', 'news_cta_button', 'news_cta_link', 'news_cta_button2', 'news_cta_link2'),
                'blog'        => array('blog_hero_title', 'blog_hero_subtitle', 'blog_hero_bg', 'blog_hero_btn', 'blog_hero_btn_link', 'blog_hero_btn2', 'blog_hero_btn2_link', 'blog_page_editor', 'blog_intro', 'blog_count', 'blog_show_categories', 'blog_show_excerpt', 'blog_show_date', 'blog_show_author', 'blog_show_readmore', 'blog_featured_show', 'blog_featured_title', 'blog_featured_count', 'blog_cta_override', 'blog_cta_title', 'blog_cta_button', 'blog_cta_link', 'blog_cta_button2', 'blog_cta_link2'),
                'home'        => array('home_hero_title', 'home_hero_subtitle', 'home_hero_bg', 'home_hero_btn', 'home_hero_btn_link', 'home_hero_btn2', 'home_hero_btn2_link', 'home_hero_video_enabled', 'home_hero_video', 'home_hero_video_poster', 'home_stats', 'home_about_title', 'home_about_highlight', 'home_about_info', 'home_products_title', 'home_products_desc', 'home_products_count', 'home_apps_title', 'home_apps_desc', 'home_apps', 'home_cta_title', 'home_cta_btn', 'home_cta_btn2', 'home_testi_title', 'home_testi_desc', 'home_testimonials', 'home_expo_title', 'home_expo_desc', 'home_expo_source', 'home_expo_count', 'home_expo_custom', 'home_partners_title', 'home_partners', 'home_faq_title', 'home_faq_items', 'home_news_title', 'home_news_placeholder', 'home_news_button'),
            );
            $page_fields = isset($slug_map[$slug]) ? $slug_map[$slug] : array();
            if (in_array($field_name, $page_fields, true)) {
                $result[$field_name] = $value;
            }
        }
    }

    return $result;
}

/**
 * Flush rewrite rules after CPTs are registered
 */
add_action('init', 'erdu_flush_rewrite_later', 99);
function erdu_flush_rewrite_later()
{
    if (get_option('erdu_flush_rewrite') === 'yes') {
        flush_rewrite_rules();
        delete_option('erdu_flush_rewrite');
    }
}

/**
 * Ensure required pages exist (fallback for updates without theme switch)
 */
add_action('admin_init', 'erdu_ensure_pages_exist');
function erdu_ensure_pages_exist()
{
    // Only run for admins and max once per hour
    if (!current_user_can('manage_options')) {
        return;
    }
    $last_check = get_option('erdu_pages_checked', 0);
    if (time() - $last_check < 3600) {
        return;
    }
    update_option('erdu_pages_checked', time());

    $required_pages = array(
        'about'       => array('title' => 'About Us',            'template' => 'page-about.php'),
        'products'    => array('title' => 'Products',            'template' => 'page-products.php'),
        'solutions'   => array('title' => 'Solutions',           'template' => 'page-solutions.php'),
        'quality'     => array('title' => 'Quality First',       'template' => 'page-quality.php'),
        'distributor' => array('title' => 'Distributor Program', 'template' => 'page-distributor.php'),
        'cases'       => array('title' => 'Case Studies',        'template' => 'page-cases.php'),
        'news'        => array('title' => 'News & Events',       'template' => 'page-news.php'),
        'contact'     => array('title' => 'Contact Us',          'template' => 'page-contact.php'),
    );

    $missing = false;
    foreach ($required_pages as $slug => $page_data) {
        $existing = erdu_get_page_by_slug($slug);
        if (!$existing) {
            $missing = true;
            break;
        }
    }

    if ($missing) {
        erdu_create_theme_pages();
    }

    // Trigger ACF default seeding for existing pages (runs once per theme version)
    $seeded_version = get_option('erdu_acf_seed_version', '0');
    if ($seeded_version !== ERDU_VERSION) {
        update_option('erdu_seed_acf_needed', 'yes');
        update_option('erdu_acf_seed_version', ERDU_VERSION);
    }
    
    // Explicitly call the seed function if it was marked as needed during this request
    if (get_option('erdu_seed_acf_needed') === 'yes' && function_exists('erdu_seed_acf_defaults')) {
        erdu_seed_acf_defaults();
    }

    // Fix: ensure all existing pages have correct template assigned
    $all_pages = array(
        'home'        => 'front-page.php',
        'about'       => 'page-about.php',
        'products'    => 'page-products.php',
        'solutions'   => 'page-solutions.php',
        'quality'     => 'page-quality.php',
        'distributor' => 'page-distributor.php',
        'cases'       => 'page-cases.php',
        'news'        => 'page-news.php',
        'contact'     => 'page-contact.php',
    );
    foreach ($all_pages as $slug => $template) {
        $page = erdu_get_page_by_slug($slug);
        if ($page && !is_wp_error($page)) {
            $current_template = get_post_meta($page->ID, '_wp_page_template', true);
            if (empty($current_template)) {
                update_post_meta($page->ID, '_wp_page_template', $template);
            }
            // Fix broken Gutenberg block content
            if (strpos($page->post_content, 'placeholder') !== false) {
                wp_update_post(array(
                    'ID'           => $page->ID,
                    'post_content' => '<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">This page content is managed by the ERDU theme template. Edit the template file to customize the layout.</p>
<!-- /wp:paragraph -->',
                ));
            }
        }
    }
}

// ==========================================
// Form Handlers
// ==========================================

/**
 * Helper: Validate redirect URL to prevent open redirect attacks
 */
function erdu_safe_redirect_url($fallback = '')
{
    $referer = wp_get_referer();
    $fallback = $fallback ?: home_url('/');
    if (empty($referer)) {
        return $fallback;
    }
    // Only allow redirects to same site
    $referer_host = wp_parse_url($referer, PHP_URL_HOST);
    $site_host    = wp_parse_url(home_url('/'), PHP_URL_HOST);
    if ($referer_host !== $site_host) {
        return $fallback;
    }
    return $referer;
}

/**
 * Helper: Check rate limiting for form submissions (transient-based)
 */
function erdu_check_rate_limit($form_key, $max_attempts = 5, $window = 3600)
{
    $ip     = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : 'unknown';
    $key    = 'erdu_rate_' . $form_key . '_' . md5($ip);
    $count  = get_transient($key);
    if ($count === false) {
        set_transient($key, 1, $window);
        return true;
    }
    if (intval($count) >= $max_attempts) {
        return false;
    }
    set_transient($key, intval($count) + 1, $window);
    return true;
}

/**
 * Handle Contact Form Submission
 */
add_action('admin_post_erdu_contact_form', 'erdu_handle_contact_form');
add_action('admin_post_nopriv_erdu_contact_form', 'erdu_handle_contact_form');

function erdu_handle_contact_form()
{
    // Verify nonce
    if (!isset($_POST['erdu_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['erdu_contact_nonce'])), 'erdu_contact_action')) {
        wp_die(esc_html__('Security check failed.', 'erdu-wp'));
    }

    // Rate limiting
    if (!erdu_check_rate_limit('contact', 5, 3600)) {
        wp_safe_redirect(add_query_arg('contact_error', 'ratelimit', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
        exit;
    }

    // Honeypot check (hidden field that should be empty)
    if (!empty($_POST['website'])) {
        wp_safe_redirect(add_query_arg('contact_success', '1', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
        exit;
    }

    // Sanitize input
    $name    = isset($_POST['contact_name']) ? sanitize_text_field(wp_unslash($_POST['contact_name'])) : '';
    $email   = isset($_POST['contact_email']) ? sanitize_email(wp_unslash($_POST['contact_email'])) : '';
    $phone   = isset($_POST['contact_phone']) ? sanitize_text_field(wp_unslash($_POST['contact_phone'])) : '';
    $company = isset($_POST['contact_company']) ? sanitize_text_field(wp_unslash($_POST['contact_company'])) : '';
    $country = isset($_POST['contact_country']) ? sanitize_text_field(wp_unslash($_POST['contact_country'])) : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field(wp_unslash($_POST['contact_subject'])) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field(wp_unslash($_POST['contact_message'])) : '';
    $product = isset($_POST['contact_product']) ? sanitize_text_field(wp_unslash($_POST['contact_product'])) : '';
    $quantity = isset($_POST['contact_quantity']) ? sanitize_text_field(wp_unslash($_POST['contact_quantity'])) : '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_safe_redirect(add_query_arg('contact_error', 'required', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
        exit;
    }

    // Email validation
    if (!is_email($email)) {
        wp_safe_redirect(add_query_arg('contact_error', 'email', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
        exit;
    }

    // Build email - recipient from module config or fallback to admin
    $to      = erdu_module_config('contact_form', 'recipient_email', get_option('admin_email'));
    $headers = array('Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>');
    $body    = "<h2>" . esc_html__('New Contact Form Submission', 'erdu-wp') . "</h2>\n";
    $body   .= "<p><strong>" . esc_html__('Name', 'erdu-wp') . ":</strong> " . esc_html($name) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Email', 'erdu-wp') . ":</strong> " . esc_html($email) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Phone', 'erdu-wp') . ":</strong> " . esc_html($phone) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Company', 'erdu-wp') . ":</strong> " . esc_html($company) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Country', 'erdu-wp') . ":</strong> " . esc_html($country) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Subject', 'erdu-wp') . ":</strong> " . esc_html($subject) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Product Interest', 'erdu-wp') . ":</strong> " . esc_html($product) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Estimated Quantity', 'erdu-wp') . ":</strong> " . esc_html($quantity) . "</p>\n";
    $body   .= "<p><strong>" . esc_html__('Message', 'erdu-wp') . ":</strong></p>\n";
    $body   .= "<p>" . nl2br(esc_html($message)) . "</p>\n";

    $sent = wp_mail($to, '[ERDU] ' . esc_html($subject), $body, $headers);

    if ($sent) {
        wp_safe_redirect(add_query_arg('contact_success', '1', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
    } else {
        wp_safe_redirect(add_query_arg('contact_error', 'send', erdu_safe_redirect_url(erdu_get_page_url('contact'))));
    }
    exit;
}

/**
 * Handle Distributor Application Form
 */
add_action('admin_post_erdu_distributor_form', 'erdu_handle_distributor_form');
add_action('admin_post_nopriv_erdu_distributor_form', 'erdu_handle_distributor_form');

function erdu_handle_distributor_form()
{
    // Verify nonce
    if (!isset($_POST['erdu_dist_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['erdu_dist_nonce'])), 'erdu_dist_action')) {
        wp_die(esc_html__('Security check failed.', 'erdu-wp'));
    }

    // Rate limiting
    if (!erdu_check_rate_limit('distributor', 3, 3600)) {
        wp_safe_redirect(add_query_arg('dist_error', 'ratelimit', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
        exit;
    }

    // Honeypot check (hidden field that should be empty)
    if (!empty($_POST['website'])) {
        wp_safe_redirect(add_query_arg('dist_success', '1', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
        exit;
    }

    // Sanitize fields (synced with reference page form)
    $fields = array(
        'dist_company', 'dist_business_type', 'dist_country', 'dist_city',
        'dist_revenue', 'dist_current_categories', 'dist_name', 'dist_title',
        'dist_email', 'dist_phone', 'dist_target_market', 'dist_first_order',
        // Legacy fields for backwards compatibility
        'dist_website', 'dist_years', 'dist_employees', 'dist_channels',
        'dist_territory', 'dist_current_brands', 'dist_annual_volume', 'dist_why'
    );
    $data = array();
    foreach ($fields as $field) {
        $data[$field] = isset($_POST[$field]) ? sanitize_text_field(wp_unslash($_POST[$field])) : '';
    }
    // Email field needs special sanitization
    $data['dist_email'] = isset($_POST['dist_email']) ? sanitize_email(wp_unslash($_POST['dist_email'])) : '';
    // Website field needs URL sanitization
    $data['dist_website'] = isset($_POST['dist_website']) ? esc_url_raw(wp_unslash($_POST['dist_website'])) : '';

    // Validate
    if (empty($data['dist_company']) || empty($data['dist_country']) || empty($data['dist_email']) || empty($data['dist_name']) || empty($data['dist_city']) || empty($data['dist_target_market']) || empty($data['dist_first_order'])) {
        wp_safe_redirect(add_query_arg('dist_error', 'required', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
        exit;
    }

    // Email validation
    if (!is_email($data['dist_email'])) {
        wp_safe_redirect(add_query_arg('dist_error', 'email', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
        exit;
    }

    // Build email - recipient from module config or fallback to admin
    $to      = erdu_module_config('distributor', 'recipient_email', get_option('admin_email'));
    $headers = array('Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $data['dist_name'] . ' <' . $data['dist_email'] . '>');
    $subject = '[ERDU Distributor] Application from ' . esc_html($data['dist_company']);

    $body  = "<h2>" . esc_html__('New Distributor Application', 'erdu-wp') . "</h2>\n";
    $body .= "<p><strong>" . esc_html__('Company', 'erdu-wp') . ":</strong> " . esc_html($data['dist_company']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Business Type', 'erdu-wp') . ":</strong> " . esc_html($data['dist_business_type']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Country/Region', 'erdu-wp') . ":</strong> " . esc_html($data['dist_country']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('City', 'erdu-wp') . ":</strong> " . esc_html($data['dist_city']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Annual Revenue Range', 'erdu-wp') . ":</strong> " . esc_html($data['dist_revenue']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Current Product Categories', 'erdu-wp') . ":</strong> " . esc_html($data['dist_current_categories']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Contact Name', 'erdu-wp') . ":</strong> " . esc_html($data['dist_name']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Job Title', 'erdu-wp') . ":</strong> " . esc_html($data['dist_title']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Email', 'erdu-wp') . ":</strong> " . esc_html($data['dist_email']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Phone/WhatsApp', 'erdu-wp') . ":</strong> " . esc_html($data['dist_phone']) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Target Market Description', 'erdu-wp') . ":</strong></p>\n";
    $body .= "<p>" . nl2br(esc_html($data['dist_target_market'])) . "</p>\n";
    $body .= "<p><strong>" . esc_html__('Expected First Order Volume', 'erdu-wp') . ":</strong> " . esc_html($data['dist_first_order']) . "</p>\n";
    // Legacy fields (only output if provided)
    if (!empty($data['dist_website']))   $body .= "<p><strong>" . esc_html__('Website', 'erdu-wp') . ":</strong> " . esc_html($data['dist_website']) . "</p>\n";
    if (!empty($data['dist_why']))       $body .= "<p><strong>" . esc_html__('Why ERDU', 'erdu-wp') . ":</strong></p>\n<p>" . nl2br(esc_html($data['dist_why'])) . "</p>\n";

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_safe_redirect(add_query_arg('dist_success', '1', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
    } else {
        wp_safe_redirect(add_query_arg('dist_error', 'send', erdu_safe_redirect_url(erdu_get_page_url('distributor'))));
    }
    exit;
}

// ==========================================
// Sample Content Seeding
// ==========================================

/**
 * Create sample content for CPTs on FIRST theme activation only.
 *
 * SAFETY: This function ONLY creates content when the transient flag
 * 'erdu_seed_content_needed' is set to 'yes'. This flag is ONLY set by
 * after_switch_theme (when user switches TO this theme), NOT during
 * routine theme updates. A persistent 'erdu_content_seeded' option
 * provides an additional guard against duplicate seeding.
 *
 * Runs after CPTs are registered (priority 20 on init).
 */
add_action('init', 'erdu_seed_sample_content', 20);
function erdu_seed_sample_content()
{
    // Primary guard: transient flag set by after_switch_theme
    if (get_option('erdu_seed_content_needed') !== 'yes') {
        return;
    }
    // Must be in admin context
    if (!is_admin()) {
        return;
    }
    // Consume the flag immediately
    delete_option('erdu_seed_content_needed');

    // Secondary guard: already seeded in a previous activation
    if (get_option('erdu_content_seeded') === 'yes') {
        return;
    }

    // =====================================================
    // 1. Sample News Articles
    // =====================================================
    $sample_news = array(
        array(
            'title'   => 'ERDU Unveils New UT16 Smart Track Light Series at Hong Kong Lighting Fair',
            'excerpt' => 'ERDU Lighting proudly presented the UT16 Smart Track Light Series at the Hong Kong International Lighting Fair, featuring app-controlled dimming, color temperature adjustment, and seamless integration with smart home systems.',
            'content' => '<p>ERDU Lighting proudly presented the UT16 Smart Track Light Series at the Hong Kong International Lighting Fair. The new series features app-controlled dimming, color temperature adjustment from 2700K to 5000K, and seamless integration with popular smart home systems including Tuya, Philips Hue, and Apple HomeKit.</p><p>"The UT16 represents our commitment to innovation in the magnetic track lighting space," said David Deng, General Manager of ERDU Lighting. "We believe smart lighting is the future, and our 48V magnetic track system provides the perfect foundation for intelligent lighting solutions."</p><p>The UT16 series will be available for order starting Q2 2026, with OEM and ODM options for distributors worldwide.</p>',
            'date'    => '2026-04-15',
            'cat'     => 'Company News',
        ),
        array(
            'title'   => 'ERDU Achieves ISO 9001:2015 Recertification with Zero Non-Conformities',
            'excerpt' => 'ERDU Lighting has successfully passed its ISO 9001:2015 surveillance audit with zero non-conformities, reaffirming the company\'s commitment to quality management excellence.',
            'content' => '<p>ERDU Lighting has successfully passed its ISO 9001:2015 surveillance audit with zero non-conformities. The audit, conducted by Bureau Veritas, covered all aspects of ERDU\'s quality management system including design, production, testing, and customer service.</p><p>This marks the third consecutive year that ERDU has achieved a clean audit result, demonstrating the robustness of our quality control processes," said Lisa Wang, QC Manager at ERDU Lighting.</p><p>The certification covers ERDU\'s full range of 48V magnetic track lighting products, including the UT, GS, DT, and LT series.</p>',
            'date'    => '2026-03-22',
            'cat'     => 'Company News',
        ),
        array(
            'title'   => 'ERDU Expands European Distribution Network with Three New Partners',
            'excerpt' => 'ERDU Lighting announces partnerships with distributors in Germany, France, and the Netherlands, strengthening its presence in the European lighting market.',
            'content' => '<p>ERDU Lighting is pleased to announce three new distribution partnerships in Europe. The new partners will represent ERDU\'s full range of 48V magnetic track lighting products in Germany, France, and the Netherlands.</p><p>"Europe represents a significant growth opportunity for ERDU," said Eileen Zhang, Sales Director. "Our CE-certified products are ideally suited for the European market, and these partnerships will help us better serve local customers with faster delivery and localized technical support."</p><p>The new partnerships bring ERDU\'s global distributor network to over 25 countries across 5 continents.</p>',
            'date'    => '2026-02-10',
            'cat'     => 'Company News',
        ),
        array(
            'title'   => 'New GS Pro Series: Anti-Glare Grille Spot Light with UGR < 13',
            'excerpt' => 'ERDU introduces the GS Pro Series, featuring advanced anti-glare technology with UGR ratings below 13, making it ideal for offices, schools, and healthcare facilities.',
            'content' => '<p>ERDU Lighting introduces the GS Pro Series, an upgraded version of its popular GS Grille Spot Light. The new series features advanced anti-glare technology with UGR (Unified Glare Rating) below 13, meeting the stringent requirements of offices, schools, libraries, and healthcare facilities.</p><p>The GS Pro Series is available in single, double, and triple head configurations, with power options ranging from 10W to 30W. All models feature CRI 90+ for accurate color rendering and are compatible with ERDU\'s 48V magnetic track system.</p><p>Samples are available now for qualified distributors and lighting designers.</p>',
            'date'    => '2026-01-28',
            'cat'     => 'Product Launch',
        ),
        array(
            'title'   => 'ERDU Factory Tour: Inside Our 6300m² Production Facility',
            'excerpt' => 'Take a virtual tour of ERDU Lighting\'s state-of-the-art production facility in Guzhen, Zhongshan, featuring 6 automated production lines and a comprehensive QC laboratory.',
            'content' => '<p>ERDU Lighting opens its doors for a virtual tour of its 6300m² production facility in Guzhen, Zhongshan — the lighting capital of China. The facility features 6 automated production lines with a daily capacity of over 3,000 units.</p><p>Highlights of the tour include the SMT (Surface Mount Technology) workshop, automated assembly lines, 48-hour aging test room, and the photometric testing laboratory equipped with integrating spheres and goniophotometers.</p><p>"We believe transparency builds trust," said David Deng. "By sharing our production capabilities, we want our partners to see the quality and scale that ERDU brings to every project."</p>',
            'date'    => '2026-01-15',
            'cat'     => 'Company News',
        ),
        array(
            'title'   => '48V Magnetic Track Lighting: The Future of Commercial Illumination',
            'excerpt' => 'An in-depth look at why 48V magnetic track lighting is becoming the preferred choice for commercial spaces worldwide, and how ERDU is leading the innovation.',
            'content' => '<p>48V magnetic track lighting is rapidly gaining popularity in commercial spaces worldwide. The technology offers several key advantages over traditional track systems:</p><ul><li><strong>Tool-free installation:</strong> Lights magnetically attach to the track, allowing instant repositioning</li><li><strong>Low voltage safety:</strong> 48V DC is safe to touch, reducing electrical hazards</li><li><strong>Modular flexibility:</strong> Mix and match spot lights, linear lights, pendant lights, and more on the same track</li><li><strong>Energy efficiency:</strong> Low voltage DC power reduces energy loss compared to AC systems</li></ul><p>ERDU Lighting has been at the forefront of 48V magnetic track lighting innovation since 2017, with over 8 product series covering commercial, residential, hospitality, and industrial applications.</p>',
            'date'    => '2025-12-20',
            'cat'     => 'Industry Insights',
        ),
    );

    foreach ($sample_news as $news) {
        if (erdu_post_exists_by_title($news['title'], 'erdu_news')) continue;

        $post_id = wp_insert_post(array(
            'post_title'   => $news['title'],
            'post_content' => $news['content'],
            'post_excerpt' => $news['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'erdu_news',
            'post_date'    => $news['date'],
        ));

        if ($post_id && !is_wp_error($post_id) && !empty($news['cat'])) {
            wp_set_object_terms($post_id, $news['cat'], 'erdu_news_cat', true);
        }
    }

    // =====================================================
    // 2. Sample Case Studies
    // =====================================================
    $sample_cases = array(
        array(
            'title'       => 'Luxury Boutique',
            'excerpt'     => '68% energy reduction, zero heat emission near merchandise, and customers reported the store felt more luxurious and inviting.',
            'content'     => '<p>A luxury boutique in Shanghai upgraded its lighting with ERDU 48V magnetic track system to create a premium shopping experience while reducing energy costs.</p><h3>Challenge</h3><p>The boutique needed focused lighting that would highlight merchandise without generating heat that could damage delicate fabrics. The system also needed to be flexible enough to adapt to seasonal displays.</p><h3>Solution</h3><p>ERDU installed 45 meters of 48V magnetic track with 32 UT Series spotlights and 18 linear accent lights. All fixtures featured CRI 95+ for accurate color rendering and deep anti-glare design.</p><h3>Results</h3><p>The boutique achieved 68% energy reduction compared to the previous halogen system. Customers reported the store felt more luxurious and inviting, and staff noted zero heat emission near merchandise. Sales increased by 15% in the first quarter after installation.</p>',
            'industry'    => 'retail',
            'location'    => 'Shanghai, China',
            'area'        => '150m²',
            'year'        => '2024',
            'tags'        => array('48V Magnetic Track', '48V Magnetic Track'),
            'image'       => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600',
            'date'        => '2024-03-01',
        ),
        array(
            'title'       => 'Modern Hotel Lobby',
            'excerpt'     => '50% energy savings, guest satisfaction scores for \'lobby ambiance\' increased from 7.2 to 9.1, and the installation was completed in 5 days.',
            'content'     => '<p>A 5-star hotel in Dubai renovated its main lobby with ERDU magnetic track lighting to create a stunning first impression while reducing operational costs.</p><h3>Challenge</h3><p>The hotel needed a lighting solution that could deliver dramatic ambiance in the lobby while being easy to maintain and reconfigure for different events and seasons.</p><h3>Solution</h3><p>ERDU designed a layered lighting scheme using 200+ meters of magnetic track, pendant lights over seating areas, flood lights for wall washing, and spotlights for artwork highlighting.</p><h3>Results</h3><p>The hotel achieved 50% energy savings compared to the previous system. Guest satisfaction scores for "lobby ambiance" increased from 7.2 to 9.1. The entire installation was completed in just 5 days with minimal disruption to hotel operations.</p>',
            'industry'    => 'hospitality',
            'location'    => 'Dubai, UAE',
            'area'        => '800m²',
            'year'        => '2023',
            'tags'        => array('Magnetic Pendant Light', 'Magnetic Flood Light'),
            'image'       => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600',
            'date'        => '2023-08-15',
        ),
        array(
            'title'       => 'Creative Office',
            'excerpt'     => 'UGR<19 achieved across all work areas, 45% energy reduction, and the company received a Green Building certification.',
            'content'     => '<p>A creative technology company in Singapore transformed its office lighting with ERDU\'s glare-free magnetic track system to improve employee comfort and productivity.</p><h3>Challenge</h3><p>The office needed uniform, glare-free illumination for computer-based work while maintaining design flexibility for the open-plan layout and collaborative zones.</p><h3>Solution</h3><p>ERDU installed 350+ linear magnetic lights and spotlights across 600m² of office space. All workstation areas achieved UGR < 19, and the system was integrated with daylight sensors for automatic dimming.</p><h3>Results</h3><p>The project achieved 45% energy reduction and the company received a Green Building certification. Employee complaints about eye strain dropped by 80%, and the flexible track system allows the facilities team to reconfigure lighting as teams move between zones.</p>',
            'industry'    => 'office',
            'location'    => 'Singapore',
            'area'        => '600m²',
            'year'        => '2024',
            'tags'        => array('Linear Magnetic Light', 'Spotlight SPT-01'),
            'image'       => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600',
            'date'        => '2024-01-20',
        ),
        array(
            'title'       => 'Minimalist Living',
            'excerpt'     => 'Achieved the desired minimalist aesthetic with full lighting flexibility. The homeowner has reconfigured the layout 4 times since installation.',
            'content'     => '<p>A residential project in Melbourne used ERDU magnetic track lighting to achieve a clean, minimalist interior without sacrificing lighting quality or flexibility.</p><h3>Challenge</h3><p>The homeowner wanted a "no main light" design with clean ceilings, but still needed flexible task and ambient lighting that could adapt as furniture arrangements changed.</p><h3>Solution</h3><p>ERDU installed recessed magnetic track throughout the living areas, with a mix of spotlights, linear lights, and a custom folding light fixture as a design feature.</p><h3>Results</h3><p>The project achieved the desired minimalist aesthetic with full lighting flexibility. The homeowner has reconfigured the layout 4 times since installation without calling an electrician. The system received praise from the interior designer and was featured in a local design magazine.</p>',
            'industry'    => 'residential',
            'location'    => 'Melbourne, Australia',
            'area'        => '120m²',
            'year'        => '2024',
            'tags'        => array('48V Magnetic Track', 'Folding Light EMF-02'),
            'image'       => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=600',
            'date'        => '2024-02-10',
        ),
        array(
            'title'       => 'Art Gallery',
            'excerpt'     => 'CRI95+ across all fixtures, zero UV emission (art-safe), and the gallery reported a 30% increase in visitor dwell time.',
            'content'     => '<p>A contemporary art gallery in Paris selected ERDU lighting to protect valuable artworks while providing exceptional color rendering for visitors.</p><h3>Challenge</h3><p>The gallery needed museum-quality lighting with CRI 95+, zero UV emission, and precise beam control to protect sensitive artworks while enhancing the viewing experience.</p><h3>Solution</h3><p>ERDU supplied 80+ specialized gallery spotlights on magnetic track, with adjustable beam angles and integrated UV filters. The track system allows curators to adapt lighting for rotating exhibitions.</p><h3>Results</h3><p>All fixtures achieved CRI 95+ with zero UV emission, meeting museum conservation standards. The gallery reported a 30% increase in visitor dwell time and received positive feedback from artists about how their work was presented.</p>',
            'industry'    => 'retail',
            'location'    => 'Paris, France',
            'area'        => '400m²',
            'year'        => '2023',
            'tags'        => array('48V Magnetic Track', 'Magnetic Track (2m)'),
            'image'       => 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=600',
            'date'        => '2023-09-05',
        ),
        array(
            'title'       => 'Industrial Warehouse',
            'excerpt'     => '62.5% energy reduction, improved color recognition for quality control, and maintenance costs dropped by 70%.',
            'content'     => '<p>A logistics and quality control warehouse in Sao Paulo upgraded to ERDU high-bay magnetic lighting to improve visibility and reduce operating costs across a vast industrial space.</p><h3>Challenge</h3><p>The warehouse needed bright, uniform illumination for quality control inspection areas, with high energy efficiency and minimal maintenance requirements given the 12-meter ceiling height.</p><h3>Solution</h3><p>ERDU installed 180 high-watt magnetic high-bay lights with motion sensors and daylight harvesting. The magnetic attachment system simplified installation and future maintenance.</p><h3>Results</h3><p>The facility achieved 62.5% energy reduction and maintenance costs dropped by 70%. Color recognition in quality control areas improved significantly, reducing defect escape rates by 18%.</p>',
            'industry'    => 'office',
            'location'    => 'Sao Paulo, Brazil',
            'area'        => '2000m²',
            'year'        => '2023',
            'tags'        => array('High Watt Magnetic', 'High Bay Light'),
            'image'       => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600',
            'date'        => '2023-11-12',
        ),
    );

    foreach ($sample_cases as $case) {
        if (erdu_post_exists_by_title($case['title'], 'erdu_case')) continue;

        $post_id = wp_insert_post(array(
            'post_title'   => $case['title'],
            'post_content' => $case['content'],
            'post_excerpt' => $case['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'erdu_case',
            'post_date'    => $case['date'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            if (!empty($case['industry'])) {
                wp_set_object_terms($post_id, $case['industry'], 'erdu_case_industry', true);
            }
            if (!empty($case['location'])) {
                update_post_meta($post_id, 'case_location', $case['location']);
            }
            if (!empty($case['area'])) {
                update_post_meta($post_id, 'case_area', $case['area']);
            }
            if (!empty($case['year'])) {
                update_post_meta($post_id, 'case_year', $case['year']);
            }
            if (!empty($case['tags'])) {
                update_post_meta($post_id, 'case_tags', $case['tags']);
            }
            if (!empty($case['image'])) {
                update_post_meta($post_id, 'case_image_url', $case['image']);
            }
        }
    }

    // =====================================================
    // 3. Sample Exhibitions
    // =====================================================
    $sample_exhibitions = array(
        array(
            'title'    => 'Hong Kong International Lighting Fair 2026',
            'content'  => '<p>ERDU Lighting will exhibit at the Hong Kong International Lighting Fair, Asia\'s largest lighting trade show. Visit us at Hall 1A, Booth C12 to see our latest 48V magnetic track lighting innovations.</p><p>We will be showcasing the new UT16 Smart Series with app control, the GS Pro anti-glare line, and our complete range of commercial and residential lighting solutions.</p>',
            'date'     => '2026-10-27',
            'location' => 'Hong Kong Convention & Exhibition Centre',
            'booth'    => 'Hall 1A, C12',
            'link'     => 'https://hklightingfair.hktdc.com',
        ),
        array(
            'title'    => 'Light + Building 2026 — Frankfurt',
            'content'  => '<p>ERDU Lighting returns to Light + Building, the world\'s leading trade fair for lighting and building services technology. Find us in Hall 4.0, Booth B20.</p><p>This year we are introducing our European product line with full CE certification, including new models designed specifically for the EU market with ERP compliance.</p>',
            'date'     => '2026-03-08',
            'location' => 'Messe Frankfurt, Germany',
            'booth'    => 'Hall 4.0, B20',
            'link'     => 'https://light-building.messefrankfurt.com',
        ),
        array(
            'title'    => 'Dubai LED Expo 2026',
            'content'  => '<p>Join ERDU Lighting at the Dubai LED Expo, the premier lighting exhibition in the Middle East. We will be at Zabeel Hall 3, showcasing our hospitality and commercial lighting solutions.</p><p>Our Middle East product specialist team will be available to discuss distribution partnerships and project specifications for the GCC region.</p>',
            'date'     => '2026-01-16',
            'location' => 'Dubai World Trade Centre, UAE',
            'booth'    => 'Zabeel Hall 3',
            'link'     => 'https://www.dubailedexpo.com',
        ),
        array(
            'title'    => 'Guangzhou International Lighting Exhibition 2026',
            'content'  => '<p>ERDU Lighting will participate in the Guangzhou International Lighting Exhibition, China\'s largest lighting trade show. Visit our booth in Hall 10.2 to explore our complete product range.</p><p>Special focus on our smart home integration capabilities and OEM/ODM services for international partners.</p>',
            'date'     => '2026-06-09',
            'location' => 'Canton Fair Complex, Guangzhou, China',
            'booth'    => 'Hall 10.2, B18',
            'link'     => 'http://www.gzlighting.com',
        ),
    );

    foreach ($sample_exhibitions as $expo) {
        if (erdu_post_exists_by_title($expo['title'], 'erdu_exhibition')) continue;

        $post_id = wp_insert_post(array(
            'post_title'   => $expo['title'],
            'post_content' => $expo['content'],
            'post_status'  => 'publish',
            'post_type'    => 'erdu_exhibition',
            'post_date'    => $expo['date'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            if (!empty($expo['date']))   update_post_meta($post_id, 'exhibition_date', $expo['date']);
            if (!empty($expo['location'])) update_post_meta($post_id, 'exhibition_location', $expo['location']);
            if (!empty($expo['booth']))  update_post_meta($post_id, 'exhibition_booth', $expo['booth']);
            if (!empty($expo['link']))   update_post_meta($post_id, 'exhibition_link', $expo['link']);
        }
    }

    // =====================================================
    // 4. Sample Blog Posts
    // =====================================================
    $sample_blogs = array(
        array(
            'title'   => 'Understanding 48V Magnetic Track Lighting: A Complete Guide',
            'excerpt'  => 'Learn everything about 48V magnetic track lighting — how it works, its benefits, and why it is the future of commercial illumination.',
            'content'  => '<p>48V magnetic track lighting is revolutionizing the way we think about commercial and residential lighting. This comprehensive guide covers everything you need to know about this innovative technology.</p><h2>What is 48V Magnetic Track Lighting?</h2><p>48V magnetic track lighting is a low-voltage lighting system that uses magnetic attachment to secure light fixtures to a track. The 48V DC power is safe to touch, making installation and repositioning straightforward without the need for tools.</p><h2>Key Benefits</h2><ul><li><strong>Tool-free installation:</strong> Lights magnetically attach to the track</li><li><strong>Low voltage safety:</strong> 48V DC is safe to touch</li><li><strong>Modular flexibility:</strong> Mix different light types on the same track</li><li><strong>Energy efficiency:</strong> Low voltage DC reduces energy loss</li><li><strong>Easy maintenance:</strong> Swap fixtures without rewiring</li></ul><h2>Applications</h2><p>48V magnetic track lighting is ideal for retail stores, galleries, museums, hotels, offices, and residential spaces where flexibility and design aesthetics are paramount.</p>',
            'date'     => '2026-04-20',
            'cat'      => 'Lighting Guides',
            'tags'     => array('48V', 'track lighting', 'guide', 'commercial'),
        ),
        array(
            'title'   => 'How to Choose the Right Beam Angle for Track Lights',
            'excerpt'  => 'Selecting the correct beam angle is crucial for achieving optimal lighting results. This guide walks you through the decision process.',
            'content'  => '<p>Beam angle is one of the most important yet often overlooked aspects of track lighting design. The right beam angle can transform a space, while the wrong choice can lead to uneven lighting and wasted energy.</p><h2>Understanding Beam Angles</h2><p>Beam angles are typically categorized as narrow (10-20 degrees), medium (24-40 degrees), and wide (60+ degrees). Each serves different purposes:</p><ul><li><strong>Narrow (10-20 degrees):</strong> Ideal for accent lighting and highlighting specific objects</li><li><strong>Medium (24-40 degrees):</strong> Best for general illumination in retail and gallery spaces</li><li><strong>Wide (60+ degrees):</strong> Perfect for ambient lighting and washing walls</li></ul><h2>Practical Considerations</h2><p>When choosing a beam angle, consider ceiling height, the size of objects to be illuminated, and the overall lighting design goals. A good rule of thumb is that the beam diameter at floor level should match the width of the display area.</p>',
            'date'     => '2026-03-25',
            'cat'      => 'Product Tips',
            'tags'     => array('beam angle', 'track lights', 'design tips'),
        ),
        array(
            'title'   => 'ERDU Lighting at Hong Kong International Lighting Fair 2026',
            'excerpt'  => 'A recap of ERDU Lighting\'s successful exhibition at the Hong Kong International Lighting Fair, showcasing our latest innovations.',
            'content'  => '<p>ERDU Lighting made a strong impression at the 2026 Hong Kong International Lighting Fair, Asia\'s largest lighting trade show. Our booth in Hall 1A attracted over 500 visitors from 40+ countries.</p><h2>Product Highlights</h2><p>We showcased three new product lines at the fair:</p><ul><li><strong>UT16 Smart Series:</strong> Our first app-controlled track light with tunable white and dim-to-warm</li><li><strong>GS Pro Anti-Glare:</strong> UGR < 13 grille spot for glare-sensitive applications</li><li><strong>LT Mini:</strong> Ultra-slim 12mm linear light for tight spaces</li></ul><p>The UT16 Smart Series received particularly strong interest, with over 50 distributors requesting samples during the three-day event.</p>',
            'date'     => '2026-03-05',
            'cat'      => 'Company News',
            'tags'     => array('exhibition', 'Hong Kong', 'trade show', 'product launch'),
        ),
        array(
            'title'   => 'CRI 90 vs CRI 95: Does It Really Matter for Track Lighting?',
            'excerpt'  => 'We break down the differences between CRI 90 and CRI 95 and help you decide which is right for your lighting project.',
            'content'  => '<p>Color Rendering Index (CRI) is a critical metric for evaluating light quality. But is the jump from CRI 90 to CRI 95 worth the additional cost? Let\'s explore the science and practical implications.</p><h2>What is CRI?</h2><p>CRI measures how accurately a light source renders colors compared to natural daylight (CRI 100). Higher CRI values mean colors appear more vivid and true to life under the light source.</p><h2>CRI 90 vs CRI 95 in Practice</h2><p>For most commercial applications — retail, offices, hospitality — CRI 90 provides excellent color rendering. However, in color-critical environments like art galleries, museums, and high-end retail, CRI 95 makes a noticeable difference in how products and artworks appear.</p><p>ERDU offers both CRI 90 (standard) and CRI 95+ (premium) options across our entire product range, allowing you to match the right specification to each project.</p>',
            'date'     => '2026-02-15',
            'cat'      => 'Lighting Guides',
            'tags'     => array('CRI', 'color rendering', 'lighting quality', 'technical'),
        ),
        array(
            'title'   => '5 Common Track Lighting Mistakes (and How to Avoid Them)',
            'excerpt'  => 'Avoid these common pitfalls when designing and installing track lighting systems for professional results.',
            'content'  => '<p>Track lighting is incredibly versatile, but it is easy to make mistakes that compromise both aesthetics and functionality. Here are the five most common errors we see in the field and how to avoid them.</p><h2>1. Insufficient Track Planning</h2><p>Many projects fail because the track layout was not planned with the final lighting design in mind. Always plan your track runs before ceiling installation to ensure optimal fixture placement.</p><h2>2. Wrong Fixture Spacing</h2><p>Fixtures placed too close together create hotspots, while spacing that is too wide leaves dark areas. A general guideline is 2-3 times the mounting height for spacing between fixtures.</p><h2>3. Ignoring Glare Control</h2><p>Direct glare can make spaces uncomfortable. Use deep-set reflectors, honeycomb louvers, or adjustable glare shields to control direct light spill.</p><h2>4. Overloading the Track</h2><p>Each track circuit has a maximum wattage rating. Exceeding this can cause flickering or circuit failure. Always calculate total load before finalizing the design.</p><h2>5. Poor Color Temperature Matching</h2><p>Mixing different CCT fixtures on the same track creates visual inconsistency. Always specify and verify color temperature across all fixtures in a single zone.</p>',
            'date'     => '2026-01-30',
            'cat'      => 'Product Tips',
            'tags'     => array('installation', 'design tips', 'common mistakes', 'best practices'),
        ),
        array(
            'title'   => 'Smart Lighting Integration: Connecting ERDU to Your Building Management System',
            'excerpt'  => 'Learn how ERDU\'s DALI-compatible track lights integrate with modern building management systems for intelligent lighting control.',
            'content'  => '<p>Modern buildings demand intelligent lighting systems that respond to occupancy, daylight, and energy management protocols. ERDU\'s DALI-compatible track lighting products are designed for seamless integration with leading BMS platforms.</p><h2>DALI Protocol Overview</h2><p>DALI (Digital Addressable Lighting Interface) is the industry-standard protocol for digital lighting control. It enables individual addressability, scene programming, and real-time monitoring of each fixture on the network.</p><h2>Compatible Systems</h2><p>ERDU DALI products have been tested and certified compatible with major BMS platforms including Siemens Desigo, Schneider EcoStruxure, Johnson Controls Metasys, and Honeywell EBI.</p><h2>Implementation Guide</h2><p>Integrating ERDU track lights into your DALI network requires three components: DALI-enabled fixtures (UT-D/GS-D/LT-D series), a DALI bus power supply, and a DALI gateway compatible with your BMS. Our technical team provides detailed wiring diagrams and commissioning support for all projects.</p>',
            'date'     => '2026-01-10',
            'cat'      => 'Technical',
            'tags'     => array('DALI', 'smart lighting', 'BMS integration', 'building automation'),
        ),
    );

    foreach ($sample_blogs as $blog) {
        // Use native 'post' type — check against all posts to avoid duplicates
        if (erdu_post_exists_by_title($blog['title'], 'post')) continue;

        $post_id = wp_insert_post(array(
            'post_title'   => $blog['title'],
            'post_content' => $blog['content'],
            'post_excerpt' => $blog['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'post',          // Native WordPress post
            'post_date'    => $blog['date'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            // Use native WordPress category
            if (!empty($blog['cat'])) {
                wp_set_object_terms($post_id, $blog['cat'], 'category', true);
            }
            // Use native WordPress post_tag
            if (!empty($blog['tags'])) {
                wp_set_object_terms($post_id, $blog['tags'], 'post_tag', true);
            }
        }
    }

    // =====================================================
    // 5. Sample Downloads (document files)
    // =====================================================
    $sample_downloads = array(
        array(
            'title'       => 'ERDU Company Profile 2026',
            'description' => 'Company introduction, product overview, and service capabilities.',
            'version'     => '2026 Edition',
            'cat'         => 'Company Documents',
        ),
        array(
            'title'       => 'Product Catalog - UT Series',
            'description' => 'Complete specifications for UT magnetic track light series.',
            'version'     => 'v3.2',
            'cat'         => 'Product Catalogs',
        ),
        array(
            'title'       => 'Product Catalog - GS Series',
            'description' => 'Complete specifications for GS grille spot light series.',
            'version'     => 'v2.1',
            'cat'         => 'Product Catalogs',
        ),
        array(
            'title'       => 'IES Photometric Files - Full Collection',
            'description' => 'IES LM-63 photometric data files for lighting design software.',
            'version'     => '2026 Q1',
            'cat'         => 'Technical Files',
        ),
        array(
            'title'       => '3D Model Files - Track Rail Systems',
            'description' => 'STEP/DWG format 3D models for architectural integration.',
            'version'     => 'v1.5',
            'cat'         => '3D Models',
        ),
        array(
            'title'       => 'ISO9001:2015 Certificate',
            'description' => 'Quality management system certification document.',
            'version'     => 'Valid until 2027',
            'cat'         => 'Certificates',
        ),
    );

    foreach ($sample_downloads as $dl) {
        if (erdu_post_exists_by_title($dl['title'], 'erdu_download')) continue;

        $post_id = wp_insert_post(array(
            'post_title'   => $dl['title'],
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'erdu_download',
        ));

        if ($post_id && !is_wp_error($post_id)) {
            if (!empty($dl['cat'])) {
                wp_set_object_terms($post_id, $dl['cat'], 'erdu_download_cat', true);
            }
            if (!empty($dl['description'])) {
                update_post_meta($post_id, 'download_description', $dl['description']);
            }
            if (!empty($dl['version'])) {
                update_post_meta($post_id, 'download_version', $dl['version']);
            }
        }
    }

    // Mark that content has been seeded — prevents re-seeding on theme updates
    update_option('erdu_content_seeded', 'yes');
}

/**
 * Helper: Check if a post exists by title and post type.
 *
 * @param string $title Post title.
 * @param string $post_type Post type slug.
 * @return bool True if a post with the same title exists.
 */
function erdu_post_exists_by_title($title, $post_type)
{
    $existing = get_posts(array(
        'post_type'      => $post_type,
        'posts_per_page' => 1,
        'post_status'    => 'any',
        's'              => $title,
    ));
    return !empty($existing);
}