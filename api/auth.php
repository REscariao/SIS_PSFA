<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = :email AND status = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login com sucesso
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_nivel'] = $usuario['nivel'];
        
        header("Location: ../dashboard.php");
    } else {
        // Falha no login
        header("Location: index.php?erro=dados_invalidos");
    }
}