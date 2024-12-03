<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="icon" href="img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Treinos</title>
    <link rel="stylesheet" href="../../assets/css/treinoAL.css">

    <?php
    session_start();
    include '../../db/conexao.php';

    $id = $_SESSION['usuario_id'];
    $c = "n";

    $query = "SELECT t.numero_treino AS id_treino, t.tipo, ta.aparelho, ta.series,ta.carga, ta.repeticao, ta.descanso
          FROM treino t
          INNER JOIN treino_aparelho ta ON t.numero_treino = ta.numero_treino
          WHERE t.fk_aluno_id_aluno = ? 
            AND t.conclusao = ?
            AND t.numero_treino = (SELECT MIN(numero_treino)
                                    FROM treino
                                    WHERE fk_aluno_id_aluno = ? AND conclusao = ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isis", $id, $c, $id, $c);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $treinos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    ?>
</head>

<body>
    <a href="perfil_aluno.php" class="back-icon">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <div id="popup" class="popup">
        <div class="popup-overlay">
            <div class="popup-content">
                <span class="popup-close" onclick="closePopup()">&times;</span>
                <p class="popup-message">Nenhum treino encontrado. Aguarde o personal enviar o treino.</p>
            </div>
        </div>
    </div>
    <header class="header">
        <h1>Treinos</h1>
        <button class="start-button" onclick="iniciarTreino()">INICIAR TREINO </button>
        <p class="mode-message">Você está no "modo visualização". Aperte INICIAR para começar o treino.</p>
    </header>

    <section class="exercises">
        <?php if (!empty($treinos)) : ?>
            <?php foreach ($treinos as $treino) : ?>
                <div class="exercise">
                    <h2><?= htmlspecialchars($treino['tipo']); ?></h2>
                    <p>Aparelho: <?= htmlspecialchars($treino['aparelho']); ?></p>
                    <p>Séries: <?= htmlspecialchars($treino['series']); ?></p>
                    <p>Carga: <?= htmlspecialchars($treino['carga']); ?></p>
                    <p>Repetições: <?= htmlspecialchars($treino['repeticao']); ?></p>
                    <p>Descanso(Em segundos:): <?= htmlspecialchars($treino['descanso']); ?> segundos</p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-exercise">
                <p>Nenhum treino encontrado. Aguarde o personal enviar o treino.</p>
            </div>
        <?php endif; ?>
    </section>

    <a href="../../controllers/finaliza_treino.php?id_treino=<?php echo $treino['id_treino']?>">
        <button class="finish-button" style="display: none;" onclick="finalizarTreino()">FINALIZAR TREINO</button>
    </a>

    <script src="treino.js"></script>
</body>

</html>

<script>
    function iniciarTreino() {
        document.querySelector(".start-button").style.display = "none";
        document.querySelector(".mode-message").textContent = "Treino em andamento. Complete os exercícios abaixo.";
        document.querySelector(".finish-button").style.display = "block";

        const exercises = document.querySelectorAll(".exercise");
        exercises.forEach(exercise => {
            exercise.classList.add("active");
        });
    }

    function finalizarTreino() {
        alert("Parabéns! Você completou o treino.");
        document.querySelector(".finish-button").style.display = "none";
        document.querySelector(".mode-message").textContent = "Você completou o treino.";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>