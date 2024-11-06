<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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
$status = $data['status'];

// Atualizar status
$sql = "UPDATE agendamentos SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $id);

if ($stmt->execute()) {
    // Se o status for cancelado, liberar o horário
    if ($status == 'cancelado') {
        // Aqui você pode usar um campo para manter o registro de que o horário foi liberado
        $sql = "UPDATE agendamentos SET horario = '00:00:00' WHERE id = ?";
        $stmtLiberar = $conn->prepare($sql);
        $stmtLiberar->bind_param('i', $id);
        $stmtLiberar->execute();
        $stmtLiberar->close();
    }
    echo json_encode(['mensagem' => 'Status alterado com sucesso!']);
} else {
    echo json_encode(['erro' => 'Erro ao alterar status: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
