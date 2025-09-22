<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;

class ListTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listar todas las plantillas disponibles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Plantillas disponibles:');
        $this->newLine();
        
        $templates = Template::all();
        
        if ($templates->isEmpty()) {
            $this->warn('No hay plantillas disponibles.');
            return 0;
        }
        
        $headers = ['ID', 'Nombre', 'Categoría', 'Premium', 'Activa'];
        $rows = [];
        
        foreach ($templates as $template) {
            $rows[] = [
                $template->id,
                $template->name,
                $template->category,
                $template->is_premium ? 'Sí' : 'No',
                $template->is_active ? 'Sí' : 'No',
            ];
        }
        
        $this->table($headers, $rows);
        
        return 0;
    }
}