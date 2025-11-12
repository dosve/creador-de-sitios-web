<section class="py-20 border-b border-gray-200 relative overflow-hidden">
    @if(!empty($image))
        <div class="absolute inset-0">
            <img src="{{ $image }}" alt="Header" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/70"></div>
        </div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            @if(!empty($badge))
                <span class="inline-block text-xs tracking-wider text-gray-500 mb-4">{{ $badge }}</span>
            @endif
            <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 mb-4">{{ $title ?? 'Título' }}</h1>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
