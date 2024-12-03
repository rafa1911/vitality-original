<?php
session_start();

$foto_padrao = "Profile-PNG-File.png"; 
$target_dir = "../../assets/uploads/alunos/"; 

$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";

$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$aluno_id = $_SESSION['usuario_id']; 

// Caso o usuário tenha clicado em "Remover Foto"
if (isset($_POST['remover_foto'])) {
    // Selecionar a foto atual do banco de dados
    $sql = "SELECT foto_perfil_aluno FROM aluno WHERE id_aluno='$aluno_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foto_antiga = $row['foto_perfil_aluno'];

        // Se não for a foto padrão, remove da pasta
        if ($foto_antiga != $foto_padrao && file_exists($target_dir . $foto_antiga)) {
            unlink($target_dir . $foto_antiga); // Remove a foto antiga
        }
    }

    // Atualizar o banco de dados para restaurar a foto padrão
    $sql = "UPDATE aluno SET foto_perfil_aluno='$foto_padrao' WHERE id_aluno='$aluno_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Foto removida e foto padrão restaurada.";
        header("Location: perfil_aluno.php");
        exit();
    } else {
        echo "Erro ao atualizar o banco de dados: " . $conn->error;
    }
    $conn->close();
    exit();
}

// Verificar se uma nova foto foi enviada
if (isset($_FILES['foto_perfil'])) {
    $imageFileType = strtolower(pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION));
    $new_file_name = uniqid('aluno_', true) . "." . $imageFileType; // Nome único
    $target_file = $target_dir . $new_file_name;
    $uploadOk = 1;

    // Verificar se a imagem é real
    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Arquivo não é uma imagem.";
        $uploadOk = 0;
    }

    // Limitar o tamanho do arquivo (500KB)
    if ($_FILES["foto_perfil"]["size"] > 500000) {
        echo "Desculpe, seu arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permitir apenas formatos JPG, JPEG e PNG
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Desculpe, somente arquivos JPG, JPEG e PNG são permitidos.";
        $uploadOk = 0;
    }

    // Se o upload estiver OK, mover o arquivo para a pasta e atualizar o banco de dados
    if ($uploadOk == 1) {
        // Remover a foto antiga
        $sql = "SELECT foto_perfil_aluno FROM aluno WHERE id_aluno='$aluno_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $foto_antiga = $row['foto_perfil_aluno'];

            if ($foto_antiga != $foto_padrao && file_exists($target_dir . $foto_antiga)) {
                unlink($target_dir . $foto_antiga); // Remove a foto antiga
            }
        }

        // Mover o arquivo para a pasta de upload
        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
            // Atualizar o caminho da nova foto no banco de dados
            $sql = "UPDATE aluno SET foto_perfil_aluno='$new_file_name' WHERE id_aluno='$aluno_id'";
            if ($conn->query($sql) === TRUE) {
                echo "O arquivo " . htmlspecialchars($new_file_name) . " foi enviado e atualizado no banco de dados.";
                header("Location: perfil_aluno.php");
                exit(); // Parar a execução após o redirecionamento
            } else {
                echo "Erro ao atualizar o banco de dados: " . $conn->error;
            }
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    } else {
        echo "Desculpe, seu arquivo não foi enviado.";
    }
}

$conn->close();
?>
