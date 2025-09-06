# Manuel dosya sync scripti
# Kullanim: .\sync.ps1 "dosya/yolu"

param(
    [Parameter(Mandatory=$true)]
    [string]$FilePath,
    [string]$ContainerName = "bagisto-app-1"
)

# Dosya var mi kontrol et
if (-not (Test-Path $FilePath)) {
    Write-Host "Hata: Dosya bulunamadi: $FilePath" -ForegroundColor Red
    exit 1
}

# Container path olustur
$ContainerPath = "/var/www/html/$($FilePath -replace '\\', '/')"

Write-Host "Dosya kopyalaniyor..." -ForegroundColor Yellow
Write-Host "Kaynak: $FilePath" -ForegroundColor Gray
Write-Host "Hedef : $ContainerPath" -ForegroundColor Gray

# Docker cp komutu
docker cp $FilePath "${ContainerName}:${ContainerPath}" 2>$null

if ($LASTEXITCODE -eq 0) {
    Write-Host "Basarili! Dosya container'a kopyalandi." -ForegroundColor Green
} else {
    Write-Host "Hata! Kopyalama basarisiz." -ForegroundColor Red
    exit 1
}
