<?php
// api/gerar_crachas.php
require_once 'db.php'; 

$id_encontro = $_GET['encontro'] ?? null;

// Busca automática do último se não houver ID
if (!$id_encontro) {
    $stmt = $pdo->query("SELECT Codigo FROM Tabela_Encontros ORDER BY Codigo DESC LIMIT 1");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_encontro = $res['Codigo'] ?? null;
}

// Busca os dados
$sql = "SELECT M.Apelido_dele, M.Apelido_dela, C.Circulo AS cor_nome, E.Encontro, E.Periodo
        FROM Tabela_Encontristas TE 
        JOIN Tabela_Membros M ON TE.Cod_Membros = M.Codigo 
        JOIN Tabela_Encontros E ON TE.Cod_Encontro = E.Codigo
        LEFT JOIN Tabela_Cor_Circulos C ON TE.Cod_Circulo = C.Codigo 
        WHERE TE.Cod_Encontro = ? 
        ORDER BY C.Circulo, M.Ele ASC";

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
        body { background-color: #525659; margin: 0; padding: 0; }
        
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
            grid-template-columns: repeat(2, 98mm); /* 2 Colunas */
            grid-template-rows: repeat(4, 65mm);   /* 4 Linhas = 8 por folha */
            gap: 4mm;
            padding: 10mm 5mm;
            justify-content: center;
            box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            /* Evita quebras de página aleatórias */
            page-break-after: always;
            overflow: hidden;
        }

        /* CRACHÁ */
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

        /* Temas de cores */
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

        /* Estilos de Impressão */
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

    <header class="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">⛪ Minha<span>Paróquia</span></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="../index.html">Início</a></li>
                    <li><a href="../secretaria.html">Secretaria</a></li>
                    <li><a href="#" class="active">Encontro</a></li>
                </ul>
            </nav>
        </div>
    </header>

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
                <?php endif; ?>

                <div class="cracha <?php echo $classeTema; ?>" style="background-color: <?php echo obterHexCor($cor); ?>;">
                    <div class="cont">
                        <div class="topo">
                            <img src="<?php echo $logo; ?>" class="logo-ecc">
                            <div class="titulo-encontro">
                                <h2><?php echo $c['Encontro']; ?></h2>
                                <p><?php echo $c['Periodo']; ?></p>
                            </div>
                            <hr>
                        </div>
                        <div class="corpo">
                            <div class="nomes"><?php echo $c['Apelido_dele']; ?> / <?php echo $c['Apelido_dela']; ?></div>
                        </div>
                        <div class="rodape">Paróquia de São Francisco de Assis</div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div> <?php else: ?>
            <div style="background:white; padding: 50px; border-radius: 10px; margin-top: 50px;">
                <h2>Nenhum casal encontrado para este encontro.</h2>
                <p>Verifique se os casais foram vinculados corretamente.</p>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>