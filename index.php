<?php
$erroLogin = isset($_GET['erro']) && $_GET['erro'] === 'login';
$erroCadastro = isset($_GET['erro']) && $_GET['erro'] === 'cadastro';
$msgCadastro = $_GET['msg'] ?? '';
$sucessoCadastro = isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastro';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Stack</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
</head>
<body>
  <div class="topbar2">
        <h1>Minha Carteira de Investimentos</h1>
    </div>
    <div class="home-card">
            <button onclick="document.getElementById('id01').style.display='block'">Login</button>
            <button onclick="document.getElementById('id02').style.display='block'">Cadastre-se</button>
    </div>

<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close" title="Close Modal">&times;</span>

  <form class="modal-content animate" action="login.php" method="post">
  <div class="containerlogin">
    <h1>Login</h1>
    <p>Entre com suas credenciais para acessar sua conta</p>
    <hr>
    <?php if ($erroLogin): ?>
    <p style="color:#f44336;">Usuário/email ou senha incorretos.</p>
<?php endif; ?>
<?php if ($sucessoCadastro): ?>
    <p style="color:#04AA6D;">Cadastro realizado! Faça login para continuar.</p>
<?php endif; ?>

    <label for="uname"><b>Usuário</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Senha</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Lembre de mim
    </label>

    <p>Esqueceu a <a href="#" style="color:dodgerblue">senha?</a></p>

    <div class="clearfix">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancelar</button>
      <button type="submit" class="signup">Login</button>
    </div>
  </div>
  </form>
</div>
<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content" action="cadastro.php" method="post">
    <div class="container">
      <h1>Cadastrar-se</h1>
      <p>Preencha esse formulario para se cadastrar</p>
      <hr>
      <?php if ($erroCadastro): ?>
    <p style="color:#f44336;">
        <?php
        if ($msgCadastro === 'duplicado') echo "Esse usuário ou email já está cadastrado.";
        elseif ($msgCadastro === 'senha') echo "As senhas digitadas não coincidem.";
        else echo "Não foi possível concluir o cadastro. Tente novamente.";
        ?>
    </p>
<?php endif; ?>
      <label for="email"><b>Nome do usuário</b></label>
      <input type="text" placeholder="" name="usuario" required>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="" name="email" required>

      <label for="psw"><b>Senha</b></label>
      <input type="password" placeholder="" name="psw" required>

      <label for="psw-repeat"><b>Repita a senha</b></label>
      <input type="password" placeholder="" name="psw-repeat" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>Criando a conta você deve aceitar os nossos <a href="#" style="color:dodgerblue">Termos & Privacidade</a>.</p>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signup">Cadastre-se</button>
      </div>
    </div>
  </form>
  </div>
  <script src="js/script.js"></script>
  <?php if ($erroLogin || $sucessoCadastro): ?>
<script>document.getElementById('id01').style.display = 'block';</script>
<?php endif; ?>

<?php if ($erroCadastro): ?>
<script>document.getElementById('id02').style.display = 'block';</script>
<?php endif; ?>
    
</body>
</html>