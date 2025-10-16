{{-- Header Blog --}}
<header class="border-b bg-white {{$headerConfig['sticky']??true?'sticky top-0 z-50':''}}">
  <div class="container px-6 py-6 mx-auto text-center">
    <h1 class="text-3xl font-bold" style="font-family:'Lora',serif;">{{$website->name??'Blog'}}</h1>
  </div>
</header>
