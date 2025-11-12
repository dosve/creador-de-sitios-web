<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TemplateCssService;

class GenerateTemplateCss extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'templates:generate-css 
                            {template? : Slug de la plantilla específica (opcional)}
                            {--all : Generar CSS para todas las plantillas}
                            {--force : Forzar la regeneración de archivos existentes}';

    /**
     * The console command description.
     */
    protected $description = 'Genera archivos CSS específicos para las plantillas';

    protected $templateCssService;

    public function __construct(TemplateCssService $templateCssService)
    {
        parent::__construct();
        $this->templateCssService = $templateCssService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $template = $this->argument('template');
        $all = $this->option('all');
        $force = $this->option('force');

        if ($template) {
            $this->generateTemplateCss($template, $force);
        } elseif ($all) {
            $this->generateAllTemplatesCss($force);
        } else {
            $this->error('Debes especificar una plantilla o usar --all');
            return 1;
        }

        return 0;
    }

    /**
     * Genera CSS para una plantilla específica
     */
    protected function generateTemplateCss(string $templateSlug, bool $force = false)
    {
        if (!$force && $this->templateCssService->hasTemplateCss($templateSlug)) {
            if (!$this->confirm("El archivo CSS para '{$templateSlug}' ya existe. ¿Deseas sobrescribirlo?")) {
                $this->info("Operación cancelada.");
                return;
            }
        }

        $cssContent = $this->getTemplateCssContent($templateSlug);
        
        if ($this->templateCssService->createTemplateCss($templateSlug, $cssContent)) {
            $this->info("✅ CSS generado exitosamente para: {$templateSlug}");
        } else {
            $this->error("❌ Error al generar CSS para: {$templateSlug}");
        }
    }

    /**
     * Genera CSS para todas las plantillas
     */
    protected function generateAllTemplatesCss(bool $force = false)
    {
        $templates = $this->getAvailableTemplates();
        
        $this->info("Generando CSS para " . count($templates) . " plantillas...");
        
        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        $success = 0;
        $errors = 0;

        foreach ($templates as $template) {
            if (!$force && $this->templateCssService->hasTemplateCss($template)) {
                $bar->advance();
                continue;
            }

            $cssContent = $this->getTemplateCssContent($template);
            
            if ($this->templateCssService->createTemplateCss($template, $cssContent)) {
                $success++;
            } else {
                $errors++;
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ CSS generado exitosamente para: {$success} plantillas");
        if ($errors > 0) {
            $this->error("❌ Errores en: {$errors} plantillas");
        }
    }

    /**
     * Obtiene el contenido CSS para una plantilla
     */
    protected function getTemplateCssContent(string $templateSlug): string
    {
        // Aquí puedes definir el contenido CSS específico para cada plantilla
        // Por ahora, devolvemos un CSS básico
        return $this->getBasicTemplateCss($templateSlug);
    }

    /**
     * Genera CSS básico para una plantilla
     */
    protected function getBasicTemplateCss(string $templateSlug): string
    {
        $templateClass = str_replace('-', '_', $templateSlug) . '_template';
        
        return "/* ========================================
   " . strtoupper(str_replace('-', ' ', $templateSlug)) . " - Estilos Específicos
   ======================================== */

/* Variables CSS específicas de la plantilla */
:root {
  --{$templateSlug}-primary: #3b82f6;
  --{$templateSlug}-secondary: #1f2937;
  --{$templateSlug}-accent: #10b981;
  --{$templateSlug}-background: #ffffff;
  --{$templateSlug}-text: #111827;
  --{$templateSlug}-font-heading: 'Inter', sans-serif;
  --{$templateSlug}-font-body: 'Inter', sans-serif;
}

/* Estilos base */
.{$templateClass} {
  font-family: var(--{$templateSlug}-font-body);
  background-color: var(--{$templateSlug}-background);
  color: var(--{$templateSlug}-text);
}

.{$templateClass} h1,
.{$templateClass} h2,
.{$templateClass} h3,
.{$templateClass} h4,
.{$templateClass} h5,
.{$templateClass} h6 {
  font-family: var(--{$templateSlug}-font-heading);
  font-weight: 600;
}

/* Header específico */
.{$templateSlug}-header {
  background: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.{$templateSlug}-logo {
  color: var(--{$templateSlug}-primary);
  font-family: var(--{$templateSlug}-font-heading);
  font-weight: 700;
}

/* Botones específicos */
.{$templateSlug}-btn-primary {
  background-color: var(--{$templateSlug}-primary);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
  cursor: pointer;
}

.{$templateSlug}-btn-primary:hover {
  background-color: var(--{$templateSlug}-secondary);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Cards */
.{$templateSlug}-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.{$templateSlug}-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Footer específico */
.{$templateSlug}-footer {
  background: var(--{$templateSlug}-secondary);
  color: white;
}

.{$templateSlug}-footer a {
  color: #d1d5db;
  transition: color 0.2s ease;
}

.{$templateSlug}-footer a:hover {
  color: var(--{$templateSlug}-primary);
}

/* Responsive */
@media (max-width: 768px) {
  .{$templateSlug}-card {
    margin-bottom: 1rem;
  }
}

/* Animaciones específicas */
@keyframes {$templateSlug}-fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.{$templateSlug}-animate {
  animation: {$templateSlug}-fadeIn 0.6s ease-out;
}";
    }

    /**
     * Obtiene la lista de plantillas disponibles
     */
    protected function getAvailableTemplates(): array
    {
        $templatesDir = resource_path('views/templates');
        
        if (!is_dir($templatesDir)) {
            return [];
        }

        $directories = array_filter(scandir($templatesDir), function($item) use ($templatesDir) {
            return is_dir($templatesDir . '/' . $item) && !in_array($item, ['.', '..', 'partials']);
        });

        return array_values($directories);
    }
}
