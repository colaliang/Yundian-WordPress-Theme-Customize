</main><!-- #primary -->

<?php do_action('erdu_above_footer'); ?>

<footer class="erdu-footer" style="background-color: <?php echo esc_attr(Erdu_Builder_Footer::get_instance()->get_bg_color()); ?>;">
    <div class="erdu-container py-12">
        <?php do_action('erdu_primary_footer'); ?>
    </div>
    
    <?php do_action('erdu_below_footer'); ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>