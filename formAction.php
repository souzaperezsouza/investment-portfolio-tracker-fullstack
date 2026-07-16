<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'db.php';

$usuarioId = $_SESSION['usuario_id'];

$sucessoEdicao = isset($_GET['sucesso']) && $_GET['sucesso'] === 'edicao';
$erroEdicao = isset($_GET['erro']) && $_GET['erro'] === 'edicao';
$sucessoInclusao = isset($_GET['sucesso']) && $_GET['sucesso'] === 'inclusao';

$sql = "SELECT a.id AS aporte_id, a.cotas, a.valor, a.data, t.ticker, ti.codigo AS tipo_codigo, ti.nome AS tipo_nome
        FROM aportes a
        JOIN tickers t ON a.ticker_id = t.id
        JOIN tipos_investimento ti ON t.tipo_investimento_id = ti.id
        WHERE a.usuario_id = ?
        ORDER BY a.data DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

$carteiraAgrupada = [];

while ($row = $result->fetch_assoc()) {
    $tipo = $row['tipo_codigo'];

    if (!isset($carteiraAgrupada[$tipo])) {
        $carteiraAgrupada[$tipo] = [
            'nome' => $row['tipo_nome'],
            'totalValor' => 0,
            'tickers' => [],
            'aportes' => []
        ];
    }

    $carteiraAgrupada[$tipo]['totalValor'] += (float) $row['valor'];
    $carteiraAgrupada[$tipo]['aportes'][] = $row;

    if ($row['cotas'] !== null) {
        $ticker = $row['ticker'];
        if (!isset($carteiraAgrupada[$tipo]['tickers'][$ticker])) {
            $carteiraAgrupada[$tipo]['tickers'][$ticker] = ['totalCotas' => 0, 'totalValor' => 0];
        }
        $carteiraAgrupada[$tipo]['tickers'][$ticker]['totalCotas'] += (int) $row['cotas'];
        $carteiraAgrupada[$tipo]['tickers'][$ticker]['totalValor'] += (float) $row['valor'];
    }
}

$stmt->close();
$conn->close();

$carteiraVazia = empty($carteiraAgrupada);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Carteira</title>
    <link rel="stylesheet" href="css/layout.css" type="text/css">
</head>
<body>
    <div class="sidebar">
        <a href="home.php">Home</a>
        <a href="form.php">Novo aporte</a>
        <a class="active" href="formAction.php">Carteira</a>
        <a href="about.php">Sobre</a>
    </div>

    <div class="topbar">
        <h1>Minha carteira</h1>
    </div>

    <div class="content">
        <?php if ($sucessoEdicao): ?>
            <p style="color:#04AA6D; text-align:center; font-weight:bold;">Aporte atualizado com sucesso!</p>
        <?php elseif ($erroEdicao): ?>
            <p style="color:#f44336; text-align:center; font-weight:bold;">Não foi possível atualizar o aporte.</p>
        <?php elseif ($sucessoInclusao): ?>
            <p style="color:#04AA6D; text-align:center; font-weight:bold;">Aporte registrado com sucesso!</p>
        <?php endif; ?>

        <?php if ($carteiraVazia): ?>
            <div id="carteiraVazia">
                <p class="textoCarteiraVazia">
                    Sua carteira ainda está vazia. Registre seu primeiro aporte para começar a
                    acompanhar seus investimentos e visualizar sua alocação.
                </p>

                <img class="flecha" src="flecha marrom.png" alt="Flecha apontando para Novo aporte">

                <div class="instrucao">
                    <p>Clique em novo aporte</p>
                </div>

                <p class="textoCarteiraInferior">
                    Quando houver dados, você verá aqui:
                    Tabela de ativos • Valor total • Alocação por tipo
                </p>
            </div>
        <?php else: ?>
            <div id="carteiraComDados" class="carteira-card">
                <h2>Minha Carteira</h2>

                <div id="resumoTipos">
                    <?php foreach ($carteiraAgrupada as $grupo): ?>
                        <div class="resumo-tipo">
                            <h3><?= htmlspecialchars($grupo['nome']) ?></h3>
                            <p>Total investido: R$ <?= number_format($grupo['totalValor'], 2, ',', '.') ?></p>

                            <?php foreach ($grupo['tickers'] as $nomeTicker => $dadosTicker): ?>
                                <?php $precoMedio = $dadosTicker['totalValor'] / $dadosTicker['totalCotas']; ?>
                                <p><?= htmlspecialchars($nomeTicker) ?>: <?= $dadosTicker['totalCotas'] ?> cotas</p>
                                <p>Preço médio: R$ <?= number_format($precoMedio, 2, ',', '.') ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="detalhesTipos">
                    <?php foreach ($carteiraAgrupada as $grupo): ?>
                        <div class="grupo-aportes">
                            <h3>Aportes de <?= htmlspecialchars($grupo['nome']) ?></h3>

                            <?php foreach ($grupo['aportes'] as $aporte): ?>
                                <div class="aporte-item">
    <p><strong>Ticker:</strong> <?= htmlspecialchars($aporte['ticker']) ?></p>
    <p><strong>Valor:</strong> R$ <?= number_format($aporte['valor'], 2, ',', '.') ?></p>
    <p><strong>Cotas:</strong> <?= $aporte['cotas'] ?? "Não se aplica" ?></p>
    <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($aporte['data'])) ?></p>

    <a href="editarAporte.php?id=<?= $aporte['aporte_id'] ?>" class="signup"
       style="display:inline-block; width:auto; padding:6px 14px; text-decoration:none; text-align:center;">
        Editar
    </a>
    <button type="button" class="cancelbtn" style="width:auto; padding:6px 14px;"
            onclick="abrirModalExcluir(<?= $aporte['aporte_id'] ?>)">
        Excluir
    </button>
</div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div id="excluirModal" class="modal">
  <div class="modal-content animate" style="max-width:400px; margin:15% auto; padding:30px; text-align:center;">
    <h2>Tem certeza que deseja excluir esse aporte?</h2>
    <p>Essa ação não pode ser desfeita.</p>

    <form action="excluirAporte.php" method="post" style="margin-top:20px;">
        <input type="hidden" name="aporte_id" id="aporteIdParaExcluir">

        <div class="clearfix">
            <button type="button" class="cancelbtn" onclick="document.getElementById('excluirModal').style.display='none'">Cancelar</button>
            <button type="submit" class="signup">Excluir</button>
        </div>
    </form>
  </div>
</div>

    <script src="js/script.js"></script>
</body>
</html>