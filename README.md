# ERDU Lighting - B2B WordPress Theme (尔度照明定制主题)

## 项目简介 (Project Overview)

本项目是专为 **ERDU Lighting (尔度照明)** —— 专业的 48V 磁吸轨道灯制造商，量身定制的高质量 B2B 独立站 WordPress 主题。该项目采用了现代化的无构建（No-Build）架构，并深度结合 ACF Pro，摒弃了传统页面构建器的臃肿，实现了极佳的性能、SEO 以及灵活的后台管理体验。

## 核心技术架构 (Tech Stack & Architecture)

1. **纯净无构建前端 (No-Build)**
   - 彻底摒弃 Node.js、Webpack、Vite 等构建工具的依赖。
   - 前端样式基于 `assets/css/main.css` 中手写的类 Tailwind 实用工具类（Utility Classes）构建。
   - 零依赖、极速加载，便于直接在服务器端或任何轻量级 IDE 中进行调整。
2. **ACF Pro 驱动 (ACF-Driven)**
   - **自定义区块 (ACF Blocks)**：通过 `inc/acf-blocks.php` 注册，替代 Elementor 等构建器。页面由 Hero、Timeline、Stats、Team 等模块化区块自由组合。
   - **主题选项页 (Options Page)**：提供全局配置面板，方便管理员自定义页脚信息、联系方式、全局配色及社交媒体链接。
   - **灵活的自定义字段**：针对产品和案例页面，提供高度结构化的字段录入（如产品功率、电压、PDF 规格书等）。
3. **组件化与 PHP 模板解耦**
   - 所有的 HTML 结构硬编码在轻量级的 PHP 模板文件中（如 `front-page.php`、`single.php`）。
   - 数据与文案通过安全的 `erdu_page_field()` 函数从后台提取，前端代码极为干净。

## Yundian+WordPress 深度定制规范 (Yundian WP Customize Skill)

本项目已融入 **“云店+WordPress深度定制技能 (Yundian WP Customize Skill)”**，确保在后续迭代或新站开发中遵循以下顶级规范：

1. **WooCommerce B2B 改造**
   - 深度集成 WooCommerce，但不用于传统的 C 端在线零售。
   - 隐藏购物车与价格体系，将“加入购物车”流程改写为 B2B 场景下的“发送询盘 (Send Inquiry)”。
   - 通过 ACF 为 WooCommerce 产品扩展 B2B 专用参数（规格书、应用场景、包装信息）。
2. **深度 SEO、GEO 与 AEO 优化**
   - **SEO (搜索引擎优化)**：全站采用完美的语义化 HTML (h1-h6, article/section)、结构化数据 (Schema.org JSON-LD)、友好的 URL 与 Alt 属性。
   - **GEO/AEO (生成式/问答引擎优化)**：内容结构逻辑清晰，针对 ChatGPT、Claude、Perplexity 等 AI 模型提供 Direct Answers、结构化表格和 FAQ 区块，确保在 AI 搜索时代的精准曝光与引用。
3. **顶级视觉规范与视频整合**
   - **国际化 UI/UX**：严格遵守 `awesome-design-md` 等业界知名设计标准，把控排版层级 (Typography Hierarchy)、留白 (Whitespace) 和对比度。
   - **优雅的视频整合**：对于背景视频、产品演示和工厂实景，采用响应式自适应比例、延迟加载 (Lazy Loading) 和精美封面图 (Poster) 策略，平衡视觉震撼与极速性能。

## 目录结构 (Directory Structure)

```text
erdu-wp-theme/
├── assets/
│   ├── css/
│   │   ├── main.css      # 核心 Utility CSS 框架
│   │   └── admin.css     # 后台定制样式
│   └── js/
│       └── main.js       # 核心交互逻辑
├── inc/                  # 核心功能模块
│   ├── acf-blocks.php    # ACF 区块注册
│   ├── acf-fields.php    # CPT 字段定义
│   ├── theme-setup.php   # 主题初始化
│   └── ...
├── woocommerce/          # WooCommerce B2B 定制模板 (规划中)
├── front-page.php        # 首页模板
├── functions.php         # 主题入口函数
├── style.css             # 主题声明文件
└── README.md             # 项目说明
```

## 开发与维护指南 (Development Guide)

- **新增样式**：请优先在 HTML 元素中使用现有的 CSS 实用类（见 `main.css`）。如需添加新类，请遵循现有的命名规范（如 `p-4`, `text-white`, `flex-col` 等）。
- **修改全局配色**：请在 `main.css` 的 `:root` 中调整 `--erdu-orange` 等 CSS 变量。
- **页面内容修改**：绝大多数内容均可通过 WordPress 后台的页面编辑器或“ERDU”全局设置面板直接修改，无需改动代码。

## 许可证 (License)

本项目主题受版权保护，未经许可不得擅自用于其他商业项目。
