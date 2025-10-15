@php
  $block = view('components.test.button')->render();
@endphp
{
  id: 'test-button'
  , label: 'Botón de Prueba'
  , attributes: {
    class: 'gjs-block-test'
  }
  , content: {!! json_encode($block) !!}
}
