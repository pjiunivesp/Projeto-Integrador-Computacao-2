<?php
header('Content-Type: application/json');

$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $conn->connect_error]);
    exit();
}

$email = $_GET['email'] ?? '';

if ($email) {
    // Primeiro, obtemos o tutor_id baseado no email
    $sql = "SELECT id FROM tutores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tutor = $result->fetch_assoc();
        $tutor_id = $tutor['id'];

        // Agora, buscamos os cães usando o tutor_id
        $sql = "SELECT * FROM caes WHERE tutor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tutor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $caes = [];
        while ($row = $result->fetch_assoc()) {
            $caes[] = $row;
        }

        echo json_encode(['success' => true, 'caes' => $caes]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tutor não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email inválido.']);
}

$conn->close();
?>
