<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/header/header.css', 'resources/js/app.js'])
</head>

<body>
    <div class="modal fade" id="modalUserEdit" tabindex="-1" aria-labelledby="modalUserEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content d-flex flex-column justify-content-center rounded-lg">
                <div class="d-flex flex-column">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title text-center modal-text-padding" id="modalUserEditLabel">Edite seu
                            cadastro
                        </h5>
                        <div><button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button></div>
                    </div>
                    <form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}"
                        class="d-flex flex-column align-items-start w-100 px-4">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Nome*</label>
                            <input class="w-100 p-2" type="text" name="name" id="name"
                                value="{{ old('name', $user->name ?? '') }}" placeholder="Digite seu nome">
                        </div>
                        <div class="d-flex flex-column align-items-start w-100">
                            <label>E-mail*</label>
                            <input class="w-100 p-2" type="text" name="email" id="email"
                                value="{{ old('email', $user->email ?? '') }}" placeholder="Digite seu E-mail">
                        </div>
                        <div class="d-flex gap-4">
                            <div class="d-flex flex-column align-items-start w-100">
                                <label>CPF</label>
                                <input class="w-100 p-2" type="text" name="cpf" id="cpf"
                                    value="{{ old('cpf', $user->cpf ?? '') }}" placeholder="Digite seu CPF">
                            </div>
                            <div class="d-flex flex-column align-items-start w-100">
                                <label>Telefone</label>
                                <input class="w-100 p-2" type="text" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}" placeholder="Digite seu Telefone">
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Nova Senha*</label>
                            <input class="w-100 p-2" type="password" name="password" id="password"
                                value="{{ old('password') }}" placeholder="Nova Senha">
                        </div>
                        <div class="d-flex flex-column align-items-start w-100">
                            <label>Confirmar Senha*</label>
                            <input class="w-100 p-2" type="password" name="password_confirmation"
                                id="password_confirmation" value="{{ old('password_confirmation') }}"
                                placeholder="Digite sua Senha">
                        </div>
                        <button type="submit" class="align-items-center mx-auto my-4">Aplicar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir o script para aplicar a máscara -->
    <script src="{{ mix('js/app.js') }}"></script> <!-- Carregue o arquivo JS compilado -->

    <script>
        // Aplicando a máscara de CPF e Telefone depois que o DOM estiver carregado
        document.addEventListener("DOMContentLoaded", function() {
            const Inputmask = require("inputmask");

            // Aplicando máscara para CPF
            const cpf = document.getElementById('cpf');
            if (cpf) {
                Inputmask('999.999.999-99').mask(cpf);
            }

            // Aplicando máscara para Telefone
            const phone = document.getElementById('phone');
            if (phone) {
                Inputmask('(99) 99999-9999').mask(phone);
            }
        });
    </script>
</body>
