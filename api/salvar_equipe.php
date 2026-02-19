<?php
// Certifique-se de que o caminho está correto para o seu arquivo de conexão
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recebendo os dados do formulário
        $id_encontro = $_POST['id_encontro'];
        $id_casal    = $_POST['id_casal'];
        $nome_equipe = $_POST['nome_equipe'];
        $funcao      = $_POST['funcao'];

        // SQL AJUSTADO: Tabelas e colunas em minúsculo para HostGator (Linux)
        // Colunas: cod_encontro, cod_membros, equipe, funcao, imprimir
        $sql = "INSERT INTO tabela_equipes_trabalho (cod_encontro, cod_membros, equipe, funcao, imprimir) 
                VALUES (:cod_enc, :cod_mem, :equipe, :funcao, 1)
                ON DUPLICATE KEY UPDATE funcao = :funcao_update"; 

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cod_enc'       => $id_encontro,
            ':cod_mem'       => $id_casal,
            ':equipe'        => $nome_equipe,
            ':funcao'        => $funcao,
            ':funcao_update' => $funcao
        ]);

        echo "<script>
                alert('Casal escalado com sucesso!');
                window.location.href = '../equipe-trabalho.html';
              </script>";

    } catch (PDOException $e) {
        // Tratamento de erro profissional para ADS
        error_log("Erro no banco: " . $e->getMessage()); // Grava o erro no log do servidor
        die("Erro ao vincular equipe. Por favor, verifique se o casal já não está escalado.");
    }
}
?>