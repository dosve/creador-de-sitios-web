<?php
/**
 * Script de Diagnóstico para Diferencias entre Editor y Página Real
 * 
 * Este script compara lo que ve el editor vs lo que se muestra en la página real
 */

// Configurar error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir bootstrap de Laravel
require __DIR__ . '/../bootstrap/app.php';

use App\Models\Page;
use App\Models\Website;

// Obtener ID de página desde parámetro
$pageId = $_GET['page_id'] ?? 33;

// Buscar la página
$page = Page::find($pageId);

if (!$page) {
    die("❌ Página no encontrada con ID: $pageId");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico - Página <?php echo $page->id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        pre {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            border-left: 4px solid #3b82f6;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin: 15px 0 10px 0;
        }
        .info-box {
            background: #ecfdf5;
            border: 1px solid #86efac;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .warning-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error-box {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .success-box {
            background: #dcfce7;
            border: 1px solid #86efac;
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
        }
        code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto p-6">
        <div class="section">
            <div class="title">🔍 Diagnóstico de Página</div>
            
            <div class="subtitle">📌 Información Básica</div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p><strong>ID Página:</strong> <code><?php echo $page->id; ?></code></p>
                    <p><strong>Título:</strong> <?php echo htmlspecialchars($page->title); ?></p>
                    <p><strong>Slug:</strong> <code><?php echo $page->slug; ?></code></p>
                </div>
                <div>
                    <p><strong>Website:</strong> <?php echo htmlspecialchars($page->website->name); ?></p>
                    <p><strong>Publicada:</strong> <?php echo $page->is_published ? '✅ Sí' : '❌ No'; ?></p>
                    <p><strong>Última actualización:</strong> <?php echo $page->updated_at->format('d/m/Y H:i:s'); ?></p>
                </div>
            </div>
        </div>

        <!-- Contenido HTML -->
        <div class="section">
            <div class="subtitle">📄 Contenido HTML</div>
            
            <div class="info-box">
                <strong>✓ Caracteres en HTML:</strong> <?php echo strlen($page->html_content); ?>
            </div>

            <?php if (empty($page->html_content)): ?>
                <div class="error-box">
                    <strong>❌ PROBLEMA:</strong> HTML está vacío. Edita la página en el editor y guarda cambios.
                </div>
            <?php else: ?>
                <div class="success-box">
                    <strong>✓ HTML presente</strong> - <?php echo strlen($page->html_content); ?> caracteres
                </div>
                
                <details>
                    <summary style="cursor: pointer; color: #3b82f6; font-weight: 600; margin: 10px 0;">Ver HTML completo</summary>
                    <pre><?php echo htmlspecialchars(substr($page->html_content, 0, 2000)); ?>
<?php if (strlen($page->html_content) > 2000): ?>
... (truncado, total: <?php echo strlen($page->html_content); ?> caracteres)</pre><?php endif; ?></pre>
                </details>

                <div class="subtitle" style="margin-top: 20px;">🔎 Análisis HTML</div>
                <table class="w-full border-collapse">
                    <tr style="background: #f3f4f6;">
                        <td style="border: 1px solid #e5e7eb; padding: 10px;"><strong>Elemento</strong></td>
                        <td style="border: 1px solid #e5e7eb; padding: 10px;"><strong>Encontrado</strong></td>
                        <td style="border: 1px solid #e5e7eb; padding: 10px;"><strong>Cantidad</strong></td>
                    </tr>
                    <?php
                    $analyses = [
                        ['<div', 'divs'],
                        ['<section', 'sections'],
                        ['<h1', 'h1'],
                        ['<img', 'imágenes'],
                        ['<button', 'botones'],
                        ['<a ', 'enlaces'],
                        ['class=', 'elementos con clases'],
                        ['style=', 'elementos con estilos inline'],
                    ];
                    foreach ($analyses as $search => $name):
                        $count = substr_count($page->html_content, $search);
                        $status = $count > 0 ? '✅' : '⚠️';
                    ?>
                        <tr>
                            <td style="border: 1px solid #e5e7eb; padding: 10px;"><?php echo $name; ?></td>
                            <td style="border: 1px solid #e5e7eb; padding: 10px;"><?php echo $status; ?></td>
                            <td style="border: 1px solid #e5e7eb; padding: 10px;"><?php echo $count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <!-- Contenido CSS -->
        <div class="section">
            <div class="subtitle">🎨 Contenido CSS</div>
            
            <div class="info-box">
                <strong>✓ Caracteres en CSS:</strong> <?php echo strlen($page->css_content); ?>
            </div>

            <?php if (empty($page->css_content)): ?>
                <div class="warning-box">
                    <strong>⚠️ NOTA:</strong> CSS está vacío. Esto es normal si usas solo Tailwind.
                </div>
            <?php else: ?>
                <div class="success-box">
                    <strong>✓ CSS presente</strong> - <?php echo strlen($page->css_content); ?> caracteres
                </div>
                
                <details>
                    <summary style="cursor: pointer; color: #3b82f6; font-weight: 600; margin: 10px 0;">Ver CSS completo</summary>
                    <pre><?php echo htmlspecialchars(substr($page->css_content, 0, 2000)); ?>
<?php if (strlen($page->css_content) > 2000): ?>
... (truncado, total: <?php echo strlen($page->css_content); ?> caracteres)</pre><?php endif; ?></pre>
                </details>

                <div class="subtitle" style="margin-top: 20px;">🔎 Análisis CSS</div>
                <?php
                    $hasImportant = strpos($page->css_content, '!important') !== false;
                    $hasPseudo = preg_match('/:hover|:active|:focus/', $page->css_content);
                    $hasMedia = preg_match('/@media/', $page->css_content);
                    $classCount = preg_match_all('/\.[a-zA-Z0-9\-_]+/', $page->css_content);
                    $idCount = preg_match_all('/#[a-zA-Z0-9\-_]+/', $page->css_content);
                ?>
                <ul>
                    <li>✓ Contiene <code>!important</code>: <?php echo $hasImportant ? '✅ Sí' : '⚠️ No'; ?></li>
                    <li>✓ Contiene pseudo-clases: <?php echo $hasPseudo ? '✅ Sí' : '⚠️ No'; ?></li>
                    <li>✓ Contiene media queries: <?php echo $hasMedia ? '✅ Sí' : '⚠️ No'; ?></li>
                    <li>✓ Número de selectores de clase: <?php echo $classCount; ?></li>
                    <li>✓ Número de selectores de ID: <?php echo $idCount; ?></li>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Datos GrapesJS -->
        <div class="section">
            <div class="subtitle">⚙️ Datos GrapesJS</div>
            
            <?php if (empty($page->grapesjs_data)): ?>
                <div class="warning-box">
                    <strong>⚠️ NOTA:</strong> Datos de GrapesJS vacíos. La página se guardó en modo HTML/CSS simple.
                </div>
            <?php else: ?>
                <div class="success-box">
                    <strong>✓ Datos de GrapesJS presente</strong>
                </div>
                
                <?php
                    $grapesData = is_array($page->grapesjs_data) ? $page->grapesjs_data : json_decode($page->grapesjs_data, true);
                    $componentCount = isset($grapesData['components']) ? count($grapesData['components']) : 0;
                    $cssRulesCount = isset($grapesData['styles']) ? count($grapesData['styles']) : 0;
                ?>
                
                <div class="info-box">
                    <p><strong>Componentes:</strong> <?php echo $componentCount; ?></p>
                    <p><strong>Reglas CSS:</strong> <?php echo $cssRulesCount; ?></p>
                </div>
                
                <details>
                    <summary style="cursor: pointer; color: #3b82f6; font-weight: 600; margin: 10px 0;">Ver estructura GrapesJS</summary>
                    <pre><?php echo htmlspecialchars(substr(json_encode($grapesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), 0, 2000)); ?></pre>
                </details>
            <?php endif; ?>
        </div>

        <!-- Recomendaciones -->
        <div class="section" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
            <div class="subtitle">💡 Recomendaciones</div>
            
            <ol style="list-style-position: inside; line-height: 1.8;">
                <li>
                    <strong>Verifica el ancho de la ventana:</strong> 
                    Asegúrate que el navegador tenga el mismo ancho al ver el editor y la página real.
                </li>
                <li>
                    <strong>Recarga el caché:</strong> 
                    Presiona Ctrl+Shift+Del (o Cmd+Shift+Del en Mac) para limpiar caché y cookies.
                </li>
                <li>
                    <strong>Usa Firefox Developer Edition:</strong> 
                    Tiene mejores herramientas para comparar layouts responsive.
                </li>
                <li>
                    <strong>Revisa la consola del navegador:</strong> 
                    Abre F12 → Pestaña "Consola" para ver si hay errores JavaScript.
                </li>
                <li>
                    <strong>Compara lado a lado:</strong> 
                    Abre editor en una ventana y página real en otra, con el mismo ancho.
                </li>
            </ol>
        </div>

        <!-- Acciones Rápidas -->
        <div class="section" style="background: #f0fdf4; border-left: 4px solid #22c55e;">
            <div class="subtitle">⚡ Acciones Rápidas</div>
            
            <p style="margin: 10px 0;">
                <a href="/eme10/prueba" target="_blank" class="text-blue-600 underline">
                    👁️ Ver página real
                </a>
            </p>
            <p style="margin: 10px 0;">
                <a href="/creator/pages/<?php echo $page->id; ?>/editor" target="_blank" class="text-blue-600 underline">
                    ✏️ Ir al editor
                </a>
            </p>
            <p style="margin: 10px 0;">
                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="text-blue-600 underline">
                    🔄 Recargar diagnóstico
                </a>
            </p>
        </div>
    </div>
</body>
</html>
