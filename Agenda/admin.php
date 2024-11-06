<?php
// Conexão com o banco de dados

$servername = "sql112.infinityfree.com";
$username = "if0_36252759";
$password = "IEDmneAVpmLnxU";
$dbname = "if0_36252759_adestramento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para obter agendamentos
function obterAgendamentos($conn) {
    $sql = "SELECT * FROM agendamentos";
    return $conn->query($sql);
}

$agendamentos = obterAgendamentos($conn);
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

        /* Estilo do popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 500;
        }
    </style>
</head>
<body>
<a href="../logout.php" class="logout-button">Sair</a>
    <h1>Agendamentos</h1>
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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $agendamentos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['cliente_nome']; ?></td>
                    <td><a href="#" onclick="mostrarDados('<?php echo $row['email']; ?>')"><?php echo $row['email']; ?></a></td>
                    <td><a href="#" onclick="mostrarCaes('<?php echo $row['email']; ?>')"><?php echo $row['cachorro_nome']; ?></a></td>

                    <td><?php echo $row['motivo_contato']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td><?php echo $row['horario']; ?></td>
                    <td>
                        <select onchange="alterarStatus(<?php echo $row['id']; ?>, this.value)">
                            <option value="pendente" <?php echo $row['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="confirmado" <?php echo $row['status'] == 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                            <option value="atendido" <?php echo $row['status'] == 'atendido' ? 'selected' : ''; ?>>Atendido</option>
                            <option value="cancelado" <?php echo $row['status'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="reservarHorario(<?php echo $row['id']; ?>)">Alterar Horário</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="overlay" id="overlay" onclick="fecharPopup()"></div>
    <div class="popup" id="popup">
        <h2>Dados do Tutor/Cães</h2>
        <div id="dadosTutor"></div>
        <button onclick="fecharPopup()">Fechar</button>
    </div>

    <script>
        function mostrarDados(email) {
            fetch('obter_tutor.php?email=' + encodeURIComponent(email))
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const dados = data.tutor;
                        let html = `<p><strong>Nome:</strong> ${dados.nome}</p>`;
                        html += `<p><strong>Email:</strong> ${dados.email}</p>`;
			html += `<p><strong>Endereço:</strong> ${dados.endereco}</p>`;
                        html += `<p><strong>Telefone:</strong> ${dados.telefone}</p>`;
			html += `<p><strong>Uso de Imagem:</strong> ${dados.autorizacao_imagem}</p>`;
			html += `<p><strong>Data do Cadastro:</strong> ${dados.created_at}</p>`;
                        // Adicione outros campos conforme necessário
                        document.getElementById('dadosTutor').innerHTML = html;
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('popup').style.display = 'block';
                    } else {
                        alert("Erro ao carregar os dados do tutor.");
                    }
                })
                .catch(error => console.error('Erro:', error));
        }

        function fecharPopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        function alterarStatus(id, novoStatus) {
            fetch('alterar_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id, status: novoStatus }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.mensagem);
                // Reload ou atualizar a tabela se necessário
            })
            .catch(error => console.error('Erro:', error));
        }

        function reservarHorario(id) {
            const data = prompt("Digite a nova data (YYYY-MM-DD):");
            const horario = prompt("Digite o novo horário (HH:MM:SS):");

            if (data && horario) {
                fetch('reservar_horario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id, data, horario }),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensagem);
                    // Reload ou atualizar a tabela se necessário
                })
                .catch(error => console.error('Erro:', error));
            }
        }

function mostrarCaes(email) {
    fetch('obter_caes.php?email=' + encodeURIComponent(email))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const caes = data.caes;
                let html = '<h3>Cães do Tutor:</h3><ul>';
                caes.forEach(cao => {
                    html += `<br><li>Nome: ${cao.nome_aluno}<br>Raça: ${cao.raca}<br>Idade: ${cao.idade} anos<br>Sexo: ${cao.sexo}<br>Castrado: ${cao.castrado}<br>Data do Cadastro: ${cao.created_at}</li>`;
                });
                html += '</ul>';
                
                document.getElementById('dadosTutor').innerHTML = html;
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('popup').style.display = 'block';
            } else {
                alert("Erro ao carregar os cães do tutor.");
            }
        })
        .catch(error => console.error('Erro:', error));
}



    </script>
</body>
</html>
