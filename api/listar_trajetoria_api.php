<?php
// api/listar_trajetoria_api.php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'] ?? null;

try {
    if ($id === '0') {
        // Busca a trajetória de TODOS os casais
        $sql = "SELECT 
                    m.ele, m.ela, m.ano_ecc,
                    e.tema AS encontro, e.periodo,
                    et.Equipe AS equipe, et.Funcao AS funcao
                FROM tabela_equipes_trabalho et
                JOIN tabela_membros m ON et.Cod_Membros = m.codigo
                JOIN tabela_encontros e ON et.Cod_Encontro = e.codigo
                ORDER BY e.ano_evento DESC, e.codigo DESC, m.ele ASC";
        $stmt = $pdo->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else if ($id) {
        // Busca a trajetória de UM casal específico
        // Usamos INNER JOIN para garantir que só traga registros onde houve trabalho
        $sql = "SELECT 
                    m.ele, m.ela, m.ano_ecc, m.fone, m.bairro,
                    e.tema AS encontro, e.periodo,
                    et.Equipe AS equipe, et.Funcao AS funcao
                FROM tabela_equipes_trabalho et
                INNER JOIN tabela_encontros e ON et.Cod_Encontro = e.codigo
                INNER JOIN tabela_membros m ON et.Cod_Membros = m.codigo
                WHERE m.codigo = ?
                ORDER BY e.ano_evento DESC, e.codigo DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo json_encode(['erro' => 'ID não fornecido.']);
        exit;
    }

    echo json_encode($resultado);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}