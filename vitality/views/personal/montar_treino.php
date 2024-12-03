<?php 
session_start();
$id = $_GET['id']; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <title>Montar Treino - Vitality</title>
  <link rel="stylesheet" href="../../assets/css/montar_treino.css" />
  <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
</head>
<body>
  <header>
    <h1>Crie o seu Treino</h1>
    <a href="../personal/perfilAL.php" class="back-icon">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </header>

  <form method="POST" action="../../controllers/Treino.php?id=<?php echo $id?>">
    <main>
      <div id="nome-treino-secao">
        <div class="treino-info">
          <label for="nome-treino">Nome do Treino:</label>
          <input type="text" name="nome_treino" id="nome-treino" placeholder="Digite o nome do treino" required />
        </div>

        <div class="grupo-muscular">
          <h2>Escolha o Membro</h2>
          <div class="membro">
            <label><input type="radio" name="membro" value="superiores" /> Membros Superiores</label>
            <label><input type="radio" name="membro" value="inferiores" /> Membros Inferiores</label>
          </div>
        </div>
      </div>

      <section id="aparelhos-secao" style="display: none;">
        <div id="aparelhos-superiores" style="display: none;">
          <h2>Aparelhos dos Membros Superiores</h2>
          
          <h3>Peitoral</h3>
          <div class="video-container">
              <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('peitoral-video')"></i>
              <label>
                <input type="checkbox" name="aparelhos[]" value="Supino Inclinado com Halteres" />
                Supino Inclinado com Halteres
              </label>
              <iframe id="peitoral-video" src="https://www.youtube.com/embed/839xznvFyYo?si=ku_8v-QlHU8kHemG" title="YouTube video player" allowfullscreen></iframe>
          </div>
          <div class="video-container">
              <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('crucifixo-video')"></i>
              <label>
                <input type="checkbox" name="aparelhos[]" value="Crucifixo na Máquina" />
                Crucifixo na Máquina
              </label>
              <iframe id="crucifixo-video" src="https://www.youtube.com/embed/VVLqTVA2skk?si=lqm_MJTAmoRRL5MH" title="YouTube video player" allowfullscreen></iframe>
          </div>

          <h3>Dorsais</h3>
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('puxada-video')"></i>
          <label>
            <input type="checkbox" name="aparelhos[]" value="Puxada Alta com Triângulo" /> Puxada Alta com Triângulo
          </label>
          <iframe id="puxada-video" width="560" height="315" src="https://www.youtube.com/embed/J-V-UCrMnvc?si=7RvPNoayEbORPgLC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
          
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('remada-video')"></i>
          <label>
            <input type="checkbox" name="aparelhos[]" value="Remada Baixa com Triângulo" /> Remada Baixa com Triângulo
          </label>
          <iframe id="remada-video" width="560" height="315" src="https://www.youtube.com/embed/tXKWdSYEDNs?si=SZvP6oDwYdYHrVGB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>

          <h3>Deltóides</h3>
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('elevacao-video')"></i>
          <label><input type="checkbox" name="aparelhos[]" value="Elevação Lateral" /> Elevação Lateral
          </label>
          <iframe id="elevacao-video" width="560" height="315" src="https://www.youtube.com/embed/XfmyjT4ivZw?si=ffs9NOPta-F_gMKq" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('desenvolvimento-video')"></i>
          <label>
            <input type="checkbox" name="aparelhos[]" value="Desenvolvimento com Halteres" /> Desenvolvimento com Halteres
        </label>
          <iframe id="desenvolvimento-video" width="560" height="315" src="https://www.youtube.com/embed/PBjxWPQjTCY?si=xb4y_8qK8IlCWvfN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>

          <h3>Tríceps</h3>
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('puxador-video')"></i>
          <label>
            <input type="checkbox" name="aparelhos[]" value="Puxador Tríceps com Corda" /> Puxador Tríceps com Corda
          </label>
          <iframe id="puxador-video" width="560" height="315" src="https://www.youtube.com/embed/6l8u3TOg7C8?si=xM9gRuTPCzmbcx64" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('triceps-video')"></i>
          <label>
         <input type="checkbox" name="aparelhos[]" value="Tríceps Francês com Halter" /> Tríceps Francês com Halter
          </label>
          <iframe id="triceps-video" width="560" height="315" src="https://www.youtube.com/embed/2ujpmoqYRUA?si=RceUgNnYlbVHxAjc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>


          <h3>Bíceps</h3>
          <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('rosca_direta-video')"></i>
          <label>
          <input type="checkbox" name="aparelhos[]" value="Rosca Direta com Barra" /> Rosca Direta com Barra
          </label>
          <iframe id="rosca_direta-video" width="560" height="315" src="https://www.youtube.com/embed/FByQebY1Cj4?si=SsMNBb3pdFTulnd9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div class="video-container">
          <i class="fa-brands fa-youtube video-icon" onclick="toggleVideo('rosca_mar-video')"></i>
          <label>
          <input type="checkbox" name="aparelhos[]" value="Rosca Martelo com Halteres" /> Rosca Martelo com Halteres
          </label>
          <iframe id="rosca_martelo-video" width="560" height="315" src="https://www.youtube.com/embed/qSRGpsmWeDQ?si=IqhnuvRpQQz8hwHb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
             
      <section id="aparelhos-secao" style="display: none;"></section>
        <div id="aparelhos-inferiores" style="display: none;">
          <h2>Aparelhos dos Membros Inferiores</h2>
          
          <h3>Quadríceps</h3>
          <label><input type="checkbox" name="aparelhos[]" value="Leg Press 45°" /> Leg Press 45°</label>
          <label><input type="checkbox" name="aparelhos[]" value="Cadeira Extensora" /> Cadeira Extensora</label>
         
          <h3>Posteriores</h3>
          <label><input type="checkbox" name="aparelhos[]" value="Stiff com Barra" /> Stiff com Barra</label>
          <label><input type="checkbox" name="aparelhos[]" value="Cadeira Flexora" /> Cadeira Flexora</label>

          <h3>Glúteos</h3>
          <label><input type="checkbox" name="aparelhos[]" value="Elevação Pélvica na Máquina" /> Elevação Pélvica na Máquina</label>
          <label><input type="checkbox" name="aparelhos[]" value="Cadeira Abdutora" /> Cadeira Abdutora</label>

          <h3>Panturrilhas</h3>
          <label><input type="checkbox" name="aparelhos[]" value="Sóleo Máquina" /> Sóleo Máquina</label>
          <label><input type="checkbox" name="aparelhos[]" value="Panturrilha em Pé na Máquina" /> Panturrilha em Pé na Máquina</label>

          <h3>Abdominais</h3>
          <label><input type="checkbox" name="aparelhos[]" value="Abdominal Infra" /> Abdominal Infra</label>
          <label><input type="checkbox" name="aparelhos[]" value="Abdominal Oblíquo (Toque nos Pés)" /> Abdominal Oblíquo (Toque nos Pés)</label>
        </div>
      </section>
      <button type="button" class="btn-proximo" style="display: none;">Próximo</button>

      <section id="config-secao" style="display: none;">
      <button type="button" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</button>        <h2>Configurar Treino</h2>
        <div id="aparelhos-selecionados">
        </div>
        <button type="submit" class="btn-finalizar">Finalizar Treino</button>
      </section>
    </main>
  </form>
  

  <script src="../../assets/js/montar_treino.js"></script>
</body>
</html>
