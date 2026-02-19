<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Forçamos o alias (AS) para garantir que as chaves do JSON sejam 'codigo', 'ele' e 'ela'
    $sql = "SELECT 
                codigo AS codigo, 
                ele AS ele, 
                ela AS ela 
            FROM tabela_membros 
            WHERE ativo = 1 
            ORDER BY ele ASC";
            
    $stmt = $pdo->query($sql);
    $casais = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($casais);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}