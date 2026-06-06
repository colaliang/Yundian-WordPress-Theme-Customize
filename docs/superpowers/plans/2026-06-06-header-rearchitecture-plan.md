# 实施计划: Header/Footer Hook-driven Rearchitecture

## 1. 目录与文件创建
- 创建目录 `inc/builder/` 和 `inc/builder/header/`
- 创建核心类 `inc/builder/class-erdu-builder-header.php`
- 创建组件文件：
  - `inc/builder/header/class-erdu-header-logo.php`
  - `inc/builder/header/class-erdu-header-menu.php`
  - `inc/builder/header/class-erdu-header-button.php`
  - `inc/builder/header/class-erdu-header-mobile-trigger.php`

## 2. 编写组件类
每个组件类包含一个 `render()` 方法输出 HTML：
- `Erdu_Header_Logo`: 输出 `<a href="...">...</a>` logo 代码
- `Erdu_Header_Menu`: 输出 Desktop Menu 和 Mobile Menu 代码
- `Erdu_Header_Button`: 输出语言切换/CTA 按钮 (Language Switcher)
- `Erdu_Header_Mobile_Trigger`: 输出 Mobile Toggle Button

## 3. 编写核心驱动类
`Erdu_Builder_Header` 单例类：
- `__construct()` 负责调用 `add_action('erdu_primary_header', ...)`
- 提供不同优先级绑定各个组件的 `render()` 方法：
  - Logo (priority 10)
  - Menu (Desktop) (priority 20)
  - Button/Language (priority 30)
  - Mobile Trigger (priority 40)
  - Mobile Menu (绑定在 primary_header 之后，或独立 hook `erdu_after_header`)

## 4. 重构 header.php
- 移除现有的 `<header>` 内部结构。
- 替换为：
  ```php
  <header class="erdu-header sticky top-0 z-50 bg-white shadow-sm">
      <div class="erdu-container">
          <div class="flex items-center justify-between h-16">
              <?php do_action('erdu_primary_header'); ?>
          </div>
      </div>
      <?php do_action('erdu_after_header'); ?>
  </header>
  ```

## 5. 更新 functions.php
- `require_once ERDU_DIR . '/inc/builder/class-erdu-builder-header.php';`
- 初始化核心类 `Erdu_Builder_Header::get_instance();`