<!doctype html>
<html lang="pt-br">
    <head>
        <title>Avaliação de Disciplinas</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="..\css\styles.css" type="text/css">
    </head>
    <body>
        <div class="header">
            <div class="logo_name">
                <img src="..\images\logo.svg" alt="Logo" class="logo">
                <h1>Avaliação de Disciplinas</h1>
            </div>
            <div class="line"></div>
            <div class="line" id="standart"></div>
            <div class="line" id="darker"></div>
        </div>
        <div class="content">
            <div class="block" id="login">
                <form action="login.php" method="POST" class="login">
                    <input class="login" type="text" name="username" placeholder="Número de matrícula ou e-mail" required>
                    <input class="login" type="password" name="password" placeholder="Senha" required>
                    <button type="submit">ENTRAR</button>
                    <a class="button_negative" href="https://teste.123">ESQUECI A SENHA / PRIMEIRO ACESSO</a>
                </form>
            </div>
        </div>
        <div class="footer">
            <div class="footer_content">
                <a href="https://teste.123" class="footer">Desenvolvedores</a>
                <a href="https://teste.123" class="footer">Termos de Uso</a>
            </div>
        </div>
    </body>


</html>
