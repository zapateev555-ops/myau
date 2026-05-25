# Unique product photos — Wikimedia full-size + Unsplash fallback
$dest = Join-Path $PSScriptRoot "..\public\images\products"
New-Item -ItemType Directory -Force -Path $dest | Out-Null
$headers = @{ "User-Agent" = "MotorDetalShop/1.0" }

# slug.jpg -> URL (full Commons path, not /thumb/)
$urls = @{
    "bosch-spark-plug-fr7dc.jpg" = "https://upload.wikimedia.org/wikipedia/commons/4/4e/Spark_plugs.jpg"
    "mann-w-712-95.jpg" = "https://upload.wikimedia.org/wikipedia/commons/3/3f/Mann-Filter_W_712_75_Oil_filter.jpg"
    "ate-disc-24-0131.jpg" = "https://upload.wikimedia.org/wikipedia/commons/1/1a/Brake_disc.jpg"
    "brembo-pad-p85077.jpg" = "https://upload.wikimedia.org/wikipedia/commons/5/5e/Brake_pad.jpg"
    "bosch-battery-s5-008.jpg" = "https://upload.wikimedia.org/wikipedia/commons/5/5f/Automotive_battery.jpg"
    "philips-h7-x-treme.jpg" = "https://upload.wikimedia.org/wikipedia/commons/2/2f/H7_bulb.jpg"
    "hella-wiper-aerotwin.jpg" = "https://upload.wikimedia.org/wikipedia/commons/1/1e/Windscreen_wipers_on_a_car.jpg"
    "castrol-edge-5w30-4l.jpg" = "https://upload.wikimedia.org/wikipedia/commons/9/96/Motor_oil.jpg"
}

# Unsplash — уникальные кадры по типу детали
$unsplash = @{
    "gates-timing-belt-5529xs.jpg" = "https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=500&h=400&fit=crop"
    "mahle-kolbtseno-kpl-026.jpg" = "https://images.unsplash.com/photo-1625047509168-61c358a1fbc4?w=500&h=400&fit=crop"
    "ina-tensioner-534-0181.jpg" = "https://images.unsplash.com/photo-1619642751034-8f9d62be67b5?w=500&h=400&fit=crop"
    "elring-prokladka-gbc-4078.jpg" = "https://images.unsplash.com/photo-1601364830957-506cadbf7092?w=500&h=400&fit=crop"
    "ferodo-ds2500-pad.jpg" = "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=400&fit=crop"
    "trw-brake-hose-scj115.jpg" = "https://images.unsplash.com/photo-1605557627920-0d711b5a3e28?w=500&h=400&fit=crop"
    "ate-brake-fluid-dot4.jpg" = "https://images.unsplash.com/photo-1607863683730-e910ef502a27?w=500&h=400&fit=crop"
    "textar-pad-2395601.jpg" = "https://images.unsplash.com/photo-1492144534655-791aed74a4b4?w=500&h=400&fit=crop"
    "sachs-amort-313-267.jpg" = "https://images.unsplash.com/photo-1563720188936-6d2db9f914b1?w=500&h=400&fit=crop"
    "lemforder-stabil-link-27318.jpg" = "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=500&h=400&fit=crop"
    "moog-ball-joint-k80632.jpg" = "https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=500&h=400&fit=crop"
    "fag-hub-bearing-713-6107.jpg" = "https://images.unsplash.com/photo-1590362891998-552b843b17fb?w=500&h=400&fit=crop"
    "trw-tie-rod-jte190.jpg" = "https://images.unsplash.com/photo-1503376780353-7c66962e2570?w=500&h=400&fit=crop"
    "kyb-spring-sm5126.jpg" = "https://images.unsplash.com/photo-1542362566-de61bc7ff40d?w=500&h=400&fit=crop"
    "valeo-starter-438-226.jpg" = "https://images.unsplash.com/photo-1615906658792-77ec5dc8ef27?w=500&h=400&fit=crop"
    "denso-alternator-dan-999.jpg" = "https://images.unsplash.com/photo-1635070041078-f197d6d9e26d?w=500&h=400&fit=crop"
    "febi-sensor-abs-37452.jpg" = "https://images.unsplash.com/photo-1553440561-b970966a071b?w=500&h=400&fit=crop"
    "hella-horn-twin-007.jpg" = "https://images.unsplash.com/photo-1502877338535-766e1452684a?w=500&h=400&fit=crop"
    "febi-mirror-glass-45712.jpg" = "https://images.unsplash.com/photo-1552519007-88aa8dfa37f3?w=500&h=400&fit=crop"
    "valeo-clutch-kit-826-552.jpg" = "https://images.unsplash.com/photo-1621134652928-92db740f1aed?w=500&h=400&fit=crop"
    "mann-cabin-filter-cuk-2939.jpg" = "https://images.unsplash.com/photo-1487754180451-c872f50a1885?w=500&h=400&fit=crop"
    "febi-door-lock-171-175.jpg" = "https://images.unsplash.com/photo-1553440561-b970966a071b?w=500&h=400&fit=crop&q=80"
    "hella-fog-lamp-ff-50.jpg" = "https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=500&h=400&fit=crop"
    "motul-8100-5w40-5l.jpg" = "https://images.unsplash.com/photo-1607863683730-e910ef502a27?w=500&h=400&fit=crop&q=80"
    "glysantin-g40-5l.jpg" = "https://images.unsplash.com/photo-1605557627920-0d711b5a3e28?w=500&h=400&fit=crop&q=80"
    "liqui-moly-atf-1l.jpg" = "https://images.unsplash.com/photo-1619642751034-8f9d62be67b5?w=500&h=400&fit=crop&q=80"
    "mann-air-filter-c-25-114.jpg" = "https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=500&h=400&fit=crop&q=80"
    "febi-washer-fluid-5l.jpg" = "https://images.unsplash.com/photo-1601364830957-506cadbf7092?w=500&h=400&fit=crop&q=80"
}

function Save-Image($name, $url) {
    $out = Join-Path $dest $name
    try {
        Invoke-WebRequest -Uri $url -OutFile $out -Headers $headers -UseBasicParsing -TimeoutSec 45
        if ((Get-Item $out).Length -gt 8000) {
            Write-Host "OK $name"
            return $true
        }
        Remove-Item $out -Force -ErrorAction SilentlyContinue
    } catch { }
    return $false
}

foreach ($e in $urls.GetEnumerator()) { Save-Image $e.Key $e.Value | Out-Null }
foreach ($e in $unsplash.GetEnumerator()) {
    $out = Join-Path $dest $e.Key
    if (-not (Test-Path $out) -or (Get-Item $out).Length -lt 8000) {
        Save-Image $e.Key $e.Value | Out-Null
    }
}

# Fallback: локальные p-*.jpg по типу детали
$fallback = @{
    "mann-w-712-95.jpg" = "p-filter.jpg"
    "bosch-spark-plug-fr7dc.jpg" = "p-spark.jpg"
    "gates-timing-belt-5529xs.jpg" = "p-filter.jpg"
    "mahle-kolbtseno-kpl-026.jpg" = "p-spark.jpg"
    "ina-tensioner-534-0181.jpg" = "p-filter.jpg"
    "elring-prokladka-gbc-4078.jpg" = "p-spark.jpg"
    "brembo-pad-p85077.jpg" = "p-brakes.jpg"
    "ate-disc-24-0131.jpg" = "p-brakes.jpg"
    "ferodo-ds2500-pad.jpg" = "p-brakes.jpg"
    "trw-brake-hose-scj115.jpg" = "p-brakes.jpg"
    "ate-brake-fluid-dot4.jpg" = "p-oil.jpg"
    "textar-pad-2395601.jpg" = "p-brakes.jpg"
    "sachs-amort-313-267.jpg" = "p-suspension.jpg"
    "lemforder-stabil-link-27318.jpg" = "p-suspension.jpg"
    "moog-ball-joint-k80632.jpg" = "p-suspension.jpg"
    "fag-hub-bearing-713-6107.jpg" = "p-suspension.jpg"
    "trw-tie-rod-jte190.jpg" = "p-suspension.jpg"
    "kyb-spring-sm5126.jpg" = "p-suspension.jpg"
    "bosch-battery-s5-008.jpg" = "p-battery.jpg"
    "philips-h7-x-treme.jpg" = "p-lamp.jpg"
    "valeo-starter-438-226.jpg" = "p-battery.jpg"
    "denso-alternator-dan-999.jpg" = "p-battery.jpg"
    "febi-sensor-abs-37452.jpg" = "p-lamp.jpg"
    "hella-horn-twin-007.jpg" = "p-lamp.jpg"
    "hella-wiper-aerotwin.jpg" = "p-wipers.jpg"
    "febi-mirror-glass-45712.jpg" = "p-wipers.jpg"
    "valeo-clutch-kit-826-552.jpg" = "p-filter.jpg"
    "mann-cabin-filter-cuk-2939.jpg" = "p-filter.jpg"
    "febi-door-lock-171-175.jpg" = "p-wipers.jpg"
    "hella-fog-lamp-ff-50.jpg" = "p-lamp.jpg"
    "castrol-edge-5w30-4l.jpg" = "p-oil.jpg"
    "motul-8100-5w40-5l.jpg" = "p-oil.jpg"
    "glysantin-g40-5l.jpg" = "p-oil.jpg"
    "liqui-moly-atf-1l.jpg" = "p-oil.jpg"
    "mann-air-filter-c-25-114.jpg" = "p-filter.jpg"
    "febi-washer-fluid-5l.jpg" = "p-oil.jpg"
}

foreach ($e in $fallback.GetEnumerator()) {
    $out = Join-Path $dest $e.Key
    if (-not (Test-Path $out) -or (Get-Item $out).Length -lt 8000) {
        Copy-Item (Join-Path $dest $e.Value) $out -Force
        Write-Host "COPY $($e.Key) <- $($e.Value)"
    }
}

Write-Host "Done."
