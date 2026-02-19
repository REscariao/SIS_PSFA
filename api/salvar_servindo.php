<?php
// Exibir erros para debug (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Pegando os nomes do formulário (FormData)
    $cod_encontro = $_POST['encontro_id'] ?? null;
    $equipe       = $_POST['funcao_equipe'] ?? null;
    $funcao       = $_POST['cargo'] ?? 'Membro';
    $cod_membro   = $_POST['nome_casal'] ?? null;

    // Validação básica
    if (!$cod_encontro || !$equipe || !$cod_membro) {
        echo json_encode(['status' => 'error', 'message' => 'Campos obrigatórios faltando']);
        exit;
    }

    try {
        // SQL exato para a sua tabela_equipes_trabalho
        // Colunas: Cod_Encontro, Cod_Membros, Equipe, Funcao, Imprimir
        $sql = "INSERT INTO tabela_equipes_trabalho (Cod_Encontro, Cod_Membros, Equipe, Funcao, Imprimir) 
                VALUES (:enc, :mem, :equi, :fun, 1)";
        
        $stmt = $pdo->prepare($sql);
        
        $sucesso = $stmt->execute([
            ':enc'  => $cod_encontro,
            ':mem'  => $cod_membro,
            ':equi' => $equipe,
            ':fun'  => $funcao
        ]);

        if ($sucesso) {
            echo json_encode(['status' => 'success', 'message' => 'Salvo com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao executar o comando no banco.']);
        }

    } catch (PDOException $e) {
        // Isso aqui vai te dizer se o erro é "Column not found" ou "Table not found"
        http_response_code(500);
        echo json_encode([
            'status' => 'error', 
            'message' => 'Erro no Banco: ' . $e->getMessage(),
            'debug' => $e->errorInfo
        ]);
    }
}