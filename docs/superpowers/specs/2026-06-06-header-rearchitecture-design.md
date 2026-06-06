# 设计规范：Yundian-WP 三层架构 Header/Footer 重构 (Astra-style)

**日期**: 2026-06-06
**主题**: 重构组件加载机制，实现基于 Hook 的三层架构解耦
**参考对象**: Astra Theme (`inc/builder/`)

## 1. 目标 (Purpose)
当前的 `header.php` 和 `footer.php` 存在较多硬编码逻辑。随着项目（云店+定制主题）的发展，为了满足未来高复杂度、高扩展性的需求，我们需要将现有的硬编码页面结构重构为**基于 Hook 驱动 (Hook-driven)** 的三层架构，完全对标 Astra 的组件解耦模式。

## 2. 架构设计 (Architecture)

### 2.1 核心 Hook 注入层
在原生的 `header.php` 中，我们将剔除具体的 HTML 元素，仅保留包裹层与核心 Action 钩子。
*   `do_action( 'erdu_above_header' );` (顶部信息栏，如联系方式、社交图标)
*   `do_action( 'erdu_primary_header' );` (主导航栏，如 Logo、主菜单、移动端 Toggle)
*   `do_action( 'erdu_below_header' );` (底部扩展栏，如复杂巨型菜单或特定分类栏)

### 2.2 核心类驱动 (Core Loader Class)
创建一个全局单例类 `Erdu_Builder_Header` (参考 Astra_Builder_Header)。
*   **职责**：在 `__construct()` 中统筹所有的 `add_action` 注册。
*   **注册逻辑**：将具体的渲染方法绑定到上述的三个 Hook 上。

### 2.3 组件拆分 (Component Split)
在 `inc/builder/` 目录下创建独立的组件文件，每个组件负责渲染自己的 HTML 结构，并严格使用 Tailwind-like Utility Classes 保持样式的 No-Build 规范。
*   `class-erdu-header-logo.php`: 渲染 Site Identity (Logo/Title)。
*   `class-erdu-header-menu.php`: 渲染 Primary Menu。
*   `class-erdu-header-button.php`: 渲染 CTA/询盘按钮。
*   `class-erdu-header-mobile-trigger.php`: 渲染移动端汉堡菜单按钮。

## 3. 数据流与渲染过程 (Data Flow)
1.  WordPress 执行 `get_header()`。
2.  加载 `header.php`，触发 `do_action('erdu_primary_header')`。
3.  `Erdu_Builder_Header` 监听到动作，按优先级（Priority）依次执行绑定好的组件渲染方法。
4.  例如，先渲染 Logo (priority 10)，再渲染 Menu (priority 20)，最后渲染 Button (priority 30)。
5.  组件内部通过 `erdu_module_config()` 或 `get_theme_mod()` 获取后台设置的数据。

## 4. 优势与影响 (Trade-offs & Impacts)
*   **优点**：极高的可维护性与扩展性。如果后续需要增加顶部通栏广告（Top Banner），无需修改 `header.php`，只需写一个独立组件并 `add_action('erdu_above_header')` 即可。
*   **代价**：文件数量增加，引入了轻微的面向对象复杂性，对初级开发者的理解成本略有提升。

## 5. 后续步骤 (Next Steps)
1.  创建 `inc/builder/` 目录。
2.  编写 `class-erdu-builder-header.php` 核心驱动类。
3.  编写对应的 UI 组件类 (Logo, Menu, Mobile Trigger)。
4.  修改 `header.php`，移除旧的 HTML 并替换为 Hook。
5.  在 `functions.php` 中引入新的 Loader。