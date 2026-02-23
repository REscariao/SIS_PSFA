<<<<<<< HEAD
<?php
require_once 'db.php'; 
date_default_timezone_set('America/Fortaleza');

$id_encontro = $_GET['encontro'] ?? null;

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

    if (!$encontro) die("Erro: Encontro não encontrado.");

    // SQL ATUALIZADO: Ordenando apenas pelo nome do homem (m.ele)
    $sql = "SELECT 
                m.ele AS ele_nome, m.ela AS ela_nome, 
                m.apelido_dele AS ele_apelido, m.apelido_dela AS ela_apelido,
                m.nascimento_dele AS ele_nascimento, m.nascimento_dela AS ela_nascimento,
                m.casamento, m.end_rua AS endereco, m.numero, m.bairro, m.fone,
                c.cor AS corhex, c.circulo AS nome_circulo
            FROM tabela_encontristas te 
            JOIN tabela_membros m ON te.cod_membros = m.codigo 
            LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
            WHERE te.cod_encontro = ? 
            ORDER BY m.ele ASC"; // Ordem Alfabética Geral
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Divide em blocos de 7 casais por folha A4
    $itens_por_pagina = 9; 
    $paginas = array_chunk($encontristas, $itens_por_pagina);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Presença Alfabética - ECC</title>
    <style>
        @page { size: A4; margin: 0; }
        body { background-color: #525659; margin: 0; padding: 0; font-family: Arial, sans-serif; }

        .folha-a4 { 
            width: 210mm; height: 297mm; background: white; 
            padding: 10mm 15mm; box-sizing: border-box; margin: 20px auto;
            position: relative; box-shadow: 0 0 15px rgba(0,0,0,0.5);
            page-break-after: always;
            overflow: hidden;
        }

        .header { 
            display: flex; justify-content: center; align-items: center;
            border-bottom: 2px solid #81693b; padding-bottom: 10px; margin-bottom: 20px;
        }
        
        .logo { width: 80px; flex-shrink: 0; }
        .header-text { color: #5f4b26; flex: 1; text-align: center; }
        .header-text h1 { color: #81693b; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header-text p { color: #81693b; margin: 2px 0; font-size: 13px; font-weight: bold; }

        .label-topo { 
            color: #81693b; display: flex; font-size: 10px; font-weight: bold; 
            text-transform: uppercase; border-bottom: 1px solid #81693b;
            padding-bottom: 5px; margin-bottom: 8px;
        }

        .item-casal { color: #81693b; margin-bottom: 10px; } 
        .casal-row { display: flex; border: 1px solid #5f4b26; background: #fff; }
        
        .col-1 { width: 45%; border-right: 1px solid #5f4b26; padding: 6px; }
        .col-2 { width: 15%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-3 { width: 14%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-4 { width: 14%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-5 { width: 12%; padding: 5px; }

        .col-apelido-dinamico {
            font-weight: bold; text-align: center; display: flex;
            flex-direction: column; justify-content: center; font-size: 13px;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .box-container { display: flex; justify-content: center; gap: 2px; margin-top: 5px; }
        .box { width: 18px; height: 18px; border: 1px solid #5f4b26; background: #fff; }
        .obs-area { color: #81693b; border: 1px solid #5f4b26; border-top: none; padding: 4px 10px; font-size: 11px; font-weight: bold; background: #fafafa; }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; border: none; }
            .no-print { display: none; }
        }

        .no-print { 
            position: fixed; top: 10px; right: 10px; padding: 12px 25px; 
            background: #27ae60; color: white; border: none; cursor: pointer; 
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR LISTA ALFABÉTICA</button>

    <?php foreach ($paginas as $indice => $casais_da_pagina): ?>
    <div class="folha-a4">
        <div class="header">
            <div class="logo"><img src="../img/logoParoquia.png" style="width:100%"></div>
            <div class="header-text">
                <h1>LISTA DE PRESENÇA</h1>
                <p><?php echo htmlspecialchars(strtoupper($encontro['encontro'] ?? '')); ?></p>
                <p>PARÓQUIA DE SÃO FRANCISCO DE ASSIS - MATERNIDADE - PATOS/PB</p>
                <p style="font-weight: normal; font-size: 12px;"><?php echo htmlspecialchars($encontro['periodo'] ?? ''); ?></p>
            </div>
        </div>

        <div class="label-topo">
            <div style="width: 43%;">Casal / Endereço / Contato</div>
            <div style="width: 15%; text-align: center;">Apelidos</div>
            <div style="width: 14%; text-align: center;">Nascimento</div>
            <div style="width: 14%; text-align: center;">Casamento</div>
            <div style="width: 14%; text-align: center;">S | S | D</div>
        </div>

        <?php foreach ($casais_da_pagina as $c): 
            $fundo = !empty($c['corhex']) ? $c['corhex'] : '#cccccc';
            // Garante legibilidade: Amarelo e Rosa usam texto escuro, outras cores texto branco
            $cor_nome = strtoupper($c['nome_circulo'] ?? '');
            $texto = (in_array($cor_nome, ['AMARELO', 'ROSA', 'LARANJA'])) ? '#5f4b26' : '#ffffff';
        ?>
        <div class="item-casal">
            <div class="casal-row">
                <div class="col-1">
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ele_nome']); ?></div>
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ela_nome']); ?></div>
                    <div style="font-size: 10px; margin-top: 4px; color: #81693b;">
                        <?php echo htmlspecialchars("{$c['endereco']}, {$c['numero']} - {$c['bairro']} | {$c['fone']}"); ?>
                    </div>
                </div>

                <div class="col-2 col-apelido-dinamico" style="background-color: <?php echo $fundo; ?> !important; color: <?php echo $texto; ?>;">
                    <?php echo htmlspecialchars($c['ele_apelido'] ?: '-'); ?><br>
                    <small style="font-weight:normal; font-size:9px;">e</small><br>
                    <?php echo htmlspecialchars($c['ela_apelido'] ?: '-'); ?>
                </div>

                <div class="col-3" style="text-align: center; font-size: 11px; display: flex; flex-direction: column; justify-content: center;">
                    <?php echo $c['ele_nascimento'] ? date('d/m/Y', strtotime($c['ele_nascimento'])) : '--/--/--'; ?><br>
                    <?php echo $c['ela_nascimento'] ? date('d/m/Y', strtotime($c['ela_nascimento'])) : '--/--/--'; ?>
                </div>
                <div class="col-4" style="text-align: center; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?php echo $c['casamento'] ? date('d/m/Y', strtotime($c['casamento'])) : '--/--/--'; ?>
                </div>
                <div class="col-5">
                    <div style="font-size: 7px; font-weight: bold; text-align: center; color: #777;">SEX | SAB | DOM</div>
                    <div class="box-container">
                        <div class="box"></div><div class="box"></div><div class="box"></div>
                    </div>
                </div>
            </div>
            <div class="obs-area">OBSERVAÇÕES: __________________________________________________________________________</div>
        </div>
        <?php endforeach; ?>

        <div style="position: absolute; bottom: 10mm; left: 15mm; font-size: 10px; color: #81693b;">
            Lista em Ordem Alfabética Geral
        </div>
        <div style="position: absolute; bottom: 10mm; right: 15mm; font-size: 10px; color: #81693b;">
            Página <?php echo ($indice + 1) . ' de ' . count($paginas); ?>
        </div>
    </div>
    <?php endforeach; ?>

</body>
=======
<?php
// Ajustado para o padrão de letras minúsculas do Linux/HostGator
require_once 'db.php'; 

date_default_timezone_set('America/Fortaleza');

// Verifica se um ID foi passado, caso contrário, busca o último evento cadastrado
$id_encontro = $_GET['encontro'] ?? null;

try {
    if (!$id_encontro) {
        // PADRONIZAÇÃO: Mudamos para tabela_encontros e codigo em minúsculo
        $stmt_ultimo = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
        $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        $id_encontro = $ultimo['codigo'] ?? null;
    }

    if (!$id_encontro) {
        die("Erro: Nenhum encontro encontrado no sistema.");
    }

    // 1. Busca dados do encontro selecionado ou do último
    $stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$encontro) die("Erro: Encontro não encontrado.");

    // 2. Busca os casais e a cor do seu respectivo círculo
    // Ajustado para os nomes reais das colunas em minúsculo: ele, ela, fone, bairro, etc.
    $sql = "SELECT 
                m.ele AS ele_nome, m.ela AS ela_nome, 
                m.apelido_dele AS ele_apelido, m.apelido_dela AS ela_apelido,
                m.nascimento_dele AS ele_nascimento, m.nascimento_dela AS ela_nascimento,
                m.casamento, m.end_rua AS endereco, m.numero, m.bairro, m.fone,
                c.cor AS corhex, c.circulo AS nome_circulo
            FROM tabela_encontristas te 
            JOIN tabela_membros m ON te.cod_membros = m.codigo 
            LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
            WHERE te.cod_encontro = ? 
            ORDER BY c.circulo, m.ele ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Presença Colorida - ECC</title>
    <style>
        @page { size: A4; margin: 10mm; }
        body { background-color: #525659; margin: 0; padding: 0; font-family: Arial, sans-serif; }

        .folha-a4 { 
            width: 210mm; min-height: 297mm; background: white; 
            padding: 10mm 15mm; box-sizing: border-box; margin: 20px auto;
            position: relative; box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }

        .header { 
            display: flex; justify-content: center; align-items: center;
            border-bottom: 2px solid #81693b; padding-bottom: 10px; margin-bottom: 20px;
        }
        
        .logo { width: 80px; flex-shrink: 0; margin-left: 9%; }
        .header-text { color: #5f4b26; flex: 1; text-align: center; }
        .header-text h1 { color: #81693b; margin: 0; font-size: 26px; text-transform: uppercase; }
        .header-text p { color: #81693b; margin: 2px 0; font-size: 14px; font-weight: bold; }

        .label-topo { 
            color: #81693b; display: flex; font-size: 10px; font-weight: bold; 
            text-transform: uppercase; border-bottom: 1px solid #81693b;
            padding-bottom: 5px; margin-bottom: 8px;
        }

        .item-casal { color: #81693b; margin-bottom: 12px; } 
        .casal-row { color: #81693b; display: flex; border: 1px solid #5f4b26; background: #fff; }
        
        .col-1 { width: 45%; border-right: 1px solid #5f4b26; padding: 6px; }
        .col-2 { width: 15%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-3 { width: 14%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-4 { width: 14%; border-right: 1px solid #5f4b26; padding: 5px; } 
        .col-5 { width: 12%; padding: 5px; }

        .col-apelido-dinamico {
            font-weight: bold;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: 13px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .box-container { display: flex; justify-content: center; gap: 2px; margin-top: 5px; }
        .box { width: 18px; height: 18px; border: 1px solid #5f4b26; background: #fff; }
        .obs-area { color: #81693b; border: 1px solid #5f4b26; border-top: none; padding: 5px 10px; font-size: 11px; font-weight: bold; background: #fafafa; }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
            .col-apelido-dinamico { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
        }

        .no-print { 
            position: fixed; top: 10px; right: 10px; padding: 12px 25px; 
            background: #27ae60; color: white; border: none; cursor: pointer; 
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR LISTA</button>

    <div class="folha-a4">
        <div class="header">
            <div class="logo"><img src="../img/logo.png" style="width:100%"></div>
            <div class="header-text">
                <h1>LISTA DE PRESENÇA</h1>
                <p>ECC - PARÓQUIA DE SANTO ANTÔNIO - PATOS/PB</p>
                <p><?php echo htmlspecialchars(strtoupper($encontro['encontro'] ?? '')); ?></p>
                <p style="font-weight: normal; font-size: 12px;"><?php echo htmlspecialchars($encontro['periodo'] ?? ''); ?></p>
            </div>
        </div>

        <div class="label-topo">
            <div style="width: 43%;">Casal / Endereço / Contato</div>
            <div style="width: 15%; text-align: center;">Apelidos</div>
            <div style="width: 14%; text-align: center;">Nascimento</div>
            <div style="width: 14%; text-align: center;">Casamento</div>
            <div style="width: 14%; text-align: center;">S | S | D</div>
        </div>

        <?php foreach ($encontristas as $c): 
            $fundo = !empty($c['corhex']) ? $c['corhex'] : '#cccccc';
            $texto = (strtoupper($c['nome_circulo'] ?? '') == 'AMARELO') ? '#5f4b26' : '#ffffff';
        ?>
        <div class="item-casal">
            <div class="casal-row">
                <div class="col-1">
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ele_nome']); ?></div>
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ela_nome']); ?></div>
                    <div style="font-size: 10px; margin-top: 4px; color: #81693b;">
                        <?php echo htmlspecialchars("{$c['endereco']}, {$c['numero']} - {$c['bairro']} | {$c['fone']}"); ?>
                    </div>
                </div>

                <div class="col-2 col-apelido-dinamico" style="background-color: <?php echo $fundo; ?> !important; color: <?php echo $texto; ?>;">
                    <?php echo htmlspecialchars($c['ele_apelido'] ?: '-'); ?><br>
                    <small style="font-weight:normal; font-size:9px;">e</small><br>
                    <?php echo htmlspecialchars($c['ela_apelido'] ?: '-'); ?>
                </div>

                <div class="col-3" style="text-align: center; font-size: 11px; display: flex; flex-direction: column; justify-content: center;">
                    <?php echo $c['ele_nascimento'] ? date('d/m/Y', strtotime($c['ele_nascimento'])) : '--/--/--'; ?><br>
                    <?php echo $c['ela_nascimento'] ? date('d/m/Y', strtotime($c['ela_nascimento'])) : '--/--/--'; ?>
                </div>
                <div class="col-4" style="text-align: center; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?php echo $c['casamento'] ? date('d/m/Y', strtotime($c['casamento'])) : '--/--/--'; ?>
                </div>
                <div class="col-5">
                    <div style="font-size: 7px; font-weight: bold; text-align: center; color: #777;">SEX | SAB | DOM</div>
                    <div class="box-container">
                        <div class="box"></div><div class="box"></div><div class="box"></div>
                    </div>
                </div>
            </div>
            <div class="obs-area">OBSERVAÇÕES: __________________________________________________________________________</div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
</html>