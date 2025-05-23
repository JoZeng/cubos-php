@vite(['resources/css/modal.css'])

<div class="modal fade" id="modalClientAdd" tabindex="-1" aria-labelledby="modalClientAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex flex-column justify-content-center rounded-lg">
            <div class="modal-header d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <h5 class="modal-title text-center modal-text-padding" id="modalClientAddLabel">Cadastro do Cliente
                    </h5>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('clients.store') }}"
                class="d-flex flex-column align-items-start w-100 px-4">
                @csrf
                <div class="d-flex flex-column align-items-start w-100">
                    <label>Nome*</label>
                    <input class="w-100 p-2" type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Digite o nome " required>
                </div>
                <div class="d-flex flex-column align-items-start w-100">
                    <label>E-mail*</label>
                    <input class="w-100 p-2" type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="Digite o E-mail " required>
                </div>
                <div class="d-flex gap-4 w-100">
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>CPF*</label>
                        <input class="w-100 p-2" type="text" name="cpf" id="cpfAddClient"
                            value="{{ old('cpf') }}" placeholder="Digite o CPF " required>
                    </div>
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>Telefone*</label>
                        <input class="w-100 p-2" type="text" name="phone" id="phoneAddClient"
                            value="{{ old('phone') }}" placeholder="Digite o Telefone " required>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-start w-100">
                    <label>Endereço</label>
                    <input class="w-100 p-2" type="text" name="address" id="address" value="{{ old('address') }}"
                        placeholder="Digite o Endereço ">
                </div>
                <div class="d-flex flex-column align-items-start w-100">
                    <label>Complemento</label>
                    <input class="w-100 p-2" type="text" name="complement" id="complement"
                        value="{{ old('complement') }}" placeholder="Digite o Complemento ">
                </div>
                <div class="d-flex gap-4 w-100">
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>CEP</label>
                        <input class="w-100 p-2" type="text" name="cep" id="cepAddClient"
                            value="{{ old('cep') }}" placeholder="Digite o CEP ">
                    </div>
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>Bairro</label>
                        <input class="w-100 p-2" type="text" name="neighborhood" id="neighborhood"
                            value="{{ old('neighborhood') }}" placeholder="Digite o Bairro ">
                    </div>
                </div>
                <div class="d-flex gap-4 w-100">
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>Cidade</label>
                        <input class="w-100 p-2" type="text" name="city" id="city"
                            value="{{ old('city') }}" placeholder="Digite a Cidade ">
                    </div>
                    <div class="d-flex flex-column align-items-start w-100">
                        <label>UF</label>
                        <input class="w-100 p-2" type="text" name="state" id="state"
                            value="{{ old('state') }}" placeholder="Digite o Estado ">
                    </div>
                </div>
                <button type="submit" class="align-items-center mx-auto my-4">Adicionar</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalClientAdd = document.getElementById('modalClientAdd');

        if (modalClientAdd) {
            modalClientAdd.addEventListener('shown.bs.modal', function() {
                const cpf = document.getElementById('cpfAddClient');
                if (cpf) {
                    Inputmask('999.999.999-99').mask(cpf);
                }

                const phone = document.getElementById('phoneAddClient');
                if (phone) {
                    Inputmask('(99) 99999-9999').mask(phone);
                }

                const cepClient = document.getElementById('cepAddClient');
                if (cepClient) {
                    Inputmask('99999-999').mask(cepClient);
                }
            });
        }
    });
</script>
