<div class="preview-block product-grid-block" style="margin-bottom: 30px;">
    <h3 style="margin-bottom: 20px; color: #333;">{{ $block['title'] ?? 'Productos' }}</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        @for($i = 1; $i <= 6; $i++)
            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background: white;">
                <div style="height: 150px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #666;">
                    <i class="fas fa-image fa-2x"></i>
                </div>
                <div style="padding: 15px;">
                    <h5 style="margin-bottom: 8px; color: #333;">Producto {{ $i }}</h5>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">Descripción del producto</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: bold; color: #007bff;">$99.99</span>
                        <button class="btn btn-sm btn-primary">Ver</button>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    @if(isset($block['filters']))
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <small style="color: #666;">Filtros disponibles: {{ implode(', ', $block['filters']) }}</small>
        </div>
    @endif
</div>
