# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
