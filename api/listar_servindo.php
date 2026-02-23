<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'db.php'; // Certifique-se de que o arquivo de conexão está na pasta raiz

// Pega o ID do encontro via URL
$encontro_id = $_GET['encontro_id'] ?? null;

if (!$encontro_id) {
    echo json_encode([]);
    exit;
}

try {
    /* IMPORTANTE: 
       Fazemos um JOIN com 'tabela_membros' para transformar o 'Cod_Membros' 
       em nomes legíveis (Ele & Ela) para a tabela do frontend.
    */
    $sql = "SELECT 
                m.ele, 
                m.ela, 
                e.Equipe AS funcao_equipe, 
                e.Funcao AS cargo 
            FROM tabela_equipes_trabalho e
            INNER JOIN tabela_membros m ON e.Cod_Membros = m.codigo
            WHERE e.Cod_Encontro = :id 
            ORDER BY e.Equipe ASC, e.Funcao DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $encontro_id]);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatamos o resultado para que o JavaScript entenda a chave 'nome_casal'
    $resultado = [];
    foreach ($dados as $item) {
        $resultado[] = [
            'nome_casal' => $item['ele'] . ' & ' . $item['ela'],
            'funcao_equipe' => $item['funcao_equipe'],
            'cargo' => $item['cargo']
        ];
    }

    echo json_encode($resultado);

} catch (PDOException $e) {
    // Se der erro, o código 500 será enviado com a mensagem do erro real
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}