<?php
session_start();

include '../db/conexao.php';

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    $stmt = $conn->prepare("SELECT id_aluno FROM aluno WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado!'); window.history.back();</script>";
    } else {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT); 
        $fk_personal_id = $_SESSION['usuario_id'];

        $stmt = $conn->prepare("INSERT INTO aluno (nome_aluno, email, senha, fk_personal_id_personal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nome, $email, $senha_hashed, $fk_personal_id);

        if ($stmt->execute()) {
            echo '<script>alert("Aluno criado com sucesso!"); window.location.href = "../views/personal/perfil_personal.php";</script>';
            exit();
        } else {
            echo "Erro ao cadastrar o aluno: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
