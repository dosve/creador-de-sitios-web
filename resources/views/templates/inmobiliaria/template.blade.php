<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{$website->name??'Inmobiliaria'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif
    }

    .font-heading {
      font-family: 'Montserrat', sans-serif
    }

    .container {
      max-width: {
          {
          $customization['layout']['container_width']??'1400px'
        }
      }
    }

  </style>
</head>
<body class="bg-teal-50">@include('templates.inmobiliaria.header')
  <section class="relative h-[600px] bg-gradient-to-br from-teal-700 to-teal-900 text-white flex items-center">
    <div class="container px-6 mx-auto text-center">
      <h1 class="font-heading text-5xl md:text-6xl font-bold mb-6">Encuentra Tu Hogar Ideal</h1>
      <p class="text-2xl text-teal-100 mb-12">Miles de propiedades disponibles</p>
      <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-xl">
        <div class="grid md:grid-cols-4 gap-4"><input type="text" placeholder="Ubicación" class="px-4 py-3 border rounded-lg text-gray-900"><select class="px-4 py-3 border rounded-lg text-gray-900">
            <option>Tipo</option>
            <option>Casa</option>
            <option>Apartamento</option>
          </select><select class="px-4 py-3 border rounded-lg text-gray-900">
            <option>Precio</option>
          </select><button class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-bold">Buscar</button></div>
      </div>
    </div>
  </section>
  <section class="py-20 bg-white" data-products-source="api" data-dynamic-products="true">
    <div class="container px-6 mx-auto">
      <h2 class="font-heading text-4xl font-bold mb-12 text-center">Propiedades Destacadas</h2>
      <div class="grid md:grid-cols-3 gap-8" id="products-container">@for($i=0;$i<6;$i++)<div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-xl transition-shadow">
          <div class="h-56 bg-teal-200 flex items-center justify-center"><svg class="w-20 h-20 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg></div>
          <div class="p-6">
            <div class="flex items-center justify-between mb-2"><span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold rounded-full">EN VENTA</span><span class="text-2xl font-bold text-teal-700">${{200+$i*50}}K</span></div>
            <h3 class="font-heading text-xl font-bold mb-2">Propiedad {{$i+1}}</h3>
            <p class="text-sm text-gray-600 mb-4">3 hab • 2 baños • 120 m²</p><button class="w-full py-3 border-2 border-teal-600 text-teal-600 rounded-lg hover:bg-teal-600 hover:text-white transition-colors font-bold add-to-cart" data-name="Propiedad {{$i+1}}" data-price="{{200+$i*50}}000">Ver Detalles</button>
          </div>
      </div>@endfor
    </div>
    </div>
  </section>
  @include('templates.inmobiliaria.footer')@include('templates.partials.cart-script')@include('templates.partials.products-script')
</body>
</html>
