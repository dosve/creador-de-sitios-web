<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'prueba')->first();

if ($page) {
    echo "=== CHECKING ALIGNMENT CLASSES IN HTML ===\n\n";
    
    // Extract first 2000 chars to see structure
    echo "First 1500 chars of html_content:\n";
    echo substr($page->html_content, 0, 1500);
    echo "\n\n";
    
    // Find all items-* classes
    preg_match_all('/items-([a-z-]+)/', $page->html_content, $itemsMatches);
    echo "items-* classes found: ";
    print_r(array_count_values($itemsMatches[1]));
    
    // Find all justify-* classes
    preg_match_all('/justify-([a-z-]+)/', $page->html_content, $justifyMatches);
    echo "\njustify-* classes found: ";
    print_r(array_count_values($justifyMatches[1]));
    
    // Count containers
    $containerCount = substr_count($page->html_content, 'container-flex');
    echo "\nTotal containers: $containerCount\n";
    
} else {
    echo "Page 'prueba' not found\n";
}
?>
