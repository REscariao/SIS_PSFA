<?php
// Inclui a conexão com o banco
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Usamos IFNULL ou COALESCE para garantir que se o apelido for vazio, use o nome
    $sql = "SELECT 
                ET.Equipe AS nome_equipe,
                IF(M.Apelido_dele != '', M.Apelido_dele, M.Ele) AS ele_nome,
                IF(M.Apelido_dela != '', M.Apelido_dela, M.Ela) AS ela_nome,
                ET.Funcao AS funcao
            FROM Tabela_Equipes_Trabalho ET
            INNER JOIN Tabela_Membros M ON ET.Cod_Membros = M.Codigo
            ORDER BY ET.Equipe ASC, ET.Funcao DESC";

    $stmt = $pdo->query($sql);
    $equipes = $stmt->fetchAll();

    echo json_encode($equipes);

} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}