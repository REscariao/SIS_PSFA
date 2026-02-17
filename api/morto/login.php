<?php
header('Content-Type: application/json');
require_once 'db.php';

// Recebe os dados do fetch (JSON)
$dados = json_decode(file_get_contents('php://input'), true);

if (!$dados) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados não recebidos']);
    exit;
}

$email = $dados['email'];
$senha = $dados['senha'];

// Busca o usuário no banco
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND status = 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha'])) {
    // Aqui você iniciaria a sessão (session_start)
    echo json_encode([
        'sucesso' => true, 
        'mensagem' => 'Bem-vindo!',
        'nome' => $user['nome']
    ]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'E-mail ou senha incorretos']);
}
?>