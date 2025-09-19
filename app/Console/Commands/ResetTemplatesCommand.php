<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTemplatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:reset {--force : Forzar el reset sin confirmación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vacía la tabla de plantillas y ejecuta el seeder si está vacía';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Script de Reset de Plantillas ===');
        $this->newLine();

        try {
            // 1. Verificar registros actuales
            $currentCount = DB::table('templates')->count();
            $this->info("Registros actuales en la tabla templates: {$currentCount}");
            
            // 2. Vaciar la tabla
            if ($currentCount > 0) {
                if (!$this->option('force')) {
                    if (!$this->confirm('¿Estás seguro de que quieres vaciar la tabla de plantillas?')) {
                        $this->info('Operación cancelada.');
                        return;
                    }
                }
                
                $this->info('Vaciando tabla templates...');
                DB::table('templates')->truncate();
                $this->info('✓ Tabla vaciada exitosamente');
            } else {
                $this->info('✓ La tabla ya está vacía');
            }
            
            // 3. Verificar que esté vacía
            $countAfterTruncate = DB::table('templates')->count();
            $this->info("Registros después de vaciar: {$countAfterTruncate}");
            
            // 4. Si está vacía, ejecutar el seeder
            if ($countAfterTruncate === 0) {
                $this->newLine();
                $this->info('Ejecutando seeder de plantillas...');
                
                // Ejecutar el seeder específico
                $this->call('db:seed', [
                    '--class' => 'TemplateSeeder'
                ]);
                
                $this->info('✓ Seeder ejecutado exitosamente');
                
                // 5. Verificar el resultado final
                $finalCount = DB::table('templates')->count();
                $this->info("Registros finales en la tabla templates: {$finalCount}");
                
                if ($finalCount > 0) {
                    $this->info('✓ Plantillas cargadas correctamente');
                } else {
                    $this->warn('⚠ Advertencia: No se cargaron plantillas');
                }
                
            } else {
                $this->error('⚠ Error: La tabla no se vació correctamente');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }

        $this->newLine();
        $this->info('=== Script completado ===');
        return 0;
    }
}
