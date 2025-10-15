<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name ?? 'Vista Previa' }} - Sin Plantilla</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: #3b82f6;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .logo-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }
        
        .nav {
            display: none;
            gap: 1.5rem;
        }
        
        .nav a {
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .nav a:hover {
            color: #3b82f6;
        }
        
        .mobile-menu-btn {
            display: block;
            padding: 0.5rem;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .main-content {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .no-template-card {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        
        .no-template-icon {
            width: 6rem;
            height: 6rem;
            background: #fef3c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #f59e0b;
            font-size: 2rem;
        }
        
        .no-template-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }
        
        .no-template-description {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        
        .template-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        
        .footer {
            background: #1f2937;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .footer-section h4 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-section p,
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .footer-section a:hover {
            color: white;
        }
        
        .preview-banner {
            background: #fef3c7;
            border-bottom: 1px solid #f59e0b;
            padding: 0.5rem 0;
            text-align: center;
            font-size: 0.875rem;
            color: #92400e;
        }
        
        @media (min-width: 768px) {
            .nav {
                display: flex;
            }
            
            .mobile-menu-btn {
                display: none;
            }
            
            .template-actions {
                flex-direction: row;
            }
            
            .footer-content {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Banner de Vista Previa -->
    <div class="preview-banner">
        <i class="fas fa-eye"></i> Vista Previa - {{ $website->name ?? 'Mi Sitio Web' }}
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="logo-text">{{ $website->name ?? 'Mi Sitio Web' }}</div>
                </div>
                
                <!-- Navegación -->
                <nav class="nav">
                    @if($menus->where('location', 'header')->first())
                        @foreach($menus->where('location', 'header')->first()->items as $item)
                            <a href="{{ $item->final_url }}" target="{{ $item->target }}">
                                @if($item->icon){{ $item->icon }} @endif
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @else
                        <a href="/">Inicio</a>
                        <a href="/productos">Productos</a>
                        <a href="/contacto">Contacto</a>
                    @endif
                </nav>
                
                <!-- Botón móvil -->
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <div class="container">
            <div class="no-template-card">
                <div class="no-template-icon">
                    <i class="fas fa-palette"></i>
                </div>
                
                <h1 class="no-template-title">¡Selecciona una Plantilla!</h1>
                
                <p class="no-template-description">
                    Tu sitio web está listo, pero necesitas seleccionar una plantilla para darle estilo y personalidad. 
                    Las plantillas incluyen diseños profesionales, colores, fuentes y layouts responsivos.
                </p>
                
                <div class="template-actions">
                    <a href="{{ route('creator.templates.index') }}" class="btn btn-primary">
                        <i class="fas fa-palette"></i>
                        Ver Plantillas Disponibles
                    </a>
                    
                    <a href="{{ route('creator.menus.index') }}" class="btn btn-secondary">
                        <i class="fas fa-bars"></i>
                        Configurar Menús
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Información del sitio -->
                <div class="footer-section">
                    <h4>{{ $website->name ?? 'Mi Sitio Web' }}</h4>
                    <p>{{ $website->description ?? 'Descripción de mi sitio web' }}</p>
                </div>
                
                <!-- Enlaces rápidos -->
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    @if($menus->where('location', 'footer')->first())
                        @foreach($menus->where('location', 'footer')->first()->items as $item)
                            <a href="{{ $item->final_url }}" target="{{ $item->target }}">
                                @if($item->icon){{ $item->icon }} @endif
                                {{ $item->title }}
                            </a>
                        @endforeach
                    @else
                        <a href="/">Inicio</a>
                        <a href="/productos">Productos</a>
                        <a href="/contacto">Contacto</a>
                    @endif
                </div>
                
                <!-- Información de contacto -->
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <p><i class="fas fa-envelope"></i> contacto@misitio.com</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-map-marker-alt"></i> Ciudad, País</p>
                </div>
            </div>
            
            <!-- Copyright -->
            <div style="border-top: 1px solid #374151; margin-top: 2rem; padding-top: 2rem; text-align: center; color: #9ca3af; font-size: 0.875rem;">
                <p>&copy; {{ date('Y') }} {{ $website->name ?? 'Mi Sitio Web' }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
