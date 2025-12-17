<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "🔧 Agregando columna 'product_image' a tabla 'order_items'\n";
echo str_repeat("=", 70) . "\n\n";

if (!Schema::hasTable('order_items')) {
    echo "❌ La tabla 'order_items' no existe\n";
    exit(1);
}

if (Schema::hasColumn('order_items', 'product_image')) {
    echo "✅ La columna 'product_image' YA EXISTE\n";
    echo "   No es necesario hacer nada.\n";
    exit(0);
}

echo "📝 Agregando columna 'product_image'...\n\n";

try {
    Schema::table('order_items', function (Blueprint $table) {
        $table->string('product_image')->nullable()->after('product_sku');
    });
    
    echo "✅ Columna 'product_image' agregada exitosamente\n";
    echo "\n";
    echo "📋 Estructura actualizada:\n";
    
    $columns = Schema::getColumnListing('order_items');
    foreach ($columns as $column) {
        $marker = $column === 'product_image' ? ' ← NUEVA' : '';
        echo "   - $column$marker\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error al agregar la columna: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "✅ Proceso completado. Puedes subir este script al servidor y ejecutarlo.\n";




