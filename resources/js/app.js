import "./bootstrap";
import * as bootstrap from "bootstrap";

import Inputmask from "inputmask";

// Aplica a máscara ao CPF
const cpf = document.getElementById("cpf");
if (cpf) {
    Inputmask("999.999.999-99").mask(cpf);
}

// Aplica a máscara ao telefone
const phone = document.getElementById("phone");
if (phone) {
    Inputmask("(99) 99999-9999").mask(phone);
}
