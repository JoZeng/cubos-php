<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/clients/clients-content.css', 'resources/js/app.js'])
    <title>Cobranças</title>
</head>

<div class="clients-content">
    <div class="clients-content-header">
        <div class="clients-content-header-firstsession">
            <img src="{{ asset('images/charges.svg') }}" alt="clients" />
            <div>Cobranças</div>
        </div>
        <div class="clients-content-header-secondsession">
            <form method="GET" action="{{ route('clients') }}">
                <input type="text" name="search" class="clients-content-header-secondsession-input"
                    placeholder="Pesquisa" value="{{ request('search') }}"
                    onkeydown="if(event.key === 'Enter'){ this.form.submit(); }" />
            </form>
        </div>
    </div>
    <div class="clients-content-background-body">
        <div class="clients-content-body-fields">
            <div class="clients-content-body-fields-list">
                <div>Cliente</div>
                <div>ID.Cobrança</div>
                <div>Valor</div>
                <div>Data de vencimento</div>
                <div>Status</div>
                <div>Descrição</div>
                <div></div>
            </div>
            <hr class="clients-content-divider" />
            @if ($loading ?? false)
                <div>Carregando...</div>
            @else
                @if (isset($charges) && $charges->count() > 0)
                    @foreach ($charges as $charge)
                        @php
                            // Lógica para definir a classe de status com base no status calculado
                            $statusClass = '';
                            switch ($charge->calculated_status) {
                                case 'vencida':
                                    $statusClass = 'status-expirated';
                                    break;
                                case 'pendente':
                                    $statusClass = 'status-pending';
                                    break;
                                case 'paga':
                                    $statusClass = 'status-paga';
                                    break;
                                default:
                                    $statusClass = 'status-unknown';
                            }
                        @endphp
                        <div class="clients-content-body-fields-list-values">
                            <div class="clients-content-body-fields-list-values-text-styles">
                                {{ $charge->client->name }} <!-- Nome do cliente -->
                            </div>
                            <div class="clients-content-body-fields-list-values-text-styles">
                                {{ $charge->id }} <!-- ID da cobrança -->
                            </div>
                            <div class="clients-content-body-fields-list-values-text-styles">
                                R$ {{ number_format($charge->value, 2, ',', '.') }} <!-- Valor da cobrança -->
                            </div>
                            <div class="clients-content-body-fields-list-values-text-styles">
                                {{ \Carbon\Carbon::parse($charge->expiration)->format('d/m/Y') }}
                                <!-- Data de vencimento -->
                            </div>
                            <div class="clients-content-body-fields-list-values-text-styles {{ $statusClass }}">
                                {{ ucfirst($charge->calculated_status) }}
                            </div>
                            <div class="clients-content-body-fields-list-values-text-styles">
                                {{ $charge->description }} <!-- Descrição da cobrança -->
                            </div>
                            <div class="d-flex justify-content-evenly cursor-pointer">
                                <img src="{{ asset('images/iconEdit.svg') }}" alt="iconEdit" data-bs-toggle="modal"
                                    data-bs-target="#modalChargesEdit" data-client-id="{{ $charge->id }}"
                                    data-client-name="{{ $charge->client->name }}">
                                <img src="{{ asset('images/iconDelete.svg') }}" alt="iconDelete" data-bs-toggle="modal"
                                    data-bs-target="#modalChargesDelete" data-charge-id="{{ $charge->id }}">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>Sem clientes cadastrados.</div>
                @endif
            @endif
            <div class="clients-content-pagination">
                <a href="{{ route('charges', ['page' => max(($paginaAtual ?? 1) - 1, 1), 'search' => request('search')]) }}"
                    class="pagination-button"
                    style="{{ ($paginaAtual ?? 1) === 1 ? 'pointer-events: none; opacity: 0.5;' : '' }}">
                    Anterior
                </a>

                <span>
                    Página {{ $paginaAtual ?? 1 }} de {{ $totalPaginas ?? 1 }}
                </span>

                <a href="{{ route('charges', ['page' => min(($paginaAtual ?? 1) + 1, $totalPaginas ?? 1), 'search' => request('search')]) }}"
                    class="pagination-button"
                    style="{{ ($paginaAtual ?? 1) === ($totalPaginas ?? 1) ? 'pointer-events: none; opacity: 0.5;' : '' }}">
                    Próxima
                </a>
            </div>


        </div>
    </div>
</div>

@include('components.modals.modal-charges-delete')
@include('components.modals.modal-charges-edit', ['client' => $charge->client])

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalEdit = document.getElementById('modalChargesEdit');
        const clientIdInputEdit = modalEdit.querySelector('#modal-client-id');
        const clientNameInput = modalEdit.querySelector('#modal-client-name');
        const formEdit = modalEdit.querySelector('form');

        document.querySelectorAll('img[data-bs-target="#modalChargesEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const chargeId = this.getAttribute('data-client-id');
                const clientName = this.getAttribute('data-client-name');

                clientIdInputEdit.value = chargeId;
                clientNameInput.value = clientName;

                formEdit.action =
                `/charges/${chargeId}`; // Atualiza a rota do formulário dinamicamente
            });
        });
    });
</script>


</html>
