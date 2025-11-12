<div class="preview-block page-header-block" style="text-align: center; padding: 40px 20px; background: #f8f9fa; margin-bottom: 30px; border-radius: 8px;">
    <h2 style="font-size: 2rem; margin-bottom: 15px; color: #333;">{{ $block['title'] ?? 'Título de Página' }}</h2>
    @if(isset($block['subtitle']))
        <h3 style="font-size: 1.3rem; margin-bottom: 15px; color: #666; font-weight: 400;">{{ $block['subtitle'] }}</h3>
    @endif
    @if(isset($block['description']))
        <p style="font-size: 1.1rem; color: #777; max-width: 600px; margin: 0 auto;">{{ $block['description'] }}</p>
    @endif
</div>
