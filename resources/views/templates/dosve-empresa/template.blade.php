<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $website->name ?? 'Dosve' }} - Desarrollamos sistemas que impulsan tu negocio</title>
    <meta name="description" content="Soluciones tecnológicas a la medida de tu empresa. Más de 10 años desarrollando software empresarial.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Roboto:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .font-heading {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    @if(!empty($website->logo))
                    <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name ?? 'DOSVE' }}" class="object-cover w-16 h-16 rounded-full">
                    @else
                    <img src="{{ asset('images/logo.jpeg') }}" alt="{{ $website->name ?? 'DOSVE' }}" class="object-cover w-16 h-16 rounded-full">
                    @endif
                </div>

                <!-- Navigation -->
                <nav class="items-center hidden space-x-8 md:flex">
                    <a href="#inicio" class="font-medium text-gray-600 hover:text-blue-600">Inicio</a>
                    <a href="#servicios" class="font-medium text-gray-600 hover:text-blue-600">Servicios</a>
                    <a href="#proyectos" class="font-medium text-gray-600 hover:text-blue-600">Proyectos</a>
                    <a href="#contacto" class="font-medium text-gray-600 hover:text-blue-600">Contacto</a>
                </nav>

                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="https://wa.me/573245229046" target="_blank" class="px-6 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="py-20 bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <h1 class="mb-6 text-4xl font-bold text-gray-900 md:text-5xl lg:text-6xl font-heading">
                        Desarrollamos sistemas que impulsan tu negocio
                    </h1>
                    <p class="mb-8 text-xl text-gray-600">
                        Soluciones tecnológicas a la medida de tu empresa
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="#servicios" class="px-8 py-4 font-medium text-center text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Conoce Nuestros Servicios
                        </a>
                        <a href="#proyectos" class="px-8 py-4 font-medium text-center text-blue-600 transition-colors border-2 border-blue-600 rounded-lg hover:bg-blue-50">
                            Ver Proyectos
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="p-8 bg-white shadow-2xl rounded-2xl">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-blue-100 rounded-full">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mb-4 text-2xl font-bold text-gray-900 font-heading">Más de 10 años</h3>
                            <p class="mb-6 text-gray-600">Desarrollando soluciones digitales para empresas e instituciones de la región y del país</p>
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
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">Sobre Nosotros</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
            </div>
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <h3 class="mb-6 text-2xl font-bold text-gray-900 font-heading">Nuestra Historia</h3>
                    <p class="mb-6 text-gray-600">
                        Dosve es una empresa de desarrollo de software con 10 años de experiencia, especializada en crear soluciones tecnológicas personalizadas que optimizan los procesos empresariales y potencian la productividad de nuestros clientes.
                    </p>
                    <p class="mb-8 text-gray-600">
                        Nacimos en 2015 en Acacías, Meta, y hoy contamos también con presencia en Bogotá, desde donde ampliamos nuestro alcance para atender proyectos a nivel nacional. Nuestro objetivo es ofrecer herramientas digitales accesibles, seguras y adaptadas a las necesidades de cada negocio.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="mb-2 text-3xl font-bold text-blue-600">10+</div>
                            <div class="text-gray-600">Años de experiencia</div>
                        </div>
                        <div class="text-center">
                            <div class="mb-2 text-3xl font-bold text-blue-600">50+</div>
                            <div class="text-gray-600">Proyectos completados</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-6 rounded-lg bg-blue-50">
                        <h4 class="mb-3 font-bold text-gray-900">Misión</h4>
                        <p class="text-sm text-gray-600">Diseñar y desarrollar sistemas inteligentes que ayuden a las empresas a automatizar, controlar y escalar sus operaciones.</p>
                    </div>
                    <div class="p-6 rounded-lg bg-blue-50">
                        <h4 class="mb-3 font-bold text-gray-900">Visión</h4>
                        <p class="text-sm text-gray-600">Ser una empresa líder en desarrollo de software empresarial en Colombia, reconocida por la innovación y calidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-20 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">Nuestros Servicios</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
                <p class="text-xl text-gray-600">Soluciones tecnológicas integrales para tu empresa</p>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-8 text-center transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Desarrollo de Software a Medida</h3>
                    <p class="text-gray-600">Plataformas accesibles, seguras y optimizadas para cualquier dispositivo.</p>
                </div>
                <div class="p-8 text-center transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Aplicaciones Web</h3>
                    <p class="text-gray-600">Soluciones personalizadas según las necesidades de tu empresa.</p>
                </div>
                <div class="p-8 text-center transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Sistemas Empresariales</h3>
                    <p class="text-gray-600">Gestión completa de ventas, inventarios, contabilidad y clientes.</p>
                </div>
                <div class="p-8 text-center transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Aplicaciones Móviles</h3>
                    <p class="text-gray-600">Desarrollo para Android y iOS con conexión a sistemas empresariales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="py-20 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">Tecnologías que Usamos</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
            </div>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-8">
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" alt="React" class="w-8 h-8" style="filter: brightness(0) saturate(100%) invert(27%) sepia(96%) saturate(1352%) hue-rotate(210deg) brightness(92%) contrast(92%);" />
                    </div>
                    <p class="text-sm font-medium text-gray-900">React</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" class="w-8 h-8">
                            <path fill="rgb(37, 99, 235)" d="M31.963 9.12c-.008-.03-.023-.056-.034-.085a1 1 0 0 0-.07-.156a2 2 0 0 0-.162-.205a1 1 0 0 0-.088-.072a1 1 0 0 0-.083-.068l-.044-.02l-.035-.024l-6-3a1 1 0 0 0-.894 0l-6 3l-.035.024l-.044.02a1 1 0 0 0-.083.068a.7.7 0 0 0-.187.191a1 1 0 0 0-.064.086a1 1 0 0 0-.069.156c-.01.029-.026.055-.034.085a1 1 0 0 0-.037.265v5.382l-4 2V5.385a1 1 0 0 0-.037-.265c-.008-.03-.023-.056-.034-.085a1 1 0 0 0-.07-.156a1 1 0 0 0-.063-.086a.7.7 0 0 0-.187-.191a1 1 0 0 0-.083-.068l-.044-.02l-.035-.024l-6-3a1 1 0 0 0-.894 0l-6 3l-.035.024l-.044.02a1 1 0 0 0-.083.068a1 1 0 0 0-.088.072a1 1 0 0 0-.1.119a1 1 0 0 0-.063.086a1 1 0 0 0-.069.156c-.01.029-.026.055-.034.085A1 1 0 0 0 0 5.385v19a1 1 0 0 0 .553.894l6 3l6 3c.014.007.03.005.046.011a.9.9 0 0 0 .802 0c.015-.006.032-.004.046-.01l12-6a1 1 0 0 0 .553-.895v-5.382l5.447-2.724a1 1 0 0 0 .553-.894v-6a1 1 0 0 0-.037-.265M9.236 21.385l4.211-2.106h.001L19 16.503l3.764 1.882L13 23.267ZM24 13.003v3.764l-4-2v-3.764Zm1-5.5l3.764 1.882L25 11.267l-3.764-1.882ZM8 19.767V9.003l4-2v10.764ZM7 3.503l3.764 1.882L7 7.267L3.236 5.385Zm-5 3.5l4 2v16.764l-4-2Zm6 16l4 2v3.764l-4-2Zm16 .764l-10 5v-3.764l10-5Zm6-9l-4 2v-3.764l4-2Z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Laravel</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 448 512" class="w-8 h-8">
                            <path fill="rgb(37, 99, 235)" d="M224.5 508c-6.7 0-13.5-1.8-19.4-5.2l-61.7-36.5c-9.2-5.2-4.7-7-1.7-8c12.3-4.3 14.8-5.2 27.9-12.7c1.4-.8 3.2-.5 4.6.4l47.4 28.1c1.7 1 4.1 1 5.7 0L412 367.5c1.7-1 2.8-3 2.8-5V149.3c0-2.1-1.1-4-2.9-5.1L227.3 37.7c-1.7-1-4-1-5.7 0L37.1 144.3c-1.8 1-2.9 3-2.9 5.1v213.1c0 2 1.1 4 2.9 4.9l50.6 29.2c27.5 13.7 44.3-2.4 44.3-18.7V167.5c0-3 2.4-5.3 5.4-5.3h23.4c2.9 0 5.4 2.3 5.4 5.3V378c0 36.6-20 57.6-54.7 57.6c-10.7 0-19.1 0-42.5-11.6l-48.4-27.9c-12-6.9-19.4-19.8-19.4-33.7V149.3c0-13.8 7.4-26.8 19.4-33.7L205.1 9c11.7-6.6 27.2-6.6 38.8 0l184.7 106.7c12 6.9 19.4 19.8 19.4 33.7v213.1c0 13.8-7.4 26.7-19.4 33.7L243.9 502.8c-5.9 3.4-12.6 5.2-19.4 5.2m149.1-210.1c0-39.9-27-50.5-83.7-58c-57.4-7.6-63.2-11.5-63.2-24.9c0-11.1 4.9-25.9 47.4-25.9c37.9 0 51.9 8.2 57.7 33.8c.5 2.4 2.7 4.2 5.2 4.2h24c1.5 0 2.9-.6 3.9-1.7s1.5-2.6 1.4-4.1c-3.7-44.1-33-64.6-92.2-64.6c-52.7 0-84.1 22.2-84.1 59.5c0 40.4 31.3 51.6 81.8 56.6c60.5 5.9 65.2 14.8 65.2 26.7c0 20.6-16.6 29.4-55.5 29.4c-48.9 0-59.6-12.3-63.2-36.6c-.4-2.6-2.6-4.5-5.3-4.5h-23.9c-3 0-5.3 2.4-5.3 5.3c0 31.1 16.9 68.2 97.8 68.2c58.4-.1 92-23.2 92-63.4" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Node.js</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" class="w-8 h-8">
                            <g fill="none" stroke="rgb(37, 99, 235)" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4.5 11a1.5 1.5 0 0 0 3 0V7.5m5 1.25c0-.69-.537-1.25-1.2-1.25h-.6c-.663 0-1.2.56-1.2 1.25S10.037 10 10.7 10h.6c.663 0 1.2.56 1.2 1.25s-.537 1.25-1.2 1.25h-.6c-.663 0-1.2-.56-1.2-1.25" />
                                <path d="M4 1.5h8c1.385 0 2.5 1.115 2.5 2.5v8c0 1.385-1.115 2.5-2.5 2.5H4A2.495 2.495 0 0 1 1.5 12V4c0-1.385 1.115-2.5 2.5-2.5" />
                            </g>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">JavaScript</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL" class="w-8 h-8" style="filter: brightness(0) saturate(100%) invert(27%) sepia(96%) saturate(1352%) hue-rotate(210deg) brightness(92%) contrast(92%);" />
                    </div>
                    <p class="text-sm font-medium text-gray-900">MySQL</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/googlecloud/googlecloud-original.svg" alt="Google Cloud" class="w-8 h-8" style="filter: brightness(0) saturate(100%) invert(27%) sepia(96%) saturate(1352%) hue-rotate(210deg) brightness(92%) contrast(92%);" />
                    </div>
                    <p class="text-sm font-medium text-gray-900">Google Cloud</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="GitHub" class="w-8 h-8" style="filter: brightness(0) saturate(100%) invert(27%) sepia(96%) saturate(1352%) hue-rotate(210deg) brightness(92%) contrast(92%);" />
                    </div>
                    <p class="text-sm font-medium text-gray-900">GitHub</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 25" class="w-8 h-8">
                            <path fill="rgb(37, 99, 235)" d="M20.557 10.634a5.07 5.07 0 0 0-.42-4.099c-1.087-1.901-3.284-2.864-5.432-2.42c-.939-1.061-2.321-1.654-3.754-1.654a5.07 5.07 0 0 0-4.814 3.481a5 5 0 0 0-3.334 2.42a5.07 5.07 0 0 0 .618 5.901a5.06 5.06 0 0 0 .444 4.1a5.025 5.025 0 0 0 5.432 2.419a5.07 5.07 0 0 0 3.753 1.679a5.07 5.07 0 0 0 4.815-3.481a5 5 0 0 0 3.333-2.42a5.07 5.07 0 0 0-.642-5.926M13.05 21.152a3.66 3.66 0 0 1-2.395-.864c.025-.025.099-.05.124-.074l3.975-2.296a.65.65 0 0 0 .321-.568v-5.605l1.679.963c.025 0 .025.024.025.05v4.641a3.716 3.716 0 0 1-3.729 3.753M5 17.72c-.444-.765-.592-1.654-.444-2.518c.025.024.075.05.124.074l3.975 2.296a.6.6 0 0 0 .642 0l4.864-2.815v1.95c0 .026 0 .05-.024.05l-4.025 2.321c-1.778 1.037-4.074.42-5.111-1.358M3.965 9.03a3.88 3.88 0 0 1 1.95-1.654v4.74c0 .223.124.445.321.568l4.865 2.815l-1.68.963c-.024 0-.049.025-.049 0L5.347 14.14a3.714 3.714 0 0 1-1.383-5.111m13.827 3.21l-4.864-2.815l1.679-.963c.024 0 .05-.025.05 0l4.024 2.32a3.727 3.727 0 0 1 1.358 5.112a3.72 3.72 0 0 1-1.95 1.63v-4.716a.61.61 0 0 0-.297-.568m1.654-2.519a.5.5 0 0 0-.123-.074L15.347 7.35a.6.6 0 0 0-.642 0L9.84 10.165V8.214c0-.025 0-.05.025-.05l4.025-2.32A3.73 3.73 0 0 1 19 7.226c.445.741.593 1.63.445 2.494M8.927 13.177l-1.68-.963c-.024 0-.024-.025-.024-.05v-4.64a3.75 3.75 0 0 1 3.753-3.753a3.66 3.66 0 0 1 2.395.864a.5.5 0 0 1-.123.074L9.273 7.004a.65.65 0 0 0-.321.568v5.605zm.913-1.975l2.173-1.26l2.173 1.26v2.493l-2.173 1.26l-2.173-1.26z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">OpenAI</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="proyectos" class="py-20 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">Nuestros Proyectos</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
                <p class="text-xl text-gray-600">Conoce nuestros últimos proyectos</p>
            </div>
            <div class="grid gap-8 md:grid-cols-2">
                <a href="https://play.google.com/store/apps/details?id=com.dosve.segundos&hl=es_CO" target="_blank" rel="noopener noreferrer" class="overflow-hidden transition-all bg-white rounded-lg shadow-lg cursor-pointer hover:shadow-xl hover:scale-105">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-16 h-16 mr-4 bg-blue-600 rounded-full">
                                <span class="text-xl font-bold text-white">1</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Segundos App</h3>
                        </div>
                        <p class="mb-6 text-gray-600">
                            Solución móvil integral de entrega y servicios, conectando usuarios con proveedores locales.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">React Native</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Node.js</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">MongoDB</span>
                        </div>
                    </div>
                </a>
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-16 h-16 mr-4 bg-blue-600 rounded-full">
                                <span class="text-xl font-bold text-white">2</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Yo Compro Acacías</h3>
                        </div>
                        <p class="mb-6 text-gray-600">
                            Plataforma oficial municipal para visibilizar negocios locales y fortalecer la economía local.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Laravel</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Vue.js</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">MySQL</span>
                        </div>
                    </div>
                </div>
                <a href="https://adminnegocios.com/" target="_blank" rel="noopener noreferrer" class="overflow-hidden transition-all bg-white rounded-lg shadow-lg cursor-pointer hover:shadow-xl hover:scale-105">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-16 h-16 mr-4 bg-blue-600 rounded-full">
                                <span class="text-xl font-bold text-white">3</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">Admin Negocios</h3>
                        </div>
                        <p class="mb-6 text-gray-600">
                            Sistema integral de gestión empresarial para manejar compras, ventas, inventarios y más.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Laravel</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">React</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">PostgreSQL</span>
                        </div>
                    </div>
                </a>
                <a href="https://eme10.com/" target="_blank" rel="noopener noreferrer" class="overflow-hidden transition-all bg-white rounded-lg shadow-lg cursor-pointer hover:shadow-xl hover:scale-105">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-16 h-16 mr-4 bg-blue-600 rounded-full">
                                <span class="text-xl font-bold text-white">4</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-heading">EME10</h3>
                        </div>
                        <p class="mb-6 text-gray-600">
                            Suite empresarial que optimiza gestión, comunicación y automatización con IA.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Laravel</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">Vue.js</span>
                            <span class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">AI/ML</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">Nuestros Valores</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Compromiso</h3>
                    <p class="text-gray-600">Priorizamos la comunicación y transparencia con cada cliente.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Confianza</h3>
                    <p class="text-gray-600">Cumplimos cada proyecto con responsabilidad y excelencia.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Innovación</h3>
                    <p class="text-gray-600">Incorporamos tecnologías modernas para ofrecer soluciones escalables.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Aprendizaje continuo</h3>
                    <p class="text-gray-600">Evolucionamos constantemente con las nuevas tendencias tecnológicas.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Eficiencia</h3>
                    <p class="text-gray-600">Optimizamos recursos y tiempos para maximizar resultados.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl font-heading">¿Por qué Elegirnos?</h2>
                <div class="w-24 h-1 mx-auto mb-8 bg-blue-600"></div>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Más de 10 años de experiencia</h3>
                    <p class="text-gray-600">Una trayectoria sólida desarrollando soluciones tecnológicas a nivel nacional.</p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Empresa legalmente constituida</h3>
                    <p class="text-gray-600">Operamos bajo los lineamientos legales, ofreciendo confianza y respaldo.</p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Cumplimiento y responsabilidad</h3>
                    <p class="text-gray-600">Respetamos los tiempos y acuerdos establecidos en cada proyecto.</p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Soporte permanente</h3>
                    <p class="text-gray-600">Brindamos acompañamiento técnico continuo a todos nuestros clientes.</p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Honestidad y transparencia</h3>
                    <p class="text-gray-600">Nuestras relaciones comerciales se basan en la confianza y la ética.</p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900 font-heading">Tarifas justas y competitivas</h3>
                    <p class="text-gray-600">Ofrecemos precios equilibrados, acordes a la calidad de nuestros desarrollos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contacto" class="py-20 bg-blue-600">
        <div class="px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl font-heading">Estamos listos para trabajar en tu proyecto</h2>
            <p class="max-w-3xl mx-auto mb-8 text-xl text-blue-100">
                Contamos con un equipo de profesionales experimentados y altamente capacitados, dispuesto a iniciar de inmediato el desarrollo de tu proyecto.
            </p>
            <a href="https://wa.me/573245229046" target="_blank" class="inline-block px-8 py-4 font-medium text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">
                Contáctanos
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 text-white bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center mb-6">
                        @if(!empty($website->logo))
                        <img src="{{ asset('storage/' . $website->logo) }}" alt="{{ $website->name ?? 'DOSVE' }}" class="object-cover w-16 h-16 mr-3 rounded-full">
                        @else
                        <img src="{{ asset('images/logo.jpeg') }}" alt="{{ $website->name ?? 'DOSVE' }}" class="object-cover w-16 h-16 mr-3 rounded-full">
                        @endif
                        <h3 class="text-2xl font-bold font-heading">{{ $website->name ?? 'DOSVE' }}</h3>
                    </div>
                    <p class="mb-6 text-gray-400">
                        Desarrollamos sistemas que impulsan tu negocio. Soluciones tecnológicas a la medida de tu empresa.
                    </p>
                </div>
                <div>
                    <h4 class="mb-6 text-lg font-bold font-heading">Servicios</h4>
                    <ul class="space-y-3">
                        <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Desarrollo de Software</a></li>
                        <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Aplicaciones Web</a></li>
                        <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Sistemas Empresariales</a></li>
                        <li><a href="#servicios" class="text-gray-400 transition-colors hover:text-white">Aplicaciones Móviles</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-6 text-lg font-bold font-heading">Proyectos</h4>
                    <ul class="space-y-3">
                        <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Segundos App</a></li>
                        <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Yo Compro Acacías</a></li>
                        <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">Admin Negocios</a></li>
                        <li><a href="#proyectos" class="text-gray-400 transition-colors hover:text-white">EME10</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-6 text-lg font-bold font-heading">Contacto</h4>
                    <div class="space-y-3">
                        <p class="text-gray-400">311 323 03 41</p>
                        <p class="text-gray-400">gerencia@dosve.co</p>
                        <p class="text-gray-400">Carrera 45a #16-05, Bogotá DC</p>
                        <p class="text-gray-400">www.dosve.co</p>
                    </div>
                </div>
            </div>
            <div class="pt-8 mt-12 text-center border-t border-gray-800">
                <p class="text-gray-400">&copy; 2024 Dosve. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>