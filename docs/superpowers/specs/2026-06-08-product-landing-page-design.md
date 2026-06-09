# Product Landing Page Architecture (Option A)

## 1. Overview
The goal is to transform the standard WooCommerce single product page (which uses a split gallery/summary layout) into a high-impact, full-width "Landing Page" style, inspired by the Wellmax Disc Downlight reference. 

## 2. Page Structure (Top to Bottom)
1. **Hero Section**: 
   - Full-width dark background with an overlaid product image or lifestyle background.
   - Centralized Product Title, Subtitle, and a primary CTA ("Inquire Now" anchoring to the bottom).
2. **Overview**:
   - Clean, centered text utilizing the standard WordPress content editor (`the_content()`).
3. **Features Blocks (Alternating Layout)**:
   - Alternating Image Left / Text Right (and vice versa) sections to highlight specific product advantages (e.g., "Ultra Thin Design", "High Efficacy").
4. **Applications Gallery**:
   - A grid of images showing the product in real-world scenarios.
5. **Technical Specifications**:
   - A full-width, clean table/grid automatically pulling from WooCommerce Attributes (Power, CCT, CRI, etc.).
6. **Downloads & Resources**:
   - PDF/IES files from the existing ACF downloads repeater.
7. **Final Call to Action (CTA)**:
   - A bold, full-width section prompting the user to send an inquiry.

## 3. Data Model (ACF Fields for Products)
To manage this without a page builder, we will add a new ACF Field Group assigned to `post_type == product`:
- **Hero Tab**:
  - `hero_background_image` (Image URL)
  - `hero_product_image` (Image URL - optional cutout PNG)
- **Features Tab**:
  - `product_features` (Repeater)
    - `feature_title` (Text)
    - `feature_description` (Textarea)
    - `feature_image` (Image URL)
    - `image_alignment` (Select: Left / Right)
- **Applications Tab**:
  - `application_images` (Gallery)

## 4. Implementation Plan
1. **ACF Setup**: Update `inc/acf-fields.php` to register these new product-specific landing page fields.
2. **Template Rewrite**: Completely rewrite `woocommerce/content-single-product.php` to remove the default WooCommerce hooks (`woocommerce_show_product_images`, `woocommerce_template_single_summary`, etc.) and replace them with our custom full-width HTML/Tailwind structure.
3. **Styling**: Ensure all new sections are fully responsive using Tailwind utility classes from our `main.css`.
