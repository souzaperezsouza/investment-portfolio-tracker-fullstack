<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Front-end</title>
    <link rel="stylesheet" href="css/layout.css" type="text/css">
</head>

<body>
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a href="form.php">Novo aporte</a>
        <a href="formAction.php">Carteira</a>
        <a class="active"href="about.php">Sobre</a>
    </div>
    </div>
        <div class="topbar">
        <h1>Sobre</h1>
    </div>

    <div class="about-card">
       <p>Sobre o projeto</p>

<p>Este site tem como objetivo simular uma carteira de investimentos, permitindo que o usuário registre um novo aporte por meio de um formulário.</p>

<p>Após o envio, os dados são enviados pelo método GET, recebidos no banco de dados e exibidos na tela.</p>

<p>O site possui um menu padrão em todas as páginas, mantendo uma identidade visual uniforme com tons de vermelho e creme. A organização dos arquivos foi feita separando estrutura, estilo, scripts e imagens em pastas próprias.</p>

<p>Autor: Enzo Souza Parecy</p>
    </div>
    <script src="js/script.js"></script>
    
</body>

</html>