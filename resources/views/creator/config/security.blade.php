@extends('layouts.creator')

@section('title', 'SSL y Seguridad - ' . $website->name)
@section('page-title', 'SSL y Seguridad')
@section('content')
            <!-- Security Configuration Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">SSL y Seguridad</h2>
                            <p class="text-sm text-gray-600 mt-1">Configura la seguridad y certificados SSL para {{ $website->name }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Seguro
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SSL Configuration -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Certificado SSL</h3>
                            <p class="text-sm text-gray-600 mt-1">Configura y gestiona el certificado SSL para tu sitio web</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Activo
                            </span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('creator.config.security.ssl') }}">
                        @csrf
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SSL Habilitado</h4>
                                    <p class="text-sm text-gray-500">Activa el certificado SSL para tu sitio web</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="ssl_enabled" value="1" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Forzar HTTPS</h4>
                                    <p class="text-sm text-gray-500">Redirigir automáticamente HTTP a HTTPS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="force_https" value="1" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">HSTS (HTTP Strict Transport Security)</h4>
                                    <p class="text-sm text-gray-500">Mejora la seguridad forzando conexiones HTTPS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="hsts_enabled" value="1" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Configuración SSL
                            </button>
                            <button type="button" 
                                    onclick="generateSsl()"
                                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Regenerar Certificado
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Configuración de Seguridad</h3>
                    <p class="text-sm text-gray-600 mt-1">Ajustes adicionales de seguridad para tu sitio web</p>
                </div>
                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('creator.config.security.update') }}">
                        @csrf
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Autenticación de Dos Factores</h4>
                                    <p class="text-sm text-gray-500">Requiere un código adicional para acceder al panel de administración</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="two_factor_enabled" value="1" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div>
                                <label for="login_attempts_limit" class="block text-sm font-medium text-gray-700">Límite de Intentos de Login</label>
                                <div class="mt-1">
                                    <select name="login_attempts_limit" id="login_attempts_limit" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="3">3 intentos</option>
                                        <option value="5" selected>5 intentos</option>
                                        <option value="7">7 intentos</option>
                                        <option value="10">10 intentos</option>
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Número máximo de intentos de login fallidos antes de bloquear la IP</p>
                            </div>

                            <div>
                                <label for="session_timeout" class="block text-sm font-medium text-gray-700">Tiempo de Expiración de Sesión (minutos)</label>
                                <div class="mt-1">
                                    <select name="session_timeout" id="session_timeout" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="15">15 minutos</option>
                                        <option value="30">30 minutos</option>
                                        <option value="60" selected>1 hora</option>
                                        <option value="120">2 horas</option>
                                        <option value="240">4 horas</option>
                                        <option value="480">8 horas</option>
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Tiempo después del cual la sesión expira automáticamente</p>
                            </div>

                            <div>
                                <label for="ip_whitelist" class="block text-sm font-medium text-gray-700">Lista Blanca de IPs</label>
                                <div class="mt-1">
                                    <textarea name="ip_whitelist" id="ip_whitelist" rows="3" 
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                                              placeholder="192.168.1.1&#10;10.0.0.1&#10;203.0.113.0/24"></textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Una IP por línea. Puedes usar rangos CIDR (ej: 192.168.1.0/24)</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Configuración de Seguridad
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Status -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Estado de Seguridad</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Certificado SSL</h4>
                                    <p class="text-sm text-gray-500">Válido hasta: 15/12/2024</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">HTTPS Redirección</h4>
                                    <p class="text-sm text-gray-500">Activa</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">2FA</h4>
                                    <p class="text-sm text-gray-500">No configurado</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Firewall</h4>
                                    <p class="text-sm text-gray-500">Activo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function generateSsl() {
                    if (confirm('¿Estás seguro de que quieres regenerar el certificado SSL? Esto puede tomar unos minutos.')) {
                        fetch('{{ route("creator.config.security.generate-ssl") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Certificado SSL regenerado exitosamente.');
                                location.reload();
                            } else {
                                alert('Error al regenerar el certificado SSL.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al regenerar el certificado SSL.');
                        });
                    }
                }
            </script>
@endsection
