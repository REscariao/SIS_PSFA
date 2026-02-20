<?php
// api/listar_ciclos_api.php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

$filtro = $_GET['filtro'] ?? 'todos';

try {
    // SQL Ajustado: m.Codigo (Maiúsculo) e e.codigo (Minúsculo) conforme seu dump
    $sql = "SELECT 
                c.cod_circulo, 
                m.ele, 
                m.ela, 
                e.tema AS encontro, 
                e.periodo
            FROM tabela_ciclos c
            INNER JOIN tabela_membros m ON c.cod_membro = m.Codigo
            INNER JOIN tabela_encontros e ON c.cod_encontro = e.codigo";

    if ($filtro !== 'todos') {
        $sql .= " WHERE c.cod_circulo = :ciclo";
    }

    $sql .= " ORDER BY e.ano_evento DESC, c.cod_circulo ASC";

    $stmt = $pdo->prepare($sql);
    
    if ($filtro !== 'todos') {
        $stmt->execute([':ciclo' => (int)$filtro]);
    } else {
        $stmt->execute();
    }

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($resultado ?: []);

} catch (PDOException $e) {
    // Se ainda der erro, o JSON vai te dizer exatamente qual coluna falhou
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}