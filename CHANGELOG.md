# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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

[Unreleased]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/colaliang/Yundian-WordPress-Theme-Customize/releases/tag/v1.0.0
