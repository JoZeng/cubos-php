<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/home/home-files.css', 'resources/js/app.js'])
</head>
<div class="file-charges-content">
    <div class="file-title-card">
        <p>{{ $title }}</p>
        <span>{{ $numbercount }}</span>
    </div>
    <hr class="file-divider" />
    <div class="file-subtitles-card">
        <div>{{ $clients }}</div>
        <div>{{ $idcharges }}</div>
        <div>{{ $valuecharges }}</div>
    </div>
    <hr class="file-divider" />
    @if (is_array($names))
        @foreach ($names as $index => $name)
            <div class="file-value-card">
                <div class="file-itemlist-clientsname">{{ $name }}</div>
                <div class="file-itemlist-idcharges">{{ $ids[$index] }}</div>
                <div class="file-itemlist-value">{{ $valuesOrCpfs[$index] }}</div>
            </div>
        @endforeach
    @endif
    <div class="file-button-card">
        <span>Ver todos</span>
    </div>
</div>
