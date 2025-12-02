<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$website = App\Models\Website::first();

if (!$website) {
    echo "No se encontró ningún website.\n";
    exit;
}

$updated = App\Models\Page::where('website_id', $website->id)
    ->where('is_home', true)
    ->update(['enable_store' => true]);

echo "Páginas actualizadas: {$updated}\n";

