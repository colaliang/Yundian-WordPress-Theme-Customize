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
<header class="erdu-header sticky top-0 z-50 bg-white shadow-sm">
    <div class="erdu-container">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="w-8 h-8 rounded-sm flex items-center justify-center" style="background-color: #F37021;">
                        <span class="text-white font-bold text-sm">E</span>
                    </div>
                    <span class="text-xl font-bold" style="color: #333;">ERDU</span>
                    <span class="hidden sm:inline text-xs text-gray-500 ml-1">LIGHTING</span>
                <?php endif; ?>
            </a>

            <!-- Desktop Navigation - WordPress Menu -->
            <nav class="hidden lg:flex items-center gap-1" id="erdu-desktop-nav">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'items_wrap'      => '%3$s',
                        'depth'           => 1,
                        'walker'          => new ERDU_Walker_Nav_Menu(),
                        'fallback_cb'     => false,
                    ));
                } else {
                    // Fallback: display links to theme pages
                    $fallback_items = array(
                        array('label' => __('Home', 'erdu-wp'), 'url' => home_url('/')),
                        array('label' => __('About Us', 'erdu-wp'), 'url' => erdu_get_page_url('about')),
                        array('label' => __('Products', 'erdu-wp'), 'url' => erdu_get_page_url('products')),
                        array('label' => __('Solutions', 'erdu-wp'), 'url' => erdu_get_page_url('solutions')),
                        array('label' => __('Quality', 'erdu-wp'), 'url' => erdu_get_page_url('quality')),
                        array('label' => __('Distributor', 'erdu-wp'), 'url' => erdu_get_page_url('distributor')),
                        array('label' => __('Case Studies', 'erdu-wp'), 'url' => erdu_get_page_url('cases')),
                        array('label' => __('News', 'erdu-wp'), 'url' => erdu_get_page_url('news')),
                        array('label' => __('Blog', 'erdu-wp'), 'url' => erdu_get_page_url('blog')),
                        array('label' => __('Contact', 'erdu-wp'), 'url' => erdu_get_page_url('contact')),
                    );
                    foreach ($fallback_items as $item) {
                        $is_active = erdu_is_current_page($item['url']);
                        printf(
                            '<a href="%s" class="erdu-nav-link %s">%s</a>',
                            esc_url($item['url']),
                            $is_active ? 'active' : '',
                            esc_html($item['label'])
                        );
                    }
                }
                ?>
            </nav>

            <!-- Language Switcher + Mobile Toggle -->
            <div class="flex items-center gap-3">
                <span class="hidden md:inline text-xs text-gray-400">EN / CN</span>
                <button class="lg:hidden p-2 rounded-md hover:bg-gray-100 erdu-mobile-toggle"
                        onclick="document.getElementById('mobile-menu').classList.toggle('active')"
                        aria-label="<?php _e('Toggle menu', 'erdu-wp'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="erdu-mobile-menu lg:hidden bg-white border-t border-gray-100">
        <div class="erdu-container py-3 space-y-1">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'items_wrap'      => '%3$s',
                    'depth'           => 1,
                    'walker'          => new ERDU_Walker_Mobile_Menu(),
                    'fallback_cb'     => false,
                ));
            } else {
                $fallback_items = array(
                    array('label' => __('Home', 'erdu-wp'), 'url' => home_url('/')),
                    array('label' => __('About Us', 'erdu-wp'), 'url' => erdu_get_page_url('about')),
                    array('label' => __('Products', 'erdu-wp'), 'url' => erdu_get_page_url('products')),
                    array('label' => __('Solutions', 'erdu-wp'), 'url' => erdu_get_page_url('solutions')),
                    array('label' => __('Quality', 'erdu-wp'), 'url' => erdu_get_page_url('quality')),
                    array('label' => __('Distributor', 'erdu-wp'), 'url' => erdu_get_page_url('distributor')),
                    array('label' => __('Case Studies', 'erdu-wp'), 'url' => erdu_get_page_url('cases')),
                    array('label' => __('News', 'erdu-wp'), 'url' => erdu_get_page_url('news')),
                    array('label' => __('Contact', 'erdu-wp'), 'url' => erdu_get_page_url('contact')),
                );
                foreach ($fallback_items as $item) {
                    $is_active = erdu_is_current_page($item['url']);
                    $class = $is_active ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:bg-gray-50';
                    printf(
                        '<a href="%s" class="block px-3 py-2 text-sm font-medium rounded-md %s">%s</a>',
                        esc_url($item['url']),
                        esc_attr($class),
                        esc_html($item['label'])
                    );
                }
            }
            ?>
        </div>
    </div>
</header>

<main id="primary" class="site-main">
