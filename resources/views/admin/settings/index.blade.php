@extends('layouts.admin')

@section('title', 'Configuración del Sistema')
@section('page-title', 'Configuración del Sistema')

@section('content')
<div class="space-y-6">
    <!-- General Settings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Configuración General</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre del Sistema</label>
                    <input type="text" value="Creador de Sitios Web" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email de Contacto</label>
                    <input type="email" value="admin@creadorweb.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción del Sistema</label>
                    <textarea rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">Plataforma para crear sitios web profesionales sin código</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- User Settings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Configuración de Usuarios</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-900">Permitir registro de nuevos usuarios</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-900">Verificación de email requerida</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-900">Aprobación manual de usuarios</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Website Settings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Configuración de Sitios Web</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Límite de sitios por usuario (plan gratuito)</label>
                    <input type="number" value="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Límite de páginas por sitio (plan gratuito)</label>
                    <input type="number" value="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-900">Permitir dominios personalizados</label>
                </div>
            </div>
        </div>
    </div>

    <!-- System Settings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Configuración del Sistema</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Zona Horaria</label>
                    <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="America/Mexico_City" selected>México (GMT-6)</option>
                        <option value="America/New_York">Nueva York (GMT-5)</option>
                        <option value="Europe/Madrid">Madrid (GMT+1)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Idioma por defecto</label>
                    <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="es" selected>Español</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-900">Modo mantenimiento</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Guardar Configuración
        </button>
    </div>
</div>
@endsection
