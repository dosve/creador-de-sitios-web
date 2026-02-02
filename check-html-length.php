<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'prueba')->first();

if ($page) {
    $html = $page->html_content;
    echo "HTML length: " . strlen($html) . " characters\n";
    echo "HTML size: " . round(strlen($html) / 1024, 2) . " KB\n\n";
    
    echo "Last 800 characters:\n";
    echo str_repeat("=", 80) . "\n";
    echo substr($html, -800);
    echo "\n" . str_repeat("=", 80) . "\n\n";
    
    // Check column type in database
    echo "Database column info:\n";
    $schema = \Illuminate\Support\Facades\Schema::getConnection();
    $table = $schema->getDoctrineSchemaManager()->listTableDetails('pages');
    if ($table->hasColumn('html_content')) {
        $col = $table->getColumn('html_content');
        echo "Type: " . $col->getType()->getName() . "\n";
        echo "Length: " . ($col->getLength() ?? 'UNLIMITED') . "\n";
    }
    
} else {
    echo "Page not found\n";
}
?>
