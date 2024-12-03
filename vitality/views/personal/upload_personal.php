<?php
session_start();
include '../../db/conexao.php'; 

$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";

$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_personal = $_SESSION['usuario_id']; 

    // Remover a foto e restaurar a foto padrão
    if (isset($_POST['remover_foto']) && $_POST['remover_foto'] == 1) {
        // Selecionar a foto atual do banco de dados
        $sql = "SELECT foto_perfil_personal FROM personal WHERE id_personal='$id_personal'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $foto_antiga = $row['foto_perfil_personal'];

            // Definir a foto padrão
            $foto_padrao = "Profile-PNG-File.png"; // Ou o caminho correto da foto padrão
            
            // Remover a foto antiga se não for a foto padrão
            if ($foto_antiga != $foto_padrao && file_exists("../../assets/uploads/personais/" . $foto_antiga)) {
                unlink("../../assets/uploads/personais/" . $foto_antiga); 
            }
        }

        // Atualizar a foto no banco de dados
        $sql = "UPDATE personal SET foto_perfil_personal = ? WHERE id_personal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $foto_padrao, $id_personal);
        
        if ($stmt->execute()) {
            header("Location: editar_personal.php?success=1");
            exit();
        } else {
            echo "Erro ao remover a foto: " . $stmt->error;
        }
        $stmt->close();
    }

    // Fazer upload de uma nova foto
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../assets/uploads/personais/";
        $new_file_name = uniqid('personal_', true) . "." . strtolower(pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION)); // Nome único
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;

        // Verificar se o arquivo é uma imagem
        $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
        if ($check === false) {
            echo "O arquivo não é uma imagem.";
            $uploadOk = 0;
        }

        // Limitar o tamanho do arquivo (5MB)
        if ($_FILES["foto_perfil"]["size"] > 5000000) {
            echo "Desculpe, o arquivo é muito grande.";
            $uploadOk = 0;
        }

        // Somente permitir certos formatos de arquivo
        if (!in_array(strtolower(pathinfo($target_file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Desculpe, somente arquivos JPG, JPEG, PNG e GIF são permitidos.";
            $uploadOk = 0;
        }

        // Se o upload estiver OK, mover o arquivo para a pasta e atualizar o banco de dados
        if ($uploadOk == 1) {
            // Remover a foto antiga antes de enviar a nova
            $sql = "SELECT foto_perfil_personal FROM personal WHERE id_personal='$id_personal'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $foto_antiga = $row['foto_perfil_personal'];

                if ($foto_antiga != 'Profile-PNG-File.png' && file_exists("../../assets/uploads/personais/" . $foto_antiga)) {
                    unlink("../../assets/uploads/personais/" . $foto_antiga); 
                }
            }

            // Tentar enviar o arquivo
            if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
                // Atualizar o caminho da nova foto no banco de dados
                $sql = "UPDATE personal SET foto_perfil_personal = ? WHERE id_personal = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_file_name, $id_personal);
                
                if ($stmt->execute()) {
                    header("Location: editar_personal.php?success=1"); 
                    exit();
                } else {
                    echo "Erro ao atualizar a foto: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Desculpe, houve um erro ao enviar seu arquivo.";
            }
        } else {
            echo "Desculpe, seu arquivo não foi enviado.";
        }
    }
}

$conn->close();
?>
