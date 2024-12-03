<?php // aluno
session_start();
include '../db/conexao.php';

$modelo_id = $_GET['id'];

$query_modelo = "SELECT titulo, descricao FROM modelos_ficha WHERE id_modelo = ?";
$stmt_modelo = $conn->prepare($query_modelo);
$stmt_modelo->bind_param("i", $modelo_id);
$stmt_modelo->execute();
$result_modelo = $stmt_modelo->get_result();


$modelo = $result_modelo->fetch_assoc();
$stmt_modelo->close();

$query_perguntas = "SELECT pm.id_pergunta, pm.pergunta, pm.tipo, op.id_opcao, op.opcao 
FROM perguntas_modelo pm 
LEFT JOIN opcoes_pergunta op ON pm.id_pergunta = op.fk_pergunta_id_pergunta 
WHERE pm.fk_modelo_id_modelo = ? 
ORDER BY pm.id_pergunta, op.id_opcao";
$stmt_perguntas = $conn->prepare($query_perguntas);
$stmt_perguntas->bind_param("i", $modelo_id);
$stmt_perguntas->execute();
$result_perguntas = $stmt_perguntas->get_result();

$perguntas = [];
while ($row = $result_perguntas->fetch_assoc()) {
    $id_pergunta = $row['id_pergunta'];

    if (!isset($perguntas[$id_pergunta])) {
        $perguntas[$id_pergunta] = [
            'pergunta' => $row['pergunta'],
            'tipo' => $row['tipo'],
            'opcoes' => [],
        ];
    }

    if ($row['opcao'] !== null) {
        $perguntas[$id_pergunta]['opcoes'][] = [
            'id_opcao' => $row['id_opcao'],
            'opcao' => $row['opcao']
        ];
    }
}
$stmt_perguntas->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preencher Ficha: <?php echo $modelo['titulo']; ?></title>
    <link rel="stylesheet" href="../assets/css/enviar_ficha.css">
</head>

<body>
    <div class="container">
        <h1><?php echo $modelo['titulo']; ?></h1>
        <p><?php echo $modelo['descricao']; ?></p>

        <form method="POST" action="salvar_resposta_personalizada.php?id=<?php echo $modelo_id?>" id="fichaForm">
            <fieldset>
                <legend>Responda às Perguntas</legend>
                <?php foreach ($perguntas as $id_pergunta => $detalhes): ?>
                    <div class="pergunta-item">
                        <h3><?php echo $detalhes['pergunta']; ?></h3>

                        <?php if ($detalhes['tipo'] === 'text'): ?>
                            <input type="text" id="pergunta-<?php echo $id_pergunta; ?>" name="respostas[<?php echo $id_pergunta; ?>]" class="form-input" required placeholder="Digite sua resposta">

                        <?php elseif ($detalhes['tipo'] === 'radio'): ?>
                            <div class="opcoes-container">
                                <?php foreach ($detalhes['opcoes'] as $index => $opcao): ?>
                                    <input type="radio" id="opcao-<?php echo $id_pergunta . '-' . $index; ?>" name="respostas[<?php echo $id_pergunta; ?>]" value="<?php echo $opcao['opcao']; ?>" class="form-input-radio" >
                                    <label for="opcao-<?php echo $id_pergunta . '-' . $index; ?>">
                                        <?php echo $opcao['opcao']; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>



                        <?php elseif ($detalhes['tipo'] === 'checkbox'): ?>
                            <div class="opcoes-container">
                                <?php foreach ($detalhes['opcoes'] as $index => $opcao): ?>
                                    <input
                                        type="checkbox"
                                        id="opcao-<?php echo $id_pergunta . '-' . $index; ?>"
                                        name="respostas[<?php echo $id_pergunta; ?>][]"
                                        value="<?php echo htmlspecialchars($opcao['opcao']); ?>"
                                        class="form-input-checkbox">
                                    <label for="opcao-<?php echo $id_pergunta . '-' . $index; ?>">
                                        <?php echo htmlspecialchars($opcao['opcao']); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enviar ficha</button>
            </div>
        </form>
    </div>
</body>

</html>