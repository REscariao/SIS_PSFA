<?php
// api/salvar_encontrista.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_encontro = $_POST['id_encontro'] ?? null;
        $id_casal    = $_POST['id_casal'] ?? null;
        $id_circulo  = !empty($_POST['id_circulo']) ? $_POST['id_circulo'] : null;
        $obs         = $_POST['obs'] ?? '';

        if (!$id_encontro || !$id_casal) {
            echo "<script>alert('Selecione o encontro e o casal!'); window.history.back();</script>";
            exit;
        }

        // Inserção incluindo o Cod_Circulo e a Etapa (padrão 1 para encontristas)
        $sql = "INSERT INTO Tabela_Encontristas (Etapa, Cod_Membros, Cod_Encontro, Cod_Circulo, Imprimir) 
                VALUES (1, :cod_mem, :cod_enc, :cod_cir, 1)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cod_mem' => $id_casal,
            ':cod_enc' => $id_encontro,
            ':cod_cir' => $id_circulo
        ]);

        echo "<script>
                alert('Casal vinculado ao círculo com sucesso!');
                window.location.href = '../vivenciando.html';
              </script>";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Erro: Este casal já está neste encontro.'); window.history.back();</script>";
        } else {
            die("Erro ao salvar: " . $e->getMessage());
        }
    }
}