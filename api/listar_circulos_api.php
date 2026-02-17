<?php
// api/listar_circulos_api.php
require_once 'db.php'; // Garante que usa o teu ficheiro de conexão principal

header('Content-Type: application/json; charset=utf-8');

try {
    // Busca apenas círculos ativos
    $sql = "SELECT Codigo as id, Circulo as nome_circulo 
            FROM Tabela_Cor_Circulos 
            WHERE Ativo = 1 
            ORDER BY Circulo ASC";
            
    $stmt = $pdo->query($sql);
    $circulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($circulos);

} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}