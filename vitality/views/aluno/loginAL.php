<?php
session_start();
include '../../db/conexao.php'; 

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_aluno = "SELECT * FROM aluno WHERE email = ?";
    $stmt_aluno = $conn->prepare($sql_aluno);
    $stmt_aluno->bind_param("s", $email);
    $stmt_aluno->execute();
    $result_aluno = $stmt_aluno->get_result();

    if ($result_aluno->num_rows > 0) {
        $row = $result_aluno->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id_aluno']; 
            $_SESSION['tipo_usuario'] = 'Aluno'; 
            header("Location: perfil_aluno.php"); 
            exit();
        } else {
            echo "<script>alert('Usuário ou senha incorretos!'); window.history.back();</script>";
            exit();
        }
    }

    // Se nenhum usuário foi encontrado
    $_SESSION['error_message'] = "Usuário não encontrado.";
    header("Location: ../../index.html"); 
    exit();
    ?>