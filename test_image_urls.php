<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Website;
use App\Services\ExternalApiService;

echo "=== PROBANDO CONSTRUCCIÓN DE URLs DE IMÁGENES ===\n";

$website = Website::find(2); // Sitio EME10

echo "Website: " . $website->name . "\n";
echo "API URL: " . $website->api_base_url . "\n";

try {
    $apiService = new ExternalApiService($website->api_key, $website->api_base_url);
    
    $products = $apiService->getProducts(['paginate' => 3]);
    
    if ($products && isset($products['data']) && count($products['data']) > 0) {
        echo "\n🔍 Productos obtenidos:\n";
        
        foreach ($products['data'] as $index => $product) {
            echo "\n--- Producto " . ($index + 1) . " ---\n";
            echo "Nombre: " . $product['producto'] . "\n";
            echo "Imagen original: " . $product['img'] . "\n";
            
            // Construir URL completa como lo hace el controlador
            if (!empty($product['img'])) {
                $baseImageUrl = rtrim($website->api_base_url, '/api');
                $fullImageUrl = $baseImageUrl . '/storage/productos/' . $product['img'];
                echo "URL completa: " . $fullImageUrl . "\n";
                
                // Probar si la imagen es accesible
                $headers = @get_headers($fullImageUrl);
                if ($headers && strpos($headers[0], '200') !== false) {
                    echo "✅ Imagen accesible\n";
                } else {
                    echo "❌ Imagen no accesible\n";
                }
            } else {
                echo "❌ Sin imagen\n";
            }
        }
    } else {
        echo "❌ No se pudieron obtener productos\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
