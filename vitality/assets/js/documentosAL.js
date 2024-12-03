// Função para mostrar o popup
function showPopup(hasDocumentsRequest) {
    document.getElementById('popup').style.display = 'flex';
    
    // Verifica se há solicitação de documentos
    if (hasDocumentsRequest) {
        document.getElementById('popup-message').textContent = "Você tem uma solicitação de documentos.";
    } else {
        document.getElementById('popup-message').textContent = "Você não tem nenhuma solicitação de documentos, aguarde notificação do personal.";
    }
}

// Função para fechar o popup
document.getElementById('popup-close').addEventListener('click', function() {
    // Simulação da verificação de solicitação de documentos
    const hasDocumentsRequest = checkForDocumentsRequest();

    if (hasDocumentsRequest) {
        // Se houver solicitação, apenas fecha o popup
        document.getElementById('popup').style.display = 'none';
    } else {
        // Se não houver solicitação, redireciona para a tela inicial
        window.location.href = '../../views/aluno/perfil_aluno.php';
    }
});

// Exemplo de chamada para mostrar o popup com ou sem solicitação
window.onload = function() {
    // Simule uma condição para verificar se há solicitação de documentos (ajuste conforme necessário)
    const hasDocumentsRequest = false; // Alterar para true se houver solicitação

    showPopup(hasDocumentsRequest);
};

// Função para verificar se há solicitação de documentos (essa função deve ser integrada à lógica do sistema)
function checkForDocumentsRequest() {
    // Simulação de verificação (ajuste conforme a lógica real do seu sistema)
    return false; // Alterar para true se houver solicitação de documentos
}

// Função para enviar o documento
function sendDocument() {
    const fileInput = document.getElementById('file-upload');
    const file = fileInput.files[0];

    if (file) {
        // Simulação de sucesso ou erro no envio (ajuste conforme a lógica real)
        const uploadSuccess = Math.random() > 0.5; // Simula 50% de chance de sucesso

        if (uploadSuccess) {
            showPopup('Documento enviado com sucesso!');
        } else {
            showPopup('Erro: Não foi possível enviar o documento.');
        }
    } else {
        showPopup('Nenhum arquivo selecionado.');
    }
}

// Função para exibir o nome do arquivo selecionado
document.getElementById('file-upload').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : 'Nenhum arquivo selecionado';
    document.getElementById('file-name').textContent = fileName;
});