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

        // ---- Page Content ----
        $page_content = erdu_page_field('contact_page_editor', '');

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

        <!-- Hero — Dark Brown -->
        <section class="relative py-16 erdu-bg-secondary">
            <div class="erdu-container">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white mt-4"><?php echo esc_html($hero_title); ?></h1>
            </div>
        </section>

        <!-- Editable Page Content -->
        <?php if ($page_content) : ?>
        <section class="py-12 bg-white">
            <div class="erdu-container"><div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- Contact Info + Form — Two Column Layout -->
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
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="font-bold text-base mb-4 text-gray-800"><?php _e('Contact Persons', 'erdu-wp'); ?></h3>
                            <div class="space-y-3">
                                <?php foreach ($persons as $p) :
                                    $initial = !empty($p['initial']) ? $p['initial'] : strtoupper(substr($p['name'], 0, 1));
                                ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0 erdu-bg-primary"><?php echo esc_html($initial); ?></div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800"><?php echo esc_html($p['name']); ?> <?php if (!empty($p['title'])) : ?>&mdash; <?php echo esc_html($p['title']); ?><?php endif; ?></p>
                                        <?php if (!empty($p['email'])) : ?><p class="text-xs text-gray-500"><?php echo esc_html($p['email']); ?></p><?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Connect With Us -->
                        <?php if ($whatsapp || $wechat) : ?>
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="font-bold text-base mb-4 text-gray-800"><?php echo esc_html($social_label); ?></h3>
                            <div class="flex gap-3">
                                <?php if ($whatsapp) : ?>
                                <a href="<?php echo esc_url(strpos($whatsapp, 'http') === 0 ? $whatsapp : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-white transition-opacity hover:opacity-90" style="background-color: #25D366;">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    WhatsApp
                                </a>
                                <?php endif; ?>
                                <?php if ($wechat) : ?>
                                <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-white cursor-default" style="background-color: #07C160;">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 01.213.665l-.39 1.48c-.019.07-.048.141-.048.213 0 .163.13.295.29.295a.326.326 0 00.167-.054l1.903-1.114a.864.864 0 01.717-.098 10.16 10.16 0 002.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.991c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178A1.17 1.17 0 014.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178 1.17 1.17 0 01-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 01.598.082l1.584.926a.272.272 0 00.14.047c.134 0 .24-.111.24-.247 0-.06-.023-.12-.038-.177l-.327-1.233a.582.582 0 01-.023-.156.49.49 0 01.201-.398C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-6.656-6.088-.139-.009-.278-.021-.418-.033h-.088zm-2.06 3.13c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.97-.982zm4.844 0c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.969-.982z"/></svg>
                                    WeChat
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Form (2 cols) -->
                    <div class="lg:col-span-2">
                        <h2 class="text-xl font-bold mb-8 text-gray-800"><?php _e('Send Us a Message', 'erdu-wp'); ?></h2>

                        <div class="rounded-xl p-6 md:p-8 border border-gray-200 bg-gray-50">
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
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Your Name', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_name" required placeholder="<?php _e('Full name', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Email Address', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="email" name="contact_email" required placeholder="email@company.com" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                </div>

                                <!-- Row 2: Phone + Company -->
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Phone Number', 'erdu-wp'); ?></label>
                                        <input type="tel" name="contact_phone" placeholder="+1 234 567 890" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Company Name', 'erdu-wp'); ?></label>
                                        <input type="text" name="contact_company" placeholder="<?php _e('Company name', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                </div>

                                <!-- Row 3: Country + Subject -->
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Country', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_country" required placeholder="<?php _e('Your country', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Subject', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                        <input type="text" name="contact_subject" required placeholder="<?php _e('What is this regarding?', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                </div>

                                <!-- Row 4: Interested Product + Quantity -->
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Interested Product', 'erdu-wp'); ?></label>
                                        <select name="contact_product" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                            <option value=""><?php _e('Select a product', 'erdu-wp'); ?></option>
                                            <option value="track">48V Magnetic Track Light</option>
                                            <option value="downlight">Downlight</option>
                                            <option value="spotlight">Spotlight</option>
                                            <option value="panel">Panel Light</option>
                                            <option value="ceiling">Ceiling Light</option>
                                            <option value="custom">Custom/OEM</option>
                                            <option value="multiple">Multiple Products</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Estimated Quantity', 'erdu-wp'); ?></label>
                                        <input type="text" name="contact_quantity" placeholder="<?php _e('e.g., 500 pcs', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm bg-white">
                                    </div>
                                </div>

                                <!-- Row 5: Message -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Message', 'erdu-wp'); ?> <span class="erdu-text-primary">*</span></label>
                                    <textarea name="contact_message" rows="5" required placeholder="<?php _e('Tell us about your project or inquiry...', 'erdu-wp'); ?>" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-sm resize-y bg-white"></textarea>
                                </div>

                                <!-- Privacy Checkbox -->
                                <div class="flex items-start gap-2 pt-2">
                                    <input type="checkbox" name="contact_privacy" id="contact_privacy" required class="mt-0.5 w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                    <label for="contact_privacy" class="text-sm text-gray-500"><?php _e('I agree to ERDU\'s Privacy Policy and consent to being contacted regarding my inquiry.', 'erdu-wp'); ?></label>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 rounded-lg text-white font-semibold transition-opacity hover:opacity-90 erdu-bg-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
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
