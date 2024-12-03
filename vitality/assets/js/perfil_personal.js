function toggleSidebar() {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('expanded');
}

function toggleSidebarCard() {
  var sidebarCard = document.getElementById('sidebar-card');
  sidebarCard.classList.toggle('open');
}

function abreviarNome(nomeCompleto) {
  const partes = nomeCompleto.split(' '); // Divide o nome em partes
  if (partes.length > 1) {
    // Se houver mais de um nome, pega a inicial do primeiro e o sobrenome
    return partes[0][0] + ". " + partes[partes.length - 1];
  } else {
    // Se for um único nome, apenas retorna a primeira letra
    return partes[0][0] + ".";
  }
}

// Função para verificar a largura da tela e abreviar os nomes
function verificarResponsividade() {
  const alunoNomeElement = document.getElementById('user-name');
  const addAlunoNomeElement = document.getElementById('add-aluno-name');
  
  const alunoNomeCompleto = alunoNomeElement.innerText; // Obtém o nome completo do usuário
  const addAlunoNomeCompleto = addAlunoNomeElement.innerText; // Obtém o nome completo de "Adicionar Aluno"
  
  // Verifica se a largura da tela é menor que um determinado valor
  if (window.innerWidth <= 768) {
    const alunoNomeAbreviado = abreviarNome(alunoNomeCompleto); // Abrevia o nome do aluno
    
    // Abrevia "Adicionar Aluno" como "Add. Aluno"
    const addAlunoNomeAbreviado = "Add. Aluno";
    
    alunoNomeElement.innerText = alunoNomeAbreviado; // Atualiza o texto do aluno
    addAlunoNomeElement.innerText = addAlunoNomeAbreviado; // Atualiza o texto de "Adicionar Aluno"
  } else {
    alunoNomeElement.innerText = alunoNomeCompleto; // Restaura o nome completo do aluno
    addAlunoNomeElement.innerText = addAlunoNomeCompleto; // Restaura o nome completo de "Adicionar Aluno"
  }
}

// Chama a função ao carregar a página
window.onload = verificarResponsividade;

// Chama a função ao redimensionar a janela
window.onresize = verificarResponsividade;

