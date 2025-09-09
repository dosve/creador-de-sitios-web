<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - {{ $page->title }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>
        .gjs-pn-panel {
            background: #f8f9fa;
        }

        .gjs-block {
            width: auto;
            height: auto;
            min-height: auto;
            padding: 10px;
            margin: 5px;
        }

        .gjs-block-section {
            background: #e3f2fd;
            border: 2px dashed #2196f3;
        }

        .gjs-block-text {
            background: #f3e5f5;
            border: 2px dashed #9c27b0;
        }

        .gjs-block-image {
            background: #e8f5e8;
            border: 2px dashed #4caf50;
        }

        .gjs-block-video {
            background: #fff3e0;
            border: 2px dashed #ff9800;
        }

        .gjs-block-form {
            background: #fce4ec;
            border: 2px dashed #e91e63;
        }

        .gjs-block-gallery {
            background: #f1f8e9;
            border: 2px dashed #8bc34a;
        }

        .gjs-block-testimonial {
            background: #e0f2f1;
            border: 2px dashed #009688;
        }

        .gjs-block-pricing {
            background: #fff8e1;
            border: 2px dashed #ffc107;
        }

        .gjs-block-contact {
            background: #e8eaf6;
            border: 2px dashed #3f51b5;
        }

        .gjs-block-newsletter {
            background: #f3e5f5;
            border: 2px dashed #9c27b0;
        }

        .gjs-block-map {
            background: #e0f7fa;
            border: 2px dashed #00bcd4;
        }

        .gjs-block-social {
            background: #f9fbe7;
            border: 2px dashed #827717;
        }
    </style>
</head>

<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b flex-shrink-0">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.websites.show', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg font-medium text-gray-900">{{ $page->title }}</h1>
                            <p class="text-sm text-gray-500">{{ $website->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button id="save-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Guardar
                        </button>
                        <a href="{{ route('creator.pages.show', [$website, $page]) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            Vista Previa
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Editor -->
        <div class="flex-1 flex">
            <!-- Sidebar con paneles -->
            <div class="w-80 bg-gray-50 border-r border-gray-200 flex flex-col">
                <!-- Panel Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-4" aria-label="Tabs">
                        <button class="tab-button active border-b-2 border-blue-500 py-3 px-1 text-center border-b-2 font-medium text-sm text-blue-600" data-panel="blocks">
                            Bloques
                        </button>
                        <button class="tab-button border-b-2 border-transparent py-3 px-1 text-center border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-panel="layers">
                            Capas
                        </button>
                        <button class="tab-button border-b-2 border-transparent py-3 px-1 text-center border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-panel="styles">
                            Estilos
                        </button>
                        <button class="tab-button border-b-2 border-transparent py-3 px-1 text-center border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-panel="traits">
                            Propiedades
                        </button>
                    </nav>
                </div>

                <!-- Panel Content -->
                <div class="flex-1 overflow-auto">
                    <div id="blocks-panel" class="panel-content p-4">
                        <div id="gjs-blocks" class="gjs-blocks-container"></div>
                    </div>
                    <div id="layers-panel" class="panel-content p-4 hidden">
                        <div class="layers-container"></div>
                    </div>
                    <div id="styles-panel" class="panel-content p-4 hidden">
                        <div class="styles-container"></div>
                    </div>
                    <div id="traits-panel" class="panel-content p-4 hidden">
                        <div class="traits-container"></div>
                    </div>
                </div>
            </div>

            <!-- Main Editor Canvas -->
            <div class="flex-1 flex flex-col">
                <!-- Device Toolbar -->
                <div class="bg-white border-b border-gray-200 px-4 py-2">
                    <div class="flex items-center justify-center space-x-4">
                        <button class="device-btn active px-3 py-1 text-xs font-medium rounded bg-blue-100 text-blue-700" data-device="desktop">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="4" width="20" height="12" rx="2" ry="2"></rect>
                                <line x1="2" y1="20" x2="22" y2="20"></line>
                                <line x1="12" y1="16" x2="12" y2="20"></line>
                            </svg>
                            Desktop
                        </button>
                        <button class="device-btn px-3 py-1 text-xs font-medium rounded hover:bg-gray-100 text-gray-600" data-device="tablet">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                            Tablet
                        </button>
                        <button class="device-btn px-3 py-1 text-xs font-medium rounded hover:bg-gray-100 text-gray-600" data-device="mobile">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            </svg>
                            Móvil
                        </button>
                    </div>
                </div>

                <!-- Canvas -->
                <div class="flex-1">
                    <div id="gjs" style="height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/grapesjs"></script>
    <script>
        const editor = grapesjs.init({
            container: '#gjs',
            height: '100%',
            width: '100%',
            storageManager: false,
            plugins: [],
            pluginsOpts: {},
            showOffsets: true,
            noticeOnUnload: true,
            canvas: {
                styles: [
                    'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'
                ]
            },
            deviceManager: {
                devices: [{
                        name: 'Desktop',
                        width: '',
                    },
                    {
                        name: 'Tablet',
                        width: '768px',
                        widthMedia: '992px',
                    },
                    {
                        name: 'Mobile portrait',
                        width: '320px',
                        widthMedia: '575px',
                    }
                ]
            },
            blockManager: {
                appendTo: '#gjs-blocks',
                blocks: [
                    // Bloques básicos
                    {
                        id: 'section',
                        label: '<b>Sección</b>',
                        attributes: {
                            class: 'gjs-block-section'
                        },
                        content: `<section class="p-8 bg-gray-100">
                            <h1 class="text-3xl font-bold text-center">Título de la Sección</h1>
                            <p class="text-center mt-4 text-gray-600">Contenido de la sección...</p>
                        </section>`,
                    },
                    {
                        id: 'text',
                        label: 'Texto',
                        content: '<div data-gjs-type="text" class="p-4">Haz clic para editar este texto</div>',
                    },
                    {
                        id: 'heading',
                        label: 'Título',
                        content: '<h2 class="text-2xl font-bold text-gray-900">Título Principal</h2>',
                    },
                    {
                        id: 'paragraph',
                        label: 'Párrafo',
                        content: '<p class="text-gray-700 leading-relaxed">Este es un párrafo de ejemplo. Puedes editarlo haciendo clic en él.</p>',
                    },
                    {
                        id: 'image',
                        label: 'Imagen',
                        select: true,
                        content: {
                            type: 'image'
                        },
                        activate: true,
                    },
                    {
                        id: 'button',
                        label: 'Botón',
                        content: '<button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">Botón</button>',
                    },
                    {
                        id: 'link',
                        label: 'Enlace',
                        content: '<a href="#" class="text-blue-600 hover:text-blue-800 underline">Enlace de ejemplo</a>',
                    },
                    {
                        id: 'divider',
                        label: 'Divisor',
                        content: '<hr class="border-gray-300 my-8">',
                    },
                    {
                        id: 'hero',
                        label: 'Hero',
                        content: `<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
                            <div class="container mx-auto text-center">
                                <h1 class="text-5xl font-bold mb-4">Tu Título Aquí</h1>
                                <p class="text-xl mb-8">Descripción de tu producto o servicio</p>
                                <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Call to Action</button>
                            </div>
                        </section>`,
                    },
                    {
                        id: 'features',
                        label: 'Características',
                        content: `<section class="py-16 bg-white">
                            <div class="container mx-auto px-4">
                                <h2 class="text-3xl font-bold text-center mb-12">Nuestras Características</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold mb-2">Rápido</h3>
                                        <p class="text-gray-600">Descripción de la característica</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold mb-2">Confiable</h3>
                                        <p class="text-gray-600">Descripción de la característica</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold mb-2">Fácil</h3>
                                        <p class="text-gray-600">Descripción de la característica</p>
                                    </div>
                                </div>
                            </div>
                        </section>`,
                    },
                    // Nuevos bloques multimedia
                    {
                        id: 'video',
                        label: 'Video',
                        attributes: {
                            class: 'gjs-block-video'
                        },
                        content: `<div class="video-container mb-8">
                            <video controls class="w-full rounded-lg shadow-lg">
                                <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                                Tu navegador no soporta video HTML5.
                            </video>
                        </div>`,
                    },
                    {
                        id: 'youtube',
                        label: 'YouTube',
                        attributes: {
                            class: 'gjs-block-video'
                        },
                        content: `<div class="youtube-container mb-8">
                            <div class="relative pb-9/16 h-0 overflow-hidden">
                                <iframe class="absolute top-0 left-0 w-full h-full rounded-lg" 
                                        src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                                        frameborder="0" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>`,
                    },
                    {
                        id: 'gallery',
                        label: 'Galería',
                        attributes: {
                            class: 'gjs-block-gallery'
                        },
                        content: `<section class="gallery py-16">
                            <div class="container mx-auto px-4">
                                <h2 class="text-3xl font-bold text-center mb-12">Galería de Imágenes</h2>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <img src="https://via.placeholder.com/300x300" alt="Imagen 1" class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform">
                                    <img src="https://via.placeholder.com/300x300" alt="Imagen 2" class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform">
                                    <img src="https://via.placeholder.com/300x300" alt="Imagen 3" class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform">
                                    <img src="https://via.placeholder.com/300x300" alt="Imagen 4" class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform">
                                </div>
                            </div>
                        </section>`,
                    },
                    // Bloques de formulario
                    {
                        id: 'form-contact',
                        label: 'Formulario de Contacto',
                        attributes: {
                            class: 'gjs-block-form'
                        },
                        content: `<section class="contact-form py-16 bg-gray-50">
                            <div class="container mx-auto px-4 max-w-2xl">
                                <h2 class="text-3xl font-bold text-center mb-8">Contáctanos</h2>
                                <form class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <input type="text" placeholder="Nombre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <input type="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <input type="text" placeholder="Asunto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <textarea placeholder="Mensaje" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">Enviar Mensaje</button>
                                </form>
                            </div>
                        </section>`,
                    },
                    {
                        id: 'newsletter',
                        label: 'Newsletter',
                        attributes: {
                            class: 'gjs-block-newsletter'
                        },
                        content: `<section class="newsletter bg-blue-600 text-white py-16">
                            <div class="container mx-auto px-4 text-center">
                                <h2 class="text-3xl font-bold mb-4">Suscríbete a nuestro Newsletter</h2>
                                <p class="text-blue-100 mb-8 max-w-2xl mx-auto">Recibe las últimas noticias y actualizaciones directamente en tu bandeja de entrada.</p>
                                <form class="flex flex-col md:flex-row gap-4 max-w-md mx-auto">
                                    <input type="email" placeholder="Tu email" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                                    <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Suscribirse</button>
                                </form>
                            </div>
                        </section>`,
                    },
                    // Bloques de testimonios
                    {
                        id: 'testimonials',
                        label: 'Testimonios',
                        attributes: {
                            class: 'gjs-block-testimonial'
                        },
                        content: `<section class="testimonials py-16 bg-gray-50">
                            <div class="container mx-auto px-4">
                                <h2 class="text-3xl font-bold text-center mb-12">Lo que dicen nuestros clientes</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="bg-white p-6 rounded-lg shadow-lg">
                                        <div class="flex items-center mb-4">
                                            <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 rounded-full mr-4">
                                            <div>
                                                <h4 class="font-semibold">María García</h4>
                                                <p class="text-sm text-gray-600">CEO, Empresa XYZ</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">"Excelente servicio, muy recomendable. La atención al cliente es excepcional."</p>
                                        <div class="flex text-yellow-400 mt-4">
                                            ★★★★★
                                        </div>
                                    </div>
                                    <div class="bg-white p-6 rounded-lg shadow-lg">
                                        <div class="flex items-center mb-4">
                                            <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 rounded-full mr-4">
                                            <div>
                                                <h4 class="font-semibold">Juan Pérez</h4>
                                                <p class="text-sm text-gray-600">Director, ABC Corp</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">"Los resultados superaron nuestras expectativas. Muy profesionales."</p>
                                        <div class="flex text-yellow-400 mt-4">
                                            ★★★★★
                                        </div>
                                    </div>
                                    <div class="bg-white p-6 rounded-lg shadow-lg">
                                        <div class="flex items-center mb-4">
                                            <img src="https://via.placeholder.com/60x60" alt="Cliente" class="w-12 h-12 rounded-full mr-4">
                                            <div>
                                                <h4 class="font-semibold">Ana López</h4>
                                                <p class="text-sm text-gray-600">Fundadora, StartupABC</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">"Una experiencia increíble. Sin duda volveríamos a trabajar con ellos."</p>
                                        <div class="flex text-yellow-400 mt-4">
                                            ★★★★★
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>`,
                    },
                    // Bloques de pricing
                    {
                        id: 'pricing',
                        label: 'Precios',
                        attributes: {
                            class: 'gjs-block-pricing'
                        },
                        content: `<section class="pricing py-16">
                            <div class="container mx-auto px-4">
                                <h2 class="text-3xl font-bold text-center mb-12">Planes y Precios</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="bg-white p-8 rounded-lg shadow-lg border-2 border-gray-200">
                                        <h3 class="text-xl font-bold mb-4">Básico</h3>
                                        <div class="text-4xl font-bold text-blue-600 mb-6">$19<span class="text-lg text-gray-600">/mes</span></div>
                                        <ul class="space-y-3 mb-8">
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Hasta 5 páginas</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte básico</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> SSL incluido</li>
                                        </ul>
                                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">Elegir Plan</button>
                                    </div>
                                    <div class="bg-white p-8 rounded-lg shadow-lg border-2 border-blue-500 relative">
                                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-4 py-1 rounded-full text-sm">Más Popular</div>
                                        <h3 class="text-xl font-bold mb-4">Pro</h3>
                                        <div class="text-4xl font-bold text-blue-600 mb-6">$49<span class="text-lg text-gray-600">/mes</span></div>
                                        <ul class="space-y-3 mb-8">
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Páginas ilimitadas</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte prioritario</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> SSL incluido</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Analytics avanzados</li>
                                        </ul>
                                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">Elegir Plan</button>
                                    </div>
                                    <div class="bg-white p-8 rounded-lg shadow-lg border-2 border-gray-200">
                                        <h3 class="text-xl font-bold mb-4">Enterprise</h3>
                                        <div class="text-4xl font-bold text-blue-600 mb-6">$99<span class="text-lg text-gray-600">/mes</span></div>
                                        <ul class="space-y-3 mb-8">
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Todo incluido</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte 24/7</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Dominio personalizado</li>
                                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Integración API</li>
                                        </ul>
                                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">Elegir Plan</button>
                                    </div>
                                </div>
                            </div>
                        </section>`,
                    },
                    // Bloques de navegación y utilidad
                    {
                        id: 'breadcrumbs',
                        label: 'Migas de pan',
                        content: `<nav class="breadcrumbs py-4 text-sm">
                            <div class="container mx-auto px-4">
                                <a href="#" class="text-blue-600 hover:text-blue-800">Inicio</a>
                                <span class="mx-2 text-gray-500">/</span>
                                <a href="#" class="text-blue-600 hover:text-blue-800">Categoría</a>
                                <span class="mx-2 text-gray-500">/</span>
                                <span class="text-gray-700">Página actual</span>
                            </div>
                        </nav>`,
                    },
                    {
                        id: 'tabs',
                        label: 'Pestañas',
                        content: `<div class="tabs-container py-8">
                            <div class="container mx-auto px-4">
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8">
                                        <button class="py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">Pestaña 1</button>
                                        <button class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">Pestaña 2</button>
                                        <button class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">Pestaña 3</button>
                                    </nav>
                                </div>
                                <div class="mt-6">
                                    <div class="tab-content">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contenido de la Pestaña 1</h3>
                                        <p class="text-gray-600">Este es el contenido de la primera pestaña. Puedes agregar cualquier contenido aquí.</p>
                                    </div>
                                </div>
                            </div>
                        </div>`,
                    },
                    {
                        id: 'accordion',
                        label: 'Acordeón',
                        content: `<div class="accordion py-8">
                            <div class="container mx-auto px-4 max-w-4xl">
                                <h2 class="text-3xl font-bold text-center mb-8">Preguntas Frecuentes</h2>
                                <div class="space-y-4">
                                    <div class="border border-gray-200 rounded-lg">
                                        <button class="w-full px-6 py-4 text-left font-medium flex justify-between items-center">
                                            <span>¿Cómo funciona el servicio?</span>
                                            <span>+</span>
                                        </button>
                                        <div class="px-6 pb-4 text-gray-600">
                                            Nuestro servicio es muy fácil de usar. Solo necesitas registrarte y seguir los pasos del tutorial.
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg">
                                        <button class="w-full px-6 py-4 text-left font-medium flex justify-between items-center">
                                            <span>¿Qué métodos de pago aceptan?</span>
                                            <span>+</span>
                                        </button>
                                        <div class="px-6 pb-4 text-gray-600 hidden">
                                            Aceptamos tarjetas de crédito, débito, PayPal y transferencias bancarias.
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg">
                                        <button class="w-full px-6 py-4 text-left font-medium flex justify-between items-center">
                                            <span>¿Puedo cancelar mi suscripción?</span>
                                            <span>+</span>
                                        </button>
                                        <div class="px-6 pb-4 text-gray-600 hidden">
                                            Sí, puedes cancelar tu suscripción en cualquier momento desde tu panel de control.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`,
                    },
                    // Bloques de redes sociales
                    {
                        id: 'social-links',
                        label: 'Redes Sociales',
                        attributes: {
                            class: 'gjs-block-social'
                        },
                        content: `<div class="social-links py-8 text-center">
                            <h3 class="text-xl font-semibold mb-6">Síguenos en nuestras redes</h3>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white hover:bg-blue-900 transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012 0z.001"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>`,
                    },
                    // Bloque de mapa
                    {
                        id: 'map',
                        label: 'Mapa',
                        attributes: {
                            class: 'gjs-block-map'
                        },
                        content: `<section class="map py-16">
                            <div class="container mx-auto px-4">
                                <h2 class="text-3xl font-bold text-center mb-8">Nuestra Ubicación</h2>
                                <div class="bg-gray-200 h-96 rounded-lg flex items-center justify-center">
                                    <div class="text-center text-gray-600">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Mapa Interactivo</p>
                                        <p class="text-sm">Integra Google Maps o cualquier otro servicio de mapas</p>
                                    </div>
                                </div>
                                <div class="mt-8 text-center">
                                    <p class="text-gray-600">📍 Calle Principal 123, Ciudad, País</p>
                                    <p class="text-gray-600">📞 +1 234 567 8900</p>
                                    <p class="text-gray-600">✉️ contacto@empresa.com</p>
                                </div>
                            </div>
                        </section>`,
                    },
                    // Bloque de estadísticas/contadores
                    {
                        id: 'stats',
                        label: 'Estadísticas',
                        content: `<section class="stats py-16 bg-blue-600 text-white">
                            <div class="container mx-auto px-4">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                                    <div>
                                        <div class="text-4xl font-bold mb-2">1000+</div>
                                        <div class="text-blue-100">Clientes Satisfechos</div>
                                    </div>
                                    <div>
                                        <div class="text-4xl font-bold mb-2">50+</div>
                                        <div class="text-blue-100">Proyectos Completados</div>
                                    </div>
                                    <div>
                                        <div class="text-4xl font-bold mb-2">24/7</div>
                                        <div class="text-blue-100">Soporte Técnico</div>
                                    </div>
                                    <div>
                                        <div class="text-4xl font-bold mb-2">99%</div>
                                        <div class="text-blue-100">Satisfacción</div>
                                    </div>
                                </div>
                            </div>
                        </section>`,
                    }
                ]
            },
            layerManager: {
                appendTo: '.layers-container'
            },
            traitManager: {
                appendTo: '.traits-container',
            },
            selectorManager: {
                appendTo: '.styles-container'
            },
        });

        // Cargar contenido existente
        @if($page - > html_content)
        editor.setComponents('{!! addslashes($page->html_content) !!}');
        @endif

        @if($page - > css_content)
        editor.setStyle('{!! addslashes($page->css_content) !!}');
        @endif

        // Guardar contenido
        document.getElementById('save-btn').addEventListener('click', function() {
            const htmlContent = editor.getHtml();
            const cssContent = editor.getCss();
            const grapesjsData = JSON.stringify(editor.getProjectData());

            fetch('{{ route("creator.pages.save", [$website, $page]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        html_content: htmlContent,
                        css_content: cssContent,
                        grapesjs_data: grapesjsData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        const btn = document.getElementById('save-btn');
                        const originalText = btn.textContent;
                        btn.textContent = 'Guardado!';
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        btn.classList.add('bg-green-600');

                        setTimeout(() => {
                            btn.textContent = originalText;
                            btn.classList.remove('bg-green-600');
                            btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar la página');
                });
        });

        // Auto-guardado cada 30 segundos
        setInterval(function() {
            const htmlContent = editor.getHtml();
            const cssContent = editor.getCss();
            const grapesjsData = JSON.stringify(editor.getProjectData());

            fetch('{{ route("creator.pages.save", [$website, $page]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    html_content: htmlContent,
                    css_content: cssContent,
                    grapesjs_data: grapesjsData
                })
            });
        }, 30000);

        // Funcionalidad de paneles laterales
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const panel = this.dataset.panel;

                // Actualizar tabs activos
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });

                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');

                // Mostrar panel correspondiente
                document.querySelectorAll('.panel-content').forEach(panel => {
                    panel.classList.add('hidden');
                });

                document.getElementById(panel + '-panel').classList.remove('hidden');
            });
        });

        // Funcionalidad de dispositivos responsive
        document.querySelectorAll('.device-btn').forEach(button => {
            button.addEventListener('click', function() {
                const device = this.dataset.device;

                // Actualizar botones activos
                document.querySelectorAll('.device-btn').forEach(btn => {
                    btn.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                    btn.classList.add('text-gray-600');
                });

                this.classList.add('active', 'bg-blue-100', 'text-blue-700');
                this.classList.remove('text-gray-600');

                // Cambiar dispositivo en GrapesJS
                const deviceManager = editor.DeviceManager;
                if (device === 'desktop') {
                    deviceManager.set('Desktop');
                } else if (device === 'tablet') {
                    deviceManager.set('Tablet');
                } else if (device === 'mobile') {
                    deviceManager.set('Mobile portrait');
                }
            });
        });

        // Atajos de teclado
        document.addEventListener('keydown', function(e) {
            // Ctrl+S para guardar
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('save-btn').click();
            }

            // Ctrl+Z para deshacer
            if (e.ctrlKey && e.key === 'z' && !e.shiftKey) {
                e.preventDefault();
                editor.UndoManager.undo();
            }

            // Ctrl+Shift+Z para rehacer
            if (e.ctrlKey && e.shiftKey && e.key === 'Z') {
                e.preventDefault();
                editor.UndoManager.redo();
            }

            // Delete para eliminar componente seleccionado
            if (e.key === 'Delete' || e.key === 'Backspace') {
                const selected = editor.getSelected();
                if (selected && selected.get('removable')) {
                    selected.remove();
                }
            }
        });

        // Funciones de utilidad
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Eventos personalizados del editor
        editor.on('component:add', (component) => {
            console.log('Componente agregado:', component.get('type'));
        });

        editor.on('component:remove', (component) => {
            console.log('Componente eliminado:', component.get('type'));
        });

        editor.on('component:selected', (component) => {
            console.log('Componente seleccionado:', component.get('type'));
        });

        // Mejoras de UI - mostrar loading mientras se guarda
        const originalSaveBtn = document.getElementById('save-btn');

        function showSaveLoading() {
            originalSaveBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Guardando...
            `;
            originalSaveBtn.disabled = true;
        }

        function hideSaveLoading() {
            originalSaveBtn.innerHTML = 'Guardar';
            originalSaveBtn.disabled = false;
        }

        // Aplicar mejoras al botón de guardar
        originalSaveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showSaveLoading();

            const htmlContent = editor.getHtml();
            const cssContent = editor.getCss();
            const grapesjsData = JSON.stringify(editor.getProjectData());

            fetch('{{ route("creator.pages.save", [$website, $page]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        html_content: htmlContent,
                        css_content: cssContent,
                        grapesjs_data: grapesjsData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    hideSaveLoading();
                    if (data.success) {
                        showNotification('Página guardada exitosamente');
                    } else {
                        showNotification('Error al guardar la página', 'error');
                    }
                })
                .catch(error => {
                    hideSaveLoading();
                    console.error('Error:', error);
                    showNotification('Error al guardar la página', 'error');
                });
        });

        console.log('Editor GrapesJS mejorado inicializado correctamente');
    </script>
</body>

</html>