<?php
session_start();
include '../db/conexao.php';

$id_aluno = $_SESSION['usuario_id'];
$modelo_id = $_GET['id'];
$respostas = $_POST['respostas'] ?? [];

if ($modelo_id <= 0 || empty($respostas)) {
    die("Erro: Dados incompletos.");
}

$conn->begin_transaction();

try {
    foreach ($respostas as $id_pergunta => $resposta) {
        if (is_array($resposta)) {
            foreach ($resposta as $resposta_individual) {
                $resposta_text = htmlspecialchars(trim($resposta_individual));

                if (!empty($resposta_text)) {
                    $query = "UPDATE perguntas_modelo SET resposta = ? WHERE id_pergunta = ? AND fk_modelo_id_modelo = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sii", $resposta_text, $id_pergunta, $modelo_id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        } else {
            $resposta_text = htmlspecialchars(trim($resposta));

            if (!empty($resposta_text)) {
                $query = "UPDATE perguntas_modelo SET resposta = ? WHERE id_pergunta = ? AND fk_modelo_id_modelo = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sii", $resposta_text, $id_pergunta, $modelo_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    $c = "s";

    $query = "UPDATE ficha_anamnese SET respondido = ? WHERE modelo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $c, $modelo_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo "Respostas salvas com sucesso!";
    header('Location: modeloAL.php');
    exit;
} catch (Exception $e) {
    $conn->rollback();
    error_log("Erro ao salvar respostas: " . $e->getMessage());
    echo "Erro ao salvar respostas: " . $e->getMessage();
} finally {
    $conn->close();
}
