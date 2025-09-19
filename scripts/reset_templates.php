<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Script de Reset de Plantillas ===\n\n";

try {
    // 1. Verificar registros actuales
    $currentCount = DB::table('templates')->count();
    echo "Registros actuales en la tabla templates: {$currentCount}\n";
    
    // 2. Vaciar la tabla
    if ($currentCount > 0) {
        echo "Vaciando tabla templates...\n";
        DB::table('templates')->truncate();
        echo "✓ Tabla vaciada exitosamente\n";
    } else {
        echo "✓ La tabla ya está vacía\n";
    }
    
    // 3. Verificar que esté vacía
    $countAfterTruncate = DB::table('templates')->count();
    echo "Registros después de vaciar: {$countAfterTruncate}\n";
    
    // 4. Si está vacía, ejecutar el seeder
    if ($countAfterTruncate === 0) {
        echo "\nEjecutando seeder de plantillas...\n";
        
        // Ejecutar el seeder específico
        Artisan::call('db:seed', [
            '--class' => 'TemplateSeeder'
        ]);
        
        echo "✓ Seeder ejecutado exitosamente\n";
        
        // 5. Verificar el resultado final
        $finalCount = DB::table('templates')->count();
        echo "Registros finales en la tabla templates: {$finalCount}\n";
        
        if ($finalCount > 0) {
            echo "✓ Plantillas cargadas correctamente\n";
        } else {
            echo "⚠ Advertencia: No se cargaron plantillas\n";
        }
        
    } else {
        echo "⚠ Error: La tabla no se vació correctamente\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== Script completado ===\n";
