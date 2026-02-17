<?php
require_once 'db.php'; 

date_default_timezone_set('America/Fortaleza');

// Verifica se um ID foi passado, caso contrário, busca o último evento cadastrado
$id_encontro = $_GET['encontro'] ?? null;

try {
    if (!$id_encontro) {
        // Busca o último encontro baseado no maior Código
        $stmt_ultimo = $pdo->query("SELECT Codigo FROM Tabela_Encontros ORDER BY Codigo DESC LIMIT 1");
        $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        $id_encontro = $ultimo['Codigo'] ?? null;
    }

    if (!$id_encontro) {
        die("Erro: Nenhum encontro encontrado no sistema.");
    }

    // 1. Busca dados do encontro selecionado ou do último
    $stmt = $pdo->prepare("SELECT * FROM Tabela_Encontros WHERE Codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$encontro) die("Erro: Encontro não encontrado.");

    // 2. Busca os casais e a cor do seu respectivo círculo
    $sql = "SELECT 
                M.Ele AS ele_nome, M.Ela AS ela_nome, 
                M.Apelido_dele AS ele_apelido, M.Apelido_dela AS ela_apelido,
                M.Nascimento_dele AS ele_nascimento, M.Nascimento_dela AS ela_nascimento,
                M.Casamento, M.End_Rua AS endereco, M.Numero, M.Bairro, M.Fone,
                C.CorHex, C.Circulo AS nome_circulo
            FROM Tabela_Encontristas TE 
            JOIN Tabela_Membros M ON TE.Cod_Membros = M.Codigo 
            LEFT JOIN Tabela_Cor_Circulos C ON TE.Cod_Circulo = C.Codigo
            WHERE TE.Cod_Encontro = ? 
            ORDER BY C.Circulo, M.Ele ASC";
            
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
            .destaque-amarelo { 
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
                <p><?php echo strtoupper($encontro['Encontro']); ?></p>
                <p style="font-weight: normal; font-size: 12px;"><?php echo $encontro['Periodo']; ?></p>
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
            $fundo = !empty($c['CorHex']) ? $c['CorHex'] : '#cccccc';
            $texto = (strtoupper($c['nome_circulo'] ?? '') == 'AMARELO') ? '#5f4b26' : '#ffffff';
        ?>
        <div class="item-casal">
            <div class="casal-row">
                <div class="col-1">
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo $c['ele_nome']; ?></div>
                    <div style="font-weight: bold; font-size: 14px; text-transform: uppercase;"><?php echo $c['ela_nome']; ?></div>
                    <div style="font-size: 10px; margin-top: 4px; color: #81693b;">
                        <?php echo "{$c['endereco']}, {$c['Numero']} - {$c['Bairro']} | {$c['Fone']}"; ?>
                    </div>
                </div>

                <div class="col-2 col-apelido-dinamico" style="background-color: <?php echo $fundo; ?> !important; color: <?php echo $texto; ?>;">
                    <?php echo $c['ele_apelido']; ?><br>
                    <small style="font-weight:normal; font-size:9px;">e</small><br>
                    <?php echo $c['ela_apelido']; ?>
                </div>

                <div class="col-3" style="text-align: center; font-size: 11px; display: flex; flex-direction: column; justify-content: center;">
                    <?php echo $c['ele_nascimento'] ? date('d/m/Y', strtotime($c['ele_nascimento'])) : '--/--/--'; ?><br>
                    <?php echo $c['ela_nascimento'] ? date('d/m/Y', strtotime($c['ela_nascimento'])) : '--/--/--'; ?>
                </div>
                <div class="col-4" style="text-align: center; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    <?php echo $c['Casamento'] ? date('d/m/Y', strtotime($c['Casamento'])) : '--/--/--'; ?>
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
</html>