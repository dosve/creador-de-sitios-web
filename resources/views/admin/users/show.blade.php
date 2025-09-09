@extends('layouts.admin')

@section('title', 'Detalles de Usuario')
@section('page-title', 'Detalles de Usuario')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Rol</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $user->role === 'admin' ? 'Administrador' : 'Creador' }}
                    </span>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Plan</h4>
                    @if($user->plan)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $user->plan->name }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Sin plan
                        </span>
                    @endif
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Estado</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Sitios Web</h4>
                    <p class="text-2xl font-bold text-blue-600">{{ $user->websites->count() }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Páginas Totales</h4>
                    <p class="text-2xl font-bold text-green-600">{{ $user->websites->sum(function($website) { return $website->pages->count(); }) }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Artículos de Blog</h4>
                    <p class="text-2xl font-bold text-purple-600">{{ $user->websites->sum(function($website) { return $website->blogPosts->count(); }) }}</p>
                </div>
            </div>
            
            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Registrado</h4>
                    <p class="text-sm text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Última actualización</h4>
                    <p class="text-sm text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <!-- Información del Plan -->
            @if($user->plan)
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Detalles del Plan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Precio:</span> ${{ number_format($user->plan->price, 2) }}
                    </div>
                    <div>
                        <span class="font-medium">Sitios web:</span> {{ $user->plan->max_websites ?? 'Ilimitados' }}
                    </div>
                    <div>
                        <span class="font-medium">Páginas por sitio:</span> {{ $user->plan->max_pages_per_site ?? 'Ilimitadas' }}
                    </div>
                    <div>
                        <span class="font-medium">Dominio personalizado:</span> {{ $user->plan->custom_domain ? 'Sí' : 'No' }}
                    </div>
                    <div>
                        <span class="font-medium">E-commerce:</span> {{ $user->plan->ecommerce ? 'Sí' : 'No' }}
                    </div>
                    <div>
                        <span class="font-medium">SEO avanzado:</span> {{ $user->plan->advanced_seo ? 'Sí' : 'No' }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Sitios Web del Usuario -->
    @if($user->websites->count() > 0)
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Sitios Web del Usuario</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sitio Web</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dominio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Páginas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->websites as $website)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $website->name }}</div>
                                    @if($website->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($website->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($website->domain)
                                        <div class="text-sm text-gray-900">{{ $website->domain }}</div>
                                    @elseif($website->subdomain)
                                        <div class="text-sm text-gray-500">{{ $website->subdomain }}.tudominio.com</div>
                                    @else
                                        <span class="text-sm text-gray-400">Sin dominio</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $website->pages->count() }} páginas
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $website->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $website->is_published ? 'Publicado' : 'Borrador' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $website->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.websites.show', $website) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
