<?php
require_once 'db.php';

// Pegar o encontro ativo
$stmtE = $pdo->query("SELECT * FROM Tabela_Encontros WHERE Etapa = 1 ORDER BY Codigo DESC LIMIT 1");
$encontro = $stmtE->fetch(PDO::FETCH_ASSOC);

// Buscar Encontristas (Vivenciando)
$sql = "SELECT M.Ele, M.Ela, M.Apelido_dele, M.Apelido_dela 
        FROM Tabela_Encontristas E
        JOIN Tabela_Membros M ON E.Cod_Membros = M.Codigo
        WHERE E.Cod_Encontro = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$encontro['Codigo']]);
$casais = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lógica da Data usando o campo 'Periodo' da nova tabela
$periodo = $encontro['Periodo']; // Ex: "21, 22 e 23 de Dezembro"
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Etiquetas de Velas - <?php echo $anoAtual; ?></title>
    <style>
        /* Estilo para impressão */
        @media print {
            .btn-imprimir { display: none; }
            body { background: none; }
        }

        body { font-family: 'Inter', sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        
        .folha-a4 {
            width: 210mm;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 colunas */
            gap: 15px;
        }

        .cartao-vela {
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            height: 120mm; /* Ajuste conforme o tamanho do papel da vela */
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Joga o texto para baixo */
            text-align: center;
            box-sizing: border-box;
            border-radius: 8px;
        }

        .nome-casal {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1a237e;
            margin-bottom: 5px;
        }

        .linha-divisoria {
            width: 80%;
            height: 2px;
            background-color: #333;
            margin: 0 auto 15px auto;
        }

        .rodape-cartao {
            font-size: 14px;
            line-height: 1.4;
            color: #555;
        }

        .btn-imprimir {
            display: block;
            width: 200px;
            margin: 0 auto 20px auto;
            padding: 10px;
            background: #1a237e;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <button class="btn-imprimir" onclick="window.print()">Imprimir Etiquetas</button>

    <div class="folha-a4">
        <?php foreach ($casais as $casal): ?>
            <div class="cartao-vela">
                <div class="nome-casal">
                    <?php echo $casal['ele_nome'] . " & " . $casal['ela_nome']; ?>
                </div>
                
                <div class="linha-divisoria"></div>

                <div class="rodape-cartao">
                    <strong><?php echo $encontro['nome_encontro']; ?></strong><br>
                    <?php 
                        // Formata as datas (Ex: 15, 16 e 17 de Maio de 2026)
                        echo date('d, ', strtotime($encontro['data_inicio'])) . 
                             date('d', strtotime($encontro['data_inicio'] . ' + 1 days')) . " e " . 
                             date('d', strtotime($encontro['data_inicio'] . ' + 2 days')) . " de " .
                             strftime('%B de %Y', strtotime($encontro['data_inicio']));
                    ?><br>
                    Paróquia São Francisco de Assis - Patos-PB
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>