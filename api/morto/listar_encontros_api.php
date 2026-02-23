<?php
require_once 'db.php';

try {
    // Busca os encontros para preencher o campo de seleção
    $stmt = $pdo->query("SELECT id, nome_encontro, ano_referencia FROM encontros ORDER BY data_inicio DESC");
    $encontros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($encontros);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>