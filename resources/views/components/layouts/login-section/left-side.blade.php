<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/login-section/left-side.css', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex flex-row gap-3 login-section-leftside-width login-section-leftside-padding-content ">
        <div>
            <img src="{{ $imageSrc }}" alt="{{ $imageAlt ?? 'Imagem' }}">
        </div>
        <div class="d-flex flex-column gap-2 login-section-">
            <div>
                <p class="login-section-leftside-text-green">Cadastre-se</p>
                <span>Por favor, escreva seu nome e e-mail</span>
            </div>
            <div>
                <p class="login-section-leftside-text-green">Escolha uma senha</p>
                <span>Escolha uma senha segura</span>
            </div>
            <div>
                <p class="login-section-leftside-text-green">Cadastro realizado com sucesso</p>
                <span>E-mail e senha cadastrados com sucesso</span>
            </div>
        </div>
    </div>
</body>

</html>
