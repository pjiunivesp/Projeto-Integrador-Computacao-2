<?php
session_start(); // Inicia a sessão

$servername = "sql112.infinityfree.com"; 
$username = "if0_36252759"; 
$password = "IEDmneAVpmLnxU"; 
$dbname = "if0_36252759_adestramento"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['tutor_id'])) {
	echo "<script> alert ('Você deve cadastrar um tutor primeiro!'); history.back();</script>";
        //die("Você deve cadastrar um tutor primeiro.");
    }

    $tutor_id = $_SESSION['tutor_id']; // Obtém o ID do tutor da sessão
    $nome_aluno = $_POST['student-name'];
    $raca = $_POST['dog-breed'];
    $idade = $_POST['student-age'];
    $sexo = $_POST['gender'];
    $castrado = $_POST['castrated'];

    $sql = "INSERT INTO caes (tutor_id, nome_aluno, raca, idade, sexo, castrado) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississ", $tutor_id, $nome_aluno, $raca, $idade, $sexo, $castrado);

    if ($stmt->execute()) {
	echo "<script> alert ('Cão cadastrado com sucesso!'); history.back();</script>";
        
    } else {
        echo "Erro ao cadastrar cão: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
