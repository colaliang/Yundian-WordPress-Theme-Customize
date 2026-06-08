<?php
/**
 * Template Name: About Us
 *
 * @package ERDU_Lighting
 */

get_header();

$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'profile';

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // --- Hero ---
        $hero_title    = erdu_page_field('about_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('about_hero_subtitle', __('"Innovating Lighting, Illuminating the World" — Since 2009', 'erdu-wp'));
        $hero_bg       = erdu_page_field('about_hero_bg', 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=1200');
        $hero_btn      = erdu_page_field('about_hero_btn', __('Explore Products', 'erdu-wp'));
        $hero_btn_link = erdu_page_field('about_hero_btn_link', erdu_get_page_url('products'));
        $hero_btn2     = erdu_page_field('about_hero_btn2', __('Contact Us', 'erdu-wp'));
        $hero_btn2_link = erdu_page_field('about_hero_btn2_link', erdu_get_page_url('contact'));

        // --- Page Content ---
        $page_content = erdu_page_field('about_page_editor', '');

        // --- Profile ---
        $highlight     = erdu_page_field('about_highlight', __('ERDU Lighting: Your Reliable 48V Magnetic Track Light Manufacturer in China', 'erdu-wp'));
        $intro         = erdu_page_field('about_company_intro', '');
        $profile_image = erdu_page_field('about_profile_image', 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800');
        $profile_stats = erdu_page_field('about_profile_stats', array(
            array('label' => __('Founded:', 'erdu-wp'),   'value' => '2009'),
            array('label' => __('Location:', 'erdu-wp'),  'value' => __('Zhongshan, Guzhen', 'erdu-wp')),
            array('label' => __('Area:', 'erdu-wp'),      'value' => '6300m²'),
            array('label' => __('Employees:', 'erdu-wp'), 'value' => '100+'),
            array('label' => __('Key Partners:', 'erdu-wp'), 'value' => 'Sanan, Aishi'),
            array('label' => __('Export:', 'erdu-wp'),    'value' => __('20+ Countries', 'erdu-wp')),
        ));
        $team = erdu_page_field('about_team', array(
            array('name' => 'David Deng',  'role' => __('General Manager', 'erdu-wp'),   'bio' => __('20+ years in LED industry', 'erdu-wp')),
            array('name' => 'Eileen Zhang', 'role' => __('Sales Director', 'erdu-wp'),    'bio' => __('15+ years in export sales', 'erdu-wp')),
            array('name' => 'Michael Chen', 'role' => __('Technical Director', 'erdu-wp'),'bio' => __('18+ years in R&D', 'erdu-wp')),
            array('name' => 'Lisa Wang',    'role' => __('QC Manager', 'erdu-wp'),        'bio' => __('12+ years in quality control', 'erdu-wp')),
        ));

        // --- Timeline (10 milestones matching reference design) ---
        $timeline_title = erdu_page_field('about_timeline_title', __('Our Journey', 'erdu-wp'));
        $timeline = erdu_page_field('about_timeline', array(
            array('year' => '2009', 'title' => __('Company Founded', 'erdu-wp'), 'description' => __('Established in Guzhen, the lighting capital of China, with a vision to create professional LED lighting products.', 'erdu-wp')),
            array('year' => '2010', 'title' => __('First Exhibition', 'erdu-wp'), 'description' => __('Debuted at Hong Kong International Lighting Fair, marking the beginning of our global journey.', 'erdu-wp')),
            array('year' => '2012', 'title' => __('Production Expansion', 'erdu-wp'), 'description' => __('Expanded production lines to meet growing international demand.', 'erdu-wp')),
            array('year' => '2015', 'title' => __('Sanan Partnership', 'erdu-wp'), 'description' => __('Became business partner of Sanan Optoelectronics, China\'s largest LED chip manufacturer.', 'erdu-wp')),
            array('year' => '2017', 'title' => __('Magnetic Track Series Launch', 'erdu-wp'), 'description' => __('Launched the first generation of 48V magnetic track lighting system.', 'erdu-wp')),
            array('year' => '2019', 'title' => __('ISO9001 Certified', 'erdu-wp'), 'description' => __('Achieved ISO9001:2015 quality management system certification.', 'erdu-wp')),
            array('year' => '2020', 'title' => __('Stable Export Growth', 'erdu-wp'), 'description' => __('Maintained export growth despite global challenges, proving product reliability.', 'erdu-wp')),
            array('year' => '2022', 'title' => __('Factory Expansion', 'erdu-wp'), 'description' => __('Expanded to 6300m² modern facility with upgraded production equipment.', 'erdu-wp')),
            array('year' => '2024', 'title' => __('UT16 Smart Series', 'erdu-wp'), 'description' => __('Launched UT16 intelligent lighting series with smart home integration.', 'erdu-wp')),
            array('year' => '2025', 'title' => __('Global Strategy', 'erdu-wp'), 'description' => __('Launching global brand strategy with distributor program in 20+ countries.', 'erdu-wp')),
        ));

        // --- Values ---
        $mission_title = erdu_page_field('about_mission_title', __('Our Mission', 'erdu-wp'));
        $mission_text  = erdu_page_field('about_mission_text', __('"To Illuminate Global Spaces with Innovative, Reliable, and Sustainable LED Lighting Solutions."', 'erdu-wp'));
        $values = erdu_page_field('about_values', array(
            array('title' => __('Quality First', 'erdu-wp'), 'description' => __('Every product undergoes rigorous testing', 'erdu-wp')),
            array('title' => __('Customer Focus', 'erdu-wp'), 'description' => __('Solutions tailored to client needs', 'erdu-wp')),
            array('title' => __('Innovation Driven', 'erdu-wp'), 'description' => __('R&D investment keeps us at the edge', 'erdu-wp')),
            array('title' => __('Integrity', 'erdu-wp'), 'description' => __('Honest communication and fair pricing', 'erdu-wp')),
            array('title' => __('Sustainability', 'erdu-wp'), 'description' => __('Energy-efficient lighting solutions', 'erdu-wp')),
        ));

        // --- Factory ---
        $factory_title  = erdu_page_field('about_factory_title', __('Factory Tour', 'erdu-wp'));
        $factory_images = erdu_page_field('about_factory_images', array(
            array('url' => 'https://images.unsplash.com/photo-1565043666747-69f6646db940?w=400', 'caption' => __('Production Line', 'erdu-wp')),
            array('url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400', 'caption' => __('Aging Test Area', 'erdu-wp')),
            array('url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400', 'caption' => __('Showroom', 'erdu-wp')),
        ));
        $factory_stats = erdu_page_field('about_factory_stats', array(
            array('label' => __('Production Lines', 'erdu-wp'), 'value' => '6'),
            array('label' => __('Daily Capacity', 'erdu-wp'), 'value' => '3,000+'),
            array('label' => __('QC Stations', 'erdu-wp'), 'value' => '12'),
            array('label' => __('Warehouse', 'erdu-wp'), 'value' => '2,000m²'),
        ));

        // --- Partners ---
        $partners_section_title = erdu_page_field('about_partners_title', __('Our Supply Chain Partners', 'erdu-wp'));
        $partners_data = erdu_page_field('about_partners_list', array(
            array('logo' => '', 'name' => 'Sanan',    'category' => __('LED Chip Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'Samsung',  'category' => __('LED Chip Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'Aishi',    'category' => __('Capacitor Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'Lifud',    'category' => __('Driver Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'OSRAM',    'category' => __('Optical Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'CREE',     'category' => __('LED Chip Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'PHILIPS',  'category' => __('Technology Partner', 'erdu-wp')),
            array('logo' => '', 'name' => 'tuya',     'category' => __('Smart Partner', 'erdu-wp')),
        ));

        // --- Certifications ---
        $certs_section_title = erdu_page_field('about_certs_title', __('Certifications', 'erdu-wp'));
        $certs_data = erdu_page_field('about_certs_list', array(
            array('icon' => '', 'name' => 'CE Certification',     'org' => 'EU',           'scope' => __('International', 'erdu-wp')),
            array('icon' => '', 'name' => 'RoHS Certification',   'org' => 'EU',           'scope' => __('International', 'erdu-wp')),
            array('icon' => '', 'name' => 'ERP Certification',    'org' => 'EU',           'scope' => __('International', 'erdu-wp')),
            array('icon' => '', 'name' => 'ISO9001:2015',         'org' => 'TUV',          'scope' => __('Quality', 'erdu-wp')),
            array('icon' => '', 'name' => 'ETL/cETL',             'org' => 'Intertek',     'scope' => __('International', 'erdu-wp')),
            array('icon' => '', 'name' => 'REACH',                'org' => 'EU',           'scope' => __('Environmental', 'erdu-wp')),
        ));

        // --- Downloads ---
        $downloads_section_title = erdu_page_field('about_downloads_title', __('Downloads & Resources', 'erdu-wp'));
        $downloads_show          = erdu_page_field('about_downloads_show', true);
        $downloads_data          = array();
        if ($downloads_show) {
            $dl_query = new WP_Query(array(
                'post_type'      => 'erdu_download',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            if ($dl_query->have_posts()) {
                while ($dl_query->have_posts()) {
                    $dl_query->the_post();
                    $dl_id = get_the_ID();
                    $file_url   = get_field('download_file', $dl_id);
                    $external   = get_field('download_external', $dl_id);
                    $version    = get_field('download_version', $dl_id);
                    $file_size  = get_field('download_size', $dl_id);
                    $desc       = get_field('download_description', $dl_id);
                    $dl_cats    = get_the_terms($dl_id, 'erdu_download_cat');
                    $cat_name   = ($dl_cats && !is_wp_error($dl_cats)) ? $dl_cats[0]->name : '';

                    // Auto-detect file size if empty
                    if (empty($file_size) && $file_url) {
                        $file_path = get_attached_file(attachment_url_to_postid($file_url));
                        if ($file_path && file_exists($file_path)) {
                            $bytes = filesize($file_path);
                            $file_size = size_format($bytes, 1);
                        }
                    }

                    // Detect file extension
                    $url = $external ?: $file_url;
                    $ext = '';
                    if ($url) {
                        $pathinfo = pathinfo(parse_url($url, PHP_URL_PATH));
                        $ext = isset($pathinfo['extension']) ? strtoupper($pathinfo['extension']) : '';
                    }

                    $downloads_data[] = array(
                        'title'       => get_the_title(),
                        'file_url'    => $url,
                        'external'    => !empty($external),
                        'version'     => $version,
                        'file_size'   => $file_size,
                        'description' => $desc,
                        'category'    => $cat_name,
                        'ext'         => $ext,
                    );
                }
                wp_reset_postdata();
            }
        }

        // --- CTA ---
        $cta_override = erdu_page_field('about_cta_override', false);
        if ($cta_override) {
            $cta_title  = erdu_page_field('about_cta_title', '');
            $cta_btn    = erdu_page_field('about_cta_button', '');
            $cta_link   = erdu_page_field('about_cta_link', '');
            $cta_btn2   = erdu_page_field('about_cta_button2', '');
            $cta_link2  = erdu_page_field('about_cta_link2', '');
        } else {
            $cta_title  = __('Want to Know More About ERDU?', 'erdu-wp');
            $cta_btn    = __('Schedule a Factory Tour', 'erdu-wp');
            $cta_link   = erdu_get_page_url('contact');
            $cta_btn2   = __('Download Company Profile', 'erdu-wp');
            $cta_link2  = '#';
        }
        ?>

        <!-- ====== HERO ====== -->
        <section class="relative py-20 erdu-bg-secondary">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <?php if ($hero_subtitle) : ?><p class="text-orange-100 mt-4 max-w-2xl"><?php echo esc_html($hero_subtitle); ?></p><?php endif; ?>
                <div class="flex flex-wrap gap-4 mt-8">
                    <?php if ($hero_btn && $hero_btn_link) : ?>
                        <a href="<?php echo esc_url($hero_btn_link); ?>" class="erdu-btn erdu-btn-primary"><?php echo esc_html($hero_btn); ?><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    <?php endif; ?>
                    <?php if ($hero_btn2 && $hero_btn2_link) : ?>
                        <a href="<?php echo esc_url($hero_btn2_link); ?>" class="erdu-btn erdu-btn-outline"><?php echo esc_html($hero_btn2); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ====== PAGE CONTENT ====== -->
        <?php if ($page_content) : ?>
        <section class="py-12 bg-white">
            <div class="erdu-container">
                <div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====== TABS ====== -->
        <div class="bg-white border-b border-gray-200 sticky top-16 z-40">
            <div class="erdu-container">
                <div class="flex overflow-x-auto gap-1">
                    <a href="<?php echo esc_url(add_query_arg('tab', 'profile',  get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'profile'  ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <?php _e('Company Profile', 'erdu-wp'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'timeline', get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'timeline' ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <?php _e('Our Journey', 'erdu-wp'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'values',   get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'values'   ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <?php _e('Mission & Values', 'erdu-wp'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'factory',  get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'factory'  ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <?php _e('Factory Tour', 'erdu-wp'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'partners', get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'partners' ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <?php _e('Partners', 'erdu-wp'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'certifications', get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'certifications' ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <?php _e('Certifications', 'erdu-wp'); ?>
                    </a>
                    <?php if ($downloads_show) : ?>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'downloads', get_permalink()) . '#content'); ?>" class="erdu-tab-btn <?php echo $tab === 'downloads' ? 'active' : ''; ?>">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <?php _e('Downloads', 'erdu-wp'); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="erdu-container py-12" id="content">

            <!-- PROFILE TAB -->
            <?php if ($tab === 'profile') : ?>
                <div class="grid md:grid-cols-2 gap-12 items-center mb-12">
                    <div>
                        <?php if ($highlight) : ?>
                            <div class="border-l-4 p-4 mb-4 rounded-r-md bg-orange-50 border-orange-500">
                                <p class="font-medium erdu-text-primary"><?php echo esc_html($highlight); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($intro) : ?>
                            <div class="prose max-w-none mb-4"><?php echo wp_kses_post($intro); ?></div>
                        <?php else : ?>
                            <p class="text-gray-600 mb-4 leading-relaxed"><?php _e('Zhongshan Erdu Lighting Technology Co., Ltd. is a professional manufacturer specializing in developing, designing, producing and selling all kinds of LED products. Our company was established in 2009, located in the lighting capital — Guzhen.', 'erdu-wp'); ?></p>
                        <?php endif; ?>
                        <?php if ($profile_stats) : ?>
                            <div class="grid grid-cols-2 gap-3 text-sm mt-4">
                                <?php foreach ($profile_stats as $s) : ?>
                                    <div class="p-3 rounded-md bg-gray-50">
                                        <span class="text-gray-500"><?php echo esc_html($s['label']); ?></span>
                                        <span class="font-medium"><?php echo esc_html($s['value']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(erdu_get_page_url('about')); ?>" class="inline-flex items-center gap-1 font-medium hover:underline mt-4 erdu-text-primary">
                            <?php _e('Learn More', 'erdu-wp'); ?>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo esc_attr($hero_title); ?>" class="w-full h-[400px] object-cover">
                    </div>
                </div>

                <?php if ($team) : ?>
                    <h3 class="erdu-h3 mb-6"><?php _e('Leadership Team', 'erdu-wp'); ?></h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($team as $m) : ?>
                            <div class="text-center p-6 rounded-xl bg-gray-50">
                                <div class="w-20 h-20 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-2xl font-bold erdu-bg-primary"><?php echo esc_html($m['name'][0]); ?></div>
                                <h4 class="font-semibold text-gray-800"><?php echo esc_html($m['name']); ?></h4>
                                <p class="text-sm erdu-text-primary"><?php echo esc_html($m['role']); ?></p>
                                <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($m['bio']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <!-- TIMELINE TAB -->
            <?php elseif ($tab === 'timeline') : ?>
                <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($timeline_title); ?></h2>
                <div class="relative max-w-3xl mx-auto">
                    <div class="absolute left-1/2 top-0 bottom-0 w-0.5 -translate-x-1/2 hidden md:block bg-orange-200"></div>
                    <div class="space-y-8">
                        <?php foreach ($timeline as $i => $item) : ?>
                            <div class="flex flex-col md:flex-row items-center gap-6 <?php echo $i % 2 === 0 ? '' : 'md:flex-row-reverse'; ?>">
                                <div class="flex-1 text-right hidden md:block">
                                    <?php if ($i % 2 === 0) : ?>
                                        <h4 class="text-xl font-bold text-gray-800"><?php echo esc_html($item['title']); ?></h4>
                                        <p class="text-sm text-gray-500 mt-1"><?php echo esc_html($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold z-10 shadow-lg shrink-0 erdu-bg-primary"><?php echo esc_html(substr($item['year'], 2)); ?></div>
                                <div class="flex-1 text-center md:text-left">
                                    <span class="text-sm font-bold md:hidden erdu-text-primary"><?php echo esc_html($item['year']); ?></span>
                                    <h4 class="text-lg font-bold md:hidden text-gray-800"><?php echo esc_html($item['title']); ?></h4>
                                    <p class="text-sm text-gray-500 mt-1 md:hidden"><?php echo esc_html($item['description']); ?></p>
                                    <?php if ($i % 2 !== 0) : ?>
                                        <h4 class="text-xl font-bold hidden md:block text-gray-800"><?php echo esc_html($item['title']); ?></h4>
                                        <p class="text-sm text-gray-500 mt-1 hidden md:block"><?php echo esc_html($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <!-- VALUES TAB -->
            <?php elseif ($tab === 'values') : ?>
                <?php if ($mission_text) : ?>
                    <div class="text-center py-16 rounded-2xl mb-12 erdu-bg-primary">
                        <h3 class="text-3xl font-bold text-white mb-4"><?php echo esc_html($mission_title); ?></h3>
                        <p class="text-xl text-orange-100 max-w-2xl mx-auto px-4"><?php echo esc_html($mission_text); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($values) : ?>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
                        <?php foreach ($values as $v) : 
                            $default_svgs = array(
                                __('Quality First', 'erdu-wp') => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>',
                                __('Customer Focus', 'erdu-wp') => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
                                __('Innovation Driven', 'erdu-wp') => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>',
                                __('Integrity', 'erdu-wp') => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
                                __('Sustainability', 'erdu-wp') => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            );
                            $svg_path = $default_svgs[$v['title']] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>';
                        ?>
                            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                                <?php if (!empty($v['icon'])) : ?>
                                    <img src="<?php echo esc_url($v['icon']); ?>" alt="<?php echo esc_attr($v['title']); ?>" class="w-12 h-12 mx-auto mb-4 object-contain">
                                <?php else : ?>
                                    <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center bg-orange-50 erdu-text-primary">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $svg_path; ?></svg>
                                    </div>
                                <?php endif; ?>
                                <h4 class="font-semibold text-gray-800"><?php echo esc_html($v['title']); ?></h4>
                                <p class="text-sm text-gray-500 mt-2"><?php echo esc_html($v['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <!-- FACTORY TAB -->
            <?php elseif ($tab === 'factory') : ?>
                <h3 class="erdu-h3 mb-4"><?php echo esc_html($factory_title); ?></h3>
                <?php if ($factory_images) : ?>
                    <div class="grid md:grid-cols-3 gap-4 mb-8">
                        <?php foreach ($factory_images as $fimg) : ?>
                            <div class="rounded-lg overflow-hidden">
                                <img src="<?php echo esc_url($fimg['url']); ?>" alt="<?php echo esc_attr($fimg['caption']); ?>" class="w-full h-48 object-cover">
                                <p class="text-sm text-gray-600 p-2 text-center" style="background-color: #F9FAFB;"><?php echo esc_html($fimg['caption']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ($factory_stats) : ?>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <?php foreach ($factory_stats as $fst) : ?>
                            <div class="p-4 rounded-lg" style="background-color: #F9FAFB;">
                                <div class="text-2xl font-bold" style="color: #F37021;"><?php echo esc_html($fst['value']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo esc_html($fst['label']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <!-- PARTNERS TAB -->
            <?php elseif ($tab === 'partners') : ?>
                <h3 class="erdu-h3 mb-6"><?php echo esc_html($partners_section_title); ?></h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php foreach ($partners_data as $p) : ?>
                        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition-shadow">
                            <?php if (!empty($p['logo'])) : ?>
                                <img src="<?php echo esc_url($p['logo']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="h-10 mx-auto mb-3 object-contain">
                            <?php else : ?>
                                <div class="text-xl font-bold text-gray-400 mb-1"><?php echo esc_html($p['name']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($p['category'])) : ?><div class="text-xs" style="color: #F37021;"><?php echo esc_html($p['category']); ?></div><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <!-- CERTIFICATIONS TAB -->
            <?php elseif ($tab === 'certifications') : ?>
                <h3 class="erdu-h3 mb-6"><?php echo esc_html($certs_section_title); ?></h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($certs_data as $c) : ?>
                        <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                            <?php if (!empty($c['icon'])) : ?>
                                <img src="<?php echo esc_url($c['icon']); ?>" alt="" class="w-10 h-10 object-contain shrink-0">
                            <?php else : ?>
                                <svg class="w-10 h-10 shrink-0 erdu-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            <?php endif; ?>
                            <div>
                                <h4 class="font-semibold text-sm text-gray-800"><?php echo esc_html($c['name']); ?></h4>
                                <?php if (!empty($c['org']) || !empty($c['scope'])) : ?>
                                    <p class="text-xs text-gray-500"><?php echo esc_html(($c['org'] ?? '') . ' · ' . ($c['scope'] ?? '')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <!-- DOWNLOADS TAB -->
            <?php elseif ($tab === 'downloads' && $downloads_show) : ?>
                <h3 class="erdu-h3 mb-6"><?php echo esc_html($downloads_section_title); ?></h3>
                <?php if (!empty($downloads_data)) : ?>
                    <div class="space-y-3">
                        <?php foreach ($downloads_data as $dl) :
                            $icon_svg = '';
                            switch ($dl['ext']) {
                                case 'PDF':  $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>'; break;
                                case 'DOCX': case 'DOC': $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'; break;
                                case 'XLSX': case 'XLS': $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'; break;
                                case 'ZIP':  case 'RAR': $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>'; break;
                                case 'IES':  $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>'; break;
                                default:     $icon_svg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>'; break;
                            }
                        ?>
                        <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center gap-4 hover:shadow-md transition-shadow">
                            <!-- File Icon -->
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0" style="background-color: #FFF5ED;">
                                <svg class="w-6 h-6" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $icon_svg; ?></svg>
                            </div>
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h4 class="font-semibold text-sm text-gray-800"><?php echo esc_html($dl['title']); ?></h4>
                                    <?php if ($dl['ext']) : ?><span class="text-xs px-2 py-0.5 rounded font-medium bg-orange-50 erdu-text-primary"><?php echo esc_html($dl['ext']); ?></span><?php endif; ?>
                                    <?php if ($dl['version']) : ?><span class="text-xs text-gray-400"><?php echo esc_html($dl['version']); ?></span><?php endif; ?>
                                </div>
                                <?php if ($dl['description']) : ?><p class="text-xs text-gray-500 line-clamp-2"><?php echo esc_html($dl['description']); ?></p><?php endif; ?>
                                <?php if ($dl['category'] || $dl['file_size']) : ?>
                                    <div class="flex gap-3 mt-1 text-xs text-gray-400">
                                        <?php if ($dl['category']) : ?><span><?php echo esc_html($dl['category']); ?></span><?php endif; ?>
                                        <?php if ($dl['file_size']) : ?><span><?php echo esc_html($dl['file_size']); ?></span><?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Download Button -->
                            <?php if ($dl['file_url']) : 
                                $require_login = erdu_module_config('downloads', 'require_login', true);
                                $exclude_cn_ip = erdu_module_config('downloads', 'exclude_cn_ip', false);
                                $is_cn_ip = $exclude_cn_ip ? erdu_is_china_ip() : false;
                                
                                if ($is_cn_ip) : ?>
                                     <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg text-gray-500 bg-gray-100 shrink-0">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                         <?php _e('Not available in your region', 'erdu-wp'); ?>
                                     </span>
                                 <?php elseif ($require_login && !is_user_logged_in()) : ?>
                                     <a href="<?php echo esc_url(wp_login_url(erdu_get_page_url('about') . '?tab=downloads')); ?>" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border transition-all hover:shadow-sm shrink-0 text-gray-700 bg-gray-50 border-gray-300" title="<?php _e('No permission. Please login to download.', 'erdu-wp'); ?>">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                                         <?php _e('Login to Download', 'erdu-wp'); ?>
                                     </a>
                                 <?php else : ?>
                                    <a href="<?php echo esc_url($dl['file_url']); ?>" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border transition-all hover:shadow-sm shrink-0 erdu-text-primary border-orange-500" <?php echo $dl['external'] ? 'target="_blank" rel="noopener"' : 'download'; ?>>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <?php _e('Download', 'erdu-wp'); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 mx-auto mb-3 erdu-text-primary" style="opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <p class="text-gray-500"><?php _e('No downloads available yet.', 'erdu-wp'); ?></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- ====== CTA ====== -->
        <?php if ($cta_title) : ?>
        <section class="py-16 bg-gray-50 border-t border-gray-200">
            <div class="erdu-container text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-8 text-gray-800"><?php echo esc_html($cta_title); ?></h2>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <?php if ($cta_btn && $cta_link) : ?>
                        <a href="<?php echo esc_url($cta_link); ?>" class="inline-flex items-center justify-center gap-2 px-8 py-3 font-semibold rounded-lg text-white transition-all hover:shadow-lg erdu-bg-primary"><?php echo esc_html($cta_btn); ?></a>
                    <?php endif; ?>
                    <?php if ($cta_btn2 && $cta_link2) : ?>
                        <a href="<?php echo esc_url($cta_link2); ?>" class="inline-flex items-center justify-center gap-2 px-8 py-3 font-semibold rounded-lg border border-gray-300 text-gray-700 bg-white transition-all hover:border-gray-400 hover:shadow-sm" download>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <?php echo esc_html($cta_btn2); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile;
endif;

get_footer();
