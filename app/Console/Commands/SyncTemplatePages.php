<?php

namespace App\Console\Commands;

use App\Models\Website;
use App\Services\TemplatePageService;
use Illuminate\Console\Command;

class SyncTemplatePages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:sync-pages 
                            {website_id? : ID del sitio web (opcional)} 
                            {template? : Slug de la plantilla (opcional)}
                            {--all : Sincronizar todos los sitios con plantillas}
                            {--overwrite : Sobrescribir páginas existentes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar o actualizar páginas prediseñadas de plantillas';

    protected $templatePageService;

    /**
     * Constructor
     */
    public function __construct(TemplatePageService $templatePageService)
    {
        parent::__construct();
        $this->templatePageService = $templatePageService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Sincronizando páginas de plantillas...');
        $this->newLine();

        // Opción 1: Sincronizar todos los sitios con plantillas
        if ($this->option('all')) {
            return $this->syncAllWebsites();
        }

        // Opción 2: Sincronizar un sitio específico
        $websiteId = $this->argument('website_id');
        $templateSlug = $this->argument('template');

        if ($websiteId) {
            return $this->syncSpecificWebsite($websiteId, $templateSlug);
        }

        // Mostrar menú interactivo
        return $this->interactiveMode();
    }

    /**
     * Sincronizar todos los sitios que tienen plantilla aplicada
     */
    protected function syncAllWebsites()
    {
        $websites = Website::whereNotNull('template_id')->get();

        if ($websites->isEmpty()) {
            $this->warn('No se encontraron sitios con plantillas aplicadas.');
            return Command::SUCCESS;
        }

        $this->info("Encontrados {$websites->count()} sitios con plantillas.");
        $this->newLine();

        $totalImported = 0;
        $totalSkipped = 0;

        foreach ($websites as $website) {
            $this->line("Procesando: {$website->name} (ID: {$website->id})");
            
            $result = $this->templatePageService->importTemplatePages(
                $website, 
                $website->template_id
            );

            if ($result['success']) {
                $this->info("  ✓ {$result['imported']} páginas importadas, {$result['skipped']} omitidas");
                $totalImported += $result['imported'];
                $totalSkipped += $result['skipped'];
            } else {
                $this->error("  ✗ {$result['message']}");
            }
        }

        $this->newLine();
        $this->info("✅ Proceso completado:");
        $this->table(
            ['Métrica', 'Total'],
            [
                ['Sitios procesados', $websites->count()],
                ['Páginas importadas', $totalImported],
                ['Páginas omitidas', $totalSkipped],
            ]
        );

        return Command::SUCCESS;
    }

    /**
     * Sincronizar un sitio específico
     */
    protected function syncSpecificWebsite($websiteId, $templateSlug = null)
    {
        $website = Website::find($websiteId);

        if (!$website) {
            $this->error("Sitio con ID {$websiteId} no encontrado.");
            return Command::FAILURE;
        }

        $template = $templateSlug ?? $website->template_id;

        if (!$template) {
            $this->error("Debes especificar una plantilla o el sitio debe tener una plantilla aplicada.");
            return Command::FAILURE;
        }

        $this->info("Sincronizando páginas para: {$website->name}");
        $this->info("Plantilla: {$template}");
        $this->newLine();

        if ($this->option('overwrite')) {
            $this->warn('⚠️  Modo sobrescritura activado. Las páginas existentes serán actualizadas.');
            
            if (!$this->confirm('¿Deseas continuar?')) {
                $this->info('Operación cancelada.');
                return Command::SUCCESS;
            }

            $result = $this->templatePageService->updateExistingPages($website, $template, true);
        } else {
            $result = $this->templatePageService->importTemplatePages($website, $template);
        }

        if ($result['success']) {
            $action = $this->option('overwrite') ? 'actualizadas' : 'importadas';
            $count = $this->option('overwrite') ? $result['updated'] : $result['imported'];
            
            $this->info("✅ {$count} páginas {$action} exitosamente.");
            
            if (!$this->option('overwrite') && isset($result['skipped'])) {
                $this->line("   {$result['skipped']} páginas omitidas (ya existían).");
            }
        } else {
            $this->error("❌ {$result['message']}");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Modo interactivo
     */
    protected function interactiveMode()
    {
        $websites = Website::whereNotNull('template_id')->get();

        if ($websites->isEmpty()) {
            $this->warn('No se encontraron sitios con plantillas aplicadas.');
            
            if ($this->confirm('¿Deseas ver todos los sitios?')) {
                $websites = Website::all();
            } else {
                return Command::SUCCESS;
            }
        }

        $options = $websites->mapWithKeys(function ($website) {
            return [$website->id => "{$website->name} - Template: {$website->template_id}"];
        })->toArray();

        $websiteId = $this->choice(
            '¿Qué sitio deseas sincronizar?',
            $options,
            null
        );

        $websiteId = array_search($websiteId, $options);

        return $this->syncSpecificWebsite($websiteId);
    }
}
