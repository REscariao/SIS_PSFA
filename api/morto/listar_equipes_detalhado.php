<?php
require_once 'db.php';

try {
    // SQL com INNER JOIN para buscar os nomes reais em vez de apenas os IDs
    $sql = "SELECT 
                eq.id,
                eq.nome_equipe,
                eq.funcao,
                enc.nome_encontro,
                enc.ano_referencia,
                casal.ele_nome,
                casal.ela_nome
            FROM equipes eq
            INNER JOIN encontros enc ON eq.id_encontro = enc.id
            INNER JOIN cadastro_geral casal ON eq.id_casal = casal.id
            ORDER BY enc.data_inicio DESC, eq.nome_equipe ASC, casal.ele_nome ASC";

    $stmt = $pdo->query($sql);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Definimos o cabeçalho como JSON para o JavaScript do equipes.html entender
    header('Content-Type: application/json');
    echo json_encode($resultado);

} catch (PDOException $e) {
    // Se der erro (ex: coluna faltando), retorna o erro em formato JSON
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>