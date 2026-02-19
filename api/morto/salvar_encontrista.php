<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_encontro = $_POST['id_encontro'];
        $id_casal    = $_POST['id_casal'];
        $id_circulo  = !empty($_POST['id_circulo']) ? $_POST['id_circulo'] : null;

        $sql = "INSERT INTO Tabela_Encontristas (Etapa, Cod_Membros, Cod_Encontro, Cod_Circulo, Imprimir) 
                VALUES (1, :cod_mem, :cod_enc, :cod_cir, 1)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cod_mem' => $id_casal,
            ':cod_enc' => $id_encontro,
            ':cod_cir' => $id_circulo
        ]);

        echo "<script>
                alert('Encontrista cadastrado com sucesso!');
                window.location.href = '../secretaria.html'; 
              </script>";

    } catch (PDOException $e) {
        die("Erro ao cadastrar encontrista: " . $e->getMessage());
    }
}