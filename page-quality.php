<?php
/**
 * Template Name: Quality First
 *
 * @package ERDU_Lighting
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields — NOT from Page Settings) ----
        $hero_title    = erdu_page_field('quality_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('quality_hero_subtitle', __("From raw material inspection to final packaging, ERDU's quality assurance system ensures every product meets international standards.", 'erdu-wp'));
        $hero_bg       = erdu_page_field('quality_hero_bg', 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=1200');
        $hero_btn      = erdu_page_field('quality_hero_btn', '');
        $hero_btn_link = erdu_page_field('quality_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('quality_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('quality_hero_btn2_link', '');

        // ---- Page Content (between Hero and Quality Intro) ----
        $page_content = erdu_page_field('quality_page_editor', '');

        // ---- Quality Introduction ----
        $quality_intro = erdu_page_field('quality_intro', '');

        // ---- 5-Step QC Process ----
        $quality_steps = erdu_page_field('quality_steps', array(
            array('icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('IQC — Incoming QC', 'erdu-wp'), 'description' => __('LED chips, drivers, and raw materials inspected upon arrival', 'erdu-wp')),
            array('icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => __('IPQC — In-Process QC', 'erdu-wp'), 'description' => __('Real-time monitoring during SMT, assembly, and welding', 'erdu-wp')),
            array('icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => __('Aging Test', 'erdu-wp'), 'description' => __('48-hour continuous operation under rated voltage', 'erdu-wp')),
            array('icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => __('OQC — Final Inspection', 'erdu-wp'), 'description' => __('Color temperature, luminous flux, and beam angle verification', 'erdu-wp')),
            array('icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'title' => __('Packaging QC', 'erdu-wp'), 'description' => __('Carton integrity, label accuracy, and drop test', 'erdu-wp')),
        ));

        // ---- Additional QC Steps ----
        $process = erdu_page_field('quality_process', array());

        // ---- Certifications ----
        $certificates = erdu_page_field('quality_certs', array(
            array('name' => 'CE (LVD/EMC)', 'org' => 'TÜV Rheinland', 'valid' => '2028'),
            array('name' => 'RoHS 2.0', 'org' => 'SGS', 'valid' => '2027'),
            array('name' => 'ISO 9001:2015', 'org' => 'BV', 'valid' => '2027'),
            array('name' => 'ETL / cETL', 'org' => 'Intertek', 'valid' => '2027'),
            array('name' => 'SAA', 'org' => 'JAS-ANZ', 'valid' => '2027'),
            array('name' => 'CB Scheme', 'org' => 'IECEE', 'valid' => '2027'),
        ));

        // ---- Quality Parameters ----
        $standards = erdu_page_field('quality_params', array(
            array('param' => __('Aging Test', 'erdu-wp'), 'value' => __('48 hours', 'erdu-wp')),
            array('param' => __('Lifespan (L70)', 'erdu-wp'), 'value' => __('50,000 hrs', 'erdu-wp')),
            array('param' => __('Color Consistency', 'erdu-wp'), 'value' => __('SDCM ≤ 3', 'erdu-wp')),
            array('param' => __('Surge Protection', 'erdu-wp'), 'value' => __('4kV (standard) / 6kV', 'erdu-wp')),
            array('param' => __('Operating Temp', 'erdu-wp'), 'value' => __('-20°C ~ +45°C', 'erdu-wp')),
            array('param' => __('IP Rating', 'erdu-wp'), 'value' => __('IP20 (IP44 optional)', 'erdu-wp')),
        ));
        ?>

        <!-- Hero -->
        <section class="relative py-20" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-blue-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
                <?php if ($hero_btn || $hero_btn2) : ?>
                    <div class="flex flex-wrap gap-4 justify-center mt-8">
                        <?php if ($hero_btn && $hero_btn_link) : ?>
                            <a href="<?php echo esc_url($hero_btn_link); ?>" class="px-6 py-3 font-semibold rounded-lg text-white transition-colors" style="background-color: #F37021;"><?php echo esc_html($hero_btn); ?></a>
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
            <div class="erdu-container">
                <div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Quality Intro -->
        <?php if ($quality_intro) : ?>
        <section class="py-8 bg-white">
            <div class="erdu-container">
                <div class="prose max-w-none"><?php echo wp_kses_post($quality_intro); ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- 5-Step Process -->
        <section class="py-16" style="background-color: #F9FAFB;">
            <div class="erdu-container">
                <h2 class="erdu-h2 mb-12 text-center"><?php _e('5-Step Quality Control Process', 'erdu-wp'); ?></h2>
                <div class="grid md:grid-cols-5 gap-4">
                    <?php foreach ($quality_steps as $i => $s) : ?>
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: #EFF6FF;">
                                <svg class="w-8 h-8" style="color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($s['icon']); ?>"/></svg>
                            </div>
                            <div class="text-sm font-bold mb-1" style="color: #F37021;">STEP <?php echo intval($i + 1); ?></div>
                            <h4 class="font-semibold text-sm mb-1" style="color: #333;"><?php echo esc_html($s['title']); ?></h4>
                            <p class="text-xs text-gray-500"><?php echo esc_html($s['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($process) : ?>
                    <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($process as $step) : ?>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <span class="text-xs font-bold" style="color: #F37021;">#<?php echo esc_html($step['step']); ?></span>
                                <h4 class="font-semibold text-sm mt-1" style="color: #333;"><?php echo esc_html($step['title']); ?></h4>
                                <?php if (!empty($step['description'])) : ?>
                                    <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($step['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Certifications -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <h2 class="erdu-h2 mb-8 text-center"><?php _e('Certifications', 'erdu-wp'); ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    <?php foreach ($certificates as $c) : ?>
                        <div class="p-4 rounded-lg border border-gray-200 flex items-center gap-3 hover:shadow-md transition-shadow">
                            <svg class="w-10 h-10 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <div>
                                <h4 class="font-semibold text-sm" style="color: #333;"><?php echo esc_html($c['name']); ?></h4>
                                <p class="text-xs text-gray-500"><?php echo esc_html($c['org']); ?></p>
                                <?php if (!empty($c['valid'])) : ?>
                                    <p class="text-xs" style="color: #F37021;"><?php printf(__('Valid until %s', 'erdu-wp'), esc_html($c['valid'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Standards Table -->
        <section class="py-16" style="background-color: #F9FAFB;">
            <div class="erdu-container max-w-3xl">
                <h2 class="erdu-h2 mb-8 text-center"><?php _e('Quality Parameters', 'erdu-wp'); ?></h2>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead><tr style="background-color: #F9FAFB;"><th class="text-left p-4 font-semibold" style="color: #333;"><?php _e('Parameter', 'erdu-wp'); ?></th><th class="text-right p-4 font-semibold" style="color: #333;"><?php _e('Standard', 'erdu-wp'); ?></th></tr></thead>
                        <tbody>
                            <?php foreach ($standards as $i => $s) : ?>
                                <tr class="<?php echo $i % 2 === 0 ? 'bg-white' : ''; ?> border-t border-gray-100">
                                    <td class="p-4 text-gray-600"><?php echo esc_html($s['param']); ?></td>
                                    <td class="p-4 text-right font-medium" style="color: #F37021;"><?php echo esc_html($s['value']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA (independent page field — NOT from Page Settings) ----
$cta_override = erdu_page_field('quality_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('quality_cta_title', __('Want Quality Products?', 'erdu-wp')),
        erdu_page_field('quality_cta_button', __('Contact Us', 'erdu-wp')),
        erdu_page_field('quality_cta_link', erdu_get_page_url('contact'))
    );
} else {
    erdu_cta_section(__('Want Quality Products?', 'erdu-wp'), __('Contact Us', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
