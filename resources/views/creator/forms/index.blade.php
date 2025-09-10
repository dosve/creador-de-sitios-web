@extends('layouts.creator')

@section('title', 'Formularios')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Formularios
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Gestiona los formularios de contacto y recopilación de datos para tu sitio web.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('creator.forms.create', $website) }}" 
                   class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Formulario
                </a>
            </div>
        </div>

        <!-- Forms Grid -->
        <div class="mt-8">
            @if($forms->count() > 0)
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($forms as $form)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                {{ $form->name }}
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                {{ $form->type === 'contact' ? 'Contacto' : 'Personalizado' }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                @if($form->description)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">{{ Str::limit($form->description, 100) }}</p>
                                    </div>
                                @endif
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $form->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $form->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $form->total_submissions_count }} envíos
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3">
                                <div class="flex space-x-3">
                                    <a href="{{ route('creator.forms.edit', [$website, $form]) }}" 
                                       class="text-sm font-medium text-gray-600 hover:text-gray-500">
                                        Editar
                                    </a>
                                    <a href="{{ route('creator.forms.builder', [$website, $form]) }}" 
                                       class="text-sm font-medium text-green-600 hover:text-green-500">
                                        Constructor
                                    </a>
                                    <a href="{{ route('creator.forms.submissions', [$website, $form]) }}" 
                                       class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                        Envíos
                                    </a>
                                    <form method="POST" action="{{ route('creator.forms.destroy', [$website, $form]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm font-medium text-red-600 hover:text-red-500"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este formulario?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay formularios</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primer formulario de contacto.</p>
                    <div class="mt-6">
                        <a href="{{ route('creator.forms.create', $website) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Formulario
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
