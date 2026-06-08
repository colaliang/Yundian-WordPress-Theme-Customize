# ERDU Cloud Templates (Astra-style Starter Templates) Design Spec

## 1. Overview
The goal is to implement an Astra-style "Starter Templates" system for the ERDU WordPress theme. This system separates the theme's code structure from its default content, allowing users to browse and import fully pre-configured templates (pages, ACF data, global settings, menus) from a cloud repository immediately after theme installation.

## 2. Architecture & Components

### 2.1 Template Library UI (Frontend in WP Admin)
- **Location:** A new submenu under the ERDU dashboard (e.g., `admin.php?page=erdu-templates`).
- **Features:**
  - Fetches the available template list from the cloud API.
  - Displays templates in a grid view with thumbnails, titles, and categories.
  - Allows previewing a template.
  - "Import" button triggers an AJAX-based step-by-step import process with a visual progress bar.

### 2.2 Import Engine (Backend)
The import process is handled via WordPress AJAX endpoints to avoid timeout issues during large imports. It executes in steps:
1. **Fetch Data:** Download the target template's JSON schema from the cloud API.
2. **Global Settings:** Update `erdu_settings`, ACF theme colors, and other global options.
3. **Page Creation:** Create pages (`wp_insert_post`) and set appropriate page templates (`_wp_page_template`).
4. **ACF Data Injection:** Inject specific text, layout toggles, and content into the newly created pages using `update_field()`.
5. **Site Setup:** Set `page_on_front` (Home) and `page_for_posts` (Blog).
6. **Menus:** Create or update WordPress navigation menus and assign them to theme locations.

### 2.3 JSON Schema Design
Templates will be defined using a standardized JSON structure.
```json
{
  "info": {
    "name": "Default B2B Factory",
    "version": "1.0",
    "category": "industrial"
  },
  "options": {
    "erdu_settings": {
      "header_sticky": true,
      "phone": "+86-..."
    },
    "acf_colors": {
      "primary_color": "#FF5722"
    }
  },
  "pages": [
    {
      "slug": "home",
      "title": "Home",
      "template": "front-page.php",
      "acf_data": {
        "home_hero_title": "Professional 48V Magnetic Track Lights",
        "home_hero_subtitle": "..."
      }
    }
  ],
  "menus": {
    "primary": [
      {"label": "Home", "type": "page", "slug": "home"},
      {"label": "Products", "type": "page", "slug": "products"}
    ]
  }
}
```

### 2.4 Cloud API Integration (Placeholders)
Since the actual cloud infrastructure will be built later, we will implement placeholder functions to mock the API responses:
- `erdu_api_get_templates_list()`: Returns a list of available templates.
- `erdu_api_get_template_data($id)`: Returns the JSON schema for a specific template.

### 2.5 Refactoring Existing Default Data
- Currently, `functions.php` contains a massive array in `erdu_get_page_acf_defaults()` that hardcodes the default content.
- **Action:** This array will be extracted into a local JSON file (e.g., `inc/templates/default-base.json`).
- On fresh theme activation, the theme will perform a "silent import" of this local JSON file to ensure the site looks good out-of-the-box even without connecting to the cloud.

## 3. Execution Plan Steps
1. **Data Extraction:** Move hardcoded ACF defaults from `functions.php` to `inc/templates/default-base.json`.
2. **API Placeholders:** Create `inc/cloud-templates/api.php` to simulate cloud responses.
3. **Import Engine:** Create `inc/cloud-templates/importer.php` with AJAX handlers for parsing JSON and creating WP entities.
4. **Admin UI:** Build the React/Vanilla JS interface in `inc/cloud-templates/admin-page.php` for the template gallery and import progress.
5. **Theme Setup Integration:** Modify `theme-setup.php` to trigger the silent import of `default-base.json` on activation if the site is empty.

## 4. Self-Review Notes
- **Placeholder Check:** API URLs will be mocked internally. The structure supports easy swapping to `wp_remote_get()` later.
- **Consistency:** The JSON schema directly mirrors the required inputs for `update_field` and `wp_insert_post`, ensuring a smooth translation.
- **Scope:** The scope is contained entirely within the admin area and activation hooks. It does not affect frontend rendering performance.
