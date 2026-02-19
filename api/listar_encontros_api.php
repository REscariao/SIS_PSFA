<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Usando a tabela em minúsculo para compatibilidade com Linux/HostGator
    $stmt = $pdo->query("SELECT codigo, encontro, periodo, tema FROM tabela_encontros ORDER BY codigo DESC");
    $encontros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($encontros);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}