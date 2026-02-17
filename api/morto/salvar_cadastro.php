<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Organizando os dados e tratando campos vazios/datas
    $dados = [
        'ele_nome'       => $_POST['ele_nome'] ?? '',
        'ele_apelido'    => $_POST['ele_apelido'] ?? '',
        'ele_nascimento' => !empty($_POST['ele_nascimento']) ? $_POST['ele_nascimento'] : null,
        'ela_nome'       => $_POST['ela_nome'] ?? '',
        'ela_apelido'    => $_POST['ela_apelido'] ?? '',
        'ela_nascimento' => !empty($_POST['ela_nascimento']) ? $_POST['ela_nascimento'] : null,
        'casamento'      => !empty($_POST['casamento']) ? $_POST['casamento'] : null,
        'fone'           => $_POST['fone'] ?? '',
        'endereco'       => $_POST['endereco'] ?? '',
        'numero'         => $_POST['numero'] ?? '',
        'complemento'    => $_POST['complemento'] ?? '',
        'bairro'         => $_POST['bairro'] ?? '',
        'cidade'         => $_POST['cidade'] ?? '',
        'uf'             => $_POST['uf'] ?? ''
    ];

    try {
        // SQL de Inserção
        $sql = "INSERT INTO cadastro_geral (
                    ele_nome, ele_apelido, ele_nascimento,
                    ela_nome, ela_apelido, ela_nascimento,
                    casamento, fone, endereco, numero, 
                    complemento, bairro, cidade, uf
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Executa a gravação usando os valores do array $dados
        $stmt->execute(array_values($dados));

        // REDIRECIONAMENTO: Volta para a secretaria com um aviso de sucesso na URL
        header("Location: ../secretaria.html?sucesso=1");
        exit;

    } catch (Exception $e) {
        // Em caso de erro, interrompe e mostra o motivo (importante para o desenvolvedor)
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
}
?>