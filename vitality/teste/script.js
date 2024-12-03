// Variável de controle para estado do treino
let treinoIniciado = false;

// Função para iniciar o treino
function iniciarTreino() {
    treinoIniciado = true;

    // Desbloquear todos os checkboxes e vídeos
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const lockedVideos = document.querySelectorAll('.video-container.locked');
    const lockedCheckboxes = document.querySelectorAll('.checkbox-container.locked');

    checkboxes.forEach(checkbox => (checkbox.disabled = false));
    lockedVideos.forEach(video => video.classList.remove('locked'));
    lockedCheckboxes.forEach(container => container.classList.remove('locked'));

    // Esconde o botão de iniciar
    document.getElementById('iniciar-treino').style.display = 'none';
}

// Modificação da função carregarTreino para bloquear inicialmente
function carregarTreino(nomeTreino) {
    document.getElementById('treinos-disponiveis').style.display = 'none';
    document.getElementById('treino-selecionado').style.display = 'block';
    document.getElementById('titulo-treino').textContent = nomeTreino;

    // Lista de exercícios
    const exercicios = [
        { aparelho: "Supino Inclinado", video: "gifs/Supino inclinado com halteres.mp4", repeticoes: "3x10", descanso: "60s" },
        { aparelho: "Puxada Alta", video: "gifs/Puxada alta com triângulo.mp4", repeticoes: "3x12", descanso: "90s" }
    ];

    const container = document.getElementById('exercicios-container');
    container.innerHTML = '';

    exercicios.forEach(exercicio => {
        const card = document.createElement('div');
        card.className = 'exercicio-card';
    
        card.innerHTML = `
            <div class="checkbox-container locked">
                <input type="checkbox" id="${exercicio.aparelho}" disabled>
            </div>
            <div class="video-container locked">
                <video src="${exercicio.video}" autoplay loop muted controls></video>
            </div>
            <div class="info-container">
                <h3>${exercicio.aparelho}</h3>
                <p>Repetições: ${exercicio.repeticoes}</p>
                <p>Descanso: ${exercicio.descanso}</p>
            </div>
        `;
    
        container.appendChild(card);
    });
    
}
