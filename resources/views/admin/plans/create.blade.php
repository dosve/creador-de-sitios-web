@extends('layouts.admin')

@section('title', 'Crear Plan')
@section('page-title', 'Crear Plan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Crear Nuevo Plan</h3>
            <p class="text-sm text-gray-500">Configura un nuevo plan de suscripción para los usuarios</p>
        </div>
        
        <form method="POST" action="{{ route('admin.plans.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Plan</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price', 0) }}" step="0.01" min="0" required
                            class="pl-7 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="billing_cycle" class="block text-sm font-medium text-gray-700">Ciclo de Facturación</label>
                <select name="billing_cycle" id="billing_cycle" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('billing_cycle') border-red-500 @enderror">
                    <option value="monthly" {{ old('billing_cycle') === 'monthly' ? 'selected' : '' }}>Mensual</option>
                    <option value="yearly" {{ old('billing_cycle') === 'yearly' ? 'selected' : '' }}>Anual</option>
                </select>
                @error('billing_cycle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Límites -->
            <div class="border-t pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Límites del Plan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_websites" class="block text-sm font-medium text-gray-700">Máximo de Sitios Web</label>
                        <input type="number" name="max_websites" id="max_websites" value="{{ old('max_websites', 1) }}" min="1" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('max_websites') border-red-500 @enderror">
                        @error('max_websites')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="max_pages" class="block text-sm font-medium text-gray-700">Máximo de Páginas</label>
                        <input type="number" name="max_pages" id="max_pages" value="{{ old('max_pages', 10) }}" min="1" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('max_pages') border-red-500 @enderror">
                        @error('max_pages')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Características -->
            <div class="border-t pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Características del Plan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="custom_domain" id="custom_domain" value="1" {{ old('custom_domain') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="custom_domain" class="ml-2 block text-sm text-gray-900">
                                Dominio Personalizado
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="ecommerce" id="ecommerce" value="1" {{ old('ecommerce') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="ecommerce" class="ml-2 block text-sm text-gray-900">
                                E-commerce
                            </label>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="seo_tools" id="seo_tools" value="1" {{ old('seo_tools') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="seo_tools" class="ml-2 block text-sm text-gray-900">
                                Herramientas SEO
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="analytics" id="analytics" value="1" {{ old('analytics') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="analytics" class="ml-2 block text-sm text-gray-900">
                                Analytics
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estado -->
            <div class="border-t pt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Plan Activo
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">Los planes inactivos no estarán disponibles para nuevos usuarios</p>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.plans.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Crear Plan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
