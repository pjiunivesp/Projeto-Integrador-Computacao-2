<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Obter a data selecionada
$data = $_GET['data'] ?? null;

if ($data) {
    // Horários padrão
    $horariosPossiveis = [
        '09:00:00', '10:00:00', '11:00:00',
        '14:00:00', '15:00:00', '16:00:00'
    ];

    // Verifica quais horários já estão ocupados
    $sql = "SELECT horario FROM agendamentos WHERE data = '$data'";
    $result = $conn->query($sql);
    $horariosOcupados = [];

    while ($row = $result->fetch_assoc()) {
        $horariosOcupados[] = $row['horario'];
    }

    // Filtra os horários disponíveis
    $horariosDisponiveis = array_diff($horariosPossiveis, $horariosOcupados);
    echo json_encode(['disponiveis' => array_values($horariosDisponiveis)]);
} else {
    echo json_encode(['erro' => 'Data não fornecida']);
}

$conn->close();
?>
