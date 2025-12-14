@extends('layouts.creator')

@section('title', 'Pedidos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pedidos</h1>
                <p class="mt-2 text-gray-600">Gestiona los pedidos de tu tienda</p>
            </div>
        </div>

        <!-- Mensaje sobre Admin Negocios -->
        <div class="py-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Gestión de Pedidos</h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Los pedidos se gestionan directamente desde <strong class="text-blue-600">Admin Negocios</strong>.
                    </p>
                    <p class="text-base text-gray-600 mb-8">
                        Para gestionar tus pedidos (ver, actualizar estados, procesar, etc.), 
                        haz clic en el botón de abajo para acceder directamente al sistema de 
                        <strong>Admin Negocios</strong>.
                    </p>
                    <a href="https://sistema.adminnegocios.com/pedidos" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                        Ir a Admin Negocios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
