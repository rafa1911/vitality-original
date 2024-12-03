document.getElementById('openModalBtn').onclick = function() {
    document.getElementById('modal').style.display = 'block';
}

document.getElementById('closeModalBtn').onclick = function() {
    document.getElementById('modal').style.display = 'none';
}

// Fechar o modal ao clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// Envio do formulário de solicitação
document.getElementById('optionsForm').onsubmit = function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    const formData = new FormData(this);
    
    fetch('processa_solicitacao.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostra a notificação de sucesso
            document.getElementById('successNotification').style.display = 'block';
            setTimeout(() => {
                document.getElementById('successNotification').style.display = 'none';
                document.getElementById('modal').style.display = 'none'; // Fecha o modal
            }, 3000); // 3 segundos de exibição
        }
    })
    .catch(error => console.error('Erro:', error));
};
