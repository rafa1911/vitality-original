<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fichas de Anamnese</title>
  <link rel="stylesheet" href="../assets/css/fichas_de_alunos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
  <link rel="icon" href="img/favicon.png" type="image/png">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <?php
  include '../db/conexao.php';
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $id = $_SESSION['id_aluno'];
  $c = "s";

  $query = "SELECT * FROM ficha_anamnese where fk_aluno_id_aluno = ? and respondido = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "is", $id, $c);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $fichas = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);

  ?>
</head>

<body>
  <div class="container">
    <h1>Fichas Anamnese</h1>
    <a href="./modelo.php" class="back-button">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
    <div class="ficha-list">
      <table class="table">
        <colgroup>
          <col style="width: 20%;">
          <col style="width: 40%;">
        </colgroup>
        <thead>
          <tr>
            <th scope="col">Modelo</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($fichas as $ficha): ?>
            <?php
            $idficha = $ficha['modelo'];

            $query = "SELECT titulo FROM modelos_ficha WHERE id_modelo = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $idficha);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $modelo = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            ?>
            <tr>
            <td><?php echo $modelo['titulo']; ?></td>
              <td>
                <div class="button-container">
                  <a href="<?php if ($ficha['modelo'] == 1) {
                              echo "./respostas.php?id=" . $id;
                            } else {
                              echo "./resposta_personalizada.php?id=" . $ficha['modelo'];
                            } ?>" class="btn-visualizar">
                    Visualizar
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function visualizarFicha(pagina) {
      window.location.href = pagina;
    }
  </script>
</body>

</html>