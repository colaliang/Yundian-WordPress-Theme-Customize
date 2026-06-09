# ERDU Gallery Container Redesign (Option A)

## 1. Overview
The goal is to redesign `erdu-gallery-container` on the WooCommerce single product page to match the visual hierarchy of the Alibaba reference while keeping WooCommerce's native gallery switching behavior intact.

The redesign focuses on four outcomes:
- A stable left-side vertical thumbnail rail
- A main image area that shows the full product image without cropping
- Reliable thumbnail-to-main-image switching
- Continued support for the existing `Photos / Video` toggle below the gallery

## 2. Current Problems
The current implementation relies on aggressive CSS overrides applied directly to WooCommerce gallery internals. This creates conflicts with the native Flexslider/Flex viewport sizing logic.

Observed issues:
- The thumbnail rail can collapse to only a few pixels instead of staying at `64px`
- Main image switching can become unstable after thumbnail clicks
- Layout rules compete with WooCommerce's own width calculations
- Single-image and multi-image products are harder to support consistently

## 3. Chosen Approach
Use **Option A**: keep WooCommerce native gallery rendering and switching, but rebuild the outer layout and scoped presentation styles around it.

This means:
- Do **not** replace WooCommerce gallery JS
- Do **not** build a custom slider or lightbox
- Do **not** add the top-right Alibaba action icons
- Do **not** change the existing product video data model or `Photos / Video` switching logic

## 4. Target Layout
The gallery block will use an Alibaba-inspired composition:

1. **Outer Card**
   - White background
   - Rounded corners
   - Soft border and shadow
   - Square aspect ratio on desktop to match the video container

2. **Left Thumbnail Rail**
   - Fixed width: `64px`
   - Vertical stack
   - Scrollable when thumbnails exceed available height
   - Clear active state with visible border

3. **Main Image Stage**
   - Occupies the remaining horizontal space
   - Centers the active image both vertically and horizontally
   - Uses full-image display (`contain`) rather than crop-fill
   - Preserves a clean, product-focused presentation

4. **Bottom Media Switcher**
   - `Photos / Video` remains below the gallery card
   - Existing toggle behavior stays unchanged

## 5. Implementation Boundaries
Only the gallery portion inside [content-single-product.php](file:///i:/官网/erdu-wp-theme/woocommerce/content-single-product.php) will be changed.

In scope:
- `erdu-gallery-container` structure and scoped CSS
- Thumbnail rail layout
- Main image presentation
- Conditional spacing when thumbnails exist

Out of scope:
- ACF field changes
- Product info panel on the right
- Section 2 content blocks
- New lightbox behavior
- New third-party gallery dependencies
- Alibaba-style floating action buttons

## 6. Technical Design
### 6.1 Rendering Strategy
Keep `woocommerce_show_product_images()` as the rendering source of truth so WooCommerce continues to manage:
- gallery image markup
- thumbnail click behavior
- active slide updates
- future plugin compatibility

### 6.2 Layout Strategy
Avoid forcing `.woocommerce-product-gallery` into a custom flex-driven main/thumbnail split that overrides its internal sizing model.

Instead:
- keep WooCommerce gallery root in normal flow
- reserve left-side space only when thumbnails exist
- position the thumbnail rail in a predictable, fixed-width region
- let the main viewport occupy the remaining width through padding/spacing rather than DOM inversion

### 6.3 Single vs Multi Image Handling
Add a small DOM check after gallery render:
- if thumbnail elements exist, apply a container class such as `erdu-gallery-has-thumbs`
- if no thumbnails exist, render the main image stage without reserving left spacing

This prevents blank rails on single-image products.

### 6.4 Image Display Rules
- Main stage images use `object-fit: contain`
- Thumbnail images use `object-fit: cover`
- Active thumbnail gets a stronger border and full opacity
- Non-active thumbnails stay slightly muted

## 7. Error Handling and Stability
The redesign must fail safely:
- If WooCommerce outputs only one image, the gallery remains centered and usable
- If thumbnail markup changes slightly, the main image still renders because WooCommerce remains in control
- If video exists, switching from `Video` back to `Photos` must restore the gallery cleanly

No custom slider state should be introduced beyond a minimal "has thumbnails" class toggle.

## 8. Validation Criteria
The redesign is complete when all of the following are true:
- Left thumbnail rail displays at a stable `64px` width
- Main image remains fully visible without unwanted cropping
- Clicking thumbnails updates the main image reliably
- Multi-image products display a vertical thumbnail rail
- Single-image products do not reserve an empty left rail
- Products with video still switch correctly between `Photos` and `Video`
- Mobile layout remains readable and does not break gallery interaction

## 9. Testing Plan
Test at least these scenarios:
1. Product with one image only
2. Product with multiple gallery images
3. Product with gallery images and video
4. Desktop viewport
5. Mobile viewport

Verification method:
- visual check of thumbnail width and spacing
- click-through check on every thumbnail
- switch `Photos -> Video -> Photos`
- confirm no new PHP or editor diagnostics are introduced

## 10. Self-Review Notes
- **Placeholder check:** No TBD items remain.
- **Consistency check:** The design keeps native WooCommerce switching while limiting scope to the gallery container only.
- **Scope check:** This is a single, focused frontend refactor and does not require decomposition.
- **Ambiguity check:** Thumbnail width is explicitly fixed at `64px`; floating action icons are explicitly excluded.
