{{-- Bloques de Formularios de Autenticación --}}
{
  id: 'login-form',
  label: 'Formulario de Login',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-login-form'
  },
  content: `
    <div class="login-form-container max-w-md mx-auto p-8 bg-white rounded-lg shadow-lg">
      <div class="text-center mb-6">
        <h2 data-gjs-type="text" data-gjs-name="form-title" class="text-2xl font-bold text-gray-900">Iniciar Sesión</h2>
        <p data-gjs-type="text" data-gjs-name="form-subtitle" class="mt-2 text-sm text-gray-600">Accede a tu cuenta</p>
      </div>
      
      <form class="login-form space-y-4" method="POST" action="/login">
        <!-- Email Field -->
        <div class="form-group">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email
          </label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="tu@email.com"
          >
        </div>
        
        <!-- Password Field -->
        <div class="form-group">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Contraseña
          </label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="••••••••"
          >
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input 
              type="checkbox" 
              id="remember" 
              name="remember"
              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            >
            <label for="remember" class="ml-2 text-sm text-gray-600">
              Recordarme
            </label>
          </div>
          <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-800">
            ¿Olvidaste tu contraseña?
          </a>
        </div>
        
        <!-- Submit Button -->
        <button 
          type="submit"
          class="w-full px-4 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Iniciar Sesión
        </button>
        
        <!-- Register Link -->
        <div class="text-center mt-4">
          <span class="text-sm text-gray-600">¿No tienes cuenta? </span>
          <a href="/register" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
            Regístrate aquí
          </a>
        </div>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Acción',
      placeholder: '/login',
      value: '/login'
    },
    {
      type: 'text',
      name: 'redirect-after-login',
      label: 'Redirigir después del login',
      placeholder: '/dashboard'
    },
    {
      type: 'checkbox',
      name: 'show-remember',
      label: 'Mostrar "Recordarme"',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-forgot-password',
      label: 'Mostrar "Olvidé mi contraseña"',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-register-link',
      label: 'Mostrar enlace de registro',
      value: true
    },
    {
      type: 'select',
      name: 'form-style',
      label: 'Estilo del Formulario',
      options: [
        { value: 'default', name: 'Por Defecto' },
        { value: 'minimal', name: 'Minimalista' },
        { value: 'card', name: 'Tarjeta' }
      ]
    }
  ]
},
{
  id: 'registration-form',
  label: 'Formulario de Registro',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-registration-form'
  },
  content: `
    <div class="registration-form-container max-w-md mx-auto p-8 bg-white rounded-lg shadow-lg">
      <div class="text-center mb-6">
        <h2 data-gjs-type="text" data-gjs-name="form-title" class="text-2xl font-bold text-gray-900">Crear Cuenta</h2>
        <p data-gjs-type="text" data-gjs-name="form-subtitle" class="mt-2 text-sm text-gray-600">Únete a nuestra comunidad</p>
      </div>
      
      <form class="registration-form space-y-4" method="POST" action="/register">
        <!-- Name Field -->
        <div class="form-group">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Nombre Completo
          </label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Juan Pérez"
          >
        </div>
        
        <!-- Email Field -->
        <div class="form-group">
          <label for="reg-email" class="block text-sm font-medium text-gray-700 mb-2">
            Email
          </label>
          <input 
            type="email" 
            id="reg-email" 
            name="email" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="tu@email.com"
          >
        </div>
        
        <!-- Password Field -->
        <div class="form-group">
          <label for="reg-password" class="block text-sm font-medium text-gray-700 mb-2">
            Contraseña
          </label>
          <input 
            type="password" 
            id="reg-password" 
            name="password" 
            required
            minlength="8"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Mínimo 8 caracteres"
          >
          <p class="mt-1 text-xs text-gray-500">Debe tener al menos 8 caracteres</p>
        </div>
        
        <!-- Confirm Password Field -->
        <div class="form-group">
          <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
            Confirmar Contraseña
          </label>
          <input 
            type="password" 
            id="password-confirm" 
            name="password_confirmation" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Repite tu contraseña"
          >
        </div>
        
        <!-- Terms & Conditions -->
        <div class="flex items-start">
          <input 
            type="checkbox" 
            id="terms" 
            name="terms" 
            required
            class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
          >
          <label for="terms" class="ml-2 text-sm text-gray-600">
            Acepto los <a href="/terms" class="text-blue-600 hover:text-blue-800">términos y condiciones</a> y la <a href="/privacy" class="text-blue-600 hover:text-blue-800">política de privacidad</a>
          </label>
        </div>
        
        <!-- Submit Button -->
        <button 
          type="submit"
          class="w-full px-4 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Crear Cuenta
        </button>
        
        <!-- Login Link -->
        <div class="text-center mt-4">
          <span class="text-sm text-gray-600">¿Ya tienes cuenta? </span>
          <a href="/login" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
            Inicia sesión aquí
          </a>
        </div>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Acción',
      placeholder: '/register',
      value: '/register'
    },
    {
      type: 'text',
      name: 'redirect-after-register',
      label: 'Redirigir después del registro',
      placeholder: '/welcome'
    },
    {
      type: 'checkbox',
      name: 'auto-login',
      label: 'Login automático después del registro',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-name-field',
      label: 'Mostrar campo de nombre',
      value: true
    },
    {
      type: 'checkbox',
      name: 'show-terms',
      label: 'Mostrar términos y condiciones',
      value: true
    },
    {
      type: 'checkbox',
      name: 'email-verification',
      label: 'Requiere verificación de email',
      value: false
    },
    {
      type: 'select',
      name: 'default-role',
      label: 'Rol por Defecto',
      options: [
        { value: 'user', name: 'Usuario' },
        { value: 'customer', name: 'Cliente' },
        { value: 'subscriber', name: 'Suscriptor' }
      ]
    }
  ]
},
{
  id: 'forgot-password-form',
  label: 'Recuperar Contraseña',
  category: 'Formularios',
  attributes: {
    class: 'gjs-block-forgot-password'
  },
  content: `
    <div class="forgot-password-form-container max-w-md mx-auto p-8 bg-white rounded-lg shadow-lg">
      <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 rounded-full">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
          </svg>
        </div>
        <h2 data-gjs-type="text" data-gjs-name="form-title" class="text-2xl font-bold text-gray-900">¿Olvidaste tu contraseña?</h2>
        <p data-gjs-type="text" data-gjs-name="form-subtitle" class="mt-2 text-sm text-gray-600">Te enviaremos un enlace para restablecer tu contraseña</p>
      </div>
      
      <form class="forgot-password-form space-y-4" method="POST" action="/forgot-password">
        <!-- Email Field -->
        <div class="form-group">
          <label for="forgot-email" class="block text-sm font-medium text-gray-700 mb-2">
            Email
          </label>
          <input 
            type="email" 
            id="forgot-email" 
            name="email" 
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="tu@email.com"
          >
        </div>
        
        <!-- Submit Button -->
        <button 
          type="submit"
          class="w-full px-4 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Enviar Enlace de Recuperación
        </button>
        
        <!-- Back to Login Link -->
        <div class="text-center mt-4">
          <a href="/login" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al login
          </a>
        </div>
      </form>
    </div>
  `,
  traits: [
    {
      type: 'text',
      name: 'form-action',
      label: 'URL de Acción',
      placeholder: '/forgot-password',
      value: '/forgot-password'
    },
    {
      type: 'text',
      name: 'success-message',
      label: 'Mensaje de Éxito',
      placeholder: 'Te hemos enviado un email con las instrucciones'
    }
  ]
}

