# İlisan Bagisto Projesi

Bu proje Bagisto e-ticaret platformu ve Docker konfigürasyonunu içerir.

## Proje Yapısı

```
ilisan_bagisto/
├── bagisto/              # Bagisto Laravel e-ticaret platformu
├── docker/               # Docker konfigürasyon dosyaları
└── frontend_roadmap/     # Frontend geliştirme yol haritası
```

## Kurulum

### Docker ile Kurulum

1. Docker klasörüne gidin:
```bash
cd docker
```

2. Docker konteynerlerini başlatın:
```bash
docker-compose up -d
```

### Manuel Kurulum

1. Bagisto klasörüne gidin:
```bash
cd bagisto
```

2. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

3. Ortam değişkenlerini ayarlayın:
```bash
cp .env.example .env
php artisan key:generate
```

4. Veritabanını migre edin:
```bash
php artisan migrate
```

5. Örnek verileri yükleyin (opsiyonel):
```bash
php artisan db:seed
```

## Geliştirme

Frontend geliştirme süreci için `frontend_roadmap` klasöründeki belgelere bakın.

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır.
