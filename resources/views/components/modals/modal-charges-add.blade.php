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
                            <input type="text" class="form-control" id="expiration" name="expiration" required>
                        </div>

                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Valor</label>
                            <input type="text" class="form-control" id="value" name="value" required>
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

<script src="https://cdn.jsdelivr.net/npm/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/inputmask"></script>
<script>
    // Aplicando a máscara no campo de valor
    const valueInput = document.getElementById('value');
    const mask = IMask(valueInput, {
        mask: 'R$ num',
        blocks: {
            num: {
                mask: Number,
                scale: 2,
                signed: false,
                thousandsSeparator: '.',
                radix: ',',
                padFractionalZeros: true,
                normalizeZeros: true,
                unmask: true // Aqui removemos a máscara para enviar o valor limpo
            }
        }
    });

    // Aplicando a máscara no campo de vencimento
    const vencimentoInput = document.getElementById('expiration');
    const imaskVencimento = new Inputmask('99/99/9999', {
        placeholder: '00/00/0000',
        clearMaskOnLostFocus: true,
    });
    imaskVencimento.mask(vencimentoInput);

    // Função de validação de data (DD/MM/AAAA)
    function validarData(data) {
        var regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
        var match = data.match(regex);

        if (!match) return false;

        var dia = parseInt(match[1], 10);
        var mes = parseInt(match[2], 10);
        var ano = parseInt(match[3], 10);

        if (mes < 1 || mes > 12) return false;
        if (ano < 1900 || ano > 2100) return false;

        var diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if (ano % 4 === 0 && (ano % 100 !== 0 || ano % 400 === 0)) {
            diasPorMes[1] = 29; // Fevereiro tem 29 dias em ano bissexto
        }

        if (dia < 1 || dia > diasPorMes[mes - 1]) return false;

        return true;
    }

    // Adicionando a validação da data ao campo de vencimento
    vencimentoInput.addEventListener('input', function() {
        var data = this.value;
        if (!validarData(data)) {
            this.setCustomValidity("Data inválida. Verifique os valores de dia, mês ou ano.");
            this.reportValidity();
        } else {
            this.setCustomValidity("");
        }
    });

    // Interceptando o envio do formulário
    const form = document.getElementById('chargesForm');
    form.addEventListener('submit', function(e) {
        // Remover a máscara de valor antes de enviar os dados
        const maskedValue = valueInput.value;
        const rawValue = maskedValue.replace('R$', '').replace(/\./g, '').replace(',', '.');
        document.getElementById('value').value = rawValue;
    });
</script>
