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
            <h2 class="title_reset-password">Esqueci a Senha / Primeiro Acesso</h2>
            <div class="block" id="login">
                <form action="gerar_nova_senha.php" method="POST" class="login">
                    <h4 class="text_reset-password">Insira seu número de matrícula ou e-mail para enviar sua nova senha no endereço de e-mail:</h4>
                    <input class="login" type="text" name="username" placeholder="Número de matrícula ou e-mail" required>
                    <button type="submit">ENVIAR</button>
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
