# Package Vitrify theme for install on any WordPress (local or temp domain).
# Run from the theme root (vitrify-site). Excludes dev files; includes vendor and built CSS.

$ErrorActionPreference = "Stop"
$themeName = "vitrify"
$outDir = "dist"
$zipName = "${themeName}-theme.zip"

$skipDirs = @("node_modules", ".git", ".github", "dist", "tests")

# Ensure build artifacts exist
if (-not (Test-Path "src\output.css")) {
    Write-Host "Building Tailwind CSS..."
    npm run build
}
if (-not (Test-Path "vendor\autoload.php")) {
    Write-Host "Installing Composer dependencies..."
    composer install --no-dev
}

# Create staging folder
$staging = Join-Path $outDir $themeName
if (Test-Path $staging) { Remove-Item $staging -Recurse -Force }
New-Item -ItemType Directory -Path $staging -Force | Out-Null

Get-ChildItem -Path . -Force | Where-Object {
    $_.Name -notin $skipDirs -and $_.Name -ne "package-theme.ps1" -and $_.Name -notlike "*.zip"
} | ForEach-Object {
    Copy-Item $_.FullName -Destination (Join-Path $staging $_.Name) -Recurse -Force
}

# WordPress requires style.css at theme root - verify it's in the staging folder
$styleInStaging = Join-Path $staging "style.css"
if (-not (Test-Path $styleInStaging)) {
    Write-Error "style.css was not copied to staging. Cannot create valid theme zip."
    exit 1
}

# Zip from *inside* the staging folder so the zip root is the theme files (no extra path).
# WordPress creates a folder from the zip name (vitrify-theme) and expects style.css inside it.
$zipPath = Join-Path (Get-Location).Path (Join-Path $outDir $zipName)
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

Push-Location $staging
try {
    Compress-Archive -Path * -DestinationPath $zipPath -Force
} finally {
    Pop-Location
}
Remove-Item $staging -Recurse -Force

Write-Host "Done: $zipPath"
Write-Host "Upload in WordPress: Appearance -> Themes -> Add New -> Upload."
Write-Host "Theme will appear as 'vitrify-theme' (folder name from zip)."
