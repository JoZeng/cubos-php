<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="d-flex flex-row">
    <x-layouts.login-section.left-side imageSrc="{{ asset('images/secondtriplecircle.png') }}" alt="Ícone Círculo" />
    <x-layouts.login-section.right-side imageSrc="{{ asset('images/secondtripleline.png') }}" alt="Icone Linha"
        title="Escolha uma senha" formMethod="POST" formAction="{{ route('final.register') }}" firstLabel="Senha*"
        firstType="password" firstPlaceholder="Digite sua senha" firstName="password" firstValue="" firstId="password"
        secondLabel="Repita a senha*" secondType="password" secondPlaceholder="Confirme sua senha"
        secondId="password_confirmation" secondName="password_confirmation" secondValue="" button="Entrar"
        span="Já tem uma conta?" linkUrl="{{ route('login') }}" link="Login" />
</body>

</html>
