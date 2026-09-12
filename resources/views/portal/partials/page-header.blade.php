<div class="gs-page-header">
    <div><p class="gs-eyebrow">{{ ucfirst($portal) }} portal / {{ $section }}</p><h1>{{ $heading }}</h1><p>{{ $description }}</p></div>
    @isset($backUrl)<a class="gs-btn" href="{{ $backUrl }}">← {{ $backLabel ?? 'Back' }}</a>@endisset
</div>
