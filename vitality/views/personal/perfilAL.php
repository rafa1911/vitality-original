<?php
session_start();
include '../../db/conexao.php'; 

if (isset($_GET['id'])) {
    $id_aluno = $_GET['id'];
    if ($id_aluno) {
        $_SESSION['id_aluno'] = $id_aluno;
    } else {
        die("ID inválido."); 
    }
} elseif (isset($_SESSION['id_aluno'])) {
    $id_aluno = $_SESSION['id_aluno'];
} else {
    die("ID do aluno não fornecido."); 
}

$query_aluno = "SELECT nome_aluno, email, fk_personal_id_personal, foto_perfil_aluno FROM aluno WHERE id_aluno = ?";
$stmt_aluno = $conn->prepare($query_aluno);
$stmt_aluno->bind_param("i", $id_aluno);
$stmt_aluno->execute();
$stmt_aluno->bind_result($nome_aluno, $email, $id_personal, $foto_perfil_aluno);
$stmt_aluno->fetch();
$stmt_aluno->close();

$conn->close();

$foto_perfil_aluno = $foto_perfil_aluno ? $foto_perfil_aluno : "Profile-PNG-File.png";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/perfilAL.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title><?php echo htmlspecialchars($nome_aluno); ?> - Perfil do Aluno</title>
</head>
<body>

    <div class="container">
        <div class="card">
        <a href="perfil_personal.php" class="back-icon">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
            <div class="content">
            <div class="content">
                <a href="excluirAL.php?id=<?php echo $id_aluno?>" >
                <button><i class="fas fa-trash-alt delete-icon"></i></button>
            </a>
                <div class="imagem">
                    <img class="foto-perfil" src="../../assets/uploads/alunos/<?php echo htmlspecialchars($foto_perfil_aluno); ?>" alt="foto do aluno">
                </div>
                <div class="texto">
                    <h2 class="name-main"><?php echo htmlspecialchars($nome_aluno); ?></h2>
                    <p class="email-main"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>
            <div class="button">
                <a href="montar_treino.php?id=<?php echo $id_aluno?>">
                    <button type="button" class="btn"> 
                        <i class="fa-solid fa-dumbbell"></i> Treino</button>
                </a>
                <a href="documentosPS.php">
                    <button type="button" class="btn">
                        <i class="fa-solid fa-file-lines"></i> Documentos</button>
                </a>
                <a href="../../controllers/modelo.php">
                    <button type="button" class="btn">
                    <i class="fa-solid fa-file-signature"></i> Ficha Anamnese</button>
                </a>
            </div>
        </div>
    </div>

    <script src="../../assets/js/perfilAL.js"></script>
</body>
</html>
