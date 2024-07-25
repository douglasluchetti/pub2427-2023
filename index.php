<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Avaliação de Disciplinas</title>
    <meta charset="utf-8">
    <meta name="description" content="Este é um projeto open source para avaliação de disciplinas. Contribua no GitHub.">
    <link rel="icon" href="images/logo.svg" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="images/logo_dark.svg" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="css\styles.css" type="text/css">
</head>
<body>
    <div class="header">
        <div class="logo_name">
            <img src="images\logo.svg" alt="Logo" class="logo">
            <h1>Avaliação de Disciplinas</h1>
        </div>
        <div class="line"></div>
        <div class="line" id="standart"></div>
        <div class="line" id="darker"></div>
    </div>
    <div class="content">
        <div class="top_menu">
        </div>
        <div class="block" id="index">
            <div class="master">
                <h2>Seja bem-vindo!</h2>
                <div>
                    <h3 class="survey"> O que é o projeto Avaliação de Disciplinas? </h3>
                    <h3>Este projeto consiste em uma aplicação web open source desenvolvida para apoiar o processo de avaliação de cursos e disciplinas em instituições de ensino superior. A ideia central é facilitar a coleta de feedback dos estudantes sobre as atividades pedagógicas, permitindo que as instituições melhorem continuamente a qualidade dos seus cursos.</h3>
                </div>
                <div>
                    <h3 class="survey"> Como funciona o projeto? </h3>
                    <h3>A aplicação "Avaliação de Disciplinas" funciona de maneira simples e intuitiva. Os administradores podem criar e gerenciar instâncias de questionários, que são distribuídos aos estudantes para que forneçam seu feedback. Os estudantes acessam a aplicação, respondem aos questionários e submetem suas respostas. Todas as respostas são armazenadas em um banco de dados MySQL, permitindo que os administradores façam o download e a análise dos dados coletados. A interface da aplicação é construída usando HTML, PHP e CSS, garantindo uma experiência de usuário amigável e eficiente.</h3>
                </div>
                <form class="center" action="views/login.php">
                    <button type="submit">ENTRAR</button>
                </form>
            </div>
        </div>
    </div>  
    <div class="footer">
        <div class="footer_content">
            <a href="https://github.com/douglasluchetti/pub2427-2023" class="footer" target="_blank" rel="noopener noreferrer">Este projeto é totalmente open source. Visite o <strong>repositório</strong> no GitHub para acessar o código-fonte, relatar problemas ou contribuir com melhorias.</a>
        </div>
    </div>
</body>
</html>