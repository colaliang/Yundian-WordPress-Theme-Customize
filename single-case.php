<?php
/**
 * Case Study Single Template
 *
 * @package ERDU_Lighting
 */

get_header();

// Get ACF fields
$client     = erdu_get_option('case_client', __('Confidential Client', 'erdu-wp'));
$location   = erdu_get_option('case_location', '');
$area       = erdu_get_option('case_area', '');
$date       = erdu_get_option('case_date', '');
$challenge  = erdu_get_option('case_challenge', '');
$solution   = erdu_get_option('case_solution', '');
$result     = erdu_get_option('case_result', '');
$before     = erdu_get_option('case_before', '');
$after      = erdu_get_option('case_after', '');
$metrics    = erdu_normalize_metrics(erdu_get_option('case_metrics', array()));
$products   = erdu_normalize_products(erdu_get_option('case_products', array()));
$rating     = erdu_get_option('case_rating', 5);
$testimonial = erdu_get_option('case_testimonial', '');
$person     = erdu_get_option('case_person', '');
$title      = erdu_get_option('case_title', '');

$industry = get_the_terms(get_the_ID(), 'erdu_case_industry');
$ind_label = $industry ? $industry[0]->name : __('Commercial', 'erdu-wp');
$hero_img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: erdu_placeholder(1200, 500);
?>

<!-- Case Hero -->
<section class="relative py-20" style="background: linear-gradient(135deg, #2D1810 0%, #4A2510 100%);">
    <div class="absolute inset-0 opacity-30" style="background-image: url('<?php echo esc_url($hero_img); ?>'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(45,24,16,0.7) 0%, rgba(45,24,16,0.95) 100%);"></div>
    <div class="relative erdu-container">
        <?php erdu_breadcrumb(); ?>
        <div class="max-w-3xl">
            <span class="inline-block px-3 py-1 text-xs font-medium text-white rounded-full mb-4" style="background-color: #F37021;">
                <?php echo esc_html($ind_label); ?>
            </span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                <?php the_title(); ?>
            </h1>
            <?php if ($client) : ?>
                <p class="text-lg text-gray-300 mb-6">
                    <?php printf(__('Client: %s', 'erdu-wp'), esc_html($client)); ?>
                </p>
            <?php endif; ?>
            <div class="flex flex-wrap gap-6 text-sm text-gray-400">
                <?php if ($location) : ?>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <?php echo esc_html($location); ?>
                    </span>
                <?php endif; ?>
                <?php if ($area) : ?>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <?php echo esc_html($area); ?>m²
                    </span>
                <?php endif; ?>
                <?php if ($date) : ?>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <?php printf(__('Completed: %s', 'erdu-wp'), esc_html($date)); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Key Metrics -->
<?php if ($metrics && is_array($metrics) && count($metrics) > 0) : ?>
<section class="py-12" style="background-color: #F9FAFB;">
    <div class="erdu-container">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach ($metrics as $metric) : ?>
                <div class="text-center p-6 bg-white rounded-xl border border-gray-100">
                    <div class="text-3xl md:text-4xl font-bold mb-1" style="color: #F37021;">
                        <?php echo esc_html($metric['metric_value']); ?>
                    </div>
                    <div class="text-sm text-gray-500">
                        <?php echo esc_html($metric['metric_label']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Challenge / Solution / Result -->
<section class="py-16">
    <div class="erdu-container">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Challenge -->
            <div class="erdu-card p-8 border-t-4" style="border-color: #EF4444;">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #FEF2F2;">
                        <svg class="w-5 h-5" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold" style="color: #333;"><?php _e('Challenge', 'erdu-wp'); ?></h3>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo esc_html($challenge ?: __('The client faced significant lighting challenges that needed innovative solutions to meet their specific requirements.', 'erdu-wp')); ?>
                </p>
            </div>

            <!-- Solution -->
            <div class="erdu-card p-8 border-t-4" style="border-color: #F37021;">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #FFF5ED;">
                        <svg class="w-5 h-5" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold" style="color: #333;"><?php _e('Solution', 'erdu-wp'); ?></h3>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo esc_html($solution ?: __('ERDU provided a comprehensive 48V magnetic track lighting system tailored to the project needs.', 'erdu-wp')); ?>
                </p>
            </div>

            <!-- Result -->
            <div class="erdu-card p-8 border-t-4" style="border-color: #10B981;">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #ECFDF5;">
                        <svg class="w-5 h-5" style="color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold" style="color: #333;"><?php _e('Result', 'erdu-wp'); ?></h3>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo esc_html($result ?: __('The project achieved outstanding results with significant energy savings and improved lighting quality.', 'erdu-wp')); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Before / After -->
<?php if ($before || $after) : ?>
<section class="py-16" style="background-color: #F9FAFB;">
    <div class="erdu-container">
        <div class="text-center mb-10">
            <h2 class="erdu-h2"><?php _e('Transformation', 'erdu-wp'); ?></h2>
            <p class="text-gray-500 mt-2"><?php _e('See the difference our lighting solution made', 'erdu-wp'); ?></p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <?php if ($before) : ?>
            <div class="rounded-xl overflow-hidden border border-gray-200">
                <div class="p-4 bg-gray-800 text-white text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php _e('Before', 'erdu-wp'); ?>
                </div>
                <img src="<?php echo esc_url($before); ?>" alt="<?php _e('Before', 'erdu-wp'); ?>" class="w-full h-64 md:h-80 object-cover">
            </div>
            <?php endif; ?>
            <?php if ($after) : ?>
            <div class="rounded-xl overflow-hidden border-2" style="border-color: #F37021;">
                <div class="p-4 text-white text-sm font-medium flex items-center gap-2" style="background-color: #F37021;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <?php _e('After - ERDU Solution', 'erdu-wp'); ?>
                </div>
                <img src="<?php echo esc_url($after); ?>" alt="<?php _e('After', 'erdu-wp'); ?>" class="w-full h-64 md:h-80 object-cover">
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Client Testimonial -->
<?php if ($testimonial) : ?>
<section class="py-16">
    <div class="erdu-container">
        <div class="max-w-3xl mx-auto text-center">
            <svg class="w-12 h-12 mx-auto mb-6 opacity-20" style="color: #F37021;" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            <blockquote class="text-xl md:text-2xl italic text-gray-700 leading-relaxed mb-6">
                "<?php echo esc_html($testimonial); ?>"
            </blockquote>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background-color: #F37021;">
                    <?php echo esc_html($person ? substr($person, 0, 1) : 'C'); ?>
                </div>
                <div class="text-left">
                    <?php if ($person) : ?>
                        <div class="font-semibold" style="color: #333;"><?php echo esc_html($person); ?></div>
                    <?php endif; ?>
                    <?php if ($title) : ?>
                        <div class="text-sm text-gray-500"><?php echo esc_html($title); ?>, <?php echo esc_html($client); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($rating) : ?>
                <div class="flex justify-center gap-1 mt-4">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg class="w-5 h-5 <?php echo $i <= $rating ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Products Used -->
<?php if ($products && is_array($products) && count($products) > 0) : ?>
<section class="py-16" style="background-color: #F9FAFB;">
    <div class="erdu-container">
        <div class="text-center mb-10">
            <h2 class="erdu-h2"><?php _e('Products Used', 'erdu-wp'); ?></h2>
            <p class="text-gray-500 mt-2"><?php _e('ERDU lighting products featured in this project', 'erdu-wp'); ?></p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($products as $product) : ?>
                <div class="flex items-center gap-4 p-4 bg-white rounded-lg border border-gray-200">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0" style="background-color: #FFF5ED;">
                        <svg class="w-6 h-6" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div>
                        <div class="font-medium" style="color: #333;"><?php echo esc_html($product['product_name']); ?></div>
                        <span class="text-xs px-2 py-0.5 rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php _e('48V Magnetic', 'erdu-wp'); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Cases -->
<section class="py-16">
    <div class="erdu-container">
        <div class="text-center mb-10">
            <h2 class="erdu-h2"><?php _e('Similar Projects', 'erdu-wp'); ?></h2>
            <p class="text-gray-500 mt-2"><?php _e('Explore more case studies from ERDU Lighting', 'erdu-wp'); ?></p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $related = new WP_Query(array(
                'post_type'      => 'erdu_case',
                'posts_per_page' => 3,
                'post__not_in'   => array(get_the_ID()),
                'orderby'        => 'rand',
            ));
            if ($related->have_posts()) :
                while ($related->have_posts()) : $related->the_post();
                    $rel_ind = get_the_terms(get_the_ID(), 'erdu_case_industry');
                    $rel_ind_label = $rel_ind ? $rel_ind[0]->name : __('Commercial', 'erdu-wp');
                    $rel_img = get_the_post_thumbnail_url(get_the_ID(), 'erdu-card') ?: erdu_placeholder(400, 260);
            ?>
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer" onclick="location.href='<?php the_permalink(); ?>'">
                    <div class="h-44 overflow-hidden">
                        <img src="<?php echo esc_url($rel_img); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                    </div>
                    <div class="p-5">
                        <span class="text-xs px-2 py-1 rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php echo esc_html($rel_ind_label); ?></span>
                        <h3 class="font-semibold mt-2 mb-1" style="color: #333;"><?php the_title(); ?></h3>
                        <span class="text-sm font-medium inline-flex items-center gap-1" style="color: #F37021;"><?php _e('View Case', 'erdu-wp'); ?> →</span>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Demo fallback
                $demo_related = array(
                    array('title' => 'Flagship Store Redesign', 'ind' => __('Retail', 'erdu-wp'), 'img' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400'),
                    array('title' => 'Boutique Hotel Lighting', 'ind' => __('Hospitality', 'erdu-wp'), 'img' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400'),
                    array('title' => 'Corporate HQ Renovation', 'ind' => __('Office', 'erdu-wp'), 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400'),
                );
                foreach ($demo_related as $rc) :
            ?>
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="h-44 overflow-hidden">
                        <img src="<?php echo esc_url($rc['img']); ?>" alt="<?php echo esc_attr($rc['title']); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <span class="text-xs px-2 py-1 rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php echo esc_html($rc['ind']); ?></span>
                        <h3 class="font-semibold mt-2 mb-1" style="color: #333;"><?php echo esc_html($rc['title']); ?></h3>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<?php erdu_cta_section(__('Interested in a Similar Solution?', 'erdu-wp'), __('Discuss Your Project', 'erdu-wp'), erdu_get_page_url('contact'), __('View All Cases', 'erdu-wp'), erdu_get_page_url('cases')); ?>

<?php get_footer(); ?>
