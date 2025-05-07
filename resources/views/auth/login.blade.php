<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="d-flex flex-row">
    <x-layouts.login-section.login-left-side imageSrc="{{ asset('images/thirdtriplecircle.png') }}" alt="Ícone Círculo" />
    <x-layouts.login-section.right-side imageSrc="{{ asset('images/thirdtripleline.png') }}" alt="Icone Linha"
        title="Faça seu login!" formMethod="POST" formAction="{{ route('authenticate') }}" firstLabel="E-mail"
        firstType="email" firstPlaceholder="Digite seu e-mail" firstId="email" firstName="email" firstValue=""
        secondLabel="Senha" secondType="password" secondPlaceholder="Digite sua senha" secondId="password"
        secondName="password" secondValue="" button="Entrar" span="Ainda não possui uma conta?"
        linkUrl="{{ route('register') }}" link="Cadastre-se" />
</body>

</html>
