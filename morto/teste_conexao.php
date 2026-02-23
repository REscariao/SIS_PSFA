<<<<<<< HEAD
<?php
// Ativa a exibição de erros para o debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o seu arquivo de configuração
require_once 'api/db.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

try {
    // 1. Testa a conexão básica
    if ($pdo) {
        echo "<p style='color: green;'>✅ Sucesso: Conexão com o servidor realizada!</p>";
    }

    // 2. Testa se o banco de dados está selecionado corretamente
    $dbname = $pdo->query("SELECT DATABASE()")->fetchColumn();
    echo "<p>📦 Banco de dados ativo: <strong>$dbname</strong></p>";

    // 3. Verifica se as tabelas principais já foram importadas
    // Isso ajuda a saber se o erro 500 é por falta de tabela
    echo "<h3>Verificando Tabelas:</h3>";
    $tabelas_para_testar = ['tabela_membros', 'tabela_encontros', 'tabela_equipes_trabalho'];
    
    foreach ($tabelas_para_testar as $tabela) {
        $check = $pdo->query("SHOW TABLES LIKE '$tabela'")->rowCount();
        if ($check > 0) {
            echo "<p style='color: green;'>✔️ Tabela '$tabela' encontrada.</p>";
        } else {
            echo "<p style='color: red;'>❌ Tabela '$tabela' NÃO encontrada no banco!</p>";
        }
    }

} catch (PDOException $e) {
    echo "<p style='color: white; background: red; padding: 10px;'>";
    echo "🚨 Erro de Conexão: " . $e->getMessage();
    echo "</p>";
    
    echo "<h4>Dicas para HostGator:</h4>";
    echo "<ul>
            <li>Verifique se o usuário <strong>$user</strong> foi adicionado ao banco no cPanel.</li>
            <li>Confirme se concedeu 'Todos os Privilégios' ao usuário.</li>
            <li>A senha contém caracteres especiais? Algumas versões do PHP na HostGator podem ter problemas com certos símbolos na DSN.</li>
          </ul>";
}
=======
<?php
// Ativa a exibição de erros para o debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o seu arquivo de configuração
require_once 'api/db.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

try {
    // 1. Testa a conexão básica
    if ($pdo) {
        echo "<p style='color: green;'>✅ Sucesso: Conexão com o servidor realizada!</p>";
    }

    // 2. Testa se o banco de dados está selecionado corretamente
    $dbname = $pdo->query("SELECT DATABASE()")->fetchColumn();
    echo "<p>📦 Banco de dados ativo: <strong>$dbname</strong></p>";

    // 3. Verifica se as tabelas principais já foram importadas
    // Isso ajuda a saber se o erro 500 é por falta de tabela
    echo "<h3>Verificando Tabelas:</h3>";
    $tabelas_para_testar = ['tabela_membros', 'tabela_encontros', 'tabela_equipes_trabalho'];
    
    foreach ($tabelas_para_testar as $tabela) {
        $check = $pdo->query("SHOW TABLES LIKE '$tabela'")->rowCount();
        if ($check > 0) {
            echo "<p style='color: green;'>✔️ Tabela '$tabela' encontrada.</p>";
        } else {
            echo "<p style='color: red;'>❌ Tabela '$tabela' NÃO encontrada no banco!</p>";
        }
    }

} catch (PDOException $e) {
    echo "<p style='color: white; background: red; padding: 10px;'>";
    echo "🚨 Erro de Conexão: " . $e->getMessage();
    echo "</p>";
    
    echo "<h4>Dicas para HostGator:</h4>";
    echo "<ul>
            <li>Verifique se o usuário <strong>$user</strong> foi adicionado ao banco no cPanel.</li>
            <li>Confirme se concedeu 'Todos os Privilégios' ao usuário.</li>
            <li>A senha contém caracteres especiais? Algumas versões do PHP na HostGator podem ter problemas com certos símbolos na DSN.</li>
          </ul>";
}
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
?>