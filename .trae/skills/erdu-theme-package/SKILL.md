---
name: "erdu-theme-package"
description: "Packages the ERDU WordPress theme into a release ZIP. Invoke when user asks to package, build, or release the theme. Always runs PHP checks first."
---

# ERDU Theme Package Skill

## Purpose
打包 ERDU Lighting WordPress 主题为可发布的 ZIP 文件。在打包前必须执行 PHP 静态检查，确保没有语法问题导致网站白屏。

## When to Invoke
- 用户说"打包主题"、"发布主题"、"build theme"、"release theme"
- 用户要求生成主题安装包
- 任何需要生成 `erdu-wp-theme-*.zip` 的场景

## Workflow

### Step 1: PHP 静态检查（强制）
运行项目自带的检查脚本：
```powershell
powershell -ExecutionPolicy Bypass -File debug\check-php-issues.ps1
```

检查内容：
- PHP 关闭标签缺失（如 `endif; ?` 漏了 `>`）
- HTML 实体泄漏（如 `?003e`、`?003c`）
- 短标签使用
- 其他常见 PHP 语法问题

**如果检查发现问题**：
1. 列出所有问题文件和行号
2. 修复所有问题
3. 重新运行检查，直到通过
4. 提交修复到 git

**如果检查通过**：继续下一步

### Step 2: Git 提交（如有未提交更改）
```powershell
git status
```

如果有未提交的修改：
```powershell
git add <modified-files>
git commit -m "fix: resolve PHP issues found by pre-package check"
```

### Step 3: 更新版本号
读取 `style.css` 中的版本号，建议递增：
- 小修复/优化：patch +1（如 1.3.0 -> 1.3.1）
- 新功能：minor +1（如 1.3.0 -> 1.4.0）
- 重大重构：major +1（如 1.3.0 -> 2.0.0）

更新以下位置的版本号：
1. `style.css` 中的 `Version:`
2. `functions.php` 中的 `ERDU_VERSION`
3. `CHANGELOG.md` 中添加新版本记录
4. 提交版本更新

### Step 4: 打包
```powershell
git archive --format=zip --output="erdu-wp-theme-v{VERSION}.zip" HEAD
```

### Step 5: 验证
```powershell
Get-ChildItem erdu-wp-theme-v{VERSION}.zip | Select-Object Name, Length, LastWriteTime
```

## Output
- 生成 `erdu-wp-theme-v{VERSION}.zip` 文件
- 报告文件大小和生成时间
- 确认打包成功

## Notes
- 使用 `git archive` 打包，自动排除 `.git/`、`.trae/`、`debug/` 等目录
- 确保 `check-php-issues.ps1` 脚本存在且可执行
- 打包前必须确保所有更改已提交到 git