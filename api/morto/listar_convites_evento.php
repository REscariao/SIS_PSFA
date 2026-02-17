<?php
require_once 'db.php';

$id_encontro = $_GET['encontro'] ?? null;

if (!$id_encontro) {
    echo json_encode(["erro" => "Encontro não selecionado"]);
    exit;
}

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
            WHERE eq.id_encontro = ?
            ORDER BY eq.nome_equipe ASC, eq.funcao ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($dados);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => $e->getMessage()]);
}
?>