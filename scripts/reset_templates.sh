#!/bin/bash

echo "=== Script de Reset de Plantillas ==="
echo ""

# Verificar registros actuales
echo "Verificando registros actuales..."
CURRENT_COUNT=$(php artisan tinker --execute="echo DB::table('templates')->count();" 2>/dev/null | tail -1)
echo "Registros actuales en la tabla templates: $CURRENT_COUNT"

# Vaciar la tabla
if [ "$CURRENT_COUNT" -gt 0 ]; then
    echo "Vaciando tabla templates..."
    php artisan tinker --execute="DB::table('templates')->truncate();" > /dev/null 2>&1
    echo "✓ Tabla vaciada exitosamente"
else
    echo "✓ La tabla ya está vacía"
fi

# Verificar que esté vacía
AFTER_COUNT=$(php artisan tinker --execute="echo DB::table('templates')->count();" 2>/dev/null | tail -1)
echo "Registros después de vaciar: $AFTER_COUNT"

# Si está vacía, ejecutar el seeder
if [ "$AFTER_COUNT" -eq 0 ]; then
    echo ""
    echo "Ejecutando seeder de plantillas..."
    php artisan db:seed --class=TemplateSeeder
    echo "✓ Seeder ejecutado exitosamente"
    
    # Verificar el resultado final
    FINAL_COUNT=$(php artisan tinker --execute="echo DB::table('templates')->count();" 2>/dev/null | tail -1)
    echo "Registros finales en la tabla templates: $FINAL_COUNT"
    
    if [ "$FINAL_COUNT" -gt 0 ]; then
        echo "✓ Plantillas cargadas correctamente"
    else
        echo "⚠ Advertencia: No se cargaron plantillas"
    fi
else
    echo "⚠ Error: La tabla no se vació correctamente"
fi

echo ""
echo "=== Script completado ==="
