<?php
require_once 'db.php';

$id_encontro = $_GET['encontro'] ?? null;

if (!$id_encontro) {
    $stmt = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_encontro = $res['codigo'] ?? null;
}

/** * 1. BUSCA ENCONTRISTAS (Círculos Coloridos)
 */
$sqlEncontristas = "SELECT m.apelido_dele, m.apelido_dela, e.encontro, e.periodo, 
                           c.circulo AS cor_nome, c.cor AS cor_hex, 'Encontrista' AS tipo_vinculo
                    FROM tabela_encontristas te 
                    JOIN tabela_membros m ON te.cod_membros = m.codigo 
                    JOIN tabela_encontros e ON te.cod_encontro = e.codigo
                    LEFT JOIN tabela_cor_circulos c ON te.cod_circulo = c.codigo
                    WHERE te.cod_encontro = ? 
                    ORDER BY m.apelido_dele ASC";

$stmt = $pdo->prepare($sqlEncontristas);
$stmt->execute([$id_encontro]);
$encontristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

/** * 2. BUSCA EQUIPE DE TRABALHO (Filtra especificamente a equipe 'Sala')
 */
$sqlSala = "SELECT m.apelido_dele, m.apelido_dela, e.encontro, e.periodo, 
                   'Sala' AS cor_nome, '#81693b' AS cor_hex, 'Sala' AS tipo_vinculo
            FROM tabela_equipes_trabalho tet
            JOIN tabela_membros m ON tet.Cod_Membros = m.codigo
            JOIN tabela_encontros e ON tet.Cod_Encontro = e.codigo
            WHERE tet.Cod_Encontro = ? AND tet.Equipe = 'Sala'
            ORDER BY m.apelido_dele ASC";

$stmtSala = $pdo->prepare($sqlSala);
$stmtSala->execute([$id_encontro]);
$equipeSala = $stmtSala->fetchAll(PDO::FETCH_ASSOC);

// Une as duas listas para gerar todos os crachás coração
$todos = array_merge($encontristas, $equipeSala);
$paginas = array_chunk($todos, 2);

function definirImagemCora($corNome) {
    $cor = mb_strtolower($corNome, 'UTF-8');
    
    if (strpos($cor, 'sala') !== false)    return '../img/coraBranco.png'; 
    if (strpos($cor, 'amarelo') !== false) return '../img/coraAmarelo.png';
    if (strpos($cor, 'azul') !== false)    return '../img/coraAzul.png';
    if (strpos($cor, 'rosa') !== false)    return '../img/coraRosa.png';
    if (strpos($cor, 'vermelho') !== false) return '../img/coraVermelho.png';
    if (strpos($cor, 'verde') !== false)   return '../img/coraVerde.png';
    
    return '../img/coraAzul.png';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Crachás Coração - Encontristas e Sala</title>
    <style>
        @page { size: A4; margin: 0; }
        body { background-color: #525659; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        .area-impressao { display: flex; flex-direction: column; align-items: center; padding: 10mm 0; }
        .folha-a4 {
            width: 297mm; height: 210mm;
            background: white;
            display: flex; flex-direction: column; justify-content: space-around;
            padding: 10mm; box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0,0,0,0.3); margin-bottom: 20px;
            page-break-after: always;
        }
        .cracha-container {
            position: relative; width: 279mm; height: 87mm;
            background-size: contain; background-repeat: no-repeat; background-position: center; margin: 0 auto;
        }
        .nomes-esquerda, .nomes-direita {
            position: absolute; width: 90mm; height: 50mm;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center; font-size: 30pt; font-weight: bold;
            font-family: 'Georgia', serif; font-style: italic; line-height: 0.5;
        }
        .nomes-esquerda { left: 5mm; top: 15mm; }
        .nomes-direita { left: 145mm; top: 15mm; }

        .info-evento {
            position: absolute; text-align: center;
            color: #81693b; 
            font-size: 15pt; font-weight: bold; width: 45mm;
        }
        .info-esq { left: 91mm; top: 15mm; }
        .info-dir { left: 231mm; top: 15mm; }
        .logo-mini { width: 22mm; margin-bottom: 3px; }

        @media print {
            body { background: none; }
            .area-impressao { padding: 0; }
            .no-print { display: none; }
            .folha-a4 { box-shadow: none; margin: 0; }
        }
        .btn-print { position: fixed; top: 20px; right: 20px; z-index: 100; padding: 10px 20px; background: #27ae60; color: white; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>

    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir Crachás</button>

    <main class="area-impressao">
        <?php foreach ($paginas as $parCasais): ?>
            <div class="folha-a4">
                <?php foreach ($parCasais as $c): 
                    $imagemFundo = definirImagemCora($c['cor_nome'] ?? '');
                    // A cor será a do banco para encontristas ou #81693b para a Sala
                    $corTexto = (!empty($c['cor_hex'])) ? $c['cor_hex'] : '#1a237e';
                ?>
                    <div class="cracha-container" style="background-image: url('<?php echo $imagemFundo; ?>');">
                        
                        <div class="nomes-esquerda" style="color: <?php echo $corTexto; ?>;">
                            <?php echo htmlspecialchars($c['apelido_dele']); ?><br>
                            <span style="font-size: 12pt; padding: 5% 0 0 0;">e</span><br>
                            <?php echo htmlspecialchars($c['apelido_dela']); ?>
                        </div>

                        <div class="nomes-direita" style="color: <?php echo $corTexto; ?>;">
                            <?php echo htmlspecialchars($c['apelido_dela']); ?><br>
                            <span style="font-size: 12pt; padding: 5% 0 0 0; ">e</span><br>
                            <?php echo htmlspecialchars($c['apelido_dele']); ?>
                        </div>

                        <div class="info-evento info-esq">
                            <img src="../img/logoParoquia.png" class="logo-mini"><br>
                            <?php echo htmlspecialchars($c['encontro']); ?><br>
                            <span style="font-size: 10pt;"><?php echo htmlspecialchars($c['periodo']); ?></span>
                        </div>

                        <div class="info-evento info-dir">
                            <img src="../img/logoParoquia.png" class="logo-mini"><br>
                            <?php echo htmlspecialchars($c['encontro']); ?><br>
                            <span style="font-size: 10pt;"><?php echo htmlspecialchars($c['periodo']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </main>

</body>
</html>