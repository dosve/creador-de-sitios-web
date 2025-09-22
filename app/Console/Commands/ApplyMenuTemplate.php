<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\Template;

class ApplyMenuTemplate extends Command
{
    protected $signature = 'website:apply-menu-template {website_id?}';
    protected $description = 'Aplicar la plantilla con menús a un sitio web';

    public function handle()
    {
        $websiteId = $this->argument('website_id');
        
        $this->info('Buscando plantilla con menús...');
        
        $template = Template::where('name', 'Plantilla con Menús')->first();
        
        if (!$template) {
            $this->error('Plantilla con menús no encontrada. Ejecuta primero: php artisan template:create-menu');
            return 1;
        }
        
        $this->info("Plantilla encontrada: {$template->name} (ID: {$template->id})");
        
        if ($websiteId) {
            $website = Website::find($websiteId);
            if (!$website) {
                $this->error("Sitio web con ID {$websiteId} no encontrado.");
                return 1;
            }
            
            $website->update(['template_id' => $template->id]);
            $this->info("✅ Plantilla aplicada al sitio web: {$website->name}");
        } else {
            $updated = Website::query()->update(['template_id' => $template->id]);
            $this->info("✅ Plantilla aplicada a {$updated} sitios web");
        }
        
        return 0;
    }
}