<?php
session_start();
include '../../db/conexao.php';


$id_aluno = $_SESSION['usuario_id'];

$query_personal = "SELECT fk_personal_id_personal FROM solicitacoes WHERE fk_aluno_id_aluno = ? LIMIT 1";
$stmt_personal = $conn->prepare($query_personal);
$stmt_personal->bind_param("i", $id_aluno);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();
$row_personal = $result_personal->fetch_assoc();
$id_personal = $row_personal['fk_personal_id_personal'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_documento']) && $_POST['tipo_documento'] === 'Avaliação Física') {
    $descricao = $_POST['description'];

    $upload_dir = "../../assets/uploads/alunos/avaliacao/";
    
    $upload_file = $upload_dir . basename($_FILES['file_upload']['name']);
    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_file)) {
       
        $stmt = $conn->prepare("UPDATE solicitacoes SET documento = ?, status = 'Baixada', descricao = ? WHERE fk_aluno_id_aluno = ? AND fk_personal_id_personal = ? AND tipo_documento = 'Avaliação Física' LIMIT 1");
        $stmt->bind_param("ssii", $_FILES['file_upload']['name'], $descricao, $id_aluno, $id_personal);

        if ($stmt->execute()) {
            echo "<script>alert('Solicitação de Avaliação Física atualizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar solicitação: " . htmlspecialchars($stmt->error) . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Erro ao fazer upload do arquivo.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_documento']) && $_POST['tipo_documento'] === 'Exames') {
    $descricao = $_POST['description'];

    $upload_dir = "../../assets/uploads/alunos/documento/";

    // Faz o upload do arquivo
    $upload_file = $upload_dir . basename($_FILES['file_upload']['name']);
    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_file)) {

        $stmt = $conn->prepare("UPDATE solicitacoes SET documento = ?, status = 'Baixada', descricao = ? WHERE fk_aluno_id_aluno = ? AND fk_personal_id_personal = ? AND tipo_documento = 'Exames' LIMIT 1");
        $stmt->bind_param("ssii", $_FILES['file_upload']['name'], $descricao, $id_aluno, $id_personal);

        if ($stmt->execute()) {
            echo "<script>alert('Solicitação de Exames atualizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar solicitação: " . htmlspecialchars($stmt->error) . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Erro ao fazer upload do arquivo.');</script>";
    }
}

$query_solicitacoes = "SELECT tipo_documento, status, created_at, documento FROM solicitacoes WHERE fk_aluno_id_aluno = ?";
$stmt_solicitacoes = $conn->prepare($query_solicitacoes);
$stmt_solicitacoes->bind_param("i", $id_aluno);
$stmt_solicitacoes->execute();
$result_solicitacoes = $stmt_solicitacoes->get_result();

$solicitacoes = [];
while ($row = $result_solicitacoes->fetch_assoc()) {
    $solicitacoes[] = $row;
}
$stmt_solicitacoes->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/documentosAL.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <style>
        .button-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .btn {
            font-size: 1.5em;
            padding: 10px 20px;
            margin: 0 10px;
        }
        .document-form {
            display: none;
            text-align: center;
        }
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

    <a href="perfil_aluno.php" class="back-icon">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span id="popup-close" class="popup-close">&times;</span>
            <p id="popup-message"></p>
        </div>
    </div>

    <div class="main-content">
        <h1 id="page-header">Documentos</h1>

        <div class="button-container">
            <button class="btn" onclick="showDocumentForm('avaliacao')">Avaliação Física</button>
            <button class="btn" onclick="showDocumentForm('exames')">Exames</button>
        </div>

        <div id="form-avaliacao" class="document-form">
            <h2>Enviar Documento - Avaliação Física</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo_documento" value="Avaliação Física">
                <label for="file-upload-avaliacao" class="custom-file-upload">
                    <i class="fa-solid fa-upload"></i> Escolher arquivo
                </label>
                <input type="file" name="file_upload" id="file-upload-avaliacao" required>
                <span id="file-name-avaliacao" class="file-name">Nenhum arquivo selecionado</span>

                <label for="description">Descrição (opcional):</label>
                <textarea id="description" name="description" rows="4" placeholder="Digite uma breve descrição do documento"></textarea>

                <button type="submit" class="submit-button">Enviar Documento</button>
                <button type="button" class="btn" onclick="cancelUpload()">Cancelar</button>
            </form>
        </div>

        <div id="form-exames" class="document-form">
            <h2>Enviar Documento - Exames</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo_documento" value="Exames">
                <label for="file-upload-exames" class="custom-file-upload">
                    <i class="fa-solid fa-upload"></i> Escolher arquivo
                </label>
                <input type="file" name="file_upload" id="file-upload-exames" required>
                <span id="file-name-exames" class="file-name">Nenhum arquivo selecionado</span>

                <label for="description">Descrição (opcional):</label>
                <textarea id="description" name="description" rows="4" placeholder="Digite uma breve descrição do documento"></textarea>

                <button type="submit" class="submit-button">Enviar Documento</button>
                <button type="button" class="btn" onclick="cancelUpload()">Cancelar</button>
            </form>
        </div>

        <h2>Solicitações de Documentos</h2>
        <ul>
            <?php if (count($solicitacoes) > 0): ?>
                <?php foreach ($solicitacoes as $solicitacao): ?>
                    <li>
                        <?php echo htmlspecialchars($solicitacao['tipo_documento']) . " - Status: " . htmlspecialchars($solicitacao['status']) . " - Data: " . htmlspecialchars($solicitacao['created_at']); ?>
                        <?php if ($solicitacao['documento']): ?>
                            - Documento: <?php echo htmlspecialchars($solicitacao['documento']); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Nenhuma solicitação encontrada.</li>
            <?php endif; ?>
        </ul>
    </div>

    <script>
        function showDocumentForm(tipo) {
            document.getElementById('form-avaliacao').style.display = 'none';
            document.getElementById('form-exames').style.display = 'none';

            if (tipo === 'avaliacao') {
                document.getElementById('form-avaliacao').style.display = 'block';
            } else if (tipo === 'exames') {
                document.getElementById('form-exames').style.display = 'block';
            }
        }

        function cancelUpload() {
            document.getElementById('form-avaliacao').style.display = 'none';
            document.getElementById('form-exames').style.display = 'none';
        }

        document.getElementById('file-upload-avaliacao').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Nenhum arquivo selecionado';
            document.getElementById('file-name-avaliacao').textContent = fileName;
        });

        document.getElementById('file-upload-exames').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Nenhum arquivo selecionado';
            document.getElementById('file-name-exames').textContent = fileName;
        });
    </script>
</body>
</html>
