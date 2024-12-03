<?php
include_once '../db/conexao.php';
session_start();

$id_alun = $_SESSION['usuario_id'];

$nome = $_POST['nome'];
$dataNascimento = $_POST['data-nascimento'];
$sexo = $_POST['sexo'];
$email = $_POST['email'];
$contatoEmergencia = $_POST['contato-emergencia'];
$atividade = $_POST['atividade'];
$atividadeTipo = isset($_POST['atividade-tipo']) ? $_POST['atividade-tipo'] : null;
$peso = $_POST['peso'];
$estatura = $_POST['estatura'];
$sintomas = isset($_POST['sintomas']);
$outroDesconforto = $_POST['outro-desconforto'];
$fumante = $_POST['fumante'];
$fumanteTempo = isset($_POST['fumante-tempo']) ? $_POST['fumante-tempo'] : null;
$lesao = $_POST['lesao'];
$lesaoTempo = isset($_POST['lesao-tempo']) ? $_POST['lesao-tempo'] : null;
$problemasSaude = $_POST['problemas-saude'];
$alergias = $_POST['alergias'];
$tratamentoMedico = $_POST['tratamento-medico'];
$medicamento = $_POST['medicamento'];
$frequenciaTreino = $_POST['frequencia-treino'];
$objetivo = $_POST['Objetivo'];

$sql = "INSERT INTO respostas 
            (nome, data_nascimento, sexo, email, contato_emergencia, atividade, atividade_tipo, peso, estatura, sintomas, outro_desconforto, fumante, fumante_tempo, lesao, lesao_tempo, problemas_saude, alergias, tratamento_medico, medicamento, frequencia_treino, objetivo, fk_aluno_id_aluno)
        VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    'sssssssdsssssssssssssi',
    $nome, $dataNascimento, $sexo, $email, $contatoEmergencia, $atividade, $atividadeTipo, $peso, $estatura, $sintomas, $outroDesconforto, $fumante, $fumanteTempo, $lesao, $lesaoTempo, $problemasSaude, $alergias, $tratamentoMedico, $medicamento, $frequenciaTreino, $objetivo, $id_alun
);

if ($stmt->execute()) {
    echo "Ficha de anamnese salva com sucesso!";
} else {
    echo "Erro ao salvar a ficha: " . $stmt->error;
}

$stmt->close();
$conn->close();