<?php
require_once 'db.php';
header('Content-Type: application/json');

try {
    // Selecionamos o Código e o nome do encontro
    $stmt = $pdo->query("SELECT Codigo as id, Encontro as nome_encontro, Periodo as ano_referencia FROM Tabela_Encontros");
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}