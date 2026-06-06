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

        // ---- Hero ----
        $hero_title    = erdu_page_field('quality_hero_title', __('Quality First — Every Light, Tested and Trusted', 'erdu-wp'));
        $hero_subtitle = erdu_page_field('quality_hero_subtitle', __("From raw material inspection to final packaging, ERDU's quality assurance system ensures every product meets international standards.", 'erdu-wp'));
        $hero_bg       = erdu_page_field('quality_hero_bg', 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=1200');

        // ---- Quality Introduction ----
        $quality_intro_quote = erdu_page_field('quality_intro_quote', __('"At ERDU, quality is not a department — it is a mindset embedded in every process."', 'erdu-wp'));
        $quality_intro_desc  = erdu_page_field('quality_intro_desc', __('We partner with industry-leading component suppliers (Sanan, Aishi, Lifud) and enforce rigorous testing protocols to deliver lighting products that perform reliably for 50,000+ hours.', 'erdu-wp'));

        // ---- 5-Step QC Process ----
        $quality_steps = erdu_page_field('quality_steps', array(
            array('num' => '1', 'title' => __('Incoming Material Inspection', 'erdu-wp'), 'description' => __('LED chips, drivers, aluminum housings, and all components undergo 100% incoming quality inspection. Sample testing for LED bins, driver output, and aluminum composition.', 'erdu-wp')),
            array('num' => '2', 'title' => __('In-Process Quality Control', 'erdu-wp'), 'description' => __('Real-time monitoring during SMT, soldering, assembly, and testing stages. IPQC inspectors patrol every production line hourly.', 'erdu-wp')),
            array('num' => '3', 'title' => __('100% Aging Test', 'erdu-wp'), 'description' => __('Every single product undergoes 48-hour continuous burn-in testing at 45°C ambient temperature to detect early failures.', 'erdu-wp')),
            array('num' => '4', 'title' => __('Photometric Testing', 'erdu-wp'), 'description' => __('Integrating sphere measures luminous flux, color temperature, CRI, and power factor. Tolerance: ±5% on flux, ±150K on CCT.', 'erdu-wp')),
            array('num' => '5', 'title' => __('Final Inspection & Packaging', 'erdu-wp'), 'description' => __('Visual inspection for cosmetic defects, function verification, label accuracy check, and protective packaging verification.', 'erdu-wp')),
        ));

        // ---- Testing Equipment ----
        $equipment = erdu_page_field('quality_equipment', array(
            array('name' => __('Integrating Sphere', 'erdu-wp'), 'desc' => __('Luminous flux, CCT, CRI measurement', 'erdu-wp'), 'model' => 'EVERFINE HAAS-2000'),
            array('name' => __('Aging Test Rack', 'erdu-wp'), 'desc' => __('48-hour continuous burn-in test', 'erdu-wp'), 'model' => __('Custom 256-channel', 'erdu-wp')),
            array('name' => __('High Voltage Tester', 'erdu-wp'), 'desc' => __('Dielectric strength test', 'erdu-wp'), 'model' => 'Chroma 19052'),
            array('name' => __('Insulation Resistance Tester', 'erdu-wp'), 'desc' => __('IR measurement', 'erdu-wp'), 'model' => 'Chroma 19073'),
            array('name' => __('LCR Meter', 'erdu-wp'), 'desc' => __('Component level testing', 'erdu-wp'), 'model' => 'Keysight E4980A'),
            array('name' => __('Oscilloscope', 'erdu-wp'), 'desc' => __('Driver waveform analysis', 'erdu-wp'), 'model' => 'Rigol DS1054Z'),
        ));

        // ---- Certifications ----
        $certificates = erdu_page_field('quality_certs', array(
            array('name' => 'CE (LVD/EMC)', 'org' => 'TUV SUD · International', 'valid' => 'Valid until 2026-12'),
            array('name' => 'RoHS 2.0', 'org' => 'SGS · International', 'valid' => 'Valid until 2026-06'),
            array('name' => 'ERP (EU) 2019/2020', 'org' => 'TUV · International', 'valid' => 'Valid until 2026-09'),
            array('name' => 'ISO 9001:2015', 'org' => 'TUV · Quality', 'valid' => 'Valid until 2027-03'),
            array('name' => 'ETL / cETL', 'org' => 'Intertek · North America', 'valid' => 'Valid until 2026-11'),
            array('name' => 'REACH', 'org' => 'SGS · Environmental', 'valid' => 'Valid until 2026-08'),
        ));

        // ---- Quality Parameters ----
        $standards = erdu_page_field('quality_params', array(
            array('param' => __('LED Chip Brand', 'erdu-wp'), 'value' => 'Sanan / Samsung / Bridgelux (optional)'),
            array('param' => __('Color Rendering Index', 'erdu-wp'), 'value' => 'Ra ≥ 80 (standard), Ra ≥ 90+ (optional)'),
            array('param' => __('Color Temperature Tolerance', 'erdu-wp'), 'value' => '±150K'),
            array('param' => __('Luminous Efficacy', 'erdu-wp'), 'value' => '≥ 100 lm/W'),
            array('param' => __('Power Factor', 'erdu-wp'), 'value' => '≥ 0.9'),
            array('param' => __('THD (Total Harmonic Distortion)', 'erdu-wp'), 'value' => '< 20%'),
            array('param' => __('Surge Protection', 'erdu-wp'), 'value' => '2kV standard, 4kV optional'),
            array('param' => __('IP Rating', 'erdu-wp'), 'value' => 'IP20 standard, IP44 optional'),
            array('param' => __('Lifespan (L70)', 'erdu-wp'), 'value' => '50,000 hours'),
            array('param' => __('Warranty', 'erdu-wp'), 'value' => '3 years standard, 5 years optional'),
        ));

        // ---- Supply Chain Partners ----
        $partners = erdu_page_field('quality_partners', array(
            array('name' => 'Sanan Optoelectronics', 'role' => 'LED Chip', 'desc' => "China's largest LED chip manufacturer"),
            array('name' => 'Samsung LED', 'role' => 'LED Chip', 'desc' => 'Premium LED chips for high-end series'),
            array('name' => 'Aishi', 'role' => 'Capacitor', 'desc' => "China's No.1 capacitor brand"),
            array('name' => 'Lifud', 'role' => 'Driver', 'desc' => 'Leading LED driver supplier'),
            array('name' => 'Tridonic', 'role' => 'Driver', 'desc' => 'European standard drivers (optional)'),
        ));
        ?>

        <!-- Hero -->
        <section class="relative py-20 bg-gradient-to-r from-[#2D1810] to-[#4A2510]">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-orange-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
            </div>
        </section>

        <!-- Quality Intro -->
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-4xl text-center">
                <p class="text-xl md:text-2xl font-medium text-[#333] leading-relaxed"><?php echo esc_html($quality_intro_quote); ?></p>
                <p class="text-gray-600 mt-4"><?php echo esc_html($quality_intro_desc); ?></p>
            </div>
        </section>

        <!-- 5-Step Quality Control Process -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <h2 class="text-2xl font-bold text-[#333] mb-10 text-center"><?php _e('5-Step Quality Control Process', 'erdu-wp'); ?></h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <?php foreach ($quality_steps as $i => $s) : ?>
                        <div class="flex items-center gap-4">
                            <div class="w-56 bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow">
                                <div class="w-10 h-10 bg-[#F37021] rounded-full flex items-center justify-center text-white font-bold mb-3"><?php echo esc_html($s['num']); ?></div>
                                <h3 class="font-semibold text-[#333] text-sm mb-2"><?php echo esc_html($s['title']); ?></h3>
                                <p class="text-xs text-gray-500"><?php echo esc_html($s['description']); ?></p>
                            </div>
                            <?php if ($i < count($quality_steps) - 1) : ?>
                                <svg class="w-6 h-6 text-gray-300 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6"/></svg>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Testing Equipment -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <h2 class="text-2xl font-bold text-[#333] mb-8 text-center"><?php _e('Testing Equipment', 'erdu-wp'); ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($equipment as $e) : ?>
                        <div class="bg-gray-50 rounded-xl p-5 flex items-start gap-4">
                            <svg class="w-8 h-8 text-[#F37021] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-[#333] text-sm"><?php echo esc_html($e['name']); ?></h4>
                                <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($e['desc']); ?></p>
                                <p class="text-xs text-[#F37021] mt-1"><?php echo esc_html($e['model']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Certifications -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <h2 class="text-2xl font-bold text-[#333] mb-8 text-center"><?php _e('Certifications', 'erdu-wp'); ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($certificates as $c) : ?>
                        <div class="bg-white rounded-xl p-5 border border-gray-200 flex items-center gap-4">
                            <svg class="w-10 h-10 text-[#F37021] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-[#333]"><?php echo esc_html($c['name']); ?></h4>
                                <p class="text-xs text-gray-500"><?php echo esc_html($c['org']); ?></p>
                                <p class="text-xs text-green-600 mt-1"><?php echo esc_html($c['valid']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Quality Standard Parameters -->
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-4xl">
                <h2 class="text-2xl font-bold text-[#333] mb-8 text-center"><?php _e('Quality Standard Parameters', 'erdu-wp'); ?></h2>
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-[#F37021] text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium"><?php _e('Parameter', 'erdu-wp'); ?></th>
                                <th class="px-4 py-3 text-left font-medium"><?php _e('ERDU Standard', 'erdu-wp'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($standards as $i => $s) : ?>
                                <tr class="<?php echo $i % 2 === 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                    <td class="px-4 py-3 font-medium text-[#333]"><?php echo esc_html($s['param']); ?></td>
                                    <td class="px-4 py-3 text-gray-600"><?php echo esc_html($s['value']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Supply Chain Partners -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <h2 class="text-2xl font-bold text-[#333] mb-4 text-center"><?php _e('Supply Chain Partners', 'erdu-wp'); ?></h2>
                <p class="text-center text-gray-500 mb-8 max-w-2xl mx-auto"><?php _e('We only partner with Tier-1 component suppliers who share our commitment to excellence.', 'erdu-wp'); ?></p>
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <?php foreach ($partners as $p) : ?>
                        <div class="bg-white rounded-xl p-5 text-center border border-gray-200">
                            <div class="text-lg font-bold text-gray-400 mb-1"><?php echo esc_html($p['name']); ?></div>
                            <div class="text-xs text-[#F37021] mb-2"><?php echo esc_html($p['role']); ?></div>
                            <div class="text-xs text-gray-500"><?php echo esc_html($p['desc']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA ----
$cta_override = erdu_page_field('quality_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('quality_cta_title', __('Want Products with Proven Quality?', 'erdu-wp')),
        erdu_page_field('quality_cta_button', __('Request Quality Documentation', 'erdu-wp')),
        erdu_page_field('quality_cta_link', erdu_get_page_url('contact'))
    );
} else {
    erdu_cta_section(__('Want Products with Proven Quality?', 'erdu-wp'), __('Request Quality Documentation', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
