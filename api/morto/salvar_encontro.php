<?php
// Configurações de acesso (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // SQL atualizado para incluir a coluna 'observacoes'
        $sql = "INSERT INTO encontros (nome_encontro, data_inicio, data_fim, ano_referencia, local_evento, status, observacoes) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Vinculando os nomes exatos do seu formulário HTML
        $stmt->execute([
            $_POST['encontro_nome'] ?? null,
            $_POST['data_inicio']   ?? null,
            $_POST['data_fim']      ?? null,
            $_POST['ano_ref']       ?? null,
            $_POST['local']         ?? null,
            $_POST['status']        ?? 'planejado',
            $_POST['obs']           ?? null // Este campo agora será gravado
        ]);

        // Redirecionamento após o sucesso (melhor para formulários simples)
        header("Location: ../secretaria.html?sucesso=1");
        exit;

    } catch (Exception $e) {
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
}
?>