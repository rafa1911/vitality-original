<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";

$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

$id_aluno = $_SESSION['usuario_id'];

$sql = "SELECT nome_aluno, email, foto_perfil_aluno, fk_personal_id_personal FROM aluno WHERE id_aluno=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $nome_aluno = $row['nome_aluno'];
  $email_aluno = $row['email'];
  $foto_perfil_aluno = $row['foto_perfil_aluno'] ? $row['foto_perfil_aluno'] : '../../assets/img/Profile-PNG-File.png';
  $id_personal = $row['fk_personal_id_personal'];

  $sql_personal = "SELECT nome_personal, email AS email_personal, foto_perfil_personal FROM personal WHERE id_personal = ?";
  $stmt_personal = $conn->prepare($sql_personal);
  $stmt_personal->bind_param("i", $id_personal);
  $stmt_personal->execute();
  $result_personal = $stmt_personal->get_result();

  if ($result_personal->num_rows > 0) {
    $row_personal = $result_personal->fetch_assoc();
    $nome_personal = $row_personal['nome_personal'];
    $email_personal = $row_personal['email_personal'];
    $foto_perfil_personal = $row_personal['foto_perfil_personal'] ? $row_personal['foto_perfil_personal'] : '../../assets/img/Profile-PNG-File.png';
  } else {
    $nome_personal = "Personal não encontrado";
    $email_personal = "E-mail não disponível";
    $foto_perfil_personal = '../../assets/img/Profile-PNG-File.png';
  }
} else {
  header("Location: loginPS.php");
  exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="../../assets/css/perfil_aluno.css">
  <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
  <link rel="icon" href="../img/favicon.png" type="image/png">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <title>Vitality</title>
</head>

<body>
  <nav id="sidebar">
    <div class="sidebar-toggle" onclick="toggleSidebar()">
      <i class="fas fa-dumbbell"></i>
      <span id="sidebar-toggle-text">Vitality</span>
    </div>
    <div id="popup" class="popup" style="display: none;">
      <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <img src="../../assets/uploads/personais/<?php echo htmlspecialchars($foto_perfil_personal); ?>" id="popup-image" alt="foto do personal" class="popup-image">
        <h2 id="popup-name"><?php echo $nome_personal; ?></h2>
        <p id="popup-email"><?php echo $email_personal; ?></p>
      </div>
    </div>

    <ul>
      <li>
        <a href="#" onclick="showPopup()">
          <img src="../../assets/uploads/personais/<?php echo htmlspecialchars($foto_perfil_personal); ?>"/>
          <span class="nav-item"><?php echo htmlspecialchars($nome_personal); ?></span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="alterar_cadastroAL.php">
          <i class="fa-regular fa-pen-to-square"></i>
          <span class="nav-item">Alterar cadastro</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="editar_aluno.php">
        <i class="fa-solid fa-user-pen"></i>
          <span class="nav-item">Alterar foto de perfil</span>
        </a>
      </li>
      <li>
        <a href="../shared/senha.html">
          <i class="fa-solid fa-lock"></i>
          <span class="nav-item">Alterar senha</span>
        </a>
      </li>
      <li class="ajuda-logout">
        <a href="../shared/ajuda.php">
          <i class="fa-solid fa-question"></i>
          <span class="nav-item"></span>
        </a>
        <a href="../shared/sair.php" class="logout">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span class="nav-item"></span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="card">
      <div class="content">
        <div class="imagem">
          <img class="foto-perfil" src="<?php echo file_exists("../../assets/uploads/alunos/" . htmlspecialchars($foto_perfil_aluno)) ? "../../assets/uploads/alunos/" . htmlspecialchars($foto_perfil_aluno) : '../../assets/img/Profile-PNG-File.png'; ?>" alt="foto do usuario">
        </div>
        <div class="texto">
          <h2 class="name-main"><?php echo htmlspecialchars($nome_aluno); ?></h2>
          <p class="email-main"><?php echo htmlspecialchars($email_aluno); ?></p>
        </div>
      </div>
      <div class="button">
        <a href="../aluno/treinoAL.php">
          <button type="button" class="btn">
            <i class="fa-solid fa-dumbbell"></i> Treino
          </button>
        </a>
        <a href="../aluno/documentosAL.php">
          <button type="button" class="btn">
            <i class="fa-solid fa-file-lines"></i> Documentos
          </button>
        </a>
        <a href="../../controllers/modeloAL.php">
          <button type="button" class="btn">
            <i class="fa-solid fa-file-signature"></i> Ficha Anamnese
          </button>
        </a>
      </div>
    </div>
  </div>
  <script src="../../assets/js/perfil_aluno.js"></script>
</body>

</html>