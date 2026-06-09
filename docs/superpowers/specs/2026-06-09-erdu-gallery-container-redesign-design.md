# ERDU Gallery Container Redesign (Option B + Lightbox)

## 1. Overview
The goal is to redesign `erdu-gallery-container` on the WooCommerce single product page to match the visual hierarchy of the Alibaba reference. We will transition to **Option B**, replacing WooCommerce's native gallery markup with a fully custom DOM and Vanilla JS implementation. We will also include a simple Lightbox for the main image.

The redesign focuses on four outcomes:
- A stable left-side vertical thumbnail rail using custom HTML/CSS
- A main image area that shows the full product image without cropping
- Reliable thumbnail-to-main-image switching via custom Vanilla JS
- A simple click-to-enlarge Lightbox overlay for the main image

## 2. Current Problems
The previous implementation attempted to wrangle WooCommerce's native Flexslider into a custom layout, which caused unpredictable behavior, hidden padding, and conflicts with the native JS width calculations.

## 3. Chosen Approach
Use **Option B**: custom main image area, custom thumbnail rendering via WooCommerce data, and custom JS.
- Do **not** use `woocommerce_show_product_images()`
- Render thumbnails and main image using standard `wp_get_attachment_image_url`
- Add a custom Vanilla JS Lightbox (Option 2)

## 4. Target Layout
The gallery block will use an Alibaba-inspired composition:

1. **Outer Card**
   - White background
   - Rounded corners
   - Soft shadow (no border)
   - Flex row layout

2. **Left Thumbnail Rail**
   - Fixed width: `64px`
   - Vertical stack with `gap-3`
   - Scrollable (scrollbar hidden)
   - Active state with Hermes Orange border

3. **Main Image Stage**
   - Occupies remaining space with a `#f3f4f6` background
   - Uses `object-fit: contain`
   - Hover state with a slight scale effect and a zoom-in cursor
   - Top-right icon hint indicating it can be expanded

4. **Lightbox Overlay**
   - Fixed full screen, high z-index
   - Dark translucent background with backdrop blur
   - Contains the high-res version of the currently active main image
   - Click background or Escape key to close

## 5. Implementation Boundaries
Only the gallery portion inside `content-single-product.php` will be changed.

In scope:
- `erdu-gallery-container` custom HTML structure
- Custom Vanilla JS for thumbnail switching and Lightbox
- Extracting image IDs via PHP

Out of scope:
- ACF field changes
- Product info panel on the right
- Section 2 content blocks

## 6. Technical Design
### 6.1 Rendering Strategy
- Fetch `$product->get_image_id()` and `$product->get_gallery_image_ids()`.
- Merge them into a single array.
- Loop through the array to build the thumbnail rail.
- Render the first image as the default main image.

### 6.2 Lightbox Logic
- A hidden `div#erdu-lightbox` sits at the bottom of the left column.
- Clicking the main image wrapper sets the lightbox image `src` to the main image's current `src`.
- Toggle Tailwind classes (`hidden`, `opacity-0`, `opacity-100`, `flex`) for a smooth fade-in.
- Add `overflow: hidden` to the `body` to prevent background scrolling while the lightbox is open.

## 7. Validation Criteria
- Left thumbnail rail displays correctly.
- Clicking thumbnails updates the main image instantly.
- Clicking the main image opens the Lightbox.
- Lightbox can be closed via the 'X' button, clicking the background, or pressing Escape.
- No PHP errors or console warnings.
