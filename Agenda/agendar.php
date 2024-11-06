<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$clienteNome = $input['clienteNome'];
$email = $input['email'];
$cachorroNome = $input['cachorroNome'];
$motivoContato = $input['motivoContato'];
$data = $input['data'];
$horario = $input['horario'];

// Conexão com o banco de dados

$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['mensagem' => 'Erro de conexão: ' . $conn->connect_error]));
}

// Verifica se o horário já está agendado
$sql = "SELECT * FROM agendamentos WHERE data = '$data' AND horario = '$horario'";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM tutores WHERE email = '$email'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {

if ($result->num_rows > 0) {
    echo json_encode(['mensagem' => 'Horário já agendado!']);
} else {
    // Insere novo agendamento
    $sql = "INSERT INTO agendamentos (cliente_nome, email, cachorro_nome, motivo_contato, data, horario) VALUES ('$clienteNome', '$email', '$cachorroNome', '$motivoContato', '$data', '$horario')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['mensagem' => 'Agendamento realizado com sucesso!']);
    } else {
        echo json_encode(['mensagem' => 'Erro ao agendar: ' . $conn->error]);
    }
}

} else {
echo json_encode(['mensagem' => 'Tutor ou email ainda não cadastrados!']);
}

$conn->close();
?>
