<?php
// Ativa a exibição de erros para o teste
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- AJUSTE O EMAIL ABAIXO PARA UM QUE EXISTA NO SEU BANCO ---
$email_para_testar = 'admin@psafranciscodeassis.com.br'; 
// ----------------------------------------------------------

try {
    // Inclui o seu arquivo de conexão
    require_once 'db.php';

    // Pega a conexão através da função db() que você criou
    $db = db();
    
    echo "<h3>--- Diagnóstico de Banco de Dados ---</h3>";
    echo "✅ <b>Conexão:</b> Estabelecida com sucesso!<br>";

    // 1. Testa se a tabela 'usuarios' existe e busca o email
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(['email' => $email_para_testar]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        echo "❌ <b>Erro de Busca:</b> O email <u>$email_para_testar</u> não foi encontrado na tabela 'usuarios'.<br>";
        echo "<i>Verifique se o email está digitado corretamente no banco.</i>";
    } else {
        echo "✅ <b>Usuário:</b> Encontrado (ID: " . $usuario['id'] . ")<br>";

        // 2. Verifica o Status (O seu login exige que seja 1)
        if ($usuario['status'] == 1) {
            echo "✅ <b>Status:</b> 1 (Ativo)<br>";
        } else {
            echo "❌ <b>Status:</b> " . $usuario['status'] . " (Bloqueado). O login vai falhar porque o status não é 1.<br>";
        }

        // 3. Verifica a Criptografia da Senha
        $hash = $usuario['senha'];
        // O password_verify precisa que a senha comece com $2y$ ou $2a$
        if (strpos($hash, '$2y$') === 0) {
            echo "✅ <b>Senha:</b> Formato de Hash Válido ($2y$).<br>";
            echo "<i>Tudo certo! Se o login falhar agora, é porque a senha digitada está errada.</i>";
        } else {
            echo "❌ <b>Senha:</b> Formato INVÁLIDO.<br>";
            echo "⚠️ A senha no banco está em texto puro: <b>" . $hash . "</b><br>";
            echo "<blockquote>O PHP não consegue validar senhas em texto puro usando password_verify. 
                  Você precisa atualizar este usuário usando <b>password_hash('suasenha', PASSWORD_DEFAULT)</b>.</blockquote>";
        }

        echo "<hr><b>Dados brutos retornados:</b><pre>";
        print_r($usuario);
        echo "</pre>";
    }

} catch (Exception $e) {
    echo "❌ <b>Falha Crítica:</b> " . $e->getMessage();
}