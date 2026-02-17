<?php
require_once 'db.php';
header('Content-Type: application/json');

try {
    // Buscamos apenas casais ativos
    $stmt = $pdo->query("SELECT Codigo as id, Ele as ele_nome, Ela as ela_nome FROM Tabela_Membros WHERE Ativo = 1 ORDER BY Ele ASC");
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}