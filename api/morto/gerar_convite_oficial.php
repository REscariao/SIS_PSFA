<?php
require_once 'db.php';

// Configura o fuso horário para garantir a data correta no Sertão
date_default_timezone_set('America/Fortaleza');

$id_encontro = $_GET['encontro'] ?? null;
$equipe_nome = $_GET['equipe'] ?? null;

if (!$id_encontro || !$equipe_nome) die("Dados insuficientes.");

// Busca dados do encontro
$stmt = $pdo->prepare("SELECT * FROM encontros WHERE id = ?");
$stmt->execute([$id_encontro]);
$encontro = $stmt->fetch(PDO::FETCH_ASSOC);

// --- LÓGICA DA SEQUÊNCIA DE DATAS ---
$data_base = new DateTime($encontro['data_inicio']);
$dia1 = $data_base->format('d');
$dia2 = (clone $data_base)->modify('+1 day')->format('d');
$dia3 = (clone $data_base)->modify('+2 days')->format('d');

$meses = [
    'January' => 'Janeiro', 'February' => 'Fevereiro', 'March' => 'Março',
    'April' => 'Abril', 'May' => 'Maio', 'June' => 'Junho',
    'July' => 'Julho', 'August' => 'Agosto', 'September' => 'Setembro',
    'October' => 'Outubro', 'November' => 'Novembro', 'December' => 'Dezembro'
];
$mes_pt = $meses[$data_base->format('F')];
$ano = $data_base->format('Y');

$data_formatada = "{$dia1}, {$dia2} e {$dia3} de {$mes_pt} de {$ano}";

// Busca membros da equipe
$sql = "SELECT c.*, eq.funcao FROM equipes eq 
        JOIN cadastro_geral c ON eq.id_casal = c.id 
        WHERE eq.id_encontro = ? AND eq.nome_equipe = ?
        ORDER BY CASE WHEN eq.funcao = 'Coordenador' THEN 1 ELSE 2 END ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_encontro, $equipe_nome]);
$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Convocação Oficial - <?php echo $equipe_nome; ?></title>
    <link rel="stylesheet" href="../print.css">
    <style>
        .check-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 15px;
            width: 55px;
        }
        .label-aceitou {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
            font-family: Arial, sans-serif;
            color: #81693b;
        }
        .square {
            width: 25px;
            height: 25px;
            border: 1px solid #81693b;
        }

        /* Estilos do Rodapé fixo a 1cm */
        .footer-convocacao {
            position: absolute;
            bottom: 10mm;
            left: 10mm;
            right: 10mm;
            display: flex;
            justify-content: space-between;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #81693b;
        }
        .footer-col-obs { width: 55%; }
        .footer-col-confirmar { width: 35%; text-align: justify; }
    </style>
</head>
<body>

<div class="no-print" style="padding: 10px; background: #eee; text-align: center;">
    <button onclick="window.print()" style="padding: 8px 16px; cursor: pointer; font-weight: bold; color: #81693b">🖨️ IMPRIMIR DOCUMENTO (A4)</button>
</div>

<div class="folha-a4">
    <header class="header-container">
        <div class="logo-area">
            <img src="../img/logo.png" alt="Logo ECC">
        </div>

        <div class="text-area">
            <h1>Diocese de Patos</h1>
            <h2>Paróquia São Francisco de Assis</h2>
            
            <div class="info-encontro">
                <?php echo $encontro['nome_encontro']; ?><br>
                <?php echo $data_formatada; ?>
            </div>

            <div class="equipe-setor">
                Equipe
                <div class="coordenador-label"><?php echo strtoupper($equipe_nome); ?></div>
            </div>
        </div>
    </header>

    <main>
        <?php foreach ($membros as $m): ?>
            <div style="border: 1px solid #81693b; margin-bottom: -1px; display: flex; align-items: flex-start; padding: 10px; font-family: Arial;">
                <div class="check-container">
                    <span class="label-aceitou">Aceitou</span>
                    <div class="square"></div>
                </div>

                <div style="flex: 1;">
                    <span style="font-weight: bold; color: #81693b; text-decoration: underline; font-style: italic; font-size: 13px;">
                        <?php echo $m['funcao'] . " " . $equipe_nome; ?>
                    </span><br>
                    <div style="margin-top: 5px; line-height: 1.2; color: #c5a059;">
                        <strong><?php echo $m['ele_apelido']; ?></strong> <?php echo $m['ele_nome']; ?><br>
                        <strong><?php echo $m['ela_apelido']; ?></strong> <?php echo $m['ela_nome']; ?>
                    </div>
                </div>

                <div style="text-align: right; font-size: 13px; width: 280px; line-height: 1.3; color: #c5a059;">
                    <?php echo $m['endereco']; ?>, <?php echo $m['numero']; ?> - <?php echo $m['bairro']; ?><br>
                    Patos-PB | <strong><?php echo $m['fone']; ?></strong>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <footer class="footer-convocacao">
        <div class="footer-col-obs">
            <strong>Obs.:</strong><br>
            Os membros não devem ter conhecimento dos outros integrantes da equipe até a 1ª reunião, mantendo total sigilo.
        </div>
        
        <div class="footer-col-confirmar">
            <strong>Confirmar os dados:</strong><br>
            <span>Nome: <span style="color:white">____________________________</span></span><br>
            <span>Endereço: <span style="color:white">_________________________</span></span><br>
            <span>Telefone: <span style="color:white">____________________________</span></span><br>
           
        </div>
    </footer>
</div>

</body>
</html>