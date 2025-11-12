{{-- Footer Blog --}}
<footer class="bg-gray-50 border-t">
  <div class="container px-6 py-12 mx-auto text-center">
    <p class="text-sm text-gray-600">© {{date('Y')}} {{$website->name??'Blog'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
    <p class="mt-2 text-xs text-gray-500">
      Creado con <a href="https://eme10.com" target="_blank" class="text-blue-500 hover:text-blue-600 transition-colors font-medium">EME10</a> | 
      <a href="https://adminnegocios.com" target="_blank" class="text-blue-500 hover:text-blue-600 transition-colors font-medium">Admin Negocios</a>
    </p>
  </div>
</footer>
