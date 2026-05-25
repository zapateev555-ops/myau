# Загрузка реальных фото товаров (izap24, производители)
param(
    [string]$Dest = (Join-Path $PSScriptRoot "..\public\images\products"),
    [string]$MapFile = (Join-Path $PSScriptRoot "product-image-sources.json")
)

$UA = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
$map = Get-Content $MapFile -Raw -Encoding UTF8 | ConvertFrom-Json

function Fetch-Html([string]$Url) {
    return curl.exe -sL -A $UA $Url 2>$null
}

function Get-OgImage([string]$Html) {
    if ($Html -match 'property="og:image"\s+content="([^"]+)"') { return $Matches[1] }
    if ($Html -match "property='og:image'\s+content='([^']+)'") { return $Matches[1] }
    return $null
}

function Find-ProductPage([string]$Url) {
    if ($Url -match '/new/|/tovar/') { return $Url }
    $html = Fetch-Html $Url
    if ($html -match 'href="(https://[^"]*izap24\.ru/new/[^"]+)"') { return $Matches[1] }
    if ($html -match 'href="(/new/[^"]+)"') { return "https://izap24.ru$($Matches[1])" }
    if ($html -match 'href="(https://[^"]*izap24\.ru/tovar/[^"]+)"') { return $Matches[1] }
    if ($html -match 'href="(/tovar/[^"]+)"') { return "https://izap24.ru$($Matches[1])" }
    return $null
}

function Resolve-ImageUrl([string]$Source) {
    if ($Source -match '\.(jpg|jpeg|png|webp)(\?|$)') { return $Source }
    $page = Find-ProductPage $Source
    if (-not $page) { return $null }
    Start-Sleep -Milliseconds 300
    $html = Fetch-Html $page
    return Get-OgImage $html
}

function Save-Image([string]$Slug, [string]$ImageUrl) {
    $out = Join-Path $Dest "$Slug.jpg"
    $tmp = Join-Path $Dest "$Slug.tmp"

    $code = curl.exe -sL -A $UA -o $tmp -w "%{http_code}" $ImageUrl
    if ($code -ne "200" -or -not (Test-Path $tmp) -or (Get-Item $tmp).Length -lt 2500) {
        Remove-Item $tmp -Force -ErrorAction SilentlyContinue
        return $false
    }

    if ($ImageUrl -match '\.webp') {
        $webpOut = Join-Path $Dest "$Slug.webp"
        Copy-Item $tmp $webpOut -Force
        # PHP конвертация
        $php = Join-Path $PSScriptRoot "..\vendor\bin\php.bat"
        if (-not (Test-Path $php)) { $php = "php" }
        $conv = @"
`$s='$($webpOut -replace '\\','\\')';
`$d='$($out -replace '\\','\\')';
if (function_exists('imagecreatefromwebp')) {
  `$i=@imagecreatefromwebp(`$s);
  if (`$i) { imagejpeg(`$i,`$d,88); imagedestroy(`$i); echo 'ok'; }
}
"@
        $r = & $php -r $conv 2>$null
        if ((Test-Path $out) -and (Get-Item $out).Length -gt 2500) {
            Remove-Item $tmp -Force -ErrorAction SilentlyContinue
            return $true
        }
        # Браузеры читают webp — оставляем .webp, модель Product поддерживает
        Rename-Item $tmp $webpOut -Force -ErrorAction SilentlyContinue
        return (Test-Path $webpOut)
    }

    Move-Item $tmp $out -Force
    return (Test-Path $out)
}

New-Item -ItemType Directory -Force -Path $Dest | Out-Null
$ok = 0
$fail = @()

foreach ($prop in $map.PSObject.Properties) {
    $slug = $prop.Name
    $src = $prop.Value
    Write-Host "[$slug]"
    $img = Resolve-ImageUrl $src
    if (-not $img) {
        Write-Warning "  no image"
        $fail += $slug
        continue
    }
    Write-Host "  $img"
    if (Save-Image $slug $img) {
        $f = Get-ChildItem (Join-Path $Dest "$slug.*") -ErrorAction SilentlyContinue | Select-Object -First 1
        Write-Host "  saved $($f.Name) ($($f.Length) bytes)"
        $ok++
    } else {
        Write-Warning "  download failed"
        $fail += $slug
    }
    Start-Sleep -Milliseconds 250
}

Write-Host "`nSaved: $ok / $($map.PSObject.Properties.Count)"
if ($fail.Count) { Write-Host "Failed: $($fail -join ', ')" }
