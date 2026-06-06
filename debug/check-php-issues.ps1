# ============================================================
#  ERDU Theme - PHP Static Check Script
#  ----------------------------------------------------------
#  Purpose : Scan all PHP files for common syntax/closure issues
#            that can cause "There has been a critical error"
#            on a WordPress site.
#
#  Usage   : powershell -ExecutionPolicy Bypass -File debug\check-php-issues.ps1
#
#  Mandatory step BEFORE packaging a release.
# ============================================================

# Force UTF-8 output (PowerShell 5.1 uses GBK by default on Windows CN)
$OutputEncoding = [System.Text.Encoding]::UTF8
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

# Resolve project root dynamically (script is in /debug)
$ScriptDir  = Split-Path -Parent $MyInvocation.MyCommand.Path
$ProjectDir = Split-Path -Parent $ScriptDir
Set-Location $ProjectDir

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  ERDU Theme - PHP Static Check" -ForegroundColor Cyan
Write-Host "  Project : $ProjectDir" -ForegroundColor DarkGray
Write-Host "=================================================" -ForegroundColor Cyan

# Find all PHP files (exclude release and temp directories)
$files = Get-ChildItem -Path $ProjectDir -Filter "*.php" -Recurse -File | Where-Object {
    $_.FullName -notmatch "[\\/]release[\\/]" -and
    $_.FullName -notmatch "[\\/]debug[\\/]" -and
    $_.FullName -notmatch "[\\/]\.trae[\\/]" -and
    $_.FullName -notmatch "[\\/]\.git[\\/]" -and
    $_.FullName -notmatch "[\\/]\.package-tmp[\\/]"
}

$issueCount = 0
$totalLines = 0
$fileCount  = 0
$fileIssuesList = @()

foreach ($file in $files) {
    $fileCount++
    $fileIssues = @()

    try {
        $lines = [System.IO.File]::ReadAllLines($file.FullName)
    } catch {
        Write-Host ("[ERROR] Cannot read: " + $file.Name) -ForegroundColor Red
        continue
    }

    for ($i = 0; $i -lt $lines.Count; $i++) {
        $line = $lines[$i]
        $lineNum = $i + 1
        $totalLines++

        $hasIssue = $false

        # Check 1: PHP close tag endif; missing >
        if ($line -match 'endif;\s*\?\s*[^>=\s]') {
            $fileIssues += "  L$lineNum : bad endif close (missing >)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 2: PHP close tag endforeach; missing >
        if ($line -match 'endforeach;\s*\?\s*[^>=\s]') {
            $fileIssues += "  L$lineNum : bad endforeach close (missing >)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 3: PHP close tag endfor; missing >
        if ($line -match 'endfor;\s*\?\s*[^>=\s]') {
            $fileIssues += "  L$lineNum : bad endfor close (missing >)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 4: PHP close tag endwhile; missing >
        if ($line -match 'endwhile;\s*\?\s*[^>=\s]') {
            $fileIssues += "  L$lineNum : bad endwhile close (missing >)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 5: PHP close tag else; missing >
        if ($line -match 'else;\s*\?\s*[^>=\s]') {
            $fileIssues += "  L$lineNum : bad else close (missing >)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 6: 003e on its own line
        if ($line -match '^\s*003e\s*$') {
            $fileIssues += "  L$lineNum : stray 003e (probably leftover from a bad edit)"
            $hasIssue = $true
        }

        # Check 7: ?003c
        if ($line -match '\?003c') {
            $fileIssues += "  L$lineNum : stray ?003c (HTML entity leaked into PHP)"
            $hasIssue = $true
        }

        # Check 8: ?003e
        if ($line -match '\?003e') {
            $fileIssues += "  L$lineNum : stray ?003e (HTML entity leaked into PHP)"
            $hasIssue = $true
        }

        # Check 9: Short tags (exclude php, xml, =)
        if ($line -match '<\?[^p\s=]' -and $line -notmatch '<\?xml') {
            $fileIssues += "  L$lineNum : short PHP tag (use <?php)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 10: ; followed by ? and non-whitespace non-> (broken close)
        if ($line -match ';\?\S') {
            $fileIssues += "  L$lineNum : possibly broken PHP close ';'?  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 11: colon syntax close tag missing > (e.g. ": ?" instead of ": ?>")
        # Matches patterns like "if (...) : ?" or "endif; : ?" where ?> is malformed
        # Exclude URL query strings like "mailto:?subject=" by requiring the colon to be preceded by control structure keywords
        if ($line -match '(endif|endforeach|endfor|endwhile|else|)\s*;\s*:\s*\?\s*[^>\s]') {
            $fileIssues += "  L$lineNum : bad alt-syntax close (missing > after ?)  ->  $($line.Trim())"
            $hasIssue = $true
        }
        # Also check for "if (...) : ?" pattern (colon after parenthesis, then bad close)
        if ($line -match '\)\s*:\s*\?\s*[^>\s]' -and $line -notmatch 'mailto:|https?://|href=') {
            $fileIssues += "  L$lineNum : bad alt-syntax close (missing > after ?)  ->  $($line.Trim())"
            $hasIssue = $true
        }

        # Check 12: endforeach/endif/endfor/endwhile/else with : but missing space or malformed
        if ($line -match '(endforeach|endif|endfor|endwhile|else)\s*;\s*:\s*\?') {
            $fileIssues += "  L$lineNum : malformed alt-syntax close  ->  $($line.Trim())"
            $hasIssue = $true
        }

        if ($hasIssue) {
            $issueCount++
        }
    }

    if ($fileIssues.Count -gt 0) {
        $relPath = $file.FullName.Substring($ProjectDir.Length + 1)
        Write-Host ""
        Write-Host "[ISSUE] $relPath" -ForegroundColor Red
        foreach ($issue in $fileIssues) {
            Write-Host $issue -ForegroundColor Yellow
        }
        $fileIssuesList += $relPath
    }
}

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ("  Files scanned : {0}" -f $fileCount)
Write-Host ("  Lines scanned : {0}" -f $totalLines)
if ($issueCount -gt 0) {
    Write-Host ("  Issues found  : {0}  ({1} files)" -f $issueCount, $fileIssuesList.Count) -ForegroundColor Red
    Write-Host ""
    Write-Host "  Please fix the issues above BEFORE packaging the theme." -ForegroundColor Red
    Write-Host "=================================================" -ForegroundColor Red
    exit 1
} else {
    Write-Host ("  Issues found  : 0") -ForegroundColor Green
    Write-Host ""
    Write-Host "  All PHP files look clean. Safe to package the theme." -ForegroundColor Green
    Write-Host "=================================================" -ForegroundColor Green
    exit 0
}
