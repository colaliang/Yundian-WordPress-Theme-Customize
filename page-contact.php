<?php
/**
 * Template Name: Contact Us
 *
 * @package ERDU_Lighting
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero ----
        $hero_title    = erdu_page_field('contact_hero_title', __('Contact ERDU Lighting — We\'re Here to Light Up Your Project', 'erdu-wp'));
        $hero_subtitle = erdu_page_field('contact_hero_subtitle', '');
        $hero_bg       = erdu_page_field('contact_hero_bg', '');
        $hero_btn      = erdu_page_field('contact_hero_btn', '');
        $hero_btn_link = erdu_page_field('contact_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('contact_hero_btn2', '');
        $hero_btn2_link= erdu_page_field('contact_hero_btn2_link', '');

        // ---- Page Content ----
        $page_content = erdu_page_field('contact_page_editor', '');

        // ---- Intro ----
        $intro = erdu_page_field('contact_intro', '');

        // ---- Contact Info ----
        $info_title = erdu_page_field('contact_info_title', __('Contact Information', 'erdu-wp'));
        $phone      = erdu_page_field('contact_phone', '+86-760-22380830');
        $mobile     = erdu_page_field('contact_mobile', '+86-18938760626 / +86-13726005031');
        $email_addr = erdu_page_field('contact_email', 'gg@erduled.com');
        $address    = erdu_page_field('contact_address', "6th Floor, JinYe Building\nTongyi Industrial District, Guzhen, Zhongshan\nGuangdong, China");
        $hours      = erdu_page_field('contact_hours', __('Mon-Fri 9:00-18:00 CST', 'erdu-wp'));

        // ---- Contact Persons ----
        $persons = erdu_page_field('contact_persons', array(
            array('name' => 'David Deng', 'title' => 'Sales Manager', 'email' => 'david@erduled.com', 'phone' => '', 'initial' => 'D'),
            array('name' => 'Eileen Zhang', 'title' => 'Export Director', 'email' => 'eileen@erduled.com', 'phone' => '', 'initial' => 'E'),
        ));

        // ---- Social / Messaging ----
        $social_label = erdu_page_field('contact_social_label', __('Connect With Us', 'erdu-wp'));
        $whatsapp     = erdu_page_field('contact_whatsapp', '');
        $wechat       = erdu_page_field('contact_wechat', '');

        // ---- Map ----
        $map_embed = erdu_page_field('contact_map_embed', '');
        $map_image = erdu_page_field('contact_map_image', '');

        // ---- FAQ ----
        $faqs = erdu_page_field('contact_faq', array(
            array('question' => __('What is the MOQ for your products?', 'erdu-wp'), 'answer' => __('Our standard MOQ is 50 pieces per model for existing products. For custom projects, MOQ varies depending on specifications. We also offer sample orders for quality evaluation.', 'erdu-wp')),
            array('question' => __('What is the typical lead time?', 'erdu-wp'), 'answer' => __('Sample orders: 3-5 business days. Bulk orders: 15-25 business days depending on quantity. Custom products: 30-45 days after design confirmation.', 'erdu-wp')),
            array('question' => __('What payment methods do you accept?', 'erdu-wp'), 'answer' => __('We accept T/T (Telegraphic Transfer), L/C at sight for large orders, and Western Union for sample orders. Payment terms can be negotiated for long-term partners.', 'erdu-wp')),
            array('question' => __('Do you provide OEM/ODM services?', 'erdu-wp'), 'answer' => __('Yes, we offer both OEM and ODM services. Our engineering team can customize products according to your specifications, including branding, packaging, and technical parameters.', 'erdu-wp')),
            array('question' => __('What certifications do your products have?', 'erdu-wp'), 'answer' => __('Our products are certified with CE, RoHS, ISO9001, ETL, and SAA. We can also assist with additional certifications required for specific markets.', 'erdu-wp')),
        ));

        // Form processing status
        $form_success = isset($_GET['contact_success']);
        $form_error   = isset($_GET['contact_error']) ? sanitize_text_field(wp_unslash($_GET['contact_error'])) : '';
        ?>

        <!-- ====== HERO ====== -->
        <section class="relative py-20 erdu-bg-secondary">
            <?php if ($hero_bg) : ?>
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <?php endif; ?>
            <div class="relative erdu-container">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white mt-4"><?php echo esc_html($hero_title); ?></h1>
                <?php if ($hero_subtitle) : ?><p class="text-orange-100 mt-4 max-w-2xl"><?php echo esc_html($hero_subtitle); ?></p><?php endif; ?>
                <div class="flex flex-wrap gap-4 mt-8">
                    <?php if ($hero_btn && $hero_btn_link) : ?>
                        <a href="<?php echo esc_url($hero_btn_link); ?>" class="erdu-btn erdu-btn-primary"><?php echo esc_html($hero_btn); ?><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    <?php endif; ?>
                    <?php if ($hero_btn2 && $hero_btn2_link) : ?>
                        <a href="<?php echo esc_url($hero_btn2_link); ?>" class="erdu-btn erdu-btn-outline"><?php echo esc_html($hero_btn2); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ====== PAGE CONTENT ====== -->
        <?php if ($page_content) : ?>
        <section class="py-12 bg-white border-b border-gray-100">
            <div class="erdu-container"><div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- ====== INTRO ====== -->
        <?php if ($intro) : ?>
        <section class="py-12 bg-white">
            <div class="erdu-container">
                <div class="prose max-w-none"><?php echo wp_kses_post($intro); ?></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====== CONTACT INFO & FORM ====== -->
        <section class="py-16 bg-white">
            <div class="erdu-container">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Left: Contact Info (1 col) -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-bold text-[#333]"><?php echo esc_html($info_title); ?></h2>

                        <!-- Tel -->
                        <?php if ($phone) : ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0 erdu-bg-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php _e('Tel', 'erdu-wp'); ?></p>
                                <p class="text-sm font-medium text-[#333]"><?php echo esc_html($phone); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Mobile -->
                        <?php if ($mobile) : ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0 erdu-bg-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php _e('Mobile', 'erdu-wp'); ?></p>
                                <p class="text-sm font-medium text-[#333]"><?php echo esc_html($mobile); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Email -->
                        <?php if ($email_addr) : ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0 erdu-bg-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php _e('Email', 'erdu-wp'); ?></p>
                                <p class="text-sm font-medium text-[#333]"><?php echo esc_html($email_addr); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Address -->
                        <?php if ($address) : ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0 erdu-bg-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php _e('Address', 'erdu-wp'); ?></p>
                                <p class="text-sm font-medium text-[#333] leading-relaxed"><?php echo nl2br(esc_html($address)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Working Hours -->
                        <?php if ($hours) : ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shrink-0 erdu-bg-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php _e('Working Hours', 'erdu-wp'); ?></p>
                                <p class="text-sm font-medium text-[#333]"><?php echo esc_html($hours); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Contact Persons -->
                        <?php if ($persons) : ?>
                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="font-semibold text-sm mb-3 text-[#333]"><?php _e('Contact Persons', 'erdu-wp'); ?></h3>
                            <div class="space-y-2">
                                <?php foreach ($persons as $p) :
                                    $initial = !empty($p['initial']) ? $p['initial'] : strtoupper(substr($p['name'], 0, 1));
                                ?>
                                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold shrink-0 erdu-bg-primary"><?php echo esc_html($initial); ?></div>
                                    <div>
                                        <div class="text-sm font-medium text-[#333]"><?php echo esc_html($p['name']); ?> <?php if (!empty($p['title'])) : ?>&mdash; <?php echo esc_html($p['title']); ?><?php endif; ?></div>
                                        <?php if (!empty($p['email'])) : ?><div class="text-xs text-gray-500"><?php echo esc_html($p['email']); ?></div><?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Connect With Us -->
                        <?php if ($whatsapp || $wechat) : ?>
                        <div class="pt-4">
                            <h3 class="font-semibold text-sm mb-3 text-[#333]"><?php echo esc_html($social_label); ?></h3>
                            <div class="flex gap-3">
                                <?php if ($whatsapp) : ?>
                                <a href="<?php echo esc_url(strpos($whatsapp, 'http') === 0 ? $whatsapp : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener" class="px-4 py-2 bg-green-500 text-white text-sm rounded-md flex items-center gap-2 hover:opacity-90 transition-opacity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 17a2 2 0 01-2 2H6.828a2 2 0 00-1.414.586l-2.202 2.202A.71.71 0 012 21.286V5a2 2 0 012-2h16a2 2 0 012 2z"/></svg>
                                    WhatsApp
                                </a>
                                <?php endif; ?>
                                <?php if ($wechat) : ?>
                                <span class="px-4 py-2 bg-[#07C160] text-white text-sm rounded-md flex items-center gap-2 cursor-default">
                                    WeChat
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Form (2 cols) -->
                    <div class="lg:col-span-2">
                        <h2 class="text-xl font-bold mb-6 text-[#333]"><?php _e('Send Us a Message', 'erdu-wp'); ?></h2>

                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <?php if ($form_success) : ?>
                                <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200"><?php _e('Thank you! Your message has been sent successfully. We will get back to you within 24 business hours.', 'erdu-wp'); ?></div>
                            <?php elseif ($form_error) : ?>
                                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                                    <?php
                                    if ($form_error === 'ratelimit') {
                                        _e('Too many submissions. Please try again later.', 'erdu-wp');
                                    } elseif ($form_error === 'email') {
                                        _e('Please enter a valid email address.', 'erdu-wp');
                                    } elseif ($form_error === 'required') {
                                        _e('Please fill in all required fields.', 'erdu-wp');
                                    } else {
                                        _e('Something went wrong. Please try again.', 'erdu-wp');
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-5">
                                <input type="hidden" name="action" value="erdu_contact_form">
                                <?php wp_nonce_field('erdu_contact_action', 'erdu_contact_nonce'); ?>
                                <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

                                <!-- Row 1: Name + Email -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Your Name', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_name" required placeholder="<?php _e('Full name', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Email Address', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="email" name="contact_email" required placeholder="email@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                </div>

                                <!-- Row 2: Phone + Company -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Phone Number', 'erdu-wp'); ?></label>
                                        <input type="tel" name="contact_phone" placeholder="+1 234 567 890" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Company Name', 'erdu-wp'); ?></label>
                                        <input type="text" name="contact_company" placeholder="<?php _e('Company name', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                </div>

                                <!-- Row 3: Country + Subject -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Country', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_country" required placeholder="<?php _e('Your country', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Subject', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_subject" required placeholder="<?php _e('What is this regarding?', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                </div>

                                <!-- Row 4: Interested Product + Quantity -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Interested Product', 'erdu-wp'); ?></label>
                                        <select name="contact_product" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                            <option value=""><?php _e('Select a product', 'erdu-wp'); ?></option>
                                            <option value="48V Magnetic Track Light">48V Magnetic Track Light</option>
                                            <option value="Downlight">Downlight</option>
                                            <option value="Spotlight">Spotlight</option>
                                            <option value="Panel Light">Panel Light</option>
                                            <option value="Track Light">Track Light</option>
                                            <option value="Ceiling Light">Ceiling Light</option>
                                            <option value="Custom/OEM">Custom/OEM</option>
                                            <option value="Multiple Products">Multiple Products</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Estimated Quantity', 'erdu-wp'); ?></label>
                                        <input type="text" name="contact_quantity" placeholder="<?php _e('e.g., 500 pcs', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors bg-white">
                                    </div>
                                </div>

                                <!-- Row 5: Message -->
                                <div>
                                    <label class="block text-sm font-medium text-[#333] mb-1"><?php _e('Message', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                    <textarea name="contact_message" rows="4" required placeholder="<?php _e('Tell us about your project or inquiry...', 'erdu-wp'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-orange-500 focus:ring-0 focus:outline-none transition-colors resize-y bg-white"></textarea>
                                </div>

                                <!-- Privacy Checkbox -->
                                <div class="flex items-center gap-2 mt-4">
                                    <input type="checkbox" name="contact_privacy" id="contact_privacy" required class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                    <label for="contact_privacy" class="text-xs text-gray-500"><?php _e('I agree to ERDU\'s Privacy Policy and consent to being contacted regarding my inquiry.', 'erdu-wp'); ?></label>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="mt-4 px-6 py-3 erdu-bg-primary text-white rounded-md font-medium hover:bg-orange-700 transition-colors flex items-center gap-2 w-max">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.536 21.686a.5.5 0 00.937-.024l6.5-19a.496.496 0 00-.635-.635l-19 6.5a.5.5 0 00-.024.937l7.93 3.18a2 2 0 011.112 1.11zm7.318-19.539l-10.94 10.939"/></svg>
                                    <?php _e('Send Message', 'erdu-wp'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map -->
        <?php if ($map_embed || $map_image) : ?>
        <section class="py-0">
            <?php if ($map_embed) : ?>
                <div class="w-full" style="height: 400px;"><?php echo wp_kses_post($map_embed); ?></div>
            <?php elseif ($map_image) : ?>
                <div class="w-full" style="height: 400px; background-image: url('<?php echo esc_url($map_image); ?>'); background-size: cover; background-position: center;"></div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- FAQ -->
        <?php if ($faqs) : ?>
        <section class="py-16 bg-white">
            <div class="erdu-container max-w-3xl">
                <h2 class="text-2xl font-bold mb-8 text-center text-gray-800"><?php _e('Frequently Asked Questions', 'erdu-wp'); ?></h2>
                <div class="space-y-3" id="faq-accordion">
                    <?php foreach ($faqs as $i => $faq) : ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                            <button type="button" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors faq-toggle" data-index="<?php echo intval($i); ?>">
                                <span class="text-sm font-medium text-gray-800"><?php echo esc_html($faq['question']); ?></span>
                                <span class="faq-icon text-xl text-gray-400 transition-transform ml-4 shrink-0" style="line-height: 1;">+</span>
                            </button>
                            <div class="faq-content hidden px-4 pb-4">
                                <p class="text-sm text-gray-600"><?php echo esc_html($faq['answer']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php
    endwhile;
endif;

get_footer();
