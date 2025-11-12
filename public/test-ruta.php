<?php
// Test simple para verificar que PHP funciona y ver el request

echo "<h1>🔍 Test de Ruta</h1>";
echo "<hr>";

echo "<h2>Información del Request:</h2>";
echo "<pre style='background:#f0f0f0; padding:15px; border-radius:5px;'>";
echo "Host: " . ($_SERVER['HTTP_HOST'] ?? 'no disponible') . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'no disponible') . "\n";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'no disponible') . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'no disponible') . "\n";
echo "PHP Version: " . phpversion() . "\n";
echo "</pre>";

echo "<h2>¿Existe index.php?</h2>";
$indexPath = __DIR__ . '/index.php';
echo "<pre style='background:#f0f0f0; padding:15px; border-radius:5px;'>";
echo "Ruta: {$indexPath}\n";
echo "Existe: " . (file_exists($indexPath) ? '✅ SÍ' : '❌ NO') . "\n";
echo "</pre>";

echo "<h2>¿Existe .htaccess?</h2>";
$htaccessPath = __DIR__ . '/.htaccess';
echo "<pre style='background:#f0f0f0; padding:15px; border-radius:5px;'>";
echo "Ruta: {$htaccessPath}\n";
echo "Existe: " . (file_exists($htaccessPath) ? '✅ SÍ' : '❌ NO') . "\n";
if (file_exists($htaccessPath)) {
    echo "\nContenido:\n";
    echo htmlspecialchars(file_get_contents($htaccessPath));
}
echo "</pre>";

echo "<h2>Test de Reescritura:</h2>";
echo "<p>Si puedes ver este archivo, PHP funciona.</p>";
echo "<p><strong>Ahora intenta acceder a:</strong></p>";
echo "<ul>";
echo "<li><a href='/index.php/sobre-nosotros'>/index.php/sobre-nosotros</a> (con index.php explícito)</li>";
echo "<li><a href='/sobre-nosotros'>/sobre-nosotros</a> (con reescritura)</li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='/diagnostico.php'>Ver Diagnóstico Completo</a></p>";
?>

