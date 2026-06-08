# WooCommerce B2B Templates Rearchitecture Design

## 1. Overview
Refactor the current `erdu-wp-theme` product templates to align with the Wellmax reference structures (Archive & Single Product). The core strategy relies on using the WooCommerce product system but heavily customizing the frontend through template overrides and Tailwind CSS, converting it into a pure B2B catalog without ecommerce checkout flows.

## 2. Architecture & B2B Conversion
- **Template Overrides**: Create a `woocommerce/` folder inside the theme to override core files:
  - `archive-product.php`
  - `single-product.php`
  - `content-single-product.php`
- **B2B Features via Hooks**:
  - Remove "Add to Cart", pricing, stock status, and product reviews.
  - Introduce an "Inquire Now" CTA replacing the purchase action.
- **ACF Configurability**: Global settings for products (e.g., global inquiry link, default banners, tab names) will be managed via ACF Options Page or specific taxonomy/post fields.

## 3. Product Archive Page (Collection)
**Structure**:
- **Hero Section**: 
  - Full-width banner.
  - Configurable via ACF on the Product Category taxonomy (e.g., Category Banner Image, Subtitle). Fallback to a global ACF option.
- **Two-Column Layout**:
  - **Sidebar**: Sticky or static product category tree/navigation for easy filtering.
  - **Main Content**: Product Grid.
- **Product Card**:
  - Thumbnail.
  - Title.
  - Key attributes snippet (e.g., Power, CCT).
  - "View Details" button.

## 4. Single Product Page
**Structure**:
- **Breadcrumbs**: Home > Category > Product.
- **Top Section (Hero)**:
  - **Left**: Product Image Gallery (Main image + thumbnail carousel).
  - **Right**: 
    - Title (H1).
    - Excerpt / Short Description.
    - Key Specifications List (dynamically pulled from WooCommerce Attributes).
    - "Inquire Now" Button (link configurable via ACF).
- **Details Section (Tabs)**:
  - **Tab 1: Overview/Features**: Full `the_content()`.
  - **Tab 2: Specifications**: Rendered table of WooCommerce attributes.
  - **Tab 3: Downloads/Resources**: Output files added via ACF Product fields.
- **Bottom Section (Recommendation)**:
  - Related Products grid (4 items) from the same category.

## 5. ACF Fields Structure
- **Taxonomy (Product Category)**:
  - `category_banner_image` (Image)
  - `category_subtitle` (Text)
- **Post Type (Product)**:
  - `product_downloads` (Repeater: File, Title)
  - `product_applications_gallery` (Gallery)
- **Theme Options (Products Global Settings)**:
  - `global_inquiry_link` (URL)
  - `default_archive_banner` (Image)

## 6. Implementation Steps
1. Add ACF field groups for Products, Categories, and Theme Options.
2. Add WooCommerce B2B hooks in `functions.php` (remove price/cart).
3. Scaffold `woocommerce/archive-product.php`.
4. Scaffold `woocommerce/single-product.php` and `content-single-product.php`.
5. Apply Tailwind styling and integrate ACF data.
