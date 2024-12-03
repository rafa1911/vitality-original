// Função para exibir o popup
function showPopup() {
    document.getElementById('popup').style.display = 'flex';
}

// Função para ocultar o popup
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}


let hasWorkout = true; // Altere para true se houver treino disponível

function showPopup() {
    document.getElementById('popup').style.display = 'flex';
    
    // Se houver treino, você pode esconder o popup diretamente ou não chamar esta função
    if (hasWorkout) {
        document.getElementById('popup').style.display = 'none'; // Opcional: se já tiver treino, não exibe popup
    } else {
        document.getElementById('popup').style.display = 'flex'; // Exibe o popup se não houver treino
    }
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    
    if (!hasWorkout) {
        window.location.href = '../../home/perfil_aluno.html'; 
    } 
    // Se houver treino, apenas fecha o popup
}

// Exemplo para mostrar o popup automaticamente (remova se não precisar)
window.onload = function() {
    showPopup();
};


// Função para simular o envio de treino ao aluno
function enviarTreino(treino) {
    // Exibe o treino enviado na interface do aluno (pode ser uma lista dinâmica)
    treino.forEach(exercicio => {
      const exerciseCard = document.createElement('div');
      exerciseCard.classList.add('exercise-card');
  
      exerciseCard.innerHTML = `
        <div class="exercise-info">
          <h2>${exercicio.nome}</h2>
          <p><strong>Séries:</strong> ${exercicio.series} reps</p>
          <p><strong>Carga:</strong> ${exercicio.carga}</p>
          <p><strong>Intervalo:</strong> <span class="interval">${exercicio.intervalo}</span></p>
        </div>
        <div class="exercise-video">
          <iframe src="${exercicio.video}" title="Exercício" allowfullscreen></iframe>
        </div>
      `;
  
      document.querySelector('.exercises').appendChild(exerciseCard);
    });
  }
  
 // Dados de exemplo
const treinoExemplo = [
  {
    nome: "Abdominal Bicicleta",
    series: "12",
    carga: "100g",
    intervalo: "11s",
    video: "https://www.youtube.com/embed/VIDEO_ID_1"
  },
  {
    nome: "Abdominal Bicicleta",
    series: "12",
    carga: "0g",
    intervalo: "10s",
    video: "https://www.youtube.com/embed/VIDEO_ID_2"
  }
];

// Função para exibir o treino
function iniciarTreino() {
  document.querySelector('.start-button').style.display = 'none';
  document.querySelector('.finish-button').style.display = 'block';
  document.querySelector('.mode-message').textContent = 'Treino iniciado! Marque os exercícios concluídos.';

  enviarTreino(treinoExemplo, true); // Passa "true" para exibir o checkbox
}

function finalizarTreino() {
  alert("Treino finalizado!");
  // Aqui você pode adicionar lógica para salvar o progresso ou resetar a tela, se necessário.
}

// Função para gerar os cards dos exercícios
function enviarTreino(treino, mostrarCheckbox = false) {
  const exercisesContainer = document.querySelector('.exercises');
  exercisesContainer.innerHTML = ''; // Limpa o conteúdo anterior

  treino.forEach(exercicio => {
    const exerciseCard = document.createElement('div');
    exerciseCard.classList.add('exercise-card');

    exerciseCard.innerHTML = `
      <div class="exercise-info">
        <h2>${exercicio.nome}</h2>
        <p><strong>Séries:</strong> ${exercicio.series} reps</p>
        <p><strong>Carga:</strong> ${exercicio.carga}</p>
        <p><strong>Intervalo:</strong> <span class="interval">${exercicio.intervalo}</span></p>
      </div>
      <div class="checkbox-container" style="display: ${mostrarCheckbox ? 'flex' : 'none'};">
        <input type="checkbox" onclick="marcarConcluido(this)">
        <label>Concluído</label>
      </div>
      <div class="exercise-video">
        <iframe src="${exercicio.video}" title="Exercício" allowfullscreen></iframe>
      </div>
    `;

    exercisesContainer.appendChild(exerciseCard);
  });
}

// Função para marcar o exercício como concluído
function marcarConcluido(checkbox) {
  const card = checkbox.closest('.exercise-card');
  if (checkbox.checked) {
    card.style.opacity = '0.6';  // Marca visual para exercícios concluídos
  } else {
    card.style.opacity = '1';
  }
}

// Exibe o treino de exemplo no modo visualização ao carregar a página
document.addEventListener('DOMContentLoaded', () => enviarTreino(treinoExemplo));