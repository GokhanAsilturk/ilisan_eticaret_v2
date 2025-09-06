<?php

$pdo = new PDO('mysql:host=mysql;port=3306;dbname=bagisto', 'sail', 'password');

// Türkçe locale'ın ID'sini bul
$stmt = $pdo->prepare('SELECT id FROM locales WHERE code = ?');
$stmt->execute(['tr']);
$trLocale = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Türkçe Locale ID: " . $trLocale['id'] . "\n";

// Channel ayarlarını kontrol et
$stmt = $pdo->prepare('SELECT id, code, name, default_locale_id FROM channels');
$stmt->execute();
$channels = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\nMevcut Channels:\n";
foreach($channels as $channel) {
    echo "ID: " . $channel['id'] . " - Code: " . $channel['code'] . " - Name: " . $channel['name'] . " - Locale ID: " . $channel['default_locale_id'] . "\n";
}

// Default channel'ı Türkçe yap
if ($trLocale && count($channels) > 0) {
    $stmt = $pdo->prepare('UPDATE channels SET default_locale_id = ? WHERE id = ?');
    $stmt->execute([$trLocale['id'], $channels[0]['id']]);
    echo "\nDefault channel Türkçe yapıldı!\n";
}
