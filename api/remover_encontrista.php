<?php
require_once 'db.php';
header('Content-Type: application/json');

if (isset($_GET['cod_encontro']) && isset($_GET['cod_membro'])) {
    try {
        $cod_enc = $_GET['cod_encontro'];
        $cod_mem = $_GET['cod_membro'];

        // Onde 'Cod_Encontro' e 'Cod_Membros' são as colunas da sua Tabela_Encontristas
        $sql = "DELETE FROM Tabela_Encontristas 
                WHERE Cod_Encontro = :enc AND Cod_Membros = :mem";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':enc' => $cod_enc, ':mem' => $cod_mem]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Dados insuficientes']);
}