<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'prueba')->first();

if ($page) {
    preg_match_all('/<div[^>]*container-flex[^>]*>/i', $page->html_content, $matches);
    
    echo "=== TODOS LOS CONTENEDORES ===\n\n";
    
    foreach ($matches[0] as $idx => $div) {
        echo "Container $idx:\n";
        echo $div . "\n\n";
    }
} else {
    echo "Page not found\n";
}
?>
