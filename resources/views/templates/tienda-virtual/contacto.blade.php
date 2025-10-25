<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto - Tienda Virtual</title>
    <meta name="description" content="Contáctanos para consultas sobre productos, envíos o soporte técnico.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .font-heading { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
@include('templates.tienda-virtual.header')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl font-heading">Contáctanos</h1>
                <p class="max-w-xl mx-auto mt-5 text-xl text-gray-500">¿Tienes preguntas sobre nuestros productos o servicios? Estamos aquí para ayudarte.</p>
            </div>
        </div>
    </div>
    <!-- Contact Section -->
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Contact Form -->
            <div class="mt-10 lg:mt-0">
                <div class="px-6 py-8 bg-white rounded-lg shadow sm:px-10">
                    <h3 class="mb-6 text-2xl font-bold text-gray-900 font-heading">Envíanos un Mensaje</h3>
                    <form class="space-y-6" action="#" method="POST">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" autocomplete="name" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <div class="mt-1">
                                <input id="phone" name="phone" type="tel" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                            <div class="mt-1">
                                <input id="subject" name="subject" type="text" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                                Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Contact Info & FAQ -->
            <div class="mt-10 lg:mt-0">
                <div class="px-6 py-8 bg-white rounded-lg shadow sm:px-10">
                    <h3 class="mb-6 text-2xl font-bold text-gray-900 font-heading">Información de Contacto</h3>
                    <div class="space-y-4 text-gray-700">
                        <p class="flex items-center"><svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> info@tiendavirtual.com</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +1 234 567 890</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Av. Digital #258, Centro</p>
                        <p class="flex items-center"><svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Soporte 24/7</p>
                    </div>
                    <h3 class="mt-10 mb-6 text-2xl font-bold text-gray-900 font-heading">Preguntas Frecuentes</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Cuánto tiempo toma el envío?</h4>
                            <p class="text-gray-600">El envío estándar toma 3-5 días hábiles, y el express 1-2 días hábiles.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Aceptan devoluciones?</h4>
                            <p class="text-gray-600">Sí, aceptamos devoluciones hasta 30 días después de la compra.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Ofrecen garantía?</h4>
                            <p class="text-gray-600">Sí, todos nuestros productos tienen garantía de 1 año.</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">¿Puedo rastrear mi pedido?</h4>
                            <p class="text-gray-600">Sí, recibirás un código de seguimiento por email una vez que tu pedido sea enviado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('templates.tienda-virtual.footer')
</body>
</html>
