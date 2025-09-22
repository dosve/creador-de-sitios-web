<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use App\Models\Website;

class ApplyDefaultTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:apply-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aplicar la plantilla básica por defecto a todos los sitios web que no tengan plantilla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando plantilla básica...');
        
        $template = Template::where('name', 'Plantilla Básica')->first();
        
        if (!$template) {
            $this->error('Plantilla básica no encontrada. Ejecuta primero: php artisan db:seed --class=DefaultTemplateSeeder');
            return 1;
        }
        
        $this->info("Plantilla encontrada: {$template->name} (ID: {$template->id})");
        
        // Contar sitios web sin plantilla
        $websitesWithoutTemplate = Website::whereNull('template_id')->count();
        $this->info("Sitios web sin plantilla: {$websitesWithoutTemplate}");
        
        if ($websitesWithoutTemplate === 0) {
            $this->info('Todos los sitios web ya tienen una plantilla asignada.');
            return 0;
        }
        
        // Aplicar plantilla a sitios web sin plantilla
        $updated = Website::whereNull('template_id')->update(['template_id' => $template->id]);
        
        $this->info("✅ Plantilla aplicada a {$updated} sitios web");
        
        // Mostrar resumen
        $totalWithTemplate = Website::where('template_id', $template->id)->count();
        $this->info("Total de sitios web con plantilla básica: {$totalWithTemplate}");
        
        return 0;
    }
}