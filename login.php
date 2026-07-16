<?php
require_once 'db.php';
session_start();

$login = $_POST['uname'];
$senha = $_POST['psw'];

$sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuarioDoBanco = $result->fetch_assoc();

    if (password_verify($senha, $usuarioDoBanco['senha'])) {
        $_SESSION['usuario_id'] = $usuarioDoBanco['id'];
        $_SESSION['usuario_nome'] = $usuarioDoBanco['usuario'];
        header("Location: home.php");
        exit;
    } else {
        header("Location: index.php?erro=login");
        exit;
    }
} else {
    header("Location: index.php?erro=login");
    exit;
}

$stmt->close();
$conn->close();
?>