<?php
/**
 * Default Page Template
 *
 * @package ERDU_Lighting
 */

get_header();
?>

<!-- Page Hero -->
<section class="relative py-20 erdu-bg-secondary">
    <div class="relative erdu-container text-center">
        <?php erdu_breadcrumb(); ?>
        <h1 class="text-3xl md:text-4xl font-bold text-white"><?php the_title(); ?></h1>
    </div>
</section>

<!-- Page Content -->
<section class="py-16">
    <div class="erdu-container">
        <div class="max-w-4xl mx-auto">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="prose prose-lg max-w-none">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-8 rounded-xl overflow-hidden">
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full">
                        </div>
                    <?php endif; ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
