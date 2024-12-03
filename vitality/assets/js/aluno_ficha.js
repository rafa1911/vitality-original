function showPopup() {
    document.getElementById('popup').style.display = 'flex';
}

// Fechar o popup e redirecionar
document.getElementById('popup-close').addEventListener('click', function () {
    document.getElementById('popup').style.display = 'none';
    window.location.href = '../aluno/perfil_aluno.php'; // Redireciona para a tela de perfil do aluno
});

// Simulação de verificar fichas
window.onload = function () {
    const fichaList = document.getElementById('ficha-list');
    
    // Suponha que você tenha uma variável que verifica se há fichas
    let hasFichas = false; // Mude para 'true' para testar a visualização com fichas

    if (!hasFichas) {
        showPopup();
        fichaList.innerHTML = ''; // Limpar a lista se não houver fichas
    }
};
