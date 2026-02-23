<?php
require_once 'db.php'; 

// Fuso horário local
date_default_timezone_set('America/Fortaleza');

$id_encontro = $_GET['encontro'] ?? null;
$equipe_nome = $_GET['equipe'] ?? null;

if (!$id_encontro || !$equipe_nome) die("Dados insuficientes.");

try {
    // 1. Busca dados do encontro (Tabela: tabela_encontros | Colunas: codigo, encontro, periodo)
    $stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$encontro) die("Encontro não encontrado.");

    // 2. Busca os membros da equipe (Ajustado para os nomes exatos do seu SQL)
    // Tabela: tabela_equipes_trabalho (Cod_Encontro, Cod_Membros, Equipe, Funcao)
    // Tabela: tabela_membros (codigo, ele, apelido_dele, ela, apelido_dela, end_rua, numero, bairro, fone)
    $sql = "SELECT 
                m.*, 
                eq.Funcao as funcao_atribuida 
            FROM tabela_equipes_trabalho eq 
            JOIN tabela_membros m ON eq.Cod_Membros = m.codigo 
            WHERE eq.Cod_Encontro = ? AND eq.Equipe = ?
            ORDER BY CASE WHEN eq.Funcao LIKE '%Coordenador%' THEN 1 ELSE 2 END ASC, m.ele ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro, $equipe_nome]);
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Convocação Oficial - <?php echo htmlspecialchars($equipe_nome); ?></title>
    <style>
        @page { size: A4; margin: 0; }
        body { background: #525659; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        .folha-a4 {
            width: 210mm; min-height: 297mm; padding: 15mm;
            margin: 20px auto; background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            position: relative; box-sizing: border-box;
        }
        .header-container { 
            display: flex; justify-content: center; align-items: center; 
            border-bottom: 2px solid #81693b; padding-bottom: 10px; margin-bottom: 20px; 
        }
        .logo-area img { width: 100px; margin-right: 30px; }
        .text-area { text-align: center; }   
        .text-area h1 { margin: 0; font-size: 20px; color: #81693b; text-transform: uppercase; }
        .text-area h2 { margin: 0; font-size: 16px; color: #81693b; }
        .info-encontro { margin-top: 10px; font-weight: bold; color: #81693b; font-size: 13px; }
        .coordenador-label { 
            font-size: 20px; font-weight: bold; color: #81693b; 
            border: 2px solid #81693b; padding: 2px 15px; 
            display: inline-block; margin-top: 5px; text-transform: uppercase;
        }
        .membro-row { 
            border: 1px solid #81693b; margin-bottom: -1px; 
            display: flex; align-items: flex-start; padding: 10px; 
        }
        .check-container { display: flex; flex-direction: column; align-items: center; margin-right: 15px; width: 55px; }
        .label-aceitou { font-size: 9px; text-transform: uppercase; font-weight: bold; color: #81693b; }
        .square { width: 22px; height: 22px; border: 1px solid #81693b; margin-top: 2px; }
        .membro-info { flex: 1; }
        .membro-contato { text-align: right; font-size: 11px; width: 250px; color: #81693b; line-height: 1.3; }
        .footer-convocacao {
            position: absolute; bottom: 15mm; left: 15mm; right: 15mm;
            display: flex; justify-content: space-between; font-size: 11px; 
            color: #81693b; border-top: 1px solid #ccc; padding-top: 10px;
        }
        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
        .no-print { 
            position: fixed; top: 10px; right: 10px; padding: 12px 25px; 
            background: #81693b; color: white; border: none; cursor: pointer; 
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR CONVOCAÇÃO</button>

    <div class="folha-a4">
        <header class="header-container">
            <div class="logo-area">
                <img src="../img/logoParoquia.png" alt="Logo">
            </div>
            <div class="text-area">
                <h1>Diocese de Patos</h1>
                <h2>Paróquia São Francisco de Assis</h2>
                <div class="info-encontro">
                    <?php echo strtoupper($encontro['encontro'] ?? 'ENCONTRO'); ?><br>
                    <?php echo $encontro['periodo'] ?? ''; ?>
                </div>
                <div style="margin-top: 5px; color: #81693b">Equipe: <span class="coordenador-label"><?php echo strtoupper($equipe_nome); ?></span></div>
            </div>
        </header>

        <main>
            <?php foreach ($membros as $m): ?>
            <div class="membro-row">
                <div class="check-container">
                    <span class="label-aceitou">Aceitou</span>
                    <div class="square"></div>
                </div>

                <div class="membro-info">
                    <span style="font-weight: bold; color: #81693b; text-decoration: underline; font-style: italic; font-size: 13px;">
                        <?php echo $m['funcao_atribuida']; ?>
                    </span><br>
                    <div style="margin-top: 5px; line-height: 1.3; color: #444">
                        <strong><?php echo strtoupper($m['apelido_dele'] ?? '---'); ?></strong> (<?php echo $m['ele']; ?>)<br>
                        <strong><?php echo strtoupper($m['apelido_dela'] ?? '---'); ?></strong> (<?php echo $m['ela']; ?>)
                    </div>
                </div>

                <div class="membro-contato">
                    <?php echo ($m['end_rua'] ?? 'Endereço não cadastrado') . ", " . ($m['numero'] ?? 'S/N'); ?><br>
                    <?php echo $m['bairro'] ?? ''; ?> - Patos-PB<br>
                    <strong><?php echo $m['fone'] ?? 'S/ Fone'; ?></strong>
                </div>
            </div>
            <?php endforeach; ?>
        </main>

        <footer class="footer-convocacao">
            <div style="width: 60%; color: #81693b">
                <strong>Atenção:</strong> O sigilo é fundamental para o sucesso do encontro. Não revele os nomes desta lista a terceiros.
            </div>
            <div style="width: 35%; text-align: right; color: #81693b">
                Data: ____/____/2026<br>
                Assinatura: _________________________
            </div>
        </footer>
    </div>
</body>
</html>