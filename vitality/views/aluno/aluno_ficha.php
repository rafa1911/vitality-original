<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/aluno_ficha.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Ficha de Anamnese</title>
</head>

<body>
    <div id="popup" class="popup">
        <div class="popup-content">
            <span id="popup-close" class="popup-close">&times;</span>
            <p>Você não tem nenhuma ficha de anamnese disponível para responder. Aguarde seu personal enviar.</p>
        </div>
    </div>

    <div class="container">
        <h1 id="page-header">Ficha de Anamnese</h1>

        <div class="anamnese-container">
            <div id="ficha-list" class="ficha-list">
                <div class="ficha-item">
                    <span>Ficha 1</span>
                    <button class="responder-button">Responder</button>
                </div>
                <div class="ficha-item">
                    <span>Ficha 2</span>
                    <button class="responder-button">Responder</button>
                </div>
            </div>
            <button id="new-ficha-button" class="submit-button">Responder Nova Ficha</button>
        </div>
    </div>

    <script src="../../assets/js/aluno_ficha.js"></script>
</body>

</html>
