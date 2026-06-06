<?php
/**
 * Template Name: Distributor Program
 *
 * @package ERDU_Lighting
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero ----
        $hero_title    = erdu_page_field('dist_hero_title', __('Join ERDU Global Distributor Network', 'erdu-wp'));
        $hero_subtitle = erdu_page_field('dist_hero_subtitle', __("Partner with China's Leading 48V Magnetic Track Light Manufacturer — Grow Your Lighting Business Together", 'erdu-wp'));
        $hero_bg       = erdu_page_field('dist_hero_bg', 'https://images.unsplash.com/photo-1526304640152-d4619684e484?w=1200');
        $hero_btn      = erdu_page_field('dist_hero_btn', __('Apply to Become a Distributor', 'erdu-wp'));
        $hero_btn_link = erdu_page_field('dist_hero_btn_link', '#apply');
        $hero_btn2     = erdu_page_field('dist_hero_btn2', __('Download Partner Program Guide', 'erdu-wp'));
        $hero_btn2_link = erdu_page_field('dist_hero_btn2_link', '');

        $hero_stats = erdu_page_field('dist_hero_stats', array(
            array('value' => '20+', 'label' => __('Countries Served', 'erdu-wp')),
            array('value' => '100+', 'label' => __('Products', 'erdu-wp')),
            array('value' => '16', 'label' => __('Years Experience', 'erdu-wp')),
        ));

        // ---- Intro ----
        $intro = erdu_page_field('dist_intro', '');
        $intro_default = __('<p>ERDU Lighting has been empowering lighting distributors worldwide since 2009. Our Global Distributor Program (GDP) provides exclusive access to our full range of 48V magnetic track lights, LED downlights, spotlights, and smart lighting solutions — all manufactured in our 6300m² ISO-certified facility in Zhongshan, China.</p><p class="text-lg font-medium text-[#333] mt-4">"Our GDP partners don\'t just sell products — they build lighting empires."</p>', 'erdu-wp');

        // ---- Benefits ----
        $benefits = erdu_page_field('dist_benefits', array(
            array('title' => __('Exclusive Territory Rights', 'erdu-wp'), 'description' => __('Designated country or city exclusive agency rights. No competing distributors in your protected zone.', 'erdu-wp'), 'icon' => 'globe'),
            array('title' => __('Competitive Wholesale Pricing', 'erdu-wp'), 'description' => __('Tiered wholesale pricing structure — the more you sell, the bigger your discount. Up to 35% off list price.', 'erdu-wp'), 'icon' => 'award'),
            array('title' => __('Marketing Support Kit', 'erdu-wp'), 'description' => __('Product catalogs, videos, display stand designs, social media templates, and exhibition materials — all co-branded.', 'erdu-wp'), 'icon' => 'book-open'),
            array('title' => __('Priority New Product Access', 'erdu-wp'), 'description' => __('Get samples and product information 60 days before public launch. Be first to market with new innovations.', 'erdu-wp'), 'icon' => 'truck'),
            array('title' => __('Technical Training', 'erdu-wp'), 'description' => __('Online and offline installation training, product knowledge sessions, and sales coaching for your team.', 'erdu-wp'), 'icon' => 'graduation-cap'),
            array('title' => __('Dedicated Account Manager', 'erdu-wp'), 'description' => __('One-on-one support with a dedicated account manager who understands your market and responds within 24 hours.', 'erdu-wp'), 'icon' => 'user-check'),
        ));

        // ---- Success Stories ----
        $stories = erdu_page_field('dist_stories', array(
            array(
                'quote'   => __('Since partnering with ERDU in 2020, our lighting business has expanded from Lima to 5 major cities. The 48V magnetic track light series is our bestseller — customers love the modular design and easy installation.', 'erdu-wp'),
                'initial' => 'M',
                'name'    => 'Miguel Rodriguez',
                'company' => 'LuzPro Distribution — Peru',
                'metric'  => '$800K+/year',
                'label'   => __('Annual Purchase', 'erdu-wp'),
            ),
            array(
                'quote'   => __('ERDU\'s product quality and on-time delivery have helped us win multiple hotel projects across the Middle East. Their technical support team is always responsive.', 'erdu-wp'),
                'initial' => 'A',
                'name'    => 'Ahmed Al-Rashid',
                'company' => 'Gulf Lighting Solutions — UAE',
                'metric'  => '$1.2M+/year',
                'label'   => __('Annual Purchase', 'erdu-wp'),
            ),
            array(
                'quote'   => __('We started as a small online seller and now distribute ERDU products to 12 European countries. The co-branded marketing materials made scaling much easier.', 'erdu-wp'),
                'initial' => 'S',
                'name'    => 'Sarah Müller',
                'company' => 'EU Light Direct — Germany',
                'metric'  => '500K+/year',
                'label'   => __('Annual Purchase', 'erdu-wp'),
            ),
            array(
                'quote'   => __('The 3-year warranty and consistent product quality give us confidence to pitch ERDU to high-end residential developers in Sydney and Melbourne.', 'erdu-wp'),
                'initial' => 'J',
                'name'    => 'James Chen',
                'company' => 'Aurora Lighting AU — Australia',
                'metric'  => '$600K+/year',
                'label'   => __('Annual Purchase', 'erdu-wp'),
            ),
        ));

        // ---- Process Steps ----
        $steps = erdu_page_field('dist_steps', array(
            array('title' => __('Submit Application', 'erdu-wp'), 'description' => __('Fill out the online application form with your company info and market plan', 'erdu-wp')),
            array('title' => __('Qualification Review', 'erdu-wp'), 'description' => __('ERDU team reviews your qualifications and market fit within 3-5 business days', 'erdu-wp')),
            array('title' => __('Sign Agreement', 'erdu-wp'), 'description' => __('Sign the distributor agreement confirming territory protection and first order commitment', 'erdu-wp')),
            array('title' => __('Launch & Support', 'erdu-wp'), 'description' => __('Receive product training, marketing materials, and first inventory — start selling', 'erdu-wp')),
        ));

        // ---- Requirements ----
        $requirements = erdu_page_field('dist_requirements', array(
            array('text' => __('Registered business entity in lighting or electrical industry', 'erdu-wp')),
            array('text' => __('Existing distribution network or showroom', 'erdu-wp')),
            array('text' => __('Minimum first order: $5,000 USD', 'erdu-wp')),
            array('text' => __('Annual sales commitment: $50,000+ USD', 'erdu-wp')),
            array('text' => __('Willingness to participate in product training', 'erdu-wp')),
            array('text' => __('Shared brand vision and quality commitment', 'erdu-wp')),
        ));

        // ---- Distributor Types ----
        $dist_types = erdu_page_field('dist_types', array(
            array('title' => __('Regional Distributor', 'erdu-wp'), 'description' => __('Exclusive territory rights, maximum discount tier, responsible for sub-channel development', 'erdu-wp'), 'badge' => __('Most Popular', 'erdu-wp')),
            array('title' => __('Project Contractor', 'erdu-wp'), 'description' => __('Project-based cooperation with technical support and project protection', 'erdu-wp'), 'badge' => ''),
            array('title' => __('Online Retail Partner', 'erdu-wp'), 'description' => __('Amazon, eBay, or independent e-commerce sellers with product image packs and listing templates', 'erdu-wp'), 'badge' => ''),
        ));

        // ---- Regions ----
        $regions = erdu_page_field('dist_regions', array(
            array('name' => 'Southeast Asia', 'status' => 'open'),
            array('name' => 'Middle East', 'status' => 'open'),
            array('name' => 'Africa', 'status' => 'open'),
            array('name' => 'South America', 'status' => 'open'),
            array('name' => 'Eastern Europe', 'status' => 'open'),
            array('name' => 'Central Asia', 'status' => 'open'),
            array('name' => 'North America', 'status' => 'assigned'),
            array('name' => 'Western Europe', 'status' => 'assigned'),
        ));

        // ---- Icons map ----
        $icon_svg = array(
            'globe'           => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
            'award'           => '<circle cx="12" cy="8" r="7"/><path d="M8.21 13.89 7 23l5-3 5 3-1.21-9.12"/>',
            'book-open'       => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
            'truck'           => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-2.336-2.92A1 1 0 0 0 18.108 10H15"/><circle cx="7" cy="18" r="2"/><path d="M9 18h5"/><circle cx="17" cy="18" r="2"/>',
            'graduation-cap'  => '<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>',
            'user-check'      => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>',
        );
        ?>

        <!-- Hero -->
        <section class="relative py-20 bg-gradient-to-r from-[#2D1810] to-[#4A2510]">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-orange-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
                <?php if ($hero_btn || $hero_btn2) : ?>
                    <div class="flex flex-wrap gap-4 justify-center mt-8">
                        <?php if ($hero_btn && $hero_btn_link) : ?>
                            <a href="<?php echo esc_url($hero_btn_link); ?>" class="px-6 py-3 font-semibold rounded-lg text-white transition-colors erdu-bg-primary"><?php echo esc_html($hero_btn); ?></a>
                        <?php endif; ?>
                        <?php if ($hero_btn2 && $hero_btn2_link) : ?>
                            <a href="<?php echo esc_url($hero_btn2_link); ?>" class="px-6 py-3 font-semibold rounded-lg border-2 border-white text-white hover:bg-white hover:text-gray-900 transition-colors"><?php echo esc_html($hero_btn2); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($hero_stats)) : ?>
                    <div class="flex flex-wrap justify-center gap-8 md:gap-16 mt-12 pt-8 border-t border-white/20">
                        <?php foreach ($hero_stats as $stat) : ?>
                            <div class="text-center">
                                <div class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($stat['value']); ?></div>
                                <div class="text-sm text-orange-200 mt-1"><?php echo esc_html($stat['label']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Intro -->
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-4xl">
                <?php if ($intro) : ?>
                    <div class="prose prose-lg max-w-none text-center"><?php echo wp_kses_post($intro); ?></div>
                <?php else : ?>
                    <div class="prose prose-lg max-w-none text-center text-gray-600"><?php echo wp_kses_post($intro_default); ?></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Benefits -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <h2 class="text-2xl font-bold text-[#333] mb-10 text-center"><?php _e('Distributor Benefits', 'erdu-wp'); ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($benefits as $b) :
                        $icon = isset($b['icon']) && isset($icon_svg[$b['icon']]) ? $icon_svg[$b['icon']] : $icon_svg['award'];
                    ?>
                        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="text-[#F37021] mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; ?></svg>
                            </div>
                            <h3 class="font-semibold text-[#333] mb-2"><?php echo esc_html($b['title']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo esc_html($b['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Success Stories -->
        <?php if (!empty($stories)) : ?>
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-4xl">
                <h2 class="text-2xl font-bold text-[#333] mb-8 text-center"><?php _e('Distributor Success Stories', 'erdu-wp'); ?></h2>
                <div class="bg-gray-50 rounded-xl p-8">
                    <?php
                    $active_story = isset($_GET['story']) ? intval($_GET['story']) : 0;
                    if ($active_story < 0 || $active_story >= count($stories)) $active_story = 0;
                    $story = $stories[$active_story];
                    ?>
                    <div class="text-4xl text-[#F37021] opacity-30 mb-4">"</div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6"><?php echo esc_html($story['quote']); ?></p>
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#F37021] rounded-full flex items-center justify-center text-white font-bold"><?php echo esc_html($story['initial']); ?></div>
                            <div>
                                <div class="font-semibold text-[#333]"><?php echo esc_html($story['name']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo esc_html($story['company']); ?></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-[#F37021]"><?php echo esc_html($story['metric']); ?></div>
                            <div class="text-xs text-gray-500"><?php echo esc_html($story['label']); ?></div>
                        </div>
                    </div>
                    <?php if (count($stories) > 1) : ?>
                        <div class="flex justify-center gap-2 mt-6">
                            <?php foreach ($stories as $i => $s) : ?>
                                <a href="<?php echo esc_url(add_query_arg('story', $i)); ?>" class="w-3 h-3 rounded-full <?php echo $i === $active_story ? 'bg-[#F37021]' : 'bg-gray-300'; ?> transition-colors" aria-label="<?php printf(__('Story %d', 'erdu-wp'), $i + 1); ?>"></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Application Process -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container max-w-5xl">
                <h2 class="text-2xl font-bold text-[#333] mb-10 text-center"><?php _e('Application Process', 'erdu-wp'); ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($steps as $i => $step) : ?>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#F37021] text-white flex items-center justify-center font-bold text-sm shrink-0"><?php echo intval($i) + 1; ?></div>
                            <div>
                                <h4 class="font-semibold text-[#333]"><?php echo esc_html($step['title']); ?></h4>
                                <p class="text-sm text-gray-500 mt-1"><?php echo esc_html($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Requirements / Types / Regions -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Requirements -->
                    <div>
                        <h3 class="text-xl font-bold text-[#333] mb-4"><?php _e('Requirements', 'erdu-wp'); ?></h3>
                        <ul class="space-y-3">
                            <?php foreach ($requirements as $req) : ?>
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-[#F37021] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
                                    <?php echo esc_html($req['text']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- Distributor Types -->
                    <div>
                        <h3 class="text-xl font-bold text-[#333] mb-4"><?php _e('Distributor Types', 'erdu-wp'); ?></h3>
                        <div class="space-y-3">
                            <?php foreach ($dist_types as $type) : ?>
                                <div class="bg-gray-50 rounded-lg p-4 relative">
                                    <?php if (!empty($type['badge'])) : ?>
                                        <span class="absolute top-2 right-2 px-2 py-0.5 bg-[#F37021] text-white text-xs rounded"><?php echo esc_html($type['badge']); ?></span>
                                    <?php endif; ?>
                                    <h4 class="font-semibold text-[#333]"><?php echo esc_html($type['title']); ?></h4>
                                    <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($type['description']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Available Regions -->
                    <div>
                        <h3 class="text-xl font-bold text-[#333] mb-4"><?php _e('Available Regions', 'erdu-wp'); ?></h3>
                        <div class="space-y-2">
                            <?php foreach ($regions as $region) :
                                $is_open = ($region['status'] ?? '') === 'open';
                            ?>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-600"><?php echo esc_html($region['name']); ?></span>
                                    <span class="px-2 py-0.5 text-xs rounded <?php echo $is_open ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'; ?>">
                                        <?php echo $is_open ? __('Open', 'erdu-wp') : __('Assigned', 'erdu-wp'); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section id="apply" class="py-16 bg-gray-50">
            <div class="erdu-container max-w-4xl">
                <h2 class="text-2xl font-bold text-[#333] mb-8 text-center"><?php _e('Distributor Application', 'erdu-wp'); ?></h2>
                <div class="bg-white border border-gray-200 rounded-xl p-8">
                    <?php if (isset($_GET['dist_success'])) : ?>
                        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200"><?php _e('Thank you! Your application has been submitted. We will review and contact you within 3 business days.', 'erdu-wp'); ?></div>
                    <?php elseif (isset($_GET['dist_error'])) : ?>
                        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                            <?php
                            $err = sanitize_text_field(wp_unslash($_GET['dist_error']));
                            if ($err === 'ratelimit') _e('Too many submissions. Please try again later.', 'erdu-wp');
                            elseif ($err === 'email') _e('Please enter a valid email address.', 'erdu-wp');
                            elseif ($err === 'required') _e('Please fill in all required fields.', 'erdu-wp');
                            else _e('Something went wrong. Please try again.', 'erdu-wp');
                            ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="erdu_distributor_form">
                        <?php wp_nonce_field('erdu_dist_action', 'erdu_dist_nonce'); ?>
                        <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Company Name', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_company" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Business Type', 'erdu-wp'); ?> *</label>
                                <select name="dist_business_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                                    <option value=""><?php _e('Select', 'erdu-wp'); ?></option>
                                    <option value="distributor"><?php _e('Distributor', 'erdu-wp'); ?></option>
                                    <option value="contractor"><?php _e('Contractor', 'erdu-wp'); ?></option>
                                    <option value="retailer"><?php _e('Retailer', 'erdu-wp'); ?></option>
                                    <option value="online_seller"><?php _e('Online Seller', 'erdu-wp'); ?></option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Country/Region', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_country" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('City', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_city" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Annual Revenue Range', 'erdu-wp'); ?> *</label>
                                <select name="dist_revenue" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                                    <option value=""><?php _e('Select', 'erdu-wp'); ?></option>
                                    <option value="<100k">< $100K</option>
                                    <option value="100k-500k">$100K - $500K</option>
                                    <option value="500k-1m">$500K - $1M</option>
                                    <option value="1m-5m">$1M - $5M</option>
                                    <option value=">5m">> $5M</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Current Product Categories', 'erdu-wp'); ?></label>
                                <input type="text" name="dist_current_categories" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Contact Person', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Job Title', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_title" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Email', 'erdu-wp'); ?> *</label>
                                <input type="email" name="dist_email" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Phone/WhatsApp', 'erdu-wp'); ?> *</label>
                                <input type="tel" name="dist_phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Target Market Description', 'erdu-wp'); ?> *</label>
                                <textarea name="dist_target_market" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500"></textarea>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Expected First Order Volume', 'erdu-wp'); ?> *</label>
                                <input type="text" name="dist_first_order" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-[#F37021] focus:outline-none focus:ring-1 focus:ring-orange-500">
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mt-4">
                            <input type="checkbox" name="dist_privacy" id="dist_privacy" required class="rounded">
                            <label for="dist_privacy" class="text-xs text-gray-500"><?php _e("I agree to ERDU's Privacy Policy and consent to being contacted regarding my application.", 'erdu-wp'); ?></label>
                        </div>

                        <button type="submit" class="mt-4 px-8 py-3 bg-[#F37021] text-white rounded-md font-medium hover:bg-orange-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                            <?php _e('Submit Application', 'erdu-wp'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <?php
    endwhile;
endif;

get_footer();
