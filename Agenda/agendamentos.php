<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    echo "Email não encontrado.";
    exit();
}

$email = $_SESSION['email'];

// Função para obter agendamentos do usuário logado
function obterAgendamentos($conn, $email) {
    $sql = "SELECT * FROM agendamentos WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

$agendamentos = obterAgendamentos($conn, $email);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Agendamentos</title>
    <link rel="stylesheet" href="style.css">

<style>
/* Estilo para o botão de logout */
.logout-button {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 15px;
    background-color: #f44336; /* Vermelho */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.logout-button:hover {
            background-color: #d32f2f; /* Vermelho escuro ao passar o mouse */
        }
</style>

</head>
<body>
<a href="../logout.php" class="logout-button">Sair</a>
    <h1>Meus Agendamentos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Cliente</th>
                <th>Email</th>
                <th>Nome do Cão</th>
                <th>Motivo do Contato</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $agendamentos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['cliente_nome']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['cachorro_nome']; ?></td>
                    <td><?php echo $row['motivo_contato']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td><?php echo $row['horario']; ?></td>
                    <td><?php echo $row['status']; ?></td>
               </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    
</body>
</html>
