<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";

$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cref = $_POST['cref'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id_personal FROM personal WHERE cref = ?");
    $stmt->bind_param("s", $cref);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este CREF já está cadastrado.";
    } else {
        $stmt = $conn->prepare("INSERT INTO personal (nome_personal, cref, email, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $cref, $email, $senha);

        if ($stmt->execute()) {
            $id = $conn->insert_id;
            
            header("Location: perfil_personal.php?id=$id");
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>
