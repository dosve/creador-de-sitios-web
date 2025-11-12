{{-- Incluir SOLO los bloques de Elementor --}}

{{-- WIDGETS BÁSICOS DE ELEMENTOR --}}
@include('creator.blocks.basic')
,
@include('creator.blocks.icons')
,
@include('creator.blocks.utilities')
,

{{-- WIDGETS DE MULTIMEDIA DE ELEMENTOR --}}
@include('creator.blocks.multimedia')
,
@include('creator.blocks.multimedia-advanced')
,

{{-- WIDGETS DE FORMULARIOS DE ELEMENTOR --}}
@include('creator.blocks.forms-auth')
,
@include('creator.blocks.forms-search')
,

{{-- WIDGETS DE NAVEGACIÓN DE ELEMENTOR --}}
@include('creator.blocks.navigation')
,

{{-- WIDGETS DE SOCIAL DE ELEMENTOR --}}
@include('creator.blocks.social')
,

{{-- WIDGETS DE WORDPRESS DE ELEMENTOR --}}
@include('creator.blocks.wordpress-basic')
,
@include('creator.blocks.wordpress-media')
,
@include('creator.blocks.wordpress-layout')
,
@include('creator.blocks.wordpress-widgets')
,
@include('creator.blocks.wordpress-embed')
,
@include('creator.blocks.wordpress-forms')
,

{{-- ============================================
    🛍️ WIDGETS DE TIENDA / E-COMMERCE
    Widgets personalizados para tiendas online
============================================ --}}
@include('creator.blocks.tienda')
,

{{-- ============================================
    BLOQUES ÚNICOS DE EME10 (COMENTADOS)
    Descomenta si necesitas estos bloques
============================================ --}}

{{-- @include('creator.blocks.columns') --}}
{{-- @include('creator.blocks.layout') --}}
{{-- @include('creator.blocks.forms') --}}
{{-- @include('creator.blocks.pricing') --}}
{{-- @include('creator.blocks.products') --}}
{{-- @include('creator.blocks.test') --}}
{{-- @include('creator.blocks.footer') --}}
{{-- @include('creator.blocks.ecommerce') --}}
{{-- @include('creator.blocks.blog') --}}
{{-- @include('creator.blocks.advanced') --}}
{{-- @include('creator.blocks.templates') --}}
,
