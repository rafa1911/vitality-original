<?php
session_start();
include '../../db/conexao.php';

if (isset($_SESSION['id_aluno'])) {
    $id_aluno = $_SESSION['id_aluno'];

    $query_documentos = "SELECT tipo_documento, documento FROM solicitacoes WHERE fk_aluno_id_aluno = ? AND status = 'baixada'";
    $stmt_documentos = $conn->prepare($query_documentos);

    if ($stmt_documentos) {
        $stmt_documentos->bind_param("i", $id_aluno);
        $stmt_documentos->execute();
        $result_documentos = $stmt_documentos->get_result();

        if ($result_documentos->num_rows > 0) {
            echo "<h2>Documentos Respondidos</h2>";
            while ($documento = $result_documentos->fetch_assoc()) {
                $tipo = htmlspecialchars($documento['tipo_documento']);
                $arquivo = htmlspecialchars($documento['documento']);
                $pasta = ($tipo == 'Avaliação Física') ? 'avaliacao' : 'documento';

                $caminho_arquivo = "../../assets/uploads/alunos/$pasta/" . $arquivo;

                echo "<p>Tipo: $tipo</p>";
                echo "<button onclick=\"openDocumentModal('$caminho_arquivo')\">Ver Documento</button>";
                echo "<hr>";
            }
        } else {
            echo "<p>Nenhum documento respondido encontrado para este aluno.</p>";
        }

        $stmt_documentos->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
} else {
    echo "ID do aluno não definido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="../../assets/css/documentosPS.css">
    <title>Documentos</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            position: relative;
            width: 80%;
            max-width: 800px;
            background: #fff;
            padding: 20px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <h1 class="page-title">Documentos</h1>
        <div class="button-container">
            <button onclick="openModal()" class="btn">Solicitar</button>
        </div>
        <a href="perfilAL.php" class="back-icon">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div id="modal" class="modal">
            <div class="modal-content">
                <span onclick="closeModal()" class="close">&times;</span>
                <h2>Selecione uma opção</h2>
                <form method="POST" action="../../controllers/upload_solicitacao.php">
                    <label class="custom-radio">
                        <input type="radio" name="tipo_documento" value="Avaliação Física" required>
                        <span class="radio-btn">
                            <i class="las la-check"></i>
                            <div class="hobbies-icon">
                                <h3>Avaliação Física</h3>
                            </div>
                        </span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="tipo_documento" value="Exames" required>
                        <span class="radio-btn">
                            <i class="las la-check"></i>
                            <div class="hobbies-icon">
                                <h3>Exames</h3>
                            </div>
                        </span>
                    </label>
                    <div class="button-container">
                        <button type="submit" class="btn-submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
        <h2>Solicitações de Documentos</h2>
        <ul>
            <?php
            $stmt_solicitacoes = $conn->prepare("SELECT tipo_documento FROM solicitacoes WHERE fk_aluno_id_aluno = ?");
            $stmt_solicitacoes->bind_param("i", $id_aluno);
            $stmt_solicitacoes->execute();
            $result_solicitacoes = $stmt_solicitacoes->get_result();

            if ($result_solicitacoes->num_rows > 0) {
                while ($row = $result_solicitacoes->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['tipo_documento']) . "</li>";
                }
            } else {
                echo "<li>Nenhuma solicitação encontrada.</li>";
            }

            $stmt_solicitacoes->close();
            ?>
        </ul>


        <div id="documentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeDocumentModal()">&times;</span>
                <img id="documentImage" src="" alt="Documento">
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("modal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        function openDocumentModal(caminho) {
            document.getElementById("documentImage").src = caminho;
            document.getElementById("documentModal").style.display = "flex";
        }

        function closeDocumentModal() {
            document.getElementById("documentModal").style.display = "none";
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>