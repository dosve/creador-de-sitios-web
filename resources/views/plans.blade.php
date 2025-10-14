<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes y Precios - Creador de Sitios Web</title>
    <meta name="description" content="Elige el plan perfecto para tu negocio. Desde planes gratuitos hasta empresariales.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-50 to-white">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Creador de Sitios Web
                    </a>
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
    <section class="py-20 text-center">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="mb-6 text-5xl font-extrabold text-gray-900 md:text-6xl">
                Planes y Precios
            </h1>
            <p class="max-w-2xl mx-auto mb-12 text-xl text-gray-600">
                Elige el plan perfecto para tu negocio. Comienza gratis y escala cuando lo necesites.
            </p>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="pb-20">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid max-w-6xl gap-8 mx-auto md:grid-cols-2 lg:grid-cols-4">
                @forelse($plans as $plan)
                <div class="relative flex flex-col p-8 bg-white border-2 {{ $plan->id == 2 ? 'border-blue-600 shadow-xl scale-105' : 'border-gray-200' }} rounded-2xl transition-all duration-200 hover:shadow-xl {{ $plan->id == 2 ? '' : 'hover:border-blue-400' }}">
                    @if($plan->id == 2)
                    <div class="absolute top-0 right-0 px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded-bl-lg rounded-tr-xl">
                        Popular
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="mb-2 text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $plan->description }}</p>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-5xl font-extrabold text-gray-900">
                                @if($plan->price > 0)
                                    ${{ number_format($plan->price, 0) }}
                                @else
                                    Gratis
                                @endif
                            </span>
                            @if($plan->price > 0)
                            <span class="ml-2 text-gray-600">
                                /{{ $plan->billing_cycle == 'monthly' ? 'mes' : 'año' }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <ul class="flex-1 mb-8 space-y-3">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $plan->max_websites }} {{ $plan->max_websites == 1 ? 'sitio web' : 'sitios web' }}</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $plan->max_pages }} páginas</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 {{ $plan->custom_domain ? 'text-green-500' : 'text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="{{ $plan->custom_domain ? '' : 'text-gray-400' }}">Dominio personalizado</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 {{ $plan->ecommerce ? 'text-green-500' : 'text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="{{ $plan->ecommerce ? '' : 'text-gray-400' }}">E-commerce</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 {{ $plan->seo_tools ? 'text-green-500' : 'text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="{{ $plan->seo_tools ? '' : 'text-gray-400' }}">Herramientas SEO</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-3 {{ $plan->analytics ? 'text-green-500' : 'text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="{{ $plan->analytics ? '' : 'text-gray-400' }}">Analytics</span>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="block w-full py-3 text-center font-semibold rounded-lg transition-all duration-200 {{ $plan->id == 2 ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-md' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                        @if($plan->price > 0)
                            Comenzar ahora
                        @else
                            Comenzar gratis
                        @endif
                    </a>
                </div>
                @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500">No hay planes disponibles en este momento.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
            <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Preguntas Frecuentes</h2>
            <div class="space-y-6">
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">¿Puedo cambiar de plan en cualquier momento?</h3>
                    <p class="text-gray-600">Sí, puedes actualizar o degradar tu plan en cualquier momento desde tu panel de control.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">¿El plan gratuito tiene límite de tiempo?</h3>
                    <p class="text-gray-600">No, el plan gratuito es completamente gratis para siempre, con las características incluidas.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">¿Qué métodos de pago aceptan?</h3>
                    <p class="text-gray-600">Aceptamos tarjetas de crédito, débito y transferencias bancarias.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 text-white bg-gradient-to-r from-gray-800 to-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="mb-4 text-2xl font-bold">Creador de Sitios Web</h2>
                <p class="mb-6 text-gray-400">La forma más fácil de crear tu presencia en línea</p>
                <div class="flex justify-center space-x-6 mb-8">
                    <a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white transition-colors">Inicio</a>
                    <a href="{{ route('plans') }}" class="text-gray-400 hover:text-white transition-colors">Planes</a>
                    @guest
                    <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">Comenzar</a>
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Acceder</a>
                    @endguest
                </div>
                <p class="text-sm text-gray-500">&copy; 2025 Creador de Sitios Web. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>

