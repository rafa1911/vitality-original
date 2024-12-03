<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/excluirAL.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Excluir Aluno</title>
</head>

<body>
    <form action="../../controllers/excluirAL.php" method="GET">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_aluno); ?>">
        <div class="container">
            <div class="card">
                <h2>Excluir Aluno</h2>
                <p>Você tem certeza que deseja excluir este aluno?</p>
                <div class="button">
                    <button class="btn confirm-btn" type="submit">
                        <i class="fas fa-check"></i> Sim
                    </button>
                    <button class="btn cancel-btn" type="button" onclick="cancelDeletion()">
                        <i class="fas fa-times"></i> Não
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script src="../../assets/js/excluirAL.js"></script>
</body>

</html>