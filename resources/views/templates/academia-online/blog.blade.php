<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Academia Online</title>
    <meta name="description" content="Artículos, consejos y recursos para tu aprendizaje. Mantente actualizado con las últimas tendencias.">
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
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
                <p class="text-xl text-gray-600 mb-8">Artículos y Recursos</p>
                <p class="text-lg text-gray-500 max-w-3xl mx-auto">
                    Mantente actualizado con las últimas tendencias en educación y desarrollo profesional
                </p>
            </div>
        </div>
    </div>

    <!-- Blog Posts Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Post 1 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Programación</span>
                        <span class="mx-2">•</span>
                        <time>15 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Las 10 Mejores Prácticas para Programadores
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Descubre las mejores prácticas que todo programador debería conocer para escribir código limpio y eficiente.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">María García</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>

            <!-- Post 2 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-green-500 to-teal-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Diseño</span>
                        <span class="mx-2">•</span>
                        <time>12 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Introducción al Diseño UX/UI
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Aprende los fundamentos del diseño de experiencia de usuario y cómo crear interfaces atractivas.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">Carlos López</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-purple-500 to-pink-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">Marketing</span>
                        <span class="mx-2">•</span>
                        <time>10 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Estrategias de Marketing Digital 2024
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Las tendencias más importantes en marketing digital para este año y cómo aplicarlas en tu negocio.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">Ana Martínez</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>

            <!-- Post 4 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-orange-500 to-red-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">Negocios</span>
                        <span class="mx-2">•</span>
                        <time>8 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Cómo Empezar tu Propio Negocio Online
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Guía paso a paso para crear y lanzar tu negocio online desde cero.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">Roberto Silva</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>

            <!-- Post 5 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-indigo-500 to-blue-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs font-medium">Idiomas</span>
                        <span class="mx-2">•</span>
                        <time>5 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Técnicas Efectivas para Aprender Inglés
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Métodos probados para mejorar tu nivel de inglés de forma rápida y eficiente.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">Sarah Johnson</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>

            <!-- Post 6 -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-r from-teal-500 to-cyan-600"></div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span class="bg-teal-100 text-teal-800 px-2 py-1 rounded-full text-xs font-medium">Carrera</span>
                        <span class="mx-2">•</span>
                        <time>3 Enero 2024</time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            Cómo Preparar tu CV para el 2024
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Consejos actualizados para crear un currículum que destaque en el mercado laboral actual.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-600">Laura Fernández</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Leer más →</a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Cargar Más Artículos
            </button>
        </div>
    </div>
</div>
@include('templates.academia-online.footer')
</body>
</html>
