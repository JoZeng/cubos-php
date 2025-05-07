<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/clients/clients-content.css', 'resources/js/app.js'])
    <title>Clientes</title>
</head>

<body>
    <div class="clients-content">
        <div class="clients-content-header">
            <div class="clients-content-header-firstsession">
                <img src="{{ asset('images/clients.svg') }}" alt="clients" />
                <div>Clientes</div>
            </div>
            <div class="clients-content-header-secondsession">
                <button class="clients-content-header-secondsession-firstbutton" data-bs-toggle="modal"
                    data-bs-target="#modalClientAdd">
                    + Adicionar cliente
                </button>
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
                    <div>Clientes</div>
                    <div>CPF</div>
                    <div>E-mail</div>
                    <div>Telefone</div>
                    <div>Status</div>
                    <div>Criar Cobrança</div>
                </div>
                <hr class="clients-content-divider" />
                @if ($loading ?? false)
                    <div>Carregando...</div>
                @else
                    @if (isset($clients) && $clients->count() > 0)
                        @foreach ($clients as $cliente)
                            @php
                                // Calcular total de cobranças pendentes e pagas
                                $totalPendente = 0;
                                $totalPago = 0;

                                foreach ($cliente->charges as $charge) {
                                    if ($charge->status == 'pendente') {
                                        $totalPendente += $charge->value;
                                    } elseif ($charge->status == 'paga') {
                                        $totalPago += $charge->value;
                                    }
                                }

                                // Lógica para determinar o status
                                $status = $totalPendente > $totalPago ? 'Inadimplente' : 'Em dia';
                                $statusClass = $status == 'Em dia' ? 'status-inday' : 'status-unpaid';
                            @endphp
                            <div class="clients-content-body-fields-list-values">
                                <div class="clients-content-body-fields-list-values-text-styles">{{ $cliente->name }}
                                </div>
                                <div class="clients-content-body-fields-list-values-text-styles">{{ $cliente->cpf }}
                                </div>
                                <div class="clients-content-body-fields-list-values-text-styles">{{ $cliente->email }}
                                </div>
                                <div class="clients-content-body-fields-list-values-text-styles">{{ $cliente->phone }}
                                </div>
                                <div class="{{ $statusClass }}">{{ $status }}</div>
                                <div>
                                    <img class="cursor-pointer" src="{{ asset('images/iconCharges.svg') }}"
                                        alt="clients" data-bs-toggle="modal" data-bs-target="#modalChargesAdd"
                                        data-client-id="{{ $cliente->id }}"
                                        data-client-name="{{ $cliente->name }}" />
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>Sem clientes cadastrados.</div>
                    @endif
                @endif
                <div class="clients-content-pagination">
                    <a href="{{ route('clients', ['page' => max(($paginaAtual ?? 1) - 1, 1), 'search' => request('search')]) }}"
                        class="pagination-button"
                        style="{{ ($paginaAtual ?? 1) === 1 ? 'pointer-events: none; opacity: 0.5;' : '' }}">
                        Anterior
                    </a>

                    <span>
                        Página {{ $paginaAtual ?? 1 }} de {{ $totalPaginas ?? 1 }}
                    </span>

                    <a href="{{ route('clients', ['page' => min(($paginaAtual ?? 1) + 1, $totalPaginas ?? 1), 'search' => request('search')]) }}"
                        class="pagination-button"
                        style="{{ ($paginaAtual ?? 1) === ($totalPaginas ?? 1) ? 'pointer-events: none; opacity: 0.5;' : '' }}">
                        Próxima
                    </a>
                </div>

            </div>
        </div>
    </div>

    @include('components.modals.modal-clients-add')
    @isset($cliente)
        @include('components.modals.modal-charges-add', ['client' => $cliente])
    @endisset

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('modalChargesAdd');
            const clientIdInput = modal.querySelector('#modal-client-id');
            const clientNameInput = modal.querySelector('#modal-client-name');

            document.querySelectorAll('img[data-bs-target="#modalChargesAdd"]').forEach(button => {
                button.addEventListener('click', function() {
                    const clientId = this.getAttribute('data-client-id');
                    const clientName = this.getAttribute('data-client-name');

                    clientIdInput.value = clientId;
                    clientNameInput.value = clientName;
                });
            });
        });
    </script>
</body>

</html>
