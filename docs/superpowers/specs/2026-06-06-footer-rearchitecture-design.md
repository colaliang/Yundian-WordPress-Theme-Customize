# 设计规范：Yundian-WP 三层架构 Footer 重构 (Astra-style)

**日期**: 2026-06-06
**主题**: 重构 Footer 组件加载机制，实现基于 Hook 的解耦
**参考对象**: Astra Theme (`inc/builder/`)

## 1. 目标 (Purpose)
目前的 `footer.php` 包含了一大堆极其复杂的 HTML 和 PHP 逻辑（包括 ACF 字段的读取、多列 Grid 的渲染、Newsletter 的表单等）。为了提升可维护性，并对齐之前对 Header 的重构，我们需要将 Footer 也改造成基于 Hook 的组件驱动架构。

## 2. 架构设计 (Architecture)

### 2.1 核心 Hook 注入层
在原生的 `footer.php` 中，仅保留外层包裹结构，通过 Hook 输出内容：
*   `do_action( 'erdu_above_footer' );` (如：全站统一的 CTA 预订栏、Instagram Feed 栏)
*   `do_action( 'erdu_primary_footer' );` (主页脚，包含多列 Widget 区域：About, Links, Contact, Newsletter)
*   `do_action( 'erdu_below_footer' );` (底部版权栏，Copyright 和条款链接)

### 2.2 核心类驱动 (Core Loader Class)
创建单例类 `Erdu_Builder_Footer`。
*   负责在 `__construct()` 中将所有的 Footer 组件注册到上述 Hook。
*   负责统一处理之前散落在 `footer.php` 顶部的全局 ACF 配置读取，供子组件调用。

### 2.3 组件拆分 (Component Split)
在 `inc/builder/footer/` 目录下创建组件：
*   **Primary Footer Widgets**:
    *   `class-erdu-footer-about.php`: 渲染 Logo、简介与社交图标。
    *   `class-erdu-footer-links.php`: 渲染快速链接。
    *   `class-erdu-footer-contact.php`: 渲染联系信息。
    *   `class-erdu-footer-newsletter.php`: 渲染订阅表单。
*   **Below Footer**:
    *   `class-erdu-footer-copyright.php`: 渲染底部的版权信息。

## 3. 数据流与渲染过程 (Data Flow)
1.  主控类 `Erdu_Builder_Footer` 获取 ACF 的设置。
2.  `footer.php` 触发 `do_action('erdu_primary_footer')`。
3.  系统通过优先级顺序依次渲染四个 Column 组件（如果它们被后台开启）。
4.  渲染 `do_action('erdu_below_footer')` 输出 Copyright。

## 4. 后续步骤 (Next Steps)
1.  创建 `inc/builder/footer/` 目录。
2.  编写 `class-erdu-builder-footer.php`。
3.  编写各个 Column 的组件类。
4.  修改 `footer.php` 移除硬编码逻辑。
5.  在 `functions.php` 中引入。