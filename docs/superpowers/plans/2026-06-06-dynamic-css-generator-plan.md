# 实施计划: 动态 CSS 生成器 (Dynamic CSS Generator)

## 1. 文件创建
- `inc/class-erdu-dynamic-css.php` - 核心生成器类
- `inc/acf-theme-colors.php` - ACF 颜色配置字段

## 2. 核心类实现
`Erdu_Dynamic_CSS` 单例类：
- `get_color_settings()`: 从 ACF Options 读取颜色，失败时使用默认值
- `generate_css_vars()`: 构建 CSS 变量数组
- `output_dynamic_css()`: 在 `wp_head` 输出 `<style>` 标签
- `generate_utility_classes()`: 生成 `.erdu-*` 工具类
- `var_ref()`: 静态方法，返回 `var(--erdu-xxx, fallback)` 字符串

## 3. ACF 配置实现
- 注册 Options Page: `erdu-theme-colors`（位于 ERDU 菜单下）
- 4 个 Tab 分组：Brand Colors, Text Colors, Background Colors, Footer Colors
- 12 个 `color_picker` 字段，每个带默认值和说明

## 4. CSS 改造
- `main.css`: 在顶部添加 `:root` 变量定义，将 `body` 颜色改为 `var(--erdu-text)`
- 新增工具类：`.erdu-text-primary`, `.erdu-bg-primary`, `.erdu-hover-primary` 等

## 5. 组件适配
- `class-erdu-header-logo.php`: Logo 背景改为 `erdu-bg-primary`
- `class-erdu-header-button.php`: CTA 按钮改为 `erdu-bg-primary erdu-hover-primary`
- `class-erdu-footer-about.php`: 图标背景改为 `erdu-bg-primary`，JS hover 使用 CSS 变量
- `class-erdu-footer-newsletter.php`: 提交按钮改为 `erdu-bg-primary`

## 6. 集成
- `functions.php`: 引入并初始化 `Erdu_Dynamic_CSS` 和 ACF 颜色配置

## 7. 测试验证
- 确认后台出现 Theme Colors 菜单
- 修改颜色后前台即时生效
- 确认所有组件正确应用新颜色
