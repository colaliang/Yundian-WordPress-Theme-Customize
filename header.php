<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>

    <?php
    // Google Analytics
    $ga_id = erdu_module_config('analytics', 'ga_id', '');
    if (!empty($ga_id) && erdu_module_enabled('analytics')) : ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga_id); ?>');
    </script>
    <?php endif; ?>

    <?php
    // Google Tag Manager
    $gtm_id = erdu_module_config('analytics', 'gtm_id', '');
    if (!empty($gtm_id) && erdu_module_enabled('analytics')) : ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');</script>
    <?php endif; ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// GTM noscript
$gtm_id = erdu_module_config('analytics', 'gtm_id', '');
if (!empty($gtm_id) && erdu_module_enabled('analytics')) : ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>

<!-- Header -->
<header class="erdu-header">
    <?php do_action('erdu_above_header'); ?>

    <div class="erdu-container">
        <div class="flex items-center justify-between">
            <?php do_action('erdu_primary_header'); ?>
        </div>
    </div>

    <?php do_action('erdu_below_header'); ?>
    <?php do_action('erdu_after_header'); ?>
</header>

<main id="primary" class="site-main">
