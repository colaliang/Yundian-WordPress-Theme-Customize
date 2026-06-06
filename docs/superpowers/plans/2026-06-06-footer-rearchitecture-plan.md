# 实施计划: Footer Hook-driven Rearchitecture

## 1. 目录与文件创建
- 创建目录 `inc/builder/footer/`
- 创建核心类 `inc/builder/class-erdu-builder-footer.php`
- 创建组件文件：
  - `inc/builder/footer/class-erdu-footer-about.php` (Logo + 简介 + 社交图标)
  - `inc/builder/footer/class-erdu-footer-links.php` (快速链接)
  - `inc/builder/footer/class-erdu-footer-contact.php` (联系方式)
  - `inc/builder/footer/class-erdu-footer-newsletter.php` (订阅表单)
  - `inc/builder/footer/class-erdu-footer-copyright.php` (底部版权)

## 2. 编写核心驱动类
`Erdu_Builder_Footer` 单例类：
- `__construct()` 绑定 Hook。
- `get_footer_settings()`: 统一读取并缓存 ACF 的 `ft_` 开头的所有配置，避免子组件重复查询数据库。
- `render_primary_footer()`: 绑定在 `erdu_primary_footer`，负责输出 Grid 容器。它会内部调用四个 Column 的 render 方法。
- `render_below_footer()`: 绑定在 `erdu_below_footer`，输出版权区域。

## 3. 编写组件类
每个组件类包含一个静态的 `render($settings)` 方法：
- `Erdu_Footer_About`: 根据 `$settings` 渲染 Logo 图像/图标，输出 About 文本和 SVG 社交图标。
- `Erdu_Footer_Links`: 遍历 `$settings['ft_quick_links']` 输出链接列表。
- `Erdu_Footer_Contact`: 渲染带有 SVG 图标的地址、电话、邮箱列表。
- `Erdu_Footer_Newsletter`: 渲染订阅表单。
- `Erdu_Footer_Copyright`: 替换 `{year}` 并输出底部文本。

## 4. 重构 footer.php
- 移除从行 13 到行 197 的所有 PHP 逻辑和 HTML 结构。
- 替换为：
  ```php
  <?php do_action('erdu_above_footer'); ?>
  
  <footer class="erdu-footer" style="background-color: <?php echo esc_attr(erdu_footer_field('ft_bg_color', '#1a1a2e')); ?>;">
      <div class="erdu-container py-12">
          <?php do_action('erdu_primary_header'); ?>
      </div>
      
      <?php do_action('erdu_below_footer'); ?>
  </footer>
  
  <?php wp_footer(); ?>
  </body>
  </html>
  ```

## 5. 更新 functions.php
- `require_once ERDU_DIR . '/inc/builder/class-erdu-builder-footer.php';`
- 初始化核心类 `Erdu_Builder_Footer::get_instance();`