<?php
// Ajustado para o padrão de letras minúsculas do Linux/HostGator
require_once 'db.php';

date_default_timezone_set('America/Fortaleza');

try {
    // PADRONIZAÇÃO: Mudança para tabela_encontros e codigo em minúsculo
    $stmt_encontro = $pdo->query("SELECT * FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $encontro = $stmt_encontro->fetch(PDO::FETCH_ASSOC);
    
    if (!$encontro) die("Nenhum encontro encontrado.");

    // Busca a lista de casais escalados para este encontro
    $id_encontro = $encontro['codigo'];
    
    // Ajustado para colunas e tabelas minúsculas: tabela_encontristas, tabela_membros, cod_membros, cod_encontro
    $sql = "SELECT m.apelido_dele, m.apelido_dela FROM tabela_encontristas te 
            JOIN tabela_membros m ON te.cod_membros = m.codigo 
            WHERE te.cod_encontro = ? ORDER BY m.ele ASC";
            
    $stmt_casais = $pdo->prepare($sql);
    $stmt_casais->execute([$id_encontro]);
    $casais = $stmt_casais->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lembranças 4 por Folha</title>
    <style>
        /* 1. CONFIGURAÇÃO DA FOLHA A4 */
        @page { size: A4; margin: 0; }
        body { margin: 0; padding: 0; background: #525659; }

        .pagina {
            width: 210mm;
            height: 297mm;
            background: white;
            margin: 10mm auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            box-sizing: border-box;
            padding: 5mm;
            gap: 2mm;
            page-break-after: always;
        }

        /* 2. CADA UNIDADE (1/4 da folha) */
        .card {
            position: relative;
            border: 1px dashed #ccc;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .img-fundo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* 3. INFORMAÇÕES DINÂMICAS */
        .conteudo {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 25px;
            text-align: center;
        }

        .nome-casal {
            font-family: Arial, sans-serif;
            font-size: 20px;
            font-weight: bold;
            color: #960303;
            margin-bottom: 35px;
        }

        .info-encontro {
            font-family: Arial, sans-serif;
            font-size: 11px;
            font-weight: bold;
            color: #53411e;
            text-transform: uppercase;
        }

        .nome-paroquia {
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: bold;
            color: #53411e;
            margin-top: 5px;
        }

        @media print {
            body { background: none; }
            .pagina { margin: 0; box-shadow: none; }
            .no-print { display: none; }
            .card { border: none; }
            /* Garante que o fundo seja impresso no Chrome/Edge */
            .img-fundo { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .no-print {
            position: fixed; top: 10px; right: 10px; padding: 12px 25px;
            background: #27ae60; color: white; border: none; cursor: pointer;
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

<button class="no-print" onclick="window.print()">🖨️ IMPRIMIR (4 POR FOLHA)</button>

<?php 
$paginas_casais = array_chunk($casais, 4);

foreach ($paginas_casais as $grupo):
?>
<div class="pagina">
    <?php foreach ($grupo as $c): ?>
    <div class="card">
        <img src="../img/fundo_vela.png" class="img-fundo">

        <div class="conteudo">
            <div class="nome-casal">
                <?php echo htmlspecialchars($c['apelido_dele'] . " / " . $c['apelido_dela']); ?>
            </div>

            <div class="info-encontro">
                <?php echo htmlspecialchars($encontro['encontro']); ?><br>
                <?php echo htmlspecialchars($encontro['periodo']); ?>
            </div>

            <div class="nome-paroquia">
                Paróquia São Francisco de Assis
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>

</body>
</html>