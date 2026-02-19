<?php
// api/gerar_crachas.php - Ajustado para HostGator (Linux)
require_once 'db.php'; 

$id_encontro = $_GET['encontro'] ?? null;

// Busca automática do último se não houver ID - Padronizado para minúsculas
if (!$id_encontro) {
    $stmt = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_encontro = $res['codigo'] ?? null;
}

// Busca os dados - Ajustado para os nomes reais das tabelas e colunas minúsculas
$sql = "SELECT m.apelido_dele, m.apelido_dela, m.ele, m.ela, c.circulo AS cor_nome, e.encontro, e.periodo
        FROM tabela_encontristas te 
        JOIN tabela_membros m ON te.cod_membros = m.codigo 
        JOIN tabela_encontros e ON te.cod_encontro = e.codigo
        LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo 
        WHERE te.cod_encontro = ? 
        ORDER BY c.circulo, m.ele ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_encontro]);
$encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

function obterHexCor($nomeCor) {
    $cores = [
        'VERDE'    => '#4CAF50',
        'AMARELO'  => '#ffe600',
        'AZUL'     => '#003cff',
        'VERMELHO' => '#ff0000',
        'ROSA'     => '#ff00ff',
    ];
    return $cores[strtoupper($nomeCor ?? '')] ?? '#cccccc';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Crachás Encontristas</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Estilo para visualização no navegador */
        body { background-color: #525659; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        .area-impressao {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }

        /* FOLHA A4 */
        .folha-a4 {
            width: 210mm;
            height: 297mm;
            background: white;
            display: grid;
            grid-template-columns: repeat(2, 98mm); 
            grid-template-rows: repeat(4, 65mm);   
            gap: 4mm;
            padding: 10mm 5mm;
            justify-content: center;
            box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            page-break-after: always;
            overflow: hidden;
        }

        .cracha { width: 98mm; height: 65mm; display: flex; align-items: center; justify-content: center; position: relative; }
        
        .cont { 
            border: 1mm solid #fff; 
            padding: 3mm; 
            width: 88mm; 
            height: 55mm; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            box-sizing: border-box; 
        }

        .tema-preto .cont { border-color: #000; color: #000; }
        .tema-preto hr { border-top: 0.7mm solid #000 !important; }
        .tema-preto .titulo-encontro, .tema-preto .corpo, .tema-preto .rodape { color: #000; border-color: #000; }

        .topo { display: flex; align-items: center; height: 18mm; position: relative; }
        .logo-ecc { width: 17mm; height: auto; margin-right: 5px; }
        .titulo-encontro { flex-grow: 1; text-align: center; color: #fff; }
        .titulo-encontro h2 { margin: 0; font-size: 11px; text-transform: uppercase; }
        .titulo-encontro p { margin: 2px 0; font-size: 9px; font-weight: bold; }
        
        hr { position: absolute; bottom: 0; left: 30%; width: 63%; border: none; border-top: 0.7mm solid #ffffff; margin: 0; }
        
        .corpo { color: #fff; flex-grow: 1; display: flex; align-items: center; justify-content: center; border-bottom: 0.5mm solid #fff; }
        .nomes { font-size: 20px; font-weight: bold; text-align: center; text-transform: uppercase; }
        
        .rodape { padding-top: 4px; text-align: center; font-weight: bold; font-size: 12px; color: #fff; text-transform: uppercase; }

        @media print {
            @page { size: A4; margin: 0; }
            .navbar, .footer, .btn-print-float { display: none !important; }
            body { background: none; }
            .area-impressao { padding: 0; }
            .folha-a4 { box-shadow: none; margin: 0; }
            .cracha { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .btn-print-float { 
            position: fixed; bottom: 30px; right: 30px; 
            background: #27ae60; color: white; border: none; 
            padding: 15px 25px; border-radius: 50px; font-weight: bold; 
            cursor: pointer; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <button class="btn-print-float" onclick="window.print()">🖨️ Imprimir Crachás</button>

    <main class="area-impressao">
        <?php if (count($encontristas) > 0): ?>
            <div class="folha-a4">
            <?php foreach ($encontristas as $i => $c): 
                $cor = strtoupper($c['cor_nome'] ?? '');
                $classeTema = ($cor == 'AMARELO') ? 'tema-preto' : '';
                $logo = ($cor == 'AMARELO') ? '../img/logo_preta.png' : '../img/logo_branca.png';
                
                // Abre nova folha se já imprimiu 8 e ainda tem mais casais
                if ($i > 0 && $i % 8 == 0): ?>
                    </div><div class="folha-a4">
                <?php endif; 

                // Lógica para apelidos: Se não houver, usa o primeiro nome
                $nomeDele = $c['apelido_dele'] ?: explode(' ', $c['ele'])[0];
                $nomeDela = $c['apelido_dela'] ?: explode(' ', $c['ela'])[0];
                ?>

                <div class="cracha <?php echo $classeTema; ?>" style="background-color: <?php echo obterHexCor($cor); ?>;">
                    <div class="cont">
                        <div class="topo">
                            <img src="<?php echo $logo; ?>" class="logo-ecc">
                            <div class="titulo-encontro">
                                <h2><?php echo htmlspecialchars($c['encontro']); ?></h2>
                                <p><?php echo htmlspecialchars($c['periodo']); ?></p>
                            </div>
                            <hr>
                        </div>
                        <div class="corpo">
                            <div class="nomes"><?php echo htmlspecialchars($nomeDele); ?> / <?php echo htmlspecialchars($nomeDela); ?></div>
                        </div>
                        <div class="rodape">Paróquia de Santo Antônio</div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div> 
        <?php else: ?>
            <div style="background:white; padding: 50px; border-radius: 10px; margin-top: 50px; text-align: center;">
                <h2>Nenhum encontrista cadastrado.</h2>
                <p>Verifique o vínculo de casais para este encontro.</p>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>