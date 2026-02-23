<<<<<<< HEAD
<?php
// Ajustado para o padrão de letras minúsculas do Linux/HostGator
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // 1. Mudamos para minúsculas: tabela_equipes_trabalho e tabela_membros
    // 2. Usamos COALESCE e IF para garantir que sempre haja um nome/apelido
    $sql = "SELECT 
                et.equipe AS nome_equipe,
                IF(m.apelido_dele IS NOT NULL AND m.apelido_dele != '', m.apelido_dele, m.ele) AS ele_nome,
                IF(m.apelido_dela IS NOT NULL AND m.apelido_dela != '', m.apelido_dela, m.ela) AS ela_nome,
                et.funcao AS funcao
            FROM tabela_equipes_trabalho et
            INNER JOIN tabela_membros m ON et.cod_membros = m.codigo
            ORDER BY et.equipe ASC, et.funcao DESC";

    $stmt = $pdo->query($sql);
    
    // FETCH_ASSOC garante que o JSON não venha com índices numéricos duplicados
    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna o JSON formatado
    echo json_encode($equipes, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    // Em produção, é melhor não exibir o erro completo por segurança, 
    // mas para o seu desenvolvimento em ADS, o log abaixo é ideal:
    http_response_code(500);
    echo json_encode(['erro' => 'Falha no banco de dados: ' . $e->getMessage()]);
=======
<?php
// Ajustado para o padrão de letras minúsculas do Linux/HostGator
require_once 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // 1. Mudamos para minúsculas: tabela_equipes_trabalho e tabela_membros
    // 2. Usamos COALESCE e IF para garantir que sempre haja um nome/apelido
    $sql = "SELECT 
                et.equipe AS nome_equipe,
                IF(m.apelido_dele IS NOT NULL AND m.apelido_dele != '', m.apelido_dele, m.ele) AS ele_nome,
                IF(m.apelido_dela IS NOT NULL AND m.apelido_dela != '', m.apelido_dela, m.ela) AS ela_nome,
                et.funcao AS funcao
            FROM tabela_equipes_trabalho et
            INNER JOIN tabela_membros m ON et.cod_membros = m.codigo
            ORDER BY et.equipe ASC, et.funcao DESC";

    $stmt = $pdo->query($sql);
    
    // FETCH_ASSOC garante que o JSON não venha com índices numéricos duplicados
    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna o JSON formatado
    echo json_encode($equipes, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    // Em produção, é melhor não exibir o erro completo por segurança, 
    // mas para o seu desenvolvimento em ADS, o log abaixo é ideal:
    http_response_code(500);
    echo json_encode(['erro' => 'Falha no banco de dados: ' . $e->getMessage()]);
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
}