


// SCRIPT AGENDA
// script.js

document.addEventListener('DOMContentLoaded', () => {
    const availableTimes = [
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '13:00 - 14:00',
        '14:00 - 15:00',
        '15:00 - 16:00'
    ];

    const availableTimesList = document.getElementById('available-times');
    const timeSelect = document.getElementById('time');

    availableTimes.forEach(time => {
        const listItem = document.createElement('li');
        listItem.textContent = time;
        availableTimesList.appendChild(listItem);

        const option = document.createElement('option');
        option.value = time;
        option.textContent = time;
        timeSelect.appendChild(option);
    });

    const bookingForm = document.getElementById('booking-form');
    bookingForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const dogName = document.getElementById('dog-name').value;
        const time = document.getElementById('time').value;

        alert(`Horário marcado com sucesso para ${dogName} (${name}) às ${time}.`);

        // Remover horário da lista de disponíveis
        const index = availableTimes.indexOf(time);
        if (index > -1) {
            availableTimes.splice(index, 1);
            timeSelect.remove(index + 1);
            availableTimesList.removeChild(availableTimesList.childNodes[index]);
        }
    });
});

// script.js

document.addEventListener('DOMContentLoaded', () => {
    const availableTimes = [];

    const availableTimesList = document.getElementById('available-times');
    const timeToRemoveSelect = document.getElementById('time-to-remove');
    const addTimeForm = document.getElementById('add-time-form');
    const removeTimeForm = document.getElementById('remove-time-form');

    // Função para atualizar a lista de horários disponíveis
    function updateAvailableTimes() {
        availableTimesList.innerHTML = '';
        timeToRemoveSelect.innerHTML = '';
        availableTimes.forEach(time => {
            const listItem = document.createElement('li');
            listItem.textContent = time;
            availableTimesList.appendChild(listItem);

            const option = document.createElement('option');
            option.value = time;
            option.textContent = time;
            timeToRemoveSelect.appendChild(option);
        });
    }

    // Adicionar novo horário
    addTimeForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const newTime = document.getElementById('new-time').value;
        if (!availableTimes.includes(newTime)) {
            availableTimes.push(newTime);
            updateAvailableTimes();
        } else {
            alert('Este horário já está disponível.');
        }
        addTimeForm.reset();
    });

    // Remover horário
    removeTimeForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const timeToRemove = document.getElementById('time-to-remove').value;
        const index = availableTimes.indexOf(timeToRemove);
        if (index > -1) {
            availableTimes.splice(index, 1);
            updateAvailableTimes();
        }
    });

    // Inicializar a lista de horários disponíveis
    updateAvailableTimes();
});
  //login

  // script.js

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Aqui você pode adicionar lógica de autenticação
        // Enviando os dados para um servidor para verificar as credenciais
        
        if (email && password) {
            alert('Login bem-sucedido!');
            // Redirecionar para a página principal ou painel do usuário
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
});
