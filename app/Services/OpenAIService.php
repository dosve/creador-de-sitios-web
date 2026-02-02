<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Generar contenido HTML de una página basado en un prompt
     * 
     * @param string $prompt El prompt del usuario
     * @param array $templateInfo Información de la plantilla y estilos
     * @param string|null $currentContent Contenido HTML actual de la página (para actualizaciones)
     * @param string $scope 'full_page' = toda la página; 'single_container' = solo un contenedor (editar/agregar)
     * @return array|null Array con 'html_content' y 'meta_description' o null si hay error
     */
    public function generatePageContent(string $prompt, array $templateInfo = [], ?string $currentContent = null, string $scope = 'full_page'): ?array
    {
        if (!$this->apiKey) {
            Log::error('OpenAI API key no configurada');
            return null;
        }

        try {
            // Construir el prompt del sistema con información de la plantilla
            $systemPrompt = $this->buildSystemPrompt($templateInfo, $currentContent !== null, $scope);
            
            // Construir el prompt del usuario
            $userPrompt = $this->buildUserPrompt($prompt, $templateInfo, $currentContent, $scope);

            $response = Http::timeout(90)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemPrompt
                        ],
                        [
                            'role' => 'user',
                            'content' => $userPrompt
                        ]
                    ],
                    'temperature' => 0.8, // Más creatividad para diseños más variados
                    'max_tokens' => 6000, // Más tokens para contenido más completo y detallado
                ]);

            if (!$response->successful()) {
                Log::error('Error en respuesta de OpenAI', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                Log::error('OpenAI no devolvió contenido');
                return null;
            }

            // Extraer HTML y meta descripción del contenido
            return $this->parseResponse($content, $scope);

        } catch (\Exception $e) {
            Log::error('Excepción al generar contenido con OpenAI', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Texto que explica cómo se comportan los contenedores (modo distribución, dirección, gap, alineación).
     * Así la IA genera HTML con las clases correctas según el diseño.
     */
    protected function getContainerBehaviorPrompt(): string
    {
        $p = "COMPORTAMIENTO DE CONTENEDORES (obligatorio para que el editor los interprete bien):\n";
        $p .= "- Base: cada contenedor es <div class=\"container-flex ...\" data-gjs-name=\"Contenedor\">. Padding por defecto: p-[10px]. Puedes variar (py-16, p-6, etc.).\n";
        $p .= "- Modo distribución: (1) FLEX: clase \"flex\" — los hijos se distribuyen en fila o columna. (2) GRID: clase \"grid\" + grid-cols-1 md:grid-cols-2 lg:grid-cols-3 — columnas equitativas.\n";
        $p .= "- Dirección (solo en modo flex): mobile-first. flex-col = hijos apilados en columna (vertical). flex-row = hijos en fila (horizontal). Para que en móvil sea columna y en desktop fila usa: flex flex-col md:flex-row.\n";
        $p .= "- Espacio entre hijos: gap-2 (8px), gap-4 (16px), gap-6 (24px).\n";
        $p .= "- Alineación: justify-start/center/end/between (horizontal), items-start/center/end (vertical). Ej: items-center justify-between.\n";
        $p .= "- Según el diseño: Hero (texto + imagen en fila en desktop) → container-flex flex flex-col md:flex-row gap-4 p-[10px] items-center; Grid de cards → container-flex flex flex-col gap-6 p-[10px] o grid grid-cols-1 md:grid-cols-3 gap-6 p-[10px]; Sección centrada → flex flex-col items-center justify-center gap-4 p-[10px].\n\n";
        return $p;
    }

    /**
     * Construir el prompt del sistema con información de la plantilla
     * @param string $scope 'full_page' o 'single_container'
     */
    protected function buildSystemPrompt(array $templateInfo, bool $isUpdate = false, string $scope = 'full_page'): string
    {
        if ($scope === 'html_code') {
            $prompt = "Eres un experto desarrollador web que genera o mejora código HTML, CSS y JavaScript puro.\n\n";
            $prompt .= "REGLAS:\n";
            $prompt .= "1. Genera SOLO HTML, CSS y JavaScript estándar. NO uses Tailwind, ni clases de frameworks, ni estructura de contenedores del editor.\n";
            $prompt .= "2. ELEMENTOS PERMITIDOS: Usa SOLO <div>, <article>, <header>, <footer>, <nav>, <main>, <aside>, <p>, <h1-h6>, <ul>, <ol>, <li>, <span>, <button>, <a>, <img>, <form>, <input>, <textarea>, etc. NUNCA uses <section> porque ya tiene estilos CSS que pueden generar conflictos.\n";
            $prompt .= "3. ESTILOS DEL CONTENEDOR: NO GENERES estilos de caja (background-color, border, box-shadow, padding, margin) en el elemento contenedor principal. El contenedor debe ser limpio y transparente.\n";
            $prompt .= "4. ESTILOS DEL CONTENIDO INTERNO: El contenido DENTRO sí puede tener fondos, bordes, sombras, padding. Solo el contenedor principal no debe tener estos estilos.\n";
            $prompt .= "5. TODO LO GENERADO DEBE TRAER ESTILOS: siempre incluye css_content con reglas CSS (colores, tipografía, fondos y bordes de elementos internos, etc.) para que el resultado se vea bien. No devuelvas HTML sin estilos.\n";
            $prompt .= "6. DISEÑO RESPONSIVE: NUNCA uses anchos fijos pequeños (como width: 100px). Usa width: 100%, max-width, min-width o porcentajes. Los elementos deben adaptarse al contenedor. Incluye media queries para móviles, tablets y desktop.\n";
            $prompt .= "7. EVITA ANCHOS LIMITADOS: NO uses width: 100px, width: 200px o similares. Usa siempre width: 100%, width: auto, o max-width con valores razonables (80%, 600px como máximo, etc.).\n";
            $prompt .= "8. Responde ÚNICAMENTE con un objeto JSON válido con exactamente estas claves: html_content, css_content, js_content.\n";
            $prompt .= "   - html_content: string con el HTML (puede incluir o no <style> y <script> internos; si prefieres separar, usa las otras claves).\n";
            $prompt .= "   - css_content: string con el CSS (estilos de contenido interno: tipografía, colores, fondos y bordes de elementos internos, pero NO del contenedor principal).\n";
            $prompt .= "   - js_content: string con el JavaScript (opcional; puede estar vacío \"\" si no se requiere).\n";
            $prompt .= "9. No incluyas markdown ni texto fuera del JSON. El primer carácter de tu respuesta debe ser { y el último }.\n";
            return $prompt;
        }

        $isSingleContainer = ($scope === 'single_container');

        if ($isSingleContainer) {
            $prompt = "Eres un experto desarrollador web que genera o actualiza UN CONTENEDOR PRINCIPAL de una página.\n\n";
            $prompt .= "REGLA DE ESTRUCTURA (OBLIGATORIA): En este sistema la estructura NO se hace con div genérico, ni con <section>, ni con <article>. La estructura se hace ÚNICAMENTE con CONTENEDORES (widget Contenedor: div con class container-flex y data-gjs-name=\"Contenedor\"). Cualquier bloque o agrupación es un contenedor.\n\n";
            $prompt .= $this->getContainerBehaviorPrompt();
            $prompt .= "IMPORTANTE - CONTENEDOR PRINCIPAL Y ESTRUCTURA:\n";
            $prompt .= "1. Debes devolver SOLO el HTML de UN contenedor principal (un solo <div> raíz con class container-flex y data-gjs-name=\"Contenedor\").\n";
            $prompt .= "2. DENTRO del contenedor principal PUEDES incluir CONTENEDORES ANIDADOS (mismo formato: container-flex y data-gjs-name=\"Contenedor\") para estructurar el contenido: bloques, filas, columnas, etc. No uses div/section/article para estructurar.\n";
            $prompt .= "3. NO generes varios contenedores al mismo nivel que el principal. NO uses <section>, <article> ni divs genéricos para layout. NO inventes componentes que no estén en el catálogo.\n";
            $prompt .= "4. Dentro de cada contenedor (principal o anidado) usa ÚNICAMENTE los widgets listados en WIDGETS DISPONIBLES.\n";
            $prompt .= "5. El resultado: un único contenedor principal; dentro solo contenedores anidados y/o widgets del catálogo.\n";
            $prompt .= "6. TODO LO GENERADO DEBE TRAER ESTILOS: usa siempre clases de Tailwind para cada elemento (colores, espaciado, tipografía, fondos, bordes, sombras). No dejes bloques sin estilo.\n\n";
        } elseif ($isUpdate) {
            $prompt = "Eres un experto desarrollador web que ACTUALIZA y MEJORA contenido HTML existente de páginas web.\n\n";
            $prompt .= "INSTRUCCIONES IMPORTANTES PARA ACTUALIZACIÓN:\n";
            $prompt .= "1. Recibirás el contenido HTML actual de la página y las instrucciones de actualización\n";
            $prompt .= "2. Debes MANTENER la estructura general y el estilo visual, pero MEJORAR el contenido según las instrucciones\n";
            $prompt .= "3. Puedes agregar nuevos contenedores, mejorar texto existente, actualizar estilos, pero mantén la coherencia\n";
            $prompt .= "4. El resultado debe ser una versión MEJORADA del contenido original, no un reemplazo completo\n";
        } else {
            $prompt = "Eres un experto desarrollador web que genera contenido HTML para un editor donde la estructura se hace SOLO con CONTENEDORES (widget Contenedor), no con div, section ni article.\n\n";
            $prompt .= "REGLA DE ESTRUCTURA (OBLIGATORIA): La estructura NO se hace con div genérico, ni con <section>, ni con <article>. La estructura se hace ÚNICAMENTE con CONTENEDORES (widget Contenedor: div con class container-flex y data-gjs-name=\"Contenedor\"). Cualquier bloque o agrupación es un contenedor.\n\n";
            $prompt .= $this->getContainerBehaviorPrompt();
            $prompt .= "INSTRUCCIONES IMPORTANTES:\n";
        }

        if (!$isSingleContainer) {
            $prompt .= "\n";
            $prompt .= "1. Genera SOLO el contenido HTML del cuerpo de la página (sin <html>, <head>, <body>)\n";
            $prompt .= "2. Usa clases de Tailwind CSS para TODOS los estilos (NO uses estilos inline)\n";
            $prompt .= "3. El HTML debe ser completamente responsivo (sm:, md:, lg:, xl:)\n";
            $prompt .= "4. ESTRUCTURA OBLIGATORIA: NO uses <section>, <article> ni divs para agrupar. Agrupa SOLO en CONTENEDORES (widget Contenedor):\n";
            $prompt .= "   Cada bloque de contenido debe ser un <div class=\"container-flex flex flex-col md:flex-row gap-4 p-[10px] min-h-[200px] rounded-lg\" data-gjs-name=\"Contenedor\"> ... </div>\n";
            $prompt .= "   Usa la dirección y distribución según el diseño (flex-col, md:flex-row, grid, gap-4, items-center, justify-between, etc.). Padding por defecto p-[10px]; puedes variar (py-16, p-6) y añadir fondos (bg-gray-50, bg-gradient-to-r, etc.).\n";
            $prompt .= "5. Genera contenido RICO con:\n";
            $prompt .= "   - Múltiples CONTENEDORES (hero, servicios, características, testimonios, CTA, etc.)\n";
            $prompt .= "   - Dentro de cada contenedor: títulos (heading), texto, botones, imágenes placeholder, iconos\n";
            $prompt .= "   - Diseño moderno: cards, grids, flexbox, espaciado adecuado\n";
            $prompt .= "   - Interactividad visual: hover effects, transiciones\n";
            $prompt .= "   - Tipografía variada: títulos grandes, subtítulos, párrafos\n";
            $prompt .= "   - Botones y CTAs con estilos atractivos\n";
            $prompt .= "6. Cada CONTENEDOR (div con container-flex) debe tener:\n";
            $prompt .= "   - Títulos y subtítulos bien estructurados dentro\n";
            $prompt .= "   - Contenido descriptivo y relevante\n";
            $prompt .= "   - Diseño visual atractivo con colores, sombras y efectos en Tailwind\n";
            $prompt .= "11. Genera AL MENOS 3-5 CONTENEDORES diferentes con contenido completo (cada uno un div container-flex)\n";
            $prompt .= "12. Usa colores, gradientes y efectos visuales para hacer el diseño más atractivo\n";
            $prompt .= "13. TODO LO GENERADO DEBE TRAER ESTILOS: aplica clases Tailwind a todos los elementos (textos, botones, contenedores, imágenes) para que todo el contenido se vea bien; no dejes bloques sin estilo.\n\n";
        } else {
            $prompt .= "1. Usa clases de Tailwind CSS para estilos (NO estilos inline). HTML responsivo.\n";
            $prompt .= "2. Contenedor principal: <div class=\"container-flex flex flex-col md:flex-row gap-4 p-[10px] min-h-[200px] rounded-lg\" data-gjs-name=\"Contenedor\"> ... </div>\n";
            $prompt .= "3. Dentro del principal: contenedores anidados (mismo div container-flex, data-gjs-name=\"Contenedor\") con la dirección y distribución que pida el diseño (flex-col, md:flex-row, grid, gap-*, items-center, justify-between). Dentro de cada contenedor solo widgets del catálogo (títulos, texto, botones, imágenes con URL por defecto, iconos, etc.).\n\n";
        }

        $defaultImage = config('editor-blocks.default_placeholder_image', 'https://placehold.co/800x400?text=Imagen');
        $prompt .= "7. Usa iconos de Heroicons o emojis cuando sea apropiado\n";
        $prompt .= "8. Para TODAS las imágenes usa esta URL por defecto: {$defaultImage} (no inventes otras URLs de placeholder)\n";
        $prompt .= "9. NO incluyas scripts externos ni estilos inline complejos\n";
        $prompt .= "10. El HTML debe ser compatible con el editor: estructura SOLO con contenedores (data-gjs-name=\"Contenedor\"). No div/section/article para estructura.\n";

        // Catálogo de widgets disponibles: la IA solo debe usar estos formatos, no inventar otros
        $blocks = config('editor-blocks.blocks', []);
        if (!empty($blocks)) {
            $prompt .= "WIDGETS DISPONIBLES EN EL EDITOR (usa SOLO estos formatos, NO inventes otros componentes):\n";
            $prompt .= "Para estructurar contenido usa solo el widget Contenedor (container-flex, data-gjs-name=\"Contenedor\"). Dentro de cada contenedor solo elementos de estos widgets:\n";
            foreach ($blocks as $b) {
                $prompt .= "- {$b['id']} ({$b['label']}): {$b['description']}\n";
            }
            $prompt .= "Genera HTML con las clases y estructura que usa el editor para estos widgets (ej: text-component para texto, heading-component para títulos, botones con estilos Tailwind, imágenes con la URL por defecto). No uses componentes que no estén en esta lista.\n\n";
        }

        if (!empty($templateInfo)) {
            $prompt .= "INFORMACIÓN DE LA PLANTILLA:\n";
            
            if (isset($templateInfo['name'])) {
                $prompt .= "- Nombre de la plantilla: {$templateInfo['name']}\n";
            }
            
            if (isset($templateInfo['category'])) {
                $prompt .= "- Categoría: {$templateInfo['category']}\n";
            }
            
            if (isset($templateInfo['customization']['colors'])) {
                $colors = $templateInfo['customization']['colors'];
                $prompt .= "- Colores de la plantilla:\n";
                if (isset($colors['primary'])) {
                    $prompt .= "  * Primario: {$colors['primary']}\n";
                }
                if (isset($colors['secondary'])) {
                    $prompt .= "  * Secundario: {$colors['secondary']}\n";
                }
                if (isset($colors['accent'])) {
                    $prompt .= "  * Acento: {$colors['accent']}\n";
                }
                if (isset($colors['background'])) {
                    $prompt .= "  * Fondo: {$colors['background']}\n";
                }
                if (isset($colors['text'])) {
                    $prompt .= "  * Texto: {$colors['text']}\n";
                }
                $prompt .= "  Usa estos colores en las clases de Tailwind CSS (bg-[color], text-[color], etc.)\n";
            }
            
            if (isset($templateInfo['customization']['fonts'])) {
                $fonts = $templateInfo['customization']['fonts'];
                $prompt .= "- Fuentes: ";
                if (isset($fonts['heading'])) {
                    $prompt .= "Títulos: {$fonts['heading']}, ";
                }
                if (isset($fonts['body'])) {
                    $prompt .= "Cuerpo: {$fonts['body']}";
                }
                $prompt .= "\n";
            }
        }

        if ($isSingleContainer) {
            $prompt .= "\nFORMATO DE RESPUESTA (UN CONTENEDOR PRINCIPAL):\n";
            $prompt .= "Responde SOLO con un objeto JSON válido. El html_content debe ser UN ÚNICO <div> contenedor principal (no varios al mismo nivel). Dentro del principal pueden ir contenedores anidados para estructurar el contenido:\n";
            $prompt .= "{\n";
            $prompt .= "  \"html_content\": \"<div class=\\\"container-flex flex flex-col md:flex-row gap-4 p-[10px] rounded-lg\\\" data-gjs-name=\\\"Contenedor\\\"><div class=\\\"container-flex flex flex-col gap-4 p-[10px]\\\" data-gjs-name=\\\"Contenedor\\\">...bloque 1...</div><div class=\\\"container-flex flex flex-col gap-4 p-[10px]\\\" data-gjs-name=\\\"Contenedor\\\">...bloque 2...</div></div>\",\n";
            $prompt .= "  \"meta_description\": \"Descripción breve del contenedor\"\n";
            $prompt .= "}\n";
            $prompt .= "\nIMPORTANTE: Un solo contenedor raíz. Cada contenedor (principal y anidados) debe incluir las clases de distribución y dirección según el diseño (flex, flex-col, md:flex-row, grid, gap-4, items-center, justify-between, p-[10px], etc.). NO uses <section>, <article> ni div para estructurar.\n";
        } else {
            $prompt .= "\nEJEMPLOS DE CONTENEDORES (cada uno con clases según modo distribución y dirección):\n";
            $prompt .= "- Hero: container-flex flex flex-col md:flex-row gap-4 p-[10px] py-20 items-center justify-between, fondo gradiente, título, subtítulo, CTA, imagen\n";
            $prompt .= "- Servicios (grid): container-flex grid grid-cols-1 md:grid-cols-3 gap-6 p-[10px], cards con iconos, títulos, descripciones, hover\n";
            $prompt .= "- Características: container-flex flex flex-col gap-6 p-[10px] o grid grid-cols-1 md:grid-cols-2, iconos, títulos, descripciones\n";
            $prompt .= "- Testimonios: container-flex flex flex-col md:flex-row gap-6 p-[10px] items-stretch, cards con citas, nombres, fotos\n";
            $prompt .= "- CTA: container-flex flex flex-col items-center justify-center gap-4 p-[10px] py-16, fondo colorido\n";
            $prompt .= "- Contenido: container-flex flex flex-col gap-4 p-[10px], títulos, párrafos, listas\n";
            $prompt .= "- Footer: container-flex flex flex-col md:flex-row gap-6 p-[10px] justify-between, links, contacto\n\n";
            $prompt .= "\nFORMATO DE RESPUESTA:\n";
            $prompt .= "Responde SOLO con un objeto JSON válido:\n";
            $prompt .= "{\n";
            $prompt .= "  \"html_content\": \"<div class=\\\"container-flex flex flex-col md:flex-row gap-4 p-[10px] py-16 rounded-lg\\\" data-gjs-name=\\\"Contenedor\\\">...</div><div class=\\\"container-flex flex flex-col gap-6 p-[10px] ...\\\" data-gjs-name=\\\"Contenedor\\\">...</div>\",\n";
            $prompt .= "  \"meta_description\": \"Descripción breve para SEO\"\n";
            $prompt .= "}\n";
            $prompt .= "\nIMPORTANTE: Estructura SOLO con contenedores (div con container-flex y data-gjs-name=\"Contenedor\"). NO uses <section>, <article> ni divs genéricos para estructura.\n";
        }

        return $prompt;
    }

    /**
     * Construir el prompt del usuario
     * @param string $scope 'full_page' o 'single_container'
     */
    protected function buildUserPrompt(string $userPrompt, array $templateInfo, ?string $currentContent = null, string $scope = 'full_page'): string
    {
        if ($scope === 'html_code') {
            $current = ['html' => '', 'css' => '', 'js' => ''];
            if ($currentContent) {
                $decoded = json_decode($currentContent, true);
                if (is_array($decoded)) {
                    $current = array_merge($current, $decoded);
                }
            }
            $prompt = "Genera o mejora el código según la solicitud del usuario.\n\n";
            if (!empty($current['html']) || !empty($current['css']) || !empty($current['js'])) {
                $prompt .= "CÓDIGO ACTUAL:\n";
                if (!empty($current['html'])) {
                    $prompt .= "HTML:\n```html\n" . substr($current['html'], 0, 4000) . "\n```\n\n";
                }
                if (!empty($current['css'])) {
                    $prompt .= "CSS:\n```css\n" . substr($current['css'], 0, 2000) . "\n```\n\n";
                }
                if (!empty($current['js'])) {
                    $prompt .= "JavaScript:\n```js\n" . substr($current['js'], 0, 2000) . "\n```\n\n";
                }
                $prompt .= "SOLICITUD DEL USUARIO:\n";
            } else {
                $prompt .= "SOLICITUD DEL USUARIO (generar código nuevo):\n";
            }
            $prompt .= $userPrompt . "\n\n";
            $prompt .= "INSTRUCCIONES CRÍTICAS:\n";
            $prompt .= "- NUNCA uses <section> porque ya tiene estilos CSS que pueden conflictuar.\n";
            $prompt .= "- Usa <div> con clases personalizadas, <article>, <header>, <footer>, <main>, etc. en su lugar.\n";
            $prompt .= "- El CONTENEDOR PRINCIPAL (wrapper) NO debe tener estilos de caja (background, border, box-shadow, padding, margin). Debe ser transparente y limpio.\n";
            $prompt .= "- El CONTENIDO DENTRO sí puede tener fondos, bordes, sombras y padding. Solo el contenedor principal debe estar limpio.\n";
            $prompt .= "Responde SOLO con el objeto JSON (html_content, css_content, js_content). Sin explicaciones fuera del JSON.\n";
            return $prompt;
        }

        $isSingleContainer = ($scope === 'single_container');

        if ($isSingleContainer) {
            $prompt = "Genera o actualiza UN CONTENEDOR PRINCIPAL. Dentro puedes usar CONTENEDORES ANIDADOS (mismo div container-flex, data-gjs-name=\"Contenedor\") para estructurar el contenido, y en cada contenedor solo widgets del catálogo (título, texto, botón, imagen, icono, etc.). No inventes otros formatos.\n\n";
            if ($currentContent) {
                $prompt .= "CONTENIDO ACTUAL DEL CONTENEDOR:\n";
                $prompt .= "```html\n";
                $prompt .= substr($currentContent, 0, 6000) . "\n";
                $prompt .= "```\n\n";
                $prompt .= "INSTRUCCIONES:\n";
            } else {
                $prompt .= "INSTRUCCIONES PARA EL NUEVO CONTENEDOR:\n";
            }
            $prompt .= $userPrompt . "\n\n";
            $prompt .= "REQUISITOS: Devuelve UN solo contenedor principal (container-flex, data-gjs-name=\"Contenedor\"). Usa en cada contenedor las clases de modo distribución (flex o grid), dirección (flex-col, md:flex-row), gap (gap-4, gap-6), alineación (items-center, justify-between) y padding (p-[10px] por defecto) según el diseño. Dentro del principal solo contenedores anidados y/o widgets del catálogo. La estructura se hace SOLO con contenedores; no uses div, section ni article para estructurar.\n";
            $prompt .= "Todo lo generado debe traer estilos: aplica clases Tailwind a todos los elementos (text-gray-700, bg-white, p-4, rounded-lg, etc.) para que el contenido se vea bien.\n";
            $defaultImage = config('editor-blocks.default_placeholder_image', 'https://placehold.co/800x400?text=Imagen');
            $prompt .= "Para imágenes usa esta URL: {$defaultImage}\n";
            return $prompt;
        }

        if ($currentContent) {
            $prompt = "ACTUALIZA y MEJORA el siguiente contenido HTML existente según las instrucciones:\n\n";
            $prompt .= "CONTENIDO ACTUAL DE LA PÁGINA:\n";
            $prompt .= "```html\n";
            $prompt .= substr($currentContent, 0, 8000) . "\n"; // Limitar a 8000 caracteres para no exceder tokens
            $prompt .= "```\n\n";
            $prompt .= "INSTRUCCIONES DE ACTUALIZACIÓN:\n";
            $prompt .= $userPrompt . "\n\n";
            $prompt .= "IMPORTANTE:\n";
            $prompt .= "- Mantén la estructura general y el estilo visual del contenido actual\n";
            $prompt .= "- Aplica las mejoras solicitadas manteniendo la coherencia\n";
            $prompt .= "- Si se pide agregar contenedores, intégralos de forma natural (div con container-flex, data-gjs-name=\"Contenedor\")\n";
            $prompt .= "- Mejora el texto, estilos y estructura según las instrucciones\n";
            $prompt .= "- El resultado debe ser una versión MEJORADA, no un reemplazo completo\n\n";
        } else {
            $prompt = "Genera contenido HTML COMPLETO usando CONTENEDORES (div con class container-flex y data-gjs-name=\"Contenedor\"). NO usa <section>.\n\n";
            $prompt .= $userPrompt . "\n\n";
        }
        
        if (!$currentContent) {
            $prompt .= "REQUISITOS OBLIGATORIOS:\n";
            $prompt .= "1. Genera MÚLTIPLES CONTENEDORES (mínimo 3-5), cada uno con clases según el diseño: container-flex + flex o grid + dirección (flex-col, md:flex-row) + gap-4 o gap-6 + p-[10px] (o py-16, etc.) + rounded-lg + data-gjs-name=\"Contenedor\". Ejemplo: <div class=\"container-flex flex flex-col md:flex-row gap-4 p-[10px] min-h-[200px] rounded-lg\" data-gjs-name=\"Contenedor\">...</div>\n";
        } else {
            $prompt .= "REQUISITOS PARA LA ACTUALIZACIÓN:\n";
            $prompt .= "1. Mantén o convierte la estructura a contenedores (widget Contenedor: container-flex, data-gjs-name=\"Contenedor\") y mejóralos según las instrucciones. No uses section/article/div para estructura.\n";
        }
        $prompt .= "2. Cada contenedor debe tener:\n";
        $prompt .= "   - Diseño visual atractivo con colores, gradientes o fondos\n";
        $prompt .= "   - Espaciado generoso (py-16 o py-20)\n";
        $prompt .= "   - Títulos y subtítulos bien jerarquizados\n";
        $prompt .= "   - Contenido descriptivo y relevante\n";
        $prompt .= "   - Elementos visuales (iconos, imágenes placeholder, efectos)\n";
        $prompt .= "3. Usa elementos modernos:\n";
        $prompt .= "   - Cards con sombras y efectos hover\n";
        $prompt .= "   - Grids responsivos (grid-cols-1 md:grid-cols-2 lg:grid-cols-3)\n";
        $prompt .= "   - Gradientes de fondo cuando sea apropiado\n";
        $prompt .= "   - Botones con estilos atractivos y efectos hover\n";
        $prompt .= "   - Iconos o emojis relevantes\n";
        $prompt .= "4. Estructura: SOLO con CONTENEDORES (widget Contenedor: container-flex, data-gjs-name=\"Contenedor\"). NO uses <section>, <article> ni div para estructurar. Responsive con Tailwind, max-width y centrado, tipografía variada.\n";
        
        if (!empty($templateInfo['customization']['colors'])) {
            $prompt .= "5. Usa los colores de la plantilla proporcionados en las clases de Tailwind\n";
        }
        
        $defaultImage = config('editor-blocks.default_placeholder_image', 'https://placehold.co/800x400?text=Imagen');
        $prompt .= "6. El contenido debe ser COMPLETO y LISTO para usar, no placeholders vacíos\n";
        $prompt .= "7. Incluye texto real y descriptivo, no solo estructura\n";
        $prompt .= "8. Para imágenes usa siempre esta URL por defecto: {$defaultImage}\n";
        $prompt .= "9. Haz el diseño MODERNO, PROFESIONAL y VISUALMENTE IMPACTANTE\n";

        return $prompt;
    }

    /**
     * Convierte <section> en contenedores (div con clase del widget Contenedor)
     * para que el HTML generado sea compatible con el editor.
     */
    protected function ensureContainersNotSections(string $html): string
    {
        $containerClasses = 'container-flex flex flex-col md:flex-row gap-4 p-[10px] min-h-[200px] rounded-lg';
        // Reemplazar <section ...> por <div class="..." data-gjs-name="Contenedor" ...>
        $html = preg_replace_callback(
            '/<section(\s[^>]*)?>/i',
            function ($m) use ($containerClasses) {
                $attrs = $m[1] ?? '';
                // Preservar clases existentes (class="...") y añadir las del contenedor
                if (preg_match('/class=["\']([^"\']*)["\']/i', $attrs, $classMatch)) {
                    $existing = trim($classMatch[1]);
                    $attrs = preg_replace('/class=["\'][^"\']*["\']/i', '', $attrs);
                    $attrs = trim($attrs);
                    $class = $containerClasses . ' ' . $existing;
                } else {
                    $class = $containerClasses;
                }
                return '<div class="' . $class . '" data-gjs-name="Contenedor"' . ($attrs ? ' ' . $attrs : '') . '>';
            },
            $html
        );
        $html = preg_replace('/<\/section>/i', '</div>', $html);
        return $html;
    }

    /**
     * Parsear la respuesta de OpenAI para extraer HTML y meta descripción
     * @param string $scope 'full_page' o 'single_container' — si single_container, devuelve solo el primer contenedor
     */
    protected function parseResponse(string $content, string $scope = 'full_page'): array
    {
        // scope html_code: respuesta es JSON con html_content, css_content, js_content
        if ($scope === 'html_code') {
            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');
            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
                $parsed = json_decode($jsonContent, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($parsed['html_content'])) {
                    return [
                        'html_content' => $parsed['html_content'] ?? '',
                        'css_content' => $parsed['css_content'] ?? '',
                        'js_content' => $parsed['js_content'] ?? '',
                        'meta_description' => 'Código generado con IA'
                    ];
                }
            }
            return [
                'html_content' => $content,
                'css_content' => '',
                'js_content' => '',
                'meta_description' => 'Código generado con IA'
            ];
        }

        // Intentar parsear como JSON primero
        $jsonStart = strpos($content, '{');
        $jsonEnd = strrpos($content, '}');
        
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
            $parsed = json_decode($jsonContent, true);
            
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['html_content'])) {
                $htmlContent = $this->ensureContainersNotSections($parsed['html_content']);
                if ($scope === 'single_container') {
                    $htmlContent = $this->extractFirstContainerOnly($htmlContent);
                }
                return [
                    'html_content' => $htmlContent,
                    'meta_description' => $parsed['meta_description'] ?? ($scope === 'single_container' ? 'Contenedor generado con IA' : 'Página generada con IA')
                ];
            }
        }

        // Si no es JSON válido, intentar extraer HTML directamente
        // Buscar contenido entre etiquetas HTML
        if (preg_match('/<section[^>]*>.*?<\/section>/is', $content, $matches)) {
            $html = $this->ensureContainersNotSections($matches[0]);
        } elseif (preg_match('/<div[^>]*>.*?<\/div>/is', $content, $matches)) {
            $html = $matches[0];
        } else {
            // Si no hay HTML claro, envolver el contenido
            $html = '<div class="container-flex flex flex-col gap-4 p-[10px] py-16 rounded-lg bg-white" data-gjs-name="Contenedor"><div class="container mx-auto px-4">' .
                    nl2br(htmlspecialchars($content)) .
                    '</div></div>';
        }
        if ($scope === 'single_container') {
            $html = $this->extractFirstContainerOnly($html);
        }

        // Extraer meta descripción si está presente
        $metaDescription = $scope === 'single_container' ? 'Contenedor generado con IA' : 'Página generada con IA';
        if (preg_match('/meta_description["\']?\s*:\s*["\']([^"\']+)["\']/i', $content, $metaMatches)) {
            $metaDescription = $metaMatches[1];
        } elseif (preg_match('/descripción[:\s]+([^\n]+)/i', $content, $metaMatches)) {
            $metaDescription = trim($metaMatches[1]);
        }

        return [
            'html_content' => $html,
            'meta_description' => $metaDescription
        ];
    }

    /**
     * Si la IA devolvió varios contenedores, quedarse solo con el primero (para scope single_container).
     */
    protected function extractFirstContainerOnly(string $html): string
    {
        if (!preg_match('/<div\s[^>]*class=["\'][^"\']*container-flex[^"\']*["\'][^>]*>/i', $html, $m)) {
            return $html;
        }
        $start = strpos($html, $m[0]);
        $pos = $start + strlen($m[0]);
        $depth = 1;
        $len = strlen($html);
        while ($pos < $len && $depth > 0) {
            $nextOpen = strpos($html, '<div', $pos);
            $nextClose = strpos($html, '</div>', $pos);
            if ($nextOpen === false) {
                $nextOpen = $len;
            }
            if ($nextClose === false) {
                break;
            }
            if ($nextClose < $nextOpen) {
                $depth--;
                $pos = $nextClose + 6; // strlen('</div>')
                if ($depth === 0) {
                    return substr($html, $start, $pos - $start);
                }
            } else {
                $depth++;
                $pos = $nextOpen + 4; // strlen('<div')
            }
        }
        return $html;
    }

    /**
     * Planificar estructura de página con IA usando el catálogo de componentes/widgets.
     * Devuelve contenedores sugeridos (widget Contenedor) y un prompt refinado para la generación.
     *
     * @param string $userIdea Idea o descripción inicial del usuario
     * @return array|null ['containers' => [...], 'refined_prompt' => string] o null
     */
    public function planPageStructure(string $userIdea): ?array
    {
        if (!$this->apiKey) {
            Log::error('OpenAI API key no configurada');
            return null;
        }

        $blocks = config('editor-blocks.blocks', []);
        $categories = config('editor-blocks.categories', []);

        $catalogText = "CATÁLOGO DE WIDGETS DISPONIBLES (usa solo estos id en suggested_components):\n";
        foreach ($blocks as $b) {
            $catalogText .= "- id: {$b['id']}, label: {$b['label']}, categoría: {$b['category']}, descripción: {$b['description']}\n";
        }
        $catalogText .= "\nIMPORTANTE: El widget 'simple-container' (Contenedor) agrupa otros widgets. La página se estructura por CONTENEDORES, no por secciones genéricas.\n";
        $catalogText .= "\nCATEGORÍAS: " . implode(' | ', array_map(fn ($cat, $desc) => "$cat: $desc", array_keys($categories), $categories));

        $defaultImage = config('editor-blocks.default_placeholder_image', 'https://placehold.co/800x400?text=Imagen');

        $systemPrompt = "Eres un planificador de páginas web. La página se estructura leyendo del SISTEMA de CONTENEDORES: cada contenedor tiene WIDGETS dentro, y cada widget tiene su INFORMACIÓN (textos, contenido). Para imágenes se usará una por defecto.\n\n";
        $systemPrompt .= "Responde ÚNICAMENTE con un objeto JSON válido con esta estructura:\n";
        $systemPrompt .= "{\n";
        $systemPrompt .= "  \"containers\": [\n";
        $systemPrompt .= "    { \"title\": \"Nombre del contenedor\", \"description\": \"Qué contendrá y estilo\", \"suggested_components\": [\"heading\", \"text\", ...], \"widgets\": [ { \"id\": \"heading\", \"content\": \"Texto del título\" }, { \"id\": \"text\", \"content\": \"Texto o descripción\" }, { \"id\": \"image\", \"content\": \"usar imagen por defecto\" } ] },\n";
        $systemPrompt .= "    ...\n";
        $systemPrompt .= "  ],\n";
        $systemPrompt .= "  \"refined_prompt\": \"Texto detallado para generar el HTML: para cada CONTENEDOR lista los widgets (por id) y su información/contenido. Indica que para imágenes se use la URL por defecto. Máximo 2-3 párrafos.\"\n";
        $systemPrompt .= "}\n\n";
        $systemPrompt .= "Reglas:\n";
        $systemPrompt .= "1. suggested_components: solo 'id' del catálogo. widgets: array de { id, content } con la información que llevará cada widget (texto del título, párrafo, botón, etc.). Para widget 'image' pon content: \"usar imagen por defecto\".\n";
        $systemPrompt .= "2. Entre 3 y 6 contenedores. Nombres claros (Hero, Servicios, Testimonios, Contacto, etc.).\n";
        $systemPrompt .= "3. refined_prompt debe describir cada contenedor con sus widgets y su información, y decir que las imágenes usen URL por defecto.\n";
        $systemPrompt .= "4. Imagen por defecto del sistema: {$defaultImage}\n\n";
        $systemPrompt .= $catalogText;

        $userPrompt = "Idea del usuario para la página:\n\n" . $userIdea . "\n\nDevuelve el JSON del plan (containers + refined_prompt).";

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.5,
                    'max_tokens' => 1500,
                ]);

            if (!$response->successful()) {
                Log::error('Error en planificación con OpenAI', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;
            if (!$content) {
                return null;
            }

            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');
            if ($jsonStart === false || $jsonEnd === false) {
                return null;
            }
            $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
            $parsed = json_decode($jsonContent, true);
            // Aceptar "containers" o "sections" por compatibilidad
            $containers = $parsed['containers'] ?? $parsed['sections'] ?? null;
            if (json_last_error() !== JSON_ERROR_NONE || empty($containers) || empty($parsed['refined_prompt'])) {
                return null;
            }

            return [
                'containers' => $containers,
                'refined_prompt' => $parsed['refined_prompt'],
            ];
        } catch (\Exception $e) {
            Log::error('Excepción en planPageStructure', ['error' => $e->getMessage()]);
            return null;
        }
    }
}

