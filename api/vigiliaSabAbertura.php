<?php
require_once 'db.php'; 
date_default_timezone_set('America/Fortaleza');

// Busca os dados do encontro mais recente para o cabeçalho da primeira página
try {
    $stmt = $pdo->query("SELECT encontro, tema, periodo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar dados do encontro: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Texto Há dois Amores - Impressão</title>
    <style>
        @page { size: A4; margin: 0; }
        
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #525659; 
            font-family: 'Inter', sans-serif; 
        }

        /* Estilo comum para as folhas */
        .folha-a4 {
            width: 210mm;
            height: 297mm;
            margin: 20px auto;
            background-color: white;
            background-size: contain;
            background-repeat: no-repeat;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            page-break-after: always;
        }

        /* PÁGINA 1: Imagem com texto */
        .pagina-1 {
            background-image: url('../img/vsab-aber-01.png'); 
        }

        /* PÁGINA 2: Outra imagem (ajuste o nome do arquivo abaixo) */
        .pagina-2 {
            background-image: url('../img/vsab-aber-02.png'); 
        }

        /* Cabeçalho dinâmico (apenas para a primeira página) */
        .header-dinamico {
            position: absolute;
            top: 105px; 
            width: 100%;
            text-align: center;
            color: #5f4b26;
        }

        .header-dinamico h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            color: #81693b;
        }

        .header-dinamico p {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
        }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; }
            .no-print { display: none; }
        }

        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR DOCUMENTO</button>

    <div class="folha-a4 pagina-1">
        <div class="header-dinamico">
            <h1><?php echo htmlspecialchars($encontro['encontro'] ?? 'ENCONTRO'); ?></h1>
            <p><?php echo htmlspecialchars($encontro['tema'] ?? ''); ?></p>
            <p style="font-weight: normal; font-size: 12px;">
                <?php echo htmlspecialchars($encontro['periodo'] ?? ''); ?>
            </p>
        </div>
    </div>

    <div class="folha-a4 pagina-2">
        </div>

</body>
</html>