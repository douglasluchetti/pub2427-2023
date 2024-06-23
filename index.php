<!doctype html>
<html lang="pt-br">
<head>
    <title>Avaliação de Disciplinas</title>
    <meta charset="utf-8">
    <!-- Link to the stylesheet -->
    <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
<body>
    <!-- Header section -->
    <div class="header">
        <div class="logo_name">
            <img src="images/logo.svg" alt="Logo" class="logo">
            <h1>Avaliação de Disciplinas Teste</h1>
        </div>
        <div class="line"></div>
        <div class="line" id="standart"></div>
        <div class="line" id="darker"></div>
    </div>
    <!-- Content section -->
    <div class="content">
        <div class="block" id="login">
            <!-- Login form -->
            <form action="controllers/login.php" method="POST" class="login">
                <input class="login" type="text" name="username" placeholder="Identificação ou e-mail" required>
                <input class="login" type="password" name="password" placeholder="Senha" required>
                <button type="submit">ENTRAR</button>
                <a class="button_negative" href="views/nova_senha.php">ESQUECI A SENHA</a>
            </form>
        </div>
    </div>
    <!-- Footer section -->
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer">Desenvolvedores</a>
            <a href="https://teste.123" class="footer">Termos de Uso</a>
        </div>
    </div>
</body>
</html>