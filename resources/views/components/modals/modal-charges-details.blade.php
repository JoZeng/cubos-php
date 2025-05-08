@vite(['resources/css/modal.css'])

<div class="modal fade" id="modalChargesDetails" tabindex="-1" aria-labelledby="modalChargesDetailsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex flex-column justify-content-center rounded-lg">
            <div class="modal-header d-flex ">
                <div class="d-flex flex-column justify-content-center ">
                    <h5 class="modal-title text-center modal-text-padding" id="modalChargesDetailsLabel">
                        {{ $headerModalText ?? 'Detalhe da cobrança' }}
                    </h5>
                </div>
            </div>
            <div class="d-flex flex-column align-items-start w-100 px-4 pt-3">
                <p>Nome</p>
                <span id="modal-client-name" class="pb-3"></span>
                <p>Descrição</p>
                <span id="modal-description" class="pb-3"></span>
                <div class="d-flex w-100 pb-3">
                    <div class="w-50 d-flex flex-column align-items-start">
                        <p>Vencimento</p>
                        <span id="modal-expiration"></span>
                    </div>
                    <div class="w-50 d-flex flex-column align-items-start">
                        <p>Valor</p>
                        <span id="modal-value"></span>
                    </div>
                </div>
                <div class="d-flex w-100 pb-3">
                    <div class="w-50 d-flex flex-column align-items-start">
                        <p>ID Cobranças</p>
                        <span id="modal-id"></span>
                    </div>
                    @php
                        $statusClass = '';
                        switch ($charge->calculated_status) {
                            case 'Vencida':
                                $statusClass = 'status-expirated';
                                break;
                            case 'Pendente':
                                $statusClass = 'status-pending';
                                break;
                            case 'Paga':
                                $statusClass = 'status-paid';
                                break;
                            default:
                                $statusClass = 'status-unknown';
                        }
                    @endphp
                    <div class="w-50 d-flex flex-column align-items-start">
                        <p>Status</p>
                        <span id="modal-status" class="text-capitalize {{ $statusClass }} w-4 h-4"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalChargesDetails = document.getElementById('modalChargesDetails');
        const nameSpan = modalChargesDetails.querySelector('#modal-client-name');
        const descriptionSpan = modalChargesDetails.querySelector('#modal-description');
        const expirationSpan = modalChargesDetails.querySelector('#modal-expiration');
        const valueSpan = modalChargesDetails.querySelector('#modal-value');
        const idSpan = modalChargesDetails.querySelector('#modal-id');
        const statusSpan = modalChargesDetails.querySelector('#modal-status');

        document.querySelectorAll('[data-bs-target="#modalChargesDetails"]').forEach(element => {
            element.addEventListener('click', function() {
                const clientName = this.getAttribute('data-client-name');
                const description = this.getAttribute('data-description');
                const expiration = this.getAttribute('data-expiration');
                const value = this.getAttribute('data-value');
                const id = this.getAttribute('data-id');
                const status = this.getAttribute('data-status');
                const statusClass = this.getAttribute(
                    'data-status-class'); // A classe do status

                nameSpan.textContent = clientName;
                descriptionSpan.textContent = description;
                expirationSpan.textContent = expiration;
                valueSpan.textContent = value;
                idSpan.textContent = id;
                statusSpan.textContent = status; // Preenche o conteúdo do status
                statusSpan.className =
                    `text-capitalize ${statusClass}`; // Aplica a classe correta ao status
            });
        });
    });
</script>
