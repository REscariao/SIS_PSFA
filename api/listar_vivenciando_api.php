<?php
// Inclui a conexão com o banco
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Query para buscar os dados dos encontristas vinculados ao encontro
    // Note que buscamos o Encontro, Nomes Reais e os Apelidos
    // api/listar_vivenciando_api.php
$sql = "SELECT 
            TE.Cod_Encontro AS cod_encontro,
            TE.Cod_Membros AS cod_membro,
            E.Encontro AS nome_encontro,
            M.Ele AS ele_nome,
            M.Ela AS ela_nome,
            M.Apelido_dele AS ele_apelido,
            M.Apelido_dela AS ela_apelido,
            C.Circulo AS cor_nome -- Adicionado
        FROM Tabela_Encontristas TE
        INNER JOIN Tabela_Membros M ON TE.Cod_Membros = M.Codigo
        INNER JOIN Tabela_Encontros E ON TE.Cod_Encontro = E.Codigo
        LEFT JOIN Tabela_Cor_Circulos C ON TE.Cod_Circulo = C.Codigo -- Join com círculos
        WHERE E.Periodo LIKE '%2026%'
        ORDER BY M.Ele ASC";

    $stmt = $pdo->query($sql);
    $encontristas = $stmt->fetchAll();

    echo json_encode($encontristas);

} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}