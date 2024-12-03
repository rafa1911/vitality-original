// document.getElementById('login_button').addEventListener('click', function() {
//     const selectedOption = document.querySelector('input[name="user_tipo"]:checked');

//     if (selectedOption) {
//         // Adiciona a classe que ativa a transição
//         document.getElementById('choice-screen').style.opacity = '0';
//         document.getElementById('choice-screen').style.transform = 'translateX(-100%)';

//         const nextScreen = document.getElementById('next-screen');
//         nextScreen.classList.remove('hidden');
//         nextScreen.classList.add('show');
        
//         // Opcional: Redireciona após a animação
//         setTimeout(function() {
//             window.location.href = 'index.html'; // Substitua com o URL da tela seguinte
//         }, 1000); // Espera o tempo da animação para redirecionar
//     } else {
//         alert('Por favor, selecione uma opção.');
//     }
// });


document.getElementById('login_form').addEventListener('submit', function(event) {
    const selectedOption = document.querySelector('input[name="tipo_usuario"]:checked');

    if (!selectedOption) {
        event.preventDefault(); // Impede o envio do formulário
        alert('Por favor, selecione uma opção.'); // Mostra o alerta
    } else {
        // Adiciona a classe que ativa a transição
        document.getElementById('choice-screen').style.opacity = '0';
        document.getElementById('choice-screen').style.transform = 'translateX(-100%)';

        const nextScreen = document.getElementById('next-screen');
        if (nextScreen) {
            nextScreen.classList.remove('hidden');
            nextScreen.classList.add('show');
        }
        
        // Redireciona para a página correta após a animação
        setTimeout(function() {
            if (selectedOption.value === 'Aluno') {
                window.location.href = '../aluno/aluno_login.php'; // Página de login do aluno
            } else if (selectedOption.value === 'Personal') {
                window.location.href = '../personal/personal_login.php'; // Página de login do personal
            }
        }, 1000); // Espera o tempo da animação para redirecionar
    }
});
