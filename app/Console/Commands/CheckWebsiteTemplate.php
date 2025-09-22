<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\Template;

class CheckWebsiteTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:check-template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar qué plantillas tienen asignadas los sitios web';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando plantillas de sitios web...');
        $this->newLine();
        
        $websites = Website::with('template')->get();
        
        if ($websites->isEmpty()) {
            $this->warn('No hay sitios web disponibles.');
            return 0;
        }
        
        $headers = ['ID', 'Nombre', 'Plantilla', 'Plantilla ID'];
        $rows = [];
        
        foreach ($websites as $website) {
            $rows[] = [
                $website->id,
                $website->name,
                $website->template ? $website->template->name : 'Sin plantilla',
                $website->template_id ?? 'N/A',
            ];
        }
        
        $this->table($headers, $rows);
        
        // Mostrar resumen
        $this->newLine();
        $withTemplate = $websites->where('template_id', '!=', null)->count();
        $withoutTemplate = $websites->where('template_id', null)->count();
        
        $this->info("Resumen:");
        $this->info("- Sitios con plantilla: {$withTemplate}");
        $this->info("- Sitios sin plantilla: {$withoutTemplate}");
        
        return 0;
    }
}