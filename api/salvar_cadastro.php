<?php
// Inclui a conexão com o banco
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mapeamento dos campos do formulário para as variáveis PHP
        $ele_nome       = $_POST['ele_nome'] ?? null;
        $ele_apelido    = $_POST['ele_apelido'] ?? null;
        $ele_nasc       = $_POST['ele_nascimento'] ?? null;
        
        $ela_nome       = $_POST['ela_nome'] ?? null;
        $ela_apelido    = $_POST['ela_apelido'] ?? null;
        $ela_nasc       = $_POST['ela_nascimento'] ?? null;
        
        $casamento      = $_POST['casamento'] ?? null;
        $fone           = $_POST['fone'] ?? null;
        $rua            = $_POST['endereco'] ?? null;
        $numero         = $_POST['numero'] ?? null;
        $complemento    = $_POST['complemento'] ?? null;
        $bairro         = $_POST['bairro'] ?? null;
        $cidade         = $_POST['cidade'] ?? null;
        $uf             = $_POST['uf'] ?? 'PB';

        // SQL baseada na sua Tabela_Membros
        $sql = "INSERT INTO Tabela_Membros (
                    Ele, Apelido_dele, Nascimento_dele, 
                    Ela, Apelido_dela, Nascimento_dela, 
                    Casamento, End_Rua, Numero, Complemento, 
                    Bairro, Cidade, Uf, Fone, Ativo
                ) VALUES (
                    :ele, :ele_ap, :ele_nasc, 
                    :ela, :ela_ap, :ela_nasc, 
                    :casamento, :rua, :num, :comp, 
                    :bairro, :cidade, :uf, :fone, 1
                )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':ele'        => $ele_nome,
            ':ele_ap'     => $ele_apelido,
            ':ele_nasc'   => $ele_nasc ?: null, // Salva null se a data estiver vazia
            ':ela'        => $ela_nome,
            ':ela_ap'     => $ela_apelido,
            ':ela_nasc'   => $ela_nasc ?: null,
            ':casamento'  => $casamento ?: null,
            ':rua'        => $rua,
            ':num'        => $numero,
            ':comp'       => $complemento,
            ':bairro'     => $bairro,
            ':cidade'     => $cidade,
            ':uf'         => strtoupper($uf),
            ':fone'       => $fone
        ]);

        echo "<script>
                alert('Casal cadastrado com sucesso!');
                window.location.href = '../cadastro_geral.html';
              </script>";

    } catch (PDOException $e) {
        die("Erro ao salvar cadastro: " . $e->getMessage());
    }
} else {
    header("Location: ../cadastro_geral.html");
    exit;
}