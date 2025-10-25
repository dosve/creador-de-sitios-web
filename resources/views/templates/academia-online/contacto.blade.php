<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto - Academia Online</title>
    <meta name="description" content="¿Tienes preguntas? Estamos aquí para ayudarte.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .font-heading { font-family: 'Raleway', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
@include('templates.academia-online.header')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Contacto</h1>
                <p class="text-xl text-gray-600 mb-8">¿Tienes Preguntas?</p>
                <p class="text-lg text-gray-500 max-w-3xl mx-auto">
                    Nuestro equipo está listo para ayudarte con cualquier consulta sobre nuestros cursos
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h2>
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                        <select id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Selecciona un asunto</option>
                            <option value="informacion">Información sobre cursos</option>
                            <option value="soporte">Soporte técnico</option>
                            <option value="billing">Facturación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="Cuéntanos en qué podemos ayudarte..."></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Enviar Mensaje
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                                <p class="text-gray-600">info@academiaonline.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Teléfono</h3>
                                <p class="text-gray-600">+1 234 567 890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Dirección</h3>
                                <p class="text-gray-600">Av. Educación #123, Centro<br>Ciudad, País</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Horarios</h3>
                                <p class="text-gray-600">Lunes a Viernes: 9:00 - 18:00<br>Sábados: 9:00 - 14:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Preguntas Frecuentes</h2>
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Cómo me inscribo a un curso?</h3>
                            <p class="text-gray-600">Puedes inscribirte directamente desde la página del curso o contactarnos para más información.</p>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Recibo certificados al completar un curso?</h3>
                            <p class="text-gray-600">Sí, todos nuestros cursos incluyen certificados de finalización.</p>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Cuánto tiempo tengo para completar un curso?</h3>
                            <p class="text-gray-600">Tienes acceso de por vida a todos los cursos que compres.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Puedo acceder a los cursos desde mi móvil?</h3>
                            <p class="text-gray-600">Sí, nuestra plataforma es completamente responsive y funciona en todos los dispositivos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('templates.academia-online.footer')
</body>
</html>
