<?php
/**
 * Single Post Template (Blog Article)
 *
 * Uses native WordPress Posts with Categories and Tags.
 *
 * @package ERDU_Lighting
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        $categories = get_the_category();
        $tags       = get_the_tags();
        $author_name = get_the_author();
        $author_bio  = get_the_author_meta('description');
        ?>

        <!-- Article Hero -->
        <section class="relative py-20 erdu-bg-secondary">
            <?php if (has_post_thumbnail()) : ?>
                <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>'); background-size: cover; background-position: center;"></div>
            <?php endif; ?>
            <div class="relative erdu-container">
                <?php erdu_breadcrumb(); ?>
                <div class="max-w-3xl mx-auto text-center">
                    <?php if ($categories) : ?>
                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            <?php foreach ($categories as $cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($cat)); ?>" class="px-3 py-1 text-xs font-medium rounded-full bg-orange-100 erdu-text-primary">
                                    <?php echo esc_html($cat->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4"><?php the_title(); ?></h1>
                    <div class="flex items-center justify-center gap-4 text-sm text-gray-300">
                        <span><?php the_author(); ?></span>
                        <span>&middot;</span>
                        <span><?php echo get_the_date('F j, Y'); ?></span>
                        <span>&middot;</span>
                        <span><?php printf(__('%s min read', 'erdu-wp'), max(1, ceil(str_word_count(strip_tags(get_the_content())) / 200))); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Article Content with Sidebar -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <div class="grid lg:grid-cols-12 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-8">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="rounded-xl overflow-hidden shadow-lg mb-8">
                                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full">
                            </div>
                        <?php endif; ?>

                        <article class="prose prose-lg max-w-none">
                            <div class="entry-content text-gray-700 leading-relaxed">
                                <?php the_content(); ?>
                            </div>
                        </article>

                        <!-- Tags -->
                        <?php if ($tags) : ?>
                        <div class="mt-10 pt-6 border-t border-gray-200">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm text-gray-500 font-medium"><?php _e('Tags:', 'erdu-wp'); ?></span>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 transition-colors">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Author Box -->
                        <?php if ($author_bio) : ?>
                        <div class="mt-8 p-6 rounded-xl border border-gray-200 bg-gray-50">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0 erdu-bg-primary">
                                    <?php echo esc_html(strtoupper(substr($author_name, 0, 1))); ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800"><?php echo esc_html($author_name); ?></h4>
                                    <p class="text-sm text-gray-500 mt-1"><?php echo esc_html($author_bio); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Share -->
                        <div class="mt-8 flex items-center gap-3">
                            <span class="text-sm text-gray-500"><?php _e('Share:', 'erdu-wp'); ?></span>
                            <?php $share_url = urlencode(get_permalink()); $share_title = urlencode(get_the_title()); ?>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr($share_url); ?>" target="_blank" rel="noopener" class="w-8 h-8 rounded-full flex items-center justify-center text-white" style="background-color: #0077B5;" aria-label="LinkedIn">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($share_url); ?>&text=<?php echo esc_attr($share_title); ?>" target="_blank" rel="noopener" class="w-8 h-8 rounded-full flex items-center justify-center text-white" style="background-color: #1DA1F2;" aria-label="X / Twitter">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                            </a>
                            <a href="mailto:?subject=<?php echo esc_attr($share_title); ?>&body=<?php echo esc_attr($share_url); ?>" class="w-8 h-8 rounded-full flex items-center justify-center text-white erdu-bg-primary" aria-label="Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </a>
                        </div>

                        <!-- Prev / Next -->
                        <div class="mt-8 pt-6 border-t border-gray-100 grid md:grid-cols-2 gap-4">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <span class="text-xs text-gray-400">&larr; <?php _e('Previous', 'erdu-wp'); ?></span>
                                    <h4 class="font-medium text-sm mt-1 line-clamp-2 text-gray-800"><?php echo esc_html(get_the_title($prev_post)); ?></h4>
                                </a>
                            <?php endif; ?>
                            <?php if ($next_post) : ?>
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow md:text-right">
                                    <span class="text-xs text-gray-400"><?php _e('Next', 'erdu-wp'); ?> &rarr;</span>
                                    <h4 class="font-medium text-sm mt-1 line-clamp-2 text-gray-800"><?php echo esc_html(get_the_title($next_post)); ?></h4>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-4 space-y-8">
                        <!-- Categories -->
                        <div class="p-6 rounded-xl border border-gray-200">
                            <h4 class="font-semibold mb-4 text-gray-800"><?php _e('Categories', 'erdu-wp'); ?></h4>
                            <?php
                            $all_cats = get_categories(array('hide_empty' => true));
                            if ($all_cats) : ?>
                                <ul class="space-y-2">
                                    <?php foreach ($all_cats as $c) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_category_link($c)); ?>" class="flex items-center justify-between text-sm text-gray-600 hover:text-orange-500 transition-colors">
                                                <span><?php echo esc_html($c->name); ?></span>
                                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-50"><?php echo intval($c->count); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Recent Posts -->
                        <div class="p-6 rounded-xl border border-gray-200">
                            <h4 class="font-semibold mb-4 text-gray-800"><?php _e('Recent Posts', 'erdu-wp'); ?></h4>
                            <?php
                            $recent = new WP_Query(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 5,
                                'post__not_in'   => array(get_the_ID()),
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            ));
                            if ($recent->have_posts()) : ?>
                                <ul class="space-y-4">
                                    <?php while ($recent->have_posts()) : $recent->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>" class="flex gap-3 group">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0">
                                                        <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h5 class="text-sm font-medium line-clamp-2 group-hover:erdu-text-primary transition-colors text-gray-800"><?php the_title(); ?></h5>
                                                    <span class="text-xs text-gray-400"><?php echo get_the_date(); ?></span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Related by Category -->
                        <?php if ($categories) :
                            $cat_ids = wp_list_pluck($categories, 'term_id');
                            $related = new WP_Query(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post__not_in'   => array(get_the_ID()),
                                'category__in'   => $cat_ids,
                                'orderby'        => 'rand',
                            ));
                            if ($related->have_posts()) : ?>
                            <div class="p-6 rounded-xl border border-gray-200">
                                <h4 class="font-semibold mb-4 text-gray-800"><?php _e('Related Articles', 'erdu-wp'); ?></h4>
                                <div class="space-y-4">
                                    <?php while ($related->have_posts()) : $related->the_post(); ?>
                                        <a href="<?php the_permalink(); ?>" class="block group">
                                            <h5 class="text-sm font-medium line-clamp-2 group-hover:erdu-text-primary transition-colors text-gray-800"><?php the_title(); ?></h5>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                                        </a>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endif; endif; ?>
                    </div>
                </div>
            </div>
        </section>

    <?php
    endwhile;
endif;

get_footer();
