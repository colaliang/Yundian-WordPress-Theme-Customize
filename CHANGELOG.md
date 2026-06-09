# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 待开发功能
### 主题关联插件
- SEO/GEO/AEO优化
- AI生成主题页面，并自动优化
- Blog/News自动生成计划
- 多渠道内容发布
- 多模板选择，云端加载（已做规划文档）

## [Unreleased]

## [1.6.23] - 2026-06-09
### Changed
- Moved breadcrumbs to the top left of the product page, and tied visibility to the Layout Settings (`erdu_show_breadcrumb`).
- Adjusted gallery alignment so the product image sits flush with the top of the thumbnail rail.
- Changed thumbnail gallery interaction to trigger on hover (`mouseenter`) rather than just click.
- Enhanced Lightbox with left/right navigation arrows and keyboard (Arrow keys) support.

## [1.6.22] - 2026-06-09
### Changed
- Refactored the `erdu-gallery-container` to completely bypass WooCommerce's native gallery markup (Option B).
- Implemented a custom gallery layout with a dedicated left thumbnail rail and a responsive main image stage using Tailwind CSS.
- Added a custom Vanilla JS image switcher for thumbnail clicks.
- Added a full-screen Lightbox feature (Option 2) for the main image with smooth fade transitions, accessible via click, and dismissible via background click or the Escape key.

## [1.6.21] - 2026-06-09
### Fixed
- Removed the border styles (`border border-gray-100`) from the `erdu-gallery-container` for a cleaner visual look.

## [1.6.20] - 2026-06-09
### Fixed
- Strictly aligned `erdu-gallery-container` layout with the 2026-06-09 design specification.
- Updated thumbnail styles to use Hermes Orange highlight and muted non-active states.
- Restored JavaScript class toggle for `erdu-gallery-has-thumbs` without overriding the native animation.

## [1.6.19] - 2026-06-09
### Fixed
- Refined `erdu-gallery-container` toward an Alibaba-style layout with a more stable left thumbnail rail and a cleaner main image stage.
- Improved thumbnail card styling, active-state visibility, and reserved spacing behavior for products with gallery images.
- Preserved WooCommerce native gallery switching while polishing the visual presentation for desktop and mobile.

## [1.6.18] - 2026-06-09
### Fixed
- Reworked `erdu-gallery-container` to keep WooCommerce native gallery switching while removing the conflicting flex-based layout override.
- Fixed the left thumbnail rail to render at a stable `64px` width and only reserve space when thumbnails actually exist.
- Improved the main product image area so the active image keeps full visibility during gallery switching.

## [1.6.17] - 2026-06-09
### Fixed
- Fixed WooCommerce product gallery image transition issues where the main image might not show completely or correctly upon thumbnail click.
- Changed main gallery image `object-fit` from `cover` to `contain` to ensure the entire product image is always visible without being cropped.
- Added padding to the gallery container and improved thumbnail visual states (opacity on hover/active).
- Hid the default WooCommerce gallery magnifier trigger icon to maintain a clean UI.

## [1.6.16] - 2026-06-09
### Fixed
- Adjusted WooCommerce gallery thumbnails width from 100px to 64px to leave more space for the main product image.

## [1.6.15] - 2026-06-09
### Fixed
- Re-architected Section 1 WooCommerce Gallery: Separated thumbnails to a vertical column on the left side while the main image stays on the right, fully occupying the remaining space. This perfectly matches the requested design where thumbnails are smaller and stacked vertically.
- Forced Section 2 content blocks to expand to full width by removing implicit internal boundaries.

## [1.6.14] - 2026-06-09
### Fixed
- Forced the main WooCommerce product gallery to fill 100% of the left column container (Section 1), matching the exact dimensions and `aspect-ratio: 1/1` behavior of the video container. This resolves the issue where the native WooCommerce gallery was not expanding fully.
- Removed the restrictive `max-w-5xl` constraint from the wrapper in Section 2, ensuring the vertical flow content now correctly spans the entire width of the page container.

## [1.6.13] - 2026-06-09
### Changed
- Refactored Section 2 from a traditional "Tab Switcher" into a "Vertical Flow Landing Page" style.
  - All content blocks (Description, Features, Specs, Downloads) are now stacked vertically and fully visible by default.
  - Replaced the tab Javascript with a modern "Sticky Navigation Menu" combined with an Intersection Observer.
  - Clicking a nav link smoothly scrolls to the corresponding section, and the nav link automatically highlights based on the user's scroll position.

## [1.6.12] - 2026-06-09
### Changed
- Added "Technical Specifications" as an independent ACF repeater field inside "Product Landing Page Data", decoupling it from WooCommerce native attributes. The Section 2 "Specs" tab now cleanly renders this custom repeater data as a table.

## [1.6.11] - 2026-06-09
### Fixed
- Improved YouTube video rendering in the Product Media Gallery: Automatically parses standard YouTube URLs (`youtube.com/watch?v=...` or `youtu.be/...`) and converts them into the official `youtube.com/embed/...` iframe format with proper permissions (`accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share`), preventing "refused to connect" or rendering issues.

## [1.6.10] - 2026-06-09
### Changed
- Improved Section 1 Left Column (Media) styling:
  - Made the product gallery container expand fully (`w-full`) to fill the left column and removed excessive inner padding (`p-2 lg:p-8`) to allow images to stretch edge-to-edge within the container.
  - Used Flexbox (`flex-col`, `flex-grow`, `mt-auto`) to strictly pin the Photos/Video switcher buttons to the bottom of the left column.

## [1.6.9] - 2026-06-09
### Changed
- Synced the global `.erdu-container` `max-width` to `1760px` to match Wellmax's maximum content width on large screens (previously set to `2560px`).

## [1.6.8] - 2026-06-09
### Added
- Added visual display for WooCommerce Product Attributes in Section 1 (below Key Attributes grid). Attributes (like "Emitting Color", "Lamp Power(W)") are now rendered as a styled pill list, giving users a clear view of available options without adding a shopping cart flow.

## [1.6.7] - 2026-06-09
### Changed
- Maximized `.erdu-container` `max-width` from 1280px to 2560px globally to achieve true edge-to-edge full-screen layout on 2K/4K monitors (matching Header width).
- Removed `max-w-5xl` constraint from Section 2 (Product Tabs), allowing the tabs and contents to expand fully to match the maximized container effect.

## [1.6.6] - 2026-06-09
### Added
- Added MOQ configuration and display to the Single Product Page (Section 1).
- Added "Key Attributes" configuration (repeater field) and a 3-column grid display below the short description.
- Added a Video tab/switcher to the product gallery (Section 1), allowing users to switch between standard WooCommerce Photos and a custom Video container via Vanilla JS.

## [1.6.5] - 2026-06-08
### Changed
- **Major Layout Overhaul (Single Product)**:
  - **Section 1**: Swapped the columns. The main product gallery is now firmly on the **left side** (Standard WooCommerce behavior), while the core product info (Title, Price, SKU, Short Description, Action Buttons) is neatly organized on the **right side**.
  - **Section 2**: Moved the horizontal Tab Layout (Description, Features, Specs, Downloads) completely out of the split-column view. It now spans horizontally below Section 1, creating a more traditional, spacious, and readable bottom-heavy product detail experience.
- Completely removed redundant duplicate CTA button from the bottom of the page.

## [1.6.4] - 2026-06-08
### Changed
- Refactored the single product accordion layout into a clean, horizontal Tabbed layout (Description, Features, Specs, Downloads) for better readability.
- Cleaned up the leftover HTML skeleton of the `Applications Gallery` from the right column.
- Fixed `Inquire Now` and `WhatsApp` button styles. Used inline colors to ensure background colors render perfectly across all environments without relying on pre-compiled Tailwind arbitrary values, and aligned them beautifully in a responsive row layout.

## [1.6.3] - 2026-06-08
### Changed
- Removed the `Applications Gallery` feature completely from ACF and frontend, as per the new layout strategy.
- Reordered the Accordion panels: `Description` now shows first (expanded by default), followed by `Product Features`.
- Moved the `Inquire Now` CTA button from the bottom of the accordion to just below the Short Description.

### Added
- Added the WooCommerce standard `Short Description` (Excerpt) below the Price and SKU section.
- Added a `WhatsApp` direct contact button next to the Inquire Now button. This button can be toggled on/off and the phone number configured globally per product via the ACF Display Options tab.

## [1.6.2] - 2026-06-08
### Fixed
- Fixed product single page wrapper width to align properly with the Header (`erdu-container`) while maintaining the 50/50 split ratio.
- Restored the rendering logic for the `Applications Gallery` which was missing from the new split-screen layout. It now elegantly displays below the main product gallery on the right column.
- Removed obsolete `Hero Banner` ACF fields since the top banner design was deprecated in favor of the clean Astra-style catalog.

### Added
- Added `Show SKU` and `Show Price` toggle options to the ACF Product Settings (Display Options tab).
- Dynamically render SKU and Price above the accordion based on the new ACF toggle settings.

## [1.6.1] - 2026-06-08
### Changed
- **Removed ACF Free Compatibility:** Fully committed to Advanced Custom Fields (ACF) Pro. Removed all fallback inputs and complex rendering logic for ACF Free in `inc/acf-fields.php` and `woocommerce/content-single-product.php` to streamline the codebase and data structure.

## [1.6.0] - 2026-06-08
### Changed
- **Ultra-Wide Screen Support:** Optimized the single product page container to support full-width displays (up to 2560px for 2K/4K monitors) with proper side padding.
- **50/50 Layout Proportion:** Adjusted the split-screen accordion and gallery ratio from 5/12 & 7/12 to a balanced 1/2 & 1/2 (50/50), ensuring the gallery takes up exactly half the screen.
- **ACF Free Usability Improvement:** Refactored the `Product Features` and `Downloads` fallback fields for ACF Free users. Replaced the single cumbersome textarea with 6 dedicated static inputs for Features (Title/Description) and 3 for Downloads, making data entry much more intuitive.

## [1.5.0] - 2026-06-08
### Changed
- **Redesigned Product Single Page:** Pivoted from the full-width landing page approach to a split-screen, sticky accordion layout (inspired by Astra/Wellmax custom catalog style).
- **Left Column (Accordion):** Features breadcrumbs, product title, "Specification" badge, and an interactive Vanilla JS Accordion containing Product Features, Description, Technical Specs, and Downloads.
- **Right Column (Gallery):** Retains the standard WooCommerce product image gallery but presented as a clean, responsive slider block on the right.
- Injected necessary utility classes (e.g., `.lg:w-5/12`, `.lg:sticky`, `.rotate-180`) to `main.css` for the new layout.

## [1.4.0] - 2026-06-08
### Changed
- **Major Architecture Change:** Replaced the traditional WooCommerce "Split Gallery/Summary" product layout with a high-impact, full-width "Landing Page" experience inspired by industry-leading B2B catalogs.
- Updated `woocommerce/single-product.php` and `woocommerce/content-single-product.php` to bypass default WooCommerce hooks and implement the new full-width sections (Hero, Overview, Features, Applications, Specs, Downloads, CTA).
- Overhauled Product ACF fields (`inc/acf-fields.php`) to introduce Tabbed sections for Hero Banner, Features Blocks (Repeater), and Applications Gallery.
- Injected required landing page utility classes and animations into `main.css`.

## [1.3.13] - 2026-06-09
### Changed
- **Editor Tweaks**: Removed the iframe-based live preview based on user feedback. The system now simply disables the confusing blank Gutenberg editor and Classic editor text area for ACF-driven pages, keeping only the clean data-entry panel.

## [1.3.12] - 2026-06-09
### Added
- **Page Live Preview**: Added a new visual preview system (`inc/page-preview.php`) for ACF-driven page templates.
- Disabled the default Gutenberg block editor for pages using ACF-based templates (e.g., Home, About, Contact) to avoid layout confusion and visual mismatch.
- Removed the Classic Editor text area for these templates to provide a clean, data-entry focused backend interface.
- Injected a live frontend iframe preview at the top of the editing screen, allowing administrators to visually review changes in real-time as they update ACF fields.

## [1.3.11] - 2026-06-08
### Fixed
- Fixed WooCommerce B2B single product layout stacking issue by injecting missing responsive grid utility classes (`lg:grid-cols-2`, `gap-0`, `lg:gap-8`) into the "No-Build" `main.css`.
- Overrode default WooCommerce `.woocommerce-product-gallery` floats to ensure correct Flex/Grid behavior in the custom template.
- Restored `aspect-ratio` inline styling and correct utility classes for `content-product.php`.

## [1.3.10] - 2026-06-08
### Added
- **Product Page Templates**: Added `page-product-category.php` and `page-product-single.php` to allow users to build custom landing pages for specific product categories or single products via the Page Editor.
- Added corresponding ACF Field Groups for the new product landing page templates to easily select WooCommerce categories/products and configure custom heroes.

## [1.3.9] - 2026-06-08
### Added
- **WooCommerce B2B Templates Rearchitecture**: Deeply customized WooCommerce templates to fit a B2B catalog model without ecommerce checkout flows.
- Overridden `archive-product.php` and `content-product.php` for a modern two-column layout (sidebar category tree + product grid) with key attributes snippet (Power, CCT, Beam Angle).
- Overridden `single-product.php` and `content-single-product.php` to include an advanced image gallery, product summary, and dynamic key specifications list.
- Overridden `tabs.php`, `product-attributes.php`, and `related.php` with Tailwind CSS styling and an integrated ACF-driven "Downloads & Resources" section.
- Added `woocommerce-b2b.php` module to remove prices, cart, and reviews, and introduce a contextual "Inquire Now" CTA button.
- Added new ACF Field Groups for Product Categories (Banner Image, Subtitle) and WooCommerce Products (Subtitle, Downloads Repeater).

## [1.3.8] - 2026-06-08
### Added
- **Theme License Activation System**: Introduced a commercial license activation requirement.
- Implemented global restrictions for unactivated themes: disabled module toggles, settings modifications, ACF options, and WordPress Customizer.
- Added a dedicated License Activation dashboard page.

## [1.3.7] - 2026-06-08
### Added
- Pre-filled Global GEO Entities: For any page/post missing custom GEO entities, the theme now automatically injects `Commercial Lighting, 48V Magnetic Track Light, Zhongshan Lighting Manufacturer` into JSON-LD Schema (`@keywords`, `@description`, `@Organization.address`) and basic Meta Tags (`<meta name="keywords">`).
- **Pre-configured SEO TDK Mapping**: Built-in, high-quality Title, Description, and Keywords specifically designed for an OEM/ODM LED Commercial Lighting factory. Applies to all major theme pages (Home, About, Products, Solutions, Cases, Contact, Quality, Distributor) automatically for immediate out-of-the-box SEO impact without requiring external plugins.
- **Pre-configured AEO Takeaways**: Automatically injects AI Summary and Key Takeaways for crucial B2B conversion pages (Home, About, Quality, Distributor) if they haven't been manually set in ACF. This feeds directly into ChatGPT and Perplexity.
- **ACF AEO Field Initialization**: The pre-configured AEO Takeaways and AI Summaries are now actively seeded into the database (ACF fields) on theme update/activation, allowing site admins to visibly edit and tweak the AI engine optimizations directly from the page editor instead of them just being hidden fallback values.

## [1.3.6] - 2026-06-08
### Added
- **Deep SEO, GEO & AEO Optimization Module** (`inc/seo-geo-aeo.php`).
- AEO Content Injection: Automatically injects AI Summary & Key Takeaways into `single.php` and `single-case.php` for AI Answer Engines (ChatGPT, Perplexity).
- GEO Entities mapping: Supports adding target regions and industries to JSON-LD Schema.
- Global GEO entities fallback: Pre-fills missing pages with default entities (Commercial Lighting, 48V Magnetic Track Light, Zhongshan Lighting Manufacturer).
- Comprehensive Schema.org: Organization, WebSite, BreadcrumbList, Article/NewsArticle, FAQPage, and ItemList for archive pages.
- Footer Latest News Component: Added `class-erdu-footer-news.php` to improve internal linking and freshness signals.

## [1.3.5] - 2026-06-07

### Added
- Added `Header Logo Size` configuration in Header Layout settings.
- Added `Hero Background Image` and `Hero Subtitle` rendering in the Contact Us page.

### Changed
- Improved Contact Us page UI to closely match design specifications:
  - Form layout refactored with a more spacious 2-column grid and modern input styles.
  - "Contact Persons" cards updated with clean backgrounds, paddings, and rounded corners.
  - "Connect With Us" social buttons refined and properly linked to global WhatsApp/WeChat settings.
- Refined FAQ accordion design globally (used in Contact and block renders) with clean white cards, `+` icons, and better spacing.

### Fixed
- Fixed Contact Form submission failing due to missing `Subject` field in the frontend.
- Added missing `Estimated Quantity` field support in the Contact Form email handler.
- Fixed `Page Content` and `Introduction` fields not rendering on the Contact Us page.
- Fixed a fatal error caused by `erdu_get_theme_colors()` missing declaration.
- Fixed a parse error caused by an extra closing brace in the footer about widget.
- Enhanced About Us page with SVG icons for Tab navigation, configurable timeline titles, and custom value icons.

## [1.3.4] - 2026-06-07

### Fixed & Enhanced
- Refactored Footer Contact Info architecture:
  - Footer contact details (address, phone, email, hours, whatsapp, wechat) now sync directly from `Theme Settings` > `Global`.
  - Removed redundant contact input fields and Appearance settings from Footer ACF Builder.
  - Unified Footer component colors to inherit globally defined Theme Colors.

## [1.3.3] - 2026-06-07

### Fixed & Enhanced
- Refactored Social Links architecture: 
  - Added centralized Social Media Links settings in `Theme Settings` > `Global`.
  - Removed redundant Repeater fields for social links in Header and Footer ACF Builder.
  - Header Social Icons, Header Element Popups (Social block), and Footer About section now dynamically read from the single global source of truth.
  - Added new platform support: Twitter / X, WhatsApp, WeChat, TikTok.

## [1.3.2] - 2026-06-07

### Fixed & Enhanced
- Re-architected mobile menu rendering and toggle mechanism:
  - Switched from Tailwind `hidden/block` to inline CSS `max-height/opacity` transitions for smooth sliding animation.
  - Forced mobile menu width to 100% and removed `bg-white` hardcoding.
  - Synchronized mobile menu background with Header's dynamic transparent state (becomes transparent when Header is transparent on Hero).
  - Improved mobile menu items styling: changed active state to bold instead of background block.

## [1.3.1] - 2026-06-07

### Fixed & Enhanced
- Updated default Search ACF configs: set default style to `fullscreen` and default icon size to `sm`.
- Added new Search config: Input Width for `inline` style (Small/Medium/Large).
- Fixed Dropdown Search panel layout: improved mobile positioning and expanded desktop width to `96`.

## [1.3.0] - 2026-06-07

### Added
- **Advanced Search Component Refactoring**:
  - Added new ACF config options for Search: Size (Small/Medium/Large), Style (Fullscreen/Dropdown/Inline).
  - Implemented Local Storage-based Search History feature with clear functionality.
  - Added Promoted Search Keywords config support.
  - Integrated Search History and Promoted Keywords directly into Dropdown, Inline, and Fullscreen search interfaces.

## [1.2.2] - 2026-06-07

### Fixed
- Fixed mobile menu toggle logic conflicts between inline JavaScript and `main.js`.
- Improved mobile/tablet menu layout (added absolute positioning, shadow, increased tap targets, and better gap spacing).

## [1.2.1] - 2026-06-07

### Fixed
- Fixed Header transparent mode not working correctly when hero section is at the top.
- Fixed Header search, language switcher, and CTA icons not displaying due to flex layout and responsive class conflicts.

## [1.2.0] - 2026-06-06

### Added
- **Header Settings ACF Options Page**: Created dedicated Header Settings page under ERDU Dashboard
  - Layout options: Default / Centered Logo / Split Menu, width, height, sticky, transparent hero
  - Element visibility toggles: search, language switcher, phone, email, address, CTA, social icons
  - Mega Menu builder with custom blocks (Links, Product Categories, Image Card, Custom HTML)
  - Top Bar with customizable content, background/text colors
  - Contact Info, CTA Button, Social Links, and Appearance tabs
  - New Header components: Search, Language Switcher, Contact Info, Social Icons, Top Bar, Mega Menu, CTA
- **Reference Page Style Sync**: Updated multiple page templates to match reference design
  - Contact page: 1:2 grid layout, compact info cards, product select options
  - News page: pill-style category filters, article cards with calendar icons
  - Case Studies page: category overlay badges, meta separators, orange tags, arrow links
  - Distributor page: full redesign with benefits grid, success stories, application steps, requirements/types/regions, updated form
  - Quality page: 5-step horizontal process, testing equipment, certifications, parameters table, supply chain partners
- **Initial Demo Data**: Updated sample Case Studies with reference-page data written on theme activation

### Changed
- **Admin Dashboard Cleanup**: Removed standalone Page Management page; Pages now managed via native WordPress `Pages` menu
  - Removed Pages entry from Dashboard submenu and Quick Settings
  - Removed `erdu_pages_page()` and related admin CSS
- **Theme Settings Consolidation**: Removed Colors entry from Customizer/Quick Settings; colors unified under ACF Theme Colors
- **Contact Form Localization**: Updated product dropdown options to match reference site
- **Distributor Form**: Replaced legacy fields with reference-page fields (business type, city, revenue, target market, first order)
- Bumped theme version to `1.2.0`

### Fixed
- Theme Settings link in Quick Settings now correctly links to Theme Colors ACF page

## [1.1.0] - 2026-06-06

### Added
- **Dynamic CSS Generator**: Implemented real-time theme color customization via ACF Options Page
  - Added `Erdu_Dynamic_CSS` class for generating CSS custom properties (`:root` variables)
  - Created ACF Options Page "Theme Colors" under ERDU admin menu with 12 configurable color fields
  - Added CSS utility classes: `.erdu-text-primary`, `.erdu-bg-primary`, `.erdu-hover-primary`, etc.
  - Supports Brand Colors, Text Colors, Background Colors, and Footer Colors tabs
- **Header/Footer Hook-driven Architecture**: Refactored to Astra-style component system
  - Implemented `Erdu_Builder_Header` with components: Logo, Menu, Button, Mobile Trigger
  - Implemented `Erdu_Builder_Footer` with components: About, Links, Contact, Newsletter, Copyright
  - Added action hooks: `erdu_above_header`, `erdu_primary_header`, `erdu_below_header`, `erdu_above_footer`, `erdu_primary_footer`, `erdu_below_footer`
- **Global Skill**: Created `Yundian+WordPress Theme Customize Skill` for AI-assisted B2B theme development
  - Supports WooCommerce B2B customization, SEO/GEO/AEO optimization
  - Includes visual design standards and video integration guidelines
- **Documentation**: Added design specs and implementation plans in `docs/superpowers/`

### Changed
- Refactored `header.php` and `footer.php` to use hook-driven component architecture
- Updated `main.css` to use CSS custom properties for dynamic theming
- Modified Header/Footer components to use dynamic color classes
- Added MIT License and updated README with project introduction

### Fixed
- Added `.gitignore` to exclude `astra/` reference directory from version control

## [1.0.0] - 2026-06-05

### Added
- Initial release of ERDU Lighting WordPress theme
- No-Build architecture with hand-written Tailwind-like utility classes
- ACF Pro integration for custom fields and blocks
- Custom post types: Products (`erdu_product`) and Case Studies (`erdu_case`)
- WooCommerce compatibility layer for B2B inquiry mode
- SEO/GEO/AEO optimized page templates
- Fully configurable Footer via ACF Options Page
- Admin Dashboard with module management
- Responsive design with mobile menu
- Multi-language support structure (EN/CN)

[Unreleased]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/compare/v1.2.0...HEAD
[1.2.0]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/releases/tag/v1.0.0
