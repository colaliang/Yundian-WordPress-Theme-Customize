# Implementation Plan: ERDU Cloud Templates

## Overview
This document outlines the step-by-step implementation plan for the ERDU Cloud Templates feature, based on the design spec `2026-06-08-cloud-templates-design.md`. **This is a design/planning document only; no coding has been executed yet.**

## Phase 1: Data Decoupling & JSON Base Template
**Objective:** Separate hardcoded content from PHP logic into a manageable JSON structure.
- **Task 1.1:** Create `inc/templates/default-base.json`. Translate the existing massive array from `erdu_get_page_acf_defaults()` into the new JSON schema (covering global settings, pages, and ACF data).
- **Task 1.2:** Clean up `functions.php`. Remove the `erdu_get_page_acf_defaults()` function and the hardcoded page creation arrays (`erdu_create_theme_pages`).

## Phase 2: Mock Cloud API
**Objective:** Provide placeholder functions to simulate cloud API requests, preparing for future real API integration.
- **Task 2.1:** Create `inc/cloud-templates/api.php`.
- **Task 2.2:** Implement `erdu_api_get_templates_list()` to return a dummy array of templates (e.g., "Default B2B Factory", "Tech Startup", "Modern Agency").
- **Task 2.3:** Implement `erdu_api_get_template_data($id)` to return the full JSON data. For the default template ID, it will read and return the contents of `inc/templates/default-base.json`.

## Phase 3: Core Import Engine
**Objective:** Build the backend logic to process the JSON schema and create WordPress entities without timing out.
- **Task 3.1:** Create `inc/cloud-templates/importer.php`.
- **Task 3.2:** Implement step-by-step AJAX endpoints:
  - `step=fetch`: Fetch JSON data from API and store temporarily.
  - `step=global`: Update `erdu_settings`, `erdu_modules`, and ACF color options.
  - `step=pages`: Loop through JSON `pages` array, use `wp_insert_post`, and set `_wp_page_template`.
  - `step=acf`: Update ACF fields for each newly created page using `update_field()`.
  - `step=menus`: Create navigation menus and assign them to `primary` and `footer` locations.
  - `step=setup`: Update WP core options like `show_on_front`, `page_on_front`, and `page_for_posts`.

## Phase 4: Admin UI (Template Library)
**Objective:** Create the user interface for browsing and importing templates inside the WP Admin.
- **Task 4.1:** Create `inc/cloud-templates/admin-page.php`.
- **Task 4.2:** Register the submenu page `admin.php?page=erdu-templates` under the main ERDU dashboard menu.
- **Task 4.3:** Build the template grid UI using HTML/CSS (matching the existing ERDU dashboard aesthetic).
- **Task 4.4:** Implement vanilla JavaScript (or lightweight React if preferred) to handle the "Import" button click, sequentially calling the AJAX endpoints defined in Phase 3 and updating a visual progress bar.

## Phase 5: Theme Activation Integration
**Objective:** Ensure the theme still works out-of-the-box by executing a silent import on fresh installations.
- **Task 5.1:** Update `inc/theme-setup.php` (or `functions.php`). Hook into `after_switch_theme`. Check if essential pages exist; if not, trigger a direct (non-AJAX) PHP import using the core logic from the Import Engine and `default-base.json`.
- **Task 5.2:** Ensure all new files from `inc/cloud-templates/` are properly required in `functions.php`.

## Definition of Done
The plan is considered complete when a user can go to "ERDU -> Templates", see a list of templates, click "Import", watch a progress bar complete, and then view their site fully populated with the selected template's structure and content.
