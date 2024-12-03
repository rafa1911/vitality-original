function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('expanded');
}

function showPopup(email) {
    const personalImage = 'assets/Profile-PNG-File.png'; // Caminho da imagem do personal
    const personalName = 'Marcos Roberto'; // Nome do personal
    document.getElementById('popup').style.display = 'flex'; // Mostra o pop-up
}

function closePopup() {
    document.getElementById('popup').style.display = 'none'; // Oculta o pop-up
}

// Fecha o pop-up se o usuário clicar fora dele
window.onclick = function(event) {
    const popup = document.getElementById('popup');
    if (event.target === popup) {
        closePopup();
    }
}
