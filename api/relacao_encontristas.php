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
</html>