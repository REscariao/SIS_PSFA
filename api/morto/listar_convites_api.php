<?php
require_once 'db.php';

try {
    $sql = "SELECT 
                eq.id,
                eq.nome_equipe,
                eq.funcao,
                eq.status,
                c.ele_nome,
                c.ela_nome,
                c.ele_apelido,
                c.ela_apelido
            FROM equipes eq
            JOIN cadastro_geral c ON eq.id_casal = c.id
            ORDER BY eq.id DESC"; // Mudamos de data_escalacao para id

    $stmt = $pdo->query($sql);
    $convites = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($convites);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>