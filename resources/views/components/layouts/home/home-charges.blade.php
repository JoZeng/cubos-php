<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/home/home-charges.css', 'resources/js/app.js'])
</head>


<div class="home-charges-modal">
    <div class="home-charges-paid">
        <div class="home-charges-cards">
            <img src={{ asset('images/Icon-paga.png') }} alt="iconpaid" />
            <div class="home-charges-cards-textvalue">
                <span>Cobranças Pagas</span>
                <span>R$ {{ number_format($totalPago, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="home-charges-out-of-date">
        <div class="home-charges-cards">
            <img src={{ asset('images/Icon-vencida.png') }} alt="iconoutofdate" />
            <div class="home-charges-cards-textvalue">
                <span>Cobranças Vencidas</span>
                <span>R$ {{ number_format($totalVencidas, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="home-charges-planned">
        <div class="home-charges-cards">
            <img src={{ asset('images/Icon-prevista.png') }} alt="iconplanned" />
            <div class="home-charges-cards-textvalue">
                <span>Cobranças Previstas</span>
                <span>R$ {{ number_format($totalPrevista, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
