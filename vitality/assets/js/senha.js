document.addEventListener('DOMContentLoaded', () => {
    const steps = Array.from(document.querySelectorAll('.step'));
    const forms = Array.from(document.querySelectorAll('.form-step'));
    const nextButtons = document.querySelectorAll('.next-btn');
    const prevButtons = document.querySelectorAll('.prev-btn');

    let currentStepIndex = 0;
    let verificationCode = '';

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle('active', i === index);
        });
        forms.forEach((form, i) => {
            form.classList.toggle('active', i === index);
        });
        currentStepIndex = index;
    }

    function validateEmail() {
        const email = document.getElementById('email').value;
        const emailWarning = document.getElementById('email-warning');
        let isValid = true;

        emailWarning.style.display = 'none';

        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            emailWarning.style.display = 'block';
            isValid = false;
        }

        return isValid;
    }

    function validateCode() {
        const userCode = document.getElementById('cod').value;
        const codWarning = document.getElementById('cod-warning');
        let isValid = true;

        codWarning.style.display = 'none';

        if (userCode !== verificationCode) {
            codWarning.style.display = 'block';
            isValid = false;
        }

        return isValid;
    }

    function validatePassword() {
        const newPassword = document.getElementById('novasenha').value;
        const confirmPassword = document.getElementById('cnsenha').value;
        const newPasswordWarning = document.getElementById('novasenha-warning');
        const confirmPasswordWarning = document.getElementById('cnsenha-warning');

        let isValid = true;

        newPasswordWarning.style.display = 'none';
        confirmPasswordWarning.style.display = 'none';

        if (newPassword.length !== 6) {
            newPasswordWarning.style.display = 'block';
            isValid = false;
        }

        if (newPassword !== confirmPassword) {
            confirmPasswordWarning.style.display = 'block';
            isValid = false;
        }

        return isValid;
    }

    function saveFormData() {
        const email = document.getElementById('email').value;
        const newPassword = document.getElementById('novasenha').value;

        localStorage.setItem('email', email);
        localStorage.setItem('newPassword', newPassword);
    }

    function showSuccessData() {
        const email = localStorage.getItem('email');
        const newPassword = localStorage.getItem('newPassword');

        document.getElementById('success-email').textContent = email;
        document.getElementById('success-password').textContent = newPassword;
    }

    // Configura o envio do e-mail e código de verificação
    document.getElementById('send-email-btn').addEventListener('click', function() {
        if (validateEmail()) {
            const email = document.getElementById('email').value;
            verificationCode = Math.floor(100000 + Math.random() * 900000).toString(); // Gera código de 6 dígitos

            const templateParams = {
                name: 'Vitality',
                destino: email,
                message: `Seu código de verificação é: ${verificationCode}`
            };

            emailjs.send('vitality', 'template_cf22syt', templateParams)
                .then(function(response) {
                    alert('E-mail enviado com sucesso!');
                    showStep(1); 
                }, function(error) {
                    alert('Erro ao enviar e-mail: ' + JSON.stringify(error));
                });
        }
    });

    nextButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            if (index === 0 && validateEmail()) { // Etapa 1
                showStep(currentStepIndex + 1);
            } else if (index === 1 && validateCode()) { // Etapa 2
                showStep(currentStepIndex + 1);
            } else if (index === 2 && validatePassword()) { // Etapa 3
                saveFormData();
                showStep(currentStepIndex + 1);
            }
        });
    });

    prevButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            showStep(currentStepIndex - 1);
        });
    });

    function continueToNextPage() {
        window.location.href = '';
    }

    // Inicializa com a primeira etapa visível
    showStep(0);

    // Mostrar dados de sucesso na etapa 4
    if (currentStepIndex === 3) {
        showSuccessData();
    }
});
