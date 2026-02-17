<?php
require_once 'db.php';

// Fuso horário local
date_default_timezone_set('America/Fortaleza');

$id_encontro = $_GET['encontro'] ?? null;
$equipe_nome = $_GET['equipe'] ?? null;

if (!$id_encontro || !$equipe_nome) die("Dados insuficientes.");

// 1. Busca dados do encontro na sua tabela_encontros
$stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE Codigo = ?");
$stmt->execute([$id_encontro]);
$encontro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$encontro) die("Encontro não encontrado.");

// 2. Busca os membros da equipe usando suas tabelas reais
$sql = "SELECT 
            m.*, 
            eq.Funcao as funcao 
        FROM tabela_equipes_trabalho eq 
        JOIN tabela_membros m ON eq.Cod_Membros = m.Codigo 
        WHERE eq.Cod_Encontro = ? AND eq.Equipe = ?
        ORDER BY CASE WHEN eq.Funcao LIKE '%Coordenador%' THEN 1 ELSE 2 END ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_encontro, $equipe_nome]);
$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Convocação Oficial - <?php echo $equipe_nome; ?></title>
    <style>
        /* 1. CONFIGURAÇÕES GERAIS DE PÁGINA */
        @page { 
            size: A4; 
            margin: 0; 
        }
        
        body { 
            background: #525659; /* Fundo cinza para destacar a folha no monitor */
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
        }

        /* Container que simula a folha A4 física */
        .folha-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm; /* Ajuste as margens internas da folha aqui */
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            position: relative;
            box-sizing: border-box;
        }

        /* 2. CABEÇALHO (Logo e Títulos) */
        .header-container { 
            display: flex; 
            justify-content: center;
            align-items: center; 
            border-bottom: 2px solid #81693b; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }

        .logo-area img { 
            width: 100px; /* Ajuste o tamanho da logo */
            margin-right: 30px; 
        }
        .text-area { 
            text-align: center; 
        }   
        .text-area h1 { margin: 0; font-size: 20px; color: #81693b; text-transform: uppercase; }
        .text-area h2 { margin: 0; font-size: 16px; color: #81693b; }
        
        .info-encontro { 
            margin-top: 10px; 
            font-weight: bold; 
            color: #81693b; 
            font-size: 13px;
        }

        /* Rótulo da Equipe */
        .coordenador-label { 
            font-size: 22px; 
            font-weight: bold; 
            color: #81693b; 
            border: 1px solid #463414; 
            padding: 2px 10px; 
            display: inline-block; 
            margin-top: 5px; 
            text-transform: uppercase;
        }
        
        /* 3. GRID DOS MEMBROS (As linhas da convocação) */
        .membro-row { 
            border: 1px solid #81693b; 
            margin-bottom: -1px; /* Faz com que as bordas se sobreponham, evitando linha dupla */
            display: flex; 
            align-items: flex-start; 
            padding: 10px; 
        }

        /* Quadrado de Check "Aceitou" */
        .check-container { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            margin-right: 15px; 
            width: 55px; 
        }
        .label-aceitou { font-size: 9px; text-transform: uppercase; font-weight: bold; color: #81693b; }
        .square { width: 22px; height: 22px; border: 1px solid #81693b; margin-top: 2px; }

        .membro-info { flex: 1; }
        
        .membro-contato { 
            text-align: right; 
            font-size: 12px; 
            width: 250px; 
            color: #81693b; 
            line-height: 1.3;
        }

        /* 4. RODAPÉ FIXO */
        .footer-convocacao {
            position: absolute; 
            bottom: 15mm; 
            left: 15mm; 
            right: 15mm;
            display: flex; 
            justify-content: space-between; 
            font-size: 12px; 
            color: #81693b;
            border-top: 1px solid #ccc; 
            padding-top: 10px;
        }

        /* 5. REGRAS DE IMPRESSÃO */
        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }

        .no-print { 
            position: fixed; top: 10px; right: 10px; padding: 12px 25px; 
            background: #27ae60; color: white; border: none; cursor: pointer; 
            border-radius: 5px; font-weight: bold; z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR CONVOCAÇÃO</button>

    <div class="folha-a4">
        <header class="header-container">
            <div class="logo-area">
                <img src="../img/logo.png" alt="Logo ECC">
            </div>
            <div class="text-area">
                <h1>Diocese de Patos</h1>
                <h2>Paróquia São Francisco de Assis</h2>
                <div class="info-encontro">
                    <?php echo strtoupper($encontro['Encontro']); ?><br>
                    <?php echo $encontro['Periodo']; ?>
                </div>
                <div style="margin-top: 5px; color: #81693b">Equipe: <span class="coordenador-label"><?php echo strtoupper($equipe_nome); ?></span></div>
            </div>
        </header>

        <main>
            <?php foreach ($membros as $m): ?>
            <div class="membro-row">
                <div class="check-container">
                    <span class="label-aceitou">Aceitou</span>
                    <div class="square"></div>
                </div>

                <div class="membro-info">
                    <span style="font-weight: bold; color: #81693b; text-decoration: underline; font-style: italic;">
                        <?php echo $m['funcao']; ?>
                    </span><br>
                    <div style="margin-top: 5px; line-height: 1.3; color: #81693b">
                        <strong><?php echo strtoupper($m['Apelido_dele']); ?></strong> (<?php echo $m['Ele']; ?>)<br>
                        <strong><?php echo strtoupper($m['Apelido_dela']); ?></strong> (<?php echo $m['Ela']; ?>)
                    </div>
                </div>

                <div class="membro-contato">
                    <?php echo $m['End_Rua'] . ", " . $m['Numero'] . " - " . $m['Bairro']; ?><br>
                    Patos-PB | <strong><?php echo $m['Fone']; ?></strong>
                </div>
            </div>
            <?php endforeach; ?>
        </main>

        <footer class="footer-convocacao">
            <div style="width: 60%; color: #81693b">
                <strong>Obs.:</strong> Os membros não devem ter conhecimento dos outros integrantes até a 1ª reunião. Mantenha sigilo total.
            </div>
            <div style="width: 35%; text-align: right; color: #81693b">
                Confirmar dados: ________________<br>
                Fone: _________________________
            </div>
        </footer>
    </div>
</body>
</html>