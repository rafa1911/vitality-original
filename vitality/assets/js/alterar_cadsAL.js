document.addEventListener("DOMContentLoaded", () => {
    const campoAlteracao = document.getElementById("campoAlteracao");
    const inputNome = document.getElementById("inputNome");
    const inputEmail = document.getElementById("inputEmail");

    // Função para mostrar campos dinâmicos
    window.mostrarInput = function () {
        const campoSelecionado = campoAlteracao.value;

        // Esconder ambos os campos inicialmente
        inputNome.style.display = "none";
        inputEmail.style.display = "none";

        // Exibir o campo correspondente
        if (campoSelecionado === "nome_aluno") {
            inputNome.style.display = "block";
        } else if (campoSelecionado === "email") {
            inputEmail.style.display = "block";
        }
    };
});
