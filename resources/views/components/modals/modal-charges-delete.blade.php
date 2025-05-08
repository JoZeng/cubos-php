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
                        <form id="deleteChargeForm" method="POST" action=""
                            class="d-flex flex-row justify-content-evenly align-items-center w-50">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-bs-dismiss="modal">Não</button>
                            <button type="submit">Sim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('modalChargesDelete');
        const form = document.getElementById('deleteChargeForm');

        document.querySelectorAll('img[data-bs-target="#modalChargesDelete"]').forEach(button => {
            button.addEventListener('click', function() {
                const chargeId = this.getAttribute('data-charge-id');
                form.action =
                    `/charges/${chargeId}`; // Atualiza a rota de exclusão dinamicamente
            });
        });
    });
</script>
