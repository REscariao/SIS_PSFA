<?php
require_once 'db.php';

try {
    // Selecionamos o ID (para salvar na equipe) e os nomes (para exibir no select)
    $stmt = $pdo->query("SELECT id, ele_nome, ela_nome FROM cadastro_geral ORDER BY ele_nome ASC");
    $casais = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Definimos que o retorno é um JSON
    header('Content-Type: application/json');
    echo json_encode($casais);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>