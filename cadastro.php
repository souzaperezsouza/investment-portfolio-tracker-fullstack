<?php
require_once 'db.php';

$usuario = $_POST['usuario'];
$email   = $_POST['email'];
$senha   = $_POST['psw'];
$senhaRepetida = $_POST['psw-repeat'];

if ($senha !== $senhaRepetida) {
    header("Location: index.php?erro=cadastro&msg=senha");
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (usuario, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $usuario, $email, $senhaHash);

if ($stmt->execute()) {
    header("Location: index.php?sucesso=cadastro");
    exit;
} else {
    if ($conn->errno === 1062) {
        header("Location: index.php?erro=cadastro&msg=duplicado");
    } else {
        header("Location: index.php?erro=cadastro&msg=geral");
    }
    exit;
}

$stmt->close();
$conn->close();
?>