<?php
// Script para resetear OPcache y ver estado

echo "<h1>🔄 Reset OPcache</h1>";
echo "<hr>";

// Verificar si OPcache está habilitado
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    
    if ($status !== false) {
        echo "<h2>📊 Estado de OPcache ANTES del reset:</h2>";
        echo "<pre style='background:#fff3cd; padding:15px; border-radius:5px;'>";
        echo "Habilitado: " . ($status['opcache_enabled'] ? '✅ SÍ' : '❌ NO') . "\n";
        echo "Cache Full: " . ($status['cache_full'] ? '⚠️ SÍ' : '✅ NO') . "\n";
        echo "Archivos en caché: " . $status['opcache_statistics']['num_cached_scripts'] . "\n";
        echo "Memoria usada: " . round($status['memory_usage']['used_memory'] / 1024 / 1024, 2) . " MB\n";
        echo "</pre>";
        
        // Resetear OPcache
        if (function_exists('opcache_reset')) {
            $reset = opcache_reset();
            
            echo "<h2>🔄 Resultado del Reset:</h2>";
            if ($reset) {
                echo "<pre style='background:#d4edda; padding:15px; border-radius:5px;'>";
                echo "✅ OPcache reseteado exitosamente\n";
                echo "Los archivos PHP se recargarán desde el disco.";
                echo "</pre>";
            } else {
                echo "<pre style='background:#f8d7da; padding:15px; border-radius:5px;'>";
                echo "❌ No se pudo resetear OPcache\n";
                echo "Puede que necesites permisos de administrador.";
                echo "</pre>";
            }
            
            // Verificar estado después del reset
            $statusAfter = opcache_get_status();
            echo "<h2>📊 Estado de OPcache DESPUÉS del reset:</h2>";
            echo "<pre style='background:#d4edda; padding:15px; border-radius:5px;'>";
            echo "Archivos en caché: " . $statusAfter['opcache_statistics']['num_cached_scripts'] . "\n";
            echo "</pre>";
        } else {
            echo "<pre style='background:#f8d7da; padding:15px; border-radius:5px;'>";
            echo "⚠️ La función opcache_reset() no está disponible.";
            echo "</pre>";
        }
    } else {
        echo "<pre style='background:#e7f3ff; padding:15px; border-radius:5px;'>";
        echo "ℹ️ OPcache está instalado pero no habilitado.";
        echo "</pre>";
    }
} else {
    echo "<pre style='background:#e7f3ff; padding:15px; border-radius:5px;'>";
    echo "ℹ️ OPcache NO está instalado en este servidor.\n";
    echo "Esto significa que los archivos PHP se leen directamente del disco.";
    echo "</pre>";
}

echo "<hr>";
echo "<h2>🎯 Siguiente Paso:</h2>";
echo "<ol>";
echo "<li>OPcache reseteado</li>";
echo "<li>Ahora prueba: <a href='/sobre-nosotros'>/sobre-nosotros</a></li>";
echo "<li>O prueba: <a href='/'>Página de inicio</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='/test-ruta.php'>← Volver a Test de Ruta</a></p>";
?>

