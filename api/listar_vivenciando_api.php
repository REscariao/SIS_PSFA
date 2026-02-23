<<<<<<< HEAD
<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Adicionamos c.cor para pegar o hexadecimal que cadastramos no banco
    $sql = "SELECT 
            te.cod_encontro,
            te.cod_membros,
            e.encontro, 
            m.ele AS ele_nome,
            m.ela AS ela_nome,
            m.apelido_dele AS ele_apelido,
            m.apelido_dela AS ela_apelido,
            c.circulo AS cor_nome,
            c.cor AS cor_hex 
        FROM tabela_encontristas te
        INNER JOIN tabela_membros m ON te.cod_membros = m.codigo
        INNER JOIN tabela_encontros e ON te.cod_encontro = e.codigo
        LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
        WHERE e.periodo LIKE '%2026%'
        ORDER BY m.ele ASC";

    $stmt = $pdo->query($sql);
    // FETCH_ASSOC evita duplicidade de dados no JSON
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($encontristas);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
=======
<?php
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Adicionamos c.cor para pegar o hexadecimal que cadastramos no banco
    $sql = "SELECT 
            te.cod_encontro,
            te.cod_membros,
            e.encontro, 
            m.ele AS ele_nome,
            m.ela AS ela_nome,
            m.apelido_dele AS ele_apelido,
            m.apelido_dela AS ela_apelido,
            c.circulo AS cor_nome,
            c.cor AS cor_hex 
        FROM tabela_encontristas te
        INNER JOIN tabela_membros m ON te.cod_membros = m.codigo
        INNER JOIN tabela_encontros e ON te.cod_encontro = e.codigo
        LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
        WHERE e.periodo LIKE '%2026%'
        ORDER BY m.ele ASC";

    $stmt = $pdo->query($sql);
    // FETCH_ASSOC evita duplicidade de dados no JSON
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($encontristas);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
}