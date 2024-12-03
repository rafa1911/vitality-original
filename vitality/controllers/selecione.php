<?php
include '../db/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_personal = $_SESSION['usuario_id'];

$query = "SELECT distinct titulo, id_modelo FROM modelos_ficha WHERE fk_personal_id_personal = ? group by id_modelo";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_personal);
$stmt->execute();
$result = $stmt->get_result();

$fichas = [];
while ($row = $result->fetch_assoc()) {
    $fichas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione um Modelo</title>
    <link rel="stylesheet" href="../assets/css/selecione.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
</head>

<body>
    <div class="container">
        <h1>Selecione um Modelo</h1>
        <a href="./modelo.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div class="model-list">
            <?php if (empty($fichas)): ?>
                <p>Nenhum modelo encontrado. Crie um novo modelo.</p>
            <?php else: ?>
                <?php foreach ($fichas as $ficha): ?>
                    <?php if ($ficha['id_modelo'] != 1): ?>
                        <div class="model-item" onclick="selecionarModelo(<?php echo $ficha['id_modelo']; ?>)">
                            <i class="fas fa-file-alt"></i>
                            <?php echo $ficha['titulo']; ?>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="model-item" onclick="selecionarModeloPadrao()">
                <i class="fas fa-file-alt"></i>
                Ficha de Anamnese Padrão
            </div>
        </div>
    </div>

    <script>
        function selecionarModelo(id) {
            window.location.href = `ficha.php?id=${id}`;
        }
        function selecionarModeloPadrao() {
            window.location.href = `ficha.html`; 
        }
    </script>
</body>

</html>