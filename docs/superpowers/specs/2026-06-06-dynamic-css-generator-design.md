# 设计规范：动态 CSS 生成器 (Dynamic CSS Generator)

**日期**: 2026-06-06
**主题**: 实现基于 ACF 的后台可视化换肤系统
**参考对象**: Astra Theme Dynamic CSS, Elementor Global Colors

## 1. 目标 (Purpose)
当前主题的颜色（如爱马仕橙 `#F37021`）硬编码在 CSS 和 PHP 组件中。为了提升客户自主运营能力，实现零代码换肤，我们需要引入动态 CSS 生成器。

## 2. 架构设计 (Architecture)

### 2.1 核心组件
- **Erdu_Dynamic_CSS**: 单例类，负责读取 ACF 配置并生成内联 CSS
- **ACF Options Page**: 后台可视化颜色配置面板
- **CSS Custom Properties**: `:root` 变量定义，实现运行时覆盖

### 2.2 数据流
1. ACF Options Page 保存颜色配置到数据库
2. `Erdu_Dynamic_CSS` 在 `wp_head` 钩子中读取配置
3. 生成 `:root { --erdu-primary: #xxx; }` 内联样式
4. 组件通过 `var(--erdu-primary)` 或 `.erdu-bg-primary` 类应用颜色

### 2.3 颜色变量体系
| 变量名 | 默认值 | 用途 |
|--------|--------|------|
| `--erdu-primary` | `#F37021` | 主品牌色，按钮、链接、高亮 |
| `--erdu-primary-hover` | `#E05D10` | 主色悬停状态 |
| `--erdu-secondary` | `#2D1810` | 次品牌色，深色背景 |
| `--erdu-text` | `#333333` | 正文文字颜色 |
| `--erdu-text-light` | `#6b7280` | 次要/辅助文字 |
| `--erdu-bg-dark` | `#1a1a2e` | 深色区块背景 |
| `--erdu-bg-light` | `#f9fafb` | 浅色交替背景 |
| `--erdu-border` | `#e5e7eb` | 边框颜色 |
| `--erdu-footer-bg` | `#1a1a2e` | 页脚背景 |
| `--erdu-footer-text` | `#9ca3af` | 页脚文字 |
| `--erdu-footer-heading` | `#ffffff` | 页脚标题 |
| `--erdu-footer-hover` | `#F37021` | 页脚链接悬停 |
| `--erdu-footer-border` | `#374151` | 页脚边框 |

## 3. 技术实现 (Implementation)

### 3.1 动态 CSS 输出
```php
add_action('wp_head', array($this, 'output_dynamic_css'), 100);
```
输出格式：
```html
<style id='erdu-dynamic-css'>
:root {
  --erdu-primary: #F37021;
  --erdu-primary-hover: #E05D10;
  /* ... */
}
.erdu-text-primary { color: var(--erdu-primary) !important; }
.erdu-bg-primary { background-color: var(--erdu-primary) !important; }
.erdu-hover-primary:hover { background-color: var(--erdu-primary-hover) !important; }
</style>
```

### 3.2 组件适配策略
- **静态类**: 使用 `.erdu-bg-primary` 等预定义类
- **动态内联**: 通过 `style="color: var(--erdu-primary)"` 直接引用
- **JavaScript 交互**: `onmouseover="this.style.backgroundColor='var(--erdu-primary, #F37021)'"`

## 4. 优势与影响 (Trade-offs)
- **优点**: 客户可自主换肤，无需开发介入；零构建工具依赖；性能影响极小（仅增加 1-2KB 内联 CSS）
- **代价**: 需要逐步替换所有硬编码颜色；增加了 ACF Pro 依赖

## 5. 后续步骤 (Next Steps)
1. 继续将剩余页面模板中的硬编码颜色替换为 CSS 变量
2. 考虑增加预设配色方案（如深色模式、高对比度）
3. 将动态 CSS 缓存到文件，减少数据库查询
