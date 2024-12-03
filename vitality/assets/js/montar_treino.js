// Exibe os aparelhos de acordo com o membro selecionado
document.querySelectorAll('input[name="membro"]').forEach((input) => {
  input.addEventListener('change', function () {
    const aparelhosSecao = document.getElementById('aparelhos-secao');
    const superiores = document.getElementById('aparelhos-superiores');
    const inferiores = document.getElementById('aparelhos-inferiores');
    const btnProximo = document.querySelector('.btn-proximo');

    // Exibe a seção de aparelhos e o botão Próximo
    aparelhosSecao.style.display = 'block';
    btnProximo.style.display = 'inline-block';

    // Exibe apenas os aparelhos do membro selecionado
    if (this.value === 'superiores') {
      superiores.style.display = 'block';
      inferiores.style.display = 'none';
    } else if (this.value === 'inferiores') {
      inferiores.style.display = 'block';
      superiores.style.display = 'none';
    }
  });
});

// Avança para a configuração do treino ao clicar em "Próximo"
document.querySelector('.btn-proximo').addEventListener('click', function () {
  const nomeTreino = document.getElementById('nome-treino').value;
  const aparelhosSelecionados = document.querySelectorAll('#aparelhos-secao input[type="checkbox"]:checked');
  const aparelhosSelecionadosContainer = document.getElementById('aparelhos-selecionados');
  const btnProximo = document.querySelector('.btn-proximo');

  // Verifica se o campo "Nome do Treino" foi preenchido
  if (nomeTreino.trim() === '') {
    alert('Por favor, preencha o nome do treino.');
    return;
  }

  // Verifica se pelo menos um aparelho foi selecionado
  if (aparelhosSelecionados.length === 0) {
    alert('Por favor, selecione pelo menos um aparelho.');
    return;
  }

  // Limpa a área de aparelhos selecionados
  aparelhosSelecionadosContainer.innerHTML = '';

  // Adiciona cada aparelho selecionado para configurar séries, repetições e descanso
  aparelhosSelecionados.forEach((aparelho) => {
    const aparelhoDiv = document.createElement('div');
    aparelhoDiv.innerHTML = `
      <label>${aparelho.parentElement.textContent.trim()}:</label>
      <label>Séries: <input type="number" name="series[]" placeholder="0" min="0" required /></label>
      <label>Repetições: <input type="number" name="repeticoes[]" placeholder="0" min="0" required /></label>
      <label>Descanso: <input type="text" name="descansos[]" placeholder="Tempo (s)" min="0" required /></label>
    `;
    aparelhosSelecionadosContainer.appendChild(aparelhoDiv);
  });

  // Oculta a seção de nome do treino, aparelhos e botão Próximo
  document.getElementById('nome-treino-secao').style.display = 'none';
  document.getElementById('aparelhos-secao').style.display = 'none';
  btnProximo.style.display = 'none';

  // Mostra a seção de configuração de treino
  document.getElementById('config-secao').style.display = 'block';
});

// Volta para a seção de escolha de aparelhos ao clicar em "Voltar"
document.querySelector('.btn-voltar').addEventListener('click', function () {
  const btnProximo = document.querySelector('.btn-proximo');

  // Oculta a seção de configuração de treino
  document.getElementById('config-secao').style.display = 'none';

  // Exibe a seção de escolha de aparelhos e botão Próximo novamente
  document.getElementById('nome-treino-secao').style.display = 'block';
  document.getElementById('aparelhos-secao').style.display = 'block';
  btnProximo.style.display = 'inline-block';
});
// video icone
function toggleVideo(videoId) {
  var video = document.getElementById(videoId);
  if (video.style.display === "none" || video.style.display === "") {
    video.style.display = "block";
  } else {
    video.style.display = "none";
  }
}
