<?php
// Define que a resposta será um JSON
header('Content-Type: application/json');

// Inclui a tua conexão com o banco de dados
require_once 'db.php'; 

try {
    // Consulta as funções oficiais do ECC cadastradas na tabela
    $sql = "SELECT id, nome_funcao FROM funcoes_ecc ORDER BY nome_funcao ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Busca todos os resultados
    $funcoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Retorna os dados para o JavaScript
    echo json_encode($funcoes);

} catch (PDOException $e) {
    // Caso haja erro no banco, retorna o erro em formato JSON
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao carregar funções: ' . $e->getMessage()]);
}