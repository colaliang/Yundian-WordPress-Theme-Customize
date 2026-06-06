<?php
/**
 * Front Page Template
 *
 * @package ERDU_Lighting
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ====== HERO ======
        $hero_title    = erdu_page_field('home_hero_title', __('Professional 48V Magnetic Track Lights', 'erdu-wp'));
        $hero_subtitle = erdu_page_field('home_hero_subtitle', __('Illuminate Your Space with ERDU — Trusted by 20+ Countries Since 2009', 'erdu-wp'));
        $hero_bg       = erdu_page_field('home_hero_bg', 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1200');
        $hero_btn      = erdu_page_field('home_hero_btn', __('Explore Products', 'erdu-wp'));
        $hero_btn_link = erdu_page_field('home_hero_btn_link', erdu_get_page_url('products'));
        $hero_btn2     = erdu_page_field('home_hero_btn2', __('Contact Us', 'erdu-wp'));
        $hero_btn2_link = erdu_page_field('home_hero_btn2_link', erdu_get_page_url('contact'));

        // Hero Video
        $hero_video_enabled = erdu_page_field('home_hero_video_enabled', false);
        $hero_video         = erdu_page_field('home_hero_video', '');
        $hero_video_poster  = erdu_page_field('home_hero_video_poster', $hero_bg);

        // ====== STATS ======
        $stats = erdu_page_field('home_stats', array(
            array('number' => '2009', 'label' => __('Founded', 'erdu-wp')),
            array('number' => '6300', 'label' => __('m² Factory', 'erdu-wp')),
            array('number' => '100+', 'label' => __('Employees', 'erdu-wp')),
            array('number' => '20+',  'label' => __('Countries', 'erdu-wp')),
            array('number' => '8',    'label' => __('Categories', 'erdu-wp')),
            array('number' => '15+',  'label' => __('Partners', 'erdu-wp')),
        ));

        // ====== ABOUT ======
        $about_title     = erdu_page_field('home_about_title', __('About ERDU Lighting', 'erdu-wp'));
        $about_highlight = erdu_page_field('home_about_highlight', __('ERDU Lighting: Your Reliable 48V Magnetic Track Light Manufacturer in China', 'erdu-wp'));
        $about_content   = erdu_page_field('home_about_content', '');
        $about_image     = erdu_page_field('home_about_image', 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800');
        $about_link      = erdu_page_field('home_about_link', erdu_get_page_url('about'));
        $about_info      = erdu_page_field('home_about_info', array(
            array('label' => __('Founded:', 'erdu-wp'),   'value' => '2009'),
            array('label' => __('Location:', 'erdu-wp'),  'value' => __('Zhongshan, Guzhen', 'erdu-wp')),
            array('label' => __('Area:', 'erdu-wp'),      'value' => '6300m²'),
            array('label' => __('Employees:', 'erdu-wp'), 'value' => '100+'),
            array('label' => __('Key Partners:', 'erdu-wp'), 'value' => 'Sanan, Aishi'),
            array('label' => __('Export:', 'erdu-wp'),    'value' => __('20+ Countries', 'erdu-wp')),
        ));

        // ====== PRODUCTS ======
        $products_title = erdu_page_field('home_products_title', __('Our Product Series', 'erdu-wp'));
        $products_desc  = erdu_page_field('home_products_desc', __('Professional LED lighting for commercial, residential and industrial applications', 'erdu-wp'));
        $products_count = erdu_page_field('home_products_count', 4);

        // ====== APPLICATIONS ======
        $apps_title = erdu_page_field('home_apps_title', __('Applications', 'erdu-wp'));
        $apps_desc  = erdu_page_field('home_apps_desc', __('Tailored lighting solutions for every space', 'erdu-wp'));
        $apps       = erdu_page_field('home_apps', array(
            array('name' => __('Retail Store', 'erdu-wp'),  'description' => __('Highlight merchandise with adjustable spotlights', 'erdu-wp'), 'icon' => '🛍️'),
            array('name' => __('Hotel Lobby', 'erdu-wp'),   'description' => __('Create elegant ambiance with modular lighting', 'erdu-wp'), 'icon' => '🏨'),
            array('name' => __('Office Space', 'erdu-wp'),  'description' => __('Boost productivity with glare-free illumination', 'erdu-wp'), 'icon' => '🏢'),
            array('name' => __('Residential Living', 'erdu-wp'), 'description' => __('Flexible no-main-light design for modern homes', 'erdu-wp'), 'icon' => '🏠'),
        ));

        // ====== CTA ======
        $cta_title      = erdu_page_field('home_cta_title', __('Ready to Upgrade Your Lighting Project?', 'erdu-wp'));
        $cta_btn        = erdu_page_field('home_cta_btn', __('Request a Quote', 'erdu-wp'));
        $cta_btn_link   = erdu_page_field('home_cta_btn_link', erdu_get_page_url('contact'));
        $cta_btn2       = erdu_page_field('home_cta_btn2', __('Download Catalog', 'erdu-wp'));
        $cta_btn2_link  = erdu_page_field('home_cta_btn2_link', erdu_get_page_url('about'));

        // ====== TESTIMONIALS ======
        $testi_title = erdu_page_field('home_testi_title', __('What Our Clients Say', 'erdu-wp'));
        $testi_desc  = erdu_page_field('home_testi_desc', __('Trusted by lighting professionals worldwide', 'erdu-wp'));
        $testimonials = erdu_page_field('home_testimonials', array(
            array('quote' => "ERDU's 48V magnetic track lights transformed our hotel lobby project. The modular design made installation incredibly efficient, and the CRI90+ quality exceeded client expectations.", 'author' => 'David Chen', 'role' => 'Lighting Designer, Luxe Interiors — Singapore'),
        ));

        // ====== EXHIBITIONS ======
        $expo_title   = erdu_page_field('home_expo_title', __('Upcoming Exhibitions', 'erdu-wp'));
        $expo_desc    = erdu_page_field('home_expo_desc', __('Meet us at leading lighting trade shows', 'erdu-wp'));
        $expo_source  = erdu_page_field('home_expo_source', 'custom');
        $expo_count   = erdu_page_field('home_expo_count', 3);
        $expo_custom  = erdu_page_field('home_expo_custom', array(
            array('name' => 'Guangzhou International Lighting Exhibition', 'date' => 'Jun 2026', 'location' => 'Guangzhou, China', 'booth' => 'Hall 10.2, B18'),
            array('name' => 'Hong Kong Lighting Fair', 'date' => 'Oct 2026', 'location' => 'Hong Kong', 'booth' => '3C-E18'),
            array('name' => 'Guzhen Lighting Exhibition', 'date' => 'Mar 2026', 'location' => 'Zhongshan, China', 'booth' => 'A18'),
        ));

        // ====== PARTNERS ======
        $partners_title = erdu_page_field('home_partners_title', __('Trusted by Industry Leaders', 'erdu-wp'));
        $partners       = erdu_page_field('home_partners', array(
            array('name' => 'Sanan'), array('name' => 'Aishi'), array('name' => 'Samsung'),
            array('name' => 'Lifud'), array('name' => 'OSRAM'), array('name' => 'CREE'),
            array('name' => 'PHILIPS'), array('name' => 'tuya'),
        ));

        // ====== FAQ ======
        $faq_title = erdu_page_field('home_faq_title', __('Frequently Asked Questions', 'erdu-wp'));
        $faq_items = erdu_page_field('home_faq_items', array(
            array('question' => __('What is 48V magnetic track light?', 'erdu-wp'), 'answer' => __('48V magnetic track lights are low-voltage lighting fixtures that attach magnetically to a track rail, allowing easy repositioning without tools. They operate at a safe 48V DC voltage and offer flexible lighting arrangements for commercial and residential spaces.', 'erdu-wp')),
            array('question' => __('How to install ERDU magnetic track system?', 'erdu-wp'), 'answer' => __("ERDU's magnetic track system features tool-free installation. Simply mount the track rail to the ceiling, then magnetically attach the light fixtures. Each fixture can be repositioned, removed, or swapped instantly without an electrician.", 'erdu-wp')),
            array('question' => __('What certifications do ERDU products have?', 'erdu-wp'), 'answer' => __('All ERDU products are CE, RoHS, and ERP certified. We also hold ISO9001:2015 quality management certification. Specific products have ETL/cETL certification for North American markets.', 'erdu-wp')),
        ));

        // ====== NEWSLETTER ======
        $news_title       = erdu_page_field('home_news_title', __('Stay Updated', 'erdu-wp'));
        $news_placeholder = erdu_page_field('home_news_placeholder', __('Enter your email', 'erdu-wp'));
        $news_button      = erdu_page_field('home_news_button', __('Subscribe', 'erdu-wp'));
        ?>

        <!-- ====== HERO BANNER ====== -->
        <section class="relative h-[500px] md:h-[600px] lg:h-[700px] overflow-hidden erdu-bg-secondary">

            <?php if ($hero_video_enabled && $hero_video) : ?>
                <!-- Video Background -->
                <video
                    class="absolute inset-0 w-full h-full object-cover"
                    src="<?php echo esc_url($hero_video); ?>"
                    poster="<?php echo esc_url($hero_video_poster); ?>"
                    autoplay muted loop playsinline
                    preload="auto"
                ></video>
                <!-- Dark overlay for text readability -->
                <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.55);"></div>
            <?php else : ?>
                <!-- Image Background -->
                <div class="absolute inset-0 opacity-30" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <?php endif; ?>

            <div class="relative erdu-container h-full flex items-center">
                <div class="max-w-2xl">
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight"><?php echo esc_html($hero_title); ?></h1>
                    <p class="text-lg md:text-xl text-orange-100 mb-8"><?php echo esc_html($hero_subtitle); ?></p>
                    <div class="flex flex-wrap gap-4">
                        <?php if ($hero_btn && $hero_btn_link) : ?>
                            <a href="<?php echo esc_url($hero_btn_link); ?>" class="erdu-btn erdu-btn-primary">
                                <?php echo esc_html($hero_btn); ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($hero_btn2 && $hero_btn2_link) : ?>
                            <a href="<?php echo esc_url($hero_btn2_link); ?>" class="erdu-btn erdu-btn-outline"><?php echo esc_html($hero_btn2); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- ====== TRUST STATS ====== -->
        <section class="erdu-section bg-white">
            <div class="erdu-container">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <?php foreach ($stats as $stat) : ?>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold erdu-text-primary"><?php echo esc_html($stat['number']); ?></div>
                            <div class="text-sm text-gray-500 mt-1"><?php echo esc_html($stat['label']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ====== ABOUT INTRO ====== -->
        <section class="erdu-section bg-gray-50">
            <div class="erdu-container">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="erdu-h2 mb-4"><?php echo esc_html($about_title); ?></h2>
                        <?php if ($about_highlight) : ?>
                            <div class="border-l-4 p-4 mb-4 rounded-r-md bg-orange-50 border-orange-500">
                                <p class="font-medium erdu-text-primary"><?php echo esc_html($about_highlight); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($about_content) : ?>
                            <div class="prose max-w-none mb-4"><?php echo wp_kses_post($about_content); ?></div>
                        <?php else : ?>
                            <p class="text-gray-600 mb-4 leading-relaxed"><?php _e('Zhongshan Erdu Lighting Technology Co., Ltd. is a professional manufacturer specializing in developing, designing, producing and selling all kinds of LED products. Established in 2009, located in Guzhen — the lighting capital of China.', 'erdu-wp'); ?></p>
                        <?php endif; ?>
                        <div class="grid grid-cols-2 gap-3 text-sm mb-6">
                            <?php foreach ($about_info as $info) : ?>
                                <div class="bg-white p-3 rounded-md shadow-sm"><span class="text-gray-500"><?php echo esc_html($info['label']); ?></span> <span class="font-medium"><?php echo esc_html($info['value']); ?></span></div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($about_link) : ?>
                            <a href="<?php echo esc_url($about_link); ?>" class="inline-flex items-center gap-1 font-medium hover:underline erdu-text-primary">
                                <?php _e('Learn More', 'erdu-wp'); ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr($about_title); ?>" class="w-full h-[400px] object-cover">
                    </div>
                </div>
            </div>
        </section>

        <!-- ====== PRODUCT SERIES ====== -->
        <section class="erdu-section bg-white">
            <div class="erdu-container">
                <div class="text-center mb-10">
                    <h2 class="erdu-h2"><?php echo esc_html($products_title); ?></h2>
                    <p class="text-gray-500 mt-2"><?php echo esc_html($products_desc); ?></p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    $product_items = array();

                    // Load from WooCommerce product categories
                    if (class_exists('WooCommerce')) {
                        $wc_cats = get_terms(array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'parent'     => 0,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'number'     => intval($products_count),
                        ));
                        if (!empty($wc_cats) && !is_wp_error($wc_cats)) {
                            foreach ($wc_cats as $cat) {
                                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                                $cat_image    = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                                $product_items[] = array(
                                    'name' => $cat->name,
                                    'desc' => $cat->description ?: '',
                                    'img'  => $cat_image ?: 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=400',
                                    'tag'  => '',
                                    'link' => get_term_link($cat),
                                );
                            }
                        }
                    }

                    // Fallback demo data
                    if (empty($product_items)) {
                        $product_items = array(
                            array('name' => '48V Magnetic Track Light', 'desc' => 'Adjustable spotlight with Samsung LED chips', 'tag' => 'HOT',  'img' => 'https://images.unsplash.com/photo-1540932296774-3ed6d23f9b58?w=400', 'link' => erdu_get_page_url('products')),
                            array('name' => '48V Magnetic Flood Light', 'desc' => 'Wide beam angle for general illumination', 'tag' => '',     'img' => 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=400', 'link' => erdu_get_page_url('products')),
                            array('name' => '48V Magnetic Pendant Light', 'desc' => 'Elegant hanging solution for high ceilings', 'tag' => 'NEW', 'img' => 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=400', 'link' => erdu_get_page_url('products')),
                            array('name' => '48V Magnetic Folding Light', 'desc' => 'Compact design for accent lighting', 'tag' => '',     'img' => 'https://images.unsplash.com/photo-1517991104123-1d56a6e81ed9?w=400', 'link' => erdu_get_page_url('products')),
                        );
                    }

                    foreach ($product_items as $p) :
                    ?>
                        <div class="erdu-card group">
                            <div class="relative h-48 overflow-hidden">
                                <img src="<?php echo esc_url($p['img']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <?php if ($p['tag']) : ?>
                                    <span class="absolute top-3 right-3 erdu-badge <?php echo $p['tag'] === 'NEW' ? 'erdu-badge-new' : 'erdu-badge-hot'; ?>"><?php echo esc_html($p['tag']); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800"><?php echo esc_html($p['name']); ?></h3>
                                <p class="text-sm text-gray-500 mt-1"><?php echo esc_html($p['desc']); ?></p>
                                <a href="<?php echo esc_url($p['link']); ?>" class="mt-3 inline-flex items-center gap-1 text-sm font-medium hover:underline erdu-text-primary">
                                    <?php _e('Discover More', 'erdu-wp'); ?>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ====== APPLICATIONS ====== -->
        <section class="erdu-section bg-gray-50">
            <div class="erdu-container">
                <div class="text-center mb-10">
                    <h2 class="erdu-h2"><?php echo esc_html($apps_title); ?></h2>
                    <p class="text-gray-500 mt-2"><?php echo esc_html($apps_desc); ?></p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($apps as $a) :
                        $app_link = !empty($a['link']) ? $a['link'] : erdu_get_page_url('solutions');
                    ?>
                        <a href="<?php echo esc_url($app_link); ?>" class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow border border-gray-100">
                            <?php if (!empty($a['icon'])) : ?><div class="text-4xl mb-3"><?php echo esc_html($a['icon']); ?></div><?php endif; ?>
                            <h3 class="font-semibold text-gray-800"><?php echo esc_html($a['name']); ?></h3>
                            <p class="text-sm text-gray-500 mt-2"><?php echo esc_html($a['description']); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ====== GLOBAL CTA ====== -->
        <?php if ($cta_title) : ?>
        <section class="py-16 erdu-bg-primary">
            <div class="erdu-container text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-8"><?php echo esc_html($cta_title); ?></h2>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <?php if ($cta_btn && $cta_btn_link) : ?>
                        <a href="<?php echo esc_url($cta_btn_link); ?>" class="inline-flex items-center justify-center px-8 py-3 bg-white font-semibold rounded-lg transition-all hover:shadow-lg erdu-text-primary"><?php echo esc_html($cta_btn); ?></a>
                    <?php endif; ?>
                    <?php if ($cta_btn2 && $cta_btn2_link) : ?>
                        <a href="<?php echo esc_url($cta_btn2_link); ?>" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-white font-semibold rounded-lg transition-all hover:bg-white hover:bg-opacity-10"><?php echo esc_html($cta_btn2); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====== TESTIMONIALS ====== -->
        <?php if (!empty($testimonials)) : ?>
        <section class="erdu-section bg-white">
            <div class="erdu-container">
                <div class="text-center mb-10">
                    <h2 class="erdu-h2"><?php echo esc_html($testi_title); ?></h2>
                    <p class="text-gray-500 mt-2"><?php echo esc_html($testi_desc); ?></p>
                </div>
                <?php foreach ($testimonials as $t) : ?>
                <div class="max-w-3xl mx-auto rounded-xl p-8 mb-6 bg-gray-50">
                    <div class="text-4xl mb-4 erdu-text-primary" style="opacity: 0.3;">"</div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6"><?php echo esc_html($t['quote']); ?></p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold erdu-bg-primary"><?php echo esc_html(substr($t['author'], 0, 1)); ?></div>
                        <div>
                            <div class="font-semibold text-gray-800"><?php echo esc_html($t['author']); ?></div>
                            <div class="text-sm text-gray-500"><?php echo esc_html($t['role']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====== EXHIBITIONS ====== -->
        <section class="erdu-section bg-gray-50">
            <div class="erdu-container">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="erdu-h2"><?php echo esc_html($expo_title); ?></h2>
                        <p class="text-gray-500 mt-2"><?php echo esc_html($expo_desc); ?></p>
                    </div>
                    <a href="<?php echo esc_url(erdu_get_page_url('news')); ?>" class="hidden md:inline-flex items-center gap-1 text-sm font-medium hover:underline erdu-text-primary"><?php _e('View All', 'erdu-wp'); ?></a>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <?php
                    $display_expos = array();

                    if ($expo_source === 'cpt') {
                        $expos_query = new WP_Query(array(
                            'post_type'      => 'erdu_exhibition',
                            'posts_per_page' => intval($expo_count),
                            'meta_key'       => 'expo_status',
                            'meta_value'     => 'upcoming',
                        ));
                        if ($expos_query->have_posts()) :
                            while ($expos_query->have_posts()) : $expos_query->the_post();
                                $display_expos[] = array(
                                    'name'     => get_the_title(),
                                    'date'     => get_post_meta(get_the_ID(), 'expo_date', true),
                                    'location' => get_post_meta(get_the_ID(), 'expo_location', true),
                                    'booth'    => get_post_meta(get_the_ID(), 'expo_booth', true),
                                );
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }

                    if (empty($display_expos) && !empty($expo_custom)) {
                        $display_expos = $expo_custom;
                    }

                    foreach ($display_expos as $e) : ?>
                        <div class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 erdu-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <?php if (!empty($e['date'])) : ?><span class="text-sm font-medium erdu-text-primary"><?php echo esc_html($e['date']); ?></span><?php endif; ?>
                            </div>
                            <h3 class="font-semibold text-gray-800"><?php echo esc_html($e['name']); ?></h3>
                            <?php if (!empty($e['location'])) : ?><p class="text-sm text-gray-500"><?php echo esc_html($e['location']); ?></p><?php endif; ?>
                            <?php if (!empty($e['booth'])) : ?><p class="text-sm text-gray-400 mt-1"><?php printf(__('Booth: %s', 'erdu-wp'), esc_html($e['booth'])); ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ====== PARTNERS ====== -->
        <section class="py-12 bg-white border-t border-gray-100">
            <div class="erdu-container">
                <p class="text-center text-sm text-gray-400 mb-6"><?php echo esc_html($partners_title); ?></p>
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 opacity-60">
                    <?php foreach ($partners as $prt) :
                        $prt_logo = !empty($prt['logo']) ? $prt['logo'] : '';
                    ?>
                        <?php if ($prt_logo) : ?>
                            <img src="<?php echo esc_url($prt_logo); ?>" alt="<?php echo esc_attr($prt['name']); ?>" class="h-8 object-contain grayscale hover:grayscale-0 transition-all">
                        <?php else : ?>
                            <span class="text-lg font-bold text-gray-400 hover:erdu-text-primary transition-colors cursor-pointer"><?php echo esc_html($prt['name']); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ====== FAQ ====== -->
        <?php if (!empty($faq_items)) : ?>
        <section class="erdu-section bg-white">
            <div class="erdu-container max-w-3xl mx-auto">
                <h2 class="erdu-h2 text-center mb-8"><?php echo esc_html($faq_title); ?></h2>
                <div class="space-y-3">
                    <?php foreach ($faq_items as $i => $f) : ?>
                        <div class="erdu-faq-item">
                            <button class="erdu-faq-question" onclick="this.nextElementSibling.classList.toggle('active'); this.querySelector('.faq-icon').textContent = this.nextElementSibling.classList.contains('active') ? '−' : '+';">
                                <span><?php echo esc_html($f['question']); ?></span>
                                <span class="faq-icon text-gray-400">+</span>
                            </button>
                            <div class="erdu-faq-answer"><?php echo esc_html($f['answer']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo esc_url(erdu_get_page_url('contact')); ?>" class="inline-flex items-center gap-1 text-sm font-medium hover:underline erdu-text-primary"><?php _e('View All FAQs', 'erdu-wp'); ?> →</a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====== NEWSLETTER ====== -->
        <?php if ($news_title) : ?>
        <section class="py-12 border-t border-gray-100 bg-gray-50">
            <div class="erdu-container text-center">
                <h3 class="text-xl font-semibold mb-2 text-gray-800"><?php echo esc_html($news_title); ?></h3>
                <form class="flex flex-wrap justify-center gap-2 max-w-md mx-auto mt-4">
                    <input type="email" placeholder="<?php echo esc_attr($news_placeholder); ?>" class="erdu-input flex-1 min-w-[200px]">
                    <button type="submit" class="erdu-btn erdu-btn-primary"><?php echo esc_html($news_button); ?></button>
                </form>
            </div>
        </section>
        <?php endif; ?>

    <?php
    endwhile;
endif;

get_footer();
