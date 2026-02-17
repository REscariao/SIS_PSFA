<?php
require_once 'db.php';

// Define o fuso horário para o Sertão da Paraíba
date_default_timezone_set('America/Fortaleza');

try {
    // 1. Identifica o ano atual (2026)
    $anoAtual = date('Y');

    // 2. SQL para buscar casais vinculados ao encontro do ano atual
    // Buscamos nomes, apelidos e o padrinho registrado na tabela vivenciando
    $sql = "SELECT 
                v.casal_padrinho,
                c.ele_nome, 
                c.ela_nome, 
                c.ele_apelido, 
                c.ela_apelido,
                e.nome_encontro
            FROM vivenciando v
            JOIN cadastro_geral c ON v.id_casal = c.id
            JOIN encontros e ON v.id_encontro = e.id
            WHERE YEAR(e.data_inicio) = ?
            ORDER BY c.ele_nome ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$anoAtual]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os dados em formato JSON para o JavaScript
    header('Content-Type: application/json');
    echo json_encode($dados);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>