<?php
session_start();
include '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: ID do personal não está definido na sessão.");
}

$id_personal = $_SESSION['usuario_id'];

if (!isset($_SESSION['id_aluno'])) {
    die("Erro: ID do aluno não está definido na sessão.");
}

$titulo_modelo = htmlspecialchars(trim($_POST['titulo'] ?? ''));
$descricao_modelo = htmlspecialchars(trim($_POST['modelo'] ?? ''));

if (empty($titulo_modelo) || empty($descricao_modelo)) {
    die("Erro: Título e descrição do modelo são obrigatórios.");
}

$conn->begin_transaction();

try {
    $query = "INSERT INTO modelos_ficha (titulo, descricao, fk_personal_id_personal) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $titulo_modelo, $descricao_modelo, $id_personal);
    $stmt->execute();
    $id_modelo = $conn->insert_id;
    $stmt->close();

    if (isset($_POST['perguntas']) && is_array($_POST['perguntas'])) {
        foreach ($_POST['perguntas'] as $index => $pergunta) {
            if (!isset($_POST['tipo_pergunta'][$index])) {
                throw new Exception("Erro: Tipo da pergunta não enviado.");
            }

            $tipo_pergunta = htmlspecialchars(trim($_POST['tipo_pergunta'][$index]));
            $pergunta_text = htmlspecialchars(trim($pergunta));

            $query = "INSERT INTO perguntas_modelo (pergunta, tipo, fk_modelo_id_modelo) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $pergunta_text, $tipo_pergunta, $id_modelo);
            $stmt->execute();
            $id_pergunta = $conn->insert_id;
            $stmt->close();

            if (($tipo_pergunta === 'radio' || $tipo_pergunta === 'checkbox') && isset($_POST['opcoes'][$index]) && is_array($_POST['opcoes'][$index])) {
                foreach ($_POST['opcoes'][$index] as $opcao) {
                    $opcao_text = htmlspecialchars(trim($opcao));
                    if (empty($opcao_text)) {
                        continue;
                    }

                    $query = "INSERT INTO opcoes_pergunta (opcao, fk_pergunta_id_pergunta) VALUES (?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $opcao_text, $id_pergunta);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    $conn->commit();
    echo "Modelo salvo com sucesso!";
    header('Location: modelo.php');
    exit;
} catch (Exception $e) {
    $conn->rollback();
    error_log("Erro ao salvar modelo: " . $e->getMessage());
    echo "Erro ao salvar modelo: " . $e->getMessage();
} finally {
    $conn->close();
}