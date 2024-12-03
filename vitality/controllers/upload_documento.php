<?php
session_start();
include '../db/conexao.php';

$id_aluno = $_SESSION['usuario_id'];

$query_personal = "SELECT fk_personal_id_personal FROM solicitacoes WHERE fk_aluno_id_aluno = ? LIMIT 1";
$stmt_personal = $conn->prepare($query_personal);
$stmt_personal->bind_param("i", $id_aluno);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();
$row_personal = $result_personal->fetch_assoc();
$id_personal = $row_personal['fk_personal_id_personal'] ?? null;
$stmt_personal->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_documento'])) {
    $descricao = $_POST['description'] ?? '';
    $tipo_documento = $_POST['tipo_documento'];
    $upload_dir = $tipo_documento === 'Avaliação Física' 
        ? "../assets/uploads/alunos/avaliacao/" 
        : "../assets/uploads/alunos/documento/";

    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];

        $file_info = pathinfo($_FILES['file_upload']['name']);
        $file_extension = strtolower($file_info['extension']);
        $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['file_upload']['name']));
        $upload_file = $upload_dir . $file_name;

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>alert('Extensão de arquivo não permitida. Permitido: " . implode(', ', $allowed_extensions) . "');</script>";
            exit;
        }
        if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_file)) {
            $stmt = $conn->prepare("UPDATE solicitacoes SET documento = ?, status = 'Baixada', descricao = ? 
                                    WHERE fk_aluno_id_aluno = ? AND fk_personal_id_personal = ? AND tipo_documento = ? LIMIT 1");
            $stmt->bind_param("ssiss", $file_name, $descricao, $id_aluno, $id_personal, $tipo_documento);

            if ($stmt->execute()) {
                echo "<script>alert('Solicitação atualizada com sucesso!'); window.history.back();</script>";
            } else {
                error_log("Erro no banco de dados: " . $stmt->error);
                echo "<script>alert('Erro ao atualizar a solicitação: " . htmlspecialchars($stmt->error) . "');</script>";
            }
            $stmt->close();
        } else {
            error_log("Falha ao mover o arquivo para: $upload_file");
            echo "<script>alert('Falha ao mover o arquivo. Verifique permissões e caminho.');</script>";
        }
    } else {
        error_log("Erro no upload do arquivo: " . $_FILES['file_upload']['error']);
        echo "<script>alert('Erro no upload do arquivo. Código do erro: " . $_FILES['file_upload']['error'] . "');</script>";
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