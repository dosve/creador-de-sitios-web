<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Web en Desarrollo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <!-- Icono -->
        <div class="mb-6">
            <svg class="w-16 h-16 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>

        <!-- Título -->
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            Sitio Web en Desarrollo
        </h1>

        <!-- Descripción -->
        <p class="text-gray-600 mb-6">
            Este sitio web está siendo desarrollado y aún no está disponible públicamente. 
            Pronto estará listo para mostrarte contenido increíble.
        </p>

        <!-- Información adicional -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-blue-800 text-sm">
                <strong>¿Eres el propietario de este sitio?</strong><br>
                Si eres el administrador, puedes iniciar sesión para verlo en desarrollo o publicarlo.
            </p>
        </div>

        <!-- Botones de acción -->
        <div class="space-y-3">
            <a href="/login" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                Iniciar Sesión (Propietario)
            </a>
            <a href="/" class="block w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                Ir al Inicio de la Plataforma
            </a>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500">
                Powered by <strong>Creador de Sitios Web</strong>
            </p>
        </div>
    </div>
</body>
</html>
