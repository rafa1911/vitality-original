<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Personalizada</title>
    <link rel="stylesheet" href="../assets/css/ficha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <?php
    include '../db/conexao.php';
    $id_ficha = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $query_modelo = "SELECT * FROM modelos_ficha WHERE id_modelo = ?";
    $stmt_modelo = mysqli_prepare($conn, $query_modelo);
    mysqli_stmt_bind_param($stmt_modelo, "i", $id_ficha);
    mysqli_stmt_execute($stmt_modelo);
    $result_modelo = mysqli_stmt_get_result($stmt_modelo);
    $modelo = mysqli_fetch_assoc($result_modelo);
    mysqli_stmt_close($stmt_modelo);

    if (!$modelo) {
        die("Erro: Modelo de ficha não encontrado.");
    }

    $query_perguntas = "SELECT pm.id_pergunta, pm.pergunta, pm.tipo, pm.resposta 
                        FROM perguntas_modelo pm
                        WHERE pm.fk_modelo_id_modelo = ?";
    $stmt_perguntas = mysqli_prepare($conn, $query_perguntas);
    mysqli_stmt_bind_param($stmt_perguntas, "i", $id_ficha);
    mysqli_stmt_execute($stmt_perguntas);
    $result_perguntas = mysqli_stmt_get_result($stmt_perguntas);

    $perguntas = [];
    while ($row = mysqli_fetch_assoc($result_perguntas)) {
        $perguntas[] = $row;
    }
    mysqli_stmt_close($stmt_perguntas);
    ?>
</head>

<body>
    <div class="container">
        <h1><?= htmlspecialchars($modelo['titulo']) ?></h1>
        <p><?= htmlspecialchars($modelo['descricao']) ?></p>

        <fieldset>
            <legend>Ficha Personalizada</legend>
            <?php foreach ($perguntas as $pergunta): ?>
                <div class="question-item">
                    <label for="pergunta-<?= $pergunta['id_pergunta'] ?>">
                        <?= htmlspecialchars($pergunta['pergunta']) ?>
                    </label>
                    <?php if ($pergunta['tipo'] === 'text'): ?>
                        <input disabled type="text" id="pergunta-<?= $pergunta['id_pergunta'] ?>" 
                               name="pergunta[<?= $pergunta['id_pergunta'] ?>]"
                               value="<?= htmlspecialchars($pergunta['resposta']) ?>" 
                               class="form-input">
                    <?php elseif ($pergunta['tipo'] === 'radio' || $pergunta['tipo'] === 'checkbox'): ?>
                        <input disabled type="text" id="pergunta-<?= $pergunta['id_pergunta'] ?>" 
                               name="pergunta[<?= $pergunta['id_pergunta'] ?>]"
                               value="<?= htmlspecialchars($pergunta['resposta']) ?>" 
                               class="form-input">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </fieldset>

        <a href="./fichas_modelos.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <script src="../assets/js/ficha.js"></script>
</body>

</html>
