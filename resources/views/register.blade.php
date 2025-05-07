<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="d-flex flex-row">
    <x-layouts.login-section.left-side imageSrc="{{ asset('images/firsttriplecircle.png') }}" alt="Ícone Círculo" />
    <x-layouts.login-section.right-side imageSrc="{{ asset('images/firsttripleline.png') }}" alt="Icone Linha"
        title="Adicione seus dados" formMethod="POST" formAction="{{ route('store.user') }}" firstLabel="Nome*"
        firstType="text" firstPlaceholder="Digite seu nome" firstId="name" firstName="name"
        firstValue="{{ old('name') }}" secondLabel="E-mail*" secondType="email" secondPlaceholder="Digite seu e-mail"
        secondId="email" secondName="email" secondValue="{{ old('email') }}" button="Continuar"
        span="Já tem uma conta?" linkUrl="{{ route('login') }}" link="Login" />

</html>
