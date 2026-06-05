<?php
/**
 * ACF Block Types
 * Custom Gutenberg blocks for ERDU Lighting page components.
 * Each block allows content editing without changing the front-end style.
 *
 * Requires ACF Pro 5.8+
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

// ==========================================
// Block Registration
// ==========================================

add_action('acf/init', 'erdu_register_acf_blocks');
function erdu_register_acf_blocks()
{
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    $blocks = array(
        array(
            'name'        => 'erdu-hero',
            'title'       => __('ERDU Hero', 'erdu-wp'),
            'description' => __('Hero section with title, subtitle and background image.', 'erdu-wp'),
            'icon'        => 'cover-image',
            'keywords'    => array('hero', 'banner', 'header'),
        ),
        array(
            'name'        => 'erdu-content',
            'title'       => __('ERDU Content', 'erdu-wp'),
            'description' => __('Rich text content area with WYSIWYG editor.', 'erdu-wp'),
            'icon'        => 'text',
            'keywords'    => array('content', 'text', 'editor'),
        ),
        array(
            'name'        => 'erdu-timeline',
            'title'       => __('ERDU Timeline', 'erdu-wp'),
            'description' => __('Vertical timeline showing company milestones.', 'erdu-wp'),
            'icon'        => 'clock',
            'keywords'    => array('timeline', 'history', 'milestones'),
        ),
        array(
            'name'        => 'erdu-team',
            'title'       => __('ERDU Team', 'erdu-wp'),
            'description' => __('Leadership team grid with photos and bios.', 'erdu-wp'),
            'icon'        => 'groups',
            'keywords'    => array('team', 'people', 'staff'),
        ),
        array(
            'name'        => 'erdu-values',
            'title'       => __('ERDU Values', 'erdu-wp'),
            'description' => __('Mission statement and company values grid.', 'erdu-wp'),
            'icon'        => 'heart',
            'keywords'    => array('values', 'mission', 'culture'),
        ),
        array(
            'name'        => 'erdu-stats',
            'title'       => __('ERDU Stats', 'erdu-wp'),
            'description' => __('Key statistics / numbers grid display.', 'erdu-wp'),
            'icon'        => 'chart-bar',
            'keywords'    => array('stats', 'numbers', 'metrics'),
        ),
        array(
            'name'        => 'erdu-cta',
            'title'       => __('ERDU CTA', 'erdu-wp'),
            'description' => __('Call-to-action banner with button.', 'erdu-wp'),
            'icon'        => 'button',
            'keywords'    => array('cta', 'banner', 'action'),
        ),
        array(
            'name'        => 'erdu-partners',
            'title'       => __('ERDU Partners', 'erdu-wp'),
            'description' => __('Partner/supplier logo grid.', 'erdu-wp'),
            'icon'        => 'networking',
            'keywords'    => array('partners', 'suppliers', 'logos'),
        ),
        array(
            'name'        => 'erdu-cases',
            'title'       => __('ERDU Case Studies', 'erdu-wp'),
            'description' => __('Project case studies grid with filters.', 'erdu-wp'),
            'icon'        => 'portfolio',
            'keywords'    => array('cases', 'projects', 'portfolio'),
        ),
        array(
            'name'        => 'erdu-faq',
            'title'       => __('ERDU FAQ', 'erdu-wp'),
            'description' => __('Accordion-style frequently asked questions.', 'erdu-wp'),
            'icon'        => 'editor-help',
            'keywords'    => array('faq', 'questions', 'accordion'),
        ),
        array(
            'name'        => 'erdu-contact-info',
            'title'       => __('ERDU Contact Info', 'erdu-wp'),
            'description' => __('Contact information and business hours.', 'erdu-wp'),
            'icon'        => 'phone',
            'keywords'    => array('contact', 'info', 'address'),
        ),
        array(
            'name'        => 'erdu-certifications',
            'title'       => __('ERDU Certifications', 'erdu-wp'),
            'description' => __('Certification badges grid display.', 'erdu-wp'),
            'icon'        => 'awards',
            'keywords'    => array('certifications', 'badges', 'quality'),
        ),
        array(
            'name'        => 'erdu-process',
            'title'       => __('ERDU Process Steps', 'erdu-wp'),
            'description' => __('Numbered process / workflow steps.', 'erdu-wp'),
            'icon'        => 'list-view',
            'keywords'    => array('process', 'steps', 'workflow'),
        ),
        array(
            'name'        => 'erdu-product-grid',
            'title'       => __('ERDU Product Grid', 'erdu-wp'),
            'description' => __('Product series cards grid display.', 'erdu-wp'),
            'icon'        => 'products',
            'keywords'    => array('products', 'grid', 'cards'),
        ),
        array(
            'name'        => 'erdu-exhibitions',
            'title'       => __('ERDU Exhibitions', 'erdu-wp'),
            'description' => __('Upcoming exhibition cards.', 'erdu-wp'),
            'icon'        => 'calendar',
            'keywords'    => array('exhibitions', 'events', 'trade shows'),
        ),
        array(
            'name'        => 'erdu-benefits',
            'title'       => __('ERDU Benefits', 'erdu-wp'),
            'description' => __('Icon + text benefit cards grid.', 'erdu-wp'),
            'icon'        => 'star-filled',
            'keywords'    => array('benefits', 'features', 'advantages'),
        ),
        array(
            'name'        => 'erdu-testimonials',
            'title'       => __('ERDU Testimonials', 'erdu-wp'),
            'description' => __('Client testimonials with quotes and author info.', 'erdu-wp'),
            'icon'        => 'format-quote',
            'keywords'    => array('testimonials', 'quotes', 'reviews'),
        ),
        array(
            'name'        => 'erdu-newsletter',
            'title'       => __('ERDU Newsletter', 'erdu-wp'),
            'description' => __('Email subscription form with title and placeholder.', 'erdu-wp'),
            'icon'        => 'email-alt',
            'keywords'    => array('newsletter', 'subscribe', 'email'),
        ),
        array(
            'name'        => 'erdu-applications',
            'title'       => __('ERDU Applications', 'erdu-wp'),
            'description' => __('Application scenario cards with icon, name and description.', 'erdu-wp'),
            'icon'        => 'building',
            'keywords'    => array('applications', 'scenarios', 'use-cases'),
        ),
    );

    foreach ($blocks as $block) {
        acf_register_block_type(array(
            'name'            => $block['name'],
            'title'           => $block['title'],
            'description'     => $block['description'],
            'category'        => 'erdu',
            'icon'            => $block['icon'],
            'keywords'        => $block['keywords'],
            'render_callback' => 'erdu_block_render',
            'mode'            => 'preview',
            'align'           => 'full',
            'supports'        => array(
                'align'   => array('full', 'wide'),
                'mode'    => true,
                'preview' => true,
                'jsx'     => false,
            ),
            'enqueue_assets'  => function () {
                wp_enqueue_style('erdu-main', ERDU_URI . '/assets/css/main.css', array(), ERDU_VERSION);
            },
        ));
    }
}

// ==========================================
// Register block category
// ==========================================

add_filter('block_categories_all', 'erdu_block_category', 10, 2);
function erdu_block_category($categories, $post)
{
    return array_merge(
        array(array('slug' => 'erdu', 'title' => __('ERDU Components', 'erdu-wp'), 'icon'  => 'lightbulb')),
        $categories
    );
}

// ==========================================
// Universal block renderer
// ==========================================

function erdu_block_render($block, $content = '', $is_preview = false, $post_id = 0)
{
    $block_name = str_replace('acf/', '', $block['name']);
    $block_name = str_replace('erdu-', '', $block_name);

    // Build template path
    $template = ERDU_DIR . '/blocks/' . sanitize_file_name($block_name) . '.php';

    if (file_exists($template)) {
        include $template;
    } else {
        // Fallback inline render
        $render_func = 'erdu_block_render_' . str_replace('-', '_', $block_name);
        if (function_exists($render_func)) {
            call_user_func($render_func, $block, $is_preview);
        } else {
            echo '<p style="padding:20px;background:#f0f0f0;">Block template not found: ' . esc_html($block_name) . '</p>';
        }
    }
}

// ==========================================
// Register block fields (acf/init)
// ==========================================
//
// IMPORTANT — Field Key & Name Stability:
// ---------------------------------------
// ACF Blocks store field values keyed by field KEY (e.g. 'field_bh_title')
// inside the block's serialized data in post_content. If you change a
// field's 'key' or 'name' after users have saved content, ALL previously
// saved data for that field will be LOST.
//
// Rules:
//   1. NEVER change an existing field's 'key' value (e.g. 'field_bh_title')
//   2. NEVER change an existing field's 'name' value (e.g. 'title')
//   3. You may ADD new fields safely
//   4. You may ADD new 'choices' to select fields safely
//   5. If you must rename, create a NEW field and deprecate the old one
//
// Adding new blocks or new fields is always safe and will not affect
// existing content.
// ==========================================

add_action('acf/init', 'erdu_register_block_fields', 20);
function erdu_register_block_fields()
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // --- 1. Hero Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_hero',
        'title'  => __('Hero Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bh_title', 'label' => __('Title (empty = page title)', 'erdu-wp'), 'name' => 'title', 'type' => 'text'),
            array('key' => 'field_bh_subtitle', 'label' => __('Subtitle', 'erdu-wp'), 'name' => 'subtitle', 'type' => 'text'),
            array('key' => 'field_bh_bg', 'label' => __('Background Image', 'erdu-wp'), 'name' => 'background_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_bh_overlay', 'label' => __('Overlay Style', 'erdu-wp'), 'name' => 'overlay_style', 'type' => 'select', 'choices' => array('dark' => __('Dark', 'erdu-wp'), 'blue' => __('Blue', 'erdu-wp'), 'orange' => __('Orange', 'erdu-wp')), 'default_value' => 'orange'),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-hero'))),
    ));

    // --- 2. Content Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_content',
        'title'  => __('Content Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bc_content', 'label' => __('Content', 'erdu-wp'), 'name' => 'content', 'type' => 'wysiwyg', 'tabs' => 'all', 'toolbar' => 'full', 'media_upload' => 1),
            array('key' => 'field_bc_bg', 'label' => __('Background Color', 'erdu-wp'), 'name' => 'bg_color', 'type' => 'select', 'choices' => array('white' => __('White', 'erdu-wp'), 'gray' => __('Light Gray', 'erdu-wp'), 'none' => __('Transparent', 'erdu-wp')), 'default_value' => 'white'),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-content'))),
    ));

    // --- 3. Timeline Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_timeline',
        'title'  => __('Timeline Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bt_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Our Journey'),
            array(
                'key'          => 'field_bt_events',
                'label'        => __('Timeline Events', 'erdu-wp'),
                'name'         => 'events',
                'type'         => 'repeater',
                'button_label' => __('Add Event', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bte_year', 'label' => __('Year', 'erdu-wp'), 'name' => 'year', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bte_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bte_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-timeline'))),
    ));

    // --- 4. Team Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_team',
        'title'  => __('Team Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_btm_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Leadership Team'),
            array(
                'key'          => 'field_btm_members',
                'label'        => __('Team Members', 'erdu-wp'),
                'name'         => 'members',
                'type'         => 'repeater',
                'button_label' => __('Add Member', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_btmm_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_btmm_role', 'label' => __('Role', 'erdu-wp'), 'name' => 'role', 'type' => 'text'),
                    array('key' => 'field_btmm_bio', 'label' => __('Bio', 'erdu-wp'), 'name' => 'bio', 'type' => 'textarea', 'rows' => 2),
                    array('key' => 'field_btmm_photo', 'label' => __('Photo', 'erdu-wp'), 'name' => 'photo', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-team'))),
    ));

    // --- 5. Values Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_values',
        'title'  => __('Values Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bv_mission', 'label' => __('Mission Statement', 'erdu-wp'), 'name' => 'mission', 'type' => 'textarea', 'rows' => 3, 'default_value' => '"To Illuminate Global Spaces with Innovative, Reliable, and Sustainable LED Lighting Solutions."'),
            array(
                'key'          => 'field_bv_values',
                'label'        => __('Company Values', 'erdu-wp'),
                'name'         => 'values',
                'type'         => 'repeater',
                'button_label' => __('Add Value', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bvv_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bvv_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-values'))),
    ));

    // --- 6. Stats Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_stats',
        'title'  => __('Stats Block', 'erdu-wp'),
        'fields' => array(
            array(
                'key'          => 'field_bs_stats',
                'label'        => __('Statistics', 'erdu-wp'),
                'name'         => 'stats',
                'type'         => 'repeater',
                'button_label' => __('Add Stat', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bss_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'value', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bss_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-stats'))),
    ));

    // --- 7. CTA Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_cta',
        'title'  => __('CTA Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bcta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
            array('key' => 'field_bcta_button', 'label' => __('Button Text', 'erdu-wp'), 'name' => 'button_text', 'type' => 'text', 'default_value' => 'Contact Us'),
            array('key' => 'field_bcta_link', 'label' => __('Button Link', 'erdu-wp'), 'name' => 'button_link', 'type' => 'url'),
            array('key' => 'field_bcta_secondary', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'secondary_text', 'type' => 'text'),
            array('key' => 'field_bcta_secondary_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'secondary_link', 'type' => 'url'),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-cta'))),
    ));

    // --- 8. Partners Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_partners',
        'title'  => __('Partners Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bp_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Supply Chain Partners'),
            array(
                'key'          => 'field_bp_partners',
                'label'        => __('Partners', 'erdu-wp'),
                'name'         => 'partners',
                'type'         => 'repeater',
                'button_label' => __('Add Partner', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bpp_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bpp_category', 'label' => __('Category', 'erdu-wp'), 'name' => 'category', 'type' => 'text'),
                    array('key' => 'field_bpp_logo', 'label' => __('Logo', 'erdu-wp'), 'name' => 'logo', 'type' => 'image', 'return_format' => 'url'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-partners'))),
    ));

    // --- 9. Case Studies Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_cases',
        'title'  => __('Case Studies Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bc_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Case Studies'),
            array(
                'key'          => 'field_bc_cases',
                'label'        => __('Case Studies', 'erdu-wp'),
                'name'         => 'cases',
                'type'         => 'repeater',
                'button_label' => __('Add Case', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bcc_title', 'label' => __('Project Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bcc_industry', 'label' => __('Industry', 'erdu-wp'), 'name' => 'industry', 'type' => 'text'),
                    array('key' => 'field_bcc_image', 'label' => __('Image', 'erdu-wp'), 'name' => 'image', 'type' => 'image', 'return_format' => 'url'),
                    array('key' => 'field_bcc_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 3),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-cases'))),
    ));

    // --- 10. FAQ Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_faq',
        'title'  => __('FAQ Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bf_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Frequently Asked Questions'),
            array(
                'key'          => 'field_bf_items',
                'label'        => __('FAQ Items', 'erdu-wp'),
                'name'         => 'faq_items',
                'type'         => 'repeater',
                'button_label' => __('Add FAQ', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bfq_question', 'label' => __('Question', 'erdu-wp'), 'name' => 'question', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bfq_answer', 'label' => __('Answer', 'erdu-wp'), 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-faq'))),
    ));

    // --- 11. Contact Info Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_contact_info',
        'title'  => __('Contact Info Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bci_address', 'label' => __('Address', 'erdu-wp'), 'name' => 'address', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_bci_phone', 'label' => __('Phone', 'erdu-wp'), 'name' => 'phone', 'type' => 'text'),
            array('key' => 'field_bci_email', 'label' => __('Email', 'erdu-wp'), 'name' => 'email', 'type' => 'email'),
            array('key' => 'field_bci_hours', 'label' => __('Business Hours', 'erdu-wp'), 'name' => 'hours', 'type' => 'text'),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-contact-info'))),
    ));

    // --- 12. Certifications Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_certifications',
        'title'  => __('Certifications Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bcert_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Certifications'),
            array(
                'key'          => 'field_bcert_certs',
                'label'        => __('Certifications', 'erdu-wp'),
                'name'         => 'certifications',
                'type'         => 'repeater',
                'button_label' => __('Add Certificate', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bcertc_name', 'label' => __('Certificate Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bcertc_org', 'label' => __('Issuing Organization', 'erdu-wp'), 'name' => 'org', 'type' => 'text'),
                    array('key' => 'field_bcertc_valid', 'label' => __('Valid Until', 'erdu-wp'), 'name' => 'valid', 'type' => 'text'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-certifications'))),
    ));

    // --- 13. Process Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_process',
        'title'  => __('Process Steps Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bproc_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Our Process'),
            array(
                'key'          => 'field_bproc_steps',
                'label'        => __('Process Steps', 'erdu-wp'),
                'name'         => 'steps',
                'type'         => 'repeater',
                'button_label' => __('Add Step', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bprocs_title', 'label' => __('Step Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bprocs_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                    array('key' => 'field_bprocs_icon', 'label' => __('SVG Icon Path', 'erdu-wp'), 'name' => 'icon', 'type' => 'text', 'instructions' => __('Enter SVG path d attribute value', 'erdu-wp')),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-process'))),
    ));

    // --- 14. Product Grid Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_product_grid',
        'title'  => __('Product Grid Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bpg_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Our Products'),
            array(
                'key'          => 'field_bpg_products',
                'label'        => __('Products', 'erdu-wp'),
                'name'         => 'products',
                'type'         => 'repeater',
                'button_label' => __('Add Product', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bpgp_name', 'label' => __('Product Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bpgp_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 3),
                    array('key' => 'field_bpgp_image', 'label' => __('Image', 'erdu-wp'), 'name' => 'image', 'type' => 'image', 'return_format' => 'url'),
                    array('key' => 'field_bpgp_tag', 'label' => __('Tag (NEW/HOT)', 'erdu-wp'), 'name' => 'tag', 'type' => 'text'),
                    array('key' => 'field_bpgp_power', 'label' => __('Power', 'erdu-wp'), 'name' => 'power', 'type' => 'text'),
                    array('key' => 'field_bpgp_angle', 'label' => __('Beam Angle', 'erdu-wp'), 'name' => 'angle', 'type' => 'text'),
                    array('key' => 'field_bpgp_cri', 'label' => __('CRI', 'erdu-wp'), 'name' => 'cri', 'type' => 'text'),
                    array('key' => 'field_bpgp_cct', 'label' => __('CCT', 'erdu-wp'), 'name' => 'cct', 'type' => 'text'),
                    array('key' => 'field_bpgp_link', 'label' => __('Product Link', 'erdu-wp'), 'name' => 'link', 'type' => 'url'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-product-grid'))),
    ));

    // --- 15. Exhibitions Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_exhibitions',
        'title'  => __('Exhibitions Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bex_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Upcoming Exhibitions'),
            array(
                'key'          => 'field_bex_events',
                'label'        => __('Exhibitions', 'erdu-wp'),
                'name'         => 'exhibitions',
                'type'         => 'repeater',
                'button_label' => __('Add Exhibition', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bexe_name', 'label' => __('Exhibition Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bexe_date', 'label' => __('Date', 'erdu-wp'), 'name' => 'date', 'type' => 'text'),
                    array('key' => 'field_bexe_booth', 'label' => __('Booth Number', 'erdu-wp'), 'name' => 'booth', 'type' => 'text'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-exhibitions'))),
    ));

    // --- 16. Benefits Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_benefits',
        'title'  => __('Benefits Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bben_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Partner Benefits'),
            array(
                'key'          => 'field_bben_items',
                'label'        => __('Benefits', 'erdu-wp'),
                'name'         => 'benefits',
                'type'         => 'repeater',
                'button_label' => __('Add Benefit', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bbeni_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bbeni_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-benefits'))),
    ));

    // --- 17. Testimonials Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_testimonials',
        'title'  => __('Testimonials Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_btsti_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'What Our Clients Say'),
            array('key' => 'field_btsti_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            array(
                'key'          => 'field_btsti_items',
                'label'        => __('Testimonials', 'erdu-wp'),
                'name'         => 'testimonials',
                'type'         => 'repeater',
                'button_label' => __('Add Testimonial', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_btstiq_quote', 'label' => __('Quote', 'erdu-wp'), 'name' => 'quote', 'type' => 'textarea', 'rows' => 4, 'required' => 1),
                    array('key' => 'field_btstia_author', 'label' => __('Author Name', 'erdu-wp'), 'name' => 'author', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_btstir_role', 'label' => __('Author Role', 'erdu-wp'), 'name' => 'role', 'type' => 'text'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-testimonials'))),
    ));

    // --- 18. Newsletter Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_newsletter',
        'title'  => __('Newsletter Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bnl_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Stay Updated'),
            array('key' => 'field_bnl_placeholder', 'label' => __('Email Placeholder', 'erdu-wp'), 'name' => 'placeholder', 'type' => 'text', 'default_value' => 'Enter your email'),
            array('key' => 'field_bnl_button', 'label' => __('Button Text', 'erdu-wp'), 'name' => 'button_text', 'type' => 'text', 'default_value' => 'Subscribe'),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-newsletter'))),
    ));

    // --- 19. Applications Block Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_block_applications',
        'title'  => __('Applications Block', 'erdu-wp'),
        'fields' => array(
            array('key' => 'field_bapp_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'default_value' => 'Applications'),
            array('key' => 'field_bapp_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            array(
                'key'          => 'field_bapp_items',
                'label'        => __('Applications', 'erdu-wp'),
                'name'         => 'applications',
                'type'         => 'repeater',
                'button_label' => __('Add Application', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_bappn_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_bappd_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                    array('key' => 'field_bappi_icon', 'label' => __('Icon (emoji or text)', 'erdu-wp'), 'name' => 'icon', 'type' => 'text'),
                    array('key' => 'field_bappl_link', 'label' => __('Link', 'erdu-wp'), 'name' => 'link', 'type' => 'url'),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/erdu-applications'))),
    ));
}
