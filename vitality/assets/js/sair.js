// Ação para o botão de confirmar saída
document.getElementById("confirm-logout").addEventListener("click", function() {
    alert("Você saiu da conta."); // Aqui você pode redirecionar para a página de logout
    // Exemplo: window.location.href = "logout.html";
});

// Ação para o botão de cancelar
document.getElementById("cancel-logout").addEventListener("click", function() {
    document.getElementById("overlay").style.display = "none"; // Esconde o card
});
