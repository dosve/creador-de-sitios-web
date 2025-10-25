<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto - Dosve</title>
    <meta name="description" content="Contáctanos para desarrollar tu proyecto. Estamos listos para trabajar contigo.">
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
                    <a href="{{ route('creator.templates.preview', 'dosve-empresa') }}" class="text-gray-600 hover:text-blue-600 font-medium">Inicio</a>
                    <a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#servicios" class="text-gray-600 hover:text-blue-600 font-medium">Servicios</a>
                    <a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#proyectos" class="text-gray-600 hover:text-blue-600 font-medium">Proyectos</a>
                    <a href="{{ route('creator.templates.contacto', 'dosve-empresa') }}" class="text-blue-600 font-medium">Contacto</a>
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

    <!-- Contact Header -->
    <section class="bg-gradient-to-br from-blue-50 to-blue-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 font-heading">Contáctanos</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Estamos listos para trabajar en tu proyecto. Contamos con un equipo de profesionales experimentados y altamente capacitados.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Envíanos un Mensaje</h2>
                        <form class="space-y-6" action="#" method="POST">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                    <input id="name" name="name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                    <input id="email" name="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <input id="phone" name="phone" type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                                    <input id="company" name="company" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Servicio de Interés</label>
                                <select id="service" name="service" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona un servicio</option>
                                    <option value="desarrollo-software">Desarrollo de Software a Medida</option>
                                    <option value="aplicaciones-web">Aplicaciones Web</option>
                                    <option value="sistemas-empresariales">Sistemas Empresariales (ERP/POS/CRM)</option>
                                    <option value="aplicaciones-moviles">Aplicaciones Móviles</option>
                                    <option value="consultoria">Consultoría Tecnológica</option>
                                </select>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                                <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                Enviar Mensaje
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Información de Contacto</h2>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Correo Electrónico</h3>
                                    <p class="text-gray-600">gerencia@dosve.co</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Teléfono</h3>
                                    <p class="text-gray-600">311 323 03 41</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Dirección</h3>
                                    <p class="text-gray-600">Carrera 45a #16-05, Bogotá DC</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Sitio Web</h3>
                                    <p class="text-gray-600">WWW.DOSVE.CO</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Why Choose Us -->
                    <div class="bg-blue-50 p-8 rounded-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 font-heading">¿Por qué elegirnos?</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Más de 10 años de experiencia</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Empresa legalmente constituida</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Soporte técnico permanente</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Tarifas justas y competitivas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#servicios" class="text-gray-400 hover:text-white transition-colors">Desarrollo de Software</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#servicios" class="text-gray-400 hover:text-white transition-colors">Aplicaciones Web</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#servicios" class="text-gray-400 hover:text-white transition-colors">Sistemas Empresariales</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#servicios" class="text-gray-400 hover:text-white transition-colors">Aplicaciones Móviles</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6 font-heading">Proyectos</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#proyectos" class="text-gray-400 hover:text-white transition-colors">Segundos App</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#proyectos" class="text-gray-400 hover:text-white transition-colors">Yo Compro Acacías</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#proyectos" class="text-gray-400 hover:text-white transition-colors">Admin Negocios</a></li>
                        <li><a href="{{ route('creator.templates.preview', 'dosve-empresa') }}#proyectos" class="text-gray-400 hover:text-white transition-colors">EME10</a></li>
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
