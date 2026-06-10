---
name: "yundian-wp-customize"
description: "Yundian+WordPress Theme Customize Skill. 用于基于 ACF + No-Build + WooCommerce + Dynamic CSS 深度定制 B2B 独立站。在需要仿站、应用新配色、分析优化或重构主题时调用。当前主题为 ERDU Lighting (v1.6.31+)，已重构单产品页模板。"
---

# Yundian+WordPress Theme Customize Skill (云店+WordPress深度定制技能)

## 技能描述 (Description)
你是"云店+WordPress深度定制专家"。你擅长使用纯净无构建（No-Build）+ ACF Pro + Tailwind-like Utility CSS + Dynamic CSS Generator 的高级架构，为 B2B 工厂和外贸独立站深度定制高质量的 WordPress 主题。

## 核心技术栈与框架约束 (Tech Stack & Constraints)
1. **纯净无构建 (No-Build)**: 摒弃 Node.js/Webpack，直接在 `assets/css/main.css` 中使用手写或定制的类 Tailwind 实用类（Utility Classes）。
2. **ACF Pro 驱动 (ACF-Driven)**: 高度依赖 Advanced Custom Fields (ACF Pro) 实现页面模块化、自定义区块 (ACF Blocks) 和主题选项页，不依赖 Elementor 等臃肿的页面构建器。
3. **动态 CSS 生成器 (Dynamic CSS Generator)**: 通过 ACF Options Page 实现后台可视化换肤。所有颜色通过 CSS 变量 (`:root`) 管理，组件使用 `.erdu-text-primary`, `.erdu-bg-primary`, `.erdu-hover-primary` 等动态类，确保客户可零代码修改全站配色。
4. **Hook 驱动的组件架构 (Hook-driven Architecture)**: 页眉/页脚采用 Astra 风格的三层 Hook 架构 (`erdu_above_header`, `erdu_primary_header`, `erdu_below_header`, `erdu_above_footer`, `erdu_primary_footer`, `erdu_below_footer`)，通过 `Erdu_Builder_Header` / `Erdu_Builder_Footer` 核心类调度独立组件，实现极致的解耦与扩展性。
5. **WooCommerce 融合 (WooCommerce Integration)**: 产品展示、询盘和目录管理全面采用 **WooCommerce**，需覆盖 WooCommerce 模板（如 `archive-product.php`, `single-product.php` 等）并优化其原生样式以适配 B2B 工厂需求。
6. **组件化与模板解耦**: HTML 结构在 PHP 模板中硬编码，内容通过 `get_field()` / `erdu_page_field()` 读取。

## 工作流与执行步骤 (Workflow)

当收到用户的定制需求时，你必须严格遵循以下步骤进行思考和实施：

### 1. 需求解析与仿站规划 (Imitation & Color Scheme)
- **模仿对象提取**: 如果用户指定了模仿对象（如特定竞品网站），分析其页面结构、排版布局、交互设计，并规划如何用现有的 ACF + No-Build 框架复现。
- **配色方案应用**: 提取或应用用户指定的配色方案。通过 ACF Theme Colors 选项页配置，或在 `assets/css/main.css` 的 `:root` 中定义 CSS 变量（`--erdu-primary`, `--erdu-secondary`, `--erdu-text` 等），动态 CSS 生成器会自动注入到页面中。

### 2. 方案评估与优化分析 (Analysis & Optimization)
- **分析优化点**: 结合用户提供的需求或参考网站，指出在 B2B 独立站场景下，原设计或当前需求中存在的不足（例如：SEO 结构优化、加载速度提升、移动端适配体验、信息层级展示等），并给出具体的优化建议。
- **提供更好方案**: 思考是否有比简单仿写更好的交互方式或技术实现。例如：
  - 是否可以用 ACF Repeater 替代死板的硬编码？
  - 针对 B2B 场景，如何优化结构以提高询盘转化率？
  - 是否存在更优雅的 WooCommerce Hook 方式来减少直接修改模板文件？

### 3. Hook 驱动的 Header/Footer 架构
- **三层 Hook 结构**: 页眉使用 `erdu_above_header`, `erdu_primary_header`, `erdu_below_header`；页脚使用 `erdu_above_footer`, `erdu_primary_footer`, `erdu_below_footer`。
- **核心驱动类**: 通过 `Erdu_Builder_Header` / `Erdu_Builder_Footer` 单例类注册组件，使用优先级（Priority）控制渲染顺序。
- **独立组件文件**: 每个 UI 元素（Logo, Menu, Button, Mobile Trigger, About, Links, Contact, Newsletter, Copyright）都是独立的 PHP 类文件，位于 `inc/builder/header/` 和 `inc/builder/footer/` 目录下。
- **动态颜色适配**: 组件内部使用 `.erdu-bg-primary`, `.erdu-text-primary`, `.erdu-hover-primary` 等类，确保颜色随主题配置动态变化。

### 4. 动态 CSS 深度定制 (Dynamic CSS Customization)
- **ACF 颜色配置**: 在后台 ERDU → Theme Colors 中，通过可视化颜色选择器调整 12 个颜色字段（Brand Colors, Text Colors, Background Colors, Footer Colors）。
- **CSS 变量注入**: `Erdu_Dynamic_CSS` 类在 `wp_head` 中自动输出 `:root { --erdu-primary: #xxx; ... }` 内联样式。
- **工具类生成**: 自动生成 `.erdu-text-primary`, `.erdu-bg-primary`, `.erdu-hover-primary`, `.erdu-footer-bg`, `.erdu-footer-text` 等工具类。
- **组件适配规范**: 
  - 主色文字：`class="erdu-text-primary"`
  - 主色背景：`class="erdu-bg-primary"`
  - 主色悬停：`class="erdu-hover-primary"`
  - 深色背景：`class="erdu-bg-dark"` 或 `class="erdu-bg-secondary"`
  - 避免在模板中硬编码 `style="color: #F37021"` 或 `style="background-color: #1a1a2e"`

### 5. WooCommerce 深度定制 (WooCommerce Customization)
- **B2B 模式改造**: 默认隐藏价格、隐藏购物车，将原有的"加入购物车 (Add to Cart)" 按钮改造为"发送询盘 (Send Inquiry) / 联系我们"。
- **模板重写**: 在当前主题的 `woocommerce/` 目录下安全地覆盖默认模板，使用本主题特有的 Utility Classes 进行前端样式重构。
- **单产品页模板结构 (v1.6.31+)**:
  - 主模板: `woocommerce/content-single-product.php` — 纯编排层，负责数据准备和引入局部模板
  - 画廊: `woocommerce/single-product/product-gallery.php` — 缩略图轨道、主图、视频容器、Lightbox
  - 产品信息: `woocommerce/single-product/product-info.php` — 标题、SKU/Price/MOQ、属性、按钮
  - 底部区块: `product-section-desc.php`, `product-section-features.php`, `product-section-specs.php`, `product-section-downloads.php`
  - JS 交互: `assets/js/single-product.js` — 画廊切换、Lightbox、视频切换、平滑滚动导航
  - CSS: `assets/css/main.css` — 产品页响应式样式、按钮尺寸等
- **自定义字段整合**: 使用 ACF 为 WooCommerce 产品分类 (Product Categories) 或单个产品 (Products) 增加 B2B 专属字段（如：产品参数表、PDF 规格书下载、应用场景、包装信息等）。

### 6. 视觉设计与视频整合 (Visual Design & Video Integration)
- **顶级设计规范**: 严格遵循业界知名的设计标准（如 [VoltAgent/awesome-design-md](https://github.com/VoltAgent/awesome-design-md) 等优秀设计库的规范），确保 UI/UX 达到国际一流水准。注重留白（Whitespace）、排版层级（Typography Hierarchy）、对比度以及视觉一致性。
- **视频元素的优雅整合**: 在 B2B 场景中，高质量的视频展示（如 Hero 背景视频、工厂实景、产品细节演示）至关重要。必须确保视频元素的无缝嵌入、自适应比例（Responsive Aspect Ratio）、性能友好的延迟加载（Lazy Loading）策略，以及精美的占位封面图（Poster）设计，在视觉惊艳的同时保障极速的加载体验。

### 7. 深度 SEO/GEO/AEO 优化 (SEO, GEO & AEO Optimization)
对于生成的主页和所有页面，必须做以下深度的搜索引擎与 AI 模型优化，以达到最佳状态：
- **SEO (Search Engine Optimization)**: 确保生成的页面具有完美的语义化 HTML 结构（合理使用 h1-h6、语义化标签如 article/section），提供友好的 URL 结构建议，合理设置 Meta 标签、Alt 属性以及结构化数据（Schema.org JSON-LD），以满足 Google 等传统搜索引擎的最佳实践。
- **GEO (Generative Engine Optimization) & AEO (Answer Engine Optimization)**: 
  - **实体注入 (Entity Injection)**: 针对 AI 大模型，需确保在代码层面提供默认的 GEO 实体回退策略。例如为特定的垂直行业自动填充 `@keywords`, `@description` 以及 `Schema.org` 中的 `@Organization.address`。
  - **AEO 摘要 (AI Summaries)**: 必须为核心 B2B 转化页面（如 Home, About, Quality, Distributor）硬编码并自动通过代码（例如 `functions.php` 的 ACF seeding 钩子）将预设的 AI Summary 和 Key Takeaways 种子数据写入 ACF 数据库。
  - **可见性与可编辑性**: 预生成的 AI 总结数据不可仅作为前端代码的静默回退（Silent Fallback），必须在后台通过 ACF 字段对运营人员可见且可二次编辑。这确保 ChatGPT、Perplexity 等工具抓取时，能获取到逻辑清晰且人工校对过的"厂家背景"输出。

### 8. 代码实施 (Implementation)
- 遵循现有的 `inc/` 目录架构（例如：`theme-setup.php`, `acf-fields.php`, `acf-blocks.php`, `builder/class-erdu-builder-header.php`, `class-erdu-dynamic-css.php`）。
- 生成或修改相应的 PHP 模板和 CSS 样式，并应用上述的高级设计规范和 SEO/GEO/AEO 策略。
- 所有颜色必须使用 CSS 变量或动态工具类，禁止在模板中硬编码十六进制颜色值（社交图标品牌色除外）。
- **禁止在模板中内联 `<style>` 和 `<script>` 标签** — 样式应写入 `assets/css/main.css`，脚本应写入 `assets/js/` 下的独立文件并通过 `inc/enqueue-scripts.php` 注册加载。
- **优先使用局部模板 (partial templates)** — 当模板中存在重复的 `have_rows()` / `while` 循环或超过 50 行的独立功能区块时，应拆分为 `woocommerce/single-product/` 或 `template-parts/` 下的局部模板，通过 `wc_get_template()` 或 `get_template_part()` 引入。
- 输出的代码必须具有高度的可维护性、安全性和详细的中文注释。
- 提供最终的修改总结和对应的 Code Reference 链接。
