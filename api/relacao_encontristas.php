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
            ORDER BY m.ele ASC"; 
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        /* HEADER AJUSTADO */
        .header { 
            position: relative; /* Necessário para posicionar a logo absoluta */
            display: flex; 
            justify-content: center; 
            align-items: center;
            border-bottom: 2px solid #81693b; 
            padding-bottom: 10px; 
            margin-bottom: 20px;
            min-height: 80px;
        }
        
        .logo { 
            position: absolute; 
            left: 5%; 
            top: 0;
            width: 80px; 
        }

        .header-text { padding-left: 20%; color: #5f4b26; text-align: center; width: 100%; }
        .header-text h1 { color: #81693b; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header-text p { color: #81693b; margin: 2px 0; font-size: 13px; font-weight: bold; }

        .label-topo { 
            color: #81693b; display: flex; font-size: 10px; font-weight: bold; 
            text-transform: uppercase; border-bottom: 1px solid #81693b;
            padding-bottom: 5px; margin-bottom: 8px;
        }

        .item-casal { color: #81693b; margin-bottom: 8px; } 
        .casal-row { display: flex; border: 1px solid #5f4b26; background: #fff; }
        
        .col-1 { width: 45%; border-right: 1px solid #5f4b26; padding: 5px; }
        .col-2 { width: 15%; border-right: 1px solid #5f4b26; padding: 4px; } 
        .col-3 { width: 14%; border-right: 1px solid #5f4b26; padding: 4px; } 
        .col-4 { width: 14%; border-right: 1px solid #5f4b26; padding: 4px; } 
        .col-5 { width: 12%; padding: 4px; }

        .col-apelido-dinamico {
            font-weight: bold; text-align: center; display: flex;
            flex-direction: column; justify-content: center; font-size: 13px;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        .box-container { display: flex; justify-content: center; gap: 2px; margin-top: 5px; }
        .box { width: 18px; height: 18px; border: 1px solid #5f4b26; background: #fff; }
        .obs-area { color: #81693b; border: 1px solid #5f4b26; border-top: none; padding: 3px 10px; font-size: 11px; font-weight: bold; background: #fafafa; }

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

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR LISTA</button>

    <?php foreach ($paginas as $indice => $casais_da_pagina): ?>
    <div class="folha-a4">
        <div class="header">
            <div class="logo">
                <img src="../img/logoParoquia.png" style="width:100%">
            </div>
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
            $cor_nome = strtoupper($c['nome_circulo'] ?? '');
            $texto = (in_array($cor_nome, ['AMARELO', 'ROSA', 'LARANJA'])) ? '#5f4b26' : '#ffffff';
        ?>
        <div class="item-casal">
            <div class="casal-row">
                <div class="col-1">
                    <div style="font-weight: bold; font-size: 13px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ele_nome']); ?></div>
                    <div style="font-weight: bold; font-size: 13px; text-transform: uppercase;"><?php echo htmlspecialchars($c['ela_nome']); ?></div>
                    <div style="font-size: 9px; margin-top: 3px; color: #81693b;">
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

        <div style="position: absolute; bottom: 10mm; right: 15mm; font-size: 10px; color: #81693b;">
            Página <?php echo ($indice + 1) . ' de ' . count($paginas); ?>
        </div>
    </div>
    <?php endforeach; ?>

</body>
=======
<?php
require_once 'db.php'; 

// Ajuste de fuso horário para o Nordeste
date_default_timezone_set('America/Fortaleza');

// Verifica se um ID foi passado, caso contrário, busca o último evento cadastrado
$id_encontro = $_GET['encontro'] ?? null;

try {
    // PADRONIZAÇÃO: Nomes de tabelas e colunas em minúsculas para HostGator (Linux)
    if (!$id_encontro) {
        $stmt_ultimo = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
        $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        $id_encontro = $ultimo['codigo'] ?? null;
    }

    if (!$id_encontro) {
        die("Erro: Nenhum encontro encontrado no sistema.");
    }

    // 1. Busca dados do encontro
    $stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Busca a relação de encontristas
    // Nota: 'cor' é onde guardamos o Hexadecimal na sua tabela_cor_circulos
    $sql = "SELECT 
                m.ele AS ele_nome, m.ela AS ela_nome, 
                m.apelido_dele AS ele_apelido, m.apelido_dela AS ela_apelido,
                m.fone, m.bairro,
                c.circulo AS nome_circulo, c.cor AS cor_hex
            FROM tabela_encontristas te 
            JOIN tabela_membros m ON te.cod_membros = m.codigo 
            LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
            WHERE te.cod_encontro = ? 
            ORDER BY m.ele ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro técnico no banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relação de Encontristas - <?php echo htmlspecialchars($encontro['encontro'] ?? ''); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 10mm; }
        body { background-color: #f4f7f6; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }

        .folha-a4 { 
            width: 210mm; min-height: 297mm; background: white; 
            padding: 15mm; box-sizing: border-box; margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .header { 
            border-bottom: 3px solid #81693b; padding-bottom: 15px; margin-bottom: 25px;
            text-align: center;
        }
        
        .header h1 { color: #81693b; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { color: #555; margin: 5px 0; font-size: 14px; font-weight: bold; }

        .relacao-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .relacao-table th { 
            background: #f8f9fa; color: #81693b; text-align: left; 
            padding: 12px; font-size: 11px; text-transform: uppercase;
            border-bottom: 2px solid #81693b;
        }
        .relacao-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 13px; color: #333; }

        .circulo-badge {
            padding: 4px 10px; border-radius: 12px; font-size: 10px; 
            font-weight: bold; text-transform: uppercase; color: white;
            display: inline-block;
            text-shadow: 0px 1px 2px rgba(0,0,0,0.3); /* Melhora leitura em cores claras */
        }

        .contato-info { font-size: 12px; color: #666; }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
            .circulo-badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .no-print { 
            position: fixed; top: 20px; right: 20px; padding: 12px 25px; 
            background: #27ae60; color: white; border: none; cursor: pointer; 
            border-radius: 8px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ Imprimir Relação</button>

    <div class="folha-a4">
        <div class="header">
            <h1>Relação Geral de Encontristas</h1>
            <p><?php echo strtoupper($encontro['encontro'] ?? 'Sem Título'); ?> - <?php echo $encontro['periodo'] ?? ''; ?></p>
            <p>Paróquia de Santo Antônio - Patos/PB</p>
        </div>

        <table class="relacao-table">
            <thead>
                <tr>
                    <th style="width: 5%;">Nº</th>
                    <th style="width: 40%;">Casal (Ele & Ela)</th>
                    <th style="width: 20%;">Apelidos</th>
                    <th style="width: 20%;">Círculo</th>
                    <th style="width: 15%;">Fone</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $cont = 1;
                foreach ($encontristas as $c): 
                    $cor_fundo = !empty($c['cor_hex']) ? $c['cor_hex'] : '#999';
                ?>
                <tr>
                    <td><?php echo str_pad($cont++, 2, "0", STR_PAD_LEFT); ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($c['ele_nome']); ?></strong><br>
                        <strong><?php echo htmlspecialchars($c['ela_nome']); ?></strong>
                    </td>
                    <td><?php echo htmlspecialchars($c['ele_apelido'] ?: '-'); ?> & <?php echo htmlspecialchars($c['ela_apelido'] ?: '-'); ?></td>
                    <td>
                        <span class="circulo-badge" style="background-color: <?php echo $cor_fundo; ?>;">
                            <?php echo htmlspecialchars($c['nome_circulo'] ?? 'Não definido'); ?>
                        </span>
                    </td>
                    <td class="contato-info">
                        <?php echo htmlspecialchars($c['fone'] ?: 'N/A'); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 30px; font-size: 11px; text-align: center; color: #999;">
            Total de Casais: <?php echo count($encontristas); ?>
        </div>
    </div>
</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
</html>