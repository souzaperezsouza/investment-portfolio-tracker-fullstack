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
<script src="js/script.js"></script>
<body>
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a class="active"href="form.php">Novo aporte</a>
        <a href="formAction.php">Carteira</a>
        <a href="about.php">Sobre</a>
    </div>
    </div>
        <div class="topbar">
        <h1>Novo aporte</h1>
    </div>

    <div class="content">
       <div class="menu">
        <form action="aporte.php" method="post" id="formAporte">

    <label for="tipoInvestimento">Tipo de investimento:</label>
    <select id="tipoInvestimento" name="tipoInvestimento" required>
        <option value="">Selecione uma opção</option>
        <option value="acao">Ações</option>
        <option value="fii">FIIs</option>
        <option value="etf">ETFs</option>
        <option value="cdb">CDB</option>
        <option value="tesouro">Tesouro Direto</option>
        <option value="renda-fixa">Renda fixa</option>
    </select>

    <label for="campoTicker">Digite o ticker:    </label>
    <input type="text" id="campoTicker" name="ticker" class="campoTicker" required>

    <label for="campoCotas">    Digite a quantidade de cotas:</label>
    <input type="number" id="campoCotas" name="cotas" class="campoCotas" min="1" step="1" required>

    <label for="campoValor">Valor investido:</label>
    <input type="number" id="campoValor" name="valor" min="0.01" step="0.01" required>

    <label for="campoData">Data do aporte:</label>
    <input type="date" id="campoData" name="data" required>

    <input type="submit" value="Enviar Aporte" class="envioAporte">

</form>
       </div>
    </div>
    
</body>

</html>