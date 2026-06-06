<?php
/**
 * Template Name: Blog
 *
 * Uses native WordPress Posts (post type: post)
 * with native Categories (taxonomy: category).
 *
 * @package ERDU_Lighting
 */

get_header();

// ---- Category filter from URL (native category) ----
$cat_filter = isset($_GET['blog_cat']) ? sanitize_text_field($_GET['blog_cat']) : '';
$paged = get_query_var('paged') ?: (isset($_GET['blog_page']) ? max(1, intval($_GET['blog_page'])) : 1);

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields) ----
        $hero_title    = erdu_page_field('blog_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('blog_hero_subtitle', __('Insights, tips, and trends in 48V magnetic track lighting technology.', 'erdu-wp'));
        $hero_bg       = erdu_page_field('blog_hero_bg', '');
        $hero_btn      = erdu_page_field('blog_hero_btn', '');
        $hero_btn_link = erdu_page_field('blog_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('blog_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('blog_hero_btn2_link', '');

        // ---- Page Content ----
        $page_content = erdu_page_field('blog_page_editor', '');

        // ---- Introduction ----
        $intro = erdu_page_field('blog_intro', '');

        // ---- Settings ----
        $posts_per_page   = erdu_page_field('blog_count', 9);
        $show_categories  = erdu_page_field('blog_show_categories', true);
        $show_excerpt     = erdu_page_field('blog_show_excerpt', true);
        $show_date        = erdu_page_field('blog_show_date', true);
        $show_author      = erdu_page_field('blog_show_author', true);
        $show_readmore    = erdu_page_field('blog_show_readmore', true);
        $featured_show    = erdu_page_field('blog_featured_show', true);
        $featured_title   = erdu_page_field('blog_featured_title', __('Featured Articles', 'erdu-wp'));
        $featured_count   = erdu_page_field('blog_featured_count', 3);

        // ---- Build query using NATIVE post type ----
        $query_args = array(
            'post_type'      => 'post',          // Native WordPress posts
            'posts_per_page' => intval($posts_per_page),
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'paged'          => $paged,
        );

        if (!empty($cat_filter)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',     // Native WordPress category
                    'field'    => 'slug',
                    'terms'    => $cat_filter,
                ),
            );
        }

        $blog_query = new WP_Query($query_args);

        // ---- Get NATIVE categories for filter ----
        $categories = get_terms(array(
            'taxonomy'   => 'category',
            'hide_empty' => true,
        ));
        ?>

        <!-- Hero -->
        <section class="relative py-20 erdu-bg-dark">
            <?php if ($hero_bg) : ?>
                <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <?php endif; ?>
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

        <!-- Intro -->
        <?php if ($intro) : ?>
        <section class="py-8 bg-white">
            <div class="erdu-container"><div class="prose max-w-none"><?php echo wp_kses_post($intro); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- Featured Posts -->
        <?php if ($featured_show) : 
            $featured_args = array(
                'post_type'      => 'post',          // Native posts
                'posts_per_page' => intval($featured_count),
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            if (!empty($cat_filter)) {
                $featured_args['tax_query'] = $query_args['tax_query'];
            }
            $featured_query = new WP_Query($featured_args);
            if ($featured_query->have_posts() && $paged <= 1) : 
        ?>
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <h2 class="erdu-h2 mb-8"><?php echo esc_html($featured_title); ?></h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <?php $f_idx = 0; while ($featured_query->have_posts() && $f_idx < $featured_count) : $featured_query->the_post(); $f_idx++; ?>
                        <a href="<?php the_permalink(); ?>" class="block group">
                            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow group-hover:shadow-xl">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="h-48 overflow-hidden">
                                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform')); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="p-5">
                                    <?php
                                    $f_cats = get_the_category();
                                    if ($f_cats) : ?>
                                        <span class="text-xs px-2 py-1 rounded-full bg-orange-50 erdu-text-primary"><?php echo esc_html($f_cats[0]->name); ?></span>
                                    <?php endif; ?>
                                    <h3 class="font-semibold mt-2 mb-2 text-gray-800"><?php the_title(); ?></h3>
                                    <?php if ($show_excerpt) : ?><p class="text-sm text-gray-500 line-clamp-2"><?php echo get_the_excerpt(); ?></p><?php endif; ?>
                                    <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                                        <?php if ($show_date) : ?><span><?php echo get_the_date(); ?></span><?php endif; ?>
                                        <?php if ($show_author) : ?><span><?php the_author(); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php endif; endif; ?>

        <!-- Blog Grid + Category Filter -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <!-- Category Filters -->
                <?php if ($show_categories && !empty($categories) && !is_wp_error($categories)) : ?>
                <div class="flex flex-wrap gap-2 mb-8">
                    <a href="<?php echo esc_url(remove_query_arg(array('blog_cat', 'blog_page'))); ?>" class="px-4 py-2 text-sm rounded-full border transition-all <?php echo empty($cat_filter) ? 'text-white border-orange-500 erdu-bg-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-orange-300'; ?>"><?php _e('All', 'erdu-wp'); ?></a>
                    <?php foreach ($categories as $cat) : ?>
                        <a href="<?php echo esc_url(add_query_arg(array('blog_cat' => $cat->slug, 'blog_page' => false))); ?>" class="px-4 py-2 text-sm rounded-full border transition-all <?php echo $cat_filter === $cat->slug ? 'text-white border-orange-500 erdu-bg-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-orange-300'; ?>"><?php echo esc_html($cat->name); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Blog Grid -->
                <?php if ($blog_query->have_posts()) : ?>
                    <div class="grid md:grid-cols-3 gap-6">
                        <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <article class="group">
                                <a href="<?php the_permalink(); ?>" class="block">
                                    <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow group-hover:shadow-xl">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="h-48 overflow-hidden">
                                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform')); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="h-48 flex items-center justify-center" style="background-color: #F9FAFB;">
                                                <svg class="w-12 h-12" style="color: #F37021; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/></svg>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-5">
                                            <?php $post_cats = get_the_category(); if ($post_cats) : ?>
                                                <span class="text-xs px-2 py-1 rounded-full bg-orange-50 erdu-text-primary"><?php echo esc_html($post_cats[0]->name); ?></span>
                                            <?php endif; ?>
                                            <h3 class="font-semibold mt-2 mb-2 text-gray-800"><?php the_title(); ?></h3>
                                            <?php if ($show_excerpt) : ?><p class="text-sm text-gray-500 line-clamp-3"><?php echo get_the_excerpt(); ?></p><?php endif; ?>
                                            <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                                                <?php if ($show_date) : ?><span><?php echo get_the_date(); ?></span><?php endif; ?>
                                                <?php if ($show_author) : ?><span><?php the_author(); ?></span><?php endif; ?>
                                            </div>
                                            <?php if ($show_readmore) : ?>
                                                <span class="text-sm font-medium mt-3 inline-block erdu-text-primary"><?php _e('Read More', 'erdu-wp'); ?> &rarr;</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($blog_query->max_num_pages > 1) : ?>
                    <div class="flex justify-center gap-2 mt-12">
                        <?php
                        $big = 999999999;
                        $current = max(1, $paged);
                        echo paginate_links(array(
                            'base'      => str_replace($big, '%#%', esc_url(add_query_arg('blog_page', $big))),
                            'format'    => '',
                            'current'   => $current,
                            'total'     => $blog_query->max_num_pages,
                            'prev_text' => '&larr; ' . __('Prev', 'erdu-wp'),
                            'next_text' => __('Next', 'erdu-wp') . ' &rarr;',
                            'mid_size'  => 2,
                            'add_args'  => array('blog_cat' => $cat_filter),
                            'type'      => 'list',
                        ));
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 mx-auto mb-4 erdu-text-primary" style="opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/></svg>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800"><?php _e('No Blog Posts Yet', 'erdu-wp'); ?></h3>
                        <p class="text-gray-500"><?php _e('Blog posts will be published here soon. Check back later!', 'erdu-wp'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA ----
$cta_override = erdu_page_field('blog_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('blog_cta_title', __('Stay Updated with Our Blog', 'erdu-wp')),
        erdu_page_field('blog_cta_button', __('Subscribe', 'erdu-wp')),
        erdu_page_field('blog_cta_link', '')
    );
} else {
    erdu_cta_section(__('Stay Updated with Our Blog', 'erdu-wp'), __('Subscribe', 'erdu-wp'), '#newsletter', __('Contact Us', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
