<?php

$pdo = new PDO('mysql:host=mysql;port=3306;dbname=bagisto', 'sail', 'password');

// Türkçe locale'ı ekle
$stmt = $pdo->prepare("INSERT INTO locales (code, name, direction, logo_path, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
$stmt->execute(['tr', 'Turkish', 'ltr', null]);

echo "Türkçe locale eklendi!\n";

// Kontrol et
$stmt = $pdo->prepare('SELECT code, name, direction FROM locales');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Güncel Locale'lar:\n";
foreach($result as $row) {
    echo $row['code'] . ' - ' . $row['name'] . ' - ' . $row['direction'] . "\n";
}
