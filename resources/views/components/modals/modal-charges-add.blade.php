@vite(['resources/css/modal.css'])

<div class="modal fade" id="modalChargesAdd" tabindex="-1" aria-labelledby="modalChargesAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex flex-column justify-content-center rounded-lg">
            <div class="modal-header d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <h5 class="modal-title text-center modal-text-padding" id="modalChargesAddLabel">
                        {{ $headerModalText ?? 'Cadastro de Cobrança' }}
                    </h5>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                </div>
            </div>

            @if ($client)
                <form method="POST" action="{{ route('charges.store') }}"
                    class="d-flex flex-column align-items-start w-100 px-4">
                    @csrf

                    <input type="hidden" name="client_id" id="modal-client-id" value="">


                    <div class="d-flex flex-column align-items-start w-100">
                        <label>Nome*</label>
                        <input class="w-100 p-2" type="text" id="modal-client-name" value="" readonly>
                    </div>


                    <div class="d-flex flex-column align-items-start w-100">
                        <label>Descrição</label>
                        <input class="w-100 p-2" type="text" name="description" placeholder="Digite a descrição"
                            required>
                    </div>

                    <div class="d-flex gap-4 w-100">
                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Vencimento</label>
                            <input class="w-100 p-2" type="date" name="expiration" required>
                        </div>

                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Valor</label>
                            <input class="w-100 p-2" type="number" step="0.01" name="value" required>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-start w-100 mt-3 w-100">
                        <label>Status da Cobrança</label>
                        <div class="d-flex gap-4 w-100">
                            <div class="d-flex flex-column align-items-start w-100 mt-3 ">
                                <div class="form-check modal-input-radio ps-5 w-100">
                                    <input class="form-check-input" type="radio" name="status" id="radio-pendente"
                                        value="pendente" checked>
                                    <label class="form-check-label mb-2" for="radio-pendente">Pendente</label>
                                </div>
                                <div class="form-check modal-input-radio ps-5 w-100">
                                    <input class="form-check-input" type="radio" name="status" id="radio-paga"
                                        value="paga" checked>
                                    <label class="form-check-label mb-2" for="radio-paga">Paga</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="align-items-center mx-auto my-4 btn btn-primary">Aplicar</button>
                </form>
            @else
                <div class="alert alert-warning mt-3 mx-4">
                    Não foi possível associar essa cobrança a um cliente. Verifique se o usuário está vinculado a um
                    cliente.
                </div>
            @endif
        </div>
    </div>
</div>
