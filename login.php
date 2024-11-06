<?php
session_start();

// Conexão com o banco de dados
$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Consulta para buscar o usuário
    $sql = "SELECT * FROM tutores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifica a senha
        if (password_verify($senha, $row['senha_hash'])) {
            // Senha correta, inicia sessão
            $_SESSION['email'] = $row['email']; // Armazena o email na sessão

            // Verifica se o usuário é admin
            if ($row['email'] === 'admin@feadestra.com.br') {
                header("Location: Agenda/admin.php"); // Redireciona para a página de admin
            } else {
                header("Location: Agenda/agendamentos.php"); // Redireciona para a página de agendamentos
            }
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    $stmt->close();
}
$conn->close();
?>
