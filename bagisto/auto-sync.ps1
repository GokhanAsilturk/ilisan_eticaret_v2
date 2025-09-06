# Otomatik file watcher
# Dosya degisikliklerini algilar ve otomatik olarak container'a kopyalar

param(
    [string]$ContainerName = "bagisto-app-1",
    [string[]]$WatchPaths = @("packages", "resources", "app", "config", "routes", "public")
)

Write-Host "=== OTOMATIK FILE SYNC BASLATILIYOR ===" -ForegroundColor Green
Write-Host "Container: $ContainerName" -ForegroundColor Yellow
Write-Host "Izlenen klasorler: $($WatchPaths -join ', ')" -ForegroundColor Yellow
Write-Host "Durdurmak icin Ctrl+C basin..." -ForegroundColor Cyan
Write-Host ""

$watchers = @()

foreach ($watchPath in $WatchPaths) {
    if (Test-Path $watchPath) {
        Write-Host "Izleniyor: $watchPath" -ForegroundColor Gray

        $watcher = New-Object System.IO.FileSystemWatcher
        $watcher.Path = (Resolve-Path $watchPath).Path
        $watcher.Filter = "*.*"
        $watcher.IncludeSubdirectories = $true

        $action = {
            $path = $Event.SourceEventArgs.FullPath
            $changeType = $Event.SourceEventArgs.ChangeType
            $name = $Event.SourceEventArgs.Name

            # Gecici dosyalari atla
            if ($name -match "\.tmp$|\.cache$|\.log$|~$") {
                return
            }

            $relativePath = $path.Substring((Get-Location).Path.Length + 1)
            $containerPath = "/var/www/html/$($relativePath -replace '\\', '/')"

            if ($changeType -eq "Changed") {
                $timestamp = (Get-Date).ToString('HH:mm:ss')
                Write-Host "[$timestamp] $relativePath" -ForegroundColor Green

                Start-Sleep -Milliseconds 200

                try {
                    docker cp $path "${ContainerName}:${containerPath}" 2>$null
                    if ($LASTEXITCODE -eq 0) {
                        Write-Host "  -> Kopyalandi" -ForegroundColor Green
                    }
                } catch {
                    # Sessiz
                }
            }
        }

        Register-ObjectEvent -InputObject $watcher -EventName "Changed" -Action $action | Out-Null
        $watcher.EnableRaisingEvents = $true
        $watchers += $watcher
    }
}

Write-Host "Hazir! Dosya degisiklikleri bekleniyor..." -ForegroundColor Cyan

try {
    while ($true) {
        Start-Sleep -Seconds 1
    }
} finally {
    foreach ($watcher in $watchers) {
        $watcher.EnableRaisingEvents = $false
        $watcher.Dispose()
    }
    Write-Host "Durduruldu." -ForegroundColor Yellow
}
