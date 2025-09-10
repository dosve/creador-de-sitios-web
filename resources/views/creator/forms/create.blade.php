@extends('layouts.creator')

@section('title', 'Crear Formulario')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                <span class="ml-4 text-sm font-medium text-gray-500">Crear Formulario</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Crear Nuevo Formulario
                </h2>
            </div>
        </div>

        <!-- Form -->
        <div class="mt-8">
            <form action="{{ route('creator.forms.store', $website) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Información Básica</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Configura la información básica del formulario.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Nombre del Formulario
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" 
                                               value="{{ old('name') }}"
                                               class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror"
                                               placeholder="Ej: Formulario de Contacto">
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">
                                        Tipo de Formulario
                                    </label>
                                    <div class="mt-1">
                                        <select name="type" id="type" 
                                                class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('type') border-red-300 @enderror">
                                            <option value="contact" {{ old('type') == 'contact' ? 'selected' : '' }}>Formulario de Contacto</option>
                                            <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>Formulario Personalizado</option>
                                        </select>
                                    </div>
                                    @error('type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                        Descripción
                                    </label>
                                    <div class="mt-1">
                                        <textarea name="description" id="description" rows="3"
                                                  class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror"
                                                  placeholder="Describe el propósito de este formulario...">{{ old('description') }}</textarea>
                                    </div>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de Email -->
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Configuración de Email</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Configura dónde se enviarán los formularios.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="email_to" class="block text-sm font-medium text-gray-700">
                                        Email de Destino
                                    </label>
                                    <div class="mt-1">
                                        <input type="email" name="email_to" id="email_to" 
                                               value="{{ old('email_to') }}"
                                               class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email_to') border-red-300 @enderror"
                                               placeholder="contacto@tusitio.com">
                                    </div>
                                    @error('email_to')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email_subject" class="block text-sm font-medium text-gray-700">
                                        Asunto del Email
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="email_subject" id="email_subject" 
                                               value="{{ old('email_subject', 'Nuevo mensaje desde el formulario') }}"
                                               class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email_subject') border-red-300 @enderror">
                                    </div>
                                    @error('email_subject')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración de Mensajes -->
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Mensajes</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Personaliza los mensajes que verán los usuarios.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="submit_button_text" class="block text-sm font-medium text-gray-700">
                                        Texto del Botón de Envío
                                    </label>
                                    <div class="mt-1">
                                        <input type="text" name="submit_button_text" id="submit_button_text" 
                                               value="{{ old('submit_button_text', 'Enviar Mensaje') }}"
                                               class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('submit_button_text') border-red-300 @enderror">
                                    </div>
                                    @error('submit_button_text')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="success_message" class="block text-sm font-medium text-gray-700">
                                        Mensaje de Éxito
                                    </label>
                                    <div class="mt-1">
                                        <textarea name="success_message" id="success_message" rows="2"
                                                  class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('success_message') border-red-300 @enderror"
                                                  placeholder="¡Gracias! Tu mensaje ha sido enviado correctamente.">{{ old('success_message', '¡Gracias! Tu mensaje ha sido enviado correctamente.') }}</textarea>
                                    </div>
                                    @error('success_message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('creator.forms.index', $website) }}" 
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Crear Formulario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
