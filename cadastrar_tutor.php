<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $nome = $_POST['tutor-name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Gera a hash da senha
    $endereco = $_POST['address'];
    $telefone = $_POST['phone'];
    $autorizacao = $_POST['image-authorization'];

    $sql = "INSERT INTO tutores (nome, email, senha_hash, endereco, telefone, autorizacao_imagem) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $email, $senha_hash, $endereco, $telefone, $autorizacao);

    if ($stmt->execute()) {
        $_SESSION['tutor_id'] = $stmt->insert_id; // Armazena o ID do tutor na sessão
	echo "<script> alert ('Tutor cadastrado com sucesso!'); history.back();</script>";
        // Redirecionar ou exibir mensagem para prosseguir ao cadastro do cão
    } else {
        echo "Erro ao cadastrar tutor: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
