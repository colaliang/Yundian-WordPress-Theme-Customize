<?php
/**
 * Footer Latest News Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Footer_News {
    public static function render($settings) {
        if (!isset($settings['footer_news_show']) || !$settings['footer_news_show']) {
            return;
        }
        ?>
        <div>
            <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($settings['heading_color']); ?>;"><?php esc_html_e('Latest News', 'erdu-wp'); ?></h4>
            <ul class="space-y-3 text-sm">
                <?php
                $recent_news = new WP_Query(array(
                    'post_type'      => array('post', 'erdu_news'),
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));
                
                if ($recent_news->have_posts()) :
                    while ($recent_news->have_posts()) : $recent_news->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" class="group block transition-colors" style="color: <?php echo esc_attr($settings['text_color']); ?>;" onmouseover="this.style.color='<?php echo esc_attr($settings['hover_color']); ?>'" onmouseout="this.style.color='<?php echo esc_attr($settings['text_color']); ?>'">
                                <span class="line-clamp-2 leading-snug hover:underline"><?php the_title(); ?></span>
                                <span class="text-xs opacity-70 mt-1 block"><?php echo get_the_date(); ?></span>
                            </a>
                        </li>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <li><span style="color: <?php echo esc_attr($settings['text_color']); ?>;"><?php esc_html_e('No news available yet.', 'erdu-wp'); ?></span></li>
                    <?php
                endif;
                ?>
            </ul>
        </div>
        <?php
    }
}
