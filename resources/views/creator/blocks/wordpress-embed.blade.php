{{-- Bloques de Incorporar de WordPress --}}
{
  id: 'twitter-embed',
  label: 'Twitter',
  category: 'WordPress Incorporar',
  content: `
    <div class="twitter-embed bg-white border border-gray-200 rounded-lg p-4">
      <div class="flex items-center space-x-3 mb-3">
        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.09 4.07 6.1 1.67 3.15a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-gray-900">@usuario</div>
          <div class="text-sm text-gray-500">Hace 2 horas</div>
        </div>
      </div>
      <div class="text-gray-900 mb-3">
        Este es un tweet de ejemplo que se mostraría embebido desde Twitter. #hashtag @mencion
      </div>
      <div class="flex items-center space-x-4 text-sm text-gray-500">
        <button class="flex items-center space-x-1 hover:text-red-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
          <span>24</span>
        </button>
        <button class="flex items-center space-x-1 hover:text-blue-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
          <span>8</span>
        </button>
        <button class="flex items-center space-x-1 hover:text-green-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
          <span>12</span>
        </button>
      </div>
    </div>
  `
},
{
  id: 'instagram-embed',
  label: 'Instagram',
  category: 'WordPress Incorporar',
  content: `
    <div class="instagram-embed bg-white border border-gray-200 rounded-lg overflow-hidden">
      <div class="flex items-center space-x-3 p-4 border-b border-gray-200">
        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-gray-900">@usuario_instagram</div>
          <div class="text-sm text-gray-500">Hace 3 horas</div>
        </div>
      </div>
      <div class="aspect-square bg-gray-200 flex items-center justify-center">
        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
      <div class="p-4">
        <div class="flex items-center space-x-4 mb-2">
          <button class="hover:text-red-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </button>
          <button class="hover:text-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
          </button>
          <button class="hover:text-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
          </button>
        </div>
        <div class="text-sm text-gray-900">
          <span class="font-semibold">@usuario_instagram</span> Descripción del post de Instagram con #hashtags
        </div>
        <div class="text-xs text-gray-500 mt-1">Ver todos los comentarios (15)</div>
      </div>
    </div>
  `
},
{
  id: 'facebook-embed',
  label: 'Facebook',
  category: 'WordPress Incorporar',
  content: `
    <div class="facebook-embed bg-white border border-gray-200 rounded-lg overflow-hidden">
      <div class="flex items-center space-x-3 p-4 border-b border-gray-200">
        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
        </div>
        <div class="flex-1">
          <div class="font-semibold text-gray-900">Página de Facebook</div>
          <div class="text-sm text-gray-500">Hace 4 horas</div>
        </div>
        <button class="text-gray-500 hover:text-gray-700">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
          </svg>
        </button>
      </div>
      <div class="p-4">
        <div class="text-gray-900 mb-3">
          Este es un post de Facebook que se mostraría embebido. Puede incluir texto, imágenes y enlaces.
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
          <div class="flex items-center space-x-4 text-sm text-gray-500">
            <button class="flex items-center space-x-1 hover:text-blue-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V18m-7-8a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2v3a2 2 0 01-2 2H7z"></path>
              </svg>
              <span>Me gusta</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-blue-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
              </svg>
              <span>Comentar</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-blue-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              <span>Compartir</span>
            </button>
          </div>
          <div class="text-sm text-gray-500">24 me gusta</div>
        </div>
      </div>
    </div>
  `
},
{
  id: 'spotify-embed',
  label: 'Spotify',
  category: 'WordPress Incorporar',
  content: `
    <div class="spotify-embed bg-black rounded-lg overflow-hidden">
      <div class="flex items-center space-x-3 p-4 bg-green-600">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
          </svg>
        </div>
        <div class="text-white">
          <div class="font-semibold">Spotify</div>
          <div class="text-sm opacity-90">Reproduciendo</div>
        </div>
      </div>
      <div class="p-4 bg-gray-900">
        <div class="flex items-center space-x-3">
          <div class="w-12 h-12 bg-gray-700 rounded"></div>
          <div class="flex-1 text-white">
            <div class="font-semibold">Nombre de la Canción</div>
            <div class="text-sm text-gray-400">Artista</div>
          </div>
          <button class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700">
            ▶
          </button>
        </div>
        <div class="mt-3">
          <div class="w-full bg-gray-700 rounded-full h-1">
            <div class="bg-green-600 h-1 rounded-full" style="width: 30%"></div>
          </div>
          <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>1:23</span>
            <span>4:56</span>
          </div>
        </div>
      </div>
    </div>
  `
},
{
  id: 'soundcloud-embed',
  label: 'SoundCloud',
  category: 'WordPress Incorporar',
  content: `
    <div class="soundcloud-embed bg-orange-100 border border-orange-200 rounded-lg p-4">
      <div class="flex items-center space-x-3 mb-3">
        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-6h2v-4h-2v4zm0-6h2V6h-2v4z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-gray-900">SoundCloud</div>
          <div class="text-sm text-gray-600">Audio en streaming</div>
        </div>
      </div>
      <div class="bg-white rounded p-3">
        <div class="text-sm font-medium text-gray-900 mb-1">Título del Audio</div>
        <div class="text-xs text-gray-600 mb-2">por Usuario</div>
        <div class="flex items-center space-x-2">
          <button class="bg-orange-500 text-white px-3 py-1 rounded text-xs hover:bg-orange-600">
            ▶ Reproducir
          </button>
          <div class="flex-1 bg-gray-200 rounded-full h-1">
            <div class="bg-orange-500 h-1 rounded-full" style="width: 45%"></div>
          </div>
          <span class="text-xs text-gray-500">2:30</span>
        </div>
      </div>
    </div>
  `
},
{
  id: 'vimeo-embed',
  label: 'Vimeo',
  category: 'WordPress Incorporar',
  content: `
    <div class="vimeo-embed bg-gray-900 rounded-lg overflow-hidden">
      <div class="aspect-video bg-gray-800 flex items-center justify-center">
        <div class="text-center text-white">
          <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.977 6.416c-.105 2.338-1.739 5.543-4.894 9.609-3.268 4.247-6.026 6.37-8.29 6.37-1.409 0-2.578-1.294-3.553-3.881L5.322 11.4C4.603 8.816 3.834 7.522 3.01 7.522c-.179 0-.806.378-1.881 1.132L0 7.197a315.065 315.065 0 003.501-3.128C5.08 2.701 6.266 1.984 7.055 1.91c1.867-.18 3.016 1.1 3.447 3.838.465 2.953.789 4.789.971 5.507.539 2.45 1.131 3.674 1.776 3.674.502 0 1.256-.796 2.265-2.385 1.004-1.589 1.54-2.797 1.612-3.628.144-1.371-.395-2.061-1.614-2.061-.574 0-1.167.121-1.777.391 1.186-3.868 3.434-5.757 6.762-5.637 2.473.06 3.628 1.664 3.493 4.797l-.013.01z"/>
          </svg>
          <div class="text-lg font-semibold">Vimeo</div>
          <div class="text-sm opacity-75">Video embebido</div>
        </div>
      </div>
      <div class="p-4 bg-gray-800 text-white">
        <div class="flex items-center justify-between">
          <div>
            <div class="font-semibold">Título del Video</div>
            <div class="text-sm text-gray-400">por Usuario</div>
          </div>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ▶ Reproducir
          </button>
        </div>
        <div class="mt-3 flex items-center space-x-4 text-sm text-gray-400">
          <span>👁️ 1.2K vistas</span>
          <span>👍 45 me gusta</span>
          <span>💬 12 comentarios</span>
        </div>
      </div>
    </div>
  `
},
{
  id: 'tiktok-embed',
  label: 'TikTok',
  category: 'WordPress Incorporar',
  content: `
    <div class="tiktok-embed bg-black rounded-lg overflow-hidden">
      <div class="aspect-[9/16] bg-gray-900 flex items-center justify-center">
        <div class="text-center text-white">
          <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
          </svg>
          <div class="text-lg font-semibold">TikTok</div>
          <div class="text-sm opacity-75">Video corto</div>
        </div>
      </div>
      <div class="p-4 bg-gray-900 text-white">
        <div class="flex items-center justify-between">
          <div>
            <div class="font-semibold">@usuario_tiktok</div>
            <div class="text-sm text-gray-400">Descripción del video</div>
          </div>
          <div class="flex flex-col items-center space-y-2">
            <button class="bg-gray-700 hover:bg-gray-600 p-2 rounded-full">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </button>
            <span class="text-xs">1.2K</span>
          </div>
        </div>
      </div>
    </div>
  `
},
{
  id: 'google-maps-embed',
  label: 'Google Maps',
  category: 'WordPress Incorporar',
  content: `
    <div class="google-maps-embed bg-white border border-gray-200 rounded-lg overflow-hidden">
      <div class="flex items-center space-x-3 p-4 border-b border-gray-200">
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-gray-900">Google Maps</div>
          <div class="text-sm text-gray-500">Ubicación</div>
        </div>
      </div>
      <div class="h-64 bg-gray-200 flex items-center justify-center">
        <div class="text-center text-gray-600">
          <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <p class="text-sm">Mapa de Google Maps</p>
          <p class="text-xs text-gray-500">Integra Google Maps aquí</p>
        </div>
      </div>
    </div>
  `
}
