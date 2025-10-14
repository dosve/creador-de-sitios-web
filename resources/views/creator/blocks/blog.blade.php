{{-- Bloques de Blog --}}
{
  id: 'blog-post-card',
  label: 'Tarjeta de Artículo',
  category: 'Blog',
  content: `
    <article class="blog-post-card max-w-sm mx-auto bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
      <div class="relative">
        <div class="w-full h-48 bg-gray-300 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/400x250')"></div>
        <div class="absolute top-4 left-4">
          <span data-gjs-type="text" data-gjs-name="post-category" class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold">Tecnología</span>
        </div>
        <div class="absolute top-4 right-4">
          <button class="w-8 h-8 bg-white bg-opacity-90 rounded-full flex items-center justify-center shadow-md hover:bg-opacity-100">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
            </svg>
          </button>
        </div>
      </div>
      <div class="p-6">
        <div class="flex items-center text-sm text-gray-500 mb-3">
          <span data-gjs-type="text" data-gjs-name="post-date">15 Enero, 2024</span>
          <span class="mx-2">•</span>
          <span data-gjs-type="text" data-gjs-name="post-read-time">5 min lectura</span>
        </div>
        <h3 data-gjs-type="text" data-gjs-name="post-title" class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">Título del Artículo de Blog</h3>
        <p data-gjs-type="text" data-gjs-name="post-excerpt" class="text-gray-600 mb-4 line-clamp-3">Descripción breve del artículo que explica de qué trata el contenido y captura la atención del lector...</p>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-gray-300 rounded-full mr-3"></div>
            <div>
              <p data-gjs-type="text" data-gjs-name="author-name" class="text-sm font-medium text-gray-900">Juan Pérez</p>
              <p data-gjs-type="text" data-gjs-name="author-title" class="text-xs text-gray-500">Editor</p>
            </div>
          </div>
          <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Leer más →</a>
        </div>
      </div>
    </article>
  `,
  traits: [
    {
      type: 'text',
      name: 'image-url',
      label: 'URL de Imagen',
      placeholder: 'https://ejemplo.com/imagen.jpg'
    },
    {
      type: 'text',
      name: 'category',
      label: 'Categoría',
      placeholder: 'Tecnología'
    },
    {
      type: 'text',
      name: 'read-time',
      label: 'Tiempo de Lectura',
      placeholder: '5 min lectura'
    },
    {
      type: 'text',
      name: 'author-name',
      label: 'Nombre del Autor',
      placeholder: 'Juan Pérez'
    },
    {
      type: 'text',
      name: 'author-title',
      label: 'Título del Autor',
      placeholder: 'Editor'
    }
  ]
},
{
  id: 'blog-grid',
  label: 'Grid de Artículos',
  category: 'Blog',
  content: `
    <section class="blog-grid py-12" data-dynamic-blog="true">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 data-gjs-type="text" data-gjs-name="section-title" class="text-3xl font-bold text-gray-900 mb-4">Últimos Artículos</h2>
          <p data-gjs-type="text" data-gjs-name="section-subtitle" class="text-lg text-gray-600">Descubre nuestras últimas publicaciones y tendencias</p>
        </div>
        <div id="blog-posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-website-id="1">
          <!-- Los posts se cargarán dinámicamente aquí -->
        </div>
        <div class="text-center mt-8">
          <a href="/creator/websites/1/preview/blog" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold" data-blog-list-link>
            Ver Todos los Artículos
          </a>
        </div>
      </div>
    </section>
  `,
  traits: [
    {
      type: 'text',
      name: 'website-id',
      label: 'ID del Sitio Web',
      placeholder: '1'
    }
  ]
},
{
  id: 'featured-post',
  label: 'Artículo Destacado',
  category: 'Blog',
  content: `
    <section class="featured-post py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden max-w-6xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="w-full h-64 lg:h-full bg-gray-300 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/600x400')"></div>
            <div class="p-8 lg:p-12">
              <div class="flex items-center text-sm text-gray-500 mb-4">
                <span data-gjs-type="text" data-gjs-name="featured-date">15 Enero, 2024</span>
                <span class="mx-2">•</span>
                <span data-gjs-type="text" data-gjs-name="featured-read-time">8 min lectura</span>
                <span class="mx-2">•</span>
                <span data-gjs-type="text" data-gjs-name="featured-category" class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">Tecnología</span>
              </div>
              <h2 data-gjs-type="text" data-gjs-name="featured-title" class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Título del Artículo Destacado</h2>
              <p data-gjs-type="text" data-gjs-name="featured-excerpt" class="text-lg text-gray-600 mb-6">Descripción del artículo destacado que explica de qué trata el contenido y captura la atención del lector con información relevante...</p>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-gray-300 rounded-full mr-4"></div>
                  <div>
                    <p data-gjs-type="text" data-gjs-name="featured-author" class="font-semibold text-gray-900">María García</p>
                    <p data-gjs-type="text" data-gjs-name="featured-author-title" class="text-sm text-gray-500">Editora Principal</p>
                  </div>
                </div>
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                  Leer Artículo
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  `,
  traits: [
    {
      type: 'text',
      name: 'image-url',
      label: 'URL de Imagen',
      placeholder: 'https://ejemplo.com/imagen-destacada.jpg'
    },
    {
      type: 'text',
      name: 'author-image',
      label: 'URL de Foto del Autor',
      placeholder: 'https://ejemplo.com/autor.jpg'
    }
  ]
},
{
  id: 'blog-categories',
  label: 'Categorías del Blog',
  category: 'Blog',
  content: `
    <section class="blog-categories py-12">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 data-gjs-type="text" data-gjs-name="categories-title" class="text-3xl font-bold text-gray-900 mb-4">Explora por Categorías</h2>
          <p data-gjs-type="text" data-gjs-name="categories-subtitle" class="text-lg text-gray-600">Encuentra contenido que te interese</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div class="category-card bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow cursor-pointer">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
              </svg>
            </div>
            <h3 data-gjs-type="text" data-gjs-name="category-1" class="text-lg font-semibold text-gray-900 mb-2">Tecnología</h3>
            <p data-gjs-type="text" data-gjs-name="category-1-count" class="text-sm text-gray-500">24 artículos</p>
          </div>
          <div class="category-card bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow cursor-pointer">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <h3 data-gjs-type="text" data-gjs-name="category-2" class="text-lg font-semibold text-gray-900 mb-2">Educación</h3>
            <p data-gjs-type="text" data-gjs-name="category-2-count" class="text-sm text-gray-500">18 artículos</p>
          </div>
          <div class="category-card bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow cursor-pointer">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <h3 data-gjs-type="text" data-gjs-name="category-3" class="text-lg font-semibold text-gray-900 mb-2">Negocios</h3>
            <p data-gjs-type="text" data-gjs-name="category-3-count" class="text-sm text-gray-500">15 artículos</p>
          </div>
          <div class="category-card bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow cursor-pointer">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 data-gjs-type="text" data-gjs-name="category-4" class="text-lg font-semibold text-gray-900 mb-2">Diseño</h3>
            <p data-gjs-type="text" data-gjs-name="category-4-count" class="text-sm text-gray-500">12 artículos</p>
          </div>
        </div>
      </div>
    </section>
  `
},
{
  id: 'newsletter-signup',
  label: 'Suscripción a Newsletter',
  category: 'Blog',
  content: `
    <section class="newsletter-signup py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
          <h2 data-gjs-type="text" data-gjs-name="newsletter-title" class="text-3xl lg:text-4xl font-bold mb-4">Mantente Actualizado</h2>
          <p data-gjs-type="text" data-gjs-name="newsletter-subtitle" class="text-xl text-blue-100 mb-8">Recibe nuestros mejores artículos directamente en tu bandeja de entrada</p>
          
          <div class="max-w-md mx-auto">
            <form class="flex flex-col sm:flex-row gap-4">
              <input type="email" placeholder="Tu email" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
              <button type="submit" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Suscribirse
              </button>
            </form>
          </div>
          
          <div class="flex items-center justify-center mt-6 text-blue-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span data-gjs-type="text" data-gjs-name="privacy-text" class="text-sm">No compartimos tu email. Cancele en cualquier momento.</span>
          </div>
          
          <div class="mt-8 flex justify-center space-x-6">
            <div class="text-center">
              <div class="text-2xl font-bold" data-gjs-type="text" data-gjs-name="subscriber-count">5,000+</div>
              <div class="text-sm text-blue-100">Suscriptores</div>
            </div>
            <div class="text-center">
              <div class="text-2xl font-bold" data-gjs-type="text" data-gjs-name="weekly-posts">3</div>
              <div class="text-sm text-blue-100">Artículos por Semana</div>
            </div>
            <div class="text-center">
              <div class="text-2xl font-bold" data-gjs-type="text" data-gjs-name="open-rate">85%</div>
              <div class="text-sm text-blue-100">Tasa de Apertura</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  `,
  traits: [
    {
      type: 'text',
      name: 'subscriber-count',
      label: 'Número de Suscriptores',
      placeholder: '5,000+'
    },
    {
      type: 'text',
      name: 'weekly-posts',
      label: 'Artículos por Semana',
      placeholder: '3'
    },
    {
      type: 'text',
      name: 'open-rate',
      label: 'Tasa de Apertura (%)',
      placeholder: '85%'
    }
  ]
},
{
  id: 'author-bio',
  label: 'Biografía del Autor',
  category: 'Blog',
  content: `
    <section class="author-bio py-12 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
              <div class="flex-shrink-0">
                <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto"></div>
              </div>
              <div class="flex-1 text-center md:text-left">
                <h2 data-gjs-type="text" data-gjs-name="author-name" class="text-2xl font-bold text-gray-900 mb-2">María García</h2>
                <p data-gjs-type="text" data-gjs-name="author-title" class="text-lg text-blue-600 font-medium mb-4">Editora Principal</p>
                <p data-gjs-type="text" data-gjs-name="author-bio" class="text-gray-600 mb-6 leading-relaxed">María es una periodista especializada en tecnología con más de 8 años de experiencia. Ha trabajado para las principales revistas del sector y es reconocida por sus análisis profundos y su capacidad para explicar conceptos complejos de manera sencilla.</p>
                
                <div class="flex justify-center md:justify-start space-x-4 mb-6">
                  <a href="#" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                  </a>
                  <a href="#" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                  </a>
                  <a href="#" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                    </svg>
                  </a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
                  <div>
                    <div class="text-2xl font-bold text-blue-600" data-gjs-type="text" data-gjs-name="articles-count">45</div>
                    <div class="text-sm text-gray-600">Artículos</div>
                  </div>
                  <div>
                    <div class="text-2xl font-bold text-blue-600" data-gjs-type="text" data-gjs-name="followers-count">2.5K</div>
                    <div class="text-sm text-gray-600">Seguidores</div>
                  </div>
                  <div class="col-span-2 md:col-span-1">
                    <div class="text-2xl font-bold text-blue-600" data-gjs-type="text" data-gjs-name="experience-years">8</div>
                    <div class="text-sm text-gray-600">Años Experiencia</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  `,
  traits: [
    {
      type: 'text',
      name: 'author-image',
      label: 'URL de Foto del Autor',
      placeholder: 'https://ejemplo.com/autor.jpg'
    },
    {
      type: 'text',
      name: 'twitter-url',
      label: 'URL de Twitter',
      placeholder: 'https://twitter.com/usuario'
    },
    {
      type: 'text',
      name: 'linkedin-url',
      label: 'URL de LinkedIn',
      placeholder: 'https://linkedin.com/in/usuario'
    }
  ]
},
{
  id: 'related-posts',
  label: 'Artículos Relacionados',
  category: 'Blog',
  content: `
    <section class="related-posts py-12">
      <div class="container mx-auto px-4">
        <h2 data-gjs-type="text" data-gjs-name="related-title" class="text-2xl font-bold text-gray-900 mb-8">Artículos Relacionados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-40 bg-gray-300"></div>
            <div class="p-4">
              <div class="flex items-center text-xs text-gray-500 mb-2">
                <span>12 Enero, 2024</span>
                <span class="mx-2">•</span>
                <span>4 min</span>
              </div>
              <h3 data-gjs-type="text" data-gjs-name="related-title-1" class="font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Título del Artículo Relacionado 1</h3>
              <p data-gjs-type="text" data-gjs-name="related-excerpt-1" class="text-sm text-gray-600">Descripción breve del artículo relacionado...</p>
            </div>
          </article>
          <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-40 bg-gray-300"></div>
            <div class="p-4">
              <div class="flex items-center text-xs text-gray-500 mb-2">
                <span>9 Enero, 2024</span>
                <span class="mx-2">•</span>
                <span>6 min</span>
              </div>
              <h3 data-gjs-type="text" data-gjs-name="related-title-2" class="font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Título del Artículo Relacionado 2</h3>
              <p data-gjs-type="text" data-gjs-name="related-excerpt-2" class="text-sm text-gray-600">Descripción breve del artículo relacionado...</p>
            </div>
          </article>
          <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="w-full h-40 bg-gray-300"></div>
            <div class="p-4">
              <div class="flex items-center text-xs text-gray-500 mb-2">
                <span>6 Enero, 2024</span>
                <span class="mx-2">•</span>
                <span>5 min</span>
              </div>
              <h3 data-gjs-type="text" data-gjs-name="related-title-3" class="font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">Título del Artículo Relacionado 3</h3>
              <p data-gjs-type="text" data-gjs-name="related-excerpt-3" class="text-sm text-gray-600">Descripción breve del artículo relacionado...</p>
            </div>
          </article>
        </div>
      </div>
    </section>
  `
}

