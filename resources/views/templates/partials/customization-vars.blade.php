{{-- Variables de personalización del tema --}}
@php
    $colors = $customization['colors'] ?? [];
    $fonts = $customization['fonts'] ?? [];
    $layout = $customization['layout'] ?? [];
@endphp

<style>
:root {
    /* Colores */
    --color-primary: {{ $colors['primary'] ?? '#3b82f6' }};
    --color-secondary: {{ $colors['secondary'] ?? '#1f2937' }};
    --color-accent: {{ $colors['accent'] ?? '#10b981' }};
    --color-background: {{ $colors['background'] ?? '#ffffff' }};
    --color-text: {{ $colors['text'] ?? '#111827' }};
    
    /* Fuentes */
    --font-heading: {{ $fonts['heading'] ?? 'Inter, sans-serif' }};
    --font-body: {{ $fonts['body'] ?? 'Inter, sans-serif' }};
    
    /* Layout */
    --container-width: {{ $layout['container_width'] ?? '1200px' }};
}

/* Aplicar variables */
body {
    font-family: var(--font-body);
    color: var(--color-text);
}

h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading);
}

.container {
    max-width: var(--container-width);
}

/* Colores personalizados */
.bg-primary { background-color: var(--color-primary) !important; }
.text-primary { color: var(--color-primary) !important; }
.border-primary { border-color: var(--color-primary) !important; }

.bg-secondary { background-color: var(--color-secondary) !important; }
.text-secondary { color: var(--color-secondary) !important; }

.bg-accent { background-color: var(--color-accent) !important; }
.text-accent { color: var(--color-accent) !important; }
</style>

