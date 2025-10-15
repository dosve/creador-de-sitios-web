{{-- Plantillas Predefinidas --}}
{
  id: 'template-landing',
  label: 'Landing Page',
  content: `
    <!-- Hero Section -->
    <section class="hero bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Tu Título Impactante</h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Descripción de tu producto o servicio que captura la atención</p>
        <div class="space-x-4">
          <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Comenzar Ahora</button>
          <button class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">Saber Más</button>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Características Principales</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">Descubre las ventajas que te ofrecemos</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Rápido</h3>
            <p class="text-gray-600">Velocidad y eficiencia en cada proceso</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Confiable</h3>
            <p class="text-gray-600">Seguridad y confiabilidad garantizada</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Fácil</h3>
            <p class="text-gray-600">Interfaz intuitiva y fácil de usar</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta py-16 bg-blue-600 text-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Listo para comenzar?</h2>
        <p class="text-xl mb-8">Únete a miles de usuarios satisfechos</p>
        <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
          Comenzar Gratis
        </button>
      </div>
    </section>
  `,
  category: 'Plantillas'
},
{
  id: 'template-portfolio',
  label: 'Portfolio',
  content: `
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Mi Portfolio</h1>
          <nav class="space-x-6">
            <a href="#" class="text-gray-600 hover:text-gray-900">Inicio</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Proyectos</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Sobre Mí</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
          </nav>
        </div>
      </div>
    </header>

    <!-- Hero -->
    <section class="hero py-20 bg-gray-50">
      <div class="container mx-auto px-4 text-center">
        <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-6"></div>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Juan Pérez</h1>
        <p class="text-xl text-gray-600 mb-8">Desarrollador Web & Diseñador UX/UI</p>
        <button class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
          Ver Mis Trabajos
        </button>
      </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="portfolio py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Mis Proyectos</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Proyecto 1</h3>
              <p class="text-gray-600 mb-4">Descripción del proyecto</p>
              <button class="text-blue-600 hover:text-blue-800">Ver Proyecto →</button>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Proyecto 2</h3>
              <p class="text-gray-600 mb-4">Descripción del proyecto</p>
              <button class="text-blue-600 hover:text-blue-800">Ver Proyecto →</button>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">Proyecto 3</h3>
              <p class="text-gray-600 mb-4">Descripción del proyecto</p>
              <button class="text-blue-600 hover:text-blue-800">Ver Proyecto →</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  `,
  category: 'Plantillas'
},
{
  id: 'template-blog',
  label: 'Blog',
  content: `
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Mi Blog</h1>
          <nav class="space-x-6">
            <a href="#" class="text-gray-600 hover:text-gray-900">Inicio</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Categorías</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Sobre Mí</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
          </nav>
        </div>
      </div>
    </header>

    <!-- Featured Post -->
    <section class="featured-post py-12 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-4xl mx-auto">
          <div class="w-full h-64 bg-gray-300"></div>
          <div class="p-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
              <span>15 Enero, 2024</span>
              <span class="mx-2">•</span>
              <span>Tecnología</span>
              <span class="mx-2">•</span>
              <span>5 min lectura</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Título del Artículo Destacado</h2>
            <p class="text-gray-600 mb-6">Descripción del artículo destacado que captura la atención del lector...</p>
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
              Leer Artículo
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Grid -->
    <section class="blog-grid py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Últimos Artículos</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <div class="text-sm text-gray-500 mb-2">10 Enero, 2024</div>
              <h3 class="text-xl font-semibold mb-2">Título del Artículo</h3>
              <p class="text-gray-600 mb-4">Descripción breve del artículo...</p>
              <button class="text-blue-600 hover:text-blue-800">Leer más →</button>
            </div>
          </article>
          <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <div class="text-sm text-gray-500 mb-2">8 Enero, 2024</div>
              <h3 class="text-xl font-semibold mb-2">Título del Artículo</h3>
              <p class="text-gray-600 mb-4">Descripción breve del artículo...</p>
              <button class="text-blue-600 hover:text-blue-800">Leer más →</button>
            </div>
          </article>
          <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <div class="text-sm text-gray-500 mb-2">5 Enero, 2024</div>
              <h3 class="text-xl font-semibold mb-2">Título del Artículo</h3>
              <p class="text-gray-600 mb-4">Descripción breve del artículo...</p>
              <button class="text-blue-600 hover:text-blue-800">Leer más →</button>
            </div>
          </article>
        </div>
      </div>
    </section>
  `,
  category: 'Plantillas'
},
{
  id: 'template-restaurant',
  label: 'Restaurante',
  content: `
    <!-- Hero -->
    <section class="hero bg-gray-900 text-white py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Restaurante El Sabor</h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Descubre los sabores auténticos de la cocina tradicional</p>
        <button class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
          Reservar Mesa
        </button>
      </div>
    </section>

    <!-- About -->
    <section class="about py-16">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Nuestra Historia</h2>
          <p class="text-lg text-gray-600 mb-8">Con más de 20 años de experiencia, ofrecemos los mejores platos tradicionales preparados con ingredientes frescos y recetas familiares.</p>
          <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="text-3xl font-bold text-orange-600 mb-2">20+</div>
              <div class="text-gray-600">Años de Experiencia</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-orange-600 mb-2">1000+</div>
              <div class="text-gray-600">Clientes Satisfechos</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-orange-600 mb-2">50+</div>
              <div class="text-gray-600">Platos Únicos</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Menu -->
    <section class="menu py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Nuestro Menú</h2>
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Platos Principales</h3>
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Pollo a la Brasa</h4>
                  <p class="text-sm text-gray-600">Pollo marinado con especias</p>
                </div>
                <span class="font-bold text-orange-600">$15.99</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Lomo Saltado</h4>
                  <p class="text-sm text-gray-600">Carne salteada con vegetales</p>
                </div>
                <span class="font-bold text-orange-600">$18.99</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Ceviche Mixto</h4>
                  <p class="text-sm text-gray-600">Pescado fresco con leche de tigre</p>
                </div>
                <span class="font-bold text-orange-600">$16.99</span>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Bebidas</h3>
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Chicha Morada</h4>
                  <p class="text-sm text-gray-600">Bebida tradicional peruana</p>
                </div>
                <span class="font-bold text-orange-600">$3.99</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Pisco Sour</h4>
                  <p class="text-sm text-gray-600">Cóctel nacional</p>
                </div>
                <span class="font-bold text-orange-600">$8.99</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <h4 class="font-medium">Jugo de Maracuyá</h4>
                  <p class="text-sm text-gray-600">Jugo natural</p>
                </div>
                <span class="font-bold text-orange-600">$4.99</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  `,
  category: 'Plantillas'
},
{
  id: 'template-ecommerce',
  label: 'E-commerce',
  content: `
    <!-- Header -->
    <header class="bg-white shadow-sm">
      <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Mi Tienda</h1>
          <div class="flex items-center space-x-6">
            <nav class="space-x-4">
              <a href="#" class="text-gray-600 hover:text-gray-900">Productos</a>
              <a href="#" class="text-gray-600 hover:text-gray-900">Ofertas</a>
              <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
            </nav>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
              🛒 Carrito (0)
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Hero -->
    <section class="hero bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">¡Gran Oferta!</h1>
        <p class="text-xl mb-8">Hasta 50% de descuento en productos seleccionados</p>
        <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
          Ver Ofertas
        </button>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="products py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Productos Destacados</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="font-semibold mb-2">Producto 1</h3>
              <p class="text-gray-600 text-sm mb-2">Descripción del producto</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-blue-600">$29.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                  Agregar
                </button>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="font-semibold mb-2">Producto 2</h3>
              <p class="text-gray-600 text-sm mb-2">Descripción del producto</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-blue-600">$39.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                  Agregar
                </button>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="font-semibold mb-2">Producto 3</h3>
              <p class="text-gray-600 text-sm mb-2">Descripción del producto</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-blue-600">$19.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                  Agregar
                </button>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-4">
              <h3 class="font-semibold mb-2">Producto 4</h3>
              <p class="text-gray-600 text-sm mb-2">Descripción del producto</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-blue-600">$49.99</span>
                <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                  Agregar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter py-12 bg-gray-50">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">¡Mantente Actualizado!</h2>
        <p class="text-gray-600 mb-6">Recibe las mejores ofertas en tu email</p>
        <div class="max-w-md mx-auto flex">
          <input type="email" placeholder="Tu email" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <button class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-blue-700">
            Suscribirse
          </button>
        </div>
      </div>
    </section>
  `,
  category: 'Plantillas'
}
