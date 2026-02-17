<?php
require_once 'api/db.php';

// 1. Busca o último encontro para saber de qual evento estamos falando
$stmt_encontro = $pdo->query("SELECT Codigo, Encontro, Periodo FROM tabela_encontros ORDER BY Codigo DESC LIMIT 1");
$encontro = $stmt_encontro->fetch(PDO::FETCH_ASSOC);

if (!$encontro) {
    die("Nenhum encontro cadastrado.");
}

// 2. Busca os casais agrupados por círculo
$sql = "SELECT 
            C.Circulo AS cor_nome, 
            C.CorHex,
            M.Ele, M.Ela, 
            M.Apelido_dele, M.Apelido_dela
        FROM Tabela_Encontristas TE 
        JOIN Tabela_Membros M ON TE.Cod_Membros = M.Codigo 
        JOIN Tabela_Encontros E ON TE.Cod_Encontro = E.Codigo
        LEFT JOIN Tabela_Cor_Circulos C ON TE.Cod_Circulo = C.Codigo 
        WHERE TE.Cod_Encontro = ? 
        ORDER BY C.Circulo, M.Ele ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$encontro['Codigo']]);
$dados = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Círculos Montados - ECC</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .grid-ciclos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .card-ciclo {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }
        .ciclo-header {
            padding: 15px 20px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .count-badge {
            background: rgba(0,0,0,0.15);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .lista-casais {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .lista-casais li {
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.95rem;
            display: flex;
            flex-direction: column;
        }
        .lista-casais li:last-child { border-bottom: none; }
        .nome-real { font-weight: 600; color: #333; }
        .apelidos { color: #777; font-size: 0.85rem; margin-top: 2px; }
        
        /* Estilização do Topo */
        .encontro-banner {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #ddd;
            text-align: center;
            margin-bottom: 10px;
        }
        .encontro-banner h1 { margin: 0; color: #1a237e; font-size: 1.8rem; }
        .encontro-banner p { margin: 10px 0 0; color: #555; font-weight: 600; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">⛪ Minha<span>Paróquia</span></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html">Início</a></li>
                    <li><a href="encontros.html">Encontros</a></li>
                    <li><a href="#" class="active">Círculos</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">


        <div class="grid-ciclos">
                    <div class="encontro-banner">
            <h1><?php echo $encontro['Encontro']; ?></h1>
            <p>📅 <?php echo $encontro['Periodo']; ?></p>
        </div>
            <?php foreach ($dados as $cor => $casais): 
                $corFundo = $casais[0]['CorHex'] ?? '#333';
                $corTexto = (strtoupper($cor) == 'AMARELO') ? '#000' : '#fff';
            ?>
                <div class="card-ciclo">
                    <div class="ciclo-header" style="background-color: <?php echo $corFundo; ?>; color: <?php echo $corTexto; ?>;">
                        <span>Círculo <?php echo $cor; ?></span>
                        <span class="count-badge"><?php echo count($casais); ?> Casais</span>
                    </div>
                    <div class="ciclo-body">
                        <ul class="lista-casais">
                            <?php foreach ($casais as $c): ?>
                                <li>
                                    <span class="nome-real"><?php echo $c['Ele']; ?> & <?php echo $c['Ela']; ?></span>
                                    <span class="apelidos"><?php echo $c['Apelido_dele']; ?> / <?php echo $c['Apelido_dela']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Patos-PB</p>
    </footer>

</body>
</html>