<?php
// api/listar_ciclos_api.php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

$filtro = $_GET['filtro'] ?? 'todos';

try {
    // Usamos LEFT JOIN para que, se um ID não existir, a linha ainda apareça (ajuda no debug)
    $sql = "SELECT 
                cfg.Circulo AS nome_circulo,
                c.cod_circulo, 
                c.cod_membro,
                c.coordenador as cod_coord,
                m1.ele AS membro_ele, 
                m1.ela AS membro_ela, 
                m2.ele AS coord_ele, 
                m2.ela AS coord_ela,
                e.tema AS encontro, 
                e.periodo,
                cfg.Cor AS cor_hex
            FROM tabela_ciclos c
            LEFT JOIN tabela_membros m1 ON c.cod_membro = m1.Codigo
            LEFT JOIN tabela_membros m2 ON c.coordenador = m2.Codigo
            LEFT JOIN tabela_encontros e ON c.cod_encontro = e.codigo
            LEFT JOIN tabela_cor_circulos cfg ON c.cod_circulo = cfg.Codigo";

    if ($filtro !== 'todos') {
        $sql .= " WHERE c.cod_circulo = :ciclo";
    }

    $sql .= " ORDER BY e.ano_evento DESC, c.cod_circulo ASC";

    $stmt = $pdo->prepare($sql);
    
    // Passagem limpa de parâmetros
    if ($filtro !== 'todos') {
        $stmt->execute([':ciclo' => (int)$filtro]);
    } else {
        $stmt->execute();
    }

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Se o resultado for falso/nulo, retorna array vazio
    echo json_encode($resultado ?: []);

} catch (PDOException $e) {
    // Em caso de erro 500, o JSON dirá exatamente o que o SQL não gostou
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}