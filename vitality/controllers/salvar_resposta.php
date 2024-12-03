<?php
include 'conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_ficha = $_POST['id_ficha'];
    $id_aluno = $_SESSION['id']; 
    $respostas = $_POST['respostas'];
    
    $stmt = $conn->prepare("INSERT INTO respostas (id_ficha, id_aluno, respostas, data_resposta, nova) VALUES (?, ?, ?, NOW(), 1)");
    $stmt->bind_param("iis", $id_ficha, $id_aluno, $respostas);
    
    if ($stmt->execute()) {
        echo "Resposta salva com sucesso!";
    } else {
        echo "Erro ao salvar resposta: " . $stmt->error;
    }

    $stmt->close();
}
?>
