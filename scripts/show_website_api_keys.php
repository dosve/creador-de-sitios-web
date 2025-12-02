<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$websites = App\Models\Website::select('id', 'name', 'slug', 'api_key', 'api_base_url')->get();

foreach ($websites as $website) {
    echo implode("\t", [
        $website->id,
        $website->slug ?? '(sin slug)',
        $website->api_key ?? '(sin api_key)',
        $website->api_base_url ?? '(sin api_base_url)',
    ]) . PHP_EOL;
}

