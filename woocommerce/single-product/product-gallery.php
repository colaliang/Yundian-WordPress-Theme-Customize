<?php
/**
 * Single Product: Gallery, Video & Lightbox
 *
 * Expected variables:
 *   $product       (WC_Product)
 *   $all_image_ids (array of attachment IDs)
 *   $has_video     (bool)
 *   $video_url     (string, optional)
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (empty($all_image_ids) && !$has_video) {
    return;
}

$image_count = count($all_image_ids);
$first_full  = !empty($all_image_ids) ? wp_get_attachment_image_url(array_values($all_image_ids)[0], 'full') : wc_placeholder_img_src('full');
?>

<!-- Media Container -->
<div class="w-full flex-grow flex flex-col relative">
    <div id="erdu-gallery-container" class="w-full relative flex flex-row gap-4 erdu-gallery-layout">

        <?php if ($image_count > 1 || $has_video) : ?>
        <!-- Thumbnail Rail -->
        <div class="w-16 lg:w-[64px] flex-shrink-0 flex flex-col gap-2 overflow-y-auto erdu-hide-scrollbar erdu-rail-layout">
            <?php foreach ($all_image_ids as $index => $img_id) :
                $thumb_url = wp_get_attachment_image_url($img_id, 'gallery_thumbnail');
                $full_url  = wp_get_attachment_image_url($img_id, 'full');
            ?>
                <img src="<?php echo esc_url($thumb_url); ?>"
                     data-full="<?php echo esc_url($full_url); ?>"
                     data-index="<?php echo $index; ?>"
                     class="erdu-gallery-thumb w-full aspect-square rounded-lg object-cover border-2 cursor-pointer transition-all <?php echo $index === 0 ? 'border-[#f97316] opacity-100' : 'border-transparent opacity-70 hover:opacity-100 hover:border-gray-300'; ?> erdu-thumb-layout"
                     alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true)); ?>" />
            <?php endforeach; ?>

            <?php if ($has_video) :
                $video_bg = !empty($all_image_ids) ? wp_get_attachment_image_url(array_values($all_image_ids)[0], 'gallery_thumbnail') : wc_placeholder_img_src('gallery_thumbnail');
            ?>
                <div id="erdu-video-thumb" class="erdu-video-thumb w-full aspect-square rounded-lg object-cover border-2 border-transparent opacity-70 hover:opacity-100 hover:border-gray-300 cursor-pointer transition-all relative flex items-center justify-center overflow-hidden erdu-thumb-layout">
                    <img src="<?php echo esc_url($video_bg); ?>" class="absolute inset-0 w-full h-full object-cover opacity-50" />
                    <div class="absolute inset-0 bg-black/30"></div>
                    <svg class="w-8 h-8 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Main Image Stage Area -->
        <div class="flex-grow relative flex items-center justify-center max-w-[800px] w-full mx-auto erdu-gallery-stage">

            <!-- Image Wrapper -->
            <div class="w-full h-full bg-[#f3f4f6] rounded-xl overflow-hidden relative flex items-center justify-center cursor-zoom-in group" id="erdu-main-image-wrapper">
                <img src="<?php echo esc_url($first_full); ?>" id="erdu-main-image" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-[1.02]" alt="<?php echo esc_attr($product->get_name()); ?>" data-current-index="0" />

                <!-- Lightbox Hint Icon -->
                <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>

            <?php if ($has_video) : ?>
            <!-- Video Container (Hidden by default) -->
            <div id="erdu-video-container" class="hidden absolute inset-0 w-full h-full bg-black rounded-xl overflow-hidden shadow-sm z-10">
                <?php
                $is_youtube = strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false;
                $is_vimeo   = strpos($video_url, 'vimeo.com') !== false;

                if ($is_youtube) :
                    $yt_id = '';
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $video_url, $match)) {
                        $yt_id = $match[1];
                    }
                    $embed_url = $yt_id ? 'https://www.youtube.com/embed/' . $yt_id . '?rel=0&showinfo=0' : $video_url;
                ?>
                    <iframe src="<?php echo esc_url($embed_url); ?>" title="YouTube video player" class="absolute inset-0 w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <?php elseif ($is_vimeo) : ?>
                    <iframe src="<?php echo esc_url($video_url); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <?php else : ?>
                    <video controls class="absolute inset-0 w-full h-full object-contain bg-black">
                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Lightbox Overlay (Alibaba Style) -->
    <div id="erdu-lightbox" class="fixed inset-0 z-[99999] bg-[#111111] hidden flex-col opacity-0 transition-opacity duration-300">
        <!-- Header -->
        <div class="h-16 flex items-center justify-between px-6 flex-shrink-0">
            <div class="w-10"></div>
            <div class="text-gray-400 text-sm font-medium tracking-widest">
                <span id="erdu-lightbox-current">1</span> / <span id="erdu-lightbox-total"><?php echo $image_count; ?></span>
            </div>
            <button id="erdu-lightbox-close" class="text-gray-400 hover:text-white transition-colors cursor-pointer p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-grow flex flex-row items-center justify-center max-w-[1400px] mx-auto w-full px-4 pb-8 gap-8">
            <?php if ($image_count > 1) : ?>
            <!-- Lightbox Thumbnails -->
            <div class="w-[80px] flex-shrink-0 flex flex-col gap-2 overflow-y-auto erdu-hide-scrollbar h-full max-h-[80vh] py-4">
                <?php foreach ($all_image_ids as $index => $img_id) :
                    $thumb_url = wp_get_attachment_image_url($img_id, 'gallery_thumbnail');
                    $full_url  = wp_get_attachment_image_url($img_id, 'full');
                ?>
                    <img src="<?php echo esc_url($thumb_url); ?>"
                         data-full="<?php echo esc_url($full_url); ?>"
                         data-index="<?php echo $index; ?>"
                         class="erdu-lightbox-thumb w-full aspect-square rounded-lg object-cover border-2 cursor-pointer transition-all <?php echo $index === 0 ? 'border-[#f97316] opacity-100' : 'border-transparent opacity-60 hover:opacity-100 hover:border-gray-500'; ?>"
                         alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true)); ?>" />
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Lightbox Main Image -->
            <div class="flex-grow relative h-full flex items-center justify-center bg-transparent group" id="erdu-lightbox-img-wrapper">
                <button id="erdu-lightbox-prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/40 hover:bg-black/80 rounded-full text-white flex items-center justify-center transition-all z-50 hidden opacity-0 group-hover:opacity-100 cursor-pointer">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <div class="bg-white rounded-xl p-4 md:p-8 w-full h-full flex items-center justify-center max-w-[900px] max-h-[900px] shadow-2xl">
                    <img id="erdu-lightbox-img" src="" class="max-w-full max-h-full object-contain select-none transition-opacity duration-200" />
                </div>

                <button id="erdu-lightbox-next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/40 hover:bg-black/80 rounded-full text-white flex items-center justify-center transition-all z-50 hidden opacity-0 group-hover:opacity-100 cursor-pointer">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<?php if ($has_video) : ?>
<!-- Media Switcher (Photos / Video) -->
<div class="flex justify-center mt-6">
    <div class="flex items-center justify-center gap-2 bg-[#f4f4f4] rounded-lg h-[34px] px-1 py-1">
        <button id="btn-show-photos" class="flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors bg-white text-black font-bold shadow-sm">
            Photos
        </button>
        <button id="btn-show-video" class="flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors text-black font-normal hover:bg-white/50 hover:text-black hover:font-bold">
            Video
        </button>
    </div>
</div>
<?php endif; ?>
