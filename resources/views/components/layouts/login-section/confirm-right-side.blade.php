<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/login-section/right-side.css', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex justify-content-center login-section-rightside-width login-section-rightside-padding-content ">
        <div class="d-flex flex-column login-section-rightside-content-width width-600px">
            <img src='images/confirmimage.png' alt="confirmimage">
            <div class="image-container">
                <img src="{{ $imageSrc }}" alt="{{ $imageAlt ?? 'Imagem' }}">
            </div>
            <a href="/login"><button>Ir para Login</button></a>
        </div>
    </div>
</body>

</html>
