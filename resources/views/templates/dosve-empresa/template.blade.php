<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $website->name ?? 'Dosve' }} - Desarrollamos sistemas que impulsan tu negocio</title>
    <meta name="description" content="Soluciones tecnológicas a la medida de tu empresa. Más de 10 años desarrollando software empresarial.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .font-heading { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">D</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 font-heading">DOSVE</h1>
                            <p class="text-xs text-gray-500">WWW.DOSVE.CO</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#inicio" class="text-gray-600 hover:text-blue-600 font-medium">Inicio</a>
                    <a href="#servicios" class="text-gray-600 hover:text-blue-600 font-medium">Servicios</a>
                    <a href="#proyectos" class="text-gray-600 hover:text-blue-600 font-medium">Proyectos</a>
                    <a href="#contacto" class="text-gray-600 hover:text-blue-600 font-medium">Contacto</a>
                </nav>
                
                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="#contacto" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="bg-gradient-to-br from-blue-50 to-blue-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 font-heading">
                        Desarrollamos sistemas que impulsan tu negocio
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Soluciones tecnológicas a la medida de tu empresa
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#servicios" class="bg-blue-600 text-white px-8 py-4 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center">
                            Conoce Nuestros Servicios
                        </a>
                        <a href="#proyectos" class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg font-medium hover:bg-blue-50 transition-colors text-center">
                            Ver Proyectos
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 font-heading">Más de 10 años</h3>
                            <p class="text-gray-600 mb-6">Desarrollando soluciones digitales para empresas e instituciones de la región y del país</p>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">2015</div>
                                    <div class="text-gray-500">Primera plataforma web</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">2017</div>
                                    <div class="text-gray-500">Primera app móvil</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">2018</div>
                                    <div class="text-gray-500">Primer video viral</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">2020</div>
                                    <div class="text-gray-500">Primera tienda virtual</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">Sobre Nosotros</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
            </div>
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Nuestra Historia</h3>
                    <p class="text-gray-600 mb-6">
                        Dosve es una empresa de desarrollo de software con 10 años de experiencia, especializada en crear soluciones tecnológicas personalizadas que optimizan los procesos empresariales y potencian la productividad de nuestros clientes.
                    </p>
                    <p class="text-gray-600 mb-8">
                        Nacimos en 2015 en Acacías, Meta, y hoy contamos también con presencia en Bogotá, desde donde ampliamos nuestro alcance para atender proyectos a nivel nacional. Nuestro objetivo es ofrecer herramientas digitales accesibles, seguras y adaptadas a las necesidades de cada negocio.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">10+</div>
                            <div class="text-gray-600">Años de experiencia</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                            <div class="text-gray-600">Proyectos completados</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-3">Misión</h4>
                        <p class="text-gray-600 text-sm">Diseñar y desarrollar sistemas inteligentes que ayuden a las empresas a automatizar, controlar y escalar sus operaciones.</p>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-3">Visión</h4>
                        <p class="text-gray-600 text-sm">Ser una empresa líder en desarrollo de software empresarial en Colombia, reconocida por la innovación y calidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">Nuestros Servicios</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
                <p class="text-xl text-gray-600">Soluciones tecnológicas integrales para tu empresa</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Desarrollo de Software a Medida</h3>
                    <p class="text-gray-600">Plataformas accesibles, seguras y optimizadas para cualquier dispositivo.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Aplicaciones Web</h3>
                    <p class="text-gray-600">Soluciones personalizadas según las necesidades de tu empresa.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Sistemas Empresariales</h3>
                    <p class="text-gray-600">Gestión completa de ventas, inventarios, contabilidad y clientes.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Aplicaciones Móviles</h3>
                    <p class="text-gray-600">Desarrollo para Android y iOS con conexión a sistemas empresariales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">Tecnologías que Usamos</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">R</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">React</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">L</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Laravel</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">N</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Node.js</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">JS</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">JavaScript</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">M</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">MySQL</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">G</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Google Cloud</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">G</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">GitHub</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">AI</span>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Inteligencia Artificial</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="proyectos" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">Nuestros Proyectos</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
                <p class="text-xl text-gray-600">Conoce nuestros últimos proyectos</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-xl">1</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Segundos App</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Solución móvil integral de entrega y servicios, conectando usuarios con proveedores locales.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">React Native</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Node.js</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">MongoDB</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-xl">2</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Yo Compro Acacías</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Plataforma oficial municipal para visibilizar negocios locales y fortalecer la economía local.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Laravel</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Vue.js</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">MySQL</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-xl">3</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Admin Negocios</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Sistema integral de gestión empresarial para manejar compras, ventas, inventarios y más.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Laravel</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">React</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">PostgreSQL</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-xl">4</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">EME10</h3>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Suite empresarial que optimiza gestión, comunicación y automatización con IA.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Laravel</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Vue.js</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">AI/ML</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">Nuestros Valores</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Compromiso</h3>
                    <p class="text-gray-600">Priorizamos la comunicación y transparencia con cada cliente.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Confianza</h3>
                    <p class="text-gray-600">Cumplimos cada proyecto con responsabilidad y excelencia.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Innovación</h3>
                    <p class="text-gray-600">Incorporamos tecnologías modernas para ofrecer soluciones escalables.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Aprendizaje continuo</h3>
                    <p class="text-gray-600">Evolucionamos constantemente con las nuevas tendencias tecnológicas.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Eficiencia</h3>
                    <p class="text-gray-600">Optimizamos recursos y tiempos para maximizar resultados.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">¿Por qué Elegirnos?</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Más de 10 años de experiencia</h3>
                    <p class="text-gray-600">Una trayectoria sólida desarrollando soluciones tecnológicas a nivel nacional.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Empresa legalmente constituida</h3>
                    <p class="text-gray-600">Operamos bajo los lineamientos legales, ofreciendo confianza y respaldo.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Cumplimiento y responsabilidad</h3>
                    <p class="text-gray-600">Respetamos los tiempos y acuerdos establecidos en cada proyecto.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Soporte permanente</h3>
                    <p class="text-gray-600">Brindamos acompañamiento técnico continuo a todos nuestros clientes.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Honestidad y transparencia</h3>
                    <p class="text-gray-600">Nuestras relaciones comerciales se basan en la confianza y la ética.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">Tarifas justas y competitivas</h3>
                    <p class="text-gray-600">Ofrecemos precios equilibrados, acordes a la calidad de nuestros desarrollos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contacto" class="py-20 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 font-heading">Estamos listos para trabajar en tu proyecto</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Contamos con un equipo de profesionales experimentados y altamente capacitados, dispuesto a iniciar de inmediato el desarrollo de tu proyecto.
            </p>
            <a href="#contacto" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-block">
                Contáctanos
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-xl">D</span>
                        </div>
                        <h3 class="text-2xl font-bold font-heading">DOSVE</h3>
                    </div>
                    <p class="text-gray-400 mb-6">
                        Desarrollamos sistemas que impulsan tu negocio. Soluciones tecnológicas a la medida de tu empresa.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6 font-heading">Servicios</h4>
                    <ul class="space-y-3">
                        <li><a href="#servicios" class="text-gray-400 hover:text-white transition-colors">Desarrollo de Software</a></li>
                        <li><a href="#servicios" class="text-gray-400 hover:text-white transition-colors">Aplicaciones Web</a></li>
                        <li><a href="#servicios" class="text-gray-400 hover:text-white transition-colors">Sistemas Empresariales</a></li>
                        <li><a href="#servicios" class="text-gray-400 hover:text-white transition-colors">Aplicaciones Móviles</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6 font-heading">Proyectos</h4>
                    <ul class="space-y-3">
                        <li><a href="#proyectos" class="text-gray-400 hover:text-white transition-colors">Segundos App</a></li>
                        <li><a href="#proyectos" class="text-gray-400 hover:text-white transition-colors">Yo Compro Acacías</a></li>
                        <li><a href="#proyectos" class="text-gray-400 hover:text-white transition-colors">Admin Negocios</a></li>
                        <li><a href="#proyectos" class="text-gray-400 hover:text-white transition-colors">EME10</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6 font-heading">Contacto</h4>
                    <div class="space-y-3">
                        <p class="text-gray-400">311 323 03 41</p>
                        <p class="text-gray-400">gerencia@dosve.co</p>
                        <p class="text-gray-400">Carrera 45a #16-05, Bogotá DC</p>
                        <p class="text-gray-400">WWW.DOSVE.CO</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Dosve. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
