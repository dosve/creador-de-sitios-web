<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\Template;

class TestTemplateRender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:template-render';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el renderizado de la plantilla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando renderizado de plantilla...');
        
        $website = Website::first();
        if (!$website) {
            $this->error('No hay sitios web disponibles.');
            return 1;
        }
        
        $this->info("Sitio web: {$website->name}");
        $this->info("Plantilla ID: {$website->template_id}");
        
        if ($website->template_id) {
            $template = $website->template;
            $this->info("Plantilla: {$template->name}");
            
            // Obtener la página de inicio
            $homePage = $website->pages()->where('is_home', true)->first();
            if ($homePage) {
                $this->info("Página de inicio: {$homePage->title}");
            } else {
                $this->warn('No hay página de inicio definida');
            }
            
            // Obtener menús
            $menus = $website->menus()->with(['items' => function($query) {
                $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
            }])->get();
            
            $this->info("Menús encontrados: {$menus->count()}");
            foreach ($menus as $menu) {
                $this->info("- {$menu->name} ({$menu->location}): {$menu->items->count()} items");
            }
            
            // Probar renderizado usando el mismo método que el controlador
            try {
                // Crear una instancia del PreviewController para usar su método
                $previewController = new \App\Http\Controllers\Creator\PreviewController();
                
                // Usar reflexión para acceder al método privado
                $reflection = new \ReflectionClass($previewController);
                $method = $reflection->getMethod('processTemplateBlade');
                $method->setAccessible(true);
                
                $rendered = $method->invoke($previewController, $template->html_content, $website, $homePage, $menus);
                
                $this->info('✅ Vista renderizada correctamente');
                $this->info('Tamaño del contenido: ' . strlen($rendered) . ' caracteres');
                
                // Verificar si hay código Blade sin procesar
                if (strpos($rendered, '{{ $website->name') !== false || strpos($rendered, '@if(') !== false || strpos($rendered, '@foreach(') !== false) {
                    $this->error('❌ Se detectó código Blade sin procesar');
                    
                    // Mostrar las primeras líneas donde se detectó el problema
                    $lines = explode("\n", $rendered);
                    foreach ($lines as $i => $line) {
                        if (strpos($line, '{{ $website->name') !== false || strpos($line, '@if(') !== false || strpos($line, '@foreach(') !== false) {
                            $this->error("Línea " . ($i + 1) . ": " . trim($line));
                            break;
                        }
                    }
                } else {
                    $this->info('✅ No se detectó código Blade sin procesar');
                }
                
            } catch (\Exception $e) {
                $this->error('❌ Error al renderizar: ' . $e->getMessage());
                return 1;
            }
        } else {
            $this->warn('El sitio web no tiene plantilla asignada');
        }
        
        return 0;
    }
}