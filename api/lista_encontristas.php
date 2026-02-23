<?php
require_once 'db.php';

$id_encontro = $_GET['encontro'] ?? null;

if (!$id_encontro) {
    $stmt = $pdo->query("SELECT codigo, encontro, periodo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $encontro_atual = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_encontro = $encontro_atual['codigo'] ?? null;
} else {
    $stmt = $pdo->prepare("SELECT encontro, periodo FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro_atual = $stmt->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT m.apelido_dele, m.apelido_dela, c.circulo AS nome_circulo, c.cor AS cor_hex
        FROM tabela_encontristas te 
        JOIN tabela_membros m ON te.cod_membros = m.codigo 
        JOIN tabela_encontros e ON te.cod_encontro = e.codigo
        LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
        WHERE te.cod_encontro = ? 
        ORDER BY c.circulo ASC, m.apelido_dele ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_encontro]);
$encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Encontristas - Design Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Configurações Gerais */
        @page { size: A4; margin: 10mm; }
        
        body { 
            font-family: 'Open Sans', sans-serif; 
            background-color: #f0f2f5; 
            margin: 0; 
            padding: 20px; 
            color: #2d3436; 
        }

        .container-a4 { 
            width: 100%; 
            max-width: 210mm; 
            margin: auto; 
            background: white; 
            padding: 40px; 
            box-sizing: border-box; 
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Cabeçalho Estilizado */
        header { 
            text-align: center; 
            border-bottom: 3px solid #81693b; 
            margin-bottom: 30px; 
            padding-bottom: 20px; 
        }

        header h1 { 
            margin: 0; 
            font-family: 'Montserrat', sans-serif;
            font-size: 26pt; 
            color: #81693b;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        header p { 
            margin: 10px 0 5px 0; 
            font-size: 16pt; 
            font-weight: 600; 
            color: #5f4b26; 
        }

        header .periodo {
            font-size: 11pt;
            color: #b2bec3;
            font-style: italic;
        }

        /* Tabela Estilizada */
        table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        
        thead th { 
            font-family: 'Montserrat', sans-serif;
            padding: 15px; 
            color: #81693b;
            text-align: left;
            text-transform: uppercase; 
            font-size: 10pt; 
            border-bottom: 2px solid #f1f2f6;
        }
        
        tbody tr {
            background-color: #ffffff;
            transition: transform 0.2s;
        }

        td { 
            padding: 15px; 
            font-size: 12pt; 
            border-bottom: 1px solid #f1f2f6;
        }

        .td-numero {
            font-weight: bold;
            color: #dfe6e9;
            font-size: 14pt;
        }

        .casal-nome {
            font-size: 13pt;
            color: #2d3436;
        }

        .casal-nome b {
            color: #81693b;
            font-weight: 700;
        }

        /* Badge do Círculo */
        .badge-circulo {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 50px;
            color: white;
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Ajustes para Impressão */
        @media print {
            body { background: none; padding: 0; }
            .container-a4 { 
                box-shadow: none; 
                margin: 0; 
                padding: 10mm; 
                max-width: 100%; 
            }
            .no-print { display: none; }
            table { border-spacing: 0; } /* Melhora alinhamento na impressão */
            tbody tr { border-bottom: 1px solid #ddd; }
        }

        /* Botão Flutuante */
        .btn-print {
            position: fixed; top: 30px; right: 30px;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white; border: none;
            padding: 15px 30px; border-radius: 50px; cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: bold; font-size: 12pt;
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
            transition: all 0.3s;
            z-index: 1000;
        }

        .btn-print:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(46, 204, 113, 0.4); }
    </style>
</head>
<body>

    <button class="btn-print no-print" onclick="window.print()">🖨️ IMPRIMIR LISTAGEM</button>

    <div class="container-a4">
        <header>
            <h1>Encontristas</h1>
            <p><?php echo htmlspecialchars($encontro_atual['encontro']); ?></p>
            <div class="periodo"><?php echo htmlspecialchars($encontro_atual['periodo']); ?></div>
        </header>

        <table>
            <thead>
                <tr>
                    <th width="8%">Nº</th>
                    <th width="62%">Casal</th>
                    <th width="30%" style="text-align: right;">Círculo / Equipe</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $cont = 1;
                foreach ($encontristas as $c): 
                    $corBadge = $c['cor_hex'] ?? '#b2bec3';
                ?>
                <tr>
                    <td class="td-numero"><?php echo str_pad($cont++, 2, "0", STR_PAD_LEFT); ?></td>
                    <td class="casal-nome">
                        <b><?php echo htmlspecialchars($c['apelido_dele']); ?></b> e 
                        <b><?php echo htmlspecialchars($c['apelido_dela']); ?></b>
                    </td>
                    <td style="text-align: right;">
                        <span class="badge-circulo" style="background-color: <?php echo $corBadge; ?>;">
                            <?php echo htmlspecialchars($c['nome_circulo'] ?? 'Pendente'); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>