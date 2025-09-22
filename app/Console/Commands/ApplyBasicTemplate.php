<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\Template;

class ApplyBasicTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:apply-basic-template {website_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aplicar la plantilla básica a un sitio web específico o a todos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websiteId = $this->argument('website_id');
        
        $this->info('Buscando plantilla básica...');
        
        $template = Template::where('name', 'Plantilla Básica')->first();
        
        if (!$template) {
            $this->error('Plantilla básica no encontrada. Ejecuta primero: php artisan db:seed --class=DefaultTemplateSeeder');
            return 1;
        }
        
        $this->info("Plantilla encontrada: {$template->name} (ID: {$template->id})");
        
        if ($websiteId) {
            // Aplicar a un sitio web específico
            $website = Website::find($websiteId);
            if (!$website) {
                $this->error("Sitio web con ID {$websiteId} no encontrado.");
                return 1;
            }
            
            $website->update(['template_id' => $template->id]);
            $this->info("✅ Plantilla aplicada al sitio web: {$website->name}");
        } else {
            // Aplicar a todos los sitios web
            $updated = Website::query()->update(['template_id' => $template->id]);
            $this->info("✅ Plantilla aplicada a {$updated} sitios web");
        }
        
        return 0;
    }
}