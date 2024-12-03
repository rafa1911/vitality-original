<?php
session_start();


$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";
$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id_aluno = $_SESSION['usuario_id']; 

$sql = "SELECT foto_perfil_aluno FROM aluno WHERE id_aluno=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $foto_perfil_aluno = $row['foto_perfil_aluno'] ? $row['foto_perfil_aluno'] : '../../assets/img/Profile-PNG-File.png';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/editar_foto.css">
    <link rel="icon" href="../img/favicon.svg" type="image/svg+xml">
    <title>Editar Foto de Perfil</title>
</head>
<body>
    <div class="container">
        <h1>Editar Foto de Perfil</h1>
        <div class="foto-atual">
            <h3>Foto Atual:</h3>
            <img class="foto-perfil" src="<?php echo file_exists("../../assets/uploads/alunos/" . htmlspecialchars($foto_perfil_aluno)) ? "../../assets/uploads/alunos/" . htmlspecialchars($foto_perfil_aluno) : '../../assets/img/Profile-PNG-File.png'; ?>" alt="foto do usuario" width="150">
        </div>

        <form action="upload_aluno.php" method="POST" enctype="multipart/form-data">
            <label for="foto_perfil">Escolha uma nova foto de perfil:</label>
            <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onchange="previewImage(event)">
            <p id="file-chosen">Nenhum arquivo escolhido</p>
            <div class="preview">
                <img id="preview" alt="Preview da nova foto" style="display: none;">
            </div>
            <button type="submit" name="atualizar_foto">Atualizar Foto</button>
        </form>

        <form action="upload_aluno.php" method="POST">
            <input type="hidden" name="remover_foto" value="1">
            <button type="submit" name="remover_foto_btn">Remover Foto</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const fileName = event.target.files[0] ? event.target.files[0].name : "Nenhum arquivo escolhido";
            document.getElementById('file-chosen').textContent = fileName;

            const preview = document.getElementById('preview');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; 
                }
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.style.display = 'none'; 
            }
        }
    </script>
</body>
</html>