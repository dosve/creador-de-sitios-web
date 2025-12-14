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
     * @return array|null Array con 'html_content' y 'meta_description' o null si hay error
     */
    public function generatePageContent(string $prompt, array $templateInfo = [], ?string $currentContent = null): ?array
    {
        if (!$this->apiKey) {
            Log::error('OpenAI API key no configurada');
            return null;
        }

        try {
            // Construir el prompt del sistema con información de la plantilla
            $systemPrompt = $this->buildSystemPrompt($templateInfo, $currentContent !== null);
            
            // Construir el prompt del usuario
            $userPrompt = $this->buildUserPrompt($prompt, $templateInfo, $currentContent);

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
            return $this->parseResponse($content);

        } catch (\Exception $e) {
            Log::error('Excepción al generar contenido con OpenAI', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Construir el prompt del sistema con información de la plantilla
     */
    protected function buildSystemPrompt(array $templateInfo, bool $isUpdate = false): string
    {
        if ($isUpdate) {
            $prompt = "Eres un experto desarrollador web que ACTUALIZA y MEJORA contenido HTML existente de páginas web.\n\n";
            $prompt .= "INSTRUCCIONES IMPORTANTES PARA ACTUALIZACIÓN:\n";
            $prompt .= "1. Recibirás el contenido HTML actual de la página y las instrucciones de actualización\n";
            $prompt .= "2. Debes MANTENER la estructura general y el estilo visual, pero MEJORAR el contenido según las instrucciones\n";
            $prompt .= "3. Puedes agregar nuevas secciones, mejorar texto existente, actualizar estilos, pero mantén la coherencia\n";
            $prompt .= "4. El resultado debe ser una versión MEJORADA del contenido original, no un reemplazo completo\n";
        } else {
            $prompt = "Eres un experto desarrollador web que genera contenido HTML moderno, completo y visualmente atractivo para páginas web.\n\n";
            $prompt .= "INSTRUCCIONES IMPORTANTES:\n";
        }
        
        $prompt .= "\n";
        $prompt .= "1. Genera SOLO el contenido HTML del cuerpo de la página (sin <html>, <head>, <body>)\n";
        $prompt .= "2. Usa clases de Tailwind CSS para TODOS los estilos (NO uses estilos inline)\n";
        $prompt .= "3. El HTML debe ser completamente responsivo usando las utilidades de Tailwind (sm:, md:, lg:, xl:)\n";
        $prompt .= "4. Incluye MÚLTIPLES secciones bien estructuradas con semántica HTML5\n";
        $prompt .= "5. Usa elementos semánticos: <section>, <article>, <header>, <footer>, <nav>, <main>, <aside>\n";
        $prompt .= "6. Genera contenido RICO con:\n";
        $prompt .= "   - Múltiples secciones (hero, servicios, características, testimonios, CTA, etc.)\n";
        $prompt .= "   - Elementos visuales: iconos, imágenes placeholder, gradientes, sombras\n";
        $prompt .= "   - Diseño moderno: cards, grids, flexbox, espaciado adecuado\n";
        $prompt .= "   - Interactividad visual: hover effects, transiciones\n";
        $prompt .= "   - Tipografía variada: títulos grandes, subtítulos, párrafos\n";
        $prompt .= "   - Botones y CTAs con estilos atractivos\n";
        $prompt .= "   - Espaciado generoso entre secciones (py-16, py-20)\n";
        $prompt .= "7. Cada sección debe tener:\n";
        $prompt .= "   - Contenedor con max-width y padding responsivo\n";
        $prompt .= "   - Títulos y subtítulos bien estructurados\n";
        $prompt .= "   - Contenido descriptivo y relevante\n";
        $prompt .= "   - Diseño visual atractivo con colores, sombras y efectos\n";
        $prompt .= "8. Usa iconos de Heroicons o emojis cuando sea apropiado\n";
        $prompt .= "9. Incluye imágenes placeholder usando placeholder.com o similar\n";
        $prompt .= "10. NO incluyas scripts externos ni estilos inline complejos\n";
        $prompt .= "11. El contenido debe estar listo para insertarse dentro de un layout existente\n";
        $prompt .= "12. Genera AL MENOS 3-5 secciones diferentes con contenido completo\n";
        $prompt .= "13. Usa colores, gradientes y efectos visuales para hacer el diseño más atractivo\n\n";

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

        $prompt .= "\nEJEMPLOS DE ESTRUCTURA RICA:\n";
        $prompt .= "- Sección Hero: fondo con gradiente, título grande, subtítulo, botones CTA, imagen o ilustración\n";
        $prompt .= "- Sección de Servicios: grid de cards con iconos, títulos, descripciones, efectos hover\n";
        $prompt .= "- Sección de Características: lista o grid con iconos, títulos y descripciones\n";
        $prompt .= "- Sección de Testimonios: cards con citas, nombres, fotos placeholder\n";
        $prompt .= "- Sección CTA: llamada a la acción destacada con fondo colorido\n";
        $prompt .= "- Sección de Contenido: texto estructurado con títulos, párrafos, listas\n";
        $prompt .= "- Footer o información adicional: links, información de contacto, etc.\n\n";
        
        $prompt .= "\nFORMATO DE RESPUESTA:\n";
        $prompt .= "Responde SOLO con un objeto JSON válido con esta estructura:\n";
        $prompt .= "{\n";
        $prompt .= "  \"html_content\": \"<section class='py-20 bg-gradient-to-r...'>...</section><section>...</section>\",\n";
        $prompt .= "  \"meta_description\": \"Descripción breve para SEO\"\n";
        $prompt .= "}\n";
        $prompt .= "\nIMPORTANTE: El html_content debe contener MÚLTIPLES secciones completas y bien diseñadas.\n";

        return $prompt;
    }

    /**
     * Construir el prompt del usuario
     */
    protected function buildUserPrompt(string $userPrompt, array $templateInfo, ?string $currentContent = null): string
    {
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
            $prompt .= "- Si se pide agregar secciones, intégralas de forma natural\n";
            $prompt .= "- Mejora el texto, estilos y estructura según las instrucciones\n";
            $prompt .= "- El resultado debe ser una versión MEJORADA, no un reemplazo completo\n\n";
        } else {
            $prompt = "Genera contenido HTML COMPLETO, RICO y VISUALMENTE ATRACTIVO con el siguiente requerimiento:\n\n";
            $prompt .= $userPrompt . "\n\n";
        }
        
        if (!$currentContent) {
            $prompt .= "REQUISITOS OBLIGATORIOS:\n";
            $prompt .= "1. Genera MÚLTIPLES secciones (mínimo 3-5 secciones diferentes)\n";
        } else {
            $prompt .= "REQUISITOS PARA LA ACTUALIZACIÓN:\n";
            $prompt .= "1. Mantén las secciones existentes y mejóralas según las instrucciones\n";
        }
        $prompt .= "2. Cada sección debe tener:\n";
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
        $prompt .= "4. Estructura profesional:\n";
        $prompt .= "   - HTML5 semántico correcto\n";
        $prompt .= "   - Completamente responsive con breakpoints de Tailwind\n";
        $prompt .= "   - Contenedores con max-width y centrado\n";
        $prompt .= "   - Tipografía variada y bien jerarquizada\n";
        
        if (!empty($templateInfo['customization']['colors'])) {
            $prompt .= "5. Usa los colores de la plantilla proporcionados en las clases de Tailwind\n";
        }
        
        $prompt .= "6. El contenido debe ser COMPLETO y LISTO para usar, no placeholders vacíos\n";
        $prompt .= "7. Incluye texto real y descriptivo, no solo estructura\n";
        $prompt .= "8. Haz el diseño MODERNO, PROFESIONAL y VISUALMENTE IMPACTANTE\n";

        return $prompt;
    }

    /**
     * Parsear la respuesta de OpenAI para extraer HTML y meta descripción
     */
    protected function parseResponse(string $content): array
    {
        // Intentar parsear como JSON primero
        $jsonStart = strpos($content, '{');
        $jsonEnd = strrpos($content, '}');
        
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
            $parsed = json_decode($jsonContent, true);
            
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['html_content'])) {
                return [
                    'html_content' => $parsed['html_content'],
                    'meta_description' => $parsed['meta_description'] ?? 'Página generada con IA'
                ];
            }
        }

        // Si no es JSON válido, intentar extraer HTML directamente
        // Buscar contenido entre etiquetas HTML
        if (preg_match('/<section[^>]*>.*?<\/section>/is', $content, $matches)) {
            $html = $matches[0];
        } elseif (preg_match('/<div[^>]*>.*?<\/div>/is', $content, $matches)) {
            $html = $matches[0];
        } else {
            // Si no hay HTML claro, envolver el contenido
            $html = '<section class="py-16 bg-white"><div class="container mx-auto px-4">' . 
                    nl2br(htmlspecialchars($content)) . 
                    '</div></section>';
        }

        // Extraer meta descripción si está presente
        $metaDescription = 'Página generada con IA';
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
}

