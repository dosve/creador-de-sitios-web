@echo off
chcp 65001 >nul
cd /d "%~dp0"

echo.
echo === Reset y recrear sitio LYMAN SAS ===
echo.

echo [1/3] Eliminando sitio lyman-sas...
php scripts/reset-lyman.php
if errorlevel 1 (
    echo Error al ejecutar reset-lyman.php
    pause
    exit /b 1
)

echo.
echo [2/3] Creando sitio y pagina Inicio (elige propietario cuando lo pida)...
php artisan db:seed --class=LymanSasPageSeeder
if errorlevel 1 (
    echo Error en LymanSasPageSeeder
    pause
    exit /b 1
)

echo.
echo [3/3] Creando menu de navegacion...
php artisan db:seed --class=LymanSasMenuSeeder
if errorlevel 1 (
    echo Error en LymanSasMenuSeeder
    pause
    exit /b 1
)

echo.
echo === Listo ===
pause
