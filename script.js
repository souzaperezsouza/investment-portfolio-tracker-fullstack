document.addEventListener("DOMContentLoaded", function () {
    const tipoInvestimento = document.getElementById("tipoInvestimento");
    const campoCotas = document.getElementById("campoCotas");
    if (tipoInvestimento && campoCotas) {
        function atualizarCampoCotas() {
            const tiposSemCotas = ["cdb", "tesouro", "renda-fixa"];

            if (tiposSemCotas.includes(tipoInvestimento.value)) {
                campoCotas.disabled = true;
                campoCotas.required = false;
                campoCotas.value = "";
                campoCotas.placeholder = "Não se aplica";
            } else {
                campoCotas.disabled = false;
                campoCotas.required = true;
                campoCotas.placeholder = "";
            }
        }

        tipoInvestimento.addEventListener("change", atualizarCampoCotas);
        atualizarCampoCotas();
    }
});
function abrirModalExcluir(aporteId) {
    document.getElementById('aporteIdParaExcluir').value = aporteId;
    document.getElementById('excluirModal').style.display = 'block';
}

document.addEventListener("DOMContentLoaded", function () {
    const tipoInvestimento = document.getElementById("tipoInvestimento");
    const campoCotas = document.getElementById("campoCotas");
    if (tipoInvestimento && campoCotas) {
        function atualizarCampoCotas() {
            const tiposSemCotas = ["cdb", "tesouro", "renda-fixa"];

            if (tiposSemCotas.includes(tipoInvestimento.value)) {
                campoCotas.disabled = true;
                campoCotas.required = false;
                campoCotas.value = "";
                campoCotas.placeholder = "Não se aplica";
            } else {
                campoCotas.disabled = false;
                campoCotas.required = true;
                campoCotas.placeholder = "";
            }
        }

        tipoInvestimento.addEventListener("change", atualizarCampoCotas);
        atualizarCampoCotas();
    }
});

window.onclick = function(event) {
    const loginmodal = document.getElementById('id01');
    const cadastromodal = document.getElementById('id02');
    const logoutmodal = document.getElementById('logoutModal');
    const excluirmodal = document.getElementById('excluirModal'); // <- linha nova

    if (event.target == loginmodal) loginmodal.style.display = "none";
    if (event.target == cadastromodal) cadastromodal.style.display = "none";
    if (event.target == logoutmodal) logoutmodal.style.display = "none";
    if (event.target == excluirmodal) excluirmodal.style.display = "none"; // <- linha nova
}
function abrirModalExcluir(aporteId) {
    document.getElementById('aporteIdParaExcluir').value = aporteId;
    document.getElementById('excluirModal').style.display = 'block';
}