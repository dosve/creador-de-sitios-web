<?php
/**
 * Script para Inspeccionar Contenido Guardado de Página
 * 
 * Muestra exactamente qué HTML y CSS se guardó en la base de datos
 * y compara con lo que se renderiza en la página real
 */

require __DIR__ . '/../bootstrap/app.php';

use App\Models\Page;

// Obtener ID de página desde parámetro
$pageId = $_GET['page_id'] ?? 33;
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
    <title>Inspector de Contenido - Página <?php echo $page->id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .comparison-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
        }
        .comparison-item.error {
            border-color: #fca5a5;
            background: #fee2e2;
        }
        .comparison-item.success {
            border-color: #86efac;
            background: #dcfce7;
        }
        code, pre {
            background: #f3f4f6;
            padding: 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            overflow-x: auto;
            max-height: 400px;
            display: block;
            margin: 10px 0;
        }
        .tabs {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            border-bottom: 2px solid #e5e7eb;
        }
        .tabs button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s;
        }
        .tabs button.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .metric {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .metric:last-child {
            border-bottom: none;
        }
        .check {
            color: #22c55e;
            font-weight: bold;
        }
        .cross {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Encabezado -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-3xl font-bold mb-2">🔍 Inspector de Contenido</h1>
            <p class="text-gray-600">Página: <strong><?php echo htmlspecialchars($page->title); ?></strong> (ID: <?php echo $page->id; ?>)</p>
            <p class="text-gray-600">Website: <strong><?php echo htmlspecialchars($page->website->name); ?></strong></p>
            <p class="text-gray-600 mt-2">
                <a href="/eme10/prueba" target="_blank" class="text-blue-600 underline">👁️ Ver página real</a>
            </p>
        </div>

        <!-- Resumen Rápido -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 shadow">
                <div class="text-gray-500 text-sm">HTML Guardado</div>
                <div class="text-2xl font-bold">
                    <?php if (strlen($page->html_content) > 0): ?>
                        <span class="check">✓</span>
                    <?php else: ?>
                        <span class="cross">✗</span>
                    <?php endif; ?>
                </div>
                <div class="text-gray-600 text-xs mt-1">
                    <?php echo number_format(strlen($page->html_content)); ?> caracteres
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow">
                <div class="text-gray-500 text-sm">CSS Guardado</div>
                <div class="text-2xl font-bold">
                    <?php if (strlen($page->css_content) > 0): ?>
                        <span class="check">✓</span>
                    <?php else: ?>
                        <span class="cross">✗</span>
                    <?php endif; ?>
                </div>
                <div class="text-gray-600 text-xs mt-1">
                    <?php echo number_format(strlen($page->css_content)); ?> caracteres
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow">
                <div class="text-gray-500 text-sm">Datos GrapesJS</div>
                <div class="text-2xl font-bold">
                    <?php if (!empty($page->grapesjs_data)): ?>
                        <span class="check">✓</span>
                    <?php else: ?>
                        <span class="cross">✗</span>
                    <?php endif; ?>
                </div>
                <div class="text-gray-600 text-xs mt-1">
                    <?php 
                    if (!empty($page->grapesjs_data)) {
                        $data = is_array($page->grapesjs_data) ? $page->grapesjs_data : json_decode($page->grapesjs_data, true);
                        echo count($data['components'] ?? []) . ' componentes';
                    } else {
                        echo 'Sin datos';
                    }
                    ?>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow">
                <div class="text-gray-500 text-sm">Publicada</div>
                <div class="text-2xl font-bold">
                    <?php if ($page->is_published): ?>
                        <span class="check">✓</span>
                    <?php else: ?>
                        <span class="cross">✗</span>
                    <?php endif; ?>
                </div>
                <div class="text-gray-600 text-xs mt-1">
                    <?php echo $page->is_published ? 'Visible públicamente' : 'Solo propietario'; ?>
                </div>
            </div>
        </div>

        <!-- Tabs para contenido -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="tabs">
                <button class="active" onclick="switchTab('html-content')">
                    <i class="fas fa-code mr-2"></i> HTML
                </button>
                <button onclick="switchTab('css-content')">
                    <i class="fas fa-palette mr-2"></i> CSS
                </button>
                <button onclick="switchTab('grapesjs-data')">
                    <i class="fas fa-database mr-2"></i> GrapesJS
                </button>
                <button onclick="switchTab('metadata')">
                    <i class="fas fa-info-circle mr-2"></i> Metadatos
                </button>
            </div>

            <!-- HTML Content -->
            <div id="html-content" class="tab-content active">
                <h3 class="text-lg font-bold mb-4">📄 Contenido HTML Guardado</h3>
                
                <?php if (strlen($page->html_content) > 0): ?>
                    <div class="comparison-item success">
                        <p class="mb-3"><span class="check">✓</span> HTML presente</p>
                        <p class="text-sm text-gray-600 mb-3">
                            <strong><?php echo number_format(strlen($page->html_content)); ?></strong> caracteres
                        </p>
                        <details>
                            <summary style="cursor: pointer; color: #3b82f6; font-weight: 600;">Ver primeros 2000 caracteres</summary>
                            <pre><?php echo htmlspecialchars(substr($page->html_content, 0, 2000)); ?>
<?php if (strlen($page->html_content) > 2000): ?>
... (truncado, total: <?php echo number_format(strlen($page->html_content)); ?> caracteres)</pre><?php endif; ?>
                        </details>

                        <div class="mt-4 p-4 bg-gray-100 rounded">
                            <strong>Análisis HTML:</strong>
                            <div class="metric">
                                <span>&lt;div&gt; encontrados:</span>
                                <span><?php echo substr_count($page->html_content, '<div'); ?></span>
                            </div>
                            <div class="metric">
                                <span>&lt;section&gt; encontrados:</span>
                                <span><?php echo substr_count($page->html_content, '<section'); ?></span>
                            </div>
                            <div class="metric">
                                <span>&lt;img&gt; encontrados:</span>
                                <span><?php echo substr_count($page->html_content, '<img'); ?></span>
                            </div>
                            <div class="metric">
                                <span>Clases CSS encontradas:</span>
                                <span><?php echo preg_match_all('/class="[^"]*"/', $page->html_content); ?></span>
                            </div>
                            <div class="metric">
                                <span>Estilos inline encontrados:</span>
                                <span><?php echo preg_match_all('/style="[^"]*"/', $page->html_content); ?></span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="comparison-item error">
                        <p><span class="cross">✗</span> <strong>ERROR: HTML está vacío</strong></p>
                        <p class="text-sm mt-2">No hay contenido guardado. Verifica que:</p>
                        <ol class="list-decimal list-inside text-sm mt-2">
                            <li>Hayas editado la página en el editor</li>
                            <li>Hayas presionado el botón "Guardar"</li>
                            <li>El servidor respondió con éxito</li>
                        </ol>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CSS Content -->
            <div id="css-content" class="tab-content">
                <h3 class="text-lg font-bold mb-4">🎨 Contenido CSS Guardado</h3>
                
                <?php if (strlen($page->css_content) > 0): ?>
                    <div class="comparison-item success">
                        <p class="mb-3"><span class="check">✓</span> CSS presente</p>
                        <p class="text-sm text-gray-600 mb-3">
                            <strong><?php echo number_format(strlen($page->css_content)); ?></strong> caracteres
                        </p>
                        <details>
                            <summary style="cursor: pointer; color: #3b82f6; font-weight: 600;">Ver CSS completo</summary>
                            <pre><?php echo htmlspecialchars(substr($page->css_content, 0, 3000)); ?>
<?php if (strlen($page->css_content) > 3000): ?>
... (truncado, total: <?php echo number_format(strlen($page->css_content)); ?> caracteres)</pre><?php endif; ?>
                        </details>

                        <div class="mt-4 p-4 bg-gray-100 rounded">
                            <strong>Análisis CSS:</strong>
                            <div class="metric">
                                <span>Contiene !important:</span>
                                <span><?php echo strpos($page->css_content, '!important') !== false ? '✓ Sí' : '✗ No'; ?></span>
                            </div>
                            <div class="metric">
                                <span>Selectores de clase (.xxx):</span>
                                <span><?php echo preg_match_all('/\.[a-zA-Z0-9\-_]+/', $page->css_content); ?></span>
                            </div>
                            <div class="metric">
                                <span>Selectores de ID (#xxx):</span>
                                <span><?php echo preg_match_all('/#[a-zA-Z0-9\-_]+/', $page->css_content); ?></span>
                            </div>
                            <div class="metric">
                                <span>Media queries:</span>
                                <span><?php echo preg_match_all('/@media/', $page->css_content); ?></span>
                            </div>
                            <div class="metric">
                                <span>Pseudo-clases (:hover, etc):</span>
                                <span><?php echo preg_match_all('/:hover|:active|:focus|:before|:after/', $page->css_content); ?></span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="comparison-item success" style="border-color: #fbbf24; background: #fef3c7;">
                        <p><span class="check">✓</span> <strong>Información: CSS está vacío (normal si usas Tailwind)</strong></p>
                        <p class="text-sm mt-2">Si usas solo clases de Tailwind (como bg-blue-500, flex, etc.), no necesitas CSS personalizado. El CDN de Tailwind lo provee automáticamente.</p>
                        <p class="text-sm mt-2">Si agregaste estilos personalizados y no aparecen aquí, significa que el editor no generó CSS (verifica el panel de estilos en el editor).</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- GrapesJS Data -->
            <div id="grapesjs-data" class="tab-content">
                <h3 class="text-lg font-bold mb-4">⚙️ Datos de GrapesJS</h3>
                
                <?php if (!empty($page->grapesjs_data)): ?>
                    <div class="comparison-item success">
                        <p class="mb-3"><span class="check">✓</span> Datos GrapesJS presentes</p>
                        <?php 
                        $grapesData = is_array($page->grapesjs_data) ? $page->grapesjs_data : json_decode($page->grapesjs_data, true);
                        $componentCount = isset($grapesData['components']) ? count($grapesData['components']) : 0;
                        $styleCount = isset($grapesData['styles']) ? count($grapesData['styles']) : 0;
                        ?>
                        <div class="mt-4 p-4 bg-gray-100 rounded">
                            <div class="metric">
                                <span>Componentes en el editor:</span>
                                <span><?php echo $componentCount; ?></span>
                            </div>
                            <div class="metric">
                                <span>Reglas de estilo:</span>
                                <span><?php echo $styleCount; ?></span>
                            </div>
                        </div>

                        <details class="mt-4">
                            <summary style="cursor: pointer; color: #3b82f6; font-weight: 600;">Ver estructura JSON (primeros 2000 caracteres)</summary>
                            <pre><?php echo htmlspecialchars(json_encode($grapesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), 0, 2000); ?></pre>
                        </details>
                    </div>
                <?php else: ?>
                    <div class="comparison-item success" style="border-color: #fbbf24; background: #fef3c7;">
                        <p><span class="check">✓</span> <strong>Información: Datos GrapesJS vacíos (normal)</strong></p>
                        <p class="text-sm mt-2">La página se guardó en modo "HTML/CSS simple" sin datos de GrapesJS. Esto es normal y no afecta la visualización. Solo importa para reabrir en el editor.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Metadata -->
            <div id="metadata" class="tab-content">
                <h3 class="text-lg font-bold mb-4">📋 Metadatos de la Página</h3>
                
                <div class="space-y-4">
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>ID:</strong> <code><?php echo $page->id; ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Título:</strong> <code><?php echo htmlspecialchars($page->title); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Slug:</strong> <code><?php echo htmlspecialchars($page->slug); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Meta Title:</strong> <code><?php echo htmlspecialchars($page->meta_title ?? '(vacío)'); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Meta Description:</strong> <code><?php echo htmlspecialchars($page->meta_description ?? '(vacío)'); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Meta Keywords:</strong> <code><?php echo htmlspecialchars($page->meta_keywords ?? '(vacío)'); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Es Página de Inicio:</strong> <?php echo $page->is_home ? '<span class="check">✓ Sí</span>' : '<span class="cross">✗ No</span>'; ?>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Publicada:</strong> <?php echo $page->is_published ? '<span class="check">✓ Sí</span>' : '<span class="cross">✗ No</span>'; ?>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Orden:</strong> <code><?php echo $page->sort_order; ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Creada:</strong> <code><?php echo $page->created_at->format('d/m/Y H:i:s'); ?></code>
                        </div>
                    </div>
                    <div class="comparison-item">
                        <div class="metric" style="border: none; padding: 0;">
                            <strong>Actualizada:</strong> <code><?php echo $page->updated_at->format('d/m/Y H:i:s'); ?></code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recomendaciones -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4">💡 Recomendaciones</h3>
            <ul class="space-y-2 text-blue-800">
                <li>✓ Si HTML está vacío → Ve al editor y guarda cambios</li>
                <li>✓ Si CSS está vacío → Está bien si solo usas Tailwind</li>
                <li>✓ Si nada funciona → Verifica que la página esté PUBLICADA (is_published = 1)</li>
                <li>✓ Compara viewport → Editor y página real deben tener mismo ancho</li>
                <li>✓ Limpia caché → Presiona Ctrl+Shift+Del en el navegador</li>
            </ul>
        </div>

        <!-- Acciones -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">⚡ Acciones Rápidas</h3>
            <div class="flex flex-wrap gap-3">
                <a href="/eme10/prueba" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    👁️ Ver página real
                </a>
                <a href="/creator/pages/<?php echo $page->id; ?>/editor" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    ✏️ Editar en editor
                </a>
                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    🔄 Recargar inspector
                </a>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.tabs button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Mostrar el tab seleccionado
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
