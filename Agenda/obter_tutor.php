<?php
$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$email = $_GET['email'] ?? '';

if ($email) {
    $sql = "SELECT * FROM tutores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tutor = $result->fetch_assoc();
        echo json_encode(['success' => true, 'tutor' => $tutor]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tutor não encontrado.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Email inválido.']);
}

$conn->close();
?>
