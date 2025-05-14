@vite(['resources/css/modal.css'])

<div class="modal fade" id="modalChargesDelete" tabindex="-1" aria-labelledby="modalChargesDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content flex-column justify-content-center rounded-lg position-relative">
            <div class="modal-header d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <div>
                        <button type="button" class="btn-close modal-charges-delete-button-close"
                            data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center g-3">
                        <img class="w-50" src={{ asset('images/warningimage.png') }} alt="">
                        <p>Tem certeza que deseja excluir esta cobrança?</p>
                        <!-- Formulário para a exclusão da cobrança -->
                        <form id="deleteChargeForm" method="POST"
                            action="{{ route('charges.delete', ['id' => '__ID__']) }}"
                            class="d-flex flex-row justify-content-evenly align-items-center w-50">
                            @csrf
                            @method('DELETE')
                            <!-- Campo oculto para armazenar o ID da cobrança -->
                            <input type="hidden" name="charge_id" id="chargeIdInput">
                            <button type="button" data-bs-dismiss="modal">Não</button>
                            <button type="submit">Sim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
