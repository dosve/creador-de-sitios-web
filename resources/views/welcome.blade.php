<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creador de Sitios Web - Crea tu sitio web sin código</title>
    <meta name="description" content="La plataforma más fácil para crear, personalizar y publicar sitios web profesionales sin código. Diseña con drag & drop y publica en minutos.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-gray-50 to-white">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-50">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Creador de Sitios Web
                    </h1>
                    <nav class="hidden md:flex space-x-6">
                        <a href="{{ route('plans') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            Planes
                        </a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Panel Admin
                                </a>
                            @else
                                <a href="{{ route('creator.select-website') }}" class="px-4 py-2 text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Seleccionar Sitio
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                Registrarse
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-1">
            <div class="px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-32">
                <div class="text-center">
                    <h1 class="mb-6 text-5xl font-extrabold text-gray-900 md:text-7xl leading-tight">
                        Crea sitios web profesionales
                        <span class="block mt-2 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            sin código
                        </span>
                    </h1>
                    <p class="max-w-3xl mx-auto mb-10 text-xl text-gray-600 md:text-2xl leading-relaxed">
                        La plataforma más fácil para crear, personalizar y publicar sitios web profesionales.
                        Diseña con drag & drop, usa plantillas predefinidas y publica en minutos.
                    </p>

                    @guest
                    <div class="flex flex-col justify-center gap-4 mb-16 sm:flex-row">
                        <a href="{{ route('register') }}" class="group px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Comenzar Gratis
                            <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:border-blue-600 hover:text-blue-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            Iniciar Sesión
                        </a>
                    </div>
                    @else
                    <div class="flex flex-col justify-center gap-4 mb-16 sm:flex-row">
                        <a href="{{ route('creator.select-website') }}" class="group px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Seleccionar Sitio Web
                            <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                    @endguest
                </div>

                <!-- Features Section -->
                <div class="grid max-w-6xl gap-8 mx-auto mt-24 md:grid-cols-3">
                    <div class="p-8 transition-all duration-200 bg-white rounded-2xl shadow-md hover:shadow-xl">
                        <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Editor Visual</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Diseña tu sitio web con nuestro editor drag & drop intuitivo. Sin necesidad de escribir código.
                        </p>
                    </div>

                    <div class="p-8 transition-all duration-200 bg-white rounded-2xl shadow-md hover:shadow-xl">
                        <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Plantillas Profesionales</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Elige entre múltiples plantillas diseñadas profesionalmente y personalízalas a tu gusto.
                        </p>
                    </div>

                    <div class="p-8 transition-all duration-200 bg-white rounded-2xl shadow-md hover:shadow-xl">
                        <div class="flex items-center justify-center w-16 h-16 mb-4 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Publica Instantáneamente</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Publica tu sitio web en minutos y hazlo visible para el mundo entero de forma inmediata.
                        </p>
                    </div>
                </div>

                <!-- Additional Features -->
                <div class="max-w-4xl mx-auto mt-24 text-center">
                    <h2 class="mb-12 text-3xl font-bold text-gray-900 md:text-4xl">
                        Todo lo que necesitas para crear tu sitio web
                    </h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="flex items-start p-6 space-x-4 text-left bg-white rounded-xl shadow-sm">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900">Blog Integrado</h3>
                                <p class="text-sm text-gray-600">Gestiona tu blog y contenido fácilmente</p>
                            </div>
                        </div>
                        <div class="flex items-start p-6 space-x-4 text-left bg-white rounded-xl shadow-sm">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900">Optimización SEO</h3>
                                <p class="text-sm text-gray-600">Mejora tu posicionamiento en buscadores</p>
                            </div>
                        </div>
                        <div class="flex items-start p-6 space-x-4 text-left bg-white rounded-xl shadow-sm">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900">E-commerce</h3>
                                <p class="text-sm text-gray-600">Vende tus productos directamente desde tu sitio</p>
                            </div>
                        </div>
                        <div class="flex items-start p-6 space-x-4 text-left bg-white rounded-xl shadow-sm">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900">Diseño Responsive</h3>
                                <p class="text-sm text-gray-600">Tu sitio se verá perfecto en todos los dispositivos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-12 text-white bg-gradient-to-r from-gray-800 to-gray-900">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="mb-4 text-2xl font-bold">Creador de Sitios Web</h2>
                    <p class="mb-6 text-gray-400">La forma más fácil de crear tu presencia en línea</p>
                <div class="flex justify-center space-x-6 mb-8">
                    <a href="{{ route('plans') }}" class="text-gray-400 hover:text-white transition-colors">
                        Planes
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">
                        Comenzar
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">
                        Acceder
                    </a>
                    @else
                    <a href="{{ route('creator.select-website') }}" class="text-gray-400 hover:text-white transition-colors">
                        Mis Sitios
                    </a>
                    @endguest
                </div>
                    <p class="text-sm text-gray-500">&copy; 2025 Creador de Sitios Web. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>