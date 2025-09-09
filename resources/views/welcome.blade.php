<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creador de Sitios Web</title>
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900">Creador de Sitios Web</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Panel Admin
                        </a>
                        @else
                        <a href="{{ route('creator.dashboard') }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Mi Dashboard
                        </a>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Registrarse
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex items-center justify-center flex-1">
            <div class="max-w-4xl px-4 mx-auto text-center sm:px-6 lg:px-8">
                <h1 class="mb-6 text-4xl font-bold text-gray-900 md:text-6xl">
                    Crea sitios web profesionales
                    <span class="text-blue-600">sin código</span>
                </h1>
                <p class="max-w-2xl mx-auto mb-8 text-xl text-gray-600">
                    La plataforma más fácil para crear, personalizar y publicar sitios web profesionales.
                    Diseña con drag & drop, usa plantillas predefinidas y publica en minutos.
                </p>

                @guest
                <div class="flex flex-col justify-center gap-4 sm:flex-row">
                    <a href="{{ route('register') }}" class="px-8 py-3 text-lg font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        Comenzar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 text-lg font-medium text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                        Iniciar Sesión
                    </a>
                </div>
                @endguest

            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8 text-white bg-gray-800">
            <div class="px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
                <p>&copy; 2025 Creador de Sitios Web. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

</body>

</html>