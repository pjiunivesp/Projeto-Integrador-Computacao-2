


// INICIO DO SCRIPT AGENDA
// script.js

document.getElementById('data').addEventListener('change', function() {
    const dataSelecionada = this.value;
    const horarioSelect = document.getElementById('horario');
    
    // Limpar opções anteriores
    horarioSelect.innerHTML = '<option value="">Selecione um horário</option>';

    if (dataSelecionada) {
        fetch(`Agenda/disponibilidade.php?data=${dataSelecionada}`)
            .then(response => response.json())
            .then(data => {
                if (data.disponiveis) {
                    data.disponiveis.forEach(horario => {
                        const option = document.createElement('option');
                        option.value = horario;
                        option.textContent = horario;
                        horarioSelect.appendChild(option);
                    });
                } else {
                    console.error(data.erro);
                }
            })
            .catch(error => console.error('Erro:', error));
    }
});

document.getElementById('agendamentoForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const clienteNome = document.getElementById('clienteNome').value;
    const email = document.getElementById('email').value;
    const cachorroNome = document.getElementById('cachorroNome').value;
    const motivoContato = document.getElementById('motivoContato').value;
    const data = document.getElementById('data').value;
    const horario = document.getElementById('horario').value;

    fetch('Agenda/agendar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ clienteNome, email, cachorroNome, motivoContato, data, horario }),
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('mensagem').innerText = data.mensagem;
    })
    .catch(error => console.error('Erro:', error));
});

// FIM DO SCRIPT DA AGENDA
