<?php
/**
 * Blog / News Index Template
 *
 * @package ERDU_Lighting
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'paged'          => $paged,
);
$news = new WP_Query($args);
?>

<!-- Hero -->
<section class="relative py-20 erdu-bg-secondary">
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200'); background-size: cover; background-position: center;"></div>
    <div class="relative erdu-container text-center">
        <?php erdu_breadcrumb(); ?>
        <h1 class="text-3xl md:text-4xl font-bold text-white"><?php _e('News & Insights', 'erdu-wp'); ?></h1>
        <p class="text-gray-300 mt-3 max-w-2xl mx-auto"><?php _e('Stay updated with the latest from ERDU Lighting — product launches, industry trends, and company news.', 'erdu-wp'); ?></p>
    </div>
</section>

<!-- News Grid -->
<section class="py-16">
    <div class="erdu-container">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
                <article class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="h-48 overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('erdu-card'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center bg-orange-50">
                                <svg class="w-12 h-12 erdu-text-primary" style="opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                            <span><?php echo get_the_date('M j, Y'); ?></span>
                            <span>·</span>
                            <span><?php echo get_the_category_list(', '); ?></span>
                        </div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">
                            <a href="<?php the_permalink(); ?>" class="hover:erdu-text-primary transition-colors"><?php the_title(); ?></a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-3"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        <a href="<?php the_permalink(); ?>" class="text-sm font-medium inline-flex items-center gap-1 erdu-text-primary">
                            <?php _e('Read More', 'erdu-wp'); ?> →
                        </a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else : ?>
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/></svg>
                    <p class="text-gray-500"><?php _e('No news articles found. Check back soon for updates.', 'erdu-wp'); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php erdu_pagination_custom($news); ?>
    </div>
</section>

<!-- CTA -->
<?php erdu_cta_section(__('Want Product Updates?', 'erdu-wp'), __('Subscribe to Newsletter', 'erdu-wp'), '#newsletter', __('Contact Us', 'erdu-wp'), erdu_get_page_url('contact')); ?>

<?php get_footer(); ?>
