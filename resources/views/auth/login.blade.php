<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Creador de Sitios Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md space-y-8">
        <div>
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                Iniciar Sesión
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600">
                Accede a tu cuenta para crear sitios web
            </p>
        </div>

        <!-- Botón principal: Login con OAuth2 -->
        <div class="mt-8">
            <a href="{{ route('oauth.redirect') }}" 
               class="group relative flex justify-center w-full px-4 py-3 text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 border border-transparent rounded-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg transform transition hover:scale-105">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-indigo-200 group-hover:text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </span>
                Iniciar sesión con Auth EME10
            </a>
            
            <p class="mt-3 text-xs text-center text-gray-500">
                🔒 Autenticación segura centralizada con soporte 2FA
            </p>
        </div>

        <!-- Separador -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-100 text-gray-500">
                    O usa el login directo (legacy)
                </span>
            </div>
        </div>

        <!-- Formulario legacy (para usuarios antiguos) -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                        placeholder="Dirección de email" value="{{ old('email') }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="sr-only">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                        placeholder="Contraseña">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="block ml-2 text-sm text-gray-900">
                        Recordarme
                    </label>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md group hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Iniciar Sesión
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>

        <!-- Usuarios de prueba -->
        <div class="p-4 mt-8 rounded-md bg-blue-50">
            <h3 class="mb-2 text-sm font-medium text-blue-800">Usuarios de prueba:</h3>
            <div class="space-y-1 text-xs text-blue-700">
                <p><strong>Admin:</strong> admin@creador.com / admin123</p>
                <p><strong>Creador:</strong> creator@creador.com / creator123</p>
            </div>
        </div>
    </div>
</body>

</html>