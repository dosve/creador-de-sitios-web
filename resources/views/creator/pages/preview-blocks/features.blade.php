<div class="preview-block features-block" style="margin-bottom: 30px;">
    @if(isset($block['title']))
        <h3 style="text-align: center; margin-bottom: 30px; color: #333;">{{ $block['title'] }}</h3>
    @endif
    @if(isset($block['items']))
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            @foreach($block['items'] as $item)
                <div style="text-align: center; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; background: white;">
                    <div style="width: 60px; height: 60px; background: #007bff; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-{{ $item['icon'] ?? 'star' }}"></i>
                    </div>
                    <h4 style="margin-bottom: 10px; color: #333;">{{ $item['title'] ?? 'Característica' }}</h4>
                    <p style="color: #666; margin: 0;">{{ $item['description'] ?? 'Descripción de la característica' }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
