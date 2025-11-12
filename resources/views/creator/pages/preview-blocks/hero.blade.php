<div class="preview-block hero-block" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 20px; text-align: center; margin-bottom: 30px; border-radius: 8px;">
    <h1 style="font-size: 2.5rem; margin-bottom: 20px; font-weight: 700;">{{ $block['title'] ?? 'Título del Hero' }}</h1>
    @if(isset($block['subtitle']))
        <p style="font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9;">{{ $block['subtitle'] }}</p>
    @endif
    @if(isset($block['cta_text']))
        <div style="margin-top: 30px;">
            <button class="btn btn-light btn-lg" style="margin: 5px;">
                {{ $block['cta_text'] }}
            </button>
            @if(isset($block['cta_secondary_text']))
                <button class="btn btn-outline-light btn-lg" style="margin: 5px;">
                    {{ $block['cta_secondary_text'] }}
                </button>
            @endif
        </div>
    @endif
</div>
