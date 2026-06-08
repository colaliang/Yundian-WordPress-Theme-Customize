<?php
/**
 * Deep SEO, GEO & AEO Optimization Module
 * 
 * Provides built-in Schema.org (JSON-LD), AI Answer Engine Optimization (AEO), 
 * and Geography/Entity Optimization (GEO) features.
 * 
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if a major SEO plugin is active.
 * If true, we skip generating basic meta tags to avoid conflicts,
 * but we STILL generate our advanced AEO schema and AI summary blocks.
 */
function erdu_is_seo_plugin_active() {
    return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION');
}

/**
 * 0. Global Default TDK Map for ERDU Lighting
 * Pre-configured Title, Description, and Keywords tailored for 
 * LED Commercial Lighting OEM/ODM Manufacturer
 */
function erdu_get_default_seo_data($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    
    $data = array(
        'title' => '',
        'desc' => '',
        'keywords' => 'Commercial Lighting, 48V Magnetic Track Light, Zhongshan Lighting Manufacturer, OEM LED Spotlights, ODM Downlights'
    );
    
    if (is_front_page()) {
        $data['title'] = 'Professional 48V Magnetic Track Light Manufacturer | OEM/ODM LED Lighting';
        $data['desc'] = 'ERDU Lighting is a leading China manufacturer of 48V magnetic track lights, LED spotlights, and downlights. Offering OEM/ODM commercial lighting solutions globally.';
        $data['keywords'] = '48V magnetic track light, LED commercial lighting, OEM LED manufacturer, ODM lighting factory, LED spotlights, downlights, ERDU Lighting';
    } elseif (is_page('about')) {
        $data['title'] = 'About ERDU | China LED Commercial Lighting Factory & Manufacturer';
        $data['desc'] = 'Founded in 2009, ERDU Lighting specializes in R&D and manufacturing of commercial LED lighting. ISO9001 certified factory providing custom OEM/ODM services.';
        $data['keywords'] = 'China LED factory, commercial lighting manufacturer, lighting OEM partner, Zhongshan lighting factory, LED ODM services';
    } elseif (is_page('products') || is_page_template('page-products.php')) {
        $data['title'] = 'Wholesale 48V Magnetic Track Lights & Commercial LED Spotlights';
        $data['desc'] = 'Browse our premium 48V magnetic track lighting systems, architectural spotlights, and downlights. CE/RoHS certified, factory direct wholesale.';
        $data['keywords'] = 'wholesale magnetic track lights, commercial LED downlights, architectural spotlights wholesale, LED lighting products factory';
    } elseif (is_page('solutions') || is_page_template('page-solutions.php')) {
        $data['title'] = 'Custom LED Lighting Solutions | Retail, Office & Hospitality';
        $data['desc'] = 'Tailored commercial lighting solutions for retail stores, hotels, and offices. Expertise in magnetic track systems and no-main-light designs.';
        $data['keywords'] = 'custom LED lighting, retail lighting solutions, hospitality LED lighting, office lighting design, no-main-light';
    } elseif (is_page('cases') || is_page_template('page-cases.php')) {
        $data['title'] = 'LED Lighting Projects & Case Studies | ERDU Lighting';
        $data['desc'] = 'View our successful commercial lighting projects worldwide. See how our magnetic track lights and downlights transform retail and hospitality spaces.';
        $data['keywords'] = 'commercial lighting projects, LED lighting case studies, track lighting applications, hotel lighting projects';
    } elseif (is_page('contact') || is_page_template('page-contact.php')) {
        $data['title'] = 'Contact ERDU Lighting | Get a Quote for OEM/ODM LED Manufacturing';
        $data['desc'] = 'Contact our expert team for wholesale inquiries, custom OEM/ODM lighting manufacturing, and project quotes. Based in Zhongshan, China.';
        $data['keywords'] = 'contact lighting manufacturer, LED wholesale inquiry, OEM lighting quote, China lighting factory contact';
    } elseif (is_page('quality') || is_page_template('page-quality.php')) {
        $data['title'] = 'Quality Assurance & Certifications | CE, RoHS, ISO9001 LED Factory';
        $data['desc'] = 'ERDU strictly follows ISO9001 standards. Our LED track lights and spotlights are CE, RoHS, and ETL certified for global markets.';
        $data['keywords'] = 'LED quality control, CE certified track lights, RoHS LED manufacturer, ISO9001 lighting factory';
    } elseif (is_page('distributor') || is_page_template('page-distributor.php')) {
        $data['title'] = 'Become a Lighting Distributor | Global LED Wholesale Partner';
        $data['desc'] = 'Join ERDU\'s global network. Enjoy factory-direct pricing, marketing support, and exclusive territories for our magnetic track lighting systems.';
        $data['keywords'] = 'lighting distributor program, LED wholesale partner, magnetic track light distributor, B2B lighting supplier';
    }
    
    return $data;
}

/**
 * Hook into document title to override WP default title
 */
add_filter('pre_get_document_title', 'erdu_custom_seo_title', 10);
function erdu_custom_seo_title($title) {
    if (erdu_is_seo_plugin_active()) {
        return $title;
    }
    $seo_data = erdu_get_default_seo_data();
    if (!empty($seo_data['title'])) {
        return $seo_data['title'];
    }
    return $title;
}

/**
 * 1. Register AEO (AI Engine Optimization) Fields
 * Adds "Key Takeaways" and "AI Summary" to Posts, Pages, and Cases.
 */
add_action('acf/init', 'erdu_register_aeo_fields');
function erdu_register_aeo_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_aeo_optimization',
            'title' => __('AEO & AI Engine Optimization', 'erdu-wp'),
            'fields' => array(
                array(
                    'key' => 'field_aeo_summary',
                    'label' => __('AI Summary / TL;DR', 'erdu-wp'),
                    'name' => 'aeo_summary',
                    'type' => 'textarea',
                    'instructions' => __('A concise, factual 1-2 paragraph summary designed for AI answer engines (ChatGPT, Perplexity, etc.) to extract easily.', 'erdu-wp'),
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_aeo_takeaways',
                    'label' => __('Key Takeaways', 'erdu-wp'),
                    'name' => 'aeo_takeaways',
                    'type' => 'repeater',
                    'instructions' => __('3-5 bullet points covering the most important facts, entities, and outcomes.', 'erdu-wp'),
                    'button_label' => __('Add Takeaway', 'erdu-wp'),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_aeo_takeaway_text',
                            'label' => __('Takeaway', 'erdu-wp'),
                            'name' => 'text',
                            'type' => 'text',
                            'required' => 1,
                        ),
                    ),
                ),
                array(
                    'key' => 'field_geo_entities',
                    'label' => __('Target GEO Entities (Regions/Industries)', 'erdu-wp'),
                    'name' => 'geo_entities',
                    'type' => 'text',
                    'instructions' => __('Comma-separated list of target regions, industries, or specific entities (e.g., "Commercial Lighting, Dubai, Retail").', 'erdu-wp'),
                ),
            ),
            'location' => array(
                array(array('param' => 'post_type', 'operator' => '==', 'value' => 'post')),
                array(array('param' => 'post_type', 'operator' => '==', 'value' => 'page')),
                array(array('param' => 'post_type', 'operator' => '==', 'value' => 'erdu_case')),
            ),
            'position' => 'normal',
            'style' => 'default',
            'menu_order' => 10,
        ));
    }
}

/**
 * 2. Generate Schema.org JSON-LD
 */
add_action('wp_head', 'erdu_generate_schema_markup', 99);
function erdu_generate_schema_markup() {
    $schema = array();
    $post_id = get_the_ID();
    
    // Get Pre-configured SEO Data
    $seo_data = erdu_get_default_seo_data($post_id);
    
    // Default GEO Entity (fallback if not set per-page)
    $default_geo_entities = !empty($seo_data['keywords']) ? $seo_data['keywords'] : "Commercial Lighting, 48V Magnetic Track Light, Zhongshan Lighting Manufacturer";
    $page_geo_entities = function_exists('get_field') ? get_field('geo_entities', $post_id) : '';
    $geo_entities = $page_geo_entities ? $page_geo_entities : $default_geo_entities;
    
    // Use pre-configured description if available
    $default_description = !empty($seo_data['desc']) ? $seo_data['desc'] : get_bloginfo('description');
    
    // 2.1 Organization & WebSite (Always output on front page)
    if (is_front_page()) {
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'ERDU Lighting',
            'url' => home_url('/'),
            'logo' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
            'description' => $default_description,
            'keywords' => $geo_entities,
            'contactPoint' => array(
                '@type' => 'ContactPoint',
                'telephone' => '+86-760-22380830',
                'contactType' => 'customer service',
                'areaServed' => 'Worldwide',
                'availableLanguage' => array('English', 'Chinese')
            ),
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => '6th Floor, JinYe Building, Tongyi Industrial District',
                'addressLocality' => 'Guzhen, Zhongshan',
                'addressRegion' => 'Guangdong',
                'addressCountry' => 'CN'
            ),
            'sameAs' => array(
                'https://www.facebook.com/erduled',
                'https://www.linkedin.com/company/erduled',
                'https://www.youtube.com/@erduled'
            )
        );
        
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'keywords' => $geo_entities,
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            )
        );
    }
    
    // 2.2 Article / NewsArticle Schema
    if (is_single() && (is_singular('post') || is_singular('erdu_case'))) {
        $post_id = get_the_ID();
        $is_news = has_category('news') || has_category('announcement');
        
        $article_schema = array(
            '@context' => 'https://schema.org',
            '@type' => $is_news ? 'NewsArticle' : 'Article',
            'headline' => get_the_title(),
            'image' => array(get_the_post_thumbnail_url($post_id, 'full')),
            'datePublished' => get_the_time('c'),
            'dateModified' => get_the_modified_time('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => 'ERDU Lighting',
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : ''
                )
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            )
        );

        // Add AEO Summary to schema if exists
        if (function_exists('get_field')) {
            $summary = get_field('aeo_summary', $post_id);
            if ($summary) {
                $article_schema['abstract'] = wp_strip_all_tags($summary);
            }
            
            $geo_entities = get_field('geo_entities', $post_id);
            if ($geo_entities) {
                $article_schema['keywords'] = wp_strip_all_tags($geo_entities);
                $article_schema['about'] = array(
                    '@type' => 'Thing',
                    'name' => wp_strip_all_tags($geo_entities)
                );
            }
        }
        
        $schema[] = $article_schema;
    }
    
    // 2.3 FAQPage Schema (Home & Contact Page usually have FAQs)
    if (is_page()) {
        $post_id = get_the_ID();
        $faq_items = false;
        
        if (function_exists('get_field')) {
            if (get_page_template_slug($post_id) === 'front-page.php') {
                $faq_items = get_field('home_faq_items', $post_id);
            } elseif (get_page_template_slug($post_id) === 'page-contact.php') {
                $faq_items = get_field('contact_faq', $post_id);
            }
        }
        
        if (!empty($faq_items) && is_array($faq_items)) {
            $faq_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array()
            );
            
            foreach ($faq_items as $item) {
                $faq_schema['mainEntity'][] = array(
                    '@type' => 'Question',
                    'name' => wp_strip_all_tags($item['question']),
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($item['answer'])
                    )
                );
            }
            $schema[] = $faq_schema;
        }
        
        // CollectionPage & ItemList Schema for "Archive" Pages
        $template = get_page_template_slug($post_id);
        if (in_array($template, array('page-news.php', 'page-blog.php', 'page-cases.php', 'page-products.php'))) {
            $schema[] = array(
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => get_the_title(),
                'url' => get_permalink(),
                'keywords' => $geo_entities
            );
            
            // Generate basic ItemList for SEO
            global $wp_query;
            $items = array();
            
            // Determine post type based on template
            $cpt = 'post';
            if ($template === 'page-cases.php') $cpt = 'erdu_case';
            if ($template === 'page-news.php') $cpt = 'erdu_news';
            if ($template === 'page-products.php') $cpt = 'product'; // WooCommerce
            
            $archive_query = new WP_Query(array(
                'post_type' => $cpt,
                'posts_per_page' => 10,
                'post_status' => 'publish'
            ));
            
            if ($archive_query->have_posts()) {
                $position = 1;
                while ($archive_query->have_posts()) {
                    $archive_query->the_post();
                    $items[] = array(
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'url' => get_permalink(),
                        'name' => get_the_title()
                    );
                }
                wp_reset_postdata();
                
                $schema[] = array(
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'itemListElement' => $items
                );
            }
        }
    }

    // 2.4 BreadcrumbList Schema
    if (!is_front_page()) {
        $breadcrumbs = array(
            array(
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => home_url('/')
            )
        );
        
        $pos = 2;
        if (is_page()) {
            global $post;
            if ($post->post_parent) {
                $parent = get_post($post->post_parent);
                $breadcrumbs[] = array(
                    '@type' => 'ListItem',
                    'position' => $pos++,
                    'name' => get_the_title($parent->ID),
                    'item' => get_permalink($parent->ID)
                );
            }
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $pos,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        } elseif (is_single()) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => 'Blog',
                'item' => get_permalink(get_option('page_for_posts'))
            );
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $pos,
                'name' => get_the_title(),
                'item' => get_permalink()
            );
        }
        
        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs
        );
    }
    
    // Output all schemas
    if (!empty($schema)) {
        echo "\n<!-- ERDU AEO & GEO Schema.org -->\n";
        foreach ($schema as $s) {
            echo '<script type="application/ld+json">' . wp_json_encode($s, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
        }
        echo "<!-- End ERDU Schema.org -->\n";
    }
}

/**
 * 3. Output Basic SEO Meta Tags (Only if no SEO plugin is active)
 */
add_action('wp_head', 'erdu_generate_meta_tags', 1);
function erdu_generate_meta_tags() {
    if (erdu_is_seo_plugin_active()) {
        return;
    }
    
    $title = get_bloginfo('name');
    $desc = get_bloginfo('description');
    $url = home_url($_SERVER['REQUEST_URI']);
    $image = get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '';
    
    $post_id = get_the_ID();
    $seo_data = erdu_get_default_seo_data($post_id);
    
    if (!empty($seo_data['title'])) {
        $title = $seo_data['title'];
    }
    if (!empty($seo_data['desc'])) {
        $desc = $seo_data['desc'];
    }
    
    $default_geo_entities = !empty($seo_data['keywords']) ? $seo_data['keywords'] : "Commercial Lighting, 48V Magnetic Track Light, Zhongshan Lighting Manufacturer";
    $page_geo_entities = function_exists('get_field') ? get_field('geo_entities', $post_id) : '';
    $geo_entities = $page_geo_entities ? $page_geo_entities : $default_geo_entities;
    
    if (is_singular()) {
        // If it's a generic single post/page and no custom SEO title is defined, fallback to post title
        if (empty($seo_data['title'])) {
            $title = get_the_title() . ' - ' . get_bloginfo('name');
        }
        
        if (function_exists('get_field')) {
            $aeo_summary = get_field('aeo_summary', $post_id);
            if (!empty($aeo_summary)) {
                $desc = wp_trim_words($aeo_summary, 30);
            } elseif (empty($seo_data['desc'])) {
                $desc = wp_trim_words(get_post_field('post_content', $post_id), 30);
            }
        }
        
        if (has_post_thumbnail()) {
            $image = get_the_post_thumbnail_url($post_id, 'full');
        }
    }
    
    echo "\n<!-- ERDU Basic SEO & OpenGraph -->\n";
    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta name="keywords" content="' . esc_attr($geo_entities) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
    
    // Open Graph
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '">' . "\n";
    if ($image) echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    
    // Twitter
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    if ($image) echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    echo "<!-- End ERDU SEO -->\n";
}

/**
 * 4. AEO Content Injection
 * Automatically prepends the "Key Takeaways" & "AI Summary" to single post content.
 * This ensures AI Answer Engines (and users) get the TL;DR right away.
 */
add_filter('the_content', 'erdu_inject_aeo_summary_block');
function erdu_inject_aeo_summary_block($content, $force = false) {
    if (!$force) {
        if (!is_singular() || !in_the_loop() || !is_main_query()) {
            return $content;
        }
    }
    
    if (!function_exists('get_field')) {
        return $content;
    }
    
    $post_id = get_the_ID();
    $summary = get_field('aeo_summary', $post_id);
    $takeaways = get_field('aeo_takeaways', $post_id);
    
    if (empty($summary) && empty($takeaways)) {
        // Automatically inject pre-configured AEO Summary & Takeaways for specific pages
        $seo_data = erdu_get_default_seo_data($post_id);
        
        if (is_front_page()) {
            $summary = "ERDU Lighting is a premier manufacturer of 48V magnetic track lights and commercial LED solutions in China. With over a decade of OEM/ODM experience, we deliver high-quality, certified lighting systems to global distributors and projects.";
            $takeaways = array(
                array('text' => 'Direct manufacturer with 6,300m² facility in Zhongshan, China.'),
                array('text' => 'Specializing in 48V magnetic track systems, downlights, and spotlights.'),
                array('text' => 'Comprehensive OEM/ODM services for commercial lighting projects.'),
                array('text' => 'ISO9001 certified with CE, RoHS, and ETL product approvals.')
            );
        } elseif (is_page('about')) {
            $summary = "Founded in 2009, ERDU Lighting has grown into a trusted B2B partner for commercial lighting. Our ISO9001 factory ensures strict quality control from raw materials to final assembly, supporting global brands with reliable LED manufacturing.";
            $takeaways = array(
                array('text' => 'Established in 2009, over 15 years of LED manufacturing expertise.'),
                array('text' => 'Strict quality control process (IQC, IPQC, Aging, OQC).'),
                array('text' => 'Exporting to over 20 countries worldwide.'),
                array('text' => 'Strategic partnerships with top component suppliers like Sanan and OSRAM.')
            );
        } elseif (is_page('quality') || is_page_template('page-quality.php')) {
            $summary = "Quality is the cornerstone of ERDU Lighting. We maintain a rigorous quality assurance system, subjecting every product to a 48-hour aging test and strict optical verifications to meet international commercial standards.";
            $takeaways = array(
                array('text' => '100% of products undergo a minimum 48-hour aging test.'),
                array('text' => 'Products certified for global markets: CE, RoHS, ERP, ETL, SAA.'),
                array('text' => 'High color consistency (SDCM ≤ 3) and excellent lifespan (L70 > 50,000 hrs).'),
                array('text' => 'Multi-stage inspection process from incoming components to final packaging.')
            );
        } elseif (is_page('distributor') || is_page_template('page-distributor.php')) {
            $summary = "ERDU's Global Distributor Program is designed for B2B lighting wholesalers and project contractors. We offer protected territories, factory-direct pricing, and comprehensive technical support to ensure our partners' success.";
            $takeaways = array(
                array('text' => 'Factory-direct pricing to maximize distributor margins.'),
                array('text' => 'Exclusive territory protection to prevent market conflicts.'),
                array('text' => 'Full marketing and technical training support provided.'),
                array('text' => 'Standard 3-year warranty on all commercial lighting products.')
            );
        }
        
        // If still empty after fallback checks, do nothing
        if (empty($summary) && empty($takeaways)) {
            return $content;
        }
    }
    
    $aeo_html = '<div class="erdu-aeo-block bg-gray-50 border-l-4 border-primary p-6 my-8 rounded-r-lg shadow-sm" aria-label="Key Takeaways">';
    
    if (!empty($summary)) {
        $aeo_html .= '<div class="aeo-summary text-lg font-medium text-gray-800 mb-4">' . wp_kses_post($summary) . '</div>';
    }
    
    if (!empty($takeaways) && is_array($takeaways)) {
        $aeo_html .= '<h3 class="text-md font-bold text-gray-900 mb-3">' . esc_html__('Key Takeaways:', 'erdu-wp') . '</h3>';
        $aeo_html .= '<ul class="aeo-takeaways list-disc pl-5 space-y-2 text-gray-700">';
        foreach ($takeaways as $t) {
            $aeo_html .= '<li>' . esc_html($t['text']) . '</li>';
        }
        $aeo_html .= '</ul>';
    }
    
    $aeo_html .= '</div>';
    
    // If $force is true and $content is empty, wrap it in a container
    if ($force && empty($content)) {
        return '<div class="erdu-container">' . $aeo_html . '</div>';
    }
    
    return $aeo_html . $content;
}
