<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'prueba')->first();

if ($page) {
    echo "=== DIAGNOSTIC REPORT ===\n\n";
    
    // Check alignment classes in current HTML
    preg_match_all('/(items-[a-z-]+|justify-[a-z-]+)/', $page->html_content, $alignMatches);
    $alignClasses = array_count_values($alignMatches[1]);
    
    echo "✓ Alignment classes found:\n";
    foreach ($alignClasses as $class => $count) {
        echo "  - $class: $count occurrences\n";
    }
    
    if (empty($alignClasses)) {
        echo "  ⚠️ NO alignment classes found!\n";
    }
    
    // Check direction classes
    preg_match_all('/(flex-(row|col)(-reverse)?|md:flex-(row|col)|lg:flex-(row|col))/', $page->html_content, $dirMatches);
    $dirClasses = array_count_values($dirMatches[0]);
    
    echo "\n✓ Direction classes found:\n";
    foreach ($dirClasses as $class => $count) {
        echo "  - $class: $count occurrences\n";
    }
    
    // Check malformed classes
    preg_match_all('/(p--[a-z0-9px-]+|min-h--[a-z0-9px-]+|gap-[0-9]+|items-|justify-)/', $page->html_content, $malMatches);
    $sample = array_slice(array_unique($malMatches[0]), 0, 20);
    
    echo "\n📊 Sample classes (first 20):\n";
    foreach ($sample as $class) {
        echo "  - $class\n";
    }
    
    // Check for gjs-selected or other dev classes
    $hasGjsClass = strpos($page->html_content, 'gjs-selected') !== false;
    echo "\n⚠️  Has gjs-selected class: " . ($hasGjsClass ? 'YES (development artifact!)' : 'NO (good)') . "\n";
    
    // Show container count
    $containerCount = substr_count($page->html_content, 'container-flex');
    echo "\n📦 Total containers: $containerCount\n";
    
    // Show first container to see class structure
    if (preg_match('/<div[^>]*class="([^"]*container-flex[^"]*)"/i', $page->html_content, $m)) {
        echo "\n🔍 First container classes:\n";
        echo "  $m[1]\n";
    }
    
} else {
    echo "Page 'prueba' not found\n";
}
?>
