<div class="preview-block contact-info-block" style="margin-bottom: 30px;">
    <h3 style="margin-bottom: 20px; color: #333;">{{ $block['title'] ?? 'Información de Contacto' }}</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        @if(isset($block['email']))
            <div style="text-align: center; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; background: white;">
                <i class="fas fa-envelope fa-2x" style="color: #007bff; margin-bottom: 10px;"></i>
                <h5 style="margin-bottom: 5px; color: #333;">Email</h5>
                <p style="color: #666; margin: 0;">{{ $block['email'] }}</p>
            </div>
        @endif
        @if(isset($block['phone']))
            <div style="text-align: center; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; background: white;">
                <i class="fas fa-phone fa-2x" style="color: #28a745; margin-bottom: 10px;"></i>
                <h5 style="margin-bottom: 5px; color: #333;">Teléfono</h5>
                <p style="color: #666; margin: 0;">{{ $block['phone'] }}</p>
            </div>
        @endif
        @if(isset($block['address']))
            <div style="text-align: center; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; background: white;">
                <i class="fas fa-map-marker-alt fa-2x" style="color: #dc3545; margin-bottom: 10px;"></i>
                <h5 style="margin-bottom: 5px; color: #333;">Dirección</h5>
                <p style="color: #666; margin: 0;">{{ $block['address'] }}</p>
            </div>
        @endif
        @if(isset($block['hours']))
            <div style="text-align: center; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; background: white;">
                <i class="fas fa-clock fa-2x" style="color: #ffc107; margin-bottom: 10px;"></i>
                <h5 style="margin-bottom: 5px; color: #333;">Horarios</h5>
                <p style="color: #666; margin: 0;">{!! $block['hours'] !!}</p>
            </div>
        @endif
    </div>
</div>
