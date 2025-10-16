{{-- Footer Blog --}}
<footer class="bg-gray-50 border-t">
  <div class="container px-6 py-12 mx-auto text-center">
    <p class="text-sm text-gray-600">© {{date('Y')}} {{$website->name??'Blog'}}. {{$footerConfig['copyright_text']??'Todos los derechos reservados.'}}</p>
  </div>
</footer>
