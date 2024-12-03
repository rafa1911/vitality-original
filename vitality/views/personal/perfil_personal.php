<?php
session_start();

include '../../db/conexao.php';

if (isset($_GET['id'])){
    $_SESSION['usuario_id'] = $_GET['id'];
}
$id_personal = $_SESSION['usuario_id'];

$query_personal = "SELECT nome_personal, email, foto_perfil_personal FROM personal WHERE id_personal = ?";
$stmt_personal = $conn->prepare($query_personal);
$stmt_personal->bind_param("i", $id_personal);
$stmt_personal->execute();
$stmt_personal->bind_result($nome_personal, $email_personal, $foto_perfil_personal);
$stmt_personal->fetch();
$stmt_personal->close();

$foto_perfil_personal = $foto_perfil_personal ? $foto_perfil_personal : "Profile-PNG-File.png";

$query_alunos = "SELECT id_aluno, nome_aluno, foto_perfil_aluno FROM aluno WHERE fk_personal_id_personal = ?";
$stmt_alunos = $conn->prepare($query_alunos);
$stmt_alunos->bind_param("i", $id_personal);
$stmt_alunos->execute();
$stmt_alunos->bind_result($id_aluno, $nome_aluno, $foto_perfil_aluno);

$alunos = [];
while ($stmt_alunos->fetch()) {
    $foto_perfil_aluno = $foto_perfil_aluno ? $foto_perfil_aluno : "Profile-PNG-File.png"; 
    $alunos[] = ['id' => $id_aluno, 'nome' => $nome_aluno, 'foto' => $foto_perfil_aluno];
}
$stmt_alunos->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/perfil_personal.css" />
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../img/favicon.png" type="image/png"> 
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Vitality</title>
</head>
<body>
    <nav id="sidebar">
        <div class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-dumbbell"></i>
            <span id="sidebar-toggle-text">Vitality</span>
        </div>
        <ul>
        <li class="add-aluno">
                <a href="cadastrar_aluno.php" id="add-aluno-name"><i class="fa fa-user-plus"></i><span class="text">Cadastrar Aluno</span></a>
            </li>
            <?php foreach ($alunos as $aluno): ?>
            <li>
                <a href="perfilAL.php?id=<?php echo $aluno['id']; ?>">
                    <img src="../../assets/uploads/alunos/<?php echo htmlspecialchars($aluno['foto']); ?>" width="48" height="48" alt="<?php echo $aluno['nome']; ?>" />
                    <span class="nav-item"><?php echo $aluno['nome']; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
       
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <div id="sidebar-card">
                <div class="sidebar-card-toggle" onclick="toggleSidebarCard()">
                    <i class="fas fa-bars"></i>
                </div>
                <ul id="sidebar-items">
                    <li class="sidebar-item">
                        <a href="alterar_cadastroPS.php">
                        <i class="fa-regular fa-pen-to-square"></i>
                        <span class="text">Alterar cadastro</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../shared/senha.php">
                        <i class="fa-solid fa-lock"></i>
                        <span class="text">Alterar senha</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../personal/editar_personal.php">
                        <i class="fa-solid fa-user-pen"></i>
                        <span class="text">Alterar foto de perfil</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../shared/ajuda.php">
                        <i class="fa-solid fa-question"></i>
                        <span class="text">Ajuda</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../shared/sair.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="text">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="content">
                <div class="imagem">
                    <img class="foto-perfil" src="../../assets/uploads/personais/<?php echo htmlspecialchars($foto_perfil_personal); ?>" alt="foto do usuario" />
                </div>
                <div class="texto">
                    <h2 class="name-main"><?php echo htmlspecialchars($nome_personal); ?></h2>
                    <p class="email-main"><?php echo htmlspecialchars($email_personal); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/perfil_personal.js"></script>
</body>
</html>
