<?php session_start(); // aluno?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Anamnese</title>
    <link rel="stylesheet" href="../assets/css/ficha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png"> 
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1>Ficha de Anamnese</h1>
        <form action="salvar_respostaAL.php" method="POST">
            <fieldset>
                <legend>Dados Pessoais</legend>
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="data-nascimento">Data de Nascimento:</label>
                <input type="date" id="data-nascimento" name="data-nascimento" required>
                
                <label>Sexo:</label>
                <div class="radio-group">
                    <input type="radio" id="sexo-m" name="sexo" value="Masculino">
                    <label for="sexo-m">Masculino</label>
                    <input type="radio" id="sexo-f" name="sexo" value="Feminino">
                    <label for="sexo-f">Feminino</label>
                </div>
                
                
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="contato-emergencia">Contato de Emergência:</label>
                <input type="text" id="contato-emergencia" name="contato-emergencia" required>
            </fieldset>

            <fieldset>
                <legend>Saúde</legend>
                <label>Pratica Atividade Física?</label>
                <div class="radio-group">
                    <input type="radio" id="atividade-s" name="atividade" value="Sim">
                    <label for="atividade-s">Sim</label>
                    <input type="radio" id="atividade-n" name="atividade" value="Não">
                    <label for="atividade-n">Não</label>
                </div>
                
                <div id="atividade-info" class="hidden">
                    <label for="atividade-tipo">Se sim, quais e há quanto tempo:</label>
                    <input type="text" id="atividade-tipo" name="atividade-tipo">
                    
                </div>

                <label for="peso">Peso (kg):</label>
                <input type="number" id="peso" name="peso" step="0.1" required>
                
                <label for="estatura">Estatura (cm):</label>
                <input type="number" id="estatura" name="estatura" step="0.1" required>
                
                <label>Tem alguns desses sintomas ao praticar atividades físicas?</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="tontura" name="sintomas" value="Tontura">
                    <label for="tontura">Tontura</label>
                    <input type="checkbox" id="mal-estar" name="sintomas" value="Mal Estar">
                    <label for="mal-estar">Mal Estar</label>
                    <input type="checkbox" id="enjoo" name="sintomas" value="Enjoo">
                    <label for="enjoo">Enjoo</label>
                </div>
                
                <label for="outro-desconforto">Algum outro desconforto?</label>
                <input type="text" id="outro-desconforto" name="outro-desconforto">
                
                <label>Fumante?</label>
                <div class="radio-group">
                    <input type="radio" id="fumante-s" name="fumante" value="Sim">
                    <label for="fumante-s">Sim</label>
                    <input type="radio" id="fumante-n" name="fumante" value="Não">
                    <label for="fumante-n">Não</label>
                </div>
                
                <div id="fumante-info" class="hidden">
                    <label for="fumante-tempo">Se sim, há quanto tempo?</label>
                    <input type="text" id="fumante-tempo" name="fumante-tempo">
                </div>

                <label>Teve lesão/cirurgia/quebrou algo?</label>
                <div class="radio-group">
                    <input type="radio" id="lesao-s" name="lesao" value="Sim">
                    <label for="lesao-s">Sim</label>
                    <input type="radio" id="lesao-n" name="lesao" value="Não">
                    <label for="lesao-n">Não</label>
                </div>
                
                <div id="lesao-info" class="hidden">
                    <label for="lesao-tempo">Há quanto tempo e qual foi o tratamento?</label>
                    <input type="text" id="lesao-tempo" name="lesao-tempo">
                </div>
                
                <label for="problemas-saude">Tem algum problema de saúde? Se sim, quais?</label>
                <input type="text" id="problemas-saude" name="problemas-saude">
                
                <label for="alergias">Alergias:</label>
                <input type="text" id="alergias" name="alergias">
                
                <label for="tratamento-medico">Faz algum tratamento médico?</label>
                <input type="text" id="tratamento-medico" name="tratamento-medico">
                
                <label for="medicamento">Toma algum medicamento?</label>
                <input type="text" id="medicamento" name="medicamento">
                
                <label for="frequencia-treino">Quantas vezes na semana pretende treinar?</label>
                <input type="number" id="frequencia-treino" name="frequencia-treino" required>

              
                <label>Objetivo:</label>
                <input type="text" id="Objetivo" name="Objetivo">
            </fieldset>

            <a href="../controllers/modeloAL.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Voltar
              </a>
            <button type="submit">Enviar</button>

           
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="atividade"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('atividade-info').classList.toggle('hidden', this.value === 'Não');
            });
        });

        document.querySelectorAll('input[name="fumante"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('fumante-info').classList.toggle('hidden', this.value === 'Não');
            });
        });

        document.querySelectorAll('input[name="lesao"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('lesao-info').classList.toggle('hidden', this.value === 'Não');
            });
        });
    </script>

<script src="../assets/js/ficha.js"></script>
</body>
</html>
