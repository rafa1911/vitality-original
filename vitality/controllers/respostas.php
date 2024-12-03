<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Anamnese</title>
    <link rel="stylesheet" href="../assets/css/ficha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <?php
    include '../db/conexao.php';
    session_start();

    $id_resposta = $_GET['id'];

    $query = "SELECT * FROM respostas WHERE id_resposta = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_resposta);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ficha = mysqli_fetch_assoc($result); 
    mysqli_stmt_close($stmt);
    ?>
</head>

<body>
    <div class="container">
        <h1>Ficha de Anamnese</h1>
        <fieldset>
            <legend>Dados Pessoais</legend>
            <label for="nome">Nome Completo:</label>
            <input disabled  type="text" id="nome" name="nome" value="<?= htmlspecialchars($ficha['nome']) ?>" required>

            <label for="data-nascimento">Data de Nascimento:</label>
            <input disabled  type="date" id="data-nascimento" name="data-nascimento" value="<?= htmlspecialchars($ficha['data_nascimento']) ?>" required>

            <label>Sexo:</label>
            <div class="radio-group">
                <input disabled  type="radio" id="sexo-m" name="sexo" value="Masculino" <?= $ficha['sexo'] === 'Masculino' ? 'checked' : '' ?>>
                <label for="sexo-m">Masculino</label>
                <input disabled  type="radio" id="sexo-f" name="sexo" value="Feminino" <?= $ficha['sexo'] === 'Feminino' ? 'checked' : '' ?>>
                <label for="sexo-f">Feminino</label>
            </div>

            <label for="email">E-mail:</label>
            <input disabled  type="email" id="email" name="email" value="<?= htmlspecialchars($ficha['email']) ?>" required>

            <label for="contato-emergencia">Contato de Emergência:</label>
            <input disabled  type="text" id="contato-emergencia" name="contato-emergencia" value="<?= htmlspecialchars($ficha['contato_emergencia']) ?>" required>
        </fieldset>

        <fieldset>
            <legend>Saúde</legend>
            <label>Pratica Atividade Física?</label>
            <div class="radio-group">
                <input disabled  type="radio" id="atividade-s" name="atividade" value="Sim" <?= $ficha['atividade'] === 'Sim' ? 'checked' : '' ?>>
                <label for="atividade-s">Sim</label>
                <input disabled  type="radio" id="atividade-n" name="atividade" value="Não" <?= $ficha['atividade'] === 'Não' ? 'checked' : '' ?>>
                <label for="atividade-n">Não</label>
            </div>

            <div id="atividade-info" class="<?= $ficha['atividade'] === 'Sim' ? '' : 'hidden' ?>">
                <label for="atividade-tipo">Se sim, quais e há quanto tempo:</label>
                <input disabled  type="text" id="atividade-tipo" name="atividade-tipo" value="<?= htmlspecialchars($ficha['atividade_tipo']) ?>">
            </div>

            <label for="peso">Peso (kg):</label>
            <input disabled  type="number" id="peso" name="peso" step="0.1" value="<?= htmlspecialchars($ficha['peso']) ?>" required>

            <label for="estatura">Estatura (cm):</label>
            <input disabled  type="number" id="estatura" name="estatura" step="0.1" value="<?= htmlspecialchars($ficha['estatura']) ?>" required>

            <label>Tem alguns desses sintomas ao praticar atividades físicas?</label>
            <div class="checkbox-group">
                <input disabled  type="checkbox" id="tontura" name="sintomas[]" value="Tontura" <?= strpos($ficha['sintomas'], 'Tontura') !== false ? 'checked' : '' ?>>
                <label for="tontura">Tontura</label>
                <input disabled  type="checkbox" id="mal-estar" name="sintomas[]" value="Mal Estar" <?= strpos($ficha['sintomas'], 'Mal Estar') !== false ? 'checked' : '' ?>>
                <label for="mal-estar">Mal Estar</label>
                <input disabled  type="checkbox" id="enjoo" name="sintomas[]" value="Enjoo" <?= strpos($ficha['sintomas'], 'Enjoo') !== false ? 'checked' : '' ?>>
                <label for="enjoo">Enjoo</label>
            </div>

            <label for="outro-desconforto">Algum outro desconforto?</label>
            <input disabled  type="text" id="outro-desconforto" name="outro-desconforto" value="<?= htmlspecialchars($ficha['outro_desconforto']) ?>">

            <label>Fumante?</label>
            <div class="radio-group">
                <input disabled  type="radio" id="fumante-s" name="fumante" value="Sim" <?= $ficha['fumante'] === 'Sim' ? 'checked' : '' ?>>
                <label for="fumante-s">Sim</label>
                <input disabled  type="radio" id="fumante-n" name="fumante" value="Não" <?= $ficha['fumante'] === 'Não' ? 'checked' : '' ?>>
                <label for="fumante-n">Não</label>
            </div>

            <div id="fumante-info" class="<?= $ficha['fumante'] === 'Sim' ? '' : 'hidden' ?>">
                <label for="fumante-tempo">Se sim, há quanto tempo?</label>
                <input disabled  type="text" id="fumante-tempo" name="fumante-tempo" value="<?= htmlspecialchars($ficha['fumante_tempo']) ?>">
            </div>

            <label>Teve lesão/cirurgia/quebrou algo?</label>
            <div class="radio-group">
                <input disabled  type="radio" id="lesao-s" name="lesao" value="Sim" <?= $ficha['lesao'] === 'Sim' ? 'checked' : '' ?>>
                <label for="lesao-s">Sim</label>
                <input disabled  type="radio" id="lesao-n" name="lesao" value="Não" <?= $ficha['lesao'] === 'Não' ? 'checked' : '' ?>>
                <label for="lesao-n">Não</label>
            </div>

            <div id="lesao-info" class="<?= $ficha['lesao'] === 'Sim' ? '' : 'hidden' ?>">
                <label for="lesao-tempo">Há quanto tempo e qual foi o tratamento?</label>
                <input disabled  type="text" id="lesao-tempo" name="lesao-tempo" value="<?= htmlspecialchars($ficha['lesao_tempo']) ?>">
            </div>

            <label for="problemas-saude">Tem algum problema de saúde? Se sim, quais?</label>
            <input disabled  type="text" id="problemas-saude" name="problemas-saude" value="<?= htmlspecialchars($ficha['problemas_saude']) ?>">

            <label for="alergias">Alergias:</label>
            <input disabled  type="text" id="alergias" name="alergias" value="<?= htmlspecialchars($ficha['alergias']) ?>">

            <label for="tratamento-medico">Faz algum tratamento médico?</label>
            <input disabled  type="text" id="tratamento-medico" name="tratamento-medico" value="<?= htmlspecialchars($ficha['tratamento_medico']) ?>">

            <label for="medicamento">Toma algum medicamento?</label>
            <input disabled  type="text" id="medicamento" name="medicamento" value="<?= htmlspecialchars($ficha['medicamento']) ?>">

            <label for="frequencia-treino">Quantas vezes na semana pretende treinar?</label>
            <input disabled  type="number" id="frequencia-treino" name="frequencia-treino" value="<?= htmlspecialchars($ficha['frequencia_treino']) ?>" required>

            <label>Objetivo:</label>
            <input disabled  type="text" id="Objetivo" name="Objetivo" value="<?= htmlspecialchars($ficha['objetivo']) ?>" >
        </fieldset>

        <a href="./fichas_de_alunos.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <script src="../assets/js/ficha.js"></script>
</body>

</html>