<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/layouts/clients/clients-details-content.css', 'resources/js/app.js'])
    <title>Cliente: {{ $client->name }}</title>
</head>

<body>
    <div class="client-details-content">
        <div class="client-details-content-header">
            <img src="{{ asset('images/clients.svg') }}" alt="clients" />
            <span class="client-details-name">{{ $client->name }}</span>
        </div>

        <div class="client-details-content-main">
            <div class="client-details-data">
                <div class="client-details-data-header">
                    <p>Dados do cliente</p>
                    <button data-bs-toggle="modal" data-client-id="{{ $client->id }}"
                        data-client-name="{{ $client->name }}" data-bs-target="#modalClientEdit">Editar
                        Cliente</button>
                </div>
            </div>

            <div class="client-details-data-grid">
                <div class="client-details-data-grid-minor">
                    <p>E-mail</p>
                    <span>{{ $client->email }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>Telefone</p>
                    <span>{{ $client->phone }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>CPF</p>
                    <span>{{ $client->cpf }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>Endereço</p>
                    <span>{{ $client->address }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>Bairro</p>
                    <span>{{ $client->neighborhood }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>Complemento</p>
                    <span>{{ $client->complement }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>CEP</p>
                    <span>{{ $client->cep }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>Cidade</p>
                    <span>{{ $client->city }}</span>
                </div>
                <div class="client-details-data-grid-minor">
                    <p>UF</p>
                    <span>{{ $client->state }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="client-details-content">
        <div class="client-details-content-main">
            <div class="client-details-charges">
                <div class="client-details-charges-header">
                    <p>Cobranças do Cliente</p>
                </div>
            </div>

            <div class="client-details-table">
                <div class="client-details-table-header">
                    <span>ID</span>
                    <span>Vencimento</span>
                    <span>Valor</span>
                    <span>Status</span>
                    <span>Descrição</span>
                    <span></span>
                </div>

                @foreach ($charges as $charge)
                    @php
                        $statusClasses = [
                            'vencida' => 'client-details-charges-outofdate',
                            'pendente' => 'client-details-charges-pending',
                            'paga' => 'client-details-charges-paid',
                        ];

                        $status = strtolower($charge->calculated_status ?? 'desconhecido');
                        $statusClass = $statusClasses[$status] ?? 'client-details-charges-unknown';
                    @endphp

                    <div class="client-details-table-row">
                        <span>{{ $charge->id }}</span>
                        <span>{{ $charge->expiration }}</span>
                        <span>{{ $charge->value }}</span>

                        <span class="{{ $statusClass }}">
                            {{ ucfirst($status) }}
                        </span>

                        <span>{{ $charge->description }}</span>
                        <div class="d-flex flex-row gap-4">
                            <img src="{{ asset('images/iconEdit.svg') }}" alt="Editar" data-bs-toggle="modal"
                                data-client-id="{{ $charge->id }}" data-client-name="{{ $charge->client->name }}"
                                data-bs-target="#modalChargesEdit" />
                            <img src="{{ asset('images/iconDelete.svg') }}" alt="Deletar" data-bs-toggle="modal"
                                data-bs-target="#modalChargesDelete" />
                        </div>
                    </div>
                    @include('components.modals.modal-charges-edit', ['client' => $charge->client])
                    @include('components.modals.modal-charges-delete')
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalEdit = document.getElementById('modalChargesEdit');
        const formEdit = modalEdit.querySelector('form');
        const clientIdInputEdit = modalEdit.querySelector('#modal-client-id');
        const clientNameInput = modalEdit.querySelector('#modal-client-name');

        // Rota corrigida
        const updateRouteTemplate = "{{ route('updateCharges', ['id' => '__ID__']) }}";
        const updateRouteTemplateDelete = "{{ route('updateCharges', ['id' => '__ID__']) }}";

        document.querySelectorAll('img[data-bs-target="#modalChargesEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const chargeId = this.getAttribute('data-client-id');
                const clientName = this.getAttribute('data-client-name');

                clientIdInputEdit.value = chargeId;
                clientNameInput.value = clientName;

                // Substitui __ID__ pelo chargeId
                formEdit.action = updateRouteTemplate.replace('__ID__', chargeId);
            });
        });
    });
</script>
