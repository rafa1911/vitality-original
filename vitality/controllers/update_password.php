<?php session_start();?>
<?php
header('Content-Type: application/json');

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "vitality"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['senha']) || !isset($data['tipo'])) {
    echo json_encode(["success" => false, "message" => "Dados incompletos."]);
    exit();
}

$email = $conn->real_escape_string($data['email']);
$senha = $conn->real_escape_string($data['senha']);
$tipo = $conn->real_escape_string($data['tipo']); 

$hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

if ($tipo === 'aluno') {
    $sql = "UPDATE alunos SET senha = ? WHERE email = ?";
} else if ($tipo === 'personal') {
    $sql = "UPDATE personal SET senha = ? WHERE email = ?";
} else {
    echo json_encode(["success" => false, "message" => "Tipo de usuário inválido."]);
    exit();
}

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $hashedPassword, $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Senha atualizada com sucesso."]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao atualizar a senha."]);
}

$stmt->close();
$conn->close();
?>
