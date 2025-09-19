# Scripts de Reset de Plantillas

Este directorio contiene scripts para vaciar la tabla de plantillas y volver a ejecutar el seeder.

## Scripts Disponibles

### 1. Script PHP (`reset_templates.php`)
Script en PHP que utiliza Laravel directamente.

```bash
php scripts/reset_templates.php
```

### 2. Script Bash (`reset_templates.sh`)
Script en bash que utiliza comandos de Artisan.

```bash
./scripts/reset_templates.sh
```

### 3. Comando Artisan (`templates:reset`)
Comando personalizado de Laravel.

```bash
# Con confirmación
php artisan templates:reset

# Sin confirmación (forzado)
php artisan templates:reset --force
```

## ¿Qué hace cada script?

1. **Verifica** cuántos registros hay en la tabla `templates`
2. **Vacía** la tabla si tiene registros
3. **Verifica** que la tabla esté vacía
4. **Ejecuta** el seeder `TemplateSeeder` si la tabla está vacía
5. **Confirma** que las plantillas se cargaron correctamente

## Salida Esperada

```
=== Script de Reset de Plantillas ===

Registros actuales en la tabla templates: 1
Vaciando tabla templates...
✓ Tabla vaciada exitosamente
Registros después de vaciar: 0

Ejecutando seeder de plantillas...
✓ Seeder ejecutado exitosamente
Registros finales en la tabla templates: 1
✓ Plantillas cargadas correctamente

=== Script completado ===
```

## Recomendación

Usa el **script bash** (`./scripts/reset_templates.sh`) ya que es el más confiable y muestra la salida completa.
