<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "🔍 Estructura de la tabla 'order_items'\n";
echo str_repeat("=", 70) . "\n\n";

// Verificar si la tabla existe
if (!Schema::hasTable('order_items')) {
    echo "❌ La tabla 'order_items' NO EXISTE\n";
    exit(1);
}

echo "✅ La tabla 'order_items' existe\n\n";

// Obtener todas las columnas
$columns = Schema::getColumnListing('order_items');

echo "📋 Columnas de la tabla:\n";
echo str_repeat("-", 70) . "\n";

foreach ($columns as $column) {
    echo "   - $column\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Obtener detalles completos de cada columna
echo "📊 Detalles completos de las columnas:\n";
echo str_repeat("-", 70) . "\n\n";

$columnDetails = DB::select("DESCRIBE order_items");

foreach ($columnDetails as $column) {
    echo "Columna: {$column->Field}\n";
    echo "   Tipo: {$column->Type}\n";
    echo "   Nulo: {$column->Null}\n";
    echo "   Clave: {$column->Key}\n";
    echo "   Default: " . ($column->Default ?? 'NULL') . "\n";
    echo "   Extra: {$column->Extra}\n";
    echo "\n";
}

// Verificar específicamente la columna product_image
echo str_repeat("=", 70) . "\n";
if (Schema::hasColumn('order_items', 'product_image')) {
    echo "✅ La columna 'product_image' SÍ EXISTE en local\n";
} else {
    echo "❌ La columna 'product_image' NO EXISTE en local\n";
}
echo str_repeat("=", 70) . "\n";









