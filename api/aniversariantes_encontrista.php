<?php
require_once 'db.php'; 
date_default_timezone_set('America/Fortaleza');

$id_encontro = $_GET['encontro'] ?? null;
$mes_atual = date('m'); // Mês atual do sistema

try {
    if (!$id_encontro) {
        $stmt_ultimo = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
        $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        $id_encontro = $ultimo['codigo'] ?? null;
    }

    if (!$id_encontro) die("Erro: Nenhum encontro encontrado.");

    $stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    /**
     * SQL UNIFICADO: 
     * Usamos UNION para transformar o casal (ele/ela) em linhas individuais de aniversariantes,
     * filtrando apenas quem faz aniversário no mês atual.
     */
    $sql = "SELECT * FROM (
                SELECT 
                    m.ele AS nome, 
                    m.nascimento_dele AS nascimento, 
                    c.cor AS corhex, 
                    c.circulo AS nome_circulo
                FROM tabela_encontristas te 
                JOIN tabela_membros m ON te.cod_membros = m.codigo 
                LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
                WHERE te.cod_encontro = ? AND MONTH(m.nascimento_dele) = ?

                UNION ALL

                SELECT 
                    m.ela AS nome, 
                    m.nascimento_dela AS nascimento, 
                    c.cor AS corhex, 
                    c.circulo AS nome_circulo
                FROM tabela_encontristas te 
                JOIN tabela_membros m ON te.cod_membros = m.codigo 
                LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
                WHERE te.cod_encontro = ? AND MONTH(m.nascimento_dela) = ?
            ) AS lista_niver
            ORDER BY DAY(nascimento) ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro, $mes_atual, $id_encontro, $mes_atual]);
    $aniversariantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Como são linhas individuais, cabem mais por página (ajustado para 14)
    $itens_por_pagina = 14; 
    $paginas = array_chunk($aniversariantes, $itens_por_pagina);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

$mes_extenso = [
    '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
    '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
    '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aniversariantes de <?php echo $mes_extenso[$mes_atual]; ?></title>
    <style>
        @page { size: A4; margin: 0; }
        body { background-color: #525659; margin: 0; padding: 0; font-family: Arial, sans-serif; }

        .folha-a4 { 
            width: 210mm; height: 297mm; background: white; 
            padding: 10mm 15mm; box-sizing: border-box; margin: 20px auto;
            position: relative; box-shadow: 0 0 15px rgba(0,0,0,0.5);
            page-break-after: always; overflow: hidden;
        }

        .header { 
            position: relative; display: flex; justify-content: center; align-items: center;
            border-bottom: 2px solid #81693b; padding-bottom: 10px; margin-bottom: 20px;
            min-height: 80px;
        }
        
        .logo { position: absolute; left: 5%; top: 0; width: 75px; }

        .header-text { padding-left: 20%; color: #5f4b26; text-align: center; width: 100%; }
        .header-text h1 { color: #81693b; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header-text p { color: #d35400; margin: 2px 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }

        .label-topo { 
            color: #81693b; display: flex; font-size: 10px; font-weight: bold; 
            text-transform: uppercase; border-bottom: 1px solid #81693b;
            padding-bottom: 5px; margin-bottom: 10px;
        }

        .item-row { display: flex; border: 1px solid #5f4b26; background: #fff; margin-bottom: 8px; align-items: stretch; }
        
        .col-nome { width: 55%; border-right: 1px solid #5f4b26; padding: 12px; font-weight: bold; font-size: 14px; text-transform: uppercase; color: #5f4b26; }
        .col-cor { width: 25%; border-right: 1px solid #5f4b26; padding: 5px; text-align: center; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; -webkit-print-color-adjust: exact; }
        .col-data { width: 20%; padding: 5px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; }

        .data-dia { font-size: 18px; font-weight: bold; color: #d35400; }
        .data-mes { font-size: 9px; text-transform: uppercase; color: #81693b; }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; border: none; }
            .no-print { display: none; }
        }

        .no-print { 
            position: fixed; top: 10px; right: 10px; padding: 12px 25px; 
            background: #d35400; color: white; border: none; cursor: pointer; 
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR ANIVERSARIANTES DE <?php echo strtoupper($mes_extenso[$mes_atual]); ?></button>

    <?php if (empty($paginas)): ?>
        <div class="folha-a4" style="display: flex; align-items: center; justify-content: center;">
            <h2 style="color: #81693b;">Nenhum aniversariante em <?php echo $mes_extenso[$mes_atual]; ?>.</h2>
        </div>
    <?php endif; ?>

    <?php foreach ($paginas as $indice => $lista): ?>
    <div class="folha-a4">
        <div class="header">
            <div class="logo"><img src="../img/logoParoquia.png" style="width:100%"></div>
            <div class="header-text">
                <h1>ANIVERSARIANTES</h1>
                <p>MÊS DE <?php echo $mes_extenso[$mes_atual]; ?></p>
                <div style="font-size: 11px; color: #81693b; margin-top: 5px;"><?php echo htmlspecialchars($encontro['encontro']); ?></div>
            </div>
        </div>

        <div class="label-topo">
            <div style="width: 55%;">Nome do Aniversariante</div>
            <div style="width: 25%; text-align: center;">Círculo</div>
            <div style="width: 20%; text-align: center;">Data</div>
        </div>

        <?php foreach ($lista as $niver): 
            $fundo = !empty($niver['corhex']) ? $niver['corhex'] : '#cccccc';
            $cor_nome = strtoupper($niver['nome_circulo'] ?? 'GERAL');
            $texto_cor = (in_array($cor_nome, ['AMARELO', 'ROSA', 'LARANJA'])) ? '#5f4b26' : '#ffffff';
        ?>
        <div class="item-row">
            <div class="col-nome">
                <?php echo htmlspecialchars($niver['nome']); ?>
            </div>

            <div class="col-cor" style="background-color: <?php echo $fundo; ?> !important; color: <?php echo $texto_cor; ?>;">
                <?php echo $cor_nome; ?>
            </div>

            <div class="col-data">
                <span class="data-dia"><?php echo date('d/m', strtotime($niver['nascimento'])); ?></span>
                <span class="data-mes">Aniversário</span>
            </div>
        </div>
        <?php endforeach; ?>

        <div style="position: absolute; bottom: 10mm; right: 15mm; font-size: 10px; color: #81693b;">
            Página <?php echo ($indice + 1) . ' de ' . count($paginas); ?>
        </div>
    </div>
    <?php endforeach; ?>

</body>
</html>