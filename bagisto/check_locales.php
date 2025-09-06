<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = new PDO('mysql:host=mysql;port=3306;dbname=bagisto', 'sail', 'password');
$stmt = $pdo->prepare('SELECT code, name, direction FROM locales');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Mevcut Locale'lar:\n";
foreach($result as $row) {
    echo $row['code'] . ' - ' . $row['name'] . ' - ' . $row['direction'] . "\n";
}
