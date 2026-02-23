<?php
require_once 'db.php';

// Defina aqui os dados do primeiro utilizador
$nome  = "Administrador";
$email = "seu-email@igreja.com"; // Altere para o seu e-mail
$senha_plana = "admin"; // Altere para a sua senha desejada
$nivel = "admin"; // Nível de acesso

// Gerar o Hash seguro da senha
$senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (:nome, :email, :senha, :nivel, 1)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nome'  => $nome,
        ':email' => $email,
        ':senha' => $senha_hash,
        ':nivel' => $nivel
    ]);

    echo "Utilizador criado com sucesso!<br>";
    echo "E-mail: " . $email . "<br>";
    echo "Senha: [A senha que você definiu]";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "Erro: Este e-mail já está registado.";
    } else {
        echo "Erro ao criar utilizador: " . $e->getMessage();
    }
}
?>