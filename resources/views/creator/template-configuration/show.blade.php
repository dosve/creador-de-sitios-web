@extends('layouts.creator')

@section('title', 'Configuración de Plantilla')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configuración - {{ ucfirst(str_replace('-', ' ', $templateConfig->template_slug)) }}
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route('creator.template-configuration.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                    <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center" onclick="resetConfig()">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Resetear
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-0">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 m-6 rounded-md flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pestañas de configuración -->
            <div class="bg-gray-50 border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="general">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        General
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="appearance">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                        Apariencia
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="layout">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Diseño
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="content">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Contenido
                    </button>
                </nav>
            </div>

            <!-- Contenido de las pestañas -->
            <div class="p-6">
                <!-- Pestaña General -->
                <div class="tab-content" id="general-content">
                    <form id="generalForm" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Información General
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Sitio</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="site_name" name="site_name" value="{{ $website->name }}" placeholder="Ingresa el nombre de tu sitio">
                                </div>
                                <div>
                                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="site_description" name="site_description" value="{{ $website->description }}" placeholder="Describe tu sitio web">
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email de Contacto</label>
                                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="contact_email" name="contact_email" value="{{ $templateConfig->settings['contact_email'] ?? '' }}" placeholder="contacto@tusitio.com">
                                </div>
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="contact_phone" name="contact_phone" value="{{ $templateConfig->settings['contact_phone'] ?? '' }}" placeholder="+57 300 123 4567">
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Guardar Configuración General
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Pestaña Apariencia -->
                <div class="tab-content hidden" id="appearance-content">
                    <form id="appearanceForm" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Logo del Sitio -->
                                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Logo del Sitio
                                    </h4>
                                    <div class="space-y-4">
                                        <!-- Vista previa del logo actual -->
                                        @if(!empty($website->logo))
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Actual</label>
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ asset('storage/' . $website->logo) }}" alt="Logo actual" class="h-16 border border-gray-200 rounded-lg p-2 bg-white">
                                                <button type="button" onclick="removeLogo()" class="px-3 py-2 text-sm text-red-600 border border-red-300 rounded-md hover:bg-red-50">
                                                    Eliminar Logo
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Subir nuevo logo -->
                                        <div>
                                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ !empty($website->logo) ? 'Cambiar Logo' : 'Subir Logo' }}
                                            </label>
                                            <div class="flex items-center space-x-4">
                                                <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml" 
                                                       class="block w-full text-sm text-gray-500
                                                              file:mr-4 file:py-2 file:px-4
                                                              file:rounded-md file:border-0
                                                              file:text-sm file:font-semibold
                                                              file:bg-blue-50 file:text-blue-700
                                                              hover:file:bg-blue-100
                                                              cursor-pointer">
                                            </div>
                                            <p class="mt-2 text-xs text-gray-500">
                                                Formatos aceptados: PNG, JPG, SVG. Tamaño máximo: 2MB. Recomendado: fondo transparente.
                                            </p>
                                        </div>
                                        
                                        <!-- Preview del logo a subir -->
                                        <div id="logo-preview" class="hidden">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Vista Previa</label>
                                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                <img id="logo-preview-img" src="" alt="Vista previa" class="h-16">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Personalización Visual -->
                                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                        </svg>
                                        Personalización Visual
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 mb-3">Colores</h5>
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">Color Primario</label>
                                                    <div class="flex space-x-2">
                                                        <input type="color" class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer" id="primary_color" name="colors[primary]" value="{{ $templateConfig->customization['colors']['primary'] ?? '#3b82f6' }}">
                                                        <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50" id="primary_color_hex" value="{{ $templateConfig->customization['colors']['primary'] ?? '#3b82f6' }}" readonly>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">Color Secundario</label>
                                                    <div class="flex space-x-2">
                                                        <input type="color" class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer" id="secondary_color" name="colors[secondary]" value="{{ $templateConfig->customization['colors']['secondary'] ?? '#1f2937' }}">
                                                        <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50" id="secondary_color_hex" value="{{ $templateConfig->customization['colors']['secondary'] ?? '#1f2937' }}" readonly>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-2">Color de Acento</label>
                                                    <div class="flex space-x-2">
                                                        <input type="color" class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer" id="accent_color" name="colors[accent]" value="{{ $templateConfig->customization['colors']['accent'] ?? '#10b981' }}">
                                                        <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50" id="accent_color_hex" value="{{ $templateConfig->customization['colors']['accent'] ?? '#10b981' }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 mb-3">Fuentes</h5>
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="heading_font" class="block text-sm font-medium text-gray-700 mb-2">Fuente de Títulos</label>
                                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="heading_font" name="fonts[heading]">
                                                        <option value="Inter, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                                        <option value="Poppins, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                                        <option value="Raleway, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Raleway, sans-serif' ? 'selected' : '' }}>Raleway</option>
                                                        <option value="Montserrat, sans-serif" {{ ($templateConfig->customization['fonts']['heading'] ?? '') == 'Montserrat, sans-serif' ? 'selected' : '' }}>Montserrat</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="body_font" class="block text-sm font-medium text-gray-700 mb-2">Fuente del Cuerpo</label>
                                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="body_font" name="fonts[body]">
                                                        <option value="Inter, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                                        <option value="Open Sans, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                                                        <option value="Nunito, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                                                        <option value="Roboto, sans-serif" {{ ($templateConfig->customization['fonts']['body'] ?? '') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                            </svg>
                                            Guardar Apariencia
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm sticky top-6">
                                    <h5 class="text-md font-medium text-gray-900 mb-4">Vista Previa</h5>
                                    <div id="preview-box" class="p-4 border border-gray-200 rounded-md min-h-[200px]" style="background-color: #ffffff;">
                                        <h6 id="preview-title" class="text-xl font-bold mb-2" style="color: {{ $templateConfig->customization['colors']['primary'] ?? '#3b82f6' }}; font-family: {{ $templateConfig->customization['fonts']['heading'] ?? 'Inter, sans-serif' }};">
                                            Título de Ejemplo
                                        </h6>
                                        <p id="preview-text" class="text-gray-700 mb-3" style="font-family: {{ $templateConfig->customization['fonts']['body'] ?? 'Inter, sans-serif' }};">
                                            Este es un texto de ejemplo para que puedas ver cómo se verá tu sitio con los colores y fuentes seleccionados.
                                        </p>
                                        <button id="preview-button" class="px-4 py-2 text-white rounded-md" style="background-color: {{ $templateConfig->customization['colors']['primary'] ?? '#3b82f6' }};">
                                            Botón de Ejemplo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Pestaña Diseño -->
                <div class="tab-content hidden" id="layout-content">
                    <form id="layoutForm" class="space-y-6">
                        @csrf
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Configuración de Diseño
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="container_width" class="block text-sm font-medium text-gray-700 mb-2">Ancho del Contenedor</label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="container_width" name="layout[container_width]">
                                        <option value="1200px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1200px' ? 'selected' : '' }}>1200px (Estándar)</option>
                                        <option value="1280px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1280px' ? 'selected' : '' }}>1280px (Ancho)</option>
                                        <option value="1000px" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '1000px' ? 'selected' : '' }}>1000px (Estrecho)</option>
                                        <option value="100%" {{ ($templateConfig->customization['layout']['container_width'] ?? '') == '100%' ? 'selected' : '' }}>100% (Completo)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="header_style" class="block text-sm font-medium text-gray-700 mb-2">Estilo del Header</label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="header_style" name="layout[header_style]">
                                        <option value="fixed" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'fixed' ? 'selected' : '' }}>Fijo</option>
                                        <option value="static" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'static' ? 'selected' : '' }}>Estático</option>
                                        <option value="transparent" {{ ($templateConfig->customization['layout']['header_style'] ?? '') == 'transparent' ? 'selected' : '' }}>Transparente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    Guardar Diseño
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Pestaña Contenido -->
                <div class="tab-content hidden" id="content-content">
                    <div class="space-y-6">
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-md flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">La configuración de contenido específico de cada plantilla se puede personalizar desde el editor de páginas.</p>
                        </div>
                        
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                                Redes Sociales
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        Facebook
                                    </label>
                                    <input type="url" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="facebook" name="social_media[facebook]" value="{{ $templateConfig->settings['social_media']['facebook'] ?? '' }}" placeholder="https://facebook.com/tu-pagina">
                                </div>
                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        Twitter
                                    </label>
                                    <input type="url" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="twitter" name="social_media[twitter]" value="{{ $templateConfig->settings['social_media']['twitter'] ?? '' }}" placeholder="https://twitter.com/tu-usuario">
                                </div>
                                <div>
                                    <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                        Instagram
                                    </label>
                                    <input type="url" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="instagram" name="social_media[instagram]" value="{{ $templateConfig->settings['social_media']['instagram'] ?? '' }}" placeholder="https://instagram.com/tu-usuario">
                                </div>
                                <div>
                                    <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        LinkedIn
                                    </label>
                                    <input type="url" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="linkedin" name="social_media[linkedin]" value="{{ $templateConfig->settings['social_media']['linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/tu-perfil">
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center" onclick="saveSocialMedia()">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    Guardar Redes Sociales
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para reset -->
<div id="resetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="mt-2 px-7 py-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Confirmar Reset</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 text-center">
                        ¿Estás seguro de que quieres resetear la configuración de esta plantilla a los valores por defecto?
                    </p>
                    <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-md p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-800">
                                    Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <div class="flex space-x-3">
                    <button id="cancelReset" class="flex-1 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancelar
                    </button>
                    <button id="confirmResetBtn" class="flex-1 px-4 py-2 bg-yellow-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                        Resetear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sistema de pestañas
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        const tabName = this.getAttribute('data-tab');
        
        // Ocultar todos los contenidos
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remover clase active de todos los botones
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Mostrar el contenido seleccionado
        document.getElementById(tabName + '-content').classList.remove('hidden');
        
        // Activar el botón seleccionado
        this.classList.add('active', 'border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
    });
});

// Manejo de formularios
document.getElementById('generalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveGeneralSettings();
});

document.getElementById('appearanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveAppearanceSettings();
});

document.getElementById('layoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    saveLayoutSettings();
});

function saveGeneralSettings() {
    const formData = new FormData(document.getElementById('generalForm'));
    
    fetch(`{{ route('creator.template-configuration.update-settings', $templateConfig->template_slug) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar la configuración');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar la configuración');
    });
}

function saveAppearanceSettings() {
    const formData = new FormData(document.getElementById('appearanceForm'));
    
    // Verificar si hay un logo seleccionado
    const logoFile = document.getElementById('logo').files[0];
    if (logoFile) {
        console.log('📸 Subiendo logo:', logoFile.name);
    }
    
    fetch(`{{ route('creator.template-configuration.update-customization', $templateConfig->template_slug) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Apariencia guardada correctamente');
            updatePreview();
            
            // Si se subió un logo, recargar la página para ver el cambio
            if (logoFile) {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        } else {
            showAlert('error', data.message || 'Error al guardar la apariencia');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar la apariencia');
    });
}

function saveLayoutSettings() {
    const formData = new FormData(document.getElementById('layoutForm'));
    
    fetch(`{{ route('creator.template-configuration.update-customization', $templateConfig->template_slug) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar el diseño');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar el diseño');
    });
}

function saveSocialMedia() {
    const socialData = {
        social_media: {
            facebook: document.getElementById('facebook').value,
            twitter: document.getElementById('twitter').value,
            instagram: document.getElementById('instagram').value,
            linkedin: document.getElementById('linkedin').value
        }
    };
    
    fetch(`{{ route('creator.template-configuration.update-settings', $templateConfig->template_slug) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(socialData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Error al guardar las redes sociales');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error al guardar las redes sociales');
    });
}

function resetConfig() {
    document.getElementById('resetModal').classList.remove('hidden');
}

document.getElementById('cancelReset').addEventListener('click', function() {
    document.getElementById('resetModal').classList.add('hidden');
});

document.getElementById('confirmResetBtn').addEventListener('click', function() {
    window.location.href = `{{ route('creator.template-configuration.reset', $templateConfig->template_slug) }}`;
});

// Cerrar modal al hacer clic fuera
document.getElementById('resetModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700';
    const iconPath = type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z';
    
    const alertHtml = `
        <div class="${alertClass} border px-4 py-3 m-6 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path>
            </svg>
            ${message}
        </div>
    `;
    
    // Insertar alerta
    const container = document.querySelector('.p-0');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        const alert = container.querySelector('.border');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

function updatePreview() {
    const primaryColor = document.getElementById('primary_color').value;
    const headingFont = document.getElementById('heading_font').value;
    const bodyFont = document.getElementById('body_font').value;
    
    const previewTitle = document.getElementById('preview-title');
    const previewText = document.getElementById('preview-text');
    const previewButton = document.getElementById('preview-button');
    
    if (previewTitle) {
        previewTitle.style.color = primaryColor;
        previewTitle.style.fontFamily = headingFont;
    }
    if (previewText) {
        previewText.style.fontFamily = bodyFont;
    }
    if (previewButton) {
        previewButton.style.backgroundColor = primaryColor;
    }
}

// Actualizar hexadecimal en tiempo real
document.getElementById('primary_color').addEventListener('input', function() {
    document.getElementById('primary_color_hex').value = this.value;
    updatePreview();
});

document.getElementById('secondary_color').addEventListener('input', function() {
    document.getElementById('secondary_color_hex').value = this.value;
});

document.getElementById('accent_color').addEventListener('input', function() {
    document.getElementById('accent_color_hex').value = this.value;
});

document.getElementById('heading_font').addEventListener('change', updatePreview);
document.getElementById('body_font').addEventListener('change', updatePreview);

// Preview del logo al seleccionar archivo
document.getElementById('logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('logo-preview-img').src = event.target.result;
            document.getElementById('logo-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Función para remover el logo
function removeLogo() {
    if (confirm('¿Estás seguro de que quieres eliminar el logo?')) {
        fetch(`{{ route('creator.template-configuration.remove-logo', $templateConfig->template_slug) }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Logo eliminado correctamente');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showAlert('error', 'Error al eliminar el logo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Error al eliminar el logo');
        });
    }
}
</script>
@endpush
