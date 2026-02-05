<?php

/**
 * Catálogo de componentes/widgets del editor (GrapesJS).
 * Usado por la IA para planificar páginas (contenedores + widgets con su información).
 * Debe coincidir con los bloques incluidos en resources/views/creator/blocks/all.blade.php
 */
return [
    /** URL de imagen por defecto cuando no se especifica (placeholders) */
    'default_placeholder_image' => env('EDITOR_DEFAULT_PLACEHOLDER_IMAGE', 'https://placehold.co/800x400?text=Imagen'),

    'categories' => [
        'Diseño' => 'Contenedores, separadores, espaciadores, pestañas, acordeones.',
        'Básicos' => 'Texto, títulos, párrafos, imágenes, botones, enlaces, listas, iconos.',
        'Multimedia' => 'Vídeo, galería, audio, carrusel, imagen avanzada.',
        'Navegación' => 'Pestañas, acordeón.',
        'Redes Sociales' => 'Embeds de Twitter, Instagram, Facebook, Spotify, TikTok, Google Maps.',
        'Avanzados' => 'Formulario dinámico, listado de blog, listado de productos, contador animado, código HTML.',
    ],

    'blocks' => [
        // wordpress-layout
        ['id' => 'separator', 'label' => 'Separador', 'category' => 'Diseño', 'description' => 'Línea divisoria entre secciones'],
        ['id' => 'spacer', 'label' => 'Espaciador', 'category' => 'Diseño', 'description' => 'Espacio vertical configurable'],
        // basic
        ['id' => 'simple-container', 'label' => 'Contenedor', 'category' => 'Diseño', 'description' => 'Contenedor flexible para agrupar elementos'],
        ['id' => 'text', 'label' => 'Texto', 'category' => 'Básicos', 'description' => 'Bloque de texto editable'],
        ['id' => 'heading', 'label' => 'Título', 'category' => 'Básicos', 'description' => 'Título (H1-H6) con estilos'],
        ['id' => 'paragraph', 'label' => 'Párrafo', 'category' => 'Básicos', 'description' => 'Párrafo con formato'],
        ['id' => 'image', 'label' => 'Imagen', 'category' => 'Básicos', 'description' => 'Imagen con URL y alt'],
        ['id' => 'button', 'label' => 'Botón', 'category' => 'Básicos', 'description' => 'Botón o enlace CTA'],
        ['id' => 'link', 'label' => 'Enlace', 'category' => 'Básicos', 'description' => 'Enlace de texto'],
        ['id' => 'unordered-list', 'label' => 'Lista no ordenada', 'category' => 'Básicos', 'description' => 'Lista con viñetas'],
        ['id' => 'ordered-list', 'label' => 'Lista ordenada', 'category' => 'Básicos', 'description' => 'Lista numerada'],
        // icons
        ['id' => 'icon', 'label' => 'Icono', 'category' => 'Básicos', 'description' => 'Icono Heroicons'],
        ['id' => 'icon-box', 'label' => 'Caja de Icono', 'category' => 'Básicos', 'description' => 'Icono + título + descripción'],
        ['id' => 'icon-list', 'label' => 'Lista con Iconos', 'category' => 'Básicos', 'description' => 'Lista de ítems con icono'],
        // utilities
        ['id' => 'html-code', 'label' => 'Código HTML', 'category' => 'Avanzados', 'description' => 'Bloque de HTML personalizado'],
        ['id' => 'alert', 'label' => 'Alerta', 'category' => 'Básicos', 'description' => 'Mensaje de aviso o notificación'],
        ['id' => 'toggle', 'label' => 'Toggle', 'category' => 'Diseño', 'description' => 'Contenido expandible/colapsable'],
        ['id' => 'star-rating', 'label' => 'Calificación con Estrellas', 'category' => 'Básicos', 'description' => 'Valoración en estrellas'],
        ['id' => 'blockquote', 'label' => 'Cita / Quote', 'category' => 'Básicos', 'description' => 'Cita o testimonio destacado'],
        // multimedia
        ['id' => 'video', 'label' => 'Video', 'category' => 'Multimedia', 'description' => 'Reproductor de video'],
        ['id' => 'gallery', 'label' => 'Galería', 'category' => 'Multimedia', 'description' => 'Galería de imágenes'],
        ['id' => 'audio', 'label' => 'Reproductor de Audio', 'category' => 'Multimedia', 'description' => 'Reproductor de audio'],
        ['id' => 'carousel', 'label' => 'Carrusel', 'category' => 'Multimedia', 'description' => 'Carrusel de contenido'],
        ['id' => 'counter-animated', 'label' => 'Contador Animado', 'category' => 'Avanzados', 'description' => 'Número con animación'],
        ['id' => 'image-box-advanced', 'label' => 'Caja de Imagen Avanzada', 'category' => 'Multimedia', 'description' => 'Imagen con overlay y texto'],
        ['id' => 'file', 'label' => 'Archivo', 'category' => 'Multimedia', 'description' => 'Enlace de descarga de archivo'],
        ['id' => 'background-image', 'label' => 'Imagen de Fondo', 'category' => 'Multimedia', 'description' => 'Sección con imagen de fondo'],
        ['id' => 'background-color', 'label' => 'Color de Fondo', 'category' => 'Multimedia', 'description' => 'Sección con color de fondo'],
        // form
        ['id' => 'form-dynamic', 'label' => 'Formulario', 'category' => 'Avanzados', 'description' => 'Formulario de contacto o personalizado'],
        // navigation
        ['id' => 'tabs', 'label' => 'Pestañas', 'category' => 'Diseño', 'description' => 'Contenido en pestañas'],
        ['id' => 'accordion', 'label' => 'Acordeón', 'category' => 'Diseño', 'description' => 'Acordeón expandible'],
        // wordpress-basic
        ['id' => 'code', 'label' => 'Código', 'category' => 'Básicos', 'description' => 'Bloque de código'],
        ['id' => 'preformatted', 'label' => 'Preformateado', 'category' => 'Básicos', 'description' => 'Texto con formato fijo'],
        ['id' => 'verse', 'label' => 'Verso', 'category' => 'Básicos', 'description' => 'Texto tipo poesía o verso'],
        // wordpress-embed
        ['id' => 'google-maps', 'label' => 'Google Maps', 'category' => 'Redes Sociales', 'description' => 'Mapa embebido'],
        ['id' => 'twitter-embed', 'label' => 'Twitter', 'category' => 'Redes Sociales', 'description' => 'Tweet embebido'],
        ['id' => 'instagram-embed', 'label' => 'Instagram', 'category' => 'Redes Sociales', 'description' => 'Post de Instagram'],
        ['id' => 'facebook-embed', 'label' => 'Facebook', 'category' => 'Redes Sociales', 'description' => 'Contenido de Facebook'],
        ['id' => 'spotify-embed', 'label' => 'Spotify', 'category' => 'Redes Sociales', 'description' => 'Reproductor Spotify'],
        ['id' => 'soundcloud-embed', 'label' => 'SoundCloud', 'category' => 'Redes Sociales', 'description' => 'Audio SoundCloud'],
        ['id' => 'tiktok-embed', 'label' => 'TikTok', 'category' => 'Redes Sociales', 'description' => 'Video de TikTok'],
        // tienda
        ['id' => 'products-list-dynamic', 'label' => 'Listado de Productos', 'category' => 'Avanzados', 'description' => 'Grid de productos de la tienda'],
        // blog
        ['id' => 'blog-posts-list-dynamic', 'label' => 'Listado de Posts', 'category' => 'Avanzados', 'description' => 'Listado dinámico de entradas del blog'],
    ],
];
