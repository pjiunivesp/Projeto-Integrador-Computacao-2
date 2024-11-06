<?php
header('Content-Type: application/json');

// Conexão com o banco de dados

$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['erro' => 'Erro de conexão: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$dataNova = $data['data'];
$horarioNovo = $data['horario'];

$sql = "UPDATE agendamentos SET data = ?, horario = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $dataNova, $horarioNovo, $id);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Horário reservado com sucesso!']);
} else {
    echo json_encode(['erro' => 'Erro ao reservar horário: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
