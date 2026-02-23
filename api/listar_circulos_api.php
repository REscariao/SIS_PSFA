<?php
// api/listar_circulos_api.php
require_once 'db.php'; // Garante que usa o teu ficheiro de conexão principal

header('Content-Type: application/json; charset=utf-8');

try {
    // Busca apenas círculos ativos
    $sql = "SELECT codigo as id, circulo as nome_circulo 
            FROM tabela_cor_circulos 
            WHERE ativo = 1 
            ORDER BY circulo ASC";
            
    $stmt = $pdo->query($sql);
    $circulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($circulos);

} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}