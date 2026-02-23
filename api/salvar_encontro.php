<?php
// api/salvar_encontro.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Coleta os dados do formulário baseando-se nos nomes dos inputs do seu HTML
        $encontro   = $_POST['encontro_nome'] ?? '';
        $periodo    = $_POST['periodo'] ?? '';
        $tema       = $_POST['local'] ?? ''; // O input do tema no seu HTML tem name="local"
        $observacao = $_POST['obs'] ?? '';   // O textarea tem name="obs"

        // Prepara a SQL com os nomes exatos das colunas da sua tabela
        $sql = "INSERT INTO tabela_encontros (Etapa, Encontro, Periodo, Tema, Observacao) 
                VALUES (1, :encontro, :periodo, :tema, :obs)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':encontro' => $encontro,
            ':periodo'  => $periodo,
            ':tema'     => $tema,
            ':obs'      => $observacao
        ]);

        echo "<script>
                alert('Encontro registrado com sucesso!'); 
                window.location.href='../secretaria.php';
              </script>";

    } catch (PDOException $e) {
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
} else {
    header("Location: ../index.html");
    exit;
}