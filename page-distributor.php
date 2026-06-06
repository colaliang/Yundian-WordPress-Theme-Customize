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

        // ---- Hero (independent page fields — NOT from Page Settings) ----
        $hero_title    = erdu_page_field('dist_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('dist_hero_subtitle', __('Join our global network of lighting distributors and grow your business with ERDU', 'erdu-wp'));
        $hero_bg       = erdu_page_field('dist_hero_bg', 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200');
        $hero_btn      = erdu_page_field('dist_hero_btn', '');
        $hero_btn_link = erdu_page_field('dist_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('dist_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('dist_hero_btn2_link', '');

        // ---- Page Content (between Hero and Intro) ----
        $page_content = erdu_page_field('dist_page_editor', '');

        // ---- Introduction ----
        $intro         = erdu_page_field('dist_intro', '');
        $partner_title = erdu_page_field('dist_partner_title', __('Why Partner with ERDU?', 'erdu-wp'));
        $partner_intro = erdu_page_field('dist_partner_content', __('Join our growing network of distributors worldwide. We provide comprehensive support to help you succeed in your market.', 'erdu-wp'));

        // ---- Benefits ----
        $benefits = erdu_page_field('dist_benefits', array(
            array('title' => __('Factory-Direct Pricing', 'erdu-wp'), 'description' => __('Competitive wholesale prices with no middlemen', 'erdu-wp')),
            array('title' => __('Exclusive Territory', 'erdu-wp'), 'description' => __('Protected sales regions to prevent channel conflict', 'erdu-wp')),
            array('title' => __('Marketing Support', 'erdu-wp'), 'description' => __('Product catalogs, samples, and promotional materials', 'erdu-wp')),
            array('title' => __('Technical Training', 'erdu-wp'), 'description' => __('Product knowledge and installation training provided', 'erdu-wp')),
            array('title' => __('Flexible MOQ', 'erdu-wp'), 'description' => __('Starter programs for new partners', 'erdu-wp')),
            array('title' => __('3-Year Warranty', 'erdu-wp'), 'description' => __('Comprehensive product warranty and after-sales support', 'erdu-wp')),
        ));

        // ---- Requirements ----
        $req_title    = erdu_page_field('dist_req_title', __('Distributor Requirements', 'erdu-wp'));
        $req_intro    = erdu_page_field('dist_req_intro', '');
        $requirements = erdu_page_field('dist_requirements', array(
            array('text' => __('Established lighting business with physical showroom or warehouse', 'erdu-wp')),
            array('text' => __('Annual purchase commitment (negotiable by region)', 'erdu-wp')),
            array('text' => __('Technical sales capability for specification and installation support', 'erdu-wp')),
            array('text' => __('Good reputation and business credit in local market', 'erdu-wp')),
        ));
        ?>

        <!-- Hero -->
        <section class="relative py-20 erdu-bg-dark">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-blue-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
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
            </div>
        </section>

        <!-- Editable Page Content -->
        <?php if ($page_content) : ?>
        <section class="py-12 bg-white">
            <div class="erdu-container"><div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- Intro + Benefits -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <div class="grid lg:grid-cols-2 gap-12">
                    <div>
                        <?php if ($intro) : ?>
                            <div class="prose max-w-none"><?php echo wp_kses_post($intro); ?></div>
                        <?php else : ?>
                            <h2 class="erdu-h3 mb-4"><?php echo esc_html($partner_title); ?></h2>
                            <p class="text-gray-600 mb-6"><?php echo esc_html($partner_intro); ?></p>
                        <?php endif; ?>
                        <?php if ($requirements) : ?>
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h4 class="font-semibold mb-4 text-gray-800"><?php echo esc_html($req_title); ?></h4>
                            <?php if ($req_intro) : ?><p class="text-sm text-gray-500 mb-4"><?php echo esc_html($req_intro); ?></p><?php endif; ?>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <?php foreach ($requirements as $req) : ?>
                                    <li class="flex items-start gap-2"><svg class="w-4 h-4 mt-0.5 shrink-0 erdu-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><?php echo esc_html($req['text']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 class="erdu-h3 mb-6"><?php _e('Partner Benefits', 'erdu-wp'); ?></h3>
                        <div class="space-y-4">
                            <?php foreach ($benefits as $b) : ?>
                                <div class="bg-white rounded-lg p-4 border border-gray-200 flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-orange-50"><svg class="w-5 h-5 erdu-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                                    <div><h4 class="font-medium text-sm text-gray-800"><?php echo esc_html($b['title']); ?></h4><p class="text-xs text-gray-500"><?php echo esc_html($b['description']); ?></p></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-3xl">
                <div class="bg-white rounded-xl p-8 border border-gray-200 shadow-sm">
                    <h3 class="font-semibold mb-6 text-center text-gray-800"><?php _e('Distributor Application', 'erdu-wp'); ?></h3>
                    <?php if (isset($_GET['dist_success'])) : ?>
                        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200"><?php _e('Thank you! Your application has been submitted. We will review and contact you within 3 business days.', 'erdu-wp'); ?></div>
                    <?php elseif (isset($_GET['dist_error'])) : ?>
                        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-green-200"><?php echo esc_html(sanitize_text_field(wp_unslash($_GET['dist_error'])) === 'ratelimit' ? __('Too many submissions. Please try again later.', 'erdu-wp') : (sanitize_text_field(wp_unslash($_GET['dist_error'])) === 'email' ? __('Please enter a valid email address.', 'erdu-wp') : __('Please fill in all required fields.', 'erdu-wp'))); ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-4">
                        <input type="hidden" name="action" value="erdu_distributor_form">
                        <?php wp_nonce_field('erdu_dist_action', 'erdu_dist_nonce'); ?>
                        <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Company Name', 'erdu-wp'); ?> *</label><input type="text" name="dist_company" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Country/Region', 'erdu-wp'); ?> *</label><input type="text" name="dist_country" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Website', 'erdu-wp'); ?></label><input type="url" name="dist_website" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Years in Business', 'erdu-wp'); ?></label><input type="number" name="dist_years" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Number of Employees', 'erdu-wp'); ?></label><input type="number" name="dist_employees" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Sales Channels', 'erdu-wp'); ?></label><input type="text" name="dist_channels" placeholder="e.g. Retail, Online, Project" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Target Territory', 'erdu-wp'); ?></label><input type="text" name="dist_territory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Current Brands', 'erdu-wp'); ?></label><input type="text" name="dist_current_brands" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Contact Name', 'erdu-wp'); ?> *</label><input type="text" name="dist_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Title/Position', 'erdu-wp'); ?></label><input type="text" name="dist_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Email', 'erdu-wp'); ?> *</label><input type="email" name="dist_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Phone', 'erdu-wp'); ?></label><input type="tel" name="dist_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Why do you want to partner with ERDU?', 'erdu-wp'); ?></label><textarea name="dist_why" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Estimated Annual Volume', 'erdu-wp'); ?></label><input type="text" name="dist_annual_volume" placeholder="e.g. $500K USD" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></div>
                        <button type="submit" class="erdu-btn-primary w-full"><?php _e('Submit Application', 'erdu-wp'); ?></button>
                    </form>
                </div>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA (independent page field — NOT from Page Settings) ----
// Note: CTA is disabled by default on this page since it has an application form
$cta_override = erdu_page_field('dist_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('dist_cta_title', __('Want to Become a Distributor?', 'erdu-wp')),
        erdu_page_field('dist_cta_button', __('Apply Now', 'erdu-wp')),
        erdu_page_field('dist_cta_link', '')
    );
}

get_footer();
