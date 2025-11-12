<div class="preview-block contact-form-block" style="margin-bottom: 30px;">
    <h3 style="margin-bottom: 20px; color: #333;">{{ $block['title'] ?? 'Formulario de Contacto' }}</h3>
    <div style="max-width: 500px; margin: 0 auto;">
        <form style="background: #f8f9fa; padding: 30px; border-radius: 8px;">
            @if(isset($block['fields']))
                @foreach($block['fields'] as $field)
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">
                            {{ ucfirst(str_replace('_', ' ', $field)) }}
                        </label>
                        @if($field === 'message')
                            <textarea style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; resize: vertical;" rows="4" placeholder="Escribe tu mensaje aquí..."></textarea>
                        @else
                            <input type="{{ $field === 'email' ? 'email' : 'text' }}" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ingresa tu {{ str_replace('_', ' ', $field) }}">
                        @endif
                    </div>
                @endforeach
            @endif
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                {{ $block['submit_text'] ?? 'Enviar Mensaje' }}
            </button>
        </form>
    </div>
</div>
