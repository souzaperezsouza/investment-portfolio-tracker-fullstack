<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'db.php';

$tipoCodigo = $_POST['tipoInvestimento'];
$ticker = strtoupper(trim($_POST['ticker']));
$valor = $_POST['valor'];
$data = $_POST['data'];
$usuarioId = $_SESSION['usuario_id'];

$tiposSemCotas = ["cdb", "tesouro", "renda-fixa"];
$cotas = in_array($tipoCodigo, $tiposSemCotas) ? null : (int) $_POST['cotas'];

$stmt = $conn->prepare("SELECT id FROM tipos_investimento WHERE codigo = ?");
$stmt->bind_param("s", $tipoCodigo);
$stmt->execute();
$tipo = $stmt->get_result()->fetch_assoc();
$tipoId = $tipo['id'];
$stmt->close();

$stmt = $conn->prepare("SELECT id FROM tickers WHERE ticker = ?");
$stmt->bind_param("s", $ticker);
$stmt->execute();
$resultTicker = $stmt->get_result();

if ($resultTicker->num_rows > 0) {
    $tickerId = $resultTicker->fetch_assoc()['id'];
} else {
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO tickers (ticker, tipo_investimento_id) VALUES (?, ?)");
    $stmt->bind_param("si", $ticker, $tipoId);
    $stmt->execute();
    $tickerId = $stmt->insert_id;
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO aportes (usuario_id, ticker_id, cotas, valor, data) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiids", $usuarioId, $tickerId, $cotas, $valor, $data);

if ($stmt->execute()) {
    header("Location: formAction.php?sucesso=inclusao");
    exit;
} else {
    echo "Erro ao registrar aporte: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>