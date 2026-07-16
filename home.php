<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

$sqlTop5 = "SELECT u.id, u.usuario, SUM(a.valor) AS total_investido
            FROM usuarios u
            JOIN aportes a ON a.usuario_id = u.id
            GROUP BY u.id, u.usuario
            ORDER BY total_investido DESC
            LIMIT 5";

$resultTop5 = $conn->query($sqlTop5);
$leaderboard = [];

while ($usuarioTop = $resultTop5->fetch_assoc()) {
    $stmt = $conn->prepare(
        "SELECT t.ticker, SUM(a.valor) AS total_ativo
         FROM aportes a
         JOIN tickers t ON a.ticker_id = t.id
         WHERE a.usuario_id = ?
         GROUP BY t.ticker
         ORDER BY total_ativo DESC
         LIMIT 1"
    );
    $stmt->bind_param("i", $usuarioTop['id']);
    $stmt->execute();
    $ativoPrincipal = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $leaderboard[] = [
        'usuario' => $usuarioTop['usuario'],
        'total_investido' => $usuarioTop['total_investido'],
        'ativo_principal' => $ativoPrincipal['ticker'] ?? '—'
    ];
}

$conn->close();
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
        <a class="active" href="index.php">Home</a>
        <a href="form.php">Novo aporte</a>
        <a href="formAction.php">Carteira</a>
        <a href="about.php">Sobre</a>
    </div>
        <div class="topbar">
            <div class="user-info">
        <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
</div>
        
        <h1>Minha Carteira de Investimentos</h1>

        <button class="logout-btn" onclick="document.getElementById('logoutModal').style.display='block'">Sair</button>
    </div>
    <div id="logoutModal" class="modal">
  <div class="modal-content animate" style="max-width:400px; margin:15% auto; padding:30px; text-align:center;">
    <h2>Tem certeza que deseja sair?</h2>
    <p>Você precisará fazer login novamente para acessar sua carteira.</p>
    <div class="clearfix" style="margin-top:20px;">
      <button type="button" class="cancelbtn" onclick="document.getElementById('logoutModal').style.display='none'">Cancelar</button>
      <a href="logout.php" class="signup" style="display:inline-block; text-align:center; text-decoration:none;">Sair</a>
    </div>
  </div>
</div>

</div>

    <div class="home-card">
        <p>Bem-vindo à sua carteira de investimentos</p>

<p>Registre seus aportes seus aportes, informe o tipo de investimento e visualize os dados enviados diretamente na página da carteira.</p>

<p>Este projeto utiliza HTML, CSS, PHP, SQL e JavaScript, com foco em estrutura, estilo, validação de formulário e manipulação de dados full stack.</p>

<p>Comece cadastrando seu primeiro aporte, ou .</p>  
<div class="leaderboard-card">
    <h2>Top 5 Investidores</h2>

    <?php if (empty($leaderboard)): ?>
        <p>Ainda não há investidores suficientes para exibir o ranking.</p>
    <?php else: ?>
        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuário</th>
                    <th>Total investido</th>
                    <th>Principal ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $posicao => $item): ?>
                    <tr>
                        <td><?= $posicao + 1 ?>º</td>
                        <td><?= htmlspecialchars($item['usuario']) ?></td>
                        <td>R$ <?= number_format($item['total_investido'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($item['ativo_principal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>   
    </div>
    <script src="js/script.js"></script>
</div>

<script src="js/script.js"></script>
</body>
</body>

</html>
