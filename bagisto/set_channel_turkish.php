<?php

$pdo = new PDO('mysql:host=mysql;port=3306;dbname=bagisto', 'sail', 'password');

// Türkçe locale'ın ID'sini bul
$stmt = $pdo->prepare('SELECT id FROM locales WHERE code = ?');
$stmt->execute(['tr']);
$trLocale = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Türkçe Locale ID: " . $trLocale['id'] . "\n";

// Channel'ı Türkçe yap (ID 1 default channel)
$stmt = $pdo->prepare('UPDATE channels SET default_locale_id = ? WHERE id = 1');
$stmt->execute([$trLocale['id']]);

echo "Default channel Türkçe yapıldı!\n";

// Kontrol et
$stmt = $pdo->prepare('SELECT id, code, default_locale_id FROM channels WHERE id = 1');
$stmt->execute();
$channel = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Channel ID: " . $channel['id'] . " - Code: " . $channel['code'] . " - Locale ID: " . $channel['default_locale_id'] . "\n";
