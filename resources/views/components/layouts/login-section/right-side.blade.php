<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/login-section/right-side.css', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex justify-content-center login-section-rightside-width login-section-rightside-padding-content ">
        <div class="d-flex flex-column login-section-rightside-content-width">
            <p class="text-align: center gap-3 text-align-center">{{ $title }}</p>

            <form class="login-section-rightside-form" method="{{ $formMethod }}" action="{{ $formAction }}">
                @csrf
                <div>
                    <label>{{ $firstLabel }}</label>
                    <input type="{{ $firstType }}" class="form-control" placeholder="{{ $firstPlaceholder }}"
                        id="{{ $firstId }}" name="{{ $firstName }}" value="{{ $firstValue }}">
                </div>
                <div>
                    <label>{{ $secondLabel }}</label>
                    <input type="{{ $secondType }}" class="form-control" placeholder="{{ $secondPlaceholder }}"
                        id="{{ $secondId }}" name="{{ $secondName }}" value="{{ $secondValue }}">
                </div>
                <button class="login-section-rightside-content-width-button"
                    type="submit">{{ $button }}</button>
            </form>

            <span class="pt-3">{{ $span }} <a href="{{ $linkUrl }}">{{ $link }}</a></span>
            <div class="image-container">
                <img src="{{ $imageSrc }}" alt="{{ $imageAlt ?? 'Imagem' }}">
            </div>
        </div>
    </div>
</body>

</html>
