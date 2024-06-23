<!doctype html>
<html lang="pt-br">
<head>
    <title>Avaliação de Disciplinas</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo.svg">

    <!-- Link to the stylesheet -->
    <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
<body>
    <!-- Header section -->
    <div class="header">
        <div class="logo_name">
            <img src="images/logo.svg" alt="Logo" class="logo">
            <h1>Avaliação de Disciplinas</h1>
        </div>
        <div class="line"></div>
        <div class="line" id="standart"></div>
        <div class="line" id="darker"></div>
    </div>
    <?php
    session_start();
    if (isset($_SESSION['incorrect_password'])) {
        echo '
        <a class="error" id="error_password" onclick="fecharerror_password()">
            <span class="error_text">Usuário ou senha informados são incorretos.</span>
            <img src="images\close.svg" alt="close" class="close">
        </a>
        <script>
            function fecharerror_password() {
                var error_password = document.getElementById("error_password");
                error_password.style.display = "none";
            }
        </script>
        ';
        unset($_SESSION['incorrect_password']);
    };
    if (isset($_SESSION['new_password'])) {
        echo '
        <a class="error" id="error_password" onclick="fecharerror_password()">
            <span class="error_text">Uma nova senha foi enviada para o endereço de e-mail cadastrado.</span>
            <img src="images\close.svg" alt="close" class="close">
        </a>
        <script>
            function fecharerror_password() {
                var error_password = document.getElementById("error_password");
                error_password.style.display = "none";
            }
        </script>
        ';
        unset($_SESSION['new_password']);
    };
    ?>
    <!-- Content section -->
    <div class="content">
        <div class="block" id="login">
            <!-- Login form -->
            <form action="controllers/login.php" method="POST" class="login">
                <input class="login" type="text" name="username" placeholder="Identificação ou e-mail" required>
                <input class="login" type="password" name="password" placeholder="Senha" required>
                <button type="submit">ENTRAR</button>
                <a class="button_negative" href="views/nova_senha.php">REDEFINIR SENHA</a>
            </form>
        </div>
        <div class="info">
                <h4 class="h4-info">Primeiro acesso?</h4>
                <p>Para iniciar, selecione "Redefinir Senha" e forneça seu número de identificação ou e-mail. 
                    Você receberá instruções para definir sua senha através do e-mail cadastrado.</p>
            <h4 class="h4-info">O que é a Aplicação de Avaliação de Disciplinas?</h4>
            <p>O projeto é uma aplicação de desenvolvimento web concebido na Escola Politécnica da USP para 
            aprimorar a avaliação de disciplinas acadêmicas e promover a constante melhoria da didática nas aulas.
            <br><br>
            A aplicação é de código aberto, com todo o seu código-fonte acessível no GitHub, 
            disponibilizado na seção Desenvolvedores abaixo.
            </p>
        </div>
    </div>
    <!-- Footer section -->
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Desenvolvedores</a>
            <a href="https://teste.123" class="footer">Termos de Uso</a>
        </div>
    </div>
</body>
</html>