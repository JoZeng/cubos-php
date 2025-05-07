<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/login-section/left-side.css', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex justify-content-center flex-row gap-3 login-section-leftside-width login-section-leftside-padding-content"
        style="background-image: url('/images/loginleftimage.png'); background-size: cover; background-position: center;">
        <h3 class="d-flex" style="text-align: center;">Gerencie todos os pagamentos<br>da sua empresa em um só<br>lugar
        </h3>
    </div>
</body>

</html>
