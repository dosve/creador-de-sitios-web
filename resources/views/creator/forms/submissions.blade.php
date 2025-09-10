@extends('layouts.creator')

@section('title', 'Envíos del Formulario')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="{{ route('creator.forms.index', $website) }}" class="text-gray-400 hover:text-gray-500">
                                    <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    <span class="sr-only">Formularios</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">Envíos</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Envíos: {{ $form->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $submissions->count() }} envíos recibidos
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('creator.forms.builder', [$website, $form]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Formulario
                </a>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="mt-8">
            @if($submissions->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                            <li>
                                <a href="{{ route('creator.forms.show-submission', [$website, $form, $submission]) }}" 
                                   class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    @if($submission->is_read)
                                                        <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                                    @else
                                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="flex items-center">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            Envío #{{ $submission->id }}
                                                        </p>
                                                        @if(!$submission->is_read)
                                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Nuevo
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-1">
                                                        <p class="text-sm text-gray-500">
                                                            {{ $submission->created_at->format('d/m/Y H:i') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-500">
                                                    IP: {{ $submission->ip_address }}
                                                </div>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Preview of submission data -->
                                        <div class="mt-2">
                                            @php
                                                $data = is_string($submission->data) ? json_decode($submission->data, true) : $submission->data;
                                            @endphp
                                            @if($data && is_array($data))
                                                <div class="text-sm text-gray-600">
                                                    @foreach(array_slice($data, 0, 3) as $key => $value)
                                                        <span class="inline-block mr-4">
                                                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                            {{ is_array($value) ? implode(', ', $value) : Str::limit($value, 50) }}
                                                        </span>
                                                    @endforeach
                                                    @if(count($data) > 3)
                                                        <span class="text-gray-400">...</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Pagination -->
                @if($submissions->hasPages())
                    <div class="mt-6">
                        {{ $submissions->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay envíos</h3>
                    <p class="mt-1 text-sm text-gray-500">Este formulario aún no ha recibido ningún envío.</p>
                    <div class="mt-6">
                        <a href="{{ route('creator.forms.builder', [$website, $form]) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Formulario
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
