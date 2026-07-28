@props([
    'title' => null
])

<div {{ $attributes->merge(['class' => 'card border-0 shadow-sm rounded-3']) }}>
    @if($title || isset($headerActions))
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            @if($title)
                <h5 class="card-title mb-0 fw-bold text-secondary">{{ $title }}</h5>
            @endif
            @if(isset($headerActions))
                <div>{{ $headerActions }}</div>
            @endif
        </div>
    @endif
    <div class="card-body p-4">
        {{ $slot }}
    </div>
</div>