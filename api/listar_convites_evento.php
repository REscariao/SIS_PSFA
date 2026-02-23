<?php
// api/listar_convites_evento.php
header('Content-Type: application/json');
require_once 'db.php'; 

$idEncontro = $_GET['encontro'] ?? null;

if (!$idEncontro) {
    echo json_encode(["error" => "ID do encontro não fornecido"]);
    exit;
}

try {
    // SQL ajustada para sua tabela 'tabela_equipes_trabalho'
    $sql = "SELECT 
                ET.Equipe AS nome_equipe,
                ET.Funcao AS funcao,
                M.Ele AS ele_nome,
                M.Ela AS ela_nome,
                M.Apelido_dele AS ele_apelido,
                M.Apelido_dela AS ela_apelido
            FROM tabela_equipes_trabalho ET
            JOIN tabela_membros M ON ET.Cod_Membros = M.Codigo
            WHERE ET.Cod_Encontro = ?
            ORDER BY ET.Equipe ASC, M.Ele ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idEncontro]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Adicionamos um status fixo 'Aceito' já que sua tabela não possui coluna de status
    foreach ($dados as &$d) {
        $d['status'] = 'Aceito';
    }

    echo json_encode($dados);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erro no banco: " . $e->getMessage()]);
}