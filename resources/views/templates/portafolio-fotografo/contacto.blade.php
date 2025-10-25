<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto - Portafolio Fotógrafo</title>
    <meta name="description" content="Contáctame para sesiones fotográficas, eventos o consultas sobre mi trabajo.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .font-heading { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
@include('templates.portafolio-fotografo.header')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl font-heading">Contáctame</h1>
                <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">¿Tienes un proyecto en mente? Estoy aquí para ayudarte a capturar esos momentos especiales.</p>
            </div>
        </div>
    </div>
    <!-- Contact Section -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Contact Form -->
            <div class="mt-10 lg:mt-0">
                <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Solicita tu Sesión</h3>
                    <form class="space-y-6" action="#" method="POST">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <div class="mt-1">
                                <input id="phone" name="phone" type="tel" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-700">Tipo de Sesión</label>
                            <div class="mt-1">
                                <select id="service" name="service" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm">
                                    <option value="">Selecciona un tipo de sesión</option>
                                    <option value="retrato">Retrato</option>
                                    <option value="evento">Evento</option>
                                    <option value="producto">Producto</option>
                                    <option value="bodas">Bodas</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required class="shadow-sm focus:ring-cyan-500 focus:border-cyan-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                                Enviar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Contact Info & FAQ -->
            <div class="mt-10 lg:mt-0">
                <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Información de Contacto</h3>
                    <div class="space-y-4 text-gray-700">
                        <p class="flex items-center"><svg class="flex-shrink-0 mr-3 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> info@portafoliofotografo.com</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 mr-3 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +1 234 567 890</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 mr-3 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Estudio Fotográfico, Ciudad</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 mr-3 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Disponible: Lunes a Sábado</p>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 mt-10 font-heading">Preguntas Frecuentes</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Cuánto tiempo toma una sesión?</h4>
                            <p class="text-gray-600">Las sesiones varían según el tipo, desde 1 hora para retratos hasta 8 horas para eventos.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Incluye edición de fotos?</h4>
                            <p class="text-gray-600">Sí, todas las sesiones incluyen edición profesional de las mejores fotos.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Puedo ver las fotos antes de la edición?</h4>
                            <p class="text-gray-600">Sí, te muestro una selección de las mejores fotos para que elijas cuáles editar.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Ofreces paquetes para eventos?</h4>
                            <p class="text-gray-600">Sí, tengo paquetes especiales para bodas, cumpleaños y otros eventos especiales.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('templates.portafolio-fotografo.footer')
</body>
</html>
