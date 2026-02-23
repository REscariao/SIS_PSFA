<?php
require_once 'db.php';

$id_encontro = $_GET['encontro'] ?? null;
$nome_equipe = $_GET['equipe'] ?? null;

if (!$id_encontro || !$nome_equipe) die("Parâmetros inválidos.");

try {
    // Busca informações do Encontro
    $stmtEnc = $pdo->prepare("SELECT * FROM encontros WHERE id = ?");
    $stmtEnc->execute([$id_encontro]);
    $encontro = $stmtEnc->fetch(PDO::FETCH_ASSOC);

    // Busca Casais da Equipe (Ordenando Coordenador primeiro)
    $sql = "SELECT eq.funcao, c.* FROM equipes eq
            JOIN cadastro_geral c ON eq.id_casal = c.id
            WHERE eq.id_encontro = ? AND eq.nome_equipe = ?
            ORDER BY CASE WHEN eq.funcao = 'Coordenador' THEN 1 ELSE 2 END ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro, $nome_equipe]);
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Erro no banco: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Equipe - ECC</title>
    <style>
        /* CSS focado em emular o seu print oficial */
        @page { size: A4; margin: 10mm; }
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; }
        .folha-a4 { width: 190mm; margin: auto; padding: 10px; border: 1px dashed #ccc; }
        
        .header-print { text-align: center; border-bottom: 2px solid #2a3d91; padding-bottom: 10px; margin-bottom: 20px; }
        .diocese-title { color: #2a3d91; font-weight: bold; font-size: 16pt; text-transform: uppercase; }
        
        .membro-box { 
            border: 1px solid #000; 
            margin-bottom: -1px; 
            display: flex; 
            padding: 8px;
            min-height: 80px;
        }
        .check-aceitou { width: 30px; border-right: 1px solid #000; display: flex; align-items: flex-start; padding-top: 5px; }
        .check-square { width: 18px; height: 18px; border: 1px solid #000; }
        
        .dados-container { flex: 1; padding-left: 10px; display: flex; justify-content: space-between; }
        .nomes-col { width: 60%; }
        .endereco-col { width: 40%; font-size: 9pt; text-align: right; }
        
        .label-funcao { text-decoration: underline; font-style: italic; font-weight: bold; font-size: 10pt; }
        
        @media print {
            .no-print { display: none; }
            .folha-a4 { border: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #333; padding: 10px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">🖨️ CONFIRMAR IMPRESSÃO</button>
    </div>

    <div class="folha-a4">
        <div class="header-print">
            <div class="diocese-title">Diocese de Patos</div>
            <div>Paróquia de Santo Antônio</div>
            <div style="font-weight: bold; font-size: 14pt;"><?php echo $encontro['nome_encontro']; ?></div>
            <div>Equipe: <strong style="font-size: 18pt; color: #2a3d91;"><?php echo strtoupper($nome_equipe); ?></strong></div>
        </div>

        <?php foreach ($membros as $m): ?>
        <div class="membro-box">
            <div class="check-aceitou"><div class="check-square"></div></div>
            <div class="dados-container">
                <div class="nomes-col">
                    <span class="label-funcao"><?php echo $m['funcao'] . " " . $nome_equipe; ?></span><br>
                    <strong><?php echo $m['ele_apelido']; ?></strong> <?php echo $m['ele_nome']; ?><br>
                    <strong><?php echo $m['ela_apelido']; ?></strong> <?php echo $m['ela_nome']; ?>
                </div>
                <div class="endereco-col">
                    <?php echo $m['endereco']; ?>, <?php echo $m['numero']; ?><br>
                    <?php echo $m['bairro']; ?> - Patos - PB<br>
                    📞 <?php echo $m['fone']; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div style="margin-top: 40px; display: flex; justify-content: space-between; font-size: 9pt;">
            <div style="width: 50%;">
                <strong>Obs:</strong> Os membros não devem ter conhecimento dos outros integrantes até a reunião.
            </div>
            <div style="border-left: 1px solid #000; padding-left: 10px;">
                Confirmar: ___________________________
            </div>
        </div>
    </div>
</body>
</html>