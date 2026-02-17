<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Recebe os dados do formulário
        $id_encontro = $_POST['id_encontro'];
        $id_casal = $_POST['id_casal'];
        $nome_equipe = $_POST['nome_equipe'];
        $funcao = $_POST['funcao'];

        $sql = "INSERT INTO equipes (id_encontro, id_casal, nome_equipe, funcao) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            $id_encontro,
            $id_casal,
            $nome_equipe,
            $funcao
        ]);

        // Redireciona para a secretaria ou para uma página de visualização de equipes
        header("Location: ../secretaria.html?sucesso_equipe=1");
        exit;

    } catch (Exception $e) {
        die("Erro ao escalar equipe: " . $e->getMessage());
    }
}
?>