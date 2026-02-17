<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_encontro = $_POST['id_encontro'];
        $id_casal    = $_POST['id_casal'];
        $nome_equipe = $_POST['nome_equipe'];
        $funcao      = $_POST['funcao'];

        // SQL baseada na sua Tabela_Equipes_Trabalho
        // Colunas: Cod_Encontro, Cod_Membros, Equipe, Funcao, Imprimir
        $sql = "INSERT INTO Tabela_Equipes_Trabalho (Cod_Encontro, Cod_Membros, Equipe, Funcao, Imprimir) 
                VALUES (:cod_enc, :cod_mem, :equipe, :funcao, 1)
                ON DUPLICATE KEY UPDATE Funcao = :funcao_update"; // Evita erro se o casal já estiver na equipe

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cod_enc'      => $id_encontro,
            ':cod_mem'      => $id_casal,
            ':equipe'       => $nome_equipe,
            ':funcao'       => $funcao,
            ':funcao_update' => $funcao
        ]);

        echo "<script>
                alert('Casal escalado com sucesso!');
                window.location.href = '../equipe-trabalho.html';
              </script>";

    } catch (PDOException $e) {
        // Se houver erro de chave primária duplicada ou outro problema
        die("Erro ao vincular equipe: " . $e->getMessage());
    }
}